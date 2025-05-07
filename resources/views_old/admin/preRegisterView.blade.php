   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - OEM Pre-Registration
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
                           <h4>OEM Pre-Registration</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="index.html">
                                       <svg class="stroke-icon">
                                           <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage OEM</li>
                               <li class="breadcrumb-item active">OEM Pre-Registration</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <!-- Container-fluid starts-->
           <div class="container-fluid">
               <div class="row">
                   <div class="col-sm-12">
                       <div class="card">
                           {{-- <div class="card-header pb-0 card-no-border">
                    <h4>HTML5 Export Buttons</h4>
                  </div> --}}
                           <div class="card-body">
                               <div class="row g-2">
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM Name:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text" value="{{ $user->name }}">

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
                                           <input class="form-control readonly" readonly type="text" value="{{ $user->address }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM Pincode:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text" value="{{ $user->pincode }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM State:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text" value="{{ $user->state }}"
                                               readonly>

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM District:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text" value="{{ $user->district }}"
                                               readonly>

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">OEM City:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text" value="{{ $user->city }}">

                                       </div>
                                   </div>

                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Contact Person Name:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_name }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Contact Person Designation:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->auth_designation }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Mobile No.:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text" value="{{ $user->mobile }}">

                                       </div>
                                   </div>
                                   <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">E-Mail:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text" value="{{ $user->email }}">

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
                                           <label class="col-form-label pt-0">Company Registration No:<span
                                                   class="text-danger">*</span></label>
                                           <input class="form-control readonly" readonly type="text"
                                               value="{{ $user->registration_no }}">
                                       </div>
                                   </div>
                                 {{--  <div class="col-4">
                                       <div class="form-group">
                                           <label class="col-form-label pt-0">Company Registration Certificate
                                               No.:<span class="text-danger">*</span></label>
                                               <a class="mt-2 btn btn-success btn-sm"
                                               href="{{ route('doc.down', encrypt($user->registration_certificate_upload_id)) }}">
                                               <i class="fa fa-download"></i>  View Document
                                            </a>
                                       </div>
                                   </div>--}}
                                @if (is_null($user->approval_for_post_reg) || $user->approval_for_post_reg=='')
                                    @if(Auth::user()->hasRole('MHI-DS'))
                                    <div class="col-4 offset-4  d-flex mt-4">
                                        <button type="button" class="btn btn-sm btn-success btnApp mx-1 submit-button">Approve</button>
                                        <form action="{{ route('PreApproveReject') }}" id="formApprove"
                                            role="form" method="POST" class='form-horizontal prevent-multiple-submit' accept-charset="utf-8"
                                            enctype='multipart/form-data' files=true>
                                            @csrf
                                            <input name="status" type="hidden" value="A">
                                            <input name="oem_id" type="hidden" value="{{ $user->id }}">
                                        </form>
                                        <button class="btn btn-sm btn-danger mx-1" type="button" data-bs-toggle="modal"
                                            data-original-title="test" data-bs-target="#reject">Reject</button>
                                    </div>
                                    @endif
                                @else
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Pre-Registration Status :</label>
                                        <span>
                                            <input class="form-control readonly" readonly type="text"
                                             value="{{ $user->approval_for_post_reg == 'A' ? 'Approved' : 'Reject ( Reason :: ' . $user->approval_remark . ')' }}"> 
                                        </span>
                                    </div>
                                </div>
                                @endif
                                  
                               </div>
                           </div>
                        </div>
                        <div class="col-4">
                         <a href="{{ route('oemRegistration.index') }}" class="btn btn-warning">Back</a>
                     </div>
                   </div>
               </div>
           </div>
           <!-- Container-fluid Ends-->
       </div>
       <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="reject"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-body">
                       <div class="modal-toggle-wrapper">
                           <form action="{{ route('PreApproveReject') }}" id="formReject" role="form"
                               method="POST" class='form-horizontal prevent-multiple-submit' accept-charset="utf-8"
                               enctype='multipart/form-data' files=true>
                               @csrf
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
                                       type="submit">Reject<i
                                           data-feather="arrow-right"></i></button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   @endsection
   @push('scripts')
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
       <script>
        $(document).ready(function() {
            $('.btnApp').click(function(e) {
                if ($(this).hasClass('disabled')) {
                    e.preventDefault(); // Prevent default form submission if button is disabled
                    return;
                }
    
                // Disable the button to prevent multiple submissions
                $(this).addClass('disabled');
                $(this).prop('disabled', true);
    
                // Submit the form
                $('#formApprove').submit();
            });
    
            $('.btnReject').click(function(e) {
                if ($(this).hasClass('disabled')) {
                    e.preventDefault(); // Prevent default form submission if button is disabled
                    return;
                }
    
                // Disable the button to prevent multiple submissions
                $(this).addClass('disabled');
                $(this).prop('disabled', true);
    
                // Submit the form
                $('#formReject').submit();
            });

            $('.prevent-multiple-submit').on('submit', function() {
           $(this).find('button[type="submit"]').prop('disabled', true);
       });
        });
    </script>
   @endpush
