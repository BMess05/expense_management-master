<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business\Bid;
use App\Models\Business\BidProfile;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DateTime;
use DateTimeZone;
use DateInterval;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Business\BusinessSettingsColors;
use App\Models\FavouriteBid;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bid-list|bid-create|bid-edit|bid-delete', ['only' => ['index', 'save']]);
        $this->middleware('permission:bid-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:bid-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:bid-delete', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {


        $data = $request->all();

        // echo "<pre>";print_r($data);die;
        $userTimezone = new DateTimeZone('Asia/Kolkata');
        $gmtTimezone = new DateTimeZone('GMT');

        $first_day = new DateTime('first day of this month', $gmtTimezone);
        $offset = $userTimezone->getOffset($first_day);
        $first_day_interval = DateInterval::createFromDateString((string)$offset . 'seconds');
        $first_day->add($first_day_interval);

        $last_day = new DateTime('last day of this month', $gmtTimezone);
        $offset = $userTimezone->getOffset($last_day);
        $last_day_interval = DateInterval::createFromDateString((string)$offset . 'seconds');
        $last_day->add($last_day_interval);

        $userid = auth()->user()->id;
        $users = User::where('id', '!=', 1)->where('id', '!=', $userid)->orderBy('id', 'DESC')->get();
        $bid = Bid::query();
        $otherbids = Bid::query();
        $business_color_setting = BusinessSettingsColors::all()->toArray();


        if (isset($data['user_id'])) {
            $otherbids = $otherbids->where('user_id', $data['user_id']);
        }
        if (isset($data['tab_value'])) {
            $request->session()->flash('tab', $data['tab_value']);
        }
        if (isset($data['filter_bid_status'])) {

            $bid = $bid->where('bid_status', $data['filter_bid_status']);
            $otherbids = $otherbids->where('bid_status', $data['filter_bid_status']);
        }
        if (isset($data['from_date']) && isset($data['to_date'])) {

            $from_date = \Carbon\Carbon::parse($data['from_date'])->format('Y-m-d 00:00:00');
            $to_date = \Carbon\Carbon::parse($data['to_date'])->format('Y-m-d 23:59:00');
            $bid = $bid->whereBetween('created_at', [$from_date, $to_date]);
            $otherbids = $otherbids->whereBetween('created_at', [$from_date, $to_date]);
        } else {

            $from_date = $first_day->format('Y-m-d 00:00:00');
            $to_date = $last_day->format('Y-m-d 23:59:00');
            $bid = $bid->whereBetween('created_at', [$from_date, $to_date]);
            $otherbids = $otherbids->whereBetween('created_at', [$from_date, $to_date]);
            $data['from_date'] = $first_day->format('d-m-Y');
            $data['to_date'] = $last_day->format('d-m-Y');
        }
        //         if (isset($data['job_id'])) {
        //             $otherbids=$otherbids->Where('bid_url', 'like', '%' . $data['job_id'] . '%');
        //             $bid=$bid->Where('bid_url', 'like', '%' . $data['job_id'] . '%');
        //         }
        if (isset($data['job_id'])) {
            $otherbids = $otherbids->Where('job_id', $data['job_id']);
            $bid = $bid->Where('job_id', $data['job_id']);
        }
        $favourite_bids = FavouriteBid::where('user_id', $userid)->pluck('bid_id');

        $mybids = $bid->with(['bidprofile', 'biduser'])->where('user_id', $userid)->orWhereIn('id', $favourite_bids)->orderBy('id', 'DESC')->get();

        // echo count($mybids);
        $otherbids = $otherbids->with(['bidprofile', 'biduser'])->where('user_id', '!=', 1)->where('user_id', '!=', $userid)->whereNotIn('id', $favourite_bids)->orderBy('id', 'DESC')->get();
        if ((isset($data['job_id']) && !empty($data['job_id'])) && count($otherbids) > 0) {
            $request->session()->flash('tab', 'otherbids');
        } else {
            $request->session()->flash('tab', 'mybids');
        }


        \Auth::user()->reset = '';
        if (isset($data['reset'])) {
            \Auth::user()->reset = 'true';
        }
        // echo "<pre>";print_r($otherbids);print_r($mybids);die;
        return view('business.bid.index', compact('mybids', 'otherbids', 'data', 'users', 'business_color_setting'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bids = BidProfile::pluck('name', 'id');
        return view('business.bid.create', compact('bids'));
    }
    public function bidStatus(Request $request)
    {
        $data = $request->all();
        if (Bid::where('id', $data['id'])->update(['bid_status' => $data['bid_status']])) {
            $request->session()->flash('message', 'Bid status updated successfully');
            $request->session()->flash('success', 'success');
            $request->session()->flash('tab', $data['bid_page']);

            $response = ['success' => true, 'message' => 'Bid status updated successfully'];
        } else {
            $request->session()->flash('message', 'Something went wrong');
            $request->session()->flash('success', 'danger');
            $response = ['success' => false, 'message' => 'Something went wrong'];
        }
        return response()->json($response);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $this->validate($request, [
            'bid_id' => 'required',
            'bid_url' => 'required',
            'job_id' => 'required|unique:bids,job_id'
        ]);
        $data['user_id'] = auth()->user()->id;
        // dd($data);
        $bid = Bid::create($data);
        if ($bid->exists) {
            $this->send_notification_of_bid($data);
            return redirect()->route('bids.index')->with(['success' => 'success', 'message' => 'Bid added successfully']);
        } else {
            return redirect()->route('bids.index')->with(['success' => 'danger', 'message' => 'Something went wrong']);
        }
    }
    function CheckBidUrl(Request $request)
    {

        if ($request->input('bid_url') !== '') {
            $id = $request->input('id');
            if ($request->input('bid_url')) {

                $rule = array('bid_url' => 'Required|unique:bids,bid_url,' . $id);
                $validator = Validator::make($request->all(), $rule);
            }
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');
    }
    function send_notification_of_bid($data)
    {

        $url =  env("SEND_BID_URL");
        $name = auth()->user()->name;
        $profile_id = BidProfile::where('id', $data['bid_id'])->value('name');
        $response = Http::post($url, [
            'text' => $data['bid_url'] . ' / [' . $profile_id . ']
Done By: ' . $name . ''

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $bid = Bid::find($id);
        $bids = BidProfile::pluck('name', 'id');
        $userbid = $bid->bidprofile->pluck('name', 'id')->all();
        //dd($userbid);
        return view('business.bid.edit', compact('bid', 'bids', 'userbid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'bid_id' => 'required',
            'bid_url' => 'required',
            'job_id' => 'required|unique:bids,job_id,' . $id
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $bid = Bid::find($id);
        $bid->fill($data)->save();

        return redirect()->route('bids.index')->with(['success' => 'success', 'message' => 'Bid updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $bid = Bid::find($id);
        $bid->delete();

        return redirect()->route('bids.index')->with(['success' => 'success', 'message' => 'Bid deleted successfully']);
    }
}
