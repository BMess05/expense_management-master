<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssuedDocument;

class IssuedDocumentController extends Controller
{
    public function fetchdocuments(Request $request){
        
        $documents = IssuedDocument::where('employee_id',$request->employee_id)->orderBy('id', 'DESC')->get();
        return view('issued-documents.index',compact('documents'))->render();
    }

    public function createdocuments(Request $request){
        $validatedData = $request->validate(
            [
                'document' => 'mimes:jpg,jpeg,bmp,ico,png,webp,docx,doc,pdf,xml,ppt,xls|max:5120'
            ],
        );
        $input = $request->all();
        $document_pic = '';
        if (isset($input['document']) && !is_null($input['document'])) {
            $folderPath = public_path('uploads/issued-documents/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $document_pic = time() . "-" . $request->document->getClientOriginalName() . '.' . $request->document->extension();
            $request->document->move($folderPath, $document_pic);
        }
        $data = IssuedDocument::create([
            'employee_id'  => $input['employee_id'],
            'doc_name'     => $input['doc_name'],
            'issued_date'  => $input['issued_date'],
            'document'     => $document_pic,
        ]);
        if($data){
        return response()->json(['data' => $data ,200]);
        }
    }

    public function deletedocuments(Request $request){
        $data = IssuedDocument::find($request->id)->delete();
        return response()->json(['data' => $data ,200]);
    }

    public function editdocuments(Request $request){
        $document = IssuedDocument::where('id',$request->id)->first();
        return view('issued-documents.update',compact('document'));
    }

    public function updatedocuments(Request $request){
        $validatedData = $request->validate(
            [
                'document' => 'mimes:jpg,jpeg,bmp,ico,png,webp,docx,doc,pdf,xml,ppt,xls|max:5120'
            ],
        );
        $input = $request->all();
        $document_pic = '';
        if (isset($input['document']) && !is_null($input['document'])) {
            $folderPath = public_path('uploads/issued-documents/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $document_pic = time() . "-" . $request->document->getClientOriginalName() . '.' . $request->document->extension();
            $request->document->move($folderPath, $document_pic);
        }
        $data = IssuedDocument::where('id',$request->id)->first();
            $data->doc_name     = $request->doc_name;
            $data->issued_date  = $request->issued_date;
            if($request->hasFile('document')){
                $data->document = $document_pic;
            }
            if($data->save()){
        return response()->json(['data' => $data ,200]);
        }
    }
}
