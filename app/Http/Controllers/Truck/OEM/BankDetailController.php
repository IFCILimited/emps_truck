<?php


namespace App\Http\Controllers\Truck\OEM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostRegistrationDetail;
use Auth;
use App\Models\User;
use DB;
use Exception;
use App\Models\TempBankDetail;

class BankDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $bankDetail = PostRegistrationDetail::where('user_id', Auth::user()->id)->first();

            $tempBankDetail = TempBankDetail::where('user_id', Auth::user()->id)->first();

            return view('truck.oem.bank_detail.bankDetails', compact('bankDetail', 'tempBankDetail'));
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
        try {
            DB::transaction(function () use ($request) {
                $bankcheck = TempBankDetail::where('user_id',Auth::user()->id)->first();
                // dd($bankcheck);
                if($bankcheck == null){
                $bankdetail = new TempBankDetail;
                $bankdetail->user_id = Auth::user()->id;
                $bankdetail->ifsc_code = $request->ifsc_code;
                $bankdetail->account_holder_name = $request->account_holder_name;
                $bankdetail->bank_name = $request->bank_name;
                $bankdetail->branch_name = $request->branch_name;
                $bankdetail->branch_address = $request->bank_address;
                $bankdetail->branch_city = $request->branch_city;
                $bankdetail->account_no = $request->account_number;
                $bankdetail->micr_code = $request->micr_code;
                $bankdetail->account_type = $request->account_type;
                $bankdetail->branch_pincode = $request->branch_pincode;
                $bankdetail->branch_state = $request->branch_state;
                $bankdetail->branch_district = $request->branch_district;
                $bankdetail->Status = '1';
                $bankdetail->save();
                }
                else {
                    return redirect()->route('e-trucks.bankDetails.index')->with('success', 'No bank check was performed.');
                }
                
            });
            alert()->success('Data has been successfully Saved', 'Success')->persistent('Close');

            return redirect()->route('e-trucks.bankDetails.index');
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
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
        try {
            $id = decrypt($id);
            $bankDetail = PostRegistrationDetail::where('id', $id)->first();
            return view('truck.oem.bank_detail.bankDetailsEdit', compact('bankDetail'));
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
