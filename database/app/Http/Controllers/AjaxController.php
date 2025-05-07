<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;

class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function pincodedetail($pincode)
    {

        $state = DB::table('pincodecitystate')->where('pincode', $pincode)->orderBy('pincode')->get()->pluck('state');

        if (count($state) > 0) {
            $city = DB::table('pincodecitystate')->where('pincode', $pincode)->distinct('city')->pluck('city');
            $district = DB::table('statedistrict')->where('state', $state[0])->pluck('district');

            $arr = array(
                'state' => $state,
                'city' => $district,
                'district' => $city,
            );
            // dd($arr);
            return json_encode($arr);
        } else {

            return json_encode($state);
        }
    }

    public function downloadfile($id)
    {
        $id = decrypt($id);
        // dd($id);
        downloadFile($id);

        // try {
        // $maxId = DB::table('document_uploads as a')->max('id');

        // if ((strlen($id)) > strlen($maxId)) {
        //     $ids = decrypt($id);
        // } else {
        //     $ids = $id;
        // }

        // $doc = DB::table('document_uploads as a')->join('document_master as dm', 'dm.doc_id', '=', 'a.doc_id')->where('a.id', $ids)->select('a.*', 'dm.doc_type')->first();

        //     $doc = DB::table('document_uploads as a')->where('a.id', $id)->select('a.*')->first();
        //     // dd($doc);
        //     ob_start();
        //     fpassthru($doc->uploaded_file);
        //     $docc = ob_get_contents();
        //     ob_end_clean();
        //     $ext = '';
        //     if ($doc->mime == "application/pdf") {

        //         $ext = 'pdf';

        //     } elseif ($doc->mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {

        //         $ext = 'docx';

        //     } elseif ($doc->mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {

        //         $ext = 'xlsx';

        //     } elseif ($doc->mime == 'application/vnd.ms-excel') {
        //         $ext = 'xls';
        //     } elseif ($doc->mime == 'application/vnd.ms-excel') {
        //         $ext = 'xlsx';
        //     } elseif ($doc->mime == "image/png") {
        //         $ext = 'png';
        //     }elseif ($doc->mime == "image/jpeg") {
        //         $ext = 'jpeg';
        //     }elseif ($doc->mime == "image/jpg") {
        //         $ext = 'jpg';
        //     }

        //     $doc_name = $doc->file_name;


        //     return response($docc)

        //         ->header('Cache-Control', 'no-cache private')

        //         ->header('Content-Description', 'File Transfer')

        //         ->header('Content-Type', $doc->mime)

        //         ->header('Content-length', strlen($docc))

        //         ->header('Content-Disposition', 'attachment; filename=' . $doc_name . '.' . $ext)

        //         ->header('Content-Transfer-Encoding', 'binary');
        // } catch (Exception $e) {
        //     alert()->error('File not available. Please try Again', 'Attention!')->persistent('Close');
        //     return redirect()->back();
        // }

    }
    public function checkEmail(Request $request)
    {
        $email = strtolower($request->input('email'));

        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function get_modelName($data, $id)
    {
        // return $data;
        $data = decrypt($data);
        if (!empty($data)) {
            $options = '<option selected disabled value="">Choose...</option>'; // Default option
            $modelMaster = DB::table('model_master')->where('segment_id', $data)->where('oem_id', $id)->get();
            if (count($modelMaster) > 0) {
                foreach ($modelMaster as $category) {
                    $options .= '<option value="' . encrypt($category->id) . '">' . $category->model_name . '</option>';
                }
            } else {
                $options .= '<option value="" disabled>No Data Available</option>';
            }
        }
        return $options;
    }


}