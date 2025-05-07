   <!-- Nav Bar Ends here -->
   @extends('layouts.e_truck_dashboard_master')
   @section('title')
       Admin - Manage Buyer Details
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
                           <h4>Buyer Details</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage Buyer Details</li>
                               <li class="breadcrumb-item active">Buyer Details</li>
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
                           {{-- <div class="card-header pb-0 card-no-border">
                               <a href="{{ route('buyerdetail.create') }}" class="btn btn-success" style="float: right;">Add
                                   Buyer Detail</a>
                           </div> --}}
                           <div class="card-body">
                               <div class="dt-ext table-responsive  custom-scrollbar">
                                   {{-- <table class="display table-bordered table-striped" id=""> --}}
                                   {{-- <table class="display table-bordered table-striped" id="export-button"> --}}
                                   <table class="display table-bordered table-striped dataTable" id="export-button">
                                       <thead>
                                           <tr>
                                               <th scope="col">S.No.</th>
                                               <th scope="col">Model Name</th>
                                               <th scope="col">Model Variant</th>
                                               <th scope="col">Model Segment</th>
                                               <th scope="col">Customer Name</th>
                                               <th scope="col">Customer ID</th>
                                               <th scope="col">Address</th>
                                               <th scope="col">Mobile No.</th>
                                               <th scope="col">Email Id</th>
                                               <th scope="col">State</th>
                                               <th scope="col">District</th>
                                               <th scope="col">Dealer Invoice Date</th>
                                               <th scope="col">OEM Status & Remark</th>
                                               <th scope="col">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach ($bankDetail as $key => $bankDetail)
                                               <tr>

                                                   <td>{{ $key + 1 }}</td>
                                                   <td>{{ $bankDetail->model_name }} </td>
                                                   <td>{{ $bankDetail->variant_name }} </td>
                                                   <td>{{ $bankDetail->segment_name }} </td>
                                                   <td>{{ $bankDetail->custmr_name }} </td>
                                                   <td>{{ $bankDetail->buyer_id }} </td>
                                                   <td>{{ $bankDetail->add }} </td>
                                                   <td>{{ $bankDetail->mobile }} </td>
                                                   <td>{{ $bankDetail->email }} </td>
                                                   <td>{{ $bankDetail->state }} </td>
                                                   <td>{{ $bankDetail->district }} </td>
                                                   <td>{{ $bankDetail->invoice_dt }} </td>
                                                   <td>
                                                    {!! $bankDetail->oem_status == 'R' ? '<span style="color: red;">Reject With Reason: ' . $bankDetail->oem_remarks . '</span>' : '' !!}
                                                </td>
                                                
                                                
                                                   <td>
                                                       <!-- @if ($bankDetail->status == 'D')
                                                           <a href="{{ route('buyerdetail.edit', $bankDetail->id) }}"
                                                               class="btn btn-sm btn-warning">Edit</a>
                                                       @elseif ($bankDetail->status == 'S')
                                                           <a href="{{route('buyerdetail.ackdoc', $bankDetail->id)}}" class="btn btn-sm btn-primary">Ack Document</a>
                                                          @elseif ($bankDetail->status == 'A')
                                                           <a href="{{route('ackdoc.finalview', $bankDetail->id)}}" class="btn btn-sm btn-success">VIEW</a>

                                                       @endif -->
                                                       @if ($bankDetail->status == 'D')
                                                               <a href="{{ route('e-trucks.buyerdetail.edit', $bankDetail->id) }}"
                                                                   class="btn btn-sm btn-warning">Edit</a>
                                                           @elseif ($bankDetail->status == 'S')
                                                               <a href="{{ route('e-trucks.buyerdetail.ackdoc', $bankDetail->id) }}"
                                                                   class="btn btn-sm btn-primary">Upload Document</a>
                                                            @elseif ($bankDetail->status == 'P')
                                                                   <a href="{{ route('e-trucks.buyerdetail.ackdoc', $bankDetail->id) }}"
                                                                       class="btn btn-sm btn-primary">RC & Document Upload</a>
                                                           @elseif ($bankDetail->status == 'A')
                                                               <a href="{{ route('e-trucks.ackdoc.finalview', $bankDetail->id) }}"
                                                                   class="btn btn-sm btn-success">VIEW</a>
                                                           @endif

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
