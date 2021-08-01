<?php

namespace App\Http\Controllers;

use App\Merchant;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $distributor =User::find(Auth::user()->id);
        $merchants = $distributor->merchants;
        return view('distributor.merchant.index', compact('merchants'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('distributor.merchant.create');
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'phone' => 'required|min:9|numeric',
        ]);
        
        $merchant = new User();
        $merchant->referred_by = Auth::user()->referral_code;
        $merchant->distributor_id = Auth::user()->id;
        $merchant->name =$request->input('name');
        $merchant->email =$request->input('email');
        $merchant->phone ='+973'.$request->input('phone');
        $merchant->address =$request->input('address');
        $merchant->user_type = 'customer';
        $merchant->referral_code = 'MER'.(rand(0000,9999));
        $merchant->is_merchant = 1 ;
        $merchant->password = Hash::make('12345678');
        
        try {
            $merchant->save();
            Toastr::success('message', 'Merchant Create Successfully');
            return redirect()->route('merchant.index');
        } catch (Exception $exception) {
            Toastr::error('message', 'Something went wrong');
            return redirect()->back();

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function show(Merchant $merchant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*$merchant = User::findOrFail(decrypt($id));
        return view('distributor.merchant.edit', compact('merchant'));*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*$request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:distributors,email',
            'address' => 'required',
            'phone' => 'required|min:11|numeric',
        ]);
        $merchant = User::findOrFail($id);
        if ($request->password != null){
            $merchant->password = Hash::make($request->password);
        }
        $merchant->name =$request->input('name');
        $merchant->email =$request->input('email');
        $merchant->phone =$request->input('phone');
        $merchant->address =$request->input('address');
        try {
            $merchant->save();
            Toastr::success('message', 'Merchant Update Successfully');
            return redirect()->route('merchant.index');
        } catch (Exception $exception) {
            Toastr::error('message', 'Something went wrong');
            return redirect()->back();
        }*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $merchant = User::findOrFail($id);
        try {
            $merchant->destroy($merchant->id);
            Toastr::warning('message', 'Merchant Delete Successfully');
            return redirect()->route('merchant.index');
        } catch (Exception $exception) {
            Toastr::error('message', 'Something went wrong');
            return redirect()->back();
        }
    }
    
    public function changeStatus(Request $request)
    {
        $merchant = User::find($request->user_id);
        $merchant->status = $request->status;
        $merchant->save();

        return response()->json(['success'=>'Status change successfully.', 'error' => false]);
    }
    
}
