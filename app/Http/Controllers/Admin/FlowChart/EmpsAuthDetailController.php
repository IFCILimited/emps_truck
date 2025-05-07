<?php

namespace App\Http\Controllers\Admin\FlowChart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class EmpsAuthDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->has('oem_id') ||  $request->has('segment_id') ) {
            // dd("hey");
            $data = DB::table('emps_buyer_auth as eba')
            ->join('users as u', 'eba.oem_id', '=', 'u.id');

            if(  !is_null($request->query('oem_id')) && $request->query('oem_id') != 'All' ) {
                $data = $data->where('u.id', (int)$request->query('oem_id'));
            }

            if( !is_null($request->query('segment_id')) && $request->query('segment_id') != 'All' ) {
                $data = $data->where('segment_name', $request->query('segment_id'));
            }

            $data = $data->select(
                'u.id',
                'u.name',
                'eba.segment_name',
                'eba.vehicle_cat',
                DB::raw('COUNT(buyer_id) AS buyer_id_generated'),
                DB::raw('COUNT(pmedrive_evoucher_copy_id) AS evoucher_generated'),
                DB::raw("SUM(CASE WHEN pmedrive_adh_verify = 'Y' THEN 1 ELSE 0 END) AS adh_verify_y_count"),
                DB::raw('SUM(CASE WHEN buyer_id IS NULL THEN 1 ELSE 0 END) AS buyer_id_null_count'),
                DB::raw('SUM(CASE WHEN pmedrive_evoucher_copy_id IS NULL THEN 1 ELSE 0 END) AS evoucher_null_count'),
                DB::raw("SUM(CASE WHEN pmedrive_adh_verify = 'N' THEN 1 ELSE 0 END) AS adh_verify_null_count")
            )
            ->groupBy('u.id', 'u.name', 'eba.segment_name', 'eba.vehicle_cat')
            ->get();

            // dd($data);

            $oemDetails = DB::table('users')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.role_id', 4)
                    ->where('parent_id', null)
                    ->where('isactive', 'Y')
                    ->where('isapproved', 'Y')
                    ->select('users.*', 'model_has_roles.role_id')
                    ->get();

            $segMaster = DB::table('segment_master')->get();
            return view('admin.flow_chart.emps_auth_details_index', compact('oemDetails','segMaster','data'));

        }


        $data = DB::table('emps_buyer_auth as eba')
    ->join('users as u', 'eba.oem_id', '=', 'u.id')
    ->select(
        'u.id',
        'u.name',
        'eba.segment_name',
        'eba.vehicle_cat',
        DB::raw('COUNT(buyer_id) AS buyer_id_generated'),
        DB::raw('COUNT(pmedrive_evoucher_copy_id) AS evoucher_generated'),
        DB::raw("SUM(CASE WHEN pmedrive_adh_verify = 'Y' THEN 1 ELSE 0 END) AS adh_verify_y_count"),
        DB::raw('SUM(CASE WHEN buyer_id IS NULL THEN 1 ELSE 0 END) AS buyer_id_null_count'),
        DB::raw('SUM(CASE WHEN pmedrive_evoucher_copy_id IS NULL THEN 1 ELSE 0 END) AS evoucher_null_count'),
        DB::raw("SUM(CASE WHEN pmedrive_adh_verify = 'N' THEN 1 ELSE 0 END) AS adh_verify_null_count")
    )
    ->groupBy('u.id', 'u.name', 'eba.segment_name', 'eba.vehicle_cat')
    ->get();



        $oemDetails = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->where('model_has_roles.role_id', 4)
        ->where('parent_id', null)
        ->where('isactive', 'Y')
        ->where('isapproved', 'Y')
        ->select('users.*', 'model_has_roles.role_id')
        ->get();
        // dd($oemDetails);
        // dd($oemDetails[0]->name);

        $segMaster = DB::table('segment_master')->get();


        return view('admin.flow_chart.emps_auth_details_index', compact('oemDetails','segMaster','data'));
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

    public function search($oem,$segm) {

        ini_set('memory_limit', '8048M');
        ini_set('max_execution_time', 8600);

        // dd($oem, $segm);

    //     $seg = DB::table('segment_master')->where('id',$segm)->first('segment_name');
    //     // dd($seg->segment_name);
    //     if(Auth::user()->hasRole('PMA')) {
    //     $claimMaster = DB::table('claim_master_view')->whereNotNull('lot_id')->whereNotNull('pma_process_at')->wherenull('pma_claim_submitted_at')->where('oem_id',$oem)->where('segment_name',$seg->segment_name)->get();
    //     }
    //     elseif(Auth::user()->hasRole('MHI-AS|MHI-DS')) {
    //         $claimMaster = DB::table('claim_master_view')->whereNotNull('lot_id')->whereNotNull('pma_process_at')->whereNotNull('pma_claim_submitted_at')->wherenull('mhi_claim_submitted_at')->where('oem_id',$oem)->where('segment_name',$seg->segment_name)->get();
    //         // dd($claimMaster);
    //         }
    //     // dd($claimMaster);
    // $oemDetails = DB::table('oem_ev_summary')->get();
    // $segMaster = DB::table('segment_master')->pluck('segment_name', 'id','segMaster');


    $oemDetails = DB::table('users')->where('id', $oem)->first();
    dd($oemDetails[0]->name);
    $segMaster = DB::table('segment_master')->where('id', $segm)->first();

    // $oemDetails = $oemName->name;
    // $segMaster =  $segmentName->segment_name;


    return view('admin.flow_chart.emps_auth_details_index',compact('claimMaster','oemDetails','segMaster'));
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
