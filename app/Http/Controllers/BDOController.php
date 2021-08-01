<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Hash;

class BDOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bdos = User::where('user_type','bdo')->orderBy('created_at', 'DESC')->get();
        return view('bdo.index', compact('bdos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bdo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bdo = new User();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'phone' => 'required|digits:8|numeric|unique:users,phone',
        ]);
        $bdo->name =$request->input('name');
        $bdo->email =$request->input('email');
        $bdo->phone ='+973'.$request->input('phone');
        $bdo->address =$request->input('address');
        $bdo->user_type = 'bdo';
        $bdo->referral_code = 'BDO'.(rand(0000,9999));
        $bdo->password = Hash::make('12345678');

        try {
            $bdo->save();
            flash(__('BDO has been inserted successfully'))->success();
            return redirect()->route('bdo.index');
        } catch (Exception $exception) {
            flash(__('Something went wrong'))->error();
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bdo = User::findOrFail(decrypt($id));
        return view('bdo.edit', compact('bdo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bdo = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);
        $bdo->name =$request->input('name');
        $bdo->address =$request->input('address');

        try {
            $bdo->save();
            flash(__('BDO has been update successfully'))->success();
            return redirect()->route('bdo.index');
        } catch (Exception $exception) {
            flash(__('Something went wrong'))->error();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bdo = User::findOrFail($id);
        try {
            $bdo->destroy($bdo->id);
            flash(__('BDO has been deleted successfully'))->success();
            return redirect()->route('bdo.index');
        } catch (Exception $exception) {
            flash(__('Something went wrong'))->error();
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
