<?php
namespace App\Http\Controllers\Truck\OEM;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\ProductionData;
use App\Imports\VinExcelImport;
use Maatwebsite\Excel\Facades\Excel;

class VinExcelDownload extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pid = getParentId();
        ini_set('memory_limit', '7048M');
        ini_set('max_execution_time', 7600);


        try {
            $modelMaster = [];
            //   dd($modelMaster,$pid);
            $productionData = ProductionData::where('oem_id', $pid)->get();
            // dd($modelMaster,$pid,$productionData );
            return view("truck.oem.production_data.vinexcel", compact('productionData', 'modelMaster'));
        } catch (\Exception $e) {
            errorMail($e, $pid);
            return redirect()->back();
        }


    }

    public function downloadVinFile()
    {
    //    dd('dd');
        try {
            $file = public_path('files/VinExcelData.xlsx');

            return response()->download($file);
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }


    public function uploadVinExcel(Request $request)
    {
        $request->validate([
            'upload' => 'required|file|mimes:xlsx,xls',
        ]);
    
        $file = $request->file('upload');
    
        $data = Excel::toArray(new VinExcelImport, $file);
        
       
        $vinData = [];
        if (!empty($data) && isset($data[0])) {
            foreach ($data[0] as $row) {
                if (!empty($row[0])) { 
                    $vinData[] = $row[0];
                }
            }
        }
        $matchedBuyers = DB::table('buyer_details_view')->whereIn('vin_chassis_no', $vinData)->get();

    
        return view("truck.oem.production_data.vinexcel",compact('vinData','matchedBuyers'))
        ->with('success', 'File uploaded and data processed successfully!');
    }
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


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
