<?php

namespace App\Http\Controllers\Truck\OEM;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;


class VinEditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vin = null;

        $vinChassis = DB::table('vin_chassis_edit')
            ->where('oem_id', Auth::user()->id)
            ->get()
            ->map(function ($item) {
                $item->vin_chassis = json_decode($item->vin_chassis, true);
                return $item;
            });


        return view('truck.oem.vin_chassis_edit.vinEdit', compact('vin', 'vinChassis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $vinChassis = DB::table('vin_chassis_edit')
            ->where('id', $id)
            ->first();

        if ($vinChassis) {
            $vinChassis->vin_chassis = json_decode($vinChassis->vin_chassis, true);
        }
        if (is_array($vinChassis->vin_chassis)) {
            foreach ($vinChassis->vin_chassis as $index => $vin) {

                if ($vin) {
                    $existsinProd = DB::table('production_data')
                        ->where('vin_chassis_no', $vin)
                        ->exists();


                    if ($existsinProd) {
                        $existsinBuyer = DB::table('buyer_details')
                            ->where('vin_chassis_no', $vin)
                            ->exists();

                        // dd($existsinBuyer);
                        $existsinBuyerEmps = CheckVinExist($vin);
                        if ($existsinBuyerEmps) {
                            alert()->warning('Vin Chassis already Sold in Emps', 'Warning')->persistent('Close');
                            return redirect()->route('e-trucks.editVin.index');
                        } elseif ($existsinBuyer) {
                            alert()->warning('Vin Chassis already Sold in PM E-Drive', 'Warning')->persistent('Close');
                            return redirect()->route('e-trucks.editVin.index');
                        } else {

                            $openVins = DB::table('vw_vin_details')->where('vin_chassis_no', $vin)->first();

                            $vinChassisData[] = [
                                'open_vins' => $openVins,
                            ];

                        }
                    }
                }
            }
            return view('truck.oem.vin_chassis_edit.vinCheck', compact('vin', 'openVins', 'vinChassisData', 'vinChassis'));


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
    public function edit(Request $request)
    {

        // dd($request);
        $prods = DB::table('production_data')->whereIn('id', $request['prod_id'])->get();

        $vinCheck = DB::table('vin_chassis_edit')->where('id', $request->vin_id)->first();

        // dd($prods);

        // dd($vinCheck);



        if ($prods) {
            foreach ($prods as $prod) {

                // Insert the fetched data into production_data_logs
                DB::table('production_data_logs')->insert([
                    'oem_id' => $prod->oem_id,
                    'model_details_id' => $prod->model_details_id,
                    'model_master_id' => $prod->model_master_id,
                    'manufacturing_date' => $prod->manufacturing_date,
                    'vin_chassis_no' => $prod->vin_chassis_no,
                    'colour' => $prod->colour,
                    'emission_norms' => $prod->emission_norms,
                    'motor_number' => $prod->motor_number,
                    'battery_number' => $prod->battery_number,
                    'battery_number2' => $prod->battery_number2,
                    'battery_number3' => $prod->battery_number3,
                    'battery_number4' => $prod->battery_number4,
                    'battery_number5' => $prod->battery_number5,
                    'battery_number6' => $prod->battery_number6,
                    'battery_number7' => $prod->battery_number7,
                    'battery_number8' => $prod->battery_number8,
                    'battery_number9' => $prod->battery_number9,
                    'battery_number10' => $prod->battery_number10,
                    'battery_make' => $prod->battery_make,
                    'battery_capacity' => $prod->battery_capacity,
                    'battery_chemistry' => $prod->battery_chemistry,
                    'dva_indicative' => $prod->dva_indicative,
                    'pmp_compliance' => $prod->pmp_compliance,
                    'status' => $prod->status,
                    'uploaded_method' => $prod->uploaded_method,
                    'created_at' => now(), // Set current timestamp
                    'updated_at' => now(), // Set current timestamp
                    'child_id' => $prod->child_id,
                ]);

                DB::table('vin_chassis_edit')->where('id', $vinCheck->id)
                    ->update(['delete_vin' => 'Y', 'delete_by' => Auth::user()->id, 'delete_at' => now()]);

            }
            DB::table('production_data')->whereIn('id', $request['prod_id'])->delete();

            alert()->success('Data Deleted Successfully', 'Success')->persistent('Close');
            return redirect()->route('e-trucks.editVin.index');
        } else {
            alert()->warning('Data Not Found', 'Warning')->persistent('Close');
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
