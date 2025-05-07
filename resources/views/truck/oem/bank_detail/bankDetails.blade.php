   <!-- Nav Bar Ends here -->
   @extends('layouts.e_truck_dashboard_master')
   @section('title')
    Manage Bank Details
   @endsection

   @push('styles')
   @endpush
   @section('content')
       <!-- Page Sidebar Ends-->
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4>Bank Details</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage Bank Details</li>
                               <li class="breadcrumb-item active">Bank Details</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <!-- Container-fluid starts-->
           <div class="container-fluid">
               <div class="row">
                   <div class="col-sm-12">
                       <div class="card">
                           <div class="card-body">
                               <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th scope="col">S.No.</th>
                                            <th scope="col">Account Holder Name</th>
                                            <th scope="col">Bank Name</th>
                                            <th scope="col">Branch Name</th>
                                            <th scope="col">Account No.</th>
                                            <th scope="col">Account Type</th>
                                            <th scope="col">IFSC Code</th>
                                            <th scope="col">MICR Code</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>{{ $bankDetail->account_holder_name }}</td>
                                            <td>{{ $bankDetail->bank_name }}</td>
                                            <td>{{ $bankDetail->branch_name }}</td>
                                            <td>{{ $bankDetail->account_no }}</td>
                                            <td>{{ $bankDetail->account_type }}</td>
                                            <td>{{ $bankDetail->ifsc_code }}</td>
                                            <td>{{ $bankDetail->micr_code }}</td>
                                            {{-- <td> --}}
                                                @if(!empty($bankDetail))
                                                    @if(isset($tempBankDetail->Status) == 1)
                                                        <td class="text-center" bgcolor="lightgreen">Pending</td>
                                                    @elseif (!isset($tempBankDetail->Status))
                                                        <td class="text-center">
                                                            <a href="{{ route('e-trucks.bankDetails.edit', encrypt($bankDetail->id)) }}" class="btn btn-sm btn-danger">Edit</a>
                                                        </td>
                                                    @endif
                                                @endif

                                            {{-- </td> --}}
                                        </tr>
                                    </tbody>
                                </table>

                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <!-- Container-fluid Ends-->
       </div>
   @endsection
