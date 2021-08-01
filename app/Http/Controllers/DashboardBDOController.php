<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class DashboardBDOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bdos = User::where('user_type','bdo')->orderBy('created_at', 'DESC')->get();
        return view('all_bdo.index', compact('bdos'));
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
    public function edit($id)
    {
        //
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
        //
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
            return redirect()->route('all-bdo.index');
        } catch (Exception $exception) {
            flash(__('Something went wrong'))->error();
            return redirect()->back();
        }
    }
}
