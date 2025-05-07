<?php

namespace App\Http\Controllers;
use App\Models\FormData;
use Illuminate\Http\Request;
use Exception;
use DB;
use Auth;

class HomeFormController extends Controller
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

        try{
        $data = [
            'category' => $request->category,
            'process' => $request->process,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'feedback_msg' => $request->feedback,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('feedback')->insert($data);

        return redirect()->back();
    }
    catch(\Exception $e){
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
    public function suggestion(Request $request)
    {
        try{
            $data = [
                'category' => $request->category,
                'process' => $request->process,
                'usertype' => $request->user_type,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'suggestion_msg' => $request->suggestion,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('suggestion')->insert($data);

            return redirect()->route('suggestion');

            // return redirect()->back();
        }
        catch(\Exception $e){
            dd($e);
        }
    }
    public function model_scheme($oem_id = null)
    {
        $user = DB::table('dashboard_view')->where('rid',4)->get();
        if($oem_id == null || $oem_id == 0){

            $schemeProducts=DB::table("scheme_model")->get();
        }
        else{

            $schemeProducts=DB::table("scheme_model")->where('oem_id',$oem_id)->get();
        }
        $groupedData = [];
        foreach ($schemeProducts as $product) {
            $companyName = $product->user_name;
            if (!isset($groupedData[$companyName])) {
                $groupedData[$companyName] = [];
            }
            $groupedData[$companyName][] = [
                'model_name' => $product->model_name,
                'variant_name' => $product->variant_name,
                'segment' => $product->segment,
                'category_name' => $product->category_name,
                'estimate_incentive_amount' => $product->estimate_incentive_amount,
                'model_status' => $product->model_status,
                'testing_range' => $product->testing_range,
                'testing_min_max_speed' => $product->testing_min_max_speed,
                'testing_min_acceleration' => $product->testing_min_acceleration,
                'testing_max_elect_consumption' => $product->testing_max_elect_consumption,
                'battery_type'=>$product->battery_type,
                'battery_capacity'=>$product->battery_capacity,
                'testing_spec_density'=>$product->testing_spec_density,
                'testing_life_cyc'=>$product->testing_life_cyc,
                // ''=>$product->upload_id,
            ];
    }
    return view('landing.model',compact('groupedData','user'));
}
}
