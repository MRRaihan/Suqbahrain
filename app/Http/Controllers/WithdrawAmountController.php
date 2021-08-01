<?php

namespace App\Http\Controllers;

use App\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Toastr;


class WithdrawAmountController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        // return $user;
        $withdraws = Withdraw::orderBy('id', 'DESC')->where('user_id', $user->id)->get();
        return view('frontend.withdraw.index', compact('withdraws'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        if($lastwithdraw == null){
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
                    flash('Your withdraw request has been successfully submitted.')->success();
                    return response()->json(['success'=>'Your withdraw request has been successfully submitted.']);
                }
            }
            return response()->json(['error'=>$validator->errors()]);
        }
        flash('Sorry. Try again after next withdrawable date')->error();
        return response()->json(['error'=> 'Sorry. Try again after next withdrawable date']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function show(Withdraw $withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function edit(Withdraw $withdraw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $withdraw = Withdraw::findOrFail($id);
        if($request->status == 'pending'){
            $withdraw->status = 'accepted';
            $withdraw->update();
            return redirect()->back();
        } elseif($request->status == 'accepted'){
            $withdraw->status = 'completed';
            $withdraw->update();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $withdraw = Withdraw::findOrFail($id);
        try {
            $withdraw->destroy($withdraw->id);
            flash('Withdraw request has been delete successfully')->warning();
            return redirect()->route('withdraw_amount.index');
        } catch (Exception $exception) {
            flash('Something went wrong')->error();
            return redirect()->back();
        }
    }
}
