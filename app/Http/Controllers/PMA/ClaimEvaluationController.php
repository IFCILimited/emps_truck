<?php

namespace App\Http\Controllers\PMA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClaimMaster;
use Auth;
use DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;


class ClaimEvaluationController extends Controller
{


   public function index()
{
        ini_set('memory_limit', '8048M');
        ini_set('max_execution_time', 8600);
    $oemDetails = DB::table('oem_ev_summary')
        ->select('oem_id', 'oem_name')
        ->orderby('oem_name')
        ->groupBy('oem_id', 'oem_name')
        ->get();
    $segMaster = DB::table('segment_master')->pluck('segment_name', 'id', 'segMaster');
    if (Auth::user()->hasRole('AUDITOR')) {
        $claimMaster = DB::table('claim_eval_master_vw as cmv')
            ->join('claim_evaluation_stages as ces', 'ces.claim_id', '=', 'cmv.claim_id')
            ->where('ces.visible_status', true)
            ->where('ces.status', 'S')
            ->where('ces.stage_id', 1)
            ->where('ces.auditor_id', Auth::user()->id)
            ->whereRaw('? = (SELECT MAX(stage_id) FROM claim_evaluation_stages WHERE visible_status = true AND claim_id =cmv.claim_id AND status = ?)', [1, 'S'])
            ->select('cmv.*', 'ces.stage_id','cmv.claim_no as claimnumberformat')
            ->get();
           $claimMaster1 = DB::table('claim_eval_master_vw as cmv')
    ->join('claim_evaluation_stages as ces', 'ces.claim_id', '=', 'cmv.claim_id')
    ->where('ces.visible_status', true)
    ->where('ces.status', 'S')
    ->where('ces.stage_id', 10)
    ->whereRaw('10 <= (
        SELECT MAX(stage_id) 
        FROM claim_evaluation_stages 
        WHERE visible_status = true 
          AND claim_id = cmv.claim_id 
          AND status = ?
    )', ['S'])
    ->whereExists(function ($query) {
        $query->select(DB::raw(1))
              ->from('claim_evaluation_stages as ces1')
              ->whereColumn('ces1.claim_id', 'cmv.claim_id')
              ->where('ces1.stage_id', 1)
              ->where('ces1.visible_status', true)
              ->where('ces1.status', 'S')
              ->where('ces1.auditor_id', Auth::user()->id);  // ✅ check for current user in stage 1
    })
    ->select('cmv.*', 'ces.stage_id', 'cmv.claim_no as claimnumberformat', 'ces.auditor_id')
    ->get();

            // dd($claimMaster1 );
        return view('pma.claimevaluation.AuditorEvaluationHome', compact('claimMaster1','claimMaster', 'oemDetails', 'segMaster'));
    } 
    
    // If user is a PMA
    elseif (Auth::user()->hasRole('PMA')) {
        $data = DB::table('claim_evaluation_stages')
            ->select('claim_id')
            ->where('visible_status', '1')
            ->where('status', 'S')
            ->groupBy('claim_id')
            ->pluck('claim_id');
        $claimMaster = DB::table('claim_master_evl_vw as cmev')
            ->leftjoin('users as u', 'u.id', '=', 'cmev.auditor_id')
            ->select('cmev.*', 'u.name as auditor_name')
            ->whereNull('cmev.stage_id')
            ->whereNotNull('pma_process_by')
            ->get();
        $claimMasterauditor = DB::table('claim_eval_master_vw as cmv')
            ->join('claim_evaluation_stages as ces', 'ces.claim_id', '=', 'cmv.claim_id')
            ->leftjoin('users as u', 'u.id', '=', 'ces.auditor_id')
            ->where('ces.visible_status', true)
            ->where('ces.status', 'S')
            ->where('ces.stage_id', 1)
            ->whereRaw('1 = (SELECT MAX(stage_id) FROM claim_evaluation_stages WHERE visible_status = true AND claim_id =cmv.claim_id AND status = \'S\')')
            ->select('cmv.*', 'ces.stage_id', 'u.name as auditor_name','cmv.claim_no as claimnumberformat')
            ->get();
        $auditortopma = DB::table('claim_eval_master_vw as cmv')
            ->join('claim_evaluation_stages as ces', 'ces.claim_id', '=', 'cmv.claim_id')
            ->where('ces.visible_status', true)
            ->where('ces.status', 'S')
            ->where('ces.stage_id', 10)
            ->whereRaw('? = (SELECT MAX(stage_id) FROM claim_evaluation_stages WHERE visible_status = true AND claim_id =cmv.claim_id AND status = ?)', [10, 'S'])
            ->select('cmv.*', 'ces.stage_id','cmv.claim_no as claimnumberformat')
            ->get();

        $claimMastermhi = DB::table('claim_eval_master_vw as cmv')
            ->join('claim_evaluation_stages as ces', 'ces.claim_id', '=', 'cmv.claim_id')
            ->where('ces.visible_status', true)
            ->where('ces.status', 'S')
            ->where('ces.stage_id', 20)
            ->whereRaw('? = (SELECT MAX(stage_id) FROM claim_evaluation_stages WHERE visible_status = true AND claim_id =cmv.claim_id AND status = ?)', [20, 'S'])
            ->select('cmv.*', 'ces.stage_id','cmv.claim_no as claimnumberformat')
            ->get();

        return view('pma.claimevaluation.claimEvaluationHome', compact(
            'auditortopma',
            'claimMasterauditor',
            'claimMastermhi',
            'claimMaster',
            'oemDetails',
            'segMaster',
            'data'
        ));
    } 
    
    // If user is MHI
    elseif (Auth::user()->hasRole('MHI')) {
        $claimMaster = DB::table('claim_eval_master_vw as cmv')
            ->join('claim_evaluation_stages as ces', 'ces.claim_id', '=', 'cmv.claim_id')
            ->where('ces.visible_status', true)
            ->where('ces.status', 'S')
            ->where('ces.stage_id', 20)
            ->whereRaw('? = (SELECT MAX(stage_id) FROM claim_evaluation_stages WHERE visible_status = true AND claim_id =cmv.claim_id AND status = ?)', [20, 'S'])
            ->select('cmv.*', 'ces.stage_id','cmv.claim_no as claimnumberformat')
            ->get();
            $claimMaster1 = DB::table('claim_eval_master_vw as cmv')
            ->join('claim_evaluation_stages as ces', 'ces.claim_id', '=', 'cmv.claim_id')
            ->where('ces.visible_status', true)
            ->where('ces.status', 'S')
            ->where('ces.stage_id', 30)
            ->whereRaw('? = (SELECT MAX(stage_id) FROM claim_evaluation_stages WHERE visible_status = true AND claim_id =cmv.claim_id AND status = ?)', [30, 'S'])
            ->select('cmv.*', 'ces.stage_id','cmv.claim_no as claimnumberformat')
            ->get();
        return view('pma.claimevaluation.AuditorEvaluationHome', compact('claimMaster1','claimMaster', 'oemDetails', 'segMaster'));
    }
}


    public function search($oem_user_id, $segm)
    {

        ini_set('memory_limit', '8048M');
        ini_set('max_execution_time', 8600);
        $seg = DB::table('segment_master')->where('id', $segm)->first('segment_name');
        $oemDetails = DB::table('oem_ev_summary')
            ->select('oem_id', 'oem_name')
            ->orderby('oem_name')
            ->groupBy('oem_id', 'oem_name')
            ->get();
        $segMaster = DB::table('segment_master')->pluck('segment_name', 'id', 'segMaster');

        if (Auth::user()->hasRole('PMA')) {
            $claimMaster = DB::table('claim_master_view')
                ->whereNotNull('lot_id')
                ->whereNotNull('pma_process_at')
                ->wherenull('pma_claim_submitted_at')
                ->where('oem_id', $oem_user_id)->where('segment_name', $seg->segment_name)->get();
        } elseif (Auth::user()->hasRole('AUDITOR')) {
            $data = DB::table('claim_evaluation_stages')
                ->select('claim_id')
                ->where('visible_status', '1')
                ->where('status', 'S')
                ->groupBy('claim_id')
                ->pluck('claim_id');
            $claimMaster = DB::table('claim_master_view')
                ->where('oem_id', $oem_user_id)
                ->whereIn('claim_id', $data)
                ->where('segment_name', $seg->segment_name)->get();
        } elseif (Auth::user()->hasRole('MHI-AS|MHI-DS')) {
            $claimMaster = DB::table('claim_master_view')->whereNotNull('lot_id')->whereNotNull('pma_process_at')->whereNotNull('pma_claim_submitted_at')->wherenull('mhi_claim_submitted_at')->where('oem_id', $oem_user_id)->where('segment_name', $seg->segment_name)->get();
        }
        return view('pma.claimevaluation.claimEvaluationHome', compact('claimMaster', 'oemDetails', 'segMaster', 'oem_user_id', 'segm'));
    }


    public function buyDetailView($claimId)
    {
        $claimId = decrypt($claimId);
        $stage = DB::table('claim_evaluation_stages')
            ->where('visible_status', '1')
            ->where('claim_id', $claimId)
            ->get();

        $uploadedFiles = DB::table('claim_evaluation_doc_mapping')->where('claim_id', $claimId)->get();
        $auditors = DB::table('users as u')
            ->join('model_has_roles as mhr', 'mhr.model_id', '=', 'u.id')
            ->join('roles as r', 'r.id', '=', 'mhr.role_id')
            ->where('r.id', 9)
            ->select('u.*', 'r.name as role_name')
            ->get();

        if (count($stage) > 0) {
            $buyerDetails = DB::table('claim_evaluation_summary_vw')->where('claim_id', $claimId)
            ->selectRaw('claim_evaluation_summary_vw.*, 1 as page_type')
                ->orderby('vin_chassis_no')
                ->get();
            $remarks = DB::table('remarks')->get();
            $pmaStatus = DB::table('claim_evaluation_status')->get();
        } else {
            $buyerDetails = DB::table('tblclaimvahanresult_vw')
    ->where('claim_id', $claimId)
    ->selectRaw('tblclaimvahanresult_vw.*, 2 as page_type')
    ->get();
            $remarks = DB::table('remarks')->get();
            $pmaStatus = DB::table('claim_evaluation_status')
                ->get();
        }
        return view('pma.claimevaluation.buyDetail', compact('uploadedFiles', 'stage', 'buyerDetails', 'remarks', 'pmaStatus', 'claimId', 'auditors'));
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
    public function store(Request $request) {}

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
    public function update(Request $request, $claim_id)
    {
    //    dd($request);
        $claim_id = decrypt($claim_id);

        try {
            $stage_id = $this->getStageIdByRole(Auth::user());
            $claim_stage = DB::table('claim_evaluation_stages')
                ->where('stage_id', $stage_id)
                ->where('status', 'D')
                ->where('claim_id', $claim_id)
                ->get();

            if ($request->hasFile('excel_file')) {
                $compareExcelHeadings = $this->compareExcelHeadings($request);
                // dd($compareExcelHeadings);
                $data = $this->handleExcelUpload($request);
                $matchingData = $this->compareExcelDataWithDatabase($data, $claim_id); // SAFE NOW
                $this->insertOrUpdateClaimApprovalRecords($matchingData, $claim_id, $stage_id, $request);
                alert()->success('The data has been successfully updated.', 'Success')->persistent('Close');
                return redirect()->back();
            }
            if (count($claim_stage) > 0) {
                $this->UpdateClaimApprovalRecords($request, $claim_id, $stage_id);
                alert()->success('The data has been successfully updated.', 'Success')->persistent('Close');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            alert()->error('Excel validation failed: ' . $e->getMessage(), 'Validation Error')->persistent('Close');
            return redirect()->back();
        }
        try {

            DB::transaction(function () use ($claim_id, $stage_id, $request) {
                $evl_stage_id = DB::table('claim_evaluation_stages')->insertGetId([
                    'claim_id'        => $claim_id,
                    'stage_id'        => $stage_id,
                    'status'          => 'D',
                    'visible_status'  => 1,
                    'revert_remarks'  => $request->remarks,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
                $evlvahan_data = DB::table('claim_evaluation_data')
                    ->where('claim_id', $claim_id)
                    ->get();
                $evldataExists = count($evlvahan_data) > 0;
                foreach ($request->data as $item) {
                    $status = explode('|', $item['pma_status']);
                    $remark_ids = [];
                    $remarks_text = [];
                    if (isset($item['pma_remark'])) {
                        foreach ($item['pma_remark'] as $rem) {
                            [$rid, $remk] = explode('|', $rem);
                            $remark_ids[] = $rid;
                            $remarks_text[] = trim($remk);
                        }
                    }
                    $rem_id = isset($remk) ? json_encode($remark_ids) : null;
                    $remk = isset($remk) ? implode(', ', $remarks_text) : null;

                    $vahan_data = DB::table('tblclaimvahanresult')
                        ->where('claim_id', $claim_id)
                        ->where('s_no', $item['sno'])
                        ->first();
                    if (!$evldataExists) {
                        DB::table('claim_evaluation_data')->insert([
                            'claim_id'           => $vahan_data->claim_id,
                            'claim_no'           => $vahan_data->claim_no,
                            's_no'               => $vahan_data->s_no,
                            'vehicle_segment'    => $vahan_data->vehicle_segment,
                            'vin_chassis_no'     => $vahan_data->vin_chassis_no,
                            'approved_incentive' => $vahan_data->approved_incentive,
                            'eligible_incentive' => $vahan_data->eligible_incentive,
                            'oemname'            => $vahan_data->oemname,
                            'oem_id'             => $vahan_data->oem_id,
                            'remark'             => $vahan_data->remark,
                            'status'             => $vahan_data->status,
                            'created_at'         => now(),
                            'updated_at'         => now(),
                        ]);
                    }
                    if ($vahan_data) {
                        DB::table('claim_approval_records')->insert([
                            'claim_id'        => $claim_id,
                            'vin_chassis_no'  => $vahan_data->vin_chassis_no,
                            's_no'            => $item['sno'],
                            'oem_id'          => $vahan_data->oem_id,
                            'evl_stage_id'    => $evl_stage_id,
                            'amount'          => $item['approved_amt'],
                            'rejected_amount' => $item['rejected_amt'],
                            'withheld_amount' => $item['withheld_amt'],
                            'evl_status_id'   => $status[0],
                            'remarks_id'      => $rem_id,
                            'remarks'         => $remk,
                            'visible_status'  => 1,
                            'created_at'      => now(),
                            'updated_at'      => now(),
                        ]);
                    } else {
                        Log::warning("No Vahan data found for claim_id {$claim_id} and s_no {$item['sno']}");
                        throw new \Exception("Missing Vahan data for claim_id {$claim_id} and s_no {$item['sno']}");
                    }
                }
            });

            alert()->success('The data has been successfully updated.', 'Success')->persistent('Close');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Error updating claim data: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to update claim data. Please try again later.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    public function UpdateClaimApprovalRecords($request, $claim_id, $stage_id)
    {
        // Retrieve existing claim evaluation stage
        $evl_stage = DB::table('claim_evaluation_stages')
            ->where('claim_id', $claim_id)
            ->where('stage_id', $stage_id)
            ->first();
        // Retrieve existing claim evaluation data for the claim_id
        $evlvahan_data = DB::table('claim_evaluation_data')
            ->where('claim_id', $claim_id)
            ->get();

        $evldataExists = count($evlvahan_data) > 0;
        foreach ($request->data as $item) {
            // Parse PMA status and remarks
            $status = explode('|', $item['pma_status']);
            $remark_ids = [];
            $remarks_text = [];

            // Prepare remarks data for the current item
            if (!empty($item['pma_remark'])) {
                foreach ($item['pma_remark'] as $rem) {
                    [$rid, $remk] = explode('|', $rem);
                    $remark_ids[] = $rid;
                    $remarks_text[] = trim($remk);
                }

                // Encode remark IDs and concatenate remarks text for the current item
                $rem_id = json_encode($remark_ids);  // Store remark IDs as JSON
                $remk = implode(', ', $remarks_text); // Concatenate remarks text
            }

            // Get Vahan data for the current item
            $vahan_data = DB::table('tblclaimvahanresult')
                ->where('claim_id', $claim_id)
                ->where('s_no', $item['sno'])
                ->first();

            if (!$vahan_data) {
                Log::warning("No Vahan data found for claim_id {$claim_id} and s_no {$item['sno']}");
                throw new \Exception("Missing Vahan data for claim_id {$claim_id} and s_no {$item['sno']}");
            }

            // Check if the record exists in claim_approval_records
            $existingApprovalRecord = DB::table('claim_approval_records')
                ->where('claim_id', $claim_id)
                ->where('vin_chassis_no', $vahan_data->vin_chassis_no)
                ->where('s_no', $item['sno'])
                ->where('evl_stage_id', $evl_stage->id)
                ->first();


                   DB::table('claim_evaluation_stages')
                    ->where('claim_id', $claim_id)
                    ->where('id',$evl_stage->id)
                    ->update([
                        'revert_remarks' => $request->remarks,
                        'updated_at' => now(),
                    ]);
            if ($existingApprovalRecord) {
                // Prepare the update data
                $updateData = [
                    'amount'        => $item['approved_amt'],
                    'rejected_amount' => $item['rejected_amt'],
                    'withheld_amount' => $item['withheld_amt'],
                    'evl_status_id' => $status[0],
                    'updated_at'    => now(),
                ];

                // Only update remarks if it's not null or empty
                if (!empty($remk)) {
                    $updateData['remarks'] = $remk;
                    $updateData['remarks_id'] = $rem_id;
                }

                // Perform the update
                DB::table('claim_approval_records')
                    ->where('id', $existingApprovalRecord->id)
                    ->update($updateData);

                 

                $remk = null;
                $rem_id = null;
            } else {
                // Log a warning if no record exists for this VIN and S No
                Log::warning("No claim approval record found for claim_id {$claim_id}, vin_chassis_no {$vahan_data->vin_chassis_no}, and s_no {$item['sno']}");
            }

            // Update claim_evaluation_data if it exists
            if ($evldataExists) {
                DB::table('claim_evaluation_data')
                    ->where('claim_id', $claim_id)
                    ->where('vin_chassis_no', $vahan_data->vin_chassis_no)
                    ->update([
                        'updated_at' => now(),
                    ]);
            } else {
                // Log a warning if claim_evaluation_data doesn't exist for the given claim_id and vin_chassis_no
                Log::warning("No claim_evaluation_data record found for claim_id {$claim_id}, vin_chassis_no {$vahan_data->vin_chassis_no}");
            }
        }
    }


    public function insertOrUpdateClaimApprovalRecords($matchingData, $claim_id, $stage_id, $request)
    {
       
        DB::beginTransaction(); // Begin the transaction

        try {
            // Check if there are any existing records for this claim and stage
            $existingEvlData = DB::table('claim_evaluation_stages')
                ->where('claim_id', $claim_id)
                ->where('stage_id', $stage_id)
                ->first();  // Use first() instead of get() to retrieve a single result

            // If records exist, delete them
            if ($existingEvlData) {
                DB::table('claim_approval_records')
                    ->where('claim_id', $claim_id)
                    ->where('evl_stage_id', $existingEvlData->id)
                    ->delete();
                DB::table('claim_evaluation_doc_mapping')
                    ->where('claim_id', $claim_id)
                    ->where('evl_stage_id', $existingEvlData->id)
                    ->delete();

                DB::table('claim_evaluation_stages')
                    ->where('claim_id', $claim_id)
                    ->where('stage_id', $stage_id)
                    ->delete();
            }


            // Insert the new stage data into claim_evaluation_stages
            $evl_stage_id = DB::table('claim_evaluation_stages')->insertGetId([
                'claim_id'       => $claim_id,
                'stage_id'       => $stage_id,
                'status'         => 'D',
                'visible_status' => 1,
                'revert_remarks' => $request->remarks,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            if ($request->hasFile('excel_file')) {
                $file = $request->excel_file;
                $response = uploadFileWithCurl($file);
                $uploaded_doc_id = $response;
                $fileName = $file->getClientOriginalName();
                $this->insertClaimEvaluationDocMapping($claim_id, $evl_stage_id, $uploaded_doc_id, $fileName);
            }

            if ($request->hasFile('additional_files')) {
                foreach ($request->file('additional_files') as $file) {
                    $response = uploadFileWithCurl($file);
                    $uploaded_doc_id = $response;
                    $fileName = $file->getClientOriginalName();
                    $this->insertClaimEvaluationDocMapping($claim_id, $evl_stage_id, $uploaded_doc_id, $fileName);
                }
            }

            $approvalData = [];

            foreach ($matchingData as $row) {

                $vin = trim($row[3]);
                $excelSerialDate  = trim($row[12]);
                $unixTimestamp = ($excelSerialDate - 25569) * 86400; // 86400 is the number of seconds in a day
                $formattedDate = date('Y-m-d', $unixTimestamp);
                $rawIds = trim($row[11]); // e.g., "1,2"
                $idArray = explode(',', $rawIds); // ['1', '2']
                $jsonIds = json_encode($idArray);
                $data_vin = DB::table('claim_evaluation_data')
                    ->where('vin_chassis_no', $vin)
                    ->first();

                if (!$data_vin) {
                    // If VIN is not found in claim_evaluation_data, throw an exception
                    throw new \Exception("VIN '{$vin}' not found in Database.");
                }
                // Add data to the approvalData array
                $approvalData[] = [
                    'claim_id'        => $claim_id,
                    'vin_chassis_no'  => $vin,
                    's_no'            => $data_vin->s_no,
                    'oem_id'          => $data_vin->oem_id,
                    'evl_stage_id'    => $evl_stage_id,
                    'amount'          => $row[6],
                    'rejected_amount' => $row[7],
                    'withheld_amount' => $row[8],
                    'evl_status_id'   => $row['evl_status_id'],
                    'remarks_id'      => $jsonIds,
                    'remarks'         => $row[10],
                    'date_of_payment'  => $formattedDate,
                    'visible_status'  => 1,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }


            // Insert all approval records in one batch
            DB::table('claim_approval_records')->insert($approvalData);


            // Commit the transaction if everything is successful
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            DB::rollBack();

            // Log the error for debugging
            Log::error("Error in insertOrUpdateClaimApprovalRecords: " . $e->getMessage());

            // Rethrow the exception so the calling method can catch and alert
            throw new \Exception("Failed to insert approval records: " . $e->getMessage());
        }
    }


    public function compareExcelDataWithDatabase($data, $claim_id)
    {
        // Fetch VINs and index them in uppercase
        $evlvahan_data = DB::table('claim_evaluation_data')
            ->select('vin_chassis_no')
            ->where('claim_id', '=', $claim_id)
            ->get()
            ->mapWithKeys(function ($item) {
                return [strtoupper(trim($item->vin_chassis_no)) => true];
            });

        // Row count match validation
        if (count($data) !== $evlvahan_data->count()) {
            throw new \Exception('Row count in Excel does not match records in the database.');
        }

        $validatedRows = [];

        foreach ($data as $index => $row) {
            $rowNumber = $index + 2;
            $vin = strtoupper(trim($row[3] ?? ''));

            if (!isset($evlvahan_data[$vin])) {
                throw new \Exception("VIN '{$vin}' not found in database at row {$rowNumber}.");
            }

            $statusText = strtoupper(trim($row[9] ?? ''));
            switch ($statusText) {
                case 'MAYBE APPROVED':
                    $evl_status_id = 1;
                    break;
                case 'MAYBE REJECTED':
                    $evl_status_id = 2;
                    break;
                case 'MAYBE WITHHELD':
                    $evl_status_id = 3;
                    break;
                default:
                    throw new \Exception("Invalid evaluation status '{$statusText}' at row {$rowNumber}.");
            }

            $row['evl_status_id'] = $evl_status_id;
            $validatedRows[] = $row;
        }

        return $validatedRows;
    }

    public function handleExcelUpload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        // Extract data from the Excel file
        $data = Excel::toArray([], $request->file('excel_file'))[0];
        unset($data[0]); // Remove header row

        return $data; // Return the data to the next step
    }

    private function getStageIdByRole($user)
    {

      
        if ($user->hasRole('PMA')) {
            return 1;
        } elseif ($user->hasRole('AUDITOR')) {
            return 10;
        } elseif ($user->hasRole('MHI')) {
            return 30;
        }

        return null; // Default case if no role matches
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

    public function claimsubmit($claimid, $auditor_id, Request $request)
    {
        $stage_id = $this->getStageIdByRole(Auth::user());

        $workflow_stages = DB::table('workflow_stages')->where('stage_order', $stage_id)->first();
        $evl_stage = DB::table('claim_evaluation_stages')
            ->where('claim_id', $claimid)
            ->where('stage_id', $stage_id)
            ->first();
        if ($auditor_id == 0) {
            $auditor_id = null;
        }
        DB::table('claim_evaluation_stages')
            ->where('id', $evl_stage->id)
            ->update([
                'status'     => 'S',
                'auditor_id' => $auditor_id,
                'updated_at' => now(),
            ]);
        alert()->success('The data has been ' . $workflow_stages->forward_status . ' successfully.', 'Success')->persistent('Close');

        return redirect()->back();
    }

    public function claimstagesubmit($claimid, $stage_id, Request $request)
    {
       
        if ($stage_id == 'R') {
            // $workflow_stages = DB::table('workflow_stages')->where('stage_order', $stage_id)->first();
            $evl_stage_id = DB::table('claim_evaluation_stages')->insertGetId([
                'claim_id'        => $claimid,
                'stage_id'        => 20,
                'status'          => 'S',
                'visible_status'  => 0,
                'revert_remarks'  => $request->remarks,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
            DB::table('claim_evaluation_stages')
                ->where('stage_id', '!=', '1')
                ->where('claim_id', $claimid)
                ->update([
                    'visible_status'  => 0,
                    'updated_at' => now(),
                ]);
            // alert()->success('Data Have been Submitted ', 'Success')->persistent('Close');
            return redirect()->back();
        }else{
      
        $workflow_stages = DB::table('workflow_stages')->where('stage_order', $stage_id)->first();
        $evl_stage = DB::table('claim_evaluation_stages')
            ->where('claim_id', $claimid)
            ->where('stage_id', $stage_id)
            ->first();

             


            //   $stage_id = $this->getStageIdByRole(Auth::user());
        $evl_stage_id = DB::table('claim_evaluation_stages')->insertGetId([
            'claim_id'        => $claimid,
            'stage_id'        => $stage_id,
            'status'          => 'S',
            'visible_status'  => 1,
            'revert_remarks'  => $request->remarks,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        if ($request->hasFile('additional_files')) {
            foreach ($request->file('additional_files') as $file) {
                $response = uploadFileWithCurl($file);
                $uploaded_doc_id = $response;
                $fileName = $file->getClientOriginalName();
                $this->insertClaimEvaluationDocMapping($claimid, $evl_stage_id, $uploaded_doc_id, $fileName);
            }
        }
        // if ($request->hasFile('excel_file')) {
        //         $compareExcelHeadings = $this->compareExcelHeadings($request);
        //         $data = $this->handleExcelUpload($request);
        //         $matchingData = $this->compareExcelDataWithDatabase($data, $claimid); // SAFE NOW
        //         $this->insertOrUpdateClaimApprovalRecords($matchingData, $claimid, $stage_id, $request);
        //         alert()->success('Excel file uploaded and processed successfully.', 'Success')->persistent('Close');
        //         return redirect()->back();
        //     }

    }
        // alert()->success('Data Have been Submitted ' . $workflow_stages->forward_status . '.', 'Success')->persistent('Close');
        return redirect()->back();
    }


    public function compareExcelHeadings(Request $request)
    {
        // Path to your static Excel file
        $staticFilePath = public_path('docs/claim_evl_format/claim_evl_format.xlsx');  // Update the extension if required

        // Check if static file exists
        if (!File::exists($staticFilePath)) {
            throw new \Exception('Static Excel file not found.');
        }

        // Get the uploaded file from the request
        $uploadedFile = $request->file('excel_file');  // File from the request

        // Validate that the uploaded file is a valid Excel file
        if (!$uploadedFile->isValid()) {
            throw new \Exception('Uploaded file is not valid.');
        }

        // Extract headers from the static Excel file
        $staticHeaders = $this->getExcelHeaders($staticFilePath);

        // Extract headers from the uploaded Excel file
        $uploadedFileHeaders = $this->getExcelHeaders($uploadedFile);
        // Trim spaces from both headers before comparing
        $staticHeaders = array_map('trim', $staticHeaders);
        $uploadedFileHeaders = array_map('trim', $uploadedFileHeaders);

        // Compare the headers
        $areHeadersEqual = $staticHeaders === $uploadedFileHeaders;

        if ($areHeadersEqual) {
            return response()->json(['message' => 'Excel headings match!']);
        } else {
            throw new \Exception('Excel headings do not match.');
        }
    }

    // Helper function to extract headers from an Excel file
    protected function getExcelHeaders($file)
    {
        // If the file is a string (path), we will use Excel::toArray() method
        if (is_string($file)) {
            return Excel::toArray([], $file)[0][0];  // Get the first sheet's first row as headers
        }

        // If the file is an uploaded file (i.e., $file is an instance of UploadedFile)
        return Excel::toArray([], $file)[0][0];  // Get the first sheet's first row as headers
    }

    private function getStageIdcheck($claim_id, $stage_id)
    {
        $getStageIdcheck = DB::table('claim_evaluation_stages')
            ->where('claim_id', $claim_id)
            ->where('stage_id', $stage_id)
            ->where('status', 'S')
            ->get();
        if (count($getStageIdcheck)) {
            return  true;
        } else {
            return false;
        }
    }

    private function insertClaimEvaluationDocMapping($claim_id, $evl_stage_id, $uploaded_doc_id, $fileName)
    {
        DB::table('claim_evaluation_doc_mapping')->insert([
            'claim_id' => $claim_id,
            'evl_stage_id' => $evl_stage_id,
            'doc_id' => 1,
            'upload_id' => $uploaded_doc_id,
            'doc_name' => $fileName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
