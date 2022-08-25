<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business\Bid;
use App\Models\BidComment;
use App\Models\BidCommentImage;
use App\Models\FavouriteBid;
use App\Models\IsReadBidComment;
use Illuminate\Support\Facades\DB;

class BidCommentController extends Controller
{
    public function index(Request $request)
    {
        $bid = Bid::where('id', $request->id)->first();
        $bidCmnts = BidComment::with('bid_comment_images')->where('bid_id', $request->id)->get();
        $is_read = DB::table('is_read_bid_comments')->where('bid_id', $request->id)->where('assign_to', auth()->user()->id)->where('is_read', 0)->update([
            'is_read' => 1
        ]);
        return view('business/bid/comments', compact('bid', 'bidCmnts'));
    }

    public function storeComments(Request $request)
    {
        $validatedData = $request->validate(
            [
                'products_uploaded' => 'required_without:comment',
                'products_uploaded.*' => 'mimes:jpg,bmp,png,webp,pdf|max:5120'
            ],
            [
                'products_uploaded.required_without' => 'Please provide text message or images',
                'products_uploaded.*.mimes' => 'Please upload file only in jpg, bmp, png, webp, or in pdf format.',
                'products_uploaded.*.max' => 'File size should not be greater than 5MB.'
            ]
        );
        $bidComment = [];
        if ($request->hasfile('products_uploaded')) {
            $removed_files = explode(',', $request->remove_products_ids);
            $total_files = $request->products_uploaded;
            foreach ($removed_files as $arr) {
                unset($total_files[$arr]);
            }
            if (sizeof($total_files) > 0) {
                $bidComment['user_id'] = auth()->user()->id;
                $bidComment['bid_id'] = $request->bid_id;
                $bidComment['comment'] = $request->comment;
            } else {
                $validatedData = $request->validate(
                    ['comment' => 'required'],
                    ['comment.required' => 'Please provide text message or images']
                );
            }
        } else {
            $bidComment['user_id'] = auth()->user()->id;
            $bidComment['bid_id'] = $request->bid_id;
            $bidComment['comment'] = $request->comment;
        }

        if (BidComment::create($bidComment)) {
            $bid_comment_id = BidComment::latest()->first();
            if ($request->hasfile('products_uploaded')) {
                $removed_files = explode(',', $request->remove_products_ids);
                $total_files = $request->products_uploaded;
                foreach ($removed_files as $arr) {
                    unset($total_files[$arr]);
                }
                if (sizeof($total_files) > 0) {
                    foreach ($total_files as $image) {
                        $name = time() . "-" . $image->getClientOriginalName() . '.' . $image->extension();
                        if ($image->move(public_path('uploads/business/bid-comments'), $name)) {
                            $data = new BidCommentImage;
                            $data->file_name = $name;
                            $data->bid_comment_id = $bid_comment_id->id;
                            $data->save();
                        }
                    }
                }
            }
            if ($bid_comment_id) {
                $bid = Bid::where('id', $bid_comment_id->bid_id)->first();
                if ($bid->user_id != auth()->user()->id) {
                    $isRead = new IsReadBidComment;
                    $isRead->bid_comment_id = $bid_comment_id->id;
                    $isRead->assign_to      = $bid->user_id;
                    $isRead->bid_id        = $bid_comment_id->bid_id;
                    $isRead->save();
                }
                $assign_to = FavouriteBid::where('bid_id', $bid_comment_id->bid_id)->pluck('user_id');
                if (!empty($assign_to)) {
                    foreach ($assign_to as $users) {
                        $isRead = new IsReadBidComment;
                        $isRead->bid_comment_id = $bid_comment_id->id;
                        $isRead->assign_to      = $users;
                        $isRead->bid_id        = $bid_comment_id->bid_id;
                        $isRead->save();
                    }
                    return response()->json(['status' => 'success', 'data' => $bid_comment_id, 'message' => 'Success! image(s) uploaded']);
                }
            }
            if ($bid_comment_id) {
                return response()->json(['status' => 'success', 'data' => $bid_comment_id, 'message' => 'Comment Created Successfully']);
            } else {
                return response()->json(['status' => 'failed', 'data' => $bid_comment_id, 'message' => 'Oops! Something went wrong']);
            }
        }
    }

    public function favouriteBids(Request $request)
    {
        $status = $request->status;
        if ($status == 1) {
            $favourite = FavouriteBid::create([
                'user_id' => auth()->user()->id,
                'bid_id'  => $request->bid_id,
            ]);
            return response()->json(['data' => $favourite, 200]);
        } else if ($status == 0) {
            $favourite = FavouriteBid::where('user_id', auth()->user()->id)->where('bid_id', $request->bid_id)->delete();
            return response()->json(['data' => $favourite, 200]);
        }
    }
}
