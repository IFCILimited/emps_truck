<!-- resources/views/application.blade.php -->

@extends('layouts.dashboard_master')

@section('title', 'OEM - Dealer Application')
@push('styles')
    <style>
        .help-block {
            color: red;
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Claim Documents</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if($claimDoc->claim_doc_status == null)
                    <form action="{{ route('claimDocStore') }}" id="creUser" role="form" method="POST"
                        class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class=" row">
                                    <div class="col-md-12" style="background-color: #CCCCCC;">
                                        <h5 style="padding: 10px;">Upload Documents For Claim</h5>
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <input type="hidden" name="claimid" value="{{ $claimid }}">
                                    <div class="col-md-6">
                                        <label for="dealer_name" class="col-form-label text-md-right">Undertaking as per Annexure 3<span
                                                class="text-danger">*</span></label>
                                            <input type="file" name="uadoc_id" value="" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                    <label for="dealer_code" class="col-form-label text-md-right">Integrity Part A as Per Annexure 7<span
                                            class="text-danger">*</span></label>
                                            <input type="file" name="ipa_id" value="" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dealer_name" class="col-form-label text-md-right">Integrity Part B as Per Annexure 8<span
                                                class="text-danger">*</span></label>
                                                <input type="file" name="ipb_id" value="" class="form-control">
                                        </div>

                                      
                                        <div class="col-md-6">
                                            <label for="dealer_name" class="col-form-label text-md-right">Deed of Indemnity Cum Undertaking as Per Annexure 9 <span
                                                    class="text-danger">*</span></label>
                                                    <input type="file" name="didcu_id" value="" class="form-control">
                                        </div>
                                        
                                </div>
                              
                                
                                
                                
                                
                                
                                
                                
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="col-md-4 text-left">
                                <a href="{{ route('claimSubmitted') }}" class="btn btn-warning">Back</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Application</button>
                            </div>
                        </div>
                        
                    </form>
                    @elseif($claimDoc->claim_doc_status == 'D')
                    <form action="{{ route('claimDocUpdate') }}" id="creUser" role="form" method="POST"
                        class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class=" row">
                                    <div class="col-md-12" style="background-color: #CCCCCC;">
                                        <h5 style="padding: 10px;">Edit/Replace Documents For Claim</h5>
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <input type="hidden" name="claimid" value="{{ $claimid }}">
                                    <div class="col-md-4">
                                        <label for="dealer_name" class="col-form-label text-md-right">Undertaking as per Annexure 3<span
                                                class="text-danger">*</span></label>
                                            <input type="file" name="uadoc_id" value="" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <a class="mt-2 btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($claimDoc->uadoc_id)) }}">
                                                <i class="fa fa-download"></i>  View Document
                                             </a>
                                    </div>
                                    <div class="col-md-4">
                                    <label for="dealer_code" class="col-form-label text-md-right">Integrity Part A as Per Annexure 7<span
                                            class="text-danger">*</span></label>
                                            <input type="file" name="ipa_id" value="" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <a class="mt-2 btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($claimDoc->ipa_id)) }}">
                                                <i class="fa fa-download"></i>  View Document
                                             </a>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="dealer_name" class="col-form-label text-md-right">Integrity Part B as Per Annexure 8<span
                                                class="text-danger">*</span></label>
                                                <input type="file" name="ipb_id" value="" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <a class="mt-2 btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($claimDoc->ipb_id)) }}">
                                                    <i class="fa fa-download"></i>  View Document
                                                 </a>
                                        </div>
                                      
                                        <div class="col-md-4">
                                            <label for="dealer_name" class="col-form-label text-md-right">Deed of Indemnity Cum Undertaking as Per Annexure 9 <span
                                                    class="text-danger">*</span></label>
                                                    <input type="file" name="didcu_id" value="" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <a class="mt-2 btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($claimDoc->didcu_id)) }}">
                                                    <i class="fa fa-download"></i>  View Document
                                                 </a>
                                        </div>
                                        
                                </div>
                              
                                
                                
                                
                                
                                
                                
                                
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="col-md-4 text-left">
                                <a href="{{ route('claimSubmitted') }}" class="btn btn-warning">Back</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Documents</button>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="button" class="btn btn-success btnApp"><i class="fa fa-save"></i> Final Submit</button>
                            </div>
                        </div>
                        
                    </form>
                    @elseif($claimDoc->claim_doc_status == 'A')
                    @if(AUTH::USER()->hasRole('PMA|MHI-AS|MHI-DS'))
                    <form action="{{ route('revertClaimDoc') }}" id="formReject" role="form" method="POST"
                        class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                     @else
                        <form>   
                      @endif
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class=" row">
                                    
                                    <div class="col-md-12" style="background-color: #CCCCCC;">
                                        <h5 style="padding: 10px;">Documents For Claim</h5>
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <input type="hidden" name="claimid" value="{{ $claimid }}">
                                    
                                    <div class="col-md-6">
                                        <label for="dealer_name" class="text-md-right">Undertaking as per Annexure 3</label><br>
                                        <a class="mt-2 btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($claimDoc->uadoc_id)) }}">
                                                <i class="fa fa-download"></i>  View Document
                                             </a>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="dealer_code" class="col-form-label text-md-right">Integrity Part A as Per Annexure 7</label><br>
                                        <a class="mt-2 btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($claimDoc->ipa_id)) }}">
                                                <i class="fa fa-download"></i>  View Document
                                             </a>
                                    </div>
                                  
                                        <div class="col-md-6">
                                            <label for="dealer_code" class="col-form-label text-md-right">Integrity Part B as Per Annexure 8</label><br>
                                            <a class="mt-2 btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($claimDoc->ipb_id)) }}">
                                                    <i class="fa fa-download"></i>  View Document
                                                 </a>
                                        </div>
                                      
                                       
                                        <div class="col-md-6">
                                            <label for="dealer_name" class="col-form-label text-md-right">Deed of Indemnity Cum Undertaking as Per Annexure 9 </label><br>
                                            <a  class="mt-2 btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($claimDoc->didcu_id)) }}">
                                                    <i class="fa fa-download"></i>  View Document
                                                 </a>
                                        </div>
                                        
                                </div>
                              
                                
                                
                                
                                
                                
                                
                                
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="col-md-4 text-left">
                                <a href="{{ url()->previous() }}" class="btn btn-warning">Back</a>
                            </div>
                            @if(AUTH::USER()->hasRole('PMA|MHI-AS|MHI-DS'))
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-info btnRev"><i class="fa fa-save"></i> Revert To OEM</button>
                            </div>
                            @endif
                            {{-- <div class="col-md-4 text-center">
                                <button type="button" class="btn btn-success btnApp"><i class="fa fa-save"></i> Final Submit</button>
                            </div> --}}
                        </div>
                        
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreUserDataRequest', '#creUser') !!}
@include('partials.js.pincode')
@include('partials.js.prevent')

<script>
    $(document).ready(function() {
       $('.prevent-multiple-submit').on('submit', function() {
           $(this).find('button[type="submit"]').prop('disabled', true);
           var buttons = $(this).find('button[type="submit"]');
           setTimeout(function() {
               buttons.prop('disabled', false);
           }, 10000); // 25 seconds in milliseconds
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
                var link = '/claimDocSubmit/' + {{$claimid}};
                window.location.href = link;
                // $('#formReject').submit();
            } else {
                // If user clicks cancel, enable the button
                $(this).removeClass('disabled');
                $(this).prop('disabled', false);
            }
        });
    });

    $('.btnRev').click(function(e) {
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
                
                $('#formReject').submit();
            } else {
                // If user clicks cancel, enable the button
                $(this).removeClass('disabled');
                $(this).prop('disabled', false);
            }
        });
    });

   });
</script>
@endpush
