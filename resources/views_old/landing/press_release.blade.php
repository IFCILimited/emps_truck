@extends('layouts.master')
@section('title')
Press-Release - {{ env('APP_NAME')}}
@endsection
@push('styles')
@endpush
@section('content')
    <!-- Start Subheader -->
    <div class="sub-header p-relative">
        <div class="overlay overlay-bg-black"></div>
        <div class="pattern"></div>
        <div class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="sub-header-content p-relative">
                            <h1 class="text-custom-white lh-default fw-600">Press-Release </h1>
                            <ul class="custom">
                                <li> <a href="/" class="text-custom-white">Home</a>
                                </li>
                                <li class="text-custom-white active">Press-Release </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Subheader -->
    <!-- start aboutus -->
    <section class=" parallax mt-20 mb-xl-30">
      
        <div class="container">
            {{-- <div class="section-header">
                <div class="section-heading">
                    <h3 class="text-custom-black fw-700">Press-Release
                    </h3>
                </div>
            </div> --}}
            <div class="row">

                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="lw-tab-table">
                            <tbody>
                                <tr class="lw-table-row-1">
                                    <th>S.No.</th>
                                    <th>Document Name/Title</th>
                                    <th>Released On</th>
                                    <th>Download Document</th>
                                    
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">1</td>
                                    <td class="lw-table-data-2">
                                       <strong>({{ env('APP_NAME')}} 2024) </strong>
                                    </td>
                                    <td style="text-align: center;" class="lw-table-data-3">
                                        <strong>11th September, 2024</strong>
                                    </td>
                                    <td style="text-align: center;" class="lw-table-data-4">
                                        <strong> <a href="/docs/press_release/Press Release_Press Information Bureau.pdf" target="_blank">
                                            <i class="nav-icon fa fa-download" title="Download"></i>
                                        </a></strong>
                                    </td>
                                   
                                </tr>
                                {{-- <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">2</td>
                                    <td class="lw-table-data-2">
                                       <strong>Extension of {{ env('APP_NAME')}} 2024 by 2 Months till 30th September, 2024 </strong>
                                    </td>
                                    <td style="text-align: center;" class="lw-table-data-3">
                                        <strong>26 July, 2024</strong>
                                    </td>
                                    <td style="text-align: center;" class="lw-table-data-4">
                                        <strong> <a href="https://pib.gov.in/PressReleasePage.aspx?PRID=2037735" target="_blank">
                                            <i class="nav-icon fa fa-download" title="Download"></i>
                                        </a></strong>
                                    </td>
                                   
                                </tr> --}}
                                
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--About-two-section-end-->
@endsection
