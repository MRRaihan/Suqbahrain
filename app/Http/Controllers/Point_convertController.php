<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Carbon;
use Brian2694\Toastr\Facades\Toastr;


class Point_convertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $depositPoint = DB::table('deposits')->where('user_id', $user->id)->sum('deposit_club_point');

        if($depositPoint >= 10000){

            if(!$user->is_merchant == 1){

                //for normal customer
                $user->balance = $user->balance + ($depositPoint * (1/10000));
                $user->update();

                $wallet = new Wallet;
                $wallet->user_id = $user->id;
                $wallet->amount = $depositPoint * (1/10000);
                $wallet->payment_method = 'Club Point Convert';
                $wallet->payment_details = 'Club Point Convert';
                $wallet->approval = 1;
                $wallet->save();

                $convertpoint = new Deposit;
                $convertpoint->user_id = $user->id;
                $convertpoint->deposit_club_point = $depositPoint * (-1);
                if( $convertpoint->save() ){
                    flash('Your points successfully Converted into BDH')->success();
                    return redirect()->back();
                }
            } else {

                //for Merchent
                $convertpoint = new Deposit;
                $convertpoint->user_id = $user->id;
                $convertpoint->deposit_amount = $depositPoint * (1/10000);
                $convertpoint->deposit_club_point = $depositPoint * (-1);
                if( $convertpoint->save() ){
                    flash('Your points successfully Converted into BDH')->success();
                    return redirect()->back();
                }
            }
        }
        flash('You can Convert your point after earn 10,000 points')->error();
        return redirect()->back();
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



    }

    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
