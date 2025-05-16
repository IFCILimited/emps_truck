   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - Claim Evaluation
   @endsection
   @push('styles')
       <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
       <style>
           /* Highlight the download link and icon */
           .list-group-item a:hover {
               color: #007bff;
               /* Change the text color on hover */
               text-decoration: underline;
               /* Underline the link when hovered */
           }

           .list-group-item a:hover i {
               color: #007bff;
               /* Change the icon color on hover */
           }

           .list-group-item a .file-name {
               font-weight: 500;
           }

           .list-group-item a .file-name:hover {
               color: #0056b3;
               /* A darker shade on hover */
           }

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
       <div id="preloader" style="display: none;">
           <div class="loader"></div>
       </div>
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">
                   @include('pma.claimevaluation.buyDetailsSummary')


                   {{-- ✅ Auditor Role Section --}}
                   @if ($stage->where('status', 'S')->where('stage_id', 10)->count() < 1)
                       @role('AUDITOR')
                           <div class="row mb-4">
                               <div class="col-md-8 d-flex justify-content-start">
                                   <!-- Download Excel Format Button -->
                                   <a href="{{ asset('docs/claim_evl_format/claim_evl_format.xlsx') }}"
                                       class="btn btn-success btn-sm" download
                                       aria-label="Download Claim Evaluation Excel Format">
                                       <i class="bi bi-download me-1"></i> Download Excel Format
                                   </a>
                               </div>
                           </div>
                           <div class="card shadow-sm mb-5">
                               <div class="card-header bg-primary text-white">
                                   <strong>Upload Claim Evaluation Files</strong>
                               </div>
                               <div class="card-body">
                                   <form action="{{ route('claimEvaluation.update', encrypt($claimId)) }}" method="POST"
                                       enctype="multipart/form-data" class="prevent-multiple-submit">
                                       @csrf
                                       @method('patch')

                                       <div class="mb-3 d-flex justify-content-end">
                                           <button type="button" id="addMoreFilesBtn" class="btn btn-primary">Add More
                                               Files</button>
                                       </div>
                                       <div class="row" id="additionalFilesContainer">
                                           <div class="col-md-6">
                                               <label for="excel_file" class="form-label">Claim Evaluation Excel File</label>
                                               <input type="file" name="excel_file" id="excel_file" class="form-control"
                                                   accept=".xls,.xlsx" required>
                                               <div class="form-text">Only .xls and .xlsx formats are allowed.</div>
                                           </div>
                                           <div class="col-md-6">
                                               <label for="additional_files" class="form-label">Supporting Documents</label>
                                               <div id="additionalFilesContainer">
                                                   <div class="input-group mb-2">
                                                       <input type="file" name="additional_files[]" class="form-control"
                                                           accept=".pdf,.doc,.docx,.zip,.rar">
                                                   </div>
                                               </div>
                                               <div class="form-text">Allowed formats: .pdf, .doc, .docx, .zip, .rar</div>
                                           </div>
                                       </div>
                                       <div class="row" id="additionalFilesContainer">
                                       </div>
                                       <div class="mb-3">
                                           <label for="remarks">Remarks</label>
                                           <textarea name="remarks" aria-describedby="remarksHelp" class="form-control" rows="3" required>
                                                    @isset($stage[1]->revert_remarks){{ $stage[1]->revert_remarks }} @endisset </textarea>
                                           <small id="remarksHelp" class="form-text text-muted">Please
                                               provide any additional remarks here.</small>
                                       </div>

                                       <div class="d-flex justify-content-end gap-2">
                                           <button type="submit" class="btn btn-success btn-sm prevent-multiple-submit">
                                               @if (count($uploadedFiles) > 0)
                                                   <i class="bi bi-arrow-repeat me-1"></i> Save As Draft
                                               @else
                                                   <i class="bi bi-upload me-1"></i> Save As Draft
                                               @endif
                                           </button>
                                           @if (count($uploadedFiles) > 0)
                                               <button type="button"
                                                   class="btn btn-warning btn-sm action-btn1 prevent-multiple-submit"
                                                   data-title="Freeze Data - Cannot be changed after submission" data-type="F"
                                                   data-confirm="Yes, Submit">
                                                   <i class="bi bi-lock-fill me-1"></i> Submit to PMA
                                               </button>
                                           @endif
                                       </div>
                                   </form>
                               </div>
                           </div>
                       @endrole
                   @endif

                   {{-- ✅ PMA Role Section --}}
                   @if (Auth::user()->hasRole('PMA'))
                       @if ($stage->where('stage_id', 10)->count() > 0 && $stage->max('stage_id') == 10)
                           <form method="POST" action="" class="prevent-multiple-submit" enctype="multipart/form-data"
                               @if ($stage->where('stage_id', 10)->count() > 0 && $stage->max('stage_id') == 10) id="actionForm" @endif>
                               @csrf
                               <div class="card">
                                   <div class="card-body">
                                       <div class="mb-3 d-flex justify-content-end">
                                           <button type="button" id="addMoreFilesBtn" class="btn btn-primary">Add More
                                               Files</button>
                                       </div>
                                       <div class="row" id="additionalFilesContainer">
                                           <div class="col-md-6">
                                               <label for="additional_files" class="form-label">Supporting
                                                   Documents</label>
                                               <div>
                                                   <div class="input-group mb-2">
                                                       <input type="file" name="additional_files[]" class="form-control"
                                                           accept=".pdf,.doc,.docx,.zip,.rar">
                                                   </div>
                                               </div>
                                               <div class="form-text">Allowed formats: .pdf, .doc, .docx, .zip,
                                                   .rar</div>
                                           </div>
                                       </div>
                                       <div class="mb-3">
                                           <label for="remarks">Remarks</label>
                                           <textarea name="remarks" id="hiddenRemarks" class="form-control" rows="3" placeholder="Enter your remarks here..."
                                               required aria-describedby="remarksHelp" required>
                                                    @isset($stage[2]->revert_remarks)
{{ trim($stage[2]->revert_remarks) }}
@endisset
                                                    </textarea>
                                           <small id="remarksHelp" class="form-text text-muted">Please
                                               provide any additional remarks here.</small>
                                       </div>

                                       <div class="text-center mt-2">
                                           <button type="button"
                                               class="btn btn-warning action-btn2 prevent-multiple-submit"
                                               data-title="Revert to Auditor" data-type="R" data-confirm="Yes, Submit">
                                               Revert to Auditor
                                           </button>

                                           <button type="submit"
                                               class="btn btn-primary action-btn2 prevent-multiple-submit"
                                               data-title="Forward to MHI" data-type="20" data-confirm="Yes, Forward">
                                               Submit to MHI
                                           </button>
                                       </div>
                                   </div>
                               </div>
                           </form>
                       @endif
                   @endif


                   @if (Auth::user()->hasRole('MHI'))
                       @if ($stage->where('stage_id', 20)->count() > 0 && $stage->max('stage_id') == 20)
                           <form id="actionForms" method="POST"
                               action="{{ route('claimEvaluation.update', encrypt($claimId)) }}"
                               enctype="multipart/form-data" class="prevent-multiple-submit">
                               @csrf
                               @method('PATCH')
                               <input type="hidden" name="action_type" id="action_type" value="">
  <div class="row mb-4">
                               <div class="col-md-8 d-flex justify-content-start">
                                   <!-- Download Excel Format Button -->
                                   <a href="{{ asset('docs/claim_evl_format/claim_evl_format.xlsx') }}"
                                       class="btn btn-success btn-sm" download
                                       aria-label="Download Claim Evaluation Excel Format">
                                       <i class="bi bi-download me-1"></i> Download Excel Format
                                   </a>
                               </div>
                           </div>
                               <div class="card">
                                   <div class="card-body">
                                       <div class="mb-3 d-flex justify-content-end">
                                           <button type="button" id="addMoreFilesBtn" class="btn btn-primary">Add More
                                               Files</button>
                                       </div>
                                       <div class="row" id="additionalFilesContainer">
                                           <div class="col-md-6">
                                               <label for="excel_file" class="form-label">Claim Evaluation Excel
                                                   File</label>
                                               <input type="file" name="excel_file" id="excel_file"
                                                   class="form-control" accept=".xls,.xlsx" required>
                                               <div class="form-text">Only .xls and .xlsx formats are allowed.</div>
                                           </div>
                                           <div class="col-md-6">
                                               <label for="additional_files" class="form-label">Supporting
                                                   Documents</label>
                                               <div>
                                                   <div class="input-group mb-2">
                                                       <input type="file" name="additional_files[]"
                                                           class="form-control" accept=".pdf,.doc,.docx,.zip,.rar">
                                                   </div>
                                               </div>
                                               <div class="form-text">Allowed formats: .pdf, .doc, .docx, .zip,
                                                   .rar</div>
                                           </div>
                                       </div>
                                       <div class="mb-3">
                                           <label for="remarks">Remarks</label>
                                           <textarea name="remarks" id="hiddenRemarks" class="form-control" rows="3"
                                               placeholder="Enter your remarks here..." required aria-describedby="remarksHelp" required>
                                                    @isset($stage[3]->revert_remarks)
{{ trim($stage[3]->revert_remarks) }}
@endisset
                                                    </textarea>
                                           <small id="remarksHelp" class="form-text text-muted">Please
                                               provide any additional remarks here.</small>
                                       </div>

                                       <div class="text-center mt-2">
                                           <div class="text-center mt-2">
                                               <button type="button"
                                                   class="btn btn-warning action-btn prevent-multiple-submit"
                                                   data-title="Revert to PMA" data-type="R" data-confirm="Yes, Submit">
                                                   Revert to PMA
                                               </button>
                                               <button type="button" class="btn btn-primary action-btn"
                                                   data-title="Forward to PMA" data-type="30"
                                                   data-confirm="Yes, Forward">
                                                   Forward to PMA
                                               </button>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </form>
                       @endif
                   @endif
                   @include('pma.claimevaluation.history_message')
               </div>
           </div>
       </div>
   @endsection
   @push('scripts')
       <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
       @include('partials.js.buyDetails')

       <script>
           $(document).ready(function() {
               $('.prevent-multiple-submit').on('submit', function() {
                   $(this).find('button[type="submit"]').prop('disabled', true);
                   var buttons = $(this).find('button[type="submit"]');
                   setTimeout(function() {
                       buttons.prop('disabled', false);
                   }, 20000); // 25 seconds in milliseconds
               });
           });
       </script>
   @endpush
