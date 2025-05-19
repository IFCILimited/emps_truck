   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - Claim Processing
   @endsection

   @push('styles')
       <style>
           #preloader {
               position: fixed;
               left: 0;
               top: 0;
               width: 100%;
               height: 100%;
               z-index: 9999;
               background-color: rgba(255, 255, 255, 0.8);
               display: flex;
               align-items: center;
               justify-content: center;
           }

           .loader {
               border: 16px solid #f3f3f3;
               border-top: 16px solid #3498db;
               border-radius: 50%;
               width: 120px;
               height: 120px;
               animation: spin 2s linear infinite;
           }

           @keyframes spin {
               0% {
                   transform: rotate(0deg);
               }

               100% {
                   transform: rotate(360deg);
               }
           }
       </style>
   @endpush
   @section('content')
       <div id="preloader" style="display: none;">
           <div class="loader"></div>
       </div>

       <!-- Page Sidebar Ends-->
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">

                   <div class="row">

                       {{-- <div class="card">
                           <div class="card-body">
                               <form id="filterForm">
                                   <div class="row">
                                       <div class="col-md-4 offset-2">
                                           <label for="select_oem">List of OEM:</label>
                                           <select name="oem" class="form-select" id="select_oem">
                                               <option value="" disabled selected>SELECT</option>
                                               @foreach ($oemDetails as $oem)
                                                   <option value="{{ $oem->oem_id }}"
                                                       {{ isset($oem_user_id) && $oem_user_id == $oem->oem_id ? 'selected' : '' }}>
                                                       {{ strtoupper($oem->oem_name) }}</option>
                                               @endforeach
                                           </select>
                                       </div>
                                       <div class="col-md-4">
                                           <label for="select_seg">List of Segment:</label>
                                           <select name="segment" class="form-select" id="select_seg">
                                               <option value="" disabled selected>SELECT</option>
                                               @foreach ($segMaster as $key => $seg)
                                                   <option value="{{ $key }}"
                                                       {{ isset($segm) && $segm == $key ? 'selected' : '' }}>
                                                       {{ $seg }}</option>
                                               @endforeach
                                           </select>
                                       </div>
                                   </div>
                                   <br>
                                   <div class="row">
                                       <div class="text-center">
                                           <button type="button" id="search" class="btn btn-primary">Search</button>
                                           <button type="reset" class="btn btn-danger btnApp"
                                               id="clear">Clear</button>
                                       </div>
                                   </div>
                               </form>
                           </div>
                       </div> --}}

                       <div class="col-xl-12">
                           <div class="col-6 mb-3">
                               <h4>Claim Evaluation</h4>
                           </div>

                           <div class="col-sm-12 col-xl-12">
                               <div class="card">

                                   <div class="card-body">
                                       <ul class="simple-wrapper nav nav-tabs" id="myTab" role="tablist">

                                           <li class="nav-item"><a class="nav-link active txt-primary" id="auditor-tabs"
                                                   data-bs-toggle="tab" href="#auditor" role="tab"
                                                   aria-controls="auditor"
                                                   aria-selected="true">{{ Auth::user()->hasRole('AUDITOR')
                                                       ? 'With
                                                                                                                                                                                                            Auditor'
                                                       : 'With
                                                                                                                                                                                                            MHI' }}
                                               </a></li>

                                           <li class="nav-item"><a class="nav-link txt-primary" id="auditor2-tabs"
                                                   data-bs-toggle="tab" href="#auditor2" role="tab"
                                                   aria-controls="auditor2"
                                                   aria-selected="auditor2">{{ Auth::user()->hasRole('AUDITOR')
                                                       ? 'With
                                                                                                                                                                                                            PMA'
                                                       : 'With
                                                                                                                                                                                                            PMA' }}
                                               </a></li>

                                       </ul>

                                       <div class="tab-content" id="myTabContent">
                                           <div class="tab-pane fade show active" id="auditor" role="tabpanel"
                                               aria-labelledby="auditor-tabs">
                                               <div class="dt-ext table-responsive  custom-scrollbar mt-5">
                                                   <table class="display table-bordered table-striped" id="table1">
                                                       <thead>
                                                           <tr>
                                                               <th scope="col">S.No.</th>
                                                               <th scope="col">Claim Number</th>
                                                               <th scope="col">OEM Name</th>

                                                               <th scope="col">Number of Vehicle</th>
                                                               <th scope="col">Total incentive Amount</th>
                                                               <th scope="col">PMA Approved Amount</th>
                                                               {{-- <th scope="col">Claim Submitted Date</th> --}}
                                                               <th scope="col">Action</th>
                                                               <th scope="col">Documents</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>

                                                           @if (count($claimMaster) > 0)
                                                               @foreach ($claimMaster as $claim)
                                                                   <tr>
                                                                       @php
                                                                           $sn = $loop->iteration;
                                                                       @endphp
                                                                       <th>{{ $sn }}</th>
                                                                       <td>{{ $claim->claimnumberformat ?? 'NA' }}</td>
                                                                       <td>{{ strtoupper($claim->oemname) ?? 'NA' }}</td>
                                                                       {{-- <td>
                                                                            {{ strtoupper($claim->auditor_name) ?? 'NA' }}
                                                                        </td> --}}
                                                                       <td>{{ $claim->count ?? 'NA' }}</td>
                                                                       <td>{{ $claim->approved_incentive ?? 'NA' }}</td>
                                                                       <td>{{ $claim->pma_amount ?? 'NA' }}</td>
                                                                       <td>
                                                                           <a href="{{ route('claimEvaluation.buyDetailView', encrypt($claim->claim_id)) }}"
                                                                               class="btn btn-sm btn-warning">View</a>
                                                                       </td>
                                                                       {{-- @if ($claim->claim_doc_status == 'A')
                                                                           <td>
                                                                            <a href="{{ route('claimUploadDoc', encrypt($claim->claim_id)) }}"
                                                                                   class="btn btn-sm btn-success">View
                                                                                   Documents</a>
                                                                           </td>
                                                                       @else
                                                                           <td>-</td>
                                                                       @endif --}}
                                                                       <td>-</td>
                                                                   </tr>
                                                               @endforeach
                                                           @else
                                                               <td colspan="19" class="text-center">No Data Available
                                                               </td>
                                                           @endif
                                                       </tbody>
                                                   </table>

                                               </div>
                                           </div>

                                           <div class="tab-pane fade" id="auditor2" role="tabpanel"
                                               aria-labelledby="auditor2-tabs">
                                               <div class="dt-ext table-responsive  custom-scrollbar mt-5">
                                                   <table class="display table-bordered table-striped" id="table2">
                                                       <thead>
                                                           <tr>
                                                               <th scope="col">S.No.</th>
                                                               <th scope="col">Claim Number</th>
                                                               <th scope="col">OEM Name</th>

                                                               <th scope="col">Number of Vehicle</th>
                                                               <th scope="col">Total incentive Amount</th>
                                                               <th scope="col">PMA Approved Amount</th>
                                                               {{-- <th scope="col">Claim Submitted Date</th> --}}
                                                               <th scope="col">Action</th>
                                                               <th scope="col">Documents</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>

                                                           @if (count($claimMaster1) > 0)
                                                               @foreach ($claimMaster1 as $claim)
                                                                   <tr>
                                                                       @php
                                                                           $sn = $loop->iteration;
                                                                       @endphp
                                                                       <th>{{ $sn }}</th>
                                                                       <td>{{ $claim->claimnumberformat ?? 'NA' }}</td>
                                                                       <td>{{ strtoupper($claim->oemname) ?? 'NA' }}</td>
                                                                       {{-- <td>
                                                                            {{ strtoupper($claim->auditor_name) ?? 'NA' }}
                                                                        </td> --}}
                                                                       <td>{{ $claim->count ?? 'NA' }}</td>
                                                                       <td>{{ $claim->approved_incentive ?? 'NA' }}</td>
                                                                       <td>{{ $claim->pma_amount ?? 'NA' }}</td>
                                                                       <td>
                                                                           <a href="{{ route('claimEvaluation.buyDetailView', encrypt($claim->claim_id)) }}"
                                                                               class="btn btn-sm btn-warning">View</a>
                                                                       </td>
                                                                       {{-- @if ($claim->claim_doc_status == 'A')
                                                                           <td>
                                                                            <a href="{{ route('claimUploadDoc', encrypt($claim->claim_id)) }}"
                                                                                   class="btn btn-sm btn-success">View
                                                                                   Documents</a>
                                                                           </td>
                                                                       @else
                                                                           <td>-</td>
                                                                       @endif --}}
                                                                       <td>-</td>
                                                                   </tr>
                                                               @endforeach
                                                           @else
                                                               <td colspan="19" class="text-center">No Data Available
                                                               </td>
                                                           @endif
                                                       </tbody>
                                                   </table>

                                               </div>
                                           </div>
                                       </div>
                                   </div>
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
               $("#table1").DataTable({
                   dom: "Bfrtip",
                   buttons: ["csvHtml5"],
                   pageLength: 2000,
                   order: [] // Disable initial sorting
               });

           });

           $(document).ready(function() {
               $("#table2").DataTable({
                   dom: "Bfrtip",
                   buttons: ["csvHtml5"],
                   pageLength: 2000,
                   order: [] // Disable initial sorting
               });

           });
       </script>
   @endpush
