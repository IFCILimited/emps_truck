<?php

namespace App\Http\Controllers\Admin\FlowChart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class ModelChartDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $modelCount = DB::table('model_details_count_vw')->first();

        $modelDetails = DB::table('vw_model_details')->where('status', 'S')->get();



        return view('admin.flow_chart.model_chart_details_index', compact('modelCount', 'modelDetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->has('oem_id') && $request->has('model_id')) {

            $users = DB::table('users')
                ->join('model_has_roles', 'users.id', '=',  'model_has_roles.model_id')
                ->where('model_has_roles.role_id', '=', 4)
                ->where('users.oem_type_id', '=', 3)
                ->where('users.approval_for_post_reg', '=', 'A')
                ->get(['id', 'name']);

            // $data = DB::table('oem_model_details_auditor');
            // if($request->query('oem_id') != 'all' ) {
            //     $data->where('oem_id', $request->query('oem_id'));
            // }
            // if($request->query('model_id') != 'all' ) {
            //     $data->where('model_id', $request->query('model_id'));
            // }
            // $data->join('vw_model_details', 'oem_model_details_auditor.oem_id', '=' , 'vw_model_details.oem_id');
            // $data =  $data->get();

            $datas = DB::table('oem_model_details_auditor')
        ->when($request->query('oem_id') && $request->query('oem_id') != 'all', function ($query) use ($request) {
            $query->where('oem_model_details_auditor.oem_id', $request->query('oem_id'));
        })
        ->when($request->query('model_id') && $request->query('model_id') != 'all', function ($query) use ($request) {
            $query->where('oem_model_details_auditor.model_id', $request->query('model_id'));
        })
        ->join('vw_model_details', function ($join) {
            $join->on('oem_model_details_auditor.oem_model_details_id', '=', 'vw_model_details.model_detail_id');
        })
        ->join('users as u', function ($join) {
            $join->on('oem_model_details_auditor.pma_revert_created_by', '=', 'u.id');
        })
        ->leftjoin('users as u1', function ($join) {
            $join->on('oem_model_details_auditor.mhi_revert_created_by', '=', 'u1.id');
        })
        ->select(
            'oem_model_details_auditor.*',
            'vw_model_details.model_name',
            'vw_model_details.oem_name',
            'vw_model_details.segment',
            'vw_model_details.vehicle_cat',
            'vw_model_details.valid_date',
            'vw_model_details.valid_upto',
            'u.name',
            'u1.name as mhi_name',
        )
        ->get();



            $modelName = DB::table('vw_model_details')->where('status', 'S')->distinct('model_name')->get(['model_name', 'oem_id', 'model_id']);

            return view('admin.flow_chart.model_chart_revert', compact('users', 'datas', 'modelName'));
        }

        $users = DB::table('users')
            ->join('model_has_roles', 'users.id', '=',  'model_has_roles.model_id')
            ->where('model_has_roles.role_id', '=', 4)
            ->where('users.oem_type_id', '=', 3)
            ->where('users.approval_for_post_reg', '=', 'A')
            ->get(['id', 'name']);

        $modelName = DB::table('vw_model_details')->where('status', 'S')->distinct('model_name')->get(['model_name', 'oem_id', 'model_id']);

        // $data = DB::table('oem_model_details_auditor')->get();

        $datas = DB::table('oem_model_details_auditor')
        ->when($request->query('oem_id') && $request->query('oem_id') != 'all', function ($query) use ($request) {
            $query->where('oem_model_details_auditor.oem_id', $request->query('oem_id'));
        })
        ->when($request->query('model_id') && $request->query('model_id') != 'all', function ($query) use ($request) {
            $query->where('oem_model_details_auditor.model_id', $request->query('model_id'));
        })
        ->join('vw_model_details', function ($join) {
            $join->on('oem_model_details_auditor.oem_model_details_id', '=', 'vw_model_details.model_detail_id');
        })
        ->join('users as u', function ($join) {
            $join->on('oem_model_details_auditor.pma_revert_created_by', '=', 'u.id');
        })
        ->leftjoin('users as u1', function ($join) {
            $join->on('oem_model_details_auditor.mhi_revert_created_by', '=', 'u1.id');
        })
        ->select(
            'oem_model_details_auditor.*',
            'vw_model_details.model_name',
            'vw_model_details.oem_name',
            'vw_model_details.segment',
            'vw_model_details.vehicle_cat',
            'vw_model_details.valid_date',
            'vw_model_details.valid_upto',
            'u.name',
            'u1.name as mhi_name',
        )
        ->get();


        // dd($datas);

        return view('admin.flow_chart.model_chart_revert', compact('users', 'datas', 'modelName'));
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

    public function fetchModelRevert($oemId)
    {
        try {

            $data = DB::table('vw_model_details')->where('status', 'S')->where('oem_id', $oemId)->distinct('model_name')->get(['model_name', 'oem_id', 'model_id']);


            return response()->json([
                'success' => true,
                'data' => $data,
                // 'oem_id' => $oem,
                // 'segment_id' => $segment,
            ]);

            // });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => [
                    'msg' => $e->getMessage(),
                    'line' => $e->getLine()
                ]
            ]);
        }
    }
}
