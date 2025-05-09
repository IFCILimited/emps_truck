<!-- resources/views/application.blade.php -->

@extends('layouts.e_truck_dashboard_master')

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
                        <h4>User Registration</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('e-trucks.manageUser.store') }}" id="creUser" role="form" method="POST"
                        class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class=" row">
                                    <div class="col-md-12" style="background-color: #CCCCCC;">
                                        <h5 style="padding: 10px;">User Registration</h5>
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                    <div class="col-md-4">
                                        <label for="dealer_name" class="col-form-label text-md-right">Auth Name<span
                                                class="text-danger">*</span></label>
                                            <input type="text" name="auth_name" value="" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                    <label for="dealer_code" class="col-form-label text-md-right">Email<span
                                            class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="dealer_name" class="col-form-label text-md-right">Mobile<span
                                                class="text-danger">*</span></label>
                                            <input type="number" name="mobile" value="" class="form-control">
                                        </div>

                                      
                                        <div class="col-md-4">
                                            <label for="dealer_name" class="col-form-label text-md-right">Designation<span
                                                    class="text-danger">*</span></label>
                                                <input type="text" name="designation" value="" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dealer_name" class="col-form-label text-md-right">Is Approved<span
                                                    class="text-danger">*</span></label>
                                                    <select class="form-control" name="isapproved" id="">
                                                        <option disabled selected>Select</option>
                                                        <option value="Y">Yes</option>
                                                        <option value="N">No</option>
                                                    </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dealer_name" class="col-form-label text-md-right">Is Active<span
                                                    class="text-danger">*</span></label>
                                                    <select class="form-control" name="isactive" id="">
                                                        <option disabled selected>Select</option>
                                                        <option value="Y">Yes</option>
                                                        <option value="N">No</option>
                                                    </select>
                                        </div>
                                </div>
                              
                                
                                
                                
                                
                                
                                
                                
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="col-md-4 text-left">
                                <a href="{{ route('e-trucks.manageUser.index') }}" class="btn btn-warning">Back</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Application</button>
                            </div>
                        </div>
                        
                    </form>
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
     $('#email').on('blur', function() {
                var email = $(this).val();
 
                // Send AJAX request to the server to check if the email exists
                $.ajax({
                    type: 'POST',
                    url: '{{ route('check.email') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'email': email
                    },
                    success: function(response) {
                        if (response.exists) {
                            // Email exists, show error message or take appropriate action
                            $('#email').val('')
                            alert('Email already exists!');
                        }
                    }
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
           }, 10000); // 25 seconds in milliseconds
       });
   });
</script>
@endpush
