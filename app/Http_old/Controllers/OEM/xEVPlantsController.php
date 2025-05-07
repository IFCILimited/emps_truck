<?php

namespace App\Http\Controllers\OEM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManufacturingEVPlantDetail;
use Auth;
use App\Models\User;
use DB;
use Exception;

class xEVPlantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $plants = ManufacturingEVPlantDetail::where('user_id', Auth::user()->id)->orderBy('id')->get();
            return view('oem.ev_plant_detail.manufacturing_xEV_plants', compact('plants'));
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('oem.ev_plant_detail.xEV_plant_create');
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                foreach ($request->evplant as $value) {
                    $manufacturing_plant = new ManufacturingEVPlantDetail;
                    $manufacturing_plant->user_id = Auth::user()->id;
                    $manufacturing_plant->plant_name = $value['plant_name'];
                    $manufacturing_plant->address = $value['plant_address'];
                    $manufacturing_plant->email = $value['plant_email'];
                    $manufacturing_plant->state = $value['plant_state'];
                    $manufacturing_plant->district = $value['plant_district'];
                    $manufacturing_plant->city = $value['plant_city'];
                    $manufacturing_plant->pincode = $value['plant_pincode'];
                    $manufacturing_plant->landline_no = $value['plant_landline'];
                    $manufacturing_plant->save();
                }
            });
            alert()->success('Data has been successfully save', 'Success')->persistent('Close');

            return redirect()->route('xEVPlants.index');
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }

    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $plant = ManufacturingEVPlantDetail::where('id', $id)->first();
            return view('oem.ev_plant_detail.xEV_plant_edit', compact('plant'));
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
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
        try {
            DB::transaction(function () use ($request, $id) {
                $id = decrypt($id);
                $manufacturing_plant = ManufacturingEVPlantDetail::find($id);
                $manufacturing_plant->user_id = Auth::user()->id;
                $manufacturing_plant->plant_name = $request->plant_name;
                $manufacturing_plant->address = $request->plant_address;
                $manufacturing_plant->email = $request->plant_email;
                $manufacturing_plant->state = $request->plant_state;
                $manufacturing_plant->district = $request->plant_district;
                $manufacturing_plant->city = $request->plant_city;
                $manufacturing_plant->pincode = $request->plant_pincode;
                $manufacturing_plant->landline_no = $request->plant_landline;
                $manufacturing_plant->save();
            });
            alert()->success('Data has been successfully updated', 'Success')->persistent('Close');

            return redirect()->route('xEVPlants.index');
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
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
