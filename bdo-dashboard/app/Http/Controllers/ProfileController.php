<?php

namespace App\Http\Controllers;


use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    public function edit()
    {
        return view('bdo.profile');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'avatar_original' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:5000',

        ]);

        $distributor_id = Auth::user()->id;
        $distributor = User::find($distributor_id);
        if ($request->password != null){
            $distributor->password = Hash::make($request->password);
        }
        $distributor->name =$request->input('name');
        $distributor->address =$request->input('address');
        if ($request->hasFile('avatar_original')){
            if (file_exists($distributor->avatar_original)){
                unlink($distributor->avatar_original);
            }
            $file = $request->file('avatar_original');
            $path ='images/bdo';
            $file_name = time() . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $distributor->avatar_original= $path.'/'. $file_name;
        }
        try {
            $distributor->update();
            Toastr::success('message', 'BDO Profile Updated');
            return redirect()->route('bdo.dashboard');
        } catch (Exception $exception) {
            Toastr::error('message', 'Something went wrong');
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
        //
    }
}
