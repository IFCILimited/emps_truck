   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - Manage Buyer Details
   @endsection

   @push('styles')
   @endpush
   @section('content')
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
           <div class="container-fluid">
               <div class="row">

                   <div class="col-sm-12">
                       <div class="card">
                           <div class="card-header pb-0 card-no-border">
                               <a href="{{ route('buyerdetail.create') }}" class="btn btn-success" style="float: right;">Add
                                   Buyer Detail</a>
                           </div>
                           <div class="card-body">
                               <div class="dt-ext table-responsive  custom-scrollbar">
                                   <table class="display table-bordered table-striped" id="export-button">
                                       <thead>
                                           <tr>
                                               <th class="text-center">S.No.</th>
                                               <th class="text-center">Model Name</th>
                                               <th class="text-center">Model Variant</th>
                                               <th class="text-center">Model Segment</th>
					       <th class="text-center">Vin Chassis No</th>
                                               <th class="text-center">Customer Name</th>
                                               <th class="text-center">Address</th>
                                               <th class="text-center">Mobile No.</th>
                                               <th class="text-center">Email Id</th>
                                               <th class="text-center">State</th>
                                               <th class="text-center">District</th>
                                               <th class="text-center">Dealer Invoice Date</th>
                                               <th class="text-center">OEM Status</th>
                                               <th class="text-center">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach ($bankDetail as $key => $bankDetail)
                                               <tr>
                                                   <td class="text-center">{{ $key + 1 }}</td>
                                                   <td class="text-center">{{ $bankDetail->model_name }} </td>
                                                   <td class="text-center">{{ $bankDetail->variant_name }} </td>
                                                   <td class="text-center">{{ $bankDetail->segment_name }} </td>
						   <td class="text-center">{{ $bankDetail->vin_chassis_no }} </td>
                                                   <td class="text-center">{{ $bankDetail->custmr_name }} </td>
                                                   <td class="text-center">{{ $bankDetail->add }} </td>
                                                   <td class="text-center">{{ $bankDetail->mobile }} </td>
                                                   <td class="text-center">{{ $bankDetail->email }} </td>
                                                   <td class="text-center">{{ $bankDetail->state }} </td>
                                                   <td class="text-center">{{ $bankDetail->district }} </td>
                                                   <td class="text-center">
                                                       {{ date('d-m-Y', strtotime($bankDetail->invoice_dt)) }} </td>
                                                   <td
                                                       class="text-center 
    {{ $bankDetail->oem_status == 'A' ? 'bg-success' : ($bankDetail->oem_status == 'R' ? 'bg-danger' : 'bg-warning') }}
">
                                                       {{ $bankDetail->oem_status ? ($bankDetail->oem_status == 'A' ? 'Approved' : ($bankDetail->oem_status == 'R' ? 'Reject' . $bankDetail->oem_remarks : $bankDetail->oem_status)) : 'Pending' }}
                                                   </td>
                                                   <td class="text-center">
                                                       @if ($bankDetail->status == 'D')
                                                           <a href="{{ route('buyerdetail.edit', $bankDetail->id) }}"
                                                               class="btn btn-sm btn-warning">Edit</a>
                                                       @elseif ($bankDetail->status == 'S')
                                                           <a href="{{ route('buyerdetail.ackdoc', $bankDetail->id) }}"
                                                               class="btn btn-sm btn-primary">Ack Document</a>
                                                       @elseif ($bankDetail->status == 'A')
                                                           <a href="{{ route('ackdoc.finalview', $bankDetail->id) }}"
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
       </div>
   @endsection
