<?php

namespace App\Http\Controllers;

use App\ClubPointSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClubPointSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pointsettings = ClubPointSetting::orderBy('id', 'DESC')->get();
        return view('clubPointSettings.create', compact('pointsettings'));

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
        $validated = $request->validate([
            'point_per_doller' => 'required | regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'marchant'=> 'required | regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'distributor'=> 'required | regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'customer'=> 'required | regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'point_start'=> 'required',
            'point_end'=> 'required',
        ]);

        $totalpercent = ($request->marchant + $request->distributor + $request->customer);
        if($totalpercent != 100){
            flash(__('You Must set 100%. not up or down'))->error();
            return redirect()->back();
        }

        $pointsettings = new ClubPointSetting();
        $pointsettings->point_per_doller  = $request->point_per_doller;
        $pointsettings->marchant_point = $request->marchant;
        $pointsettings->distributor_point = $request->distributor;
        $pointsettings->customer_point = $request->customer;
        $pointsettings->start_date = $request->point_start;
        $pointsettings->end_date = $request->point_end;
        $pointsettings->save();

        flash(__('Your Point Setting successfully submitted'))->success();
        return $this->index();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClubPointSetting  $clubPointSetting
     * @return \Illuminate\Http\Response
     */
    public function show(ClubPointSetting $clubPointSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClubPointSetting  $clubPointSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(ClubPointSetting $clubPointSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClubPointSetting  $clubPointSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClubPointSetting $clubPointSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClubPointSetting  $clubPointSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClubPointSetting $clubPointSetting)
    {
        //
    }
}
