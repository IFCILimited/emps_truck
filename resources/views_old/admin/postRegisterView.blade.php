   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - OEM Post-Registration
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
                           <h4>OEM Post-Registration</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="index.html">
                                       <svg class="stroke-icon">
                                           <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage OEM</li>
                               <li class="breadcrumb-item active">OEM Post-Registration</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid">
               <div class="text-end m-1">
                   <button onclick="window.print()" class="btn btn-sm btn-outline-warning text-end"> <i
                           class="fa fa-print"></i> Print</button>
               </div>
               <div class="row">
                   <div class="col-sm-12">
                       {{-- OEM Detail --}}
                       <div class="card">
                           <div class="card-header bg-primary">
                               <h5 class="text-white">OEM Details</h5>
                           </div>
                           <div class="card-body">
                               <div class="row g-2">
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM Name:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->name }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Type of OEM:<span
                                                   class="text-danger">*</span></label>
                                           <input type="text" class="form-control readonly" readonly
                                               value="{{ $oemType->where('id', $user->oem_type_id)->first()->type }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM Address:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->address }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM Pincode:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->pincode }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM State:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->state }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM District:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->district }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM City:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->city }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Mobile No.:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->mobile }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">E-Mail:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->email }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Fax No:</label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->fax }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Landmark:</label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->landmark }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Landline No.:</label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->landline }}">
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>

                       {{-- Authorised Person Detail --}}
                       <div class="card">
                           <div class="card-header bg-primary">
                               <h5 class="text-white">Authorised Person Detail</h5>
                           </div>
                           <div class="card-body">
                               <div class="row g-2">
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Authorised Person Name:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_name }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Authorised Person Designation:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_designation }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Authorised Person Address:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_address }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Authorised Person Pincode:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_pincode }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Authorised Person State:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_state }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Authorised Person District:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_district }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Authorised Person City:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_city }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Authorised Person Landmark:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_city }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Authorised Person Mobile No.:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_mobile }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Authorised Person E-Mail:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_email }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Authorised Person Fax No:</label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_fax }}">
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>

                       {{-- Manufacturing Information --}}
                       <div class="card">
                           <div class="card-header bg-primary">
                               <h5 class="text-white">Manufacturing Information</h5>
                           </div>
                           <div class="card-body">
                               <div class="row g-2">

                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Company Registration No. :<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->registration_no }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">GSTIN No.:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->gstin_no }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM PAN:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->oem_pan }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Company Registration Certificate No.:<span
                                                   class="text-danger">*</span></label>
                                           <a class="mt-2 btn btn-success btn-sm"
                                               href="{{ route('doc.down', encrypt($user->registration_certificate_upload_id)) }}">
                                               <i class="fa fa-download"></i> View
                                               Document
                                           </a>
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">GSTIN Registration File:<span
                                                   class="text-danger">*</span></label><br>
                                           <a class="mt-2 btn btn-success btn-sm"
                                               href="{{ route('doc.down', encrypt($postRegDetail->gstin_registration_upload_id)) }}">
                                               <i class="fa fa-download"></i> View
                                               Document
                                           </a>
                                       </div>
                                   </div>

                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM PAN File:<span
                                                   class="text-danger">*</span></label><br>
                                           <a class="mt-2 btn btn-success btn-sm"
                                               href="{{ route('doc.down', encrypt($postRegDetail->oem_pan_upload_id)) }}">
                                               <i class="fa fa-download"></i> View
                                               Document
                                           </a>
                                       </div>
                                   </div>

                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">R&D Facilities File:<span
                                                   class="text-danger">*</span></label><br>
                                           <a class="mt-2 btn btn-success btn-sm"
                                               href="{{ route('doc.down', encrypt($postRegDetail->r_and_d_facilities_upload_id)) }}">
                                               <i class="fa fa-download"></i> View
                                               Document
                                           </a>
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Annual Turnover (INR in cr):<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->annual_turnover }}">

                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>

                       {{-- Manufacturing Plant Detail --}}
                       <div class="card">
                           <div class="card-header bg-primary">
                               <h5 class="text-white">Manufacturing Plant Detail</h5>
                           </div>
                           <div class="card-body">
                               <div class="row g-3">
                                   <div class="table-responsive">
                                       <table class="table table-bordered" id="plantTable">
                                           <thead>
                                               <tr>
                                                   <th scope="col">S.No.</th>
                                                   <th scope="col">Plant Name</th>
                                                   <th scope="col">Email Id</th>
                                                   <th scope="col">Landline No.</th>
                                                   <th scope="col">Address</th>
                                                   <th scope="col">Pincode</th>
                                                   <th scope="col">State</th>
                                                   <th scope="col">District</th>
                                                   <th scope="col">City</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                               @foreach ($manufacturing as $item)
                                                   <tr>
                                                       <td>{{ $loop->iteration }}</td>
                                                       <td>{{ $item->plant_name }}</td>
                                                       <td>{{ $item->email }}</td>
                                                       <td>{{ $item->landline_no }}</td>
                                                       <td>{{ $item->address }}</td>
                                                       <td>{{ $item->pincode }}</td>
                                                       <td>{{ $item->state }}</td>
                                                       <td>{{ $item->district }}</td>
                                                       <td>{{ $item->city }}</td>
                                                   </tr>
                                               @endforeach


                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>

                       {{-- Bank Detail --}}
                       <div class="card">
                           <div class="card-header bg-primary">
                               <h5 class="text-white">Bank Detail</h5>
                           </div>
                           <div class="card-body">
                               <div class="row g-2">

                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">IFSC
                                               Code :<span class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->ifsc_code }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Account Holder Name:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->account_holder_name }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Name of Bank:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->bank_name }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Name of Branch:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->branch_name }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Address:<span
                                                   class="text-danger">*</span></label><br>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->branch_address }}">
                                       </div>
                                   </div>

                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Pincode:<span
                                                   class="text-danger">*</span></label><br>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->branch_pincode }}">
                                       </div>
                                   </div>

                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">State:<span
                                                   class="text-danger">*</span></label><br>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->branch_state }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">District:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->branch_district }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Branch City:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->branch_city }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Account No.:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->account_no }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">MICR Code:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->micr_code }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Account Type:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->account_type }}">
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="text-white">Documents</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">

                               
                              
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Vehicle Photo<span
                                                class="text-danger">*</span></label><br>
                                        <a class="mt-2 btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($postRegDetail->vehicle_photo_id)) }}">
                                            <i class="fa fa-download"></i> View
                                            Document
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">MOA & AOA<span
                                                class="text-danger">*</span></label><br>
                                        <a class="mt-2 btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($postRegDetail->moa_aoa_id)) }}">
                                            <i class="fa fa-download"></i> View
                                            Document
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Trade License<span
                                                class="text-danger">*</span></label><br>
                                        <a class="mt-2 btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($postRegDetail->trade_license_id)) }}">
                                            <i class="fa fa-download"></i> View
                                            Document
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Manufacturer Registration (Annexure-I)<span
                                                class="text-danger">*</span></label><br>
                                        <a class="mt-2 btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($postRegDetail->manufacturer_registration_id)) }}">
                                            <i class="fa fa-download"></i> View
                                            Document
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Pre-registration of EV model (Annexure-II)<span
                                                class="text-danger">*</span></label><br>
                                        <a class="mt-2 btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($postRegDetail->pre_registration_ev_model_id)) }}">
                                            <i class="fa fa-download"></i> View
                                            Document
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">OEM’s Sales and Service Network<span
                                                class="text-danger">*</span></label><br>
                                        <a target="_blank" download="" class="mt-2 btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($postRegDetail->oem_sales_and_service_network_id)) }}">
                                            <i class="fa fa-download"></i> View
                                            Document
                                        </a>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Testing/Homologation Certificate<span
                                                class="text-danger">*</span></label><br>
                                        <a class="mt-2 btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($postRegDetail->tesed_homologation_certificate_id)) }}">
                                            <i class="fa fa-download"></i> View
                                            Document
                                        </a>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                       {{-- Other Detail --}}
                       <div class="card">
                           <div class="card-header bg-primary">
                               <h5 class="text-white">Other Detail</h5>
                           </div>
                           <div class="card-body">
                               <div class="row g-2">

                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Dealer Mode :<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->dealer_mode }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Dealer Numbers:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->dealer_no }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">No. of Dealer:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->no_of_dealers }}">
                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Dealer List File:<span
                                                   class="text-danger">*</span></label><br>
                                           <a class="mt-2 btn btn-success btn-sm"
                                               href="{{ route('doc.down', encrypt($postRegDetail->dealer_upload_id)) }}">
                                               <i class="fa fa-download"></i> View
                                               Document
                                           </a>
                                       </div>
                                   </div>
                                   <div class="col-8">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">State of dealer presence:<span
                                                   class="text-danger">*</span></label><br>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $postRegDetail->dealer_state }}">
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>

                       {{-- Button --}}
                       <div class="card">
                           <div class="card-header bg-primary">
                               <h5 class="text-white">Post-Registration Approval/Rejection Details</h5>
                           </div>
                           <div class="card-body">
                               <div class="row g-2">

                                   @if (is_null($user->post_registration_status))
                                       @if (Auth::user()->hasRole('MHI-DS'))
                                           <div class="col-4 offset-4  d-flex mt-4">

                                               {{-- <form action="{{ route('oemRegistration.update', $user->id) }}"
                                                    id="formApprove" role="form" method="POST" class='form-horizontal'
                                                    accept-charset="utf-8" enctype='multipart/form-data' files=true>
                                                    @csrf
                                                    @method('PUT')
                                                  
                                                    <input name="status" type="hidden" value="A">
                                                    <input name="oem_id" type="hidden" value="{{ $user->id }}">
                                                </form> --}}
                                               <button class="btn btn-sm btn-success mx-1" type="button"
                                                   data-bs-toggle="modal" data-original-title="test"
                                                   data-bs-target="#approve">Recommend for Approval</button>
                                               {{-- <button type="button"
                                                    class="btn btn-sm btn-success btnApp mx-1">Approve</button> --}}
                                               <button class="btn btn-sm btn-danger mx-1" type="button"
                                                   data-bs-toggle="modal" data-original-title="test"
                                                   data-bs-target="#reject">Reject</button>
                                           </div>
                                       @else
                                           <div class="col-3 mt-2">
                                               <div class="form-group">
                                                   <label class="col-form-label pt-0"><b>Post-Registration Status
                                                           :</b></label>
                                               </div>
                                           </div>
                                           <div class="col-3">
                                               <div class="form-group">
                                                   @php
                                                       $value = 'Pending';
                                                       if ($user->post_registration_status == 'A') {
                                                           $value = 'Approved';
                                                       } elseif ($user->post_registration_status == 'R') {
                                                           $value =
                                                               'Reject with Reason :: ' .
                                                               $user->post_registration_remark;
                                                       } elseif ($user->post_registration_status == 'RC') {
                                                           $value = 'Recommended for Approval To MHI-AS';
                                                       }
                                                   @endphp
                                                   <span>
                                                    <label class="col-form-label pt-0">Status</label>
                                                       <input class="form-control readonly" readonly type="text"
                                                           value="{{ $value }}">
                                                   </span>
                                               </div>
                                           </div>
                                           {{-- @if ($user->approval_doc_id)
                                               <div class="col-3">
                                                   <a class="mt-2 btn btn-success btn-sm"
                                                       href="{{ route('doc.down', encrypt($user->approval_doc_id)) }}">
                                                       <i class="fa fa-download"></i> View
                                                       Document
                                                   </a>
                                               </div>
                                           @endif --}}
                                           {{-- @if ($user->post_approval_date != null)
                                               <div class="col-3">
                                                <label class="col-form-label pt-0">Approval Date</label>
                                                   <input type="text" class="form-control readonly" readonly
                                                       value="{{ $user->post_approval_date }}">
                                               </div>
                                           @endif --}}
                                       @endif
                                    @elseif($user->post_registration_status == 'C' && Auth::user()->hasRole('MHI-AS'))
                                    <div class="col-2">
                                        <div class="form-group">
                                            <span>
                                             <label class="col-form-label pt-0">Status</label>
                                                <input class="form-control readonly" readonly type="text"
                                                    {{-- value="{{ $user->post_registration_status == 'A' ? 'Approved' : 'Reject with Reason :: ' . $user->post_registration_remark }}"> --}}
                                                    value="{{ $user->post_registration_status == 'A' ? 'Approved' : ($user->post_registration_status == 'C' ? 'Recommended for Approval' : 'Reject with Reason :: ' . $user->post_registration_remark) }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                     <div class="form-group">
                                         <span>
                                             <label class="col-form-label pt-0">E-Office Approval Note No.</label>
                                             <input class="form-control readonly" name="e_office_noting_no" readonly type="text"
                                                 {{-- value="{{ $user->post_registration_status == 'A' ? 'Approved' : 'Reject with Reason :: ' . $user->post_registration_remark }}"> --}}
                                                 value="{{ $user->e_office_noting_no != null ? $user->e_office_noting_no : '' }} ">
                                         </span>
                                     </div>
                                 </div>
                                 <div class="col-3">
                                     <div class="form-group">
                                         <span>
                                             <label class="col-form-label pt-0">E-Office Computer Note No.</label>
                                             <input class="form-control readonly" name="computer_no" readonly type="text"
                                                 {{-- value="{{ $user->post_registration_status == 'A' ? 'Approved' : 'Reject with Reason :: ' . $user->post_registration_remark }}"> --}}
                                                 value="{{ $user->e_office_computer_no != null ? $user->e_office_computer_no : '' }} ">
                                         </span>
                                     </div>
                                 </div>
                                  
                                    <div class="col-2">
                                     <label class="col-form-label pt-0">Approval Date</label>
                                        <input type="text" class="form-control readonly" name="post_approval_date" readonly
                                            value="{{ $user->post_approval_date }}">
                                    </div>
                                      @if ($user->approval_doc_id)
                                            <div class="col-2">
                                                <label>Document</label>
                                                <a class="mt-2 btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($user->approval_doc_id)) }}">
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                            </div>
                                        @endif
                                       <form action="{{ route('oemRegistration.update', $user->id) }}"
                                                    id="formApprove" role="form" method="POST" class='form-horizontal'
                                                    accept-charset="utf-8" enctype='multipart/form-data' files=true>
                                                    @csrf
                                                    @method('PUT')
                                                  
                                                    <input name="status" type="hidden" value="A">
                                                    <input name="oem_id" type="hidden" value="{{ $user->id }}">
                                                </form> 
                                                <div class="col-4 offset-4  d-flex mt-4">
                                    <button class="btn btn-sm btn-success mx-1 btnApp" type="button"
                                        >Approval</button>
                                    {{-- <button type="button"
                                        class="btn btn-sm btn-success btnApp mx-1">Approve</button> --}}
                                    <button class="btn btn-sm btn-danger mx-1" type="button"
                                        data-bs-toggle="modal" data-original-title="test"
                                        data-bs-target="#reject">Reject</button>
                                                </div>
                                    @else
                                       {{-- <div class="col-2 mt-2">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0"><b>Post-Registration Status :</b></label>
                                           </div>
                                       </div> --}}
                                       <div class="col-2">
                                           <div class="form-group">
                                               <span>
                                                <label class="col-form-label pt-0">Status</label>
                                                   <input class="form-control readonly" readonly type="text"
                                                       {{-- value="{{ $user->post_registration_status == 'A' ? 'Approved' : 'Reject with Reason :: ' . $user->post_registration_remark }}"> --}}
                                                       value="{{ $user->post_registration_status == 'A' ? 'Approved' : ($user->post_registration_status == 'C' ? 'Recommended for Approval' : 'Reject with Reason :: ' . $user->post_registration_remark) }}">
                                               </span>
                                           </div>
                                       </div>
                                       <div class="col-3">
                                        <div class="form-group">
                                            <span>
                                                <label class="col-form-label pt-0">E-Office Approval Note No.</label>
                                                <input class="form-control readonly" name="e_office_noting_no" readonly type="text"
                                                    {{-- value="{{ $user->post_registration_status == 'A' ? 'Approved' : 'Reject with Reason :: ' . $user->post_registration_remark }}"> --}}
                                                    value="{{ $user->e_office_noting_no != null ? $user->e_office_noting_no : '' }} ">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <span>
                                                <label class="col-form-label pt-0">E-Office Computer Note No.</label>
                                                <input class="form-control readonly" name="computer_no" readonly type="text"
                                                    {{-- value="{{ $user->post_registration_status == 'A' ? 'Approved' : 'Reject with Reason :: ' . $user->post_registration_remark }}"> --}}
                                                    value="{{ $user->e_office_computer_no != null ? $user->e_office_computer_no : '' }} ">
                                            </span>
                                        </div>
                                    </div>
                                     
                                       <div class="col-2">
                                        <label class="col-form-label pt-0">Approval Date</label>
                                           <input type="text" class="form-control readonly" name="post_approval_date" readonly
                                               value="{{ $user->post_approval_date }}">
                                       </div>
                                         @if ($user->approval_doc_id)
                                               <div class="col-2">
                                                   <a class="mt-2 btn btn-success btn-sm"
                                                       href="{{ route('doc.down', encrypt($user->approval_doc_id)) }}">
                                                       <i class="fa fa-download"></i> View
                                                       Document
                                                   </a>
                                               </div>
                                           @endif
                                   @endif
                               </div>
                           </div>
                       </div>
                       <div class="col-4">
                           <a href="{{ route('oemPostRegistration') }}" class="btn btn-warning">Back</a>
                       </div>
                   </div>
               </div>
           </div>

       </div>
       <div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="approve"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title">Recommend For Approval</h5>
                   </div>
                   <div class="modal-body">
                       <div class="modal-toggle-wrapper">
                           <form action="{{ route('oemRegistration.update', $user->id) }}" role="form" method="POST"
                               class='form-horizontal prevent-multiple-submit postForm' accept-charset="utf-8"
                               enctype='multipart/form-data' files=true>
                               @csrf
                               @method('PUT')



                               <input name="status" type="hidden" value="C">
                               <input name="oem_id" type="hidden" value="{{ $user->id }}">
                               <div class="row">
                                   <div class="col-12">
                                       <label>Document</label>
                                       <input type="file" class="form-control" name="approve_doc">
                                   </div>
                                   <div class="col-12">
                                       <label>Date</label>
                                       <input type="date" class="form-control" name="approve_doc_date">
                                   </div>
                                   <div class="col-12">
                                       <label>E-Office Computer File No.</label>
                                       <input type="text" class="form-control" name="e_office_computer_no">
                                   </div>
                                   <div class="col-12">
                                    <label>E-Office Approval Number</label>
                                    <input type="text" class="form-control" name="e_office_noting_no">
                                </div>
                                   <div class="col-md-12 col-sm-12 col-xs-12">
                                       <div class="form-check checkbox checkbox-secondary">
                                           <input class="form-check-input primary" id="flexCheckDefault"
                                               onchange="setCheckboxValue(this)" type="checkbox" value=""
                                               name="declaration">
                                           <label class="form-check-label" for="flexCheckDefault">Declaration : The documents uploaded in the e-office and on the AMS portal have been checked, and there is no variance in the two set of documents uploaded.<span
                                                   class="text-danger">*</span> </label>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-12">
                                   <button
                                       class="btn bg-success mt-2 d-flex align-items-center gap-2 text-light ms-auto btnReject"
                                       type="submit">Recommend for Approval<i data-feather="arrow-right"></i></button>
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
                   <div class="modal-header">
                       <h5 class="modal-title">Reject</h5>
                   </div>
                   <div class="modal-body">
                       <div class="modal-toggle-wrapper">
                           <form action="{{ route('oemRegistration.update', $user->id) }}" id="formReject"
                               role="form" method="POST" class='form-horizontal prevent-multiple-submit postForm'
                               accept-charset="utf-8" enctype='multipart/form-data' files=true>
                               @csrf
                               @method('PUT')

                               <input name="status" type="hidden" value="R">
                               <input name="oem_id" type="hidden" value="{{ $user->id }}">
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
       {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
       <script>
              $(document).ready(function() {
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
                $('#formApprove').submit();
            } else {
                // If user clicks cancel, enable the button
                $(this).removeClass('disabled');
                $(this).prop('disabled', false);
            }
        });
    });
});

           //         $('.btnReject').click(function(e) {
           //             if ($(this).hasClass('disabled')) {
           //                 e.preventDefault(); // Prevent default form submission if button is disabled
           //                 return;
           //             }

           //             // Disable the button to prevent multiple submissions
           //             $(this).addClass('disabled');
           //             $(this).prop('disabled', true);

           //             // Submit the form
           //             $('#formReject').submit();
           //         });
           //         $('.prevent-multiple-submit').on('submit', function() {
           //        $(this).find('button[type="submit"]').prop('disabled', true);
           //    });
           //     });
           function setCheckboxValue(checkbox) {
               checkbox.value = checkbox.checked ? 'Yes' : 'No';
           }

           // Initialize the checkbox value on page load
           document.addEventListener('DOMContentLoaded', function() {
               const checkbox = document.getElementById('flexCheckDefault');
               setCheckboxValue(checkbox);
           });
       </script>
       {!! JsValidator::formRequest('App\Http\Requests\PostRegisterApproval', '.postForm') !!}
   @endpush
