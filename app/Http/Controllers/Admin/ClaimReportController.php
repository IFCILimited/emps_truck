<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;


class ClaimReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->where('model_has_roles.role_id', 4)
        ->where('parent_id', null)
        ->where('isactive', 'Y')
        ->where('isapproved', 'Y')
        ->select('users.*', 'model_has_roles.role_id')
        ->get();

        $claimReport = DB::table('claim_report_vw')->first();

        $segment = DB::table('segment_master')->get();

        $oem_id = null;

        return view('admin.claim_report_index', compact('claimReport','users','oem_id','segment'));
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

    public function fetchClaimDetails(Request $request)
    {

        try {
            // DB::transaction(function() use($request) {
                $query = DB::table('claim_report_oem_vw');
                if( isset($request->oem_id) && $request->oem_id != 'all') {
                    $query = $query->where('oem_id', $request->oem_id);
                }
                if(isset($request->seg_id) && $request->seg_id != 'all') {
                    $query = $query->where('segment_id', $request->seg_id);
                }

                $data = $query->get();

                return response()->json([
                    'success' => true,
                    'data' => $data
                ]);

            // });
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => [
                    'msg' => $e->getMessage(),
                    'line' => $e->getLine()
                ]
            ]);
        }
    }




    public function fetchClaimVin($oemId, $segment_id)
    {
        // dd($oemId, $segment_id);

        try {
            // DB::transaction(function() use($request) {
                $data = DB::table('claim_report_vin_vw')->where('oem_id', $oemId)->where('segment_id', $segment_id)->get();
                // if( isset($request->oem_id) && $request->oem_id != 'all') {
                //     $query = $query->where('oem_id', $request->oem_id);
                //     dd($query);
                // }
                // if(isset($request->seg_id) && $request->seg_id != 'all') {
                //     $query = $query->where('segment_id', $request->seg_id);
                // }

                // $data = $query->get();

                // dd($data);

                $oemName = DB::table('users')->where('id', $oemId)->first();
                $segmentName = DB::table('segment_master')->where('id', $segment_id)->first();

                $oem = $oemName->name;
                $segment =  $segmentName->segment_name;


                return response()->json([
                    'success' => true,
                    'data' => $data,
                    'oem_id' => $oem,
                    'segment_id' => $segment,
                ]);

            // });
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => [
                    'msg' => $e->getMessage(),
                    'line' => $e->getLine()
                ]
            ]);
        }
    }

    public function viewDetails($oemId,$claimnumberformat)
    {
        // dd(func_get_args(), base64_decode($claimnumberformat), str_replace("-", "/", $claimnumberformat));

      $claimnumberformats =  str_replace("-", "/", $claimnumberformat);
        $claim = DB::table('claim_report_customer_details_vw')->where('oem_id', $oemId)->where('claimnumberformat',$claimnumberformats)->paginate(50);

        return view('admin.claim_report_customer_detail', compact('claim'));
    }
}
