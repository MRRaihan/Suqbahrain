<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllMembersController extends Controller
{
    public function bdo_report(){
        $bdos = DB::table('users')->where('user_type', 'bdo')->where('status', 1)->orderBy('created_at', 'DESC')->get();
        return view('reports.all_bdo_report', compact('bdos'));
    }

    public function distributor_report($id){
        $bdo = User::findOrFail(decrypt($id));
        $distributors = DB::table('users')->where('referred_by', $bdo->referral_code)->where('bdo_id', $bdo->id)->where('user_type', 'distributor')->where('status', 1)->where('is_distributor', 1)->orderBy('created_at', 'DESC')->get();
        return view('reports.all_distributor_report', compact('distributors'));
    }

    public function merchant_report($id){
        $distributor = User::findOrFail(decrypt($id));
        $merchants = DB::table('users')->where('referred_by', $distributor->referral_code)->where('distributor_id', $distributor->id)->where('user_type', 'customer')->where('status', 1)->where('is_merchant', 1)->orderBy('created_at', 'DESC')->get();
        return view('reports.all_merchant_report', compact('merchants'));

    }
    public function customer_report($id){
        $merchant = User::findOrFail(decrypt($id));
        $customers = DB::table('users')->where('referred_by', $merchant->referral_code)->where('user_type', 'customer')->where('status', 1)->where('is_merchant', 0)->orderBy('created_at', 'DESC')->get();
        return view('reports.all_customer_report', compact('customers'));
    }

}
