<?php

namespace App\Http\Controllers;

use App\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Carbon;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $withdraws = Withdraw::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
        return view('bdo.withdraw.index', compact('withdraws'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = Auth::user();
        $lastwithdraw = Withdraw::select('created_at')->where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();
        if(!$lastwithdraw > 0){
            $lastwithdraw = $user;
        }
        if($request->withdraw_amount > 0 && Carbon::now()->diffInDays($lastwithdraw->created_at) >= 30){
            $validator = Validator::make($request->all(), [
                // 'agree_term' => 'required'
            ]);

            if ($validator->passes()) {
                $withdraw = new Withdraw;
                $withdraw->user_id = Auth::user()->id;
                $withdraw->bank_info_id = $request->bank_info_id;
                $withdraw->withdraw_amount = $request->withdraw_amount;
                if($withdraw->save()){
                    Toastr::success('message', 'Your withdraw request has been successfully submitted.');
                    return response()->json(['success'=>'Your withdraw request has been successfully submitted.']);
                }
            }
            return response()->json(['error'=>$validator->errors()]);
        }
        Toastr::error('message', 'Sorry. Try again after next withdrawable date');
        return response()->json(['error'=> 'Sorry. Try again after next withdrawable date']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function show(withdraw $withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function edit(withdraw $withdraw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, withdraw $withdraw)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $withdraw = Withdraw::findOrFail($id);
        try {
            $withdraw->destroy($withdraw->id);
            Toastr::warning('message', 'Distributor Delete Successfully');
            return redirect()->route('withdraw.index');
        } catch (Exception $exception) {
            Toastr::error('message', 'Something went wrong');
            return redirect()->back();
        }
    }
}
