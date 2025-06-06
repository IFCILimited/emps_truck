<?php

namespace App\Http\Controllers\Admin\FlowChart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class OemDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $oemCount = DB::table('oem_details_count_chart_vw')->first();

        $oemData = DB::table('oem_details_chart_vw')->get();

        $oemPostCount = DB::table('oem_details_post_reg_count_chart_vw')->first();

        $oemPostChart = DB::table('oem_details_post_reg_chart_vw')->get();

        $oemChart = $oemData->map(function($item) {     return [
            'id' => encrypt($item->id),
            'name' => $item->name,
            'email' => $item->email,
            'auth_name' => $item->auth_name,
            'auth_designation' => $item->auth_designation,
            'status' => $item->status
        ]; });

        // dd($oemChart,$oemData);

        // dd($oemPostChart);

        return view('admin.flow_chart.oem_details_index',compact('oemCount','oemChart','oemPostCount','oemPostChart'));
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
        //
    }
}
