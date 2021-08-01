<?php

namespace App\Http\Controllers;

use App\ProfitPointSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfitPointSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clubPoint_profit_settings.create');
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
        return $request;

        $validator = Validator::make($request->all(), [
            'point_per_doller' => 'required',
            'marchant'=> 'required',
            'distributor'=> 'required',
            'customer'=> 'required',
            'point_start'=> 'required',
            'point_end'=> 'required',
            'marchant_profit'=> 'required',
            'distributor_profit'=> 'required',
            'customer_profit' => 'required',
            'bdo_profit'=> 'required',
            'profit_start'=> 'required',
            'profit_end'=> 'required',
        ]);

        if ($validator->passes()) {

            return 'success';
            $profitpoint = new ProfitPointSettingsController;
            $profitpoint->point_per_doller  = $request->point_per_doller;
            $profitpoint->marchant_point = $request->point_per_doller;
            $profitpoint->distributor_point = $request->point_per_doller;
            $profitpoint->customer_point = $request->point_per_doller;
            $profitpoint->point_start = $request->point_per_doller;
            $profitpoint->point_end = $request->point_per_doller;
            $profitpoint->marchant_profit = $request->point_per_doller;
            $profitpoint->distributor_profit = $request->point_per_doller;
            $profitpoint->customer_profit = $request->point_per_doller;
            $profitpoint->bdo_profit = $request->point_per_doller;
            $profitpoint->profit_start = $request->point_per_doller;
            $profitpoint->profit_end = $request->point_per_doller;

            // if($bankInfo->save()){
            //     flash('Bank Info Add Successfully')->success();
            //     return response()->json(['success'=>'Bank Info add Successfully.']);
            // }
        }

        return 'failed';

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProfitPointSettings  $profitPointSettings
     * @return \Illuminate\Http\Response
     */
    public function show(ProfitPointSettings $profitPointSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProfitPointSettings  $profitPointSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfitPointSettings $profitPointSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProfitPointSettings  $profitPointSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfitPointSettings $profitPointSettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProfitPointSettings  $profitPointSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfitPointSettings $profitPointSettings)
    {
        //
    }
}
