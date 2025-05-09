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
                <div class="col-12 p-10">
                    <a href="#" onclick="printDiv('printSection')" class="btn btn-primary mt-2" style="float:right">Download PDF</a>
                </div>
                   <div class="col-sm-12">
                       <form action="{{ route('e-trucks.manageOEMApproval.store') }}" id="plant" role="form" method="POST"
                       class='form-horizontal modelVer' files=true enctype='multipart/form-data' accept-charset="utf-8">
                       @csrf
                       {{-- {!! method_field('patch') !!} --}}
                       <div class="card">
                               {{-- <div class="card-header pb-0 card-no-border">
                    <h4>HTML5 Export Buttons</h4>
                  </div> --}}
                               {{-- <input type="hidden" name="oem_id" value="{{$id['oem_id']}}">
                    <input type="hidden" name="model_id" value="{{$id['model_id']}}">
                    <input type="hidden" name="oem_name" value="Tvs Motor Company Limited"> --}}
                               <div class="card-body" id="printSection">
                                   <div class="row g-3">
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <h5><b>Filled By OEM's</b></h5>
                                    </div>
                                    <div class="col4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <h5><b>(As per Certificate Details)</b></h5>
                                    </div>
                                    <div class="col4"></div>
                                       <div class="col-4">
                                           <p><b>Testing Agency:*</b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $testing_agency_name }}</h5>
                                       </div>
                                       <div class="col-4">
                                           {{-- <select  id="" class="form-select" disabled>
                                                <option>Select</option>
                                                <option value="icat"  selected>Icat</option>
                                            </select> --}}
                                           <input type="text" class="form-control readonly" readonly
                                               value="{{ $testing_agency_name }}">
                                       </div>
                                       <div class="col-4">
                                           <p><b>OEM Name:* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5> {{ $model->oem_name }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly class="form-control readonly"
                                               value="{{ $model->oem_name }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>xEV Model Name:* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5> {{ $model->model_name }} </h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly class="form-control readonly"
                                               value="{{ $model->model_name }}">
                                       </div>


                                       <div class="col-4">
                                           <p><b>Variant Name:* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5> {{ $model->variant_name }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly class="form-control readonly"
                                               value="{{ $model->variant_name }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>Vehicle Segment:* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->segment }}</h5>
                                       </div>
                                       <div class="col-4">

                                           <input type="text" class="form-control readonly" readonly
                                               value="{{ $model->segment }}">

                                       </div>

                                       <div class="col-4">
                                           <p><b>Vehicle Category (as per CMVR):* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->vehicle_cat }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" class="form-control readonly" readonly
                                               value="{{ $model->vehicle_cat }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>Vehicle Gross Weight</b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->gross_weight }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" class="form-control readonly" readonly
                                               value="{{ $model->gross_weight }}">
                                       </div>


                                       <div class="col-4">
                                           <p><b>Technology Type (xEV Type):* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->tech_type }}</h5>
                                       </div>
                                       <div class="col-4">

                                           <input type="text" class="form-control readonly" readonly
                                               value="{{ $model->tech_type }}">

                                       </div>

                                       <div class="col-4">
                                           <p><b>Ex-Factory Price (INR):* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5> {{ $model->factory_price }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly class="form-control readonly {{ $model->factory_price == $model->testing_factory_price ? 'readonly' : 'bg-danger' }}" name="factory_price"
                                               value="{{ $model->testing_factory_price }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>Specific Density (Wh/Kg):*</b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->spec_density }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly class="form-control readonly {{ $model->spec_density == $model->testing_spec_density ? 'readonly' : 'bg-danger' }}" name="spec_density"
                                               value="{{ $model->testing_spec_density }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>Life Cycle (No. of Cycles):* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->life_cyc }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly class="form-control readonly {{ $model->life_cyc == $model->testing_life_cyc ? 'readonly' : 'bg-danger' }}" name="life_cyc"
                                               value="{{ $model->testing_life_cyc }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>No. of Batteries Required for Vehicle Propulsion:* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->no_of_battery }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" class="form-control readonly" readonly
                                               value="{{ $model->no_of_battery }}">

                                       </div>

                                       <div class="col-4">
                                           <p><b>Total Energy xEV Capacity (kWh):* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5> {{ $model->tot_energy }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly class="form-control readonly"
                                               value=" {{ $model->tot_energy }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>Minimum Ex-Showroom Price (INR) across the Country:*</b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->min_ex_show_price }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly class="form-control readonly {{ $model->min_ex_show_price == $model->testing_min_ex_show_price ? 'readonly' : 'bg-danger' }}"
                                               name="min_ex_show_price" value="{{ $model->testing_min_ex_show_price }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>Estimated Incentive Amount (INR):* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->estimate_incentive_amount }}</h5>
                                       </div>
                                       <div class="col-4">
                                        <input type="text" readonly class="form-control readonly"
                                        value="{{ $model->testing_estimate_incentive_amount ? $model->testing_estimate_incentive_amount : $model->estimate_incentive_amount }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>Monitoring Device Fitment (Make & ID):* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->monitoring_device_fitment }}</h5>
                                       </div>
                                       <div class="col-4">

                                           <input type="text" class="form-control readonly" readonly
                                           value="{{ $model->monitoring_device_fitment }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>Range (Km):* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->range }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly class="form-control readonly {{ $model->range == $model->testing_range ? 'readonly' : 'bg-danger' }}" name="range"
                                               value="{{ $model->testing_range }}">
                                       </div>


                                       <div class="col-4">
                                           <p><b>Maximum Electric Energy Consumption (kWh/100 Km):* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->max_elect_consumption }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly class="form-control readonly {{ $model->max_elect_consumption == $model->testing_max_elect_consumption ? 'readonly' : 'bg-danger' }}"
                                               name="max_elect_consumption" value="{{ $model->testing_max_elect_consumption }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>MinimumMax Speed (Km/Hr):* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->min_max_speed }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly name="min_max_speed"
                                               class=" readonly form-control {{ $model->min_max_speed == $model->testing_min_max_speed ? 'readonly' : 'bg-danger' }}" value="{{ $model->testing_min_max_speed }}">
                                       </div>

                                       <div class="col-4">
                                           <p><b>Minimum Acceleration (m/s2):* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->min_acceleration }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" readonly class="form-control readonly {{ $model->min_acceleration == $model->testing_min_acceleration ? 'readonly' : 'bg-danger' }}"
                                               name="min_acceleration" value="{{ $model->testing_min_acceleration }}">
                                       </div>



                                       <div class="col-4">
                                           <p><b>Meeting xEV Technology Function:* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->meeting_tech_function }}</h5>
                                       </div>
                                       <div class="col-4">

                                           <input type="text" class="form-control readonly {{ $model->meeting_tech_function == $model->testing_meeting_tech_function ? 'readonly' : 'bg-danger' }}"  readonly name="meeting_tech_function" value="{{ $model->testing_meeting_tech_function == 'Y' ? 'Yes' : 'No' }}" readonly>

                                       </div>

                                       <div class="col-4">
                                           <p><b>Meeting Qualification Targets:* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ $model->meeting_qualif }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="text" class="form-control readonly {{ $model->meeting_qualif == $model->testing_meeting_qualif ? 'readonly' : 'bg-danger' }}" readonly name="meeting_tech_function" value="{{ $model->testing_meeting_qualif == 'Y' ? 'Yes' : 'No' }}" readonly>
                                       </div>

                                       <div class="col-4">
                                           <p><b>Date of Vehicle Submission to Test Agency for Type Approval:* </b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ date('d-m-Y', strtotime($model->vehicle_sub_to_test_agency_apprv)) }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="date" readonly class="form-control readonly {{ $model->vehicle_sub_to_test_agency_apprv == $model->testing_vehicle_sub_to_test_agency_apprv ? 'readonly' : 'bg-danger' }}"
                                               name="vehicle_sub_to_test_agency_apprv"
                                               value="{{ $model->vehicle_sub_to_test_agency_apprv }}">
                                       </div>
                                       <hr/>
                                       <div class="col-4 offset-8">
                                        <h5><b>Filled by Testing Agency</b></h5>
                                    </div>
                                       {{-- @if ($model->date_certificate != null)
                                       <div class="col-4">
                                           <p><b>{{ env('APP_NAME') }} Certificate Effective Date to be filled by OEM:*</b></p>
                                       </div>
                                       <div class="col-4">
                                           <h5>{{ date('d-m-Y', strtotime($model->date_certificate)) }}</h5>
                                       </div>
                                       <div class="col-4">
                                           <input type="date" name="date_certificate" readonly
                                               class="form-control readonly" value="{{ $model->date_certificate }}"
                                               placeholder="Select Approval Date">
                                       </div>
                                   @endif --}}
                                   <div class="col-4">
                                    <p><b>{{ env('APP_NAME')}} Compliance Certificate Number*</b></p>
                                </div>
                                <div class="col-4">
                                 </div>
                                 <div class="col-4">
                                    <input type="text" name="certificate_no" value="{{$model->testing_certificate_no}}" readonly class="form-control readonly" placeholder="Enter Certificate Number">
                                 </div>
                                 <div></div>
                                 <div class="col-4 hide">
                                    <p><b>PM E-DRIVE Certificate Copy ( @if ($model->category_type == 'O')
                                                Original Model
                                            @elseif ($model->category_type == 'R')
                                                Re-Validate
                                            @elseif ($model->category_type == 'E')
                                                Extended
                                            @elseif ($model->category_type == 'V')
                                                Revised
                                            @endif ) :* </b></p>
                                </div>
                        <div class="col-4 hide">
                         </div>
                         <div class="col-4 hide">
                            <h5>   <a class="mt-2 btn btn-success btn-sm"
                                href="{{ route('doc.down', encrypt($model->testing_doc_id)) }}">
                                <i class="fa fa-download"></i>  View Document
                             </a>
                            </h5>
                         </div>
                         <div class="col-4 hide">
                            <p><b>Assessment Report:*  </b></p>
                        </div>
                        <div class="col-4 hide">

                         </div>
                         <div class="col-4 hide">
                                <h5> <a class="mt-2 btn btn-success btn-sm"
                                    href="{{ route('doc.down', encrypt($model->assessment_report_id)) }}">
                                    <i class="fa fa-download"></i> View Document
                                </a>
                            </h5>
                        </div>
                         <div class="col-4 hide">
                            <p><b>CMVR Certificate Copy :* </b></p>
                            <span class="text-danger">(Please also upload all earlier certificates in a single file.)</span>
                        </div>
                        <div class="col-4 hide">
                        </div>
                        <div class="col-4 hide">
                                <h5> <a class="mt-2 btn btn-success btn-sm"
                                    href="{{ route('doc.down', encrypt($model->testing_cmvr_doc_id)) }}">
                                    <i class="fa fa-download"></i> View Document
                                </a>
                            </h5>
                        </div>
                        <div class="col-4">
                            <p><b>CMVR Certificate Date:*</b></p>
                        </div>
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                                <input type="date" name="certificate_no" value="{{$model->testing_cmvr_date}}" readonly class="form-control readonly">
                        </div>
                         {{-- <div class="col-4">
                            <p><b>{{ env('APP_NAME')}} Compliance Certificate Date:*</b></p>
                        </div>
                        <div class="col-4">
                         </div>
                         <div class="col-4">
                            <input type="date" name="cmvr_date" readonly class="form-control readonly"  value="{{$model->testing_cmvr_date}}" placeholder="Select PM E-DRIVE Date">
                         </div> --}}
                         {{-- @if ($model->date_certificate != null)
                         <div class="col-4">
                            <p><b>{{ env('APP_NAME')}} Certificate Effective Date:*</b></p>
                        </div>
                        <div class="col-4">
                         </div>
                         <div class="col-4">
                            <input type="date" name="date_certificate" readonly class="form-control readonly" value="{{$model->date_certificate}}" placeholder="Select Approval Date">
                         </div>
                         @endif --}}

                         <div class="col-4">
                            <p><b>{{ env('APP_NAME')}} Compliance Certificate Approval Date:*</b></p>
                        </div>
                        <div class="col-4">
                         </div>
                         <div class="col-4">
                            <input type="date" name="approval_date" readonly class="form-control readonly" value="{{$model->valid_from}}" placeholder="Select Approval Date">
                         </div>
                         <div class="col-4">
                            <p><b>{{ env('APP_NAME')}} Certificate Effective Date:*</b></p>
                        </div>
                        <div class="col-4">

                         </div>
                         <div class="col-4">
                            <input type="date" name="valid_date" readonly class="form-control readonly" value="{{$model->valid_date}}" placeholder="Select Approval Date">
                         </div>

                         <div class="col-4">
                            <p><b>{{ env('APP_NAME')}} Compliance Certificate Valid Upto:*</b></p>
                        </div>
                        <div class="col-4">

                         </div>
                         <div class="col-4">
                            <input type="date" name="expiry_date" readonly class="form-control readonly" value="{{$model->valid_upto}}" placeholder="Select Validate Date">
                         </div>

                         <div class="col-4">
                            <p><b>PMP Compliance:*  </b></p>
                        </div>
                        <div class="col-4">

                         </div>
                         <div class="col-4">
                            <select  id="" class="form-select" disabled name="pmp_compliance">
                                <option>Select</option>
                                <option value="Yes" {{ $model->pmp_compliance == 'Yes' ? 'selected':''}}>Yes</option>
                                <option value="No" {{ $model->pmp_compliance == 'No' ? 'selected':''}}>No</option>
                            </select>
                         </div>
                         <div class="col-4">
                            <p><b>Warranty Period :*  </b></p>
                        </div>
                        <div class="col-4"></div>
                         <div class="col-4">
                            <input type="text" readonly name="warranty_period_indicate" class="form-control readonly" value="{{ $model->warranty_period_indicate }}" placeholder="">
                         </div>
                         <div class="col-4">
                            <p><b>Warranty Check:*  </b></p>
                        </div>
                        <div class="col-4">

                         </div>
                         <div class="col-4">
                            <select  id="" class="form-select" disabled name="warranty_check">
                                <option>Select</option>
                                <option value="Yes" {{$model->warranty_check == 'Yes' ? 'selected':''}}>Yes</option>
                                <option value="No" {{$model->warranty_check == 'No' ? 'selected':''}}>No</option>
                            </select>
                         </div>
{{--
                                       <div class="col-4">
                                           <p><b>Certificate Copy:* </b></p>
                                       </div>
                                       <div class="col-4">
                                       </div>
                                       <div class="col-4">
                                               <h5> <a class="mt-2 btn btn-success btn-sm"
                                                   href="{{ route('doc.down', encrypt($model->testing_doc_id)) }}">
                                                   <i class="fa fa-download"></i> View Document
                                               </a>
                                           </h5>
                                       </div>
                                       <div class="col-4">
                                        <p><b>CMVR Certificate Copy:* </b></p>
                                    </div>
                                    <div class="col-4">
                                    </div>
                                    <div class="col-4">
                                            <h5> <a class="mt-2 btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($model->testing_cmvr_doc_id)) }}">
                                                <i class="fa fa-download"></i> View Document
                                            </a>
                                        </h5>
                                    </div>

                                       <div class="col-4">
                                           <p><b>Model {{ env('APP_NAME')}} Compliance Certificate Number*</b></p>
                                       </div>
                                       <div class="col-4">

                                       </div>
                                       <div class="col-4">
                                           <input type="text" name="certificate_no"
                                               value="{{ $model->testing_certificate_no }}" readonly
                                               class="form-control readonly" placeholder="Enter Certificate Number">
                                       </div>

                                       <div class="col-4">
                                           <p><b> Model {{ env('APP_NAME')}} CMVR Date:*</b></p>
                                       </div>
                                       <div class="col-4">

                                       </div>
                                       <div class="col-4">
                                           <input type="date" name="cmvr_date" readonly class="form-control readonly"
                                               value="{{ $model->testing_cmvr_date }}" placeholder="Select CMVR Date">
                                       </div>

                                       <div class="col-4">
                                           <p><b>Model {{ env('APP_NAME')}} Compliance Certificate Approval Date:*</b></p>
                                       </div>
                                       <div class="col-4">

                                       </div>
                                       <div class="col-4">
                                           <input type="date" name="approval_date" readonly
                                               class="form-control readonly" value="{{ $model->valid_from }}"
                                               placeholder="Select Approval Date">
                                       </div>

                                       <div class="col-4">
                                           <p><b>Model {{ env('APP_NAME')}} Compliance Certificate Validate Upto:*</b></p>
                                       </div>
                                       <div class="col-4">

                                       </div>
                                       <div class="col-4">
                                           <input type="date" name="expiry_date" readonly
                                               class="form-control readonly" value="{{ $model->valid_upto }}"
                                               placeholder="Select Validate Date">
                                       </div>
                                       <div class="col-4">
                                        <p><b>PMP Compliance:*  </b></p>
                                    </div>
                                    <div class="col-4">

                                     </div>
                                     <div class="col-4">
                                        <select  id="" class="form-select" disabled name="pmp_compliance">
                                            <option>Select</option>
                                            <option value="Yes" {{ $model->pmp_compliance == 'Yes' ? 'selected':''}}>Yes</option>
                                            <option value="No" {{ $model->pmp_compliance == 'No' ? 'selected':''}}>No</option>
                                        </select>
                                     </div>
                                     <div class="col-4">
                                        <p><b>Warranty Period :*  </b></p>
                                    </div>
                                    <div class="col-4"></div>
                                     <div class="col-4">
                                        <input type="text" readonly name="warranty_period_indicate" class="form-control readonly" value="{{ $model->warranty_period_indicate }}" placeholder="">
                                     </div>
                                     <div class="col-4">
                                        <p><b>Warranty Check:*  </b></p>
                                    </div>
                                    <div class="col-4">

                                     </div>
                                     <div class="col-4">
                                        <select  id="" class="form-select" disabled name="warranty_check">
                                            <option>Select</option>
                                            <option value="Yes" {{$model->warranty_check == 'Yes' ? 'selected':''}}>Yes</option>
                                            <option value="No" {{$model->warranty_check == 'No' ? 'selected':''}}>No</option>
                                        </select>
                                     </div> --}}
                                       <div class="col-md-12 col-sm-12 col-xs-12 hide">
                                           <div class="form-check">
                                            @if(Auth::user()->hasRole('MHI-DS|PMA'))
                                               <input class="form-check-input" disabled id="flexCheckDefault" checked
                                                   type="checkbox" value="" name="declaration">
                                            @else
                                                   <input class="form-check-input" id="flexCheckDefault" checked
                                                   type="checkbox" value="" name="declaration">
                                                @endif   
                                               <label class="form-check-label" for="flexCheckDefault">Declaration :* We declare that the above information relating to vehicle testing report is correct to the best of our knowledge and belief. The above information is being provided to MHI for the purpose of availing demand incentive as per guidelines of the
                                                {{ env('APP_NAME') }}.</label>
                                           </div>
                                       </div>
                                       <div class="col-4 hide" >
                                        <label for="">Testing Status</label>
                                        @if ($model->testing_flag == 'A')
                                            <input type="text" value="Approved" readonly class="readonly form-control">
                                        @elseif($model->testing_flag == 'R')
                                            <input type="text" value="Rejected - with Reason :: {{ $model->testing_remarks }}" readonly class="readonly form-control">
                                        @elseif($model->testing_flag == 'D')
                                            <input type="text" value="Reverted - with Reason :: {{ $model->pma_revert_remarks }}" readonly class="readonly form-control">
                                        @endif

                                       </div>
                                       <div class="col-4 hide">
                                        <label for="">PMA Status</label>
                                            @if($model->pma_status == null)
                                                <input type="text" value="Pending at PMA" readonly class="readonly form-control">
                                            @elseif($model->pma_status == 'A')
                                                <input type="text" value="Recommended by PMA" readonly class="readonly form-control">
                                            @elseif($model->pma_status == 'R')
                                                <input type="text" value="Rejected By PMA - with Reason :: {{ $model->pma_remarks }}" readonly class="readonly form-control">
                                            @elseif($model->pma_revert_status == 'R')
                                                <input type="text" value="Reverted By PMA - with Reason :: {{ $model->pma_revert_remarks }}" readonly class="readonly form-control">
                                            @elseif($model->pma_status == 'N')
                                                <input type="text" value="N/A" readonly class="readonly form-control">
                                            @endif
                                       </div>
                                            <div class="col-4 hide">
                                                <label for="">MHI Status</label>
                                            {{-- @if($model->pma_status == 'A') --}}
                                                @if ($model->mhi_flag == 'A')
                                                    <input type="text" value="Approved by MHI" readonly class="readonly form-control">
                                                @elseif($model->mhi_flag == 'R')
                                                    <input type="text" value="Rejected by MHI - with Reason :: {{ $model->mhi_remarks }}" readonly class="readonly form-control">
                                                @elseif($model->pma_status == 'R')
                                                    <input type="text" value="Rejected By PMA" readonly class="readonly form-control">
                                                @else
                                                    <input type="text" value="Pending at MHI" readonly class="readonly form-control">
                                                @endif
                                            {{-- @endif --}}
                                        </div>
                                   </div>
                                   @if(Auth::user()->hasRole('MHI-DS'))

                                @if($model->pma_status != null || $model->pma_status != '' )
                                    @if($model->mhi_flag == null || $model->mhi_flag == '')
                                    @if($model->pma_status != 'R')
                                        <input type="hidden" name="oem_id" value="{{$model->oem_id}}">
                                        <input type="hidden" name="model_id" value="{{$model->model_id}}">
                                        <input type="hidden" name="oem_name" value="{{$model->oem_name}}">
                                        <input type="hidden" name="status" value="A">
                                        <input type="hidden" name="mid" value="{{$model->model_detail_id}}">
                                        <div class="col-12 text-center mt-2">
                                            <button type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#approve" class="btn btn-info btn-approve">Approve</button>
                                            <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#reject">Reject</button>
                                            <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#revertMHI">Revert</button>
                                            <a href="{{ route('e-trucks.manageOEMApproval.index') }}" class="btn btn-warning">Back</a>
                                        </div>
                                    @endif
                                    @endif
                                @endif
                            @elseif(Auth::user()->hasRole('PMA'))
                                @if ($model->pma_status == null)
                                    {{-- @if($model->mhi_flag == null || $model->mhi_flag == '') --}}
                                        <input type="hidden" name="oem_id" value="{{$model->oem_id}}">
                                        <input type="hidden" name="model_id" value="{{$model->model_id}}">
                                        <input type="hidden" name="oem_name" value="{{$model->oem_name}}">
                                        <input type="hidden" name="status" value="A">
                                        <input type="hidden" name="mid" value="{{$model->model_detail_id}}">
                                        <div class="col-12 text-center mt-2">
                                            <button type="submit" class="btn btn-info btn-approve btnApp" name="pma_recomend">Recommend</button>
                                            <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#reject">Reject</button>
                                            <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#revert">Revert</button>
                                            <a href="{{ url()->previous() }}" class="btn btn-warning">Back</a>
                                        </div>
                                @elseif($model->pma_status == 'A')
                                <div class="col-12 text-center mt-2">
                                        {{-- @if(!Auth::user()->hasRole('TESTINGAGENCY'))
                                            <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#revert">Revert</button>
                                        @endif --}}
                                        <a href="{{ url()->previous() }}" class="btn btn-warning">Back</a>
                                    </div>
                                @endif
                           @endif

                               </div>
                               <input type="hidden" name="oem_id" value="{{ $model->oem_id }}">
                               <input type="hidden" name="model_id" value="{{ $model->model_id }}">
                               <input type="hidden" name="oem_name" value="{{ $model->oem_name }}">
                               <input type="hidden" name="status" value="A">
                               <input type="hidden" name="mid" value="{{ $model->model_detail_id }}">
                           </div>
                           {{-- <div class="col-12 text-center"> --}}
                               {{-- <a href="{{ route('manageOEMApproval.index') }}" class="btn btn-warning">Back</a> --}}
                               {{-- <button type="submit" class="btn btn-info btn-approve">Approve</button>
                               <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#reject">Reject</button> --}}
                           {{-- </div> --}}
                       </form>
                   </div>


               </div>
           </div>
           <!-- Container-fluid Ends-->
       </div>
       <div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="approve" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div class="modal-toggle-wrapper"> 
                <form action="{{route('e-trucks.manageOEMApproval.store')}}"  id="formApprove" role="form" method="POST"
                   class='form-horizontal modelVer' accept-charset="utf-8" enctype='multipart/form-data' files=true>
                   @csrf
               
                   <input type="hidden" name="oem_id" value="{{$model->oem_id}}">
                            <input type="hidden" name="model_id" value="{{$model->model_id}}">
                            <input type="hidden" name="oem_name" value="{{$model->oem_name}}">
                            <input type="hidden" name="status" value="A">
                            <input type="hidden" name="mid" value="{{$model->model_detail_id}}">
                    <div class="row">
                        <div class="col-12">
                            <label>E-Office Number</label>
                           <input type="date"  name="e_office_date" class="form-control" required>
                        </div> 
                    </div>
                    <div class="col-12">
                        <button class="btn bg-primary mt-2 d-flex align-items-center gap-2 text-light ms-auto eApr" type="button">Approve<i data-feather="arrow-right"></i></button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
       <div class="modal fade" id="revert" tabindex="-1" role="dialog" aria-labelledby="revert"
       aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-body">
                   <div class="modal-toggle-wrapper">
                       <form action="{{ route('e-trucks.modelRevert') }}" id="formReject" role="form"
                           method="POST" class='form-horizontal modelVer' accept-charset="utf-8"
                           enctype='multipart/form-data' files=true>
                           @csrf

                           <input name="status" type="hidden" value="R">
                           <input type="hidden" name="oem_id" value="{{ $model->oem_id }}">
                           <input type="hidden" name="model_id" value="{{ $model->model_id }}">
                           <input type="hidden" name="oem_name" value="{{ $model->oem_name }}">
                           <input type="hidden" name="mid" value="{{ $model->model_detail_id }}">
                           <div class="row">
                               <div class="col-12">
                                   <label>Remarks</label>
                                   <textarea class="form-control" name="pma_revert_remarks" placeholder="Remarks"></textarea>
                               </div>
                           </div>
                           <div class="col-12">
                               <button
                                   class="btn bg-primary mt-2 d-flex align-items-center gap-2 text-light ms-auto btnReject"
                                   type="submit">Revert<i data-feather="arrow-right"></i></button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </div>


   <div class="modal fade" id="revertMHI" tabindex="-1" role="dialog" aria-labelledby="revert"
       aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-body">
                   <div class="modal-toggle-wrapper">
                       <form action="{{ route('e-trucks.modelRevertMHI') }}" id="formReject" role="form"
                           method="POST" class='form-horizontal modelVer' accept-charset="utf-8"
                           enctype='multipart/form-data' files=true>
                           @csrf
 
                           <input name="status" type="hidden" value="R">
                           <input type="hidden" name="oem_id" value="{{ $model->oem_id }}">
                           <input type="hidden" name="model_id" value="{{ $model->model_id }}">
                           <input type="hidden" name="oem_name" value="{{ $model->oem_name }}">
                           <input type="hidden" name="mid" value="{{ $model->model_detail_id }}">
                           <div class="row">
                               <div class="col-12">
                                   <label>Remarks</label>
                                   <textarea class="form-control" name="mhi_revert_remarks" placeholder="Remarks"></textarea>
                               </div>
                           </div>
                           <div class="col-12">
                               <button
                                   class="btn bg-primary mt-2 d-flex align-items-center gap-2 text-light ms-auto btnReject"
                                   type="submit">Revert<i data-feather="arrow-right"></i></button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </div>
 
       <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="reject"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-body">
                       <div class="modal-toggle-wrapper">
                           <form action="{{ route('e-trucks.manageOEMApproval.store') }}" id="formReject" role="form"
                               method="POST" class='form-horizontal modelVer' accept-charset="utf-8"
                               enctype='multipart/form-data' files=true>
                               @csrf

                               <input name="status" type="hidden" value="R">
                               <input type="hidden" name="oem_id" value="{{ $model->oem_id }}">
                               <input type="hidden" name="model_id" value="{{ $model->model_id }}">
                               <input type="hidden" name="oem_name" value="{{ $model->oem_name }}">
                               <input type="hidden" name="mid" value="{{ $model->model_detail_id }}">
                               <div class="row">
                                   <div class="col-12">
                                       <label>Remarks</label>
                                       <textarea class="form-control" name="mhi_remarks" placeholder="Remarks"></textarea>
                                   </div>
                               </div>
                               <div class="col-12">
                                   <button
                                       class="btn bg-primary mt-2 d-flex align-items-center gap-2 text-light ms-auto btnReject"
                                       type="submit">Reject<i data-feather="arrow-right"></i></button>
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
           $(document).ready(function() {
               // Listen for click event on the Save button
               $('.btn-save').on('click', function() {
                   // Set the value of the hidden input to blank
                   $('input[name="status"]').val('');
               });

               // Listen for click event on the Approve button
               $('.btn-approve').on('click', function() {
                   // Set the value of the hidden input to 'A'
                   $('input[name="status"]').val('A');
               });
           });
           $(document).ready(function() {

            $(".eApr").click(function () {
            let eOfficeDate = $("input[name='e_office_date']").val();

            if (!eOfficeDate) {
                alert("E-Office Date cannot be empty!"); // Show alert popup
                return false; // Prevent form submission
            }

            $("#formApprove").submit(); // Submit form if date is filled
        });


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

               $('.btnApp').click(function(e) {
        e.preventDefault(); // Prevent default form submission

        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to submit the form. Are you sure you want to proceed?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit!',
            cancelButtonText: 'No, cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable the button to prevent multiple submissions
                $(this).addClass('disabled');
                $(this).prop('disabled', true);

                // Submit the form
                document.getElementById('plant').submit();
                // $('#formReject').submit();
            } else {
                // If user clicks cancel, enable the button
                $(this).removeClass('disabled');
                $(this).prop('disabled', false);
            }
        });
    });
           });
           function printDiv(divId, title) {
    var divElement = document.getElementById(divId);
 
    if (!divElement) {
        console.error("Div not found!");
        return;
    }
 
    // Clone the div to keep the original content intact
    var clonedDiv = divElement.cloneNode(true);
 
    // Remove all buttons and <a> elements with class "btn"
    var elementsToRemove = clonedDiv.querySelectorAll("button, a.btn, .hide");
    elementsToRemove.forEach(element => element.remove());
 
    var divContents = clonedDiv.innerHTML;
    var originalContents = document.body.innerHTML;
 
    // Get the current date
    var currentDate = new Date().toLocaleDateString();
 
    // Create a title and date section
    var headerContent = `
        <div style="text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 10px;">
           Models Details
        </div>
        <div style="text-align: right; font-size: 14px; font-weight: bold; margin-bottom: 10px;">
            Printed on: ${currentDate}
        </div>
    `;
 
    // Update document body with title, date, and cleaned div content
    document.body.innerHTML = headerContent + divContents;
 
    // Print the content
    window.print();
 
    // Restore original content
    document.body.innerHTML = originalContents;
    location.reload(); // Reload to restore JavaScript functionality
}
       </script>
   @endpush
