<?php

namespace App\Http\Controllers;

use App\BankInfo;
use App\OrderDetail;
use App\User;
use App\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function login(){
        return view('bdo.login');
    }
    public function dashboard(){

        $user = Auth::user();
        //total distributors of BDO
        $total_distributor = User::where('bdo_id', $user->id)->where('referred_by', $user->referral_code)->where('user_type', 'distributor')->count();
        $distributors = User::where('bdo_id', $user->id)->where('referred_by', $user->referral_code)->where('user_type', 'distributor')->get();

        $bdo_profit = 0;
        $bdo_today_profit = 0;
        foreach ($distributors as $distributor){
            $merchants = User::where('distributor_id', $distributor->id)->where('referred_by', $distributor->referral_code)->where('user_type', 'customer')->where('is_merchant', 1)->get();
            foreach ($merchants as $merchant){

                $result = DB::table('order_details')->where('user_id', $merchant->id)->sum('profit');
                $bdo_profit += $result * (2.5/100);
                $today_result = DB::table('order_details')->where('user_id', $merchant->id)
                    ->whereDate('created_at',Carbon::today())->sum('profit');
                $bdo_today_profit += $today_result * (2.5/100);

            }
        }

        //bdo bank info
        $bankinfo = BankInfo::select('id', 'ac_holder', 'ac_no', 'bank_name', 'iban_number')->where('user_id', $user->id)->where('status', 'primary')->first();
        if($bankinfo == null) {
            $bankinfo = BankInfo::select('id', 'ac_holder', 'ac_no', 'bank_name', 'iban_number')->where('user_id', $user->id)->where('status', 'secondary')->first();
        }
        //Last Withdraw avialble date.
        $lastwithdraw = Withdraw::select('created_at')->where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();
        if(!$lastwithdraw > 0){
            $lastwithdraw = $user;
        }
        //total deposite Profit amount
        $depositProfit = DB::table('deposits')->where('user_id', $user->id)->sum('deposit_amount');

        //Available profit amount
        $withdrawamount = DB::table('withdraws')->where('user_id', $user->id)->sum('withdraw_amount');
        $availbleProfit = $depositProfit-$withdrawamount;

        return view('bdo.dashboard', compact('bdo_today_profit','total_distributor', 'availbleProfit', 'bankinfo', 'withdrawamount', 'lastwithdraw'));
    }
}