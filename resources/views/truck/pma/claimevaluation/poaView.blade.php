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

                           <div class="col-sm-12 col-xl-12">
                            <form action="{{ route('e-trucks.claimEvaluation.update', encrypt($claimId)) }}" id="plant" role="form" 
                       method="POST" class='form-horizontal modelVer prevent-multiple-submit' files=true
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
                                                    <th scope="col">Claim Number</th>
                                                    <th scope="col">OEM Name</th>
                                                    {{-- <th scope="col">Segment Name</th>
                                                    <th scope="col">Vin chassis</th> --}}
                                                    <th scope="col">Claim Amount</th>
                                                    <th scope="col">Approved Amount</th>
                                                    <th scope="col">Reject Amount</th>
                                                    <th scope="col">Withheld Amount</th>
                                                    <th scope="col">No. Of Vehicle</th>
                                                    <th scope="col">Claim Submitted Date</th>
                                                    <th scope="col">Paid Status</th>
                                                    <th scope="col">Paid Date</th>
                                                    <th scope="col">Document</th>
                                                    <th scope="col">Remarks</th>
                                                    
                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                               
                                            </tbody>
                                        </table>
                                        
                                       </div>

                                       {{-- <div class="col-12">
                                           <div class="text-center">
                                            @if(Auth::user()->hasRole('PMA'))
                                                @if($buyerDetail->pma_submitted_at == null)
                                                    <button type="submit" class="btn btn-primary" >Update</button>
                                                    <button type="button" class="btn btn-warning btnApp" @if($buyerDetail->pma_id === null) disabled @endif >Submit To MHI</button>
                                                @else
                                                    <button type="button" disabled class="btn btn-primary" >Submitted To MHI</button>
                                                @endif
                                            @elseif(Auth::user()->hasRole('MHI-OnlyView') || Auth::user()->hasRole('MHI-DS') || Auth::user()->hasRole('MHI-AS'))
                                               <button type="submit" class="btn btn-primary" >Update</button>
                                                <button type="button" class="btn btn-warning btnApp" @if($buyerDetail->mhi_id === null) disabled @endif >Recommended For POA</button>
                                            @endif
                                            </div>
                                       </div> --}}
                                   </div>
                               </div>
                            </form>
                           </div>

                       </div>

                   </div>

               </div>
           </div>

       </div>
   @endsection
   @push('scripts')
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
    // Loop through each select element with id starting with 'roles'
    $('[id^="roles"]').each(function() {
        $(this).select2({
            placeholder: 'Select Remarks',
            allowClear: true
        });
    });
    $('[id^="role"]').each(function() {
        $(this).select2({
            placeholder: 'Select Status',
            allowClear: true
        });
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
                var link = '/claimEvaluation/submit/' + {{$claimId}};
                window.location.href = link;
            } else {
                // If user clicks cancel, enable the button
                $(this).removeClass('disabled');
                $(this).prop('disabled', false);
            }
        });
    });
});

    </script>
       <script>
           $(document).ready(function() {
            $('#search').click(function(e) {
                var modSeg = $('#select_oem').val();
                var modName = $('#select_seg').val();

                var link = '/claimGenerate/search/' + modSeg + '/' +modName;
                window.location.href = link;

            });

            $('#clear').click(function(e) {

                var link = '../../../claimGenerate';
                window.location.href = link;

            });


           });
       </script>
   @endpush
