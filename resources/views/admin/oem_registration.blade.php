   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - OEM Pre-Registration
   @endsection

   @push('styles')
   <style>
        table th {
        
        white-space: nowrap;  /* Prevent text from breaking onto a new line */
       
    }
   </style>
   @endpush
   @section('content')
       <!-- Page Sidebar Ends-->
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4>OEM Pre-Registration</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="index.html">
                                       <svg class="stroke-icon">
                                           <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage OEM</li>
                               <li class="breadcrumb-item active">OEM Pre-Registration</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <!-- Container-fluid starts-->
           <div class="container-fluid">
               <div class="row">

                <div class="col-sm-12">
                <div class="card p-10">
                    <div class="row">
                        
                        <div class="col-lg-3 offset-3">
                        <select class="form-control" name="status" id="status">
                           
                            <option value="all" {{($status  == null)?'selected':''}}>All</option>
                            <option value="A" {{($status  == 'A')?'selected':''}}>Approved</option>
                            <option value="P" {{($status  == 'P')?'selected':''}}>Pending</option>
                            <option value="R" {{($status  == 'R')?'selected':''}}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <button class="btn btn-primary" type="button" onclick="filterBtn()">Filter</button>
                    </div>
                
                    </div>
                    
                </div>    
                </div>    
                

                   <div class="col-sm-12">
                       <div class="card">
                           {{-- <div class="card-header pb-0 card-no-border">
                    <h4>HTML5 Export Buttons</h4>
                  </div> --}}
                           <div class="card-body">
                               <div class="dt-ext table-responsive  custom-scrollbar">
                                   <table class="display table-bordered table-striped" id="basic-12">
                                       <thead>
                                           <tr>
                                               <th>S.No.</th>
                                               <th>OEM Name</th>
                                               <th>Type of OEM</th>
                                               <th>Company Registration No. </th>
                                               <th>Contact Person</th>
                                               <th> Email Id </th>
                                               <th>Created On</th>
                                               <th> Verification Status </th>
                                               <th> Action </th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach ($preUser as $user)
                                               <tr>
                                                   <td>{{ $loop->iteration }}</td>
                                                   <td> {{ $user->name }}</td>
                                                   <td>{{ $oemType->where('id', $user->oem_type_id)->first()->type }}</td>
                                                   <td>{{ $user->registration_no }}</td>
                                                   <td>{{ $user->auth_name }}</td>
                                                   <td>{{ $user->email }}</td>
                                                   <td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
                                                   <td class="text-center"  @if($user->approval_for_post_reg == 'A') bgcolor="lightgreen" @elseif($user->approval_for_post_reg == 'R') bgcolor="red" @else bgcolor="orange"  @endif>
                                                    {{ $user->approval_for_post_reg == 'A' ? 'Approved' : ($user->approval_for_post_reg == 'R' ? 'Rejected' : 'Pending') }}
                                                   </td>
                                                   <td>
                                                       <ul class="action">
                                                           <li class="edit"> <a
                                                                   href="{{ route('oemRegistration.show', encrypt($user->id)) }}"
                                                                   class="btn btn-sm btn-success"> View</a> </li>
                                                       </ul>
                                                   </td>
                                               </tr>
                                           @endforeach
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
   @push('scripts')
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
       <script>
           $(document).ready(function() {
               $('.btnApp').click(function(e) {

                   $('#formApprove').submit();
               });
               $('.btnReject').click(function(e) {

                   $('#formReject').submit();
               });
           });
           function filterBtn() {
            var status = document.getElementById("status");
            var statusid = status.value;

            window.location.href = "/preRegister/" + statusid;
        }
       </script>
   @endpush
