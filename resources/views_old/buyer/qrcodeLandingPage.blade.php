@extends('layouts.master')

@section('title')
    Home - PM E-DRIVE
@endsection
@push('styles')

<style>
@media screen and (max-width: 480px) {
    .e-voucher-card button.btn {
        white-space: normal;
    }
  }
</style>



@endpush
@section('content')
    <div class="sub-header p-relative">
        <div class="overlay overlay-bg-black"></div>
        <div class="pattern"></div>
        <div class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="sub-header-content p-relative">
                            <h1 class="text-custom-white lh-default fw-600">Verify E-Voucher</h1>
                            {{-- <ul class="custom">
                                <li> <a href="/" class="text-custom-white">Home</a>
                                </li>
                                <li class="text-custom-white active">verify certificate</li>
                            </ul> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- customer_id/e-voucher certificate number
mobile number --->>>check at customer_id id... 
captcha
----> submit -->>otp -- correct verficied --- download signed e-voucher. --}}


    <section class="section-padding about-us-sec p-relative e-voucher-card">
        <div class="container">
            {{-- <div class="col-12 text-right mt-3">
                <button type="button" class="btn btn-primary text-uppercase" data-toggle="modal" data-target="#verifyDoc">
                    Click here to verify your E-Voucher
                </button>
            </div> --}}
            <div class="col-lg-12">
                <strong style="color: #ff8214;text-align: center;font-size: 24px;display: block;">Benefits of EV Adoption Since 01/10/2024</strong>

                <button type="button"  style="display: block;margin: 15px auto 30px;" class="btn btn-primary text-uppercase" data-toggle="modal" data-target="#verifyDoc">
                    Download E-Voucher
                 </button>
            </div>
            

            <div class="row mt-">
                <div class="col-md-4">
                    <div class="card card-1">
                        <div class="card-body">
                            <h5 class="card-title text-center">Models Available</h5>
                            <p class="card-text text-center">1234</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-2">
                        <div class="card-body">
                            <h5 class="card-title text-center">Fuel Saving Per Day (in litre)</h5>
                            <p class="card-text text-center">1234</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-3">
                        <div class="card-body">
                            <h5 class="card-title text-center">Total Saved Fuel (in Ltrs.)</h5>
                            <p class="card-text text-center">1234</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-4">
                        <div class="card-body">
                            <h5 class="card-title text-center">CO2 Reduction per day (in Kg.)</h5>
                            <p class="card-text text-center">1234</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-5">
                        <div class="card-body">
                            <h5 class="card-title text-center">Total Co2 Reduction (in Kg.)</h5>
                            <p class="card-text text-center">1234</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-6">
                        <div class="card-body">
                            <h5 class="card-title text-center">Total Incentive Claimed (In Crores)</h5>
                            <p class="card-text text-center">1234</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center mt-3">
                <button type="button" class="btn btn-primary text-uppercase" data-toggle="modal" data-target="#verifyDoc">
                    Click here to verify your E-Voucher
                </button>
            </div>
        </div>
        <div class="bg-light-white-skew-2 bg-custom-black"></div>
    </section>



    <div class="modal fade" id="verifyDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0070ba">
                    <h5 class="modal-title">Verify E-Voucher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="verify_Cert_form" action="{{route('dealer.check_and_Verify_certificate')}}" method="post">
                    @csrf
                    <div class="modal-body" style="display: block;">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>customer Id/ E-Voucher Certificate Number</label>
                                    <input class="form-control" type="text" name="c_id" placeholder="Enter customer id"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Registered Mobile Number</label><br>
                                    <input class="form-control" type="text" max=10 name="mb_num" placeholder="Enter mobile number"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{-- <label>Captcha</label>
                                    <input class="form-control" type="text" max=10 name="mb_num" placeholder="Enter mobile number"/> --}}
                                    <label>Captcha</label>
                                    <div class="captcha d-flex" >
                                        <span style="width:100%">{!! Captcha::img() !!}</span>
                                        <button type="button" class="btn" style="color: #000000" id="refresh-captcha" >
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                        </button><br>
                                        <input type="text" class="form-control mt-2 " name="captcha" id="captcha" placeholder="Enter captcha">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" id="opt_form" style="display:none">
                                <div class="form-group">
                                    <label>Enter OTP</label>
                                    <input class="form-control" type="text" max=10 name="otp" placeholder="Enter OTP"/>
                                </div>
                            </div>

                        </div>
                        
                        <div class="col-12 form-error text-danger"></div>
                        <div class="col-12 form-message text-success"></div>
                        <div id="doc_link"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="check_btn" type="button" class="btn btn-primary">Check Details</button>
                        <button style="display:none" id="verify_otp_btn" type="button" class="btn btn-primary">Verify OTP</button>
                        <a></a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const reloadCaptcha = function(){
            $.ajax({
                type: 'GET',
                url: '{{ route('refresh.captcha') }}',
                success: function(data) {
                    $('.captcha span').html(data.captcha);
                }
            });
        }
        $('#refresh-captcha').click(function() {
            reloadCaptcha();
        });
        $('#check_btn').on("click", function(){
            $("#check_btn").attr("disabled",true);
            let phoneNumber = $("input[name='mb_num']").val();
            let cust_num = $("input[name='c_id']").val();
            let captcha = $("input[name='captcha']").val();
            console.log(cust_num, phoneNumber);
            if (!cust_num) {
                $('.form-error').text('Customer id is required!');
                $("#check_btn").removeAttr("disabled");
                return;
            }
            $('.form-error').text('');


            if(!phoneNumber || phoneNumber.length != 10){
                $('.form-error').text('Please enter a valid contact number!');
                $("#check_btn").removeAttr("disabled");
                return;
            }
            $('.form-error').text('');

            if (!captcha) {
                $('.form-error').text('Captcha field is required!');
                $("#check_btn").removeAttr("disabled");
                return;
            }
            $('.form-error').text('');


            $('#check_btn').text("Loading...");
            let csrfToken = $('input[name="_token"]').val();
            var formData = new FormData();
            formData.append("c_id", cust_num);
            formData.append("mb_num", phoneNumber);
            formData.append("captcha", captcha);
            $.ajax({
                url: "{{route("dealer.check_and_Verify_certificate")}}",
                method: "POST",
                headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                data: formData,
                processData: false,
                contentType: false,
                success: function(data){
                    if(!data.status) {
                        $('.form-error').text(data.message);
                        reloadCaptcha(); 
                        $("#check_btn").removeAttr("disabled");
                        $('#check_btn').text("Check Details");
                        return;
                    }
                    $('.form-error').text('');
                    $('.form-message').text('The OTP has been sent at the registered mobile number!');

                    $('#check_btn').hide();
                    $('#verify_otp_btn, #opt_form').show();
                    $("input[name='c_id']").attr("readonly", "true");
                    $("input[name='mb_num']").attr("readonly", "true");
                    $("input[name='captcha']").attr("readonly", "true");
                },
                error: function(xhr, status, error) {
                    if('captcha' in xhr.responseJSON.errors){
                        $('.form-error').text('Captcha validation failed!');
                        reloadCaptcha(); 
                        $("#check_btn").removeAttr("disabled");
                        $('#check_btn').text("Check Details");
                        return;
                    }
                    $('.form-error').text('');
                    $("#check_btn").removeAttr("disabled");
                    $('#check_btn').text("Check Details");
                    console.error(error)
                }
            })
        });

        $('#verify_otp_btn').on("click", function(){
            let phoneNumber = $("input[name='mb_num']").val();
            let otp = $("input[name='otp']").val();

            if(otp.length != 6){
                $('.form-error').text('Please enter a valid OTP!');
                return;
            }
            $('.form-error').text('');

            $('#verify_otp_btn').text("Loading...");
            $('#verify_otp_btn').attr("disabled",true);


            let csrfToken = $('input[name="_token"]').val();
            var formData = new FormData();
            formData.append("otp", otp);
            formData.append("mb_num", phoneNumber);
            formData.append("dlr_id", $("input[name='c_id']").val());
            
            $.ajax({
                url: "{{route("dealer.Verify_otp_certificate")}}",
                method: "POST",
                headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                data: formData,
                processData: false,
                contentType: false,
                success: function(data){
                    if(!data.status) {
                        $('.form-error').text(data.message);
                        $('#verify_otp_btn').text("Verify OTP");
                        $('#verify_otp_btn').removeAttr("disabled");
                        return;
                    }
                    $('.form-error').text('');

                    const anchor = document.createElement('a');
                    anchor.href = data.message;
                    anchor.innerText = 'Download File';
                    anchor.classList.add('btn');
                    anchor.classList.add('btn-primary');
                    $('#doc_link').append(anchor);

                    $("input[name='otp']").attr("readonly", "true");
                    $(".modal-footer").hide();
                    
                    $('.form-message').text('Verified successfully!');

                    $('#verify_otp_btn').text("Verify OTP");
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#verify_otp_btn').text("Verify OTP");
                    $('#verify_otp_btn').removeAttr("disabled");
                }
            })
        });
    </script>
@endpush


