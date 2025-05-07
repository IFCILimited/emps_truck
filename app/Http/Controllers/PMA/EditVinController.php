<?php

namespace App\Http\Controllers\PMA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VinChassisEdit;
use DB;
use Carbon\Carbon;
use Exception;
use Auth;

class EditVinController extends Controller
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
        // dd($users);

        $openVins = DB::table('vin_chassis_edit')->get();

        $oem_id = null;

        return view('pma.editVin', compact('users', 'oem_id', 'openVins'));
    }


    public function vinSearch($oem_id)
    {

        $users = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 4)
            ->where('isactive', 'Y')
            ->where('isapproved', 'Y')
            ->where('parent_id', null)
            ->where('id', $oem_id)
            ->select('users.*', 'model_has_roles.role_id')
            ->first()->name;

        // dd($users);

        $selusers = DB::table('users')->where('id', $oem_id)->get();

        return view('pma.editVin', compact('users', 'selusers', 'oem_id'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
{
    // dd($request);
    try {
        // Fetch user details
        $users = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 4)
            ->where('isactive', 'Y')
            ->where('isapproved', 'Y')
            ->whereNull('parent_id')
            ->where('users.id', $request->oem_id)
            ->select('users.*', 'model_has_roles.role_id')
            ->first();

        // Get OEM-specific users (if needed)
        $selusers = DB::table('users')->where('id', $request->oem_id)->get();

        $vin = $request->vinchassis; // Input VIN list
        $temp = []; // Array to store VIN statuses

        foreach ($vin as $chasno) {
        $existsinBuyerEmps = CheckVinExist($chasno);
        // dd($existsinBuyerEmps);
        if ($existsinBuyerEmps) {
            $temp[] = [
                "chas_no" => $chasno,
                "status" => "1"
                ];
        }else{
            $checkProd = DB::table('production_data')
                    ->where('vin_chassis_no', $chasno)
                    ->where('oem_id', $request->oem_id)
                    ->exists();
            if($checkProd){
                $checkBuyer = DB::table('buyer_details')
                    ->where('vin_chassis_no', $chasno)
                    ->where('oem_id', $request->oem_id)
                    ->exists();
                if($checkBuyer)
                {
                    $temp[] = [
                        "chas_no" => $chasno,
                        "status" => "2"
                        ];
                }else{
                    $temp[] = [
                        "chas_no" => $chasno,
                        "status" => "3"
                        ];
                }
            }else{
                $temp[] = [
                    "chas_no" => $chasno,
                    "status" => "4"
                    ];
            }
        }
    }

        $chasnonew = $temp;


        return view('pma.checkVin', compact('vin', 'users', 'selusers', 'chasnonew'));
    } catch (\Exception $e) {
        \Log::error('Error in create method: ' . $e->getMessage() . ' on line ' . $e->getLine());

        // Debug during development
        // dd($e->getMessage(), $e->getLine());

        // Redirect back with error message
        return redirect()->back()->with('error', 'An error occurred while processing your request.');
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
        // dd($request->vinchassis,json_encode($request->vinchassis));
        try {
            DB::transaction(function () use ($request) {
                if ($request->hasFile('vin_doc')) {
                    $file = $request->vin_doc;
                    $response = uploadFileWithCurl($file);
                    $vinFile = $response;
                    // $vinFile = 1;
                }

                $vinChassis = array_values($request->vinchassis);

                $vinEdit = new VinChassisEdit;
                $vinEdit->oem_id = $request->oem_id;
                $vinEdit->valid_from = $request->validFrom;
                $vinEdit->valid_to = $request->validTo;
                $vinEdit->reason = $request->reason;
                $vinEdit->vin_document = $vinFile;
                $vinEdit->vin_chassis = $vinChassis;
                $vinEdit->created_by = Auth::user()->id;
                $vinEdit->created_at = Carbon::now();
                $vinEdit->save();

            });
            alert()->success('Data has been successfully Saved', 'Success')->persistent('Close');

            return redirect()->route('vinEdit.index');
        } catch (\Exception $e) {
            dd($e);
            alert()->warning('Data Failed', 'Warning')->persistent('Close');
            return redirect()->back();
        }
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

    public function searchVin($vin)
    {


        // $vin = $vin->input('vin');

        dd($vin);

        $productionData = DB::table('production_data')->where('vin_chassis_no', $vin)->first();

        dd($productionData);

        if ($productionData) {
            return response()->json([
                'success' => true,
                'vin_chassis_no' => $productionData->vin_chassis_no
            ]);
        }

        return response()->json([
            'success' => false
        ]);
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
