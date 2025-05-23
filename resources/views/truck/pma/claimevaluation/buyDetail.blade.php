   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - Claim Evaluation
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

           */ @keyframes spin {
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
       < <div id="preloader" style="display: none;">
           <div class="loader"></div>
           </div>
           <div class="page-body">
               <div class="container-fluid">
                   <div class="page-title">
                       <div class="row" style="position: fixed;top:81px;  width: 79%; z-index: 1000;">
                           <div class="col-md-12">
                               <div class="card border-start border-4 border-info shadow-sm">
                                   <div class="card-body">
                                       <div class="row ">
                                           <div class="col-md-4">
                                               <strong>Claim Number:</strong>
                                               <div>{{ $buyerDetails[0]->claim_no ?? '-' }}</div>
                                           </div>
                                           <div class="col-md-4">
                                               <strong>OEM Name:</strong>
                                               <div>
                                                   {{ !empty($buyerDetails[0]->oemname) ? strtoupper($buyerDetails[0]->oemname) : '-' }}
                                               </div>
                                           </div>
                                           <div class="col-md-4">
                                               <strong>Segment Name:</strong>
                                               <div>{{ $buyerDetails[0]->vehicle_segment ?? '-' }}</div>
                                           </div>
                                       </div>
                                   </div>

                               </div>
                           </div>
                       </div>
                       <div style="height: 90px;"></div>

                       <div class="row">
                           <div class="col-md-12">
                               <div class="card border-start border-4 border-info shadow-sm">
                                   <div class="card-body">
                                       <h5 class="card-title text-info">Claim Evaluation Summary</h5>
                                       {{-- 🔹 Stage-Wise Totals --}}
                                       <div class="row text-center mt-5">
                                           {{-- PMA Status --}}
                                           <div class="col-md-6 mb-3">
                                               <div class="border p-3 rounded bg-dark">
                                                   <h4 class="text-white fw-bold mb-3">PMA Summary</h4>

                                                   <div class="d-flex justify-content-between mb-2">
                                                       <span class="fw-bold">✅ Approved</span>
                                                       <span class="fw-bold">
                                                           {{ $buyerDetails->where('pma_status_id', '1')->count() > 0
                                                               ? $buyerDetails->where('pma_status_id', '1')->count() . ' | ₹ ' . number_format($buyerDetails->sum('pma_amount'), 2)
                                                               : '' . ' | ₹ ' . number_format($buyerDetails->sum('pma_amount'), 2) }}
                                                       </span>
                                                   </div>

                                                   <div class="d-flex justify-content-between mb-2">
                                                       <span class="fw-bold">❌ Rejected</span>
                                                       <span class="fw-bold">
                                                           {{ $buyerDetails->where('pma_status_id', '=', '2')->count() > 0
                                                               ? $buyerDetails->where('pma_status_id', '=', '2')->count() .
                                                                   ' | ₹ ' .
                                                                   number_format($buyerDetails->sum('pma_rej_amount'), 2)
                                                               : '' . ' | ₹ ' . number_format($buyerDetails->sum('pma_rej_amount'), 2) }}
                                                       </span>
                                                   </div>

                                                   <div class="d-flex justify-content-between">
                                                       <span class="fw-bold">⏸️ Withheld</span>
                                                       <span class="fw-bold">
                                                           {{ $buyerDetails->where('pma_status_id', '=', '3')->count() > 0
                                                               ? $buyerDetails->where('pma_status_id', '=', '3')->count() .
                                                                   ' | ₹ ' .
                                                                   number_format($buyerDetails->sum('pma_wthhld_amount'), 2)
                                                               : '' . ' | ₹ ' . number_format($buyerDetails->sum('pma_wthhld_amount'), 2) }}
                                                       </span>
                                                   </div>

                                                   <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                                       <span class="fw-bold text-white">🔢 Total</span>
                                                       <span class="fw-bold text-white">
                                                           {{ $buyerDetails->count() }}
                                                           |
                                                           ₹
                                                           {{ number_format(
                                                               $buyerDetails->sum('pma_amount') + $buyerDetails->sum('pma_rej_amount') + $buyerDetails->sum('pma_wthhld_amount'),
                                                               2,
                                                           ) }}
                                                       </span>
                                                   </div>
                                               </div>
                                           </div>


                                           {{-- Auditor Status --}}
                                           <div class="col-md-6 mb-3">
                                               <div class="border p-3 rounded bg-dark">
                                                   <h4 class="text-white fw-bold mb-3">Auditor Summary</h4>
                                                   <div class="d-flex justify-content-between mb-2">
                                                       <span class="fw-bold">✅ Approved</span>
                                                       <span class="fw-bold">
                                                           {{ $buyerDetails->where('auditor_status_id', '1')->count() > 0
                                                               ? $buyerDetails->where('auditor_status_id', '1')->count() .
                                                                   ' | ₹ ' .
                                                                   number_format($buyerDetails->sum('auditor_amount'), 2)
                                                               : '-' }}
                                                       </span>
                                                   </div>
                                                   <div class="d-flex justify-content-between mb-2">
                                                       <span class="fw-bold">❌ Rejected</span>
                                                       <span class="fw-bold">
                                                           {{ $buyerDetails->where('auditor_status_id', '2')->count() > 0
                                                               ? $buyerDetails->where('auditor_status_id', '2')->count() .
                                                                   ' | ₹ ' .
                                                                   number_format($buyerDetails->sum('auditor_rej_amount'), 2)
                                                               : '' . ' | ₹ ' . number_format($buyerDetails->sum('auditor_rej_amount'), 2) }}
                                                       </span>
                                                   </div>
                                                   <div class="d-flex justify-content-between">
                                                       <span class="fw-bold">⏸️ Withheld</span>
                                                       <span class="fw-bold">
                                                           {{ $buyerDetails->where('auditor_status_id', '3')->count() > 0
                                                               ? $buyerDetails->where('auditor_status_id', '3')->count() .
                                                                   ' | ₹ ' .
                                                                   number_format($buyerDetails->sum('auditor_wthhld_amount'), 2)
                                                               : '' . ' | ₹ ' . number_format($buyerDetails->sum('auditor_wthhld_amount'), 2) }}
                                                       </span>
                                                   </div>

                                                   <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                                       <span class="fw-bold text-white">🔢 Total</span>
                                                       <span class="fw-bold text-white">
                                                           {{ $buyerDetails->count() }}
                                                           |
                                                           ₹
                                                           {{ number_format(
                                                               $buyerDetails->sum('auditor_amount') +
                                                                   $buyerDetails->sum('auditor_rej_amount') +
                                                                   $buyerDetails->sum('auditor_wthhld_amount'),
                                                               2,
                                                           ) }}
                                                       </span>
                                                   </div>
                                               </div>
                                           </div>
                                       </div> {{-- End Row --}}
                                   </div>
                               </div>
                           </div>
                       </div>
                       {{-- ✅ Auditor Role Section --}}
                       @if ($stage->where('status', 'S')->where('stage_id', 2)->count() < 1)
                           @role('AUDITOR')
                               <div class="row">
                                   <div class="col-md-8 d-flex justify-content-end">
                                       <a href="{{ asset('docs/claim_evl_format/claim_evl_format.xlsx') }}"
                                           class="btn btn-success mt-3" download="claim_evl_format.xlsx">
                                           Download Format
                                       </a>
                                   </div>
                                   @php
                                       $stage_upload_id = $stage->where('status', 'D')->where('stage_id', 2)->first();
                                   @endphp
                                   @if ($stage->where('status', 'D')->where('stage_id', 2)->count() > 0)
                                       <div class="col-md-4 d-flex justify-content-end">
                                           {{-- <a href="{{ downloadFile('686')}}" --}}
                                           <a href="{{ route('doc.down', encrypt($stage_upload_id->upload_id)) }}"
                                               class="btn btn-success mt-3">
                                               Download Attachment
                                           </a>
                                       </div>
                                   @endif
                               </div>

                               <div class="row">
                                   <div class="col-xl-12">
                                       <h4 class="mb-3">Claim Evaluation Details</h4>


                                       {{-- ✅ Excel Upload --}}
                                       <div class="card mb-4 shadow-sm">
                                           <div class="card-header bg-dark text-white">
                                               <strong>Upload Claim Evaluation Excel</strong>
                                           </div>

                                           <div class="card-body">
                                               <form action="{{ route('e-trucks.claimEvaluation.update', encrypt($claimId)) }}"
                                                   method="POST" enctype="multipart/form-data">
                                                   {!! method_field('patch') !!}
                                                   @csrf
                                                   <div class="row">
                                                       <div class="col-md-12">
                                                           <label for="excel_file" class="form-label">Select Claim Evaluation
                                                               Excel File</label>
                                                           <input type="file" class="form-control" name="excel_file"
                                                               id="excel_file" accept=".xls,.xlsx" required>
                                                           <small class="form-text text-muted">Only .xls and .xlsx files are
                                                               allowed.</small>
                                                       </div>
                                                   </div>

                                                   <div class="row mt-3">

                                                       <div class="col-md-2 offset-md-8">
                                                           <button type="submit" class="btn btn-success w-100 btn-sm"
                                                               id="uploadBtn">
                                                               @if ($stage->where('status', 'D')->where('stage_id', 2)->count() > 0)
                                                                   Reupload Excel
                                                               @else
                                                                   Upload Excel
                                                               @endif
                                                           </button>
                                                       </div>
                                                       @if ($stage->where('status', 'D')->where('stage_id', 2)->count() > 0)
                                                           <div class="col-md-2">
                                                               <button type="button"
                                                                   class="btn btn-warning w-100 btn-sm btnApp"
                                                                   data-bs-toggle="tooltip" data-bs-placement="top"
                                                                   title="Freezing the data will prevent further modifications."
                                                                   id="freezeDataBtn">
                                                                   Freeze Data
                                                               </button>
                                                           </div>
                                                       @endif

                                                   </div>
                                               </form>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           @endrole
                       @endif




                       <div class="row">
                           <div class="col-xl-12">
                               <div class="col-6 mb-3">
                                   <h4>Claim Evaluation Details</h4>
                               </div>
                               <div class="col-sm-12 col-xl-12">
                                   <form action="{{ route('e-trucks.claimEvaluation.update', encrypt($claimId)) }}" id="plant"
                                       role="form" method="POST"
                                       class='form-horizontal modelVer prevent-multiple-submit' files=true
                                       enctype='multipart/form-data' accept-charset="utf-8">
                                       {!! method_field('patch') !!}
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
                                                               <th scope="col">Vin chassis</th>
                                                               <th scope="col">Claim Amount</th>
                                                               <th scope="col">System Amount</th>
                                                               <th scope="col">System Status</th>
                                                               <th scope="col">System Remark</th>

                                                               <th scope="col" style="white-space: nowrap">PMA Approved
                                                                   Amount</th>
                                                               <th scope="col" style="white-space: nowrap">PMA Rejected
                                                                   Amount</th>
                                                               <th scope="col" style="white-space: nowrap">PMA Withheld
                                                                   Amount</th>
                                                               <th scope="col">PMA Status</th>
                                                               <th scope="col">PMA Remark</th>

                                                               @if (Auth::user()->hasRole('AUDITOR') || count($stage) > 1)
                                                                   <th scope="col" style="white-space: nowrap">Auditor
                                                                       Approved
                                                                       Amount</th>
                                                                   <th scope="col" style="white-space: nowrap">Auditor
                                                                       Rejected
                                                                       Amount</th>
                                                                   <th scope="col" style="white-space: nowrap">Auditor
                                                                       Withheld
                                                                       Amount</th>
                                                                   <th scope="col">Auditor Status</th>
                                                                   <th scope="col">Auditor Remark</th>
                                                                   <th scope="col">Date Of Payment</th>
                                                               @endif

                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           @if (count($buyerDetails) > 0)
                                                               @foreach ($buyerDetails as $buyerDetail)
                                                                   <tr>
                                                                       @php
                                                                           $sn = $loop->iteration;
                                                                       @endphp
                                                                       <input type="hidden"
                                                                           name="data[{{ $sn }}][sno]"
                                                                           value="{{ $buyerDetail->s_no }}"
                                                                           id="">
                                                                       <th class="text-end">{{ $sn }}</th>
                                                                       <td class="text-start">
                                                                           {{ $buyerDetail->vin_chassis_no ?? 'NA' }}</td>
                                                                       <td class="text-end">
                                                                           {{ number_format($buyerDetail->eligible_incentive) ?? 'NA' }}
                                                                       </td>
                                                                       <td class="text-end">
                                                                           {{ number_format($buyerDetail->approved_incentive) ?? 'NA' }}
                                                                       </td>
                                                                       <td class="text-start">
                                                                           {{ $buyerDetail->status ?? 'NA' }}</td>
                                                                       <td class="text-start">
                                                                           {{ $buyerDetail->remark ?? 'NA' }}</td>

                                                                       @if ($stage->where('status', 'D')->where('stage_id', '1')->count() == 1 || $stage->count() == 0)
                                                                          
                                                                       @php
                                                                       $approved_incentive = $buyerDetail->pma_amount ?? $buyerDetail->approved_incentive;
                                                                   @endphp
                                                                       <td class="text-end">
                                                                               <input type="number"
                                                                                   name="data[{{ $sn }}][approved_amt]"
                                                                                   value="{{ $approved_incentive}}"
                                                                                   class="form-control-sm text-end"
                                                                                   placeholder="PMA Approved Amount"
                                                                                   id="pmaApproved"
                                                                                   data-old-value="{{ $buyerDetail->eligible_incentive }}">
                                                                           </td>
                                                                           <td class="text-end">
                                                                               <input type="number"
                                                                                   name="data[{{ $sn }}][rejected_amt]"
                                                                                   value="{{ $buyerDetail->pma_rej_amount ?? 0.0 }}"
                                                                                   class="form-control-sm text-end"
                                                                                   placeholder="PMA Rejected Amount"
                                                                                   id="rejected_amt">
                                                                           </td>
                                                                           <td class="text-end">
                                                                               <input type="number"
                                                                                   name="data[{{ $sn }}][withheld_amt]"
                                                                                   value="{{ $buyerDetail->pma_wthhld_amount ?? 0.0 }}"
                                                                                   class="form-control-sm text-end"
                                                                                   placeholder="PMA Withheld Amount"
                                                                                   id="pmaWithheld">
                                                                           </td>
                                                                           <td class="text-start">
                                                                            <select class="form-select"
                                                                                name="data[{{ $sn }}][pma_status]"
                                                                                style="width: 100px;" required
                                                                                onchange="upVal(this)">
                                                                                <option value="" disabled selected>Please Select</option>
                                                                        
                                                                                @php
                                                                                    $syst_status_id = $buyerDetail->pma_status_id ?? $buyerDetail->syst_status_id;
                                                                                @endphp
                                                                        
                                                                                @foreach ($pmaStatus as $stat)
                                                                                    <option
                                                                                        value="{{ $stat->id }}|{{ $stat->name }}"
                                                                                        {{ $stat->id == $syst_status_id ? 'selected' : '' }}>
                                                                                        {{ $stat->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        
                                                                           <td class="text-start">

                                                                               <textarea rows="3" cols="30" disabled>{{ $buyerDetail->pma_remarks ?? '' }}</textarea>
                                                                               <select id="role_id1{{ $sn }}"
                                                                                   name="data[{{ $sn }}][pma_remark][]"
                                                                                   multiple="multiple"
                                                                                   style="width: 100px;">
                                                                                   <option disabled>Please select</option>
                                                                                   @foreach ($remarks as $remark)
                                                                                       <option
                                                                                           value="{{ $remark->id }}|{{ $remark->remark }}">
                                                                                           {{ $remark->remark }}
                                                                                       </option>
                                                                                   @endforeach
                                                                               </select>
                                                                           </td>
                                                                       @else
                                                                           <td class="text-end">
                                                                               {{ number_format($buyerDetail->pma_amount) }}
                                                                           </td>
                                                                           <td class="text-end">
                                                                               {{ number_format($buyerDetail->pma_rej_amount) ?? 0.0 }}
                                                                           </td>
                                                                           <td class="text-end">
                                                                               {{ number_format($buyerDetail->pma_wthhld_amount) ?? 0.0 }}
                                                                           </td>
                                                                           <td class="text-start">
                                                                               {{ $buyerDetail->pma_status }}</td>
                                                                           <td class="text-start">
                                                                               {{ $buyerDetail->pma_remarks }}</td>
                                                                       @endif

                                                                       @if (count($stage) < 2)
                                                                           @if (Auth::user()->hasRole('AUDITOR'))
                                                                               <td>-</td>
                                                                               <td>-</td>
                                                                               <td>-</td>
                                                                               <td>-</td>
                                                                               <td>-</td>
                                                                               <td>-</td>
                                                                           @endif
                                                                       @else
                                                                           <td class="text-end">
                                                                               {{ number_format($buyerDetail->auditor_amount) }}
                                                                           </td>
                                                                           <td class="text-end">
                                                                               {{ number_format($buyerDetail->auditor_rej_amount) }}
                                                                           </td>
                                                                           <td class="text-end">
                                                                               {{ number_format($buyerDetail->auditor_wthhld_amount) }}
                                                                           </td>
                                                                           <td class="text-start">
                                                                               {{ $buyerDetail->auditor_status }}</td>
                                                                           <td class="text-start">
                                                                               {{ $buyerDetail->auditor_remarks }}</td>
                                                                           <td class="text-start">
                                                                               {{ $buyerDetail->auditor_date_of_payment }}
                                                                           </td>
                                                                       @endif

                                                                   </tr>
                                                               @endforeach
                                                           @else
                                                               <td colspan="19" class="text-center">No Data Available
                                                               </td>
                                                           @endif
                                                       </tbody>
                                                   </table>
                                               </div>
                                               @if ($stage->where('status', 'S')->where('stage_id', 1)->count() < 1)
                                                   @if (Auth::user()->hasRole('PMA'))
                                                       <div class="col-12 mt-2">
                                                           <div class="text-center">
                                                               <button type="submit" class="btn btn-primary">Save As
                                                                   Draft</button>
                                                               @if ($stage->where('stage_id', 1)->count() >= 1)
                                                                   <button type="button"
                                                                       class="btn btn-warning btnApp">Submit To
                                                                       Auditor</button>
                                                               @endif
                                                           </div>
                                                       </div>
                                                   @endif
                                               @endif
                                           </div>
                                       </div>
                                   </form>
                               </div>
                           </div>
                       </div>
                   </div> {{-- page-title --}}
               </div> {{-- container-fluid --}}
           </div> {{-- page-body --}}
       @endsection

       @push('scripts')
           <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
           <script>
               $(document).ready(function() {
                   // Initialize select2 for all role-specific remark fields
                   $('[id^="role_id1"], [id^="role_id2"], [id^="role_id3"]').select2({
                       placeholder: 'Select Remarks',
                       allowClear: true,
                       width: 'resolve'
                   });
               });

               //    $('.btnApp').click(function(e) {
               //        e.preventDefault(); // Prevent default form submission
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
               //                // Disable the button to prevent multiple submissions
               //                $(this).addClass('disabled');
               //                $(this).prop('disabled', true);

               //                // Submit the form
               //                var link = '/claimEvaluation/submit/' + {{ $claimId }};
               //                window.location.href = link;
               //                // $('#formReject').submit();
               //            } else {
               //                // If user clicks cancel, enable the button
               //                $(this).removeClass('disabled');
               //                $(this).prop('disabled', false);
               //            }
               //        });
               //    });



               $('.btnApp').click(function(e) {
                   e.preventDefault();

                   Swal.fire({
                       title: 'Forward to Auditor',
                       html: `
                <div class="form-group text-left">
                    <label for="auditorSelect">Select Auditor <span class="text-danger">*</span></label>
                    <select id="auditorSelect" class="form-control" required>
                        <option value="">-- Choose Auditor --</option>
                        @foreach ($auditors as $auditor)
                            <option value="{{ $auditor->id }}">{{ $auditor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="mt-2 text-left">Kindly confirm the selected auditor before proceeding with the claim  evaluation.</p>
            `,
                       icon: 'question',
                       showCancelButton: true,
                       confirmButtonText: 'Yes, Forward',
                       cancelButtonText: 'Cancel',
                       reverseButtons: true,
                       focusConfirm: false,
                       preConfirm: () => {
                           const selectedAuditor = document.getElementById('auditorSelect').value;
                           if (!selectedAuditor) {
                               Swal.showValidationMessage('Auditor selection is required.');
                               return false;
                           }
                           return selectedAuditor;
                       }
                   }).then((result) => {
                       if (result.isConfirmed) {
                           const auditorId = result.value;

                           $('.btnApp').addClass('disabled').prop('disabled', true);

                           const claimId = {{ $claimId }};
                           const link = `/claimEvaluation/submit/${claimId}/${auditorId}`;
                           window.location.href = link;
                       }
                   });
               });





               // Function to handle PMA status change
               function upVal(selectElement) {
                   let selectedValue = selectElement.value;
                   let [selectedId, selectedText] = selectedValue.split("|").map(val => val.trim());

                   let row = $(selectElement).closest('tr');
                   let inputField = row.find('input[name^="data"][name$="[approved_amt]"]');
                   let inputField1 = row.find('input[name^="data"][name$="[rejected_amt]"]');
                   let inputField2 = row.find('input[name^="data"][name$="[withheld_amt]"]');
                   let oldValue = inputField.attr('data-old-value');

                   if (selectedId === "1" && selectedText === "Maybe Approved") {
                       inputField.val(oldValue);
                       inputField1.val(0);
                       inputField2.val(0);
                   }
                   else if (selectedId === "2") {
                    inputField1.val(oldValue);
                    inputField2.val(0);
                    inputField.val(0);
                   }
                   else if (selectedId === "3") {
                    inputField2.val(oldValue);
                    inputField.val(0);
                    inputField1.val(0);
                   }
                //     else if (["2", "3"].includes(selectedId)) {
                //        inputField.val(0);
                //    }
               }

               // Function to handle Auditor status change
               //    function AuditorVal(selectElement) {
               //        let selectedValue = selectElement.value;
               //        let [selectedId, selectedText] = selectedValue.split("|").map(val => val.trim());
               //        let row = $(selectElement).closest('tr');
               //        let inputField = row.find('input[name^="data"][name$="[auditor_approved_amt]"]');
               //        let oldValue = inputField.attr('data-auditor-value');

               //        if (selectedId === "1" && selectedText === "Maybe Approved") {
               //            inputField.val(oldValue);
               //        } else if (["2", "3"].includes(selectedId)) {
               //            inputField.val(0);
               //        }
               //    }
           </script>
       @endpush
