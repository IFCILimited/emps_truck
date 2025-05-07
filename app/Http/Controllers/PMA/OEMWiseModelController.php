<?php

namespace App\Http\Controllers\PMA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;


class OEMWiseModelController extends Controller
{
    public function index() {
        $oemList = User::whereNotNull('oem_type_id')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('roles.id', 4)
        ->where('users.parent_id', null) 
        ->where('post_registration_status','A')
        ->orderBy('users.name', 'ASC')
        ->orderBy('users.created_at', 'desc')
        ->select('users.*')
        ->get();

        // dd($preUser);

        return view('pma.oemwisemodel',compact('oemList'));
    }

    public function show($oemid) {
        
        // $models1 = DB::table('model_master')->where('oem_id',$oemid)->get();
        $models = DB::table('vw_model_details')->where('oem_id',$oemid)->where('mhi_flag','A')->distinct('model_name')->get();
        $oemName = User::where('id',$oemid)->first();
        $segment = DB::table('segment_master')->get();
        // dd($models,$models1);

        return view('pma.oemwisemodelshow',compact('oemName','models','segment'));
    }

    public function modelDetails($modelid) {
        $modelDet = DB::table('vw_model_details')->where('model_id',$modelid)->where('mhi_flag','A')->orderBy('valid_from', 'DESC')->get();
        $models = DB::table('model_master')->where('id',$modelid)->first();
        $oemName =  User::where('id',$models->oem_id)->first();
        $segment = DB::table('segment_master')->get();
        // dd($modelDet);
        return view('pma.oemwisemodeldetails',compact('modelDet','models','oemName','segment'));
    }
}
