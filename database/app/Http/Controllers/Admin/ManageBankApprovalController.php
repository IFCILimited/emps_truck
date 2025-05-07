<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use DB;
use App\Models\TempBankDetail;
use App\Models\PostRegistrationDetail;
use App\Models\LogBankDetails;
use Exception;

class ManageBankApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tempBank = TempBankDetail::where('Status', 1)->get();
            return view('admin.index_manage_bank_approval', compact('tempBank'));
        } catch (Exception $e) {
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $bankDetail = TempBankDetail::where('id', $id)->where('Status', 1)->first();
            return view('admin.show_manage_bank_approval', compact('bankDetail'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
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

        $bankDetailMain = PostRegistrationDetail::where('user_id', $request->user_id_hidden)->first();

        try {
            DB::transaction(function () use ($request, $id, $bankDetailMain) {
                $logbankdetail = new LogBankDetails;
                $logbankdetail->user_id = $bankDetailMain->user_id;
                $logbankdetail->ifsc_code = $bankDetailMain->ifsc_code;
                $logbankdetail->account_holder_name = $bankDetailMain->account_holder_name;
                $logbankdetail->bank_name = $bankDetailMain->bank_name;
                $logbankdetail->branch_name = $bankDetailMain->branch_name;
                $logbankdetail->branch_address = $bankDetailMain->branch_address;
                $logbankdetail->branch_city = $bankDetailMain->branch_city;
                $logbankdetail->account_no = $bankDetailMain->account_no;
                $logbankdetail->micr_code = $bankDetailMain->micr_code;
                $logbankdetail->account_type = $bankDetailMain->account_type;
                $logbankdetail->branch_pincode = $bankDetailMain->branch_pincode;
                $logbankdetail->branch_state = $bankDetailMain->branch_state;
                $logbankdetail->branch_district = $bankDetailMain->branch_district;
                $logbankdetail->save();

                $bankdetailMain = PostRegistrationDetail::where('user_id', $request->user_id_hidden)->first();
                $bankdetailMain->user_id = $request->user_id_hidden;
                if ($request->status == 'R') {
                    $bankdetailMain->mhi_bank_status = 'R';
                    $bankdetailMain->mhi_bank_remarks = $request->mhi_bank_remarks;
                    $bankdetailMain->mhi_bank_remarks_at = date('Y-m-d H:i:s');
                    $bankdetailMain->save();
                } else {
                    $bankdetailMain->ifsc_code = $request->ifsc_code;
                    $bankdetailMain->account_holder_name = $request->account_holder_name;
                    $bankdetailMain->bank_name = $request->bank_name;
                    $bankdetailMain->branch_name = $request->branch_name;
                    $bankdetailMain->branch_address = $request->branch_address;
                    $bankdetailMain->branch_city = $request->branch_city;
                    $bankdetailMain->account_no = $request->account_no;
                    $bankdetailMain->micr_code = $request->micr_code;
                    $bankdetailMain->account_type = $request->account_type;
                    $bankdetailMain->branch_pincode = $request->branch_pincode;
                    $bankdetailMain->branch_state = $request->branch_state;
                    $bankdetailMain->branch_district = $request->branch_district;
                    $bankdetailMain->mhi_bank_status = 'A';
                    $bankdetailMain->mhi_bank_remarks = null;
                    $bankdetailMain->mhi_bank_remarks_at = date('Y-m-d H:i:s');
                    $bankdetailMain->save();
                }

                $bankDetailtemp = TempBankDetail::find($id);
                $bankDetailtemp->delete();
            });
            alert()->success('Data has been successfully saved', 'Success')->persistent('Close');

            return redirect()->route('bankApproval.index');
        } catch (Exception $e) {
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
