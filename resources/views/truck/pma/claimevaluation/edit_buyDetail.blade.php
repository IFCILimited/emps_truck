   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - Claim Processing
   @endsection

   @push('styles')
       <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

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
                       <div class="col-xl-12">
                           <div class="col-6 mb-3">
                               <h4>Claim Evaluation Details</h4>
                           </div>

                           @if (Auth::user()->hasRole('AUDITOR'))
                               <div class="card mb-3">
                                   <div class="card-header">
                                       <h5 class="mb-0">Upload CSV File</h5>
                                   </div>
                                   <div class="card-body">
                                       <a href="{{ asset('docs/claim_evl_format/claim_evl_format.xlsx') }}"
                                           class="btn btn-success mt-3" download="claim_evl_format.xlsx">Download Format</a>
                                       <form action="{{ route('e-trucks.claimEvaluation.update', encrypt($claimId)) }}"
                                           method="POST" enctype="multipart/form-data">
                                           {!! method_field('PATCH') !!}
                                           @csrf
                                           <div class="mb-3">
                                               <label for="csv_file" class="form-label">Select CSV File</label>
                                               <input type="file" class="form-control" id="csv_file" name="csv_file"
                                                   accept=".csv" required>
                                           </div>
                                           <button type="submit" class="btn btn-primary">CSV Upload</button>
                                       </form>
                                   </div>
                               </div>
                           @endif


                           <div class="col-sm-12 col-xl-12">

                               <form action="{{ route('e-trucks.claimEvaluation.edit', encrypt($claimId)) }}" id="plant"
                                   role="form" method="POST" class='form-horizontal modelVer prevent-multiple-submit'
                                   files=true enctype='multipart/form-data' accept-charset="utf-8">
                                   {!! method_field('GET') !!}
                                   @csrf
                                   <div class="card">
                                       <div class="card-header">

                                       </div>
                                       <div class="card-body">
                                           <div class="dt-ext table-responsive  custom-scrollbar">
                                               <table class="display table-bordered table-striped" id="export-button">
                                                   <thead>
                                                       <tr>
                                                           <th scope="col">S.No.</th>
                                                           <th scope="col">Claim Number</th>
                                                           <th scope="col">OEM Name</th>
                                                           <th scope="col">Segment Name</th>
                                                           <th scope="col">Vin chassis</th>
                                                           <th scope="col">Claim Amount</th>
                                                           <th scope="col">System Amount</th>
                                                           <th scope="col">System Status</th>
                                                           <th scope="col">System Remark</th>

                                                           <th scope="col" style="white-space: nowrap">PMA Approved
                                                               Amount</th>
                                                           <th scope="col">PMA Status</th>
                                                           <th scope="col">PMA Remark</th>
                                                           @if (Auth::user()->hasRole('AUDITOR'))
                                                               <th scope="col" style="white-space: nowrap">Auditor
                                                                   Approved
                                                                   Amount</th>
                                                               <th scope="col">Auditor Status</th>
                                                               <th scope="col">Auditor Remark</th>
                                                           @endif
                                                           @if (Auth::user()->hasRole('MHI-AS') || Auth::user()->hasRole('MHI-DS') || Auth::user()->hasRole('MHI-OnlyView'))
                                                               <th scope="col" style="white-space: nowrap">MHI Approved
                                                                   Amount</th>
                                                               <th scope="col">MHI Status</th>
                                                               <th scope="col">MHI Remark</th>
                                                           @endif

                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                       @if (count($aprvl_data) > 0)
                                                           @foreach ($aprvl_data_vw as $buyerDetail)
                                                               <tr>
                                                                   @php
                                                                       $sn = $loop->iteration;
                                                                   @endphp
                                                                   <th>{{ $sn }}</th>
                                                                   <td>{{ $buyerDetail->claim_no ?? 'NA' }}</td>
                                                                   <td>{{ strtoupper($buyerDetail->oemname) ?? 'NA' }}</td>
                                                                   <td>{{ $buyerDetail->vehicle_segment ?? 'NA' }}</td>
                                                                   <td>{{ $buyerDetail->vin_chassis_no ?? 'NA' }}</td>
                                                                   <td>{{ $buyerDetail->eligible_incentive ?? 'NA' }}</td>
                                                                   <td>{{ $buyerDetail->approved_incentive ?? 'NA' }}</td>
                                                                   <td>{{ $buyerDetail->status ?? 'NA' }}</td>
                                                                   <td>{{ $buyerDetail->remark ?? 'NA' }}</td>
                                                                   @if (Auth::user()->hasRole('PMA') || Auth::user()->hasRole('AUDITOR'))
                                                                       <td>
                                                                           <input type="text"
                                                                               name="data[{{ $sn }}][approved_amt]"
                                                                               {{-- value="{{ $buyerDetail->pma_amount }}" --}}
                                                                               value="{{ $buyerDetail->pma_amount == null ? $buyerDetail->eligible_incentive : $buyerDetail->pma_amount }}"
                                                                               class="form-control-sm"
                                                                               placeholder="PMA Approved Amount"
                                                                               id="pmaApproved"
                                                                               data-old-value="{{ $buyerDetail->pma_amount == null ? $buyerDetail->eligible_incentive : $buyerDetail->pma_amount }}">
                                                                       </td>
                                                                       {{-- @elseif(Auth::user()->hasRole('MHI-AS') || Auth::user()->hasRole('MHI-DS') || Auth::user()->hasRole('MHI-OnlyView'))
                                                                       <td><input type="text"
                                                                               name="data[{{ $sn }}][pma_approved_amt]"
                                                                               readonly
                                                                               value="{{ $buyerDetail->pma_approved_amt == null ? $buyerDetail->eligible_incentive : $buyerDetail->pma_approved_amt }}"
                                                                               class="form-control-sm readonly"
                                                                               placeholder="PMA Approved Amount"
                                                                               id=""></td>
                                                                       <td><input type="text"
                                                                               name="data[{{ $sn }}][mhi_approved_amt]"
                                                                               value="{{ $buyerDetail->mhi_approved_amt == null ? $buyerDetail->pma_approved_amt : $buyerDetail->mhi_approved_amt }}"
                                                                               class="form-control-sm" id=""
                                                                               data-mhi-value="{{ $buyerDetail->mhi_approved_amt == null ? $buyerDetail->pma_approved_amt : $buyerDetail->mhi_approved_amt }}">
                                                                       </td> --}}
                                                                   @endif
                                                                   @if (Auth::user()->hasRole('PMA') || Auth::user()->hasRole('AUDITOR'))
                                                                       <td>
                                                                           <select class="form-select"
                                                                               name="data[{{ $sn }}][pma_status]"
                                                                               onchange="upVal(this)" style="width: 100px;">
                                                                               <option value="" disabled
                                                                                   {{ empty($buyerDetail->pma_status) ? 'selected' : '' }}>
                                                                                   Please Select
                                                                               </option>
                                                                               @foreach ($status as $stat)
                                                                                   <option
                                                                                       value="{{ $stat->id }}|{{ $stat->name }}"
                                                                                       {{ $stat->id == $buyerDetail->pma_status_id ? 'selected' : '' }}>
                                                                                       {{ $stat->name }}
                                                                                   </option>
                                                                               @endforeach
                                                                           </select>

                                                                       </td>
                                                                       <td>
                                                                           {{-- <select class="form-select"
                                                                               name="data[{{ $sn }}][pma_remark][]"
                                                                               style="width: 100px;">
                                                                               <option value="" disabled
                                                                                   {{ empty($buyerDetail->pma_remarks) ? 'selected' : '' }}>
                                                                                   Please Select
                                                                               </option>
                                                                               @foreach ($remarks as $remark)
                                                                                   <option
                                                                                       value="{{ $remark->id }}|{{ $remark->remark }}"
                                                                                       {{ $remark->id == $buyerDetail->pma_remarks ? 'selected' : '' }}>
                                                                                       {{ $remark->remark }}
                                                                                   </option>
                                                                               @endforeach
                                                                           </select> --}}

                                                                           @php
                                                                               // Decode the selected remark IDs (if JSON encoded)
                                                                               $selectedRemarks = is_array(
                                                                                   $buyerDetail->pma_remarks_id,
                                                                               )
                                                                                   ? $buyerDetail->pma_remarks_id
                                                                                   : json_decode(
                                                                                       $buyerDetail->pma_remarks_id,
                                                                                       true,
                                                                                   );
                                                                           @endphp

                                                                           <select id="role_id1{{ $sn }}"
                                                                               name="data[{{ $sn }}][pma_remark][]"
                                                                               multiple="multiple" style="width: 100px;">
                                                                               <option disabled>Please select</option>
                                                                               @foreach ($remarks as $remark)
                                                                                   <option
                                                                                       value="{{ $remark->id }}|{{ $remark->remark }}"
                                                                                       {{ in_array($remark->id, $selectedRemarks ?? []) ? 'selected' : '' }}>
                                                                                       {{ $remark->remark }}
                                                                                   </option>
                                                                               @endforeach
                                                                           </select>


                                                                           {{-- @php
                                                                               // Decode the selected remark IDs (if JSON encoded)
                                                                               $selectedRemarks = is_array(
                                                                                   $buyerDetail->pma_remarks_id,
                                                                               )
                                                                                   ? $buyerDetail->pma_remarks_id
                                                                                   : json_decode(
                                                                                       $buyerDetail->pma_remarks_id,
                                                                                       true,
                                                                                   );
                                                                           @endphp

                                                                           <select id="role_id1{{ $sn }}"
                                                                               name="data[{{ $sn }}][pma_remark][]"
                                                                               multiple="multiple" style="width: 100px;">
                                                                               <option disabled>Please select</option>
                                                                               @foreach ($remarks as $remark)
                                                                                   <option
                                                                                       value="{{ $remark->id }}|{{ $remark->remark }}"
                                                                                       {{ in_array($remark->id, $selectedRemarks ?? []) ? 'selected' : '' }}>
                                                                                       {{ $remark->remark }}
                                                                                   </option>
                                                                                   <option
                                                                                       value="{{ $remark->id }}|{{ $remark->remark }}"
                                                                                       {{ $remark->remark == $buyerDetail->pma_remarks ? 'selected' : '' }}>
                                                                                       {{ $remark->remark }}
                                                                                   </option>
                                                                               @endforeach

                                                                           </select> --}}

                                                                       </td>
                                                                   @endif
                                                                   @if (Auth::user()->hasRole('AUDITOR'))
                                                                       <td>
                                                                           <input type="text"
                                                                               name="data[{{ $sn }}][approved_amt]"
                                                                               value="{{ $buyerDetail->auditor_amount ?? '' }}"
                                                                               class="form-control-sm"
                                                                               placeholder="PMA Approved Amount"
                                                                               id="pmaApproved"
                                                                               data-old-value="{{ $buyerDetail->auditor_amount ?? '' }}"
                                                                               {{ is_null($buyerDetail->auditor_amount) ? 'disabled' : '' }}>
                                                                       </td>
                                                                       <td>
                                                                           <select class="form-select"
                                                                               name="data[{{ $sn }}][pma_status]"
                                                                               onchange="AuditorVal(this)"
                                                                               style="width: 100px;"
                                                                               {{ is_null($buyerDetail->auditor_amount) ? 'disabled' : '' }}>
                                                                               <option value="" disabled selected>
                                                                                   Please Select</option>

                                                                               @foreach ($status as $stat)
                                                                                   <option
                                                                                       value="{{ $stat->id }}|{{ $stat->name }}"
                                                                                       {{ $stat->id == $buyerDetail->auditor_status_id ? 'selected' : '' }}>
                                                                                       {{ $stat->name }}
                                                                                   </option>
                                                                               @endforeach
                                                                           </select>

                                                                       </td>
                                                                       <td>

                                                                       </td>
                                                                   @endif
                                                                   <input type="hidden"
                                                                       name="data[{{ $sn }}][sno]"
                                                                       value="{{ $buyerDetail->s_no }}" id="">
                                                               </tr>
                                                           @endforeach
                                                       @else
                                                           <td colspan="19" class="text-center">No Data Available</td>
                                                       @endif
                                                   </tbody>
                                               </table>
                                           </div>
                                           <div class="col-12">
                                               <div class="text-center">
                                                   @if (Auth::user()->hasRole('PMA'))
                                                       {{-- @if ($buyerDetail->pma_submitted_at == null) --}}
                                                       <button type="submit" class="btn btn-primary">Save As
                                                           Draft</button>
                                                       {{-- <button type="button" class="btn btn-warning btnApp"
                                                               @if ($buyerDetail->pma_id === null) disabled @endif>Submit To
                                                               MHI</button> --}}
                                                       {{-- @else --}}
                                                       <button type="button" disabled class="btn btn-primary">Submitted
                                                           To MHI</button>
                                                       {{-- @endif --}}
                                                   @elseif(Auth::user()->hasRole('MHI-OnlyView') || Auth::user()->hasRole('MHI-DS') || Auth::user()->hasRole('MHI-AS'))
                                                       @if ($buyerDetail->mhi_updated_at == null)
                                                           <button type="submit" class="btn btn-primary">Update</button>
                                                           <button type="button" class="btn btn-warning"
                                                               data-bs-toggle="modal" data-original-title="test"
                                                               data-bs-target="#poa"
                                                               @if ($buyerDetail->mhi_id === null) disabled @endif>Recommended
                                                               For POA</button>
                                                       @else
                                                           <button type="button" disabled
                                                               class="btn btn-primary">Submitted
                                                               To POA</button>
                                                       @endif
                                                   @endif
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </form>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           {{-- <div class="modal fade" id="poa" tabindex="-1" role="dialog" aria-labelledby="poa"
               aria-hidden="true">
               <div class="modal-dialog" role="document">
                   <div class="modal-content">
                       <div class="modal-header">
                           <h5 class="modal-title">Reject</h5>
                       </div>
                       <div class="modal-body">
                           <div class="modal-toggle-wrapper">
                               <form action="{{ route('claimEvaluation.poa_submit') }}" id="formReject" role="form"
                                   method="POST" class='form-horizontal prevent-multiple-submit postForm'
                                   accept-charset="utf-8" enctype='multipart/form-data' files=true>
                                   @csrf
                                   <div class="row">
                                       <input type="hidden" name="claim_id" value="{{ $claimId }}">
                                       <div class="col-12">
                                           <div class="form-group">
                                               <span>
                                                   <label class="col-form-label pt-0">E-Office Document</label>
                                                   <input class="form-control" name="e_office_doc" type="file"
                                                       value="">
                                               </span>
                                           </div>
                                       </div>
                                       <div class="col-12">
                                           <div class="form-group">
                                               <span>
                                                   <label class="col-form-label pt-0">E-Office Approval Note No.</label>
                                                   <input class="form-control" name="e_office_noting_no" type="text"
                                                       value="">
                                               </span>
                                           </div>
                                       </div>
                                       <div class="col-12">
                                           <div class="form-group">
                                               <span>
                                                   <label class="col-form-label pt-0">E-Office Approval Date.</label>
                                                   <input class="form-control" name="e_office_date" type="date"
                                                       value="">
                                               </span>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="col-12">
                                       <button
                                           class="btn bg-primary mt-2 d-flex align-items-center gap-2 text-light ms-auto"
                                           type="submit">Recommended For POA<i data-feather="arrow-right"></i></button>
                                   </div>
                               </form>
                           </div>
                       </div>
                   </div>
               </div>
           </div> --}}
       </div>
   @endsection
   @push('scripts')
       <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
       <script>
           $(document).ready(function() {
               $('[id^="roles"]').each(function() {
                   $(this).select2({
                       placeholder: 'Select Status',
                       allowClear: true
                   });
               });
               $('[id^="role"]').each(function() {
                   $(this).select2({
                       placeholder: 'Select Remarks',
                       allowClear: true
                   });
               });

               //    $('.btnApp').click(function(e) {
               //        e.preventDefault();

               //        Swal.fire({
               //            title: 'Are you sure?',
               //            text: 'You are about to submit the form. Are you sure you want to proceed?',
               //            icon: 'warning',
               //            showCancelButton: true,
               //            confirmButtonText: 'Yes, submit!',
               //            cancelButtonText: 'No, cancel',
               //            reverseButtons: true
               //        }).then((result) => {
               //            if (result.isConfirmed) {
               //                $(this).addClass('disabled');
               //                $(this).prop('disabled', true);
               //                var link = '/claimEvaluation/submit/' + {{ $claimId }};
               //                window.location.href = link;

               //            } else {

               //                $(this).removeClass('disabled');
               //                $(this).prop('disabled', false);
               //            }
               //        });
               //    });
           });
       </script>
       <script>
           function upVal(selectElement) {
               var selectedValue = selectElement.value;
               var parts = selectedValue.split("|");
               var selectedId = parts[0].trim();
               var selectedText = parts[1].trim();
               var row = $(selectElement).closest('tr');
               var pmaApprovedInput = row.find('input[name^="data"][name$="[approved_amt]"]');
               var oldValue = pmaApprovedInput.attr('data-old-value');

               if (selectedId === "1" && selectedText === "Maybe Approved") {
                   pmaApprovedInput.val(oldValue);
               } else if (selectedId === "2" && selectedText === "Maybe Rejected") {
                   pmaApprovedInput.val(0);
               } else if (selectedId === "3" && selectedText === "Maybe Withheld") {
                   pmaApprovedInput.val(0);
               }
           }

           //    function upMHIVal(selectElement) {
           //        var selectedValue = selectElement.value;
           //        console.log("Selected Value:", selectedValue);

           //        var parts = selectedValue.split("|");
           //        var selectedId = parts[0].trim(); // Extract ID (e.g., "1")
           //        var selectedText = parts[1].trim(); // Extract Name (e.g., "Maybe Approved")

           //        var row = $(selectElement).closest('tr');
           //        var pmaApprovedInput = row.find('input[name^="data"][name$="[mhi_approved_amt]"]');

           //        var oldValue = pmaApprovedInput.attr('data-mhi-value');

           //        // ✅ Check conditions
           //        if (selectedId === "1" && selectedText === "Maybe Approved") {
           //            pmaApprovedInput.val(oldValue);
           //        } else if (selectedId === "2" && selectedText === "Maybe Rejected") {
           //            pmaApprovedInput.val(0);
           //        } else if (selectedId === "3" && selectedText === "Maybe Withheld") {
           //            pmaApprovedInput.val(0);
           //        }
           //    }
       </script>
   @endpush
