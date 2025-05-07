   <!-- Nav Bar Ends here -->
   @extends('layouts.e_truck_dashboard_master')
   @section('title')
       Request- Bank Detail
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
                           <h4>Bank Detail</h4>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid">
               <div class="row">
                   <div class="col-sm-12">
                       <form action="{{ route('e-trucks.bankDetails.store') }}" id="plant" role="form" method="POST"
                           class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                           @csrf
                           <div class="card">
                               <div class="card-body">
                                   <div class="row g-3">
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0">IFSC Code<span
                                          class="text-danger">*</span></label>
                                        <input class="form-control" type="text"
                                          placeholder="IFSC Code" value="{{$bankDetail->ifsc_code}}" name="ifsc_code">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0">Account Holder
                                        Name<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text"
                                          placeholder="Account Holder Name"
                                          name="account_holder_name" value="{{$bankDetail->account_holder_name}}">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0">Name of
                                        Bank<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text"
                                          placeholder="Name of Bank" value="{{$bankDetail->bank_name}}" name="bank_name">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0">Name of
                                        Branch<span
                                          class="text-danger">*</span></label>
                                        <input class="form-control" type="text"
                                          placeholder="Name of Branch"
                                          name="branch_name" value="{{$bankDetail->branch_name}}">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0">Address<span
                                          class="text-danger">*</span></label>
                                        <input class="form-control" type="text"
                                          placeholder="Address" value="{{$bankDetail->branch_address}}" name="bank_address">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0">Pincode.<span
                                          class="text-danger">*</span></label>
                                        <input class="form-control" type="number"
                                          placeholder="Branch Pincode."
                                          onkeyup="GetCityByPinCode('bank', this.value, 0)"
                                          name="branch_pincode" value="{{$bankDetail->branch_pincode}}">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0">State.<span
                                          class="text-danger">*</span></label>
                                        <input class="form-control readonly" readonly
                                          type="text" id="bankAddState0"
                                          placeholder="Branch State"
                                          name="branch_state" value="{{$bankDetail->branch_state}}">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0">District.<span
                                          class="text-danger">*</span></label>
                                        <input class="form-control readonly" readonly
                                          type="text" id="bankAddDistrict0"
                                          placeholder="Branch District"
                                          name="branch_district" value="{{$bankDetail->branch_district}}">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                          <label class="col-form-label pt-0">Branch City<span
                                            class="text-danger">*</span></label>
                                          <input class="form-control" type="text"
                                            placeholder="Branch City" value="{{$bankDetail->branch_city}}" name="branch_city">
                                        </div>
                                      </div>
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0">Branch Name<span
                                          class="text-danger">*</span></label>
                                        <input class="form-control" type="text"
                                          placeholder="Branch Name" value="{{$bankDetail->branch_name}}" name="branch_name">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0">Account No.<span
                                          class="text-danger">*</span></label>
                                        <input class="form-control" type="text"
                                          placeholder="Account No."
                                          name="account_number" value="{{$bankDetail->account_no}}">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0">MICR Code<span
                                          class="text-danger">*</span></label>
                                        <input class="form-control" type="text"
                                          placeholder="MICR Code" name="micr_code" value="{{$bankDetail->micr_code}}">
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="form-group">
                                        <label class="col-form-label pt-0"> Account
                                        Type<span class="text-danger">*</span></label>
                                        <select class="form-control" name="account_type">
                                          <option selected="selected" value="0">
                                            Please select
                                          </option>
                                          <option value="Saving" {{($bankDetail->account_type == 'Saving')?'Selected':''}}>Saving</option>
                                          <option value="Current" {{($bankDetail->account_type == 'Current')?'Selected':''}}>Current</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                               </div>
                           </div>
                           <div class="row">
                            <div class="col-md-4 text-left">
                                <a href="{{ route('e-trucks.bankDetails.index') }}" class="btn btn-warning">Back</a>
                            </div>
                            <div class="col-md-4 text-center">
                              <button type="submit" class="btn btn-info">Update</button>
                            </div>
                        </div>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   @endsection
   @push('scripts')
       {!! JsValidator::formRequest('App\Http\Requests\XrvPlantRequest', '#plant') !!}
       @include('partials.js.pincode')
       <script>
        $(document).ready(function() {
           $('.prevent-multiple-submit').on('submit', function() {
               $(this).find('button[type="submit"]').prop('disabled', true);
               var buttons = $(this).find('button[type="submit"]');
               setTimeout(function() {
                   buttons.prop('disabled', false);
               }, 10000); // 25 seconds in milliseconds
           });
       });
   </script>
   @endpush
