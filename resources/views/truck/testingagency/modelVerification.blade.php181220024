   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - Model Verification
   @endsection

   @push('styles')
   @endpush
   @section('content')
       <!-- Page Sidebar Ends-->
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4>Model Verification</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage Model</li>
                               <li class="breadcrumb-item active">Model Verification</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <!-- Container-fluid starts-->
           <div class="container-fluid">
               <div class="row">



                   <div class="col-sm-12">
                       <form action="{{route('modelRequests.store')}}" id="plant" role="form" 
                       method="POST" class='form-horizontal modelVer prevent-multiple-submit' files=true
                           enctype='multipart/form-data' accept-charset="utf-8">
                           @csrf
                           {{-- {!! method_field('patch') !!} --}}
                           <div class="card">
                               {{-- <div class="card-header pb-0 card-no-border">
                    <h4>HTML5 Export Buttons</h4>
                  </div> --}}
                    {{-- <input type="hidden" name="oem_id" value="{{$id['oem_id']}}">
                    <input type="hidden" name="model_id" value="{{$id['model_id']}}">
                    <input type="hidden" name="oem_name" value="Tvs Motor Company Limited"> --}}
                               <div class="card-body">
                                   <div class="row g-3">
                                       <div class="col-4 offset-4">
                                           <h5><b>Filled By OEM's</b></h5>
                                       </div>
                                       <div class="col-4">
                                           <h5><b>To be Filled by Testing Agency</b></h5>
                                       </div>
                                       <div class="col-4">
                                           <p><b>Testing Agency:*</b></p>
                                       </div>
                                       <div class="col-4">
                                            <h5>{{$testing_agency_name}}</h5>
                                        </div>
                                        <div class="col-4">
                                           
                                            <input type="text" readonly class="form-control readonly" value="{{$testing_agency_name}}">

                                        </div>
                                        <div class="col-4">
                                            <p><b>OEM Name:* </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>  {{$model->oem_name}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" readonly class="form-control readonly" value="{{$model->oem_name}}">
                                         </div>

                                         <div class="col-4">
                                            <p><b>xEV Model Name:* </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>  {{$model->model_name}} </h5>
                                         </div>
                                         <div class="col-4">
                                             <input type="text" readonly class="form-control readonly" value="{{$model->model_name}}">
                                         </div>


                                         <div class="col-4">
                                            <p><b>Variant Name:* </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5> {{$model->variant_name}}</h5>
                                         </div>
                                         <div class="col-4">
                                             <input type="text" readonly class="form-control readonly" value="{{$model->variant_name}}">
                                         </div>

                                         <div class="col-4">
                                            <p><b>Vehicle Segment:* </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->segment}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" class="form-control readonly" readonly
                                            value="{{ $model->segment }}">
                                         </div>

                                         <div class="col-4">
                                            <p><b>Vehicle Category (as per CMVR):* </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->vehicle_cat}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" class="form-control readonly" readonly
                                            value="{{ $model->vehicle_cat }}">
                                         </div>
                                         

                                         <div class="col-4">
                                            <p><b>Technology Type (xEV Type):* </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->tech_type}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" class="form-control readonly" readonly
                                               value="{{ $model->tech_type }}">
                                         </div>
                                         
                                         <div class="col-4">
                                            <p><b>Ex-Factory Price (INR):*  </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5> {{$model->factory_price}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" class="form-control" name="factory_price" value="{{$model->factory_price}}">
                                         </div>
                                        
                                         <div class="col-4">
                                            <p><b>Specific Density (Wh/Kg):*</b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->spec_density}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" class="form-control" name="spec_density" value="{{$model->spec_density}}">
                                         </div>
                                         
                                         <div class="col-4">
                                            <p><b>Life Cycle (No. of Cycles):* </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->life_cyc}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" class="form-control" name="life_cyc" value="{{$model->life_cyc}}">
                                         </div>

                                         <div class="col-4">
                                            <p><b>No. of Batteries Required for Vehicle Propulsion:* </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->no_of_battery}}</h5>
                                         </div>
                                         <div class="col-4">
                                             
                                             <input type="text" class="form-control readonly" readonly name="" value="{{$model->no_of_battery}}">

                                         </div>

                                         <div class="col-4">
                                            <p><b>Total Energy xEV Capacity (kWh):*  </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5> {{$model->tot_energy}}</h5>
                                         </div>
                                         <div class="col-4">
                                             <input type="text" readonly class="form-control readonly" value=" {{$model->tot_energy}}">
                                         </div>
                                         
                                         <div class="col-4">
                                            <p><b>Minimum Ex-Showroom Price (INR) across the Country:*</b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->min_ex_show_price}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" class="form-control" name="min_ex_show_price" value="{{$model->min_ex_show_price}}">
                                         </div>
                                         
                                         <div class="col-4">
                                            <p><b>Estimated Incentive Amount (INR):* </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->estimate_incentive_amount}}</h5>
                                         </div>
                                         <div class="col-4">
                                             <input type="text" readonly class="form-control readonly" value="{{$model->estimate_incentive_amount}}">
                                         </div>

                                         <div class="col-4">
                                            <p><b>Monitoring Device Fitment (Make & ID):*  </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->monitoring_device_fitment}}</h5>
                                         </div>
                                         <div class="col-4">

                                            <input type="text" class="form-control readonly" readonly name="" value="{{$model->monitoring_device_fitment}}">
                                         </div>

                                         <div class="col-4">
                                            <p><b>Range (Km):*  </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->range}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" class="form-control" name="range" value="{{$model->range}}">
                                         </div>
                                         
                                         
                                         <div class="col-4">
                                            <p><b>Maximum Electric Energy Consumption (kWh/100 Km):*   </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->max_elect_consumption}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" class="form-control" name="max_elect_consumption" value="{{$model->max_elect_consumption}}">
                                         </div>
                                         
                                         <div class="col-4">
                                            <p><b>MinimumMax Speed (Km/Hr):* </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->min_max_speed}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" name="min_max_speed" class="form-control" value="{{$model->min_max_speed}}">
                                         </div>
                                         
                                         <div class="col-4">
                                            <p><b>Minimum Acceleration (m/s2):*  </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->min_acceleration}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="text" class="form-control" name="min_acceleration" value="{{$model->min_acceleration}}">
                                         </div>

                                         

                                         <div class="col-4">
                                            <p><b>Meeting xEV Technology Function:*  </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->meeting_tech_function}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <select id="" class="form-select" name="meeting_tech_function">
                                                <option>Select</option>
                                                <option value="Y" {{($model->meeting_tech_function == 'Y')?'selected':''}}>Yes</option>
                                                <option value="N" {{($model->meeting_tech_function == 'N')?'selected':''}}>No</option>
                                            </select>
                                         </div>

                                         <div class="col-4">
                                            <p><b>Meeting Qualification Targets:*  </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{$model->meeting_qualif}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <select  id="" class="form-select" name="meeting_qualif">
                                                <option>Select</option>
                                                <option value="Y" {{($model->meeting_qualif == 'Y')?'selected':''}}>Yes</option>
                                                <option value="N" {{($model->meeting_qualif == 'N')?'selected':''}}>No</option>
                                            </select>
                                         </div>

                                         <div class="col-4">
                                            <p><b>Date of Vehicle Submission to Test Agency for Type Approval:*   </b></p>
                                        </div>
                                        <div class="col-4">
                                             <h5>{{date('d-m-Y',strtotime($model->vehicle_sub_to_test_agency_apprv))}}</h5>
                                         </div>
                                         <div class="col-4">
                                            <input type="date"  class="form-control" name="vehicle_sub_to_test_agency_apprv" value="{{$model->vehicle_sub_to_test_agency_apprv}}">
                                         </div>

                                         <div class="col-4">
                                            <p><b>Certificate Copy:*   </b></p>
                                        </div>
                                        <div class="col-4">
                                             {{-- <h5>   <a class="mt-2 btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($model->id)) }}">
                                                <i class="fa fa-download"></i>  View Document
                                             </a>
                                            </h5> --}}
                                         </div>
                                         <div class="col-4">
                                            <input type="file" name="certificate" class="form-control" >
                                         </div>

                                         <div class="col-4">
                                            <p><b>CMVR Certificate Copy:*   </b></p>
                                        </div>
                                        <div class="col-4">
                                             {{-- <h5>   <a class="mt-2 btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($model->id)) }}">
                                                <i class="fa fa-download"></i>  View Document
                                             </a>
                                            </h5> --}}
                                         </div>
                                         <div class="col-4">
                                            <input type="file" name="cmvr_certificate" class="form-control" >
                                         </div>

                                         <div class="col-4">
                                            <p><b>Model {{ env('APP_NAME')}} Compliance Certificate Number*</b></p>
                                        </div>
                                        <div class="col-4">
                                            
                                         </div>
                                         <div class="col-4">
                                            <input type="text" name="certificate_no" class="form-control " placeholder="Enter Certificate Number">
                                         </div>

                                         <div class="col-4">
                                            <p><b> Model {{ env('APP_NAME')}} CMVR Date:*</b></p>
                                        </div>
                                        <div class="col-4">
                                            
                                         </div>
                                         <div class="col-4">
                                            <input type="date" name="cmvr_date" class="form-control " placeholder="Select CMVR Date">
                                         </div>

                                         <div class="col-4">
                                            <p><b>Model {{ env('APP_NAME')}} Compliance Certificate Approval Date:*</b></p>
                                        </div>
                                        <div class="col-4">
                                            
                                         </div>
                                         <div class="col-4">
                                            <input type="date" name="approval_date" class="form-control " placeholder="Select Approval Date">
                                         </div>
                                         <div class="col-4">
                                            <p><b>Model {{ env('APP_NAME')}} Compliance Certificate Validate from:*</b></p>
                                        </div>
                                        <div class="col-4">
 
                                         </div>
                                         <div class="col-4">
                                            <input type="date" name="valid_date" class="form-control " placeholder="Select Validate Date">
                                         </div>

                                         <div class="col-4">
                                            <p><b>Model {{ env('APP_NAME')}} Compliance Certificate Validate Upto:*</b></p>
                                        </div>
                                        <div class="col-4">
                                            
                                         </div>
                                         <div class="col-4">
                                            <input type="date" name="expiry_date" class="form-control " placeholder="Select Validate Date">
                                         </div>

                                        
                                         <div class="col-4">
                                            <p><b>PMP Compliance:*  </b></p>
                                        </div>
                                        <div class="col-4">
                                           
                                         </div>
                                         <div class="col-4">
                                            <select  id="" class="form-select" name="pmp_compliance">
                                                <option selected disabled>Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                         </div>
                                         {{-- <div class="col-4">
                                            <p><b>Name Of the Officer who inspect the Vehicle</b></p>
                                        </div>
                                        <div class="col-4">
                                         </div>
                                         <div class="col-4">
                                            <input type="text" name="inspection_officer" class="form-control " placeholder="Select Validate Date">
                                         </div>
                                         <div class="col-4">
                                            <p><b>Name Of the Officer who Apporove the Model</b></p>
                                        </div>
                                        <div class="col-4">
                                         </div>
                                         <div class="col-4">
                                            <input type="text" name="approval_officer" class="form-control " placeholder="Select Validate Date">
                                         </div>
                                         <div class="col-4">
                                            <p><b>Supplier List Checked:*  </b></p>
                                        </div>
                                        <div class="col-4">
                                           
                                         </div>
                                         <div class="col-4">
                                            <select  id="" class="form-select" name="supplier_list">
                                                <option>Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                         </div> --}}
                                          <div class="col-4">
                                            <p><b>Warranty Period :*  </b></p>
                                        </div>
                                        <div class="col-4">
                                            {{-- <input type="date" readonly name="warranty_period_from" value="{{date('d-m-Y',strtotime($model->warranty_period_from))}}" class="form-control readonly" placeholder="Select Validate Date"> --}}
                                         </div>
                                         <div class="col-4">
                                            <input type="text" readonly name="warranty_period_indicate" class="form-control readonly" value="{{ $model->warranty_period_indicate }}" placeholder="">
                                         </div>
                                         <div class="col-4">
                                            <p><b>Warranty Check:*  </b></p>
                                        </div>
                                        <div class="col-4">
                                           
                                         </div>
                                         <div class="col-4">
                                            <select  id="" class="form-select" name="warranty_check">
                                                <option selected disabled>Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                         </div>
                                         {{-- <div class="col-4">
                                            <p><b>Strip Down Analysis Carried Out:*  </b></p>
                                        </div>
                                        <div class="col-4">
                                           
                                         </div>
                                         <div class="col-4">
                                            <select  id="" class="form-select" name="strip_down_analysis">
                                                <option>Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                         </div> --}}
                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-check checkbox checkbox-secondary">
                                                <input class="form-check-input primary" id="flexCheckDefault" type="checkbox" value="" name="declaration">
                                                <label class="form-check-label" for="flexCheckDefault">Declaration : <span class="text-danger">*</span> We declare that the above information relating to vehicle testing report is correct to the best of our knowledge and belief. The above information is being provided to DHI/NAB for the purpose of availing demand incentive as per guidelines of the {{ env('APP_NAME')}}</label>
                                            </div>
                                        </div>
                                   </div>

                               </div>
                               <input type="hidden" name="oem_id" value="{{$model->oem_id}}">
                               <input type="hidden" name="model_id" value="{{$model->model_id}}">
                               <input type="hidden" name="oem_name" value="{{$model->oem_name}}">
                               <input type="hidden" name="status" value="A">
                               <input type="hidden" name="mid" value="{{$model->model_detail_id}}">
                           </div>
                           <div class="col-12 text-center">
                            <a href="{{route('modelRequests.index')}}" class="btn btn-warning">Back</a>
                            <button type="submit" class="btn btn-info btn-approve">Approve</button>
                               <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#reject">Reject</button>
                           </div>
                       </form>
                   </div>


               </div>
           </div>
           <!-- Container-fluid Ends-->
       </div>
       <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="reject" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div class="modal-toggle-wrapper"> 
                <form action="{{route('modelRequests.store')}}"  id="formReject" role="form" method="POST"
                   class='form-horizontal modelVer prevent-multiple-submit' accept-charset="utf-8" enctype='multipart/form-data' files=true>
                   @csrf
               
                   <input name="status" type="hidden" value="R">
                   <input type="hidden" name="oem_id" value="{{$model->oem_id}}">
                   <input type="hidden" name="model_id" value="{{$model->model_id}}">
                   <input type="hidden" name="oem_name" value="{{$model->oem_name}}">
                   <input type="hidden" name="mid" value="{{$model->model_detail_id}}">
                    <div class="row">
                        <div class="col-12">
                            <label>Remarks</label>
                            <textarea class="form-control" name="remarks" placeholder="Remarks"></textarea>
                        </div> 
                    </div>
                    <div class="col-12">
                        <button class="btn bg-primary mt-2 d-flex align-items-center gap-2 text-light ms-auto btnReject" type="submit">Reject<i data-feather="arrow-right"></i></button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
   @endsection
   @push('scripts')
       {!! JsValidator::formRequest('App\Http\Requests\ModelRequestEdit', '.modelVer') !!}

       @include('partials.js.pincode')
       <script>
    //   $(document).ready(function() {
    //     // Function to disable buttons
    //     function disableButtons() {
    //         $('.btn-save, .btn-approve').prop('disabled', true);
    //     }

    //     // Function to enable buttons
    //     function enableButtons() {
    //         $('.btn-save, .btn-approve').prop('disabled', false);
    //     }

    //     // Listen for click event on the Save button
    //     $('.btn-save').on('click', function() {
    //         // Set the value of the hidden input to blank
    //         $('input[name="status"]').val('');
    //         // Disable buttons to prevent multiple clicks
    //         disableButtons();
    //     });

    //     // Listen for click event on the Approve button
    //     $('.btn-approve').on('click', function() {
    //         // Set the value of the hidden input to 'A'
    //         $('input[name="status"]').val('A');
    //         // Disable buttons to prevent multiple clicks
    //         disableButtons();
    //     });

    //     // Automatically enable the buttons after 25 seconds
    //     setTimeout(function() {
    //         enableButtons();
    //     }, 20000); // 25 seconds in milliseconds
    // });
        $(document).ready(function() {
            
            function toggleButtonState() {
                var checkbox = $('#flexCheckDefault');
                var buttons = $('button[type="submit"]');
                var button = $('button[type="button"]');

                if (checkbox.prop('checked')) {
                    buttons.prop('disabled', false); 
                    button.prop('disabled', false); 
                } else {
                    buttons.prop('disabled', true); 
                    button.prop('disabled', true); 
                }
            }

           
            toggleButtonState();

           
            $('#flexCheckDefault').on('change', function() {
                toggleButtonState(); 
            });
        });
       </script>
         <script>
            $(document).ready(function() {
               $('.prevent-multiple-submit').on('submit', function() {
                   $(this).find('button[type="submit"]').prop('disabled', true);
                   var buttons = $(this).find('button[type="submit"]');
                   setTimeout(function() {
                       buttons.prop('disabled', false);
                   }, 20000); // 25 seconds in milliseconds
               });
           });
        </script>
   @endpush
r