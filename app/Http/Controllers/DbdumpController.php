<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Alert;
use Carbon;
use App\Charts\EmployeeChart;
use App\Emp_Vaccine;
use App\Http\Requests\VacDepen;
use App\User;
use Analytics;
use Spatie\Analytics\Period;
use Adldap;
use Config;

class DbdumpController extends Controller
{
    public function index()
    {
       //
    }
    public function create()
    {
        //
    }
 
   public function dbdump($id)
    {
    //dd($id);
    return view('dbdump',compact('id'));

    }
  public function appdump($id)
    {
    //dd($id);
    return view('appdump',compact('id'));

    }



    public function store(request $request)
    {
       //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        dd($id);

    }
    public function update(Request $request, $id)
    {//
    }

    public function destroy($id)
    {
        //
    }
}
