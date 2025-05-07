@extends('layouts.dashboard_master')
@section('title')
   Vahan Details
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>ADV Details</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">ADV Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                            <div>
                                <b>Fetch ADV Details</b>
                            </div>
                            <div>
                                <button id="fetch_token" type="button" class="btn btn-warning">Fetch Recent reference tokens</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12 mb-3">
                                <table class="table table-stripped" id="table_ref_token" style="display: none">
                                 </table>
                            </div>

                            <div class="loader-container" id="loaderContainer">
                                <div class="loader"></div>
                            </div>

                            <form id="claim-form" action="{{ route('adv.fetch.post') }}" role="form" method="post"
                                class="form-horizontal" files=true enctype="multipart/form-data" accept-charset="utf-8">
                                @csrf

                                <div class="form-group row">
                                    <label for="rf_token" class="col-md-3 col-form-label text-md-right"> Reference Token</label>
                                    <div class="col-md-6">
                                        <input type="text" name="rf_token" id="rf_token" class="form-control"
                                            placeholder="Enter Reference Token">
                                    </div>
                                </div>

                                <div class="form-group row mt-2">
                                    <div class="col-md-6 offset-md-4" id="button-container">
                                        <button type="submit" class="btn btn-success btn-sm px-4" id="process-button">Process</button>
                                        <a href="{{ route('dashboard') }}" class="btn btn-danger btn-sm px-4" id="">Exit</a>
                                    </div>
                                </div>
                                
                            </form>
                            @if(isset($aadharFetched))
                                <div class="mt-4">
                                    <h4>AADHAR NUMBER FETCHED: {{$aadharFetched}}</h4>
                                </div>
                            @endif
                            <div class="text-center" id="wait-msg" style="display: none;">
                                <p>Please wait, processing...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#fetch_token').click(function(){
                $.ajax({
                    url: "{{route('adv.fetch.token')}}",
                    type: 'GET',
                    success: function(result){
                        // console.log(result);
                        if(result.length > 0) {
                            let html = `<tr>
                                        <th>Reference Token</th>
                                        <th>Buyer Id</th>
                                    </tr>`;
                            result.forEach(element => {
                                // console.log(element);
                                html+= `<tr><td>${element.rtoken}</td><td>${element.buyer_id}</td></tr>`;
                            });
                            $('#table_ref_token').empty();
                            $('#table_ref_token').append(html);
                            $('#table_ref_token').show();
                        }
                    },
                    error:function(err){
                        console.error(err);
                    }
                });
            })

            $("#process-button").click(function() {
                // Hide all buttons
                $("#button-container").hide();
                // Show "Please wait" message
                $("#wait-msg").show();
            });

            $("#refresh-button").click(function() {
                $("#claim_number").val('');
            });
        });
    </script>
@endpush
