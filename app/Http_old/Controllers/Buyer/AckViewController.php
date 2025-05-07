<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\User;
use App\Models\BuyerDetail;
use App\Models\DocumentUpload;
// use App\BuyerDetail;
class AckViewController extends Controller
{
    public function AckView($id){
        // dd($id);
        // return view('buyer.create', compact('user', 'type','oemname'));
        $user = User::where('id', Auth::user()->id)->first();
        $oemname = DB::table('users')->where('id',Auth::user()->oem_id)->first();
        $buyer = DB::table('buyer_details')->where('id',$id)->first();

        $detail = DB::table('vw_vin_details')->where('oem_id',$buyer->oem_id)->first();

        $type = DB::table('customer_doc_verf_type')->where('id',$buyer->custmr_id)->first();
        $sectype = DB::table('customer_doc_verf_type')->where('id',$buyer->addi_cust_id)->first();

        $maindata = DB::table('vw_vin_details')->where('oem_id',$buyer->oem_id)->first();

        // dd($maindata);

        return view('buyer.ackview',compact('user','oemname','detail','buyer','type','sectype','maindata'));

    }
    public function FinallSubmit($id){
        // dd($id);
        DB::transaction(function () use ($id) {

            $BuyerDetail = BuyerDetail::find($id);
            $BuyerDetail->status = 'S';
            $BuyerDetail->save();

        });
        alert()->success('Buyer Detail successfully submit')->persistent('Close');

        return redirect()->route('buyerdetail.index');


    }

    public function AckDoc($id){
        $type = DB::table('customer_doc_verf_type')->whereNotIn('id', [1])->get();
        $user = User::where('id', Auth::user()->id)->first();
        $bankDetail = DB::table('buyer_details_view as bd')
            ->where('id', $id)->first();

        $customerId = (int) $bankDetail->custmr_id;

        $oemname = DB::table('users')->where('id',Auth::user()->oem_id)->first();

        $cat = DB::table('customer_doc_verf_type')
            ->where('id', $customerId)
            ->first();
        // dd($bankDetail);

        return view('buyer.ack_doc', compact('bankDetail', 'user', 'id', 'type', 'cat','oemname'));

    }

    public function update(Request $request,$id){
        // dd($request);

        DB::transaction(function () use ($request,$id) {

            // if ($request->hasFile('cst_ack_file')) {
            //     $filecopy = $request->cst_ack_file->getClientOriginalName();
            //     $mime = $request->cst_ack_file->getMimeType();
            //     $filesize = $request->cst_ack_file->getSize();
            //     $content = fopen($request->cst_ack_file->getRealPath(), 'r');

            //     $file1 = new DocumentUpload();
            //     $file1->file_name = $filecopy;
            //     $file1->mime = $mime;
            //     $file1->file_size = $filesize;
            //     $file1->uploaded_file = $content;
            //     $file1->save();

            // }

            if ($request->hasFile('cst_ack_file')) {

                $file = $request->cst_ack_file;
                $response = uploadFileWithCurl($file);
                $file1_id = $response;

            }


            // if ($request->hasFile('invc_copy_file')) {
            //     $filecopy = $request->invc_copy_file->getClientOriginalName();
            //     $mime = $request->invc_copy_file->getMimeType();
            //     $filesize = $request->invc_copy_file->getSize();
            //     $content = fopen($request->invc_copy_file->getRealPath(), 'r');

            //     $file2 = new DocumentUpload();
            //     $file2->file_name = $filecopy;
            //     $file2->mime = $mime;
            //     $file2->file_size = $filesize;
            //     $file2->uploaded_file = $content;
            //     $file2->save();

            // }

            if ($request->hasFile('invc_copy_file')) {

                $file = $request->invc_copy_file;
                $response = uploadFileWithCurl($file);
                $file2_id = $response;

            }

            // if ($request->hasFile('vhcl_reg_file')) {
            //     $filecopy = $request->vhcl_reg_file->getClientOriginalName();
            //     $mime = $request->vhcl_reg_file->getMimeType();
            //     $filesize = $request->vhcl_reg_file->getSize();
            //     $content = fopen($request->vhcl_reg_file->getRealPath(), 'r');

            //     $file3 = new DocumentUpload();
            //     $file3->file_name = $filecopy;
            //     $file3->mime = $mime;
            //     $file3->file_size = $filesize;
            //     $file3->uploaded_file = $content;
            //     $file3->save();

            // }

            if ($request->hasFile('vhcl_reg_file')) {

                $file = $request->vhcl_reg_file;
                $response = uploadFileWithCurl($file);
                $file3_id = $response;

            }

            $BuyerDetail = BuyerDetail::find($id);
            $BuyerDetail->status = 'A';
            $BuyerDetail->cst_ack_file = $file1_id;
            $BuyerDetail->invc_copy_file = $file2_id;
            $BuyerDetail->vhcl_reg_file =$file3_id;
            $BuyerDetail->vhcl_regis_no =$request->vhcl_regis_no;
            $BuyerDetail->vihcle_dt = $request->vihcle_dt;
            $BuyerDetail->oem_status = null;
            $BuyerDetail->oem_status_at = null;
            $BuyerDetail->oem_remarks = null;
            $BuyerDetail->save();

        });
        alert()->success('Acknowledge Detail successfully submit')->persistent('Close');

        return redirect()->route('buyerdetail.index');

    }

    public function view($id){
        $type = DB::table('customer_doc_verf_type')->whereNotIn('id', [1])->get();
        $user = User::where('id', Auth::user()->id)->first();
        $bankDetail = DB::table('buyer_details_view as bd')
            ->where('id', $id)->first();

        // dd($bankDetail);

        $customerId = (int) $bankDetail->custmr_id;

        $oemname = DB::table('users')->where('oem_id',$bankDetail->oem_id)->first();

	

        $cat = DB::table('customer_doc_verf_type')
            ->where('id', $customerId)
            ->first();
        // dd($bankDetail);

        return view('buyer.view', compact('bankDetail', 'user', 'id', 'type', 'cat','oemname'));
    }


    public function OemReturn(){
        $bankDetail = DB::table('buyer_details_view')
        ->where('oem_status','R')
        ->where('dealer_id', Auth::user()->id)
        ->get();

    // dd($bankDetail);

    return view('buyer.oemreturn', compact('bankDetail'));


    }
}
