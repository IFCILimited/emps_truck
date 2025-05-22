<?php

namespace App\Http\Controllers\Truck\OEM;

use DB;
use Auth;
use App\Models\Trucks\TempProductionData;
use App\Models\Trucks\ProductionData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\TempProductionDataTruckImport;
use App\Exports\TruckProductionExport;
use Exception;

class ManageProductionDataController extends Controller
{
    public function index()
    {
        $pid = getParentId();
        // ini_set('memory_limit', '7048M');
        // ini_set('max_execution_time', 7600);
        ini_set('max_execution_time', 0);

        try {
            //             $modelMaster = DB::table("model_master as mm")
            //                 ->join('oem_model_details as omd', 'mm.id', '=', 'omd.model_id')
            //                 ->join('users as u', 'u.id', '=', 'mm.oem_id')
            //                 ->where('omd.testing_flag', 'A')
            //                 ->where('omd.mhi_flag', 'A')
            //                 ->where('omd.oem_id', $pid)
            // 		 ->where('mm.oem_id', $pid)
            //                 ->select('u.name', 'mm.*', 'omd.*')
            //                 ->get();
            //            //  dd($modelMaster,$pid);
            //             $productionData = ProductionData::where('oem_id',$pid)->get();
            //  //dd($modelMaster,$pid,$productionData );
            //             return view("truck.oem.production_data.index_production_data", compact('productionData', 'modelMaster'));


            $modelMaster = DB::table("truck_model_master as mm")
                ->join('truck_oem_model_details as omd', 'mm.id', '=', 'omd.model_id')
                ->join('users as u', 'u.id', '=', 'mm.oem_id')
                ->where('omd.testing_flag', 'A')
                ->where('omd.mhi_flag', 'A')
                ->where('omd.oem_id', $pid)
                ->where('mm.oem_id', $pid)
                ->select('u.name', 'mm.*', 'omd.*')
                ->get();
            // dd($modelMaster);

            if (count($modelMaster) > 0) {
                foreach ($modelMaster as $model) {
                    $prd = ProductionData::select('status')
                        ->where('oem_id', $pid)
                        ->where('model_master_id', $model->model_id)
                        ->where('model_details_id', $model->id)
                        ->first();

                    if ($prd) {
                        $model->productionDataStatus = $prd->status;
                        continue;
                    }
                    $model->productionDataStatus = false;
                }
            }
            return view("truck.oem.production_data.index_production_data", compact('modelMaster'));
        } catch (\Exception $e) {
            errorMail($e, $pid);
            return redirect()->back();
        }
    }


    public function create($data)
    {
        ini_set('memory_limit', '7048M');
        ini_set('max_execution_time', 7600);

        $data = decrypt($data);
        $pid = getParentId();
        // dd($pid);
        try {
            $items = DB::table('temp_production_data_trucks')
                ->join('truck_model_master', 'temp_production_data_trucks.model_master_id', '=', 'truck_model_master.id')
                ->where('temp_production_data_trucks.oem_id', $pid)
                ->where('temp_production_data_trucks.model_master_id', $data['model_id'])
                ->where('temp_production_data_trucks.model_details_id', $data['model_det_id'])
                ->get();



            $modelMaster = DB::table("truck_model_master as mm")
                ->join('truck_oem_model_details as omd', 'mm.id', '=', 'omd.model_id')
                ->join('users as u', 'u.id', '=', 'mm.oem_id')
                ->join('truck_segment_master as sm', 'mm.segment_id', '=', 'sm.id')
                ->where('omd.testing_flag', 'A')
                ->where('omd.mhi_flag', 'A')
                ->where('omd.oem_id', $pid)
                ->where('mm.oem_id', $pid)
                ->where('omd.model_id', $data['model_id'])
                ->where('omd.id', $data['model_det_id'])
                ->select('u.name', 'mm.*', 'omd.*', 'sm.*')
                ->get();
                //dd($modelMaster);

            return view('truck.oem.production_data.create_production_data', compact('items', 'modelMaster'));
        } catch (\Exception $e) {
        //    dd($e);
            // errorMail($e, $pid);
            return redirect()->back();
        }
    }



    public function store(Request $request)
    {
        // dd($request);
        // ini_set('memory_limit', '7048M');
        // ini_set('max_execution_time', 7600);
        ini_set('max_execution_time', 0);
        $pid = getParentId();
        try {
            DB::transaction(function () use ($request, $pid) {
                $vinChassisNos = [];
                $gwVehicle = [];
                foreach ($request->production as $productionItem) {
                    $modelMasterId = $productionItem['model_master_id'];
                    $modelDetailsId = $productionItem['model_deatils_id'];

                    foreach ($productionItem as $key => $production) {
                        if (strpos($key, 'production[') !== false) {
                            // Collect VIN chassis numbers to check uniqueness
                            $vinChassisNos[] = $production['vin_chassis_no'];
                            $gwVehicle[] = $production['gross_weight'];
                        }
                    }
                }

                $gvwCheck = DB::table('truck_oem_model_details')->where('id', $modelDetailsId)->first();

                $offendingVins = [];
                foreach ($gwVehicle as $index => $grossWeight) {
                    if ($grossWeight > $gvwCheck->gross_weight) {
                        $offendingVins[] = $vinChassisNos[$index];
                    }
                }

                if (!empty($offendingVins)) {
                    throw new \Exception('The following VIN chassis numbers exceed the allowed gross weight: ' . implode(', ', $offendingVins));
                }
                // Check if any VIN chassis numbers are already in the database
                $existingVinChassisNos = ProductionData::whereIn('vin_chassis_no', $vinChassisNos)->pluck('vin_chassis_no')->toArray();

                if (!empty($existingVinChassisNos)) {
                    throw new \Exception('The following VIN chassis numbers are already in the database: ' . implode(', ', $existingVinChassisNos));
                }

                // Proceed with saving the production data
                foreach ($request->production as $productionItem) {
                    $modelMasterId = $productionItem['model_master_id'];
                    $modelDetailsId = $productionItem['model_deatils_id'];

                    foreach ($productionItem as $key => $production) {
                        if (strpos($key, 'production[') !== false) {
                            $newProductionData = new ProductionData;
                            $newProductionData->oem_id = $pid;
                            $newProductionData->model_details_id = $modelDetailsId;
                            $newProductionData->model_master_id = $modelMasterId;
                            $newProductionData->manufacturing_date = $production['manufacturing_date'];
                            $newProductionData->vin_chassis_no = $production['vin_chassis_no'];
                            $newProductionData->colour = $production['colour'];
                            $newProductionData->emission_norms = $production['emission_norms'];
                            $newProductionData->motor_number = $production['motor_number'];
                            $newProductionData->gross_weight = $production['gross_weight'];
                            // $newProductionData->battery_number = $production['battery_number'];
                            // $newProductionData->battery_number2 = $production['battery_number2'];
                            // $newProductionData->battery_number3 = $production['battery_number3'];
                            // $newProductionData->battery_number4 = $production['battery_number4'];
                            // $newProductionData->battery_number5 = $production['battery_number5'];
                            // $newProductionData->battery_number6 = $production['battery_number6'];
                            // $newProductionData->battery_number7 = $production['battery_number7'];
                            // $newProductionData->battery_number8 = $production['battery_number8'];
                            // $newProductionData->battery_number9 = $production['battery_number9'];
                            // $newProductionData->battery_number10 = $production['battery_number10'];
                            $newProductionData->battery_make = $production['battery_make'];
                            $newProductionData->no_of_battery = $production['no_of_battery'];
                            $newProductionData->battery_capacity = $production['battery_capacity'];
                            $newProductionData->battery_chemistry = $production['battery_chemistry'];
                            $newProductionData->dva_indicative = $production['dva_indicative'];
                            $newProductionData->pmp_compliance = $production['pmp_compliance'];
                            $newProductionData->status = 'D';
                            $newProductionData->uploaded_method = 'Excel';
                            $newProductionData->child_id = Auth::user()->id;
                            $newProductionData->save();
                        }
                    }
                }

                TempProductionData::where('model_master_id', $request->model_master_id)->delete();
            });

            $data = [
                'model_id' => $request->model_master_id,
                'model_det_id' => $request->model_deatils_id,
            ];
            return response()->json(['message' => 'Data has been successfully saved.', 'redirect_url' => route('e-trucks.manageProductionData.edit', encrypt($data))]);
        } catch (\Exception $e) {
            // dd($e);
            // errorMail($e, Auth::user()->id);
            return response()->json(['message' => 'An error occurred while saving the data.', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        ini_set('memory_limit', '7048M');
        ini_set('max_execution_time', 7600);

        $pid = getParentId();
        try {

            $id = decrypt($id);

            $productionData = DB::table('production_data')
                ->join('model_master', 'production_data.model_master_id', '=', 'model_master.id')
                ->where('production_data.oem_id', $pid)
                ->where('production_data.model_master_id', $id['model_id'])
                ->where('production_data.model_details_id', $id['model_det_id'])
                ->get();
            return view('truck.oem.production_data.view_production_data', compact('productionData'));
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        ini_set('memory_limit', '7048M');
        ini_set('max_execution_time', 7600);

        $pid = getParentId();
        try {
            $id = decrypt($id);

            $productionData = DB::table('trucks_production_data')
                ->join('truck_model_master', 'trucks_production_data.model_master_id', '=', 'truck_model_master.id')
                ->where('trucks_production_data.oem_id', $pid)
                ->where('trucks_production_data.model_master_id', $id['model_id'])
                ->where('trucks_production_data.model_details_id', $id['model_det_id'])
                ->get(['trucks_production_data.*', 'truck_model_master.model_name', 'truck_model_master.model_code']);

            $modelMaster = DB::table("truck_model_master as mm")
                ->join('truck_oem_model_details as omd', 'mm.id', '=', 'omd.model_id')
                ->join('users as u', 'u.id', '=', 'mm.oem_id')
                ->join('segment_master as sm', 'mm.segment_id', '=', 'sm.id')
                ->where('omd.testing_flag', 'A')
                ->where('omd.mhi_flag', 'A')
                ->where('omd.oem_id', $pid)
                ->where('mm.oem_id', $pid)
                ->where('omd.model_id', $id['model_id'])
                ->where('omd.id', $id['model_det_id'])
                ->select('u.name', 'mm.*', 'omd.*', 'sm.*')
                ->get();


            return view('truck.oem.production_data.edit_production_data', compact('productionData', 'id', 'modelMaster'));
        } catch (\Exception $e) {
            // dd($e);
            errorMail($e, $pid);
            return redirect()->back();
        }
    }

    public function update(Request $request, $user_id)
    {
        // dd($request);
        // ini_set('memory_limit', '7048M');
        // ini_set('max_execution_time', 7600);
        ini_set('max_execution_time', 0);
        $pid = getParentId();
        try {
            DB::transaction(function () use ($request, $pid) {
                $vinChassisNos =[];
                $gwVehicle = [];
                foreach ($request->production as $productionItem) {
                     $modelMasterId = $request->model_master_id;
                    $modelDetailsId = $request->model_deatils_id;
                    foreach ($productionItem as $key => $production) {
                        
                            // Collect VIN chassis numbers to check uniqueness
                            $vinChassisNos[] = $production['vin_chassis_no'];
                            $gwVehicle[] = $production['gross_weight'];
                        
                    }
                    // dd($production);

                     $gvwCheck = DB::table('truck_oem_model_details')->where('id', $modelDetailsId)->first();
// dd($gwVehicle,$vinChassisNos);
                $offendingVins = [];
                foreach ($gwVehicle as $index => $grossWeight) {
                    if ($grossWeight > $gvwCheck->gross_weight) {
                        $offendingVins[] = $vinChassisNos[$index];
                    }
                }

                if (!empty($offendingVins)) {
                    throw new \Exception('The following VIN chassis numbers exceed the allowed gross weight: ' . implode(', ', $offendingVins));
                }
                // Check if any VIN chassis numbers are already in the database
                
                    foreach ($productionItem as $key => $value) {
                        // dd($value);

                        $productionData = ProductionData::find($value['id']);
                        $productionData->manufacturing_date = $value['manufacturing_date'];
                        $productionData->vin_chassis_no = $value['vin_chassis_no'];
                        $productionData->colour = $value['colour'];
                        $productionData->emission_norms = $value['emission_norms'];
                        $productionData->motor_number = $value['motor_number'];
                        $productionData->gross_weight = $value['gross_weight'];
                        $productionData->battery_number = $value['battery_number'];
                        $productionData->battery_number2 = $value['battery_number2'] ?? null;
                        $productionData->battery_number3 = $value['battery_number3'] ?? null;
                        $productionData->battery_number4 = $value['battery_number4'] ?? null;
                        $productionData->battery_number5 = $value['battery_number5'] ?? null;
                        $productionData->battery_number6 = $value['battery_number6'] ?? null;
                        $productionData->battery_number7 = $value['battery_number7'] ?? null;
                        $productionData->battery_number8 = $value['battery_number8'] ?? null;
                        $productionData->battery_number9 = $value['battery_number9'] ?? null;
                        $productionData->battery_number10 = $value['battery_number10'] ?? null;
                        $productionData->battery_make = $value['battery_make'];
                        $productionData->battery_capacity = $value['battery_capacity'];
                        $productionData->battery_chemistry = $value['battery_chemistry'];
                        $productionData->dva_indicative = $value['dva_indicative'];
                        $productionData->pmp_compliance = $value['pmp_compliance'];
                        $productionData->save();
                    }
                }
            });

            $data = [
                'model_id' => $request->model_master_id,
                'model_det_id' => $request->model_deatils_id,
            ];

            // Return JSON response with success message and redirect URL
            return response()->json(['message' => 'Data has been successfully updated.', 'redirect_url' => route('e-trucks.manageProductionData.edit', encrypt($data))]);
        } catch (\Exception $e) {
            // dd($e);
            // errorMail($e, Auth::user()->id);
            return response()->json(['message' => 'An error occurred while saving the data.', 'error' => $e->getMessage()], 500);
        }
    }




    public function destroy($id)
    {
        //
    }

    public function downloadFile()
    {
        try {
            $file = public_path('files/ManageProductionData.xlsx');

            return response()->download($file);
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    // public function uploadExcel(Request $request)
    // {
    //     $request->validate([
    //         'excel_file' => 'required|mimes:xlsx,xls|max:20480',
    //     ]);


    //     try {

    //         $checkIfTempProductionDataExists = TempProductionData::where('model_details_id', $request->model_det_id)->where('model_master_id', $request->model_id)->exists();
    //         if ($checkIfTempProductionDataExists) {
    //             TempProductionData::where('model_details_id', $request->model_det_id)->where('model_master_id', $request->model_id)->delete();
    //         }

    //         $excel = Excel::import(new TempProductionDataImport($request), $request->file('excel_file'));

    //         return redirect()->route('manageProductionData.create')->with('success', 'Excel file uploaded successfully!');
    //     } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
    //         // dd($e);
    //         $failures = $e->failures();
    //         // errorMail($e, Auth::user()->id);

    //         foreach ($failures as $val) {
    //             if ($val->attribute()) {
    //                 alert()->error($val->errors(), 'Error')->persistent('ok');
    //                 redirect()->back();
    //             }
    //         }
    //         return redirect()->back()->withErrors($failures)->withInput();
    //     }catch (\Exception $e) {
    //         // dd($e);     
    //         // errorMail($e, Auth::user()->id);
    //         return redirect()->back();
    //     }
    // }
    public function uploadExcel(Request $request)
    {


        // ini_set('memory_limit', '7048M');
        //     ini_set('max_execution_time', 7600);
        ini_set('max_execution_time', 0);
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls|max:20480',
        ]);

        // try {
            $checkIfTempProductionDataExists = TempProductionData::where('model_details_id', $request->model_det_id)
                ->where('model_master_id', $request->model_id)
                ->exists();

            if ($checkIfTempProductionDataExists) {
                TempProductionData::where('model_details_id', $request->model_det_id)
                    ->where('model_master_id', $request->model_id)
                    ->delete();
            }
            $data = array(
                'model_id' => $request->model_id,
                'model_det_id' => $request->model_det_id
            );

            Excel::import(new TempProductionDataTruckImport($request), $request->file('excel_file'));

            return redirect()->route('e-trucks.manageProductionData.create', encrypt($data))->with('success', 'Excel file uploaded successfully!');
        // } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        //     dd($e);
        //     $failures = $e->failures();

        //     foreach ($failures as $failure) {
        //         if ($failure->attribute()) {
        //             alert()->error($failure->errors(), 'Error')->persistent('ok');
        //             return redirect()->back();
        //         }
        //     }
        //     return redirect()->back()->withErrors($failures)->withInput();
        // } catch (\Exception $e) {
        //     // dd($e);
        //     return redirect()->back();
        // }
    }




    public function finalSubmit(Request $request, $id)
    {
        //     ini_set('memory_limit', '7048M');
        // ini_set('max_execution_time', 7600);
        ini_set('max_execution_time', 0);
        $pid = getParentId();
        try {
            ProductionData::where('oem_id', $pid)->update([
                'status' => 'S'
            ]);
            alert()->success('Data has been successfully submitted.', 'Success')->persistent('close');
            return redirect()->route('e-trucks.manageProductionData.index');
        } catch (\Exception $e) {
            errorMail($e, $pid);
            return redirect()->back();
        }
    }

    public function downloadexcel($data)
    {
        
        //     ini_set('memory_limit', '7048M');
        // ini_set('max_execution_time', 7600);
        ini_set('max_execution_time', 0);
        $pid = getParentId();
        try {
            return Excel::download(new TruckProductionExport($data), 'production_data.xlsx');
        } catch (\Exception $e) {
            dd($e);
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }
    public function deleteTempData($id, $status)
    {
        try {

            // dd($id, $status);
            DB::transaction(function () use ($id, $status) {

                if ($status == '1') {

                    TempProductionData::where('model_master_id', $id)->delete();
                } elseif ($status == '2') {

                    ProductionData::where('model_master_id', $id)->where('status', 'D')->delete();
                }
            });
            alert()->success('Data has been successfully Deleted.', 'Success')->persistent('close');
            return redirect()->route('e-trucks.manageProductionData.index');
        } catch (\Exception $e) {
            dd($e);
            // errorMail($e, Auth::user()->id);
            return response()->json(['message' => 'An error occurred while saving the data.', 'error' => $e->getMessage()], 500);
        }
    }
}
