<?php

namespace App\Http\Controllers;

use App\OrderDetail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\BankInfo;
use App\Withdraw;

class DashboardController extends Controller
{
    public function login(){
        return view('distributor.login');
    }
    public function dashboard(){


        $user = Auth::user();
        $total_merchant = User::where('distributor_id', $user->id)->where('referred_by', $user->referral_code)->where('user_type', 'customer')->where('is_merchant', 1)->count();
        $merchant_today = User::where('distributor_id', $user->id)->where('referred_by', $user->referral_code)->where('user_type', 'customer')->where('is_merchant', 1)->whereDate('created_at',Carbon::today())->count();

        $merchants = User::where('distributor_id', $user->id)->where('referred_by', $user->referral_code)->where('user_type', 'customer')->where('is_merchant', 1)->get();
        $distributor_today_profit = 0;

        foreach ($merchants as $merchant){

            $today_result = DB::table('order_details')->where('user_id', $merchant->id)
                ->whereDate('created_at',Carbon::today())->sum('profit');
            $distributor_today_profit += $today_result * (10/100);

        }


        //distributor bank info
        $bankinfo = BankInfo::select('id', 'ac_holder', 'ac_no', 'bank_name', 'iban_number')->where('user_id', $user->id)->where('status', 'primary')->first();
        if($bankinfo== null){
            $bankinfo = BankInfo::select('id', 'ac_holder', 'ac_no', 'bank_name', 'iban_number')->where('user_id', $user->id)->where('status', 'secondary')->first();
        }
        //Last Withdraw avialble date.
        $lastwithdraw = Withdraw::select('created_at')->where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();
        if(!$lastwithdraw > 0){
            $lastwithdraw = $user;
        }
        //total deposite Profit amount
        $depositProfit = DB::table('deposits')->where('user_id', $user->id)->sum('deposit_amount');
        //Total earn points
        $depositPoint = DB::table('deposits')->where('user_id', $user->id)->sum('deposit_club_point');
        //Available profit amount
        $withdrawamount = DB::table('withdraws')->where('user_id', $user->id)->sum('withdraw_amount');

        $availbleProfit = $depositProfit-$withdrawamount;

        return view('distributor.dashboard', compact('total_merchant', 'distributor_today_profit', 'merchant_today', 'availbleProfit', 'depositPoint', 'bankinfo', 'withdrawamount', 'lastwithdraw'));
    }
}
