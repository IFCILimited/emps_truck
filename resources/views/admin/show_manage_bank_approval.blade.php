   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Request- Bank Details
   @endsection

   @push('styles')
   @endpush
   @section('content')
       <style>
           .form-control {
               background: #e9ecef;
           }
       </style>
       <!-- Page Sidebar Ends-->
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4>Bank Details </h4>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid">
               <div class="row">
                   <div class="col-sm-12">
                       <form action="{{ route('bankApproval.update', $bankDetail->id) }}" id="plant" role="form"
                           method="POST" class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                           accept-charset="utf-8">
                           @csrf
                           @method('patch')
                           <div class="card">
                               <div class="card-body">
                                   <div class="row g-3">
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">IFSC Code<span
                                                       class="text-danger">*</span></label>
                                               <input class="form-control" type="text" placeholder="IFSC Code"
                                                   value="{{ $bankDetail->ifsc_code }}" name="ifsc_code" readonly>
                                           </div>
                                       </div>
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">Account Holder
                                                   Name<span class="text-danger">*</span></label>
                                               <input class="form-control" type="text" placeholder="Account Holder Name"
                                                   name="account_holder_name" value="{{ $bankDetail->account_holder_name }}"
                                                   readonly>
                                           </div>
                                       </div>
                                       <input type="hidden" name="user_id_hidden" value="{{ $bankDetail->user_id }}">
                                       <input type="hidden" name="id_hidden" value="{{ $bankDetail->id }}">
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">Name of
                                                   Bank<span class="text-danger">*</span></label>
                                               <input class="form-control" type="text" placeholder="Name of Bank"
                                                   value="{{ $bankDetail->bank_name }}" name="bank_name" readonly>
                                           </div>
                                       </div>
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">Name of
                                                   Branch<span class="text-danger">*</span></label>
                                               <input class="form-control" type="text" placeholder="Name of Branch"
                                                   name="branch_name" value="{{ $bankDetail->branch_name }}" readonly>
                                           </div>
                                       </div>
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">Address<span
                                                       class="text-danger">*</span></label>
                                               <input class="form-control" type="text" placeholder="Address"
                                                   value="{{ $bankDetail->branch_address }}" name="branch_address" readonly>
                                           </div>
                                       </div>
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">Pincode.<span
                                                       class="text-danger">*</span></label>
                                               <input class="form-control" type="number" placeholder="Branch Pincode."
                                                   onkeyup="GetCityByPinCode('bank', this.value, 0)" name="branch_pincode"
                                                   value="{{ $bankDetail->branch_pincode }}" readonly>
                                           </div>
                                       </div>
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">State.<span
                                                       class="text-danger">*</span></label>
                                               <input class="form-control readonly" readonly type="text"
                                                   id="bankAddState0" placeholder="Branch State" name="branch_state"
                                                   value="{{ $bankDetail->branch_state }}" readonly>
                                           </div>
                                       </div>
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">District.<span
                                                       class="text-danger">*</span></label>
                                               <input class="form-control readonly" readonly type="text"
                                                   id="bankAddDistrict0" placeholder="Branch District"
                                                   name="branch_district" value="{{ $bankDetail->branch_district }}"
                                                   readonly>
                                           </div>
                                       </div>
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">Branch City<span
                                                       class="text-danger">*</span></label>
                                               <input class="form-control" type="text" placeholder="Branch City"
                                                   value="{{ $bankDetail->branch_city }}" name="branch_city" readonly>
                                           </div>
                                       </div>
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">Branch Name<span
                                                       class="text-danger">*</span></label>
                                               <input class="form-control" type="text" placeholder="Branch Name"
                                                   value="{{ $bankDetail->branch_name }}" name="branch_name" readonly>
                                           </div>
                                       </div>
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">Account No.<span
                                                       class="text-danger">*</span></label>
                                               <input class="form-control" type="text" placeholder="Account No."
                                                   name="account_no" value="{{ $bankDetail->account_no }}" readonly>
                                           </div>
                                       </div>
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0">MICR Code<span
                                                       class="text-danger">*</span></label>
                                               <input class="form-control" type="text" placeholder="MICR Code"
                                                   name="micr_code" value="{{ $bankDetail->micr_code }}" readonly>
                                           </div>
                                       </div>
                                       <div class="col-4">
                                           <div class="form-group">
                                               <label class="col-form-label pt-0"> Account
                                                   Type<span class="text-danger">*</span></label>
                                               <select class="form-control" name="account_type" readonly>
                                                   <option selected="selected" value="0">
                                                       Please select
                                                   </option>
                                                   <option value="Saving"
                                                       {{ $bankDetail->account_type == 'Saving' ? 'Selected' : '' }}>Saving
                                                   </option>
                                                   <option value="Current"
                                                       {{ $bankDetail->account_type == 'Current' ? 'Selected' : '' }}>Current
                                                   </option>
                                               </select>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="col-12 text-center">
                               <a href="{{ route('bankApproval.index') }}" class="btn btn-warning">Back</a>
                               <button type="submit" class="btn btn-info btn-approve">Approve</button>
                               <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                   data-original-title="test" data-bs-target="#reject">Reject</button>
                           </div>
                       </form>
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
                           <form action="{{ route('bankApproval.update', $bankDetail->id) }}" id="formReject"
                               role="form" method="POST" class='form-horizontal prevent-multiple-submit modelVer' accept-charset="utf-8"
                               enctype='multipart/form-data' files=true>
                               @csrf
                               @method('patch')
                               <input name="status" type="hidden" value="R">
                               <input type="hidden" name="user_id_hidden" value="{{ $bankDetail->user_id }}">
                               <input type="hidden" name="id_hidden" value="{{ $bankDetail->id }}">
                               <div class="row">
                                   <div class="col-12">
                                       <label>Remarks</label>
                                       <textarea class="form-control" name="mhi_bank_remarks" placeholder="Remarks"></textarea>
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
       {!! JsValidator::formRequest('App\Http\Requests\XrvPlantRequest', '#plant') !!}
       <script>
        $(document).ready(function() {
           $('.prevent-multiple-submit').on('submit', function() {
               $(this).find('button[type="submit"]').prop('disabled', true);
           });
           var buttons = $(this).find('button[type="submit"]');
            setTimeout(function() {
                buttons.prop('disabled', false);
            }, 10000);
       });
   </script>
       @include('partials.js.pincode')
   @endpush
