<?php

namespace App\Http\Controllers;

use App\BankInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('distributor.bankinfo.index', compact('bankinfos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('distributor.bankinfo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'ac_holder' => 'required',
            'ac_no' => 'required | unique:bank_infos,ac_no',
            'iban_number' => 'required | unique:bank_infos,iban_number',
            'bank_name' => 'required',
            'status' => 'required',
            'routing_no' => 'nullable|integer',
            'address' => 'nullable|string',

        ]);

        $bankInfo = new BankInfo();
        $bankInfo->user_id = Auth::user()->id;
        $bankInfo->ac_holder = $request->ac_holder;
        $bankInfo->ac_no = $request->ac_no;
        $bankInfo->iban_number = $request->iban_number;
        $bankInfo->bank_name = $request->bank_name;
        $bankInfo->address = $request->address;
        $bankInfo->routing_no = $request->routing_no;
        $bankInfo->status = $request->status;

        try {
            $bankInfo->save();
            Toastr::success('message', 'Bank Info Added Successfully');
            return redirect()->route('bankinfo.index');
        } catch (Exception $exception) {
            Toastr::error('message', 'Something went wrong');
            return redirect()->back();

        }
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
        return view('distributor.bankinfo.edit', compact('bankinfo'));
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
        $request->validate([
            'ac_holder' => 'required',
            'ac_no' => 'required | unique:bank_infos,ac_no,'. $id,
            'iban_number' => 'required | unique:bank_infos,iban_number,' . $id,
            'bank_name' => 'required',
            'status' => 'required',
            'routing_no' => 'nullable|integer',
            'address' => 'nullable|string',
        ]);

        $bankInfo = BankInfo::find($id);
        $bankInfo->user_id = Auth::user()->id;
        $bankInfo->ac_holder = $request->ac_holder;
        $bankInfo->ac_no = $request->ac_no;
        $bankInfo->iban_number = $request->iban_number;
        $bankInfo->bank_name = $request->bank_name;
        $bankInfo->address = $request->address;
        $bankInfo->routing_no = $request->routing_no;
        $bankInfo->status = $request->status;

        try {
            $bankInfo->update();
            Toastr::success('message', 'Bank Info Update Successfully');
            return redirect()->route('bankinfo.index');
        } catch (Exception $exception) {
            Toastr::error('message', 'Something went wrong');
            return redirect()->back();

        }
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
            Toastr::warning('message', 'Bank Info Delete Successfully');
            return redirect()->route('bankinfo.index');
        } catch (Exception $exception) {
            Toastr::error('message', 'Something went wrong');
            return redirect()->back();
        }
    }
}
