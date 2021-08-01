<?php

namespace App\Http\Controllers;

use App\BankInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Brian2694\Toastr\Facades\Toastr;


class BankInfoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $bankinfos = BankInfo::where('user_id', $user->id)->get();
        return view('frontend.bankinfo.index', compact('bankinfos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.bankinfo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'ac_holder' => 'required',
            'ac_no' => 'required | unique:bank_infos',
            'iban_number' => 'required | unique:bank_infos',
            'bank_name' => 'required',
            'status' => 'required',
            'routing_no' => 'nullable | integer',
            'address' => 'nullable | string',
        ]);

        if ($validator->passes()) {

            $bankInfo = new BankInfo;
            $bankInfo->user_id = Auth::user()->id;
            $bankInfo->ac_holder = $request->ac_holder;
            $bankInfo->ac_no = $request->ac_no;
            $bankInfo->iban_number = $request->iban_number;
            $bankInfo->bank_name = $request->bank_name;
            $bankInfo->address = $request->address;
            $bankInfo->routing_no = $request->routing_no;
            $bankInfo->status = $request->status;
            if($bankInfo->save()){
                flash('Bank Info Add Successfully')->success();
                return response()->json(['success'=>'Bank Info add Successfully.']);
            }
        }

        return response()->json(['error'=>$validator->errors()]);

        // $request->validate([
        //     'ac_holder' => 'required',
        //     'ac_no' => 'required | unique:bank_infos,ac_no',
        //     'iban_number' => 'required | unique:bank_infos,iban_number',
        //     'bank_name' => 'required',
        //     'status' => 'required'
        // ]);

        // $bankInfo = new BankInfo();
        // $bankInfo->user_id = Auth::user()->id;
        // $bankInfo->ac_holder = $request->ac_holder;
        // $bankInfo->ac_no = $request->ac_no;
        // $bankInfo->iban_number = $request->iban_number;
        // $bankInfo->bank_name = $request->bank_name;
        // $bankInfo->address = $request->address;
        // $bankInfo->routing_no = $request->routing_no;
        // $bankInfo->status = $request->status;

        // try {
        //     $bankInfo->save();
        //     flash('Bank Information has been add successfully')->success();
        //     return redirect()->route('bankinfo.index');
        // } catch (Exception $exception) {
        //     Toastr::error('message', 'Something went wrong');
        //     return redirect()->back();

        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankInfo  $bankInfo
     * @return \Illuminate\Http\Response
     */
    public function show(BankInfo $bankInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankInfo  $bankInfo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bankinfo = BankInfo::find($id);
        return view('frontend.bankinfo.edit', compact('bankinfo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankInfo  $bankInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ac_holder' => 'required',
            'ac_no' => 'required | unique:bank_infos,ac_no,'. $id,
            'iban_number' => 'required | unique:bank_infos,iban_number,' . $id,
            'bank_name' => 'required',
            'status' => 'required',
            'routing_no' => 'nullable | integer',
            'address' => 'nullable | string',
        ]);

        if ($validator->passes()) {

            $bankInfo = BankInfo::find($id);
            $bankInfo->ac_holder = $request->ac_holder;
            $bankInfo->ac_no = $request->ac_no;
            $bankInfo->iban_number = $request->iban_number;
            $bankInfo->bank_name = $request->bank_name;
            $bankInfo->address = $request->address;
            $bankInfo->routing_no = $request->routing_no;
            $bankInfo->status = $request->status;
            if($bankInfo->update()){
                flash('Bank Info Update Successfully')->success();
                return response()->json(['success'=>'Bank Info Update Successfully.', 'url'=> '/']);
            }
        }

        return response()->json(['error'=>$validator->errors()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankInfo  $bankInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bankinfo = BankInfo::findOrFail($id);
        try {
            $bankinfo->destroy($bankinfo->id);
            flash('Bank Info Delete Successfully')->success();
            return redirect()->route('bankinfo.index');
        } catch (Exception $exception) {
            flash('Something went wrong')->error();
            return redirect()->back();
        }
    }
}
