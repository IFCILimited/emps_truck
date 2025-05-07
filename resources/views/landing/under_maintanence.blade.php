<!-- Nav Bar Ends here -->
@extends('layouts.master')
@section('title')
    Dashboard - PM E-DRIVE
@endsection
@push('styles')
    <style>
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000 !important;
        }

        .table-container {
            width: 80%;
            margin: 0 auto;
            padding-left: 10%;
            padding-right: 10%;
        }
        .card-wrapper {
            border: 1px solid #007bff;
            border-radius: 56px;
            padding: 12px;
            margin: 20px 89px;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/style1.css') }}">
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
                            <h1 class="text-custom-white lh-default fw-600">Sales Dashboard</h1>
                            <ul class="custom">
                                <li> <a href="/" class="text-custom-white">Home</a>
                                </li>
                                <li class="text-custom-white active">Sales Segment Wise </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class=" parallax mt-20 mb-xl-30">
    <div class="card-wrapper">
        <div class="card-body">
            <span class="text-primary" style="font-size: 20px">This page is under maintenance</span>    
        </div>    
    </div>
    @endsection
