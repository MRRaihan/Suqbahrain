<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Str;
use App\Distributor;
use Illuminate\Http\Request;
use Hash;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $distributors = User::where('user_type','distributor')->orderBy('created_at', 'DESC')->get();
        return view('distributor.index', compact('distributors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('distributor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $distributor = new User();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'phone' => 'required|digits:8|numeric|unique:users,phone',
        ]);
        $distributor->name =$request->input('name');
        $distributor->email =$request->input('email');
        $distributor->phone ='+973'.$request->input('phone');
        $distributor->address =$request->input('address');
        $distributor->user_type = 'distributor';
        $distributor->referral_code =Str::random(4).rand(0000,9999);
        $distributor->password = Hash::make('12345678');
        try {
            $distributor->save();
            flash(__('Distributor has been inserted successfully'))->success();
            return redirect()->route('distributor.index');
        } catch (Exception $exception) {
            flash(__('Something went wrong'))->error();
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
    public function edit($id)
    {
        $distributor = User::findOrFail(decrypt($id));
        return view('distributor.edit', compact('distributor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Distributor  $distributor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $distributor = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            
        ]);
        $distributor->name =$request->input('name');
        $distributor->address =$request->input('address');

        try {
            $distributor->save();
            flash(__('Distributor has been update successfully'))->success();
            return redirect()->route('distributor.index');
        } catch (Exception $exception) {
            flash(__('Something went wrong'))->error();
            return redirect()->back();
        }
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
            flash(__('Distributor has been deleted successfully'))->success();
            return redirect()->route('distributor.index');
        } catch (Exception $exception) {
            flash(__('Something went wrong'))->error();
            return redirect()->back();
        }
    }
}
