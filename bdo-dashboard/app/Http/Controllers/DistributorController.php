<?php

namespace App\Http\Controllers;

use App\Distributor;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bdo = User::find(Auth::user()->id);
        $distributors = $bdo->distributors;
        return view('bdo.distributor.index', compact('distributors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bdo.distributor.create');
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
            'phone' => 'required|digits:8|numeric|unique:users,phone',
        ]);

        $distributor = new User();
        $distributor->referred_by = Auth::user()->referral_code;
        $distributor->bdo_id = Auth::user()->id;
        $distributor->name =$request->input('name');
        $distributor->email =$request->input('email');
        $distributor->phone ='+973'.$request->input('phone');
        $distributor->address =$request->input('address');
        $distributor->user_type = 'distributor';
        $distributor->referral_code = 'DIS'.(rand(0000,9999));
        $distributor->is_distributor = 1 ;
        $distributor->password = Hash::make('12345678');

        try {
            $distributor->save();
            Toastr::success('message', 'Distributor Create Successfully');
            return redirect()->route('distributor.index');
        } catch (Exception $exception) {
            Toastr::error('message', 'Something went wrong');
            return redirect()->back();

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Distributor  $distributor
     * @return \Illuminate\Http\Response
     */
    public function show(Distributor $distributor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Distributor  $distributor
     * @return \Illuminate\Http\Response
     */
    public function edit(Distributor $distributor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Distributor  $distributor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Distributor $distributor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Distributor  $distributor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $distributor = User::findOrFail($id);
        try {
            $distributor->destroy($distributor->id);
            Toastr::warning('message', 'Distributor Delete Successfully');
            return redirect()->route('distributor.index');
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
