   <!-- Nav Bar Ends here -->
   @extends('layouts.e_truck_dashboard_master')
   @section('title')
       OEM - Manufacturing xEV Plants
   @endsection
   @push('styles')
   @endpush
   @section('content')
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4>Manufacturing xEV Plants</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage Plants</li>
                               <li class="breadcrumb-item active">Manufacturing xEV Plants</li>
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
                               <a href="{{ route('e-trucks.xEVPlants.create') }}" class="btn btn-success" style="float: right;">Add
                                   Plant</a>
                           </div>
                           <div class="card-body">
                               <div class="dt-ext table-responsive  custom-scrollbar">
                                   <table class="display table-bordered table-striped" id="export-button">
                                       <thead>
                                           <tr>
                                               <th scope="col">S.No.</th>
                                               <th scope="col">Plant Name</th>
                                               <th scope="col">Address</th>
                                               <th scope="col">Pincode</th>
                                               <th scope="col">State</th>
                                               <th scope="col">District</th>
                                               <th scope="col">City</th>
                                               <th scope="col">Email Id</th>
                                               <th scope="col">Landline No.</th>
                                               <th scope="col">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach ($plants as $plant)
                                               <tr>
                                                   <th scope="row">{{ $loop->iteration }}</th>
                                                   <td>{{ $plant->plant_name }} </td>
                                                   <td>{{ $plant->address }} </td>
                                                   <td>{{ $plant->pincode }}</td>
                                                   <td>{{ $plant->state }}</td>
                                                   <td>{{ $plant->district }}</td>
                                                   <td>{{ $plant->city }}</td>
                                                   <td>{{ $plant->email }}</td>
                                                   <td>{{ $plant->landline_no }}</td>
                                                   <td><a href="{{ route('e-trucks.xEVPlants.edit', encrypt($plant->id)) }}"
                                                           class="btn btn-sm btn-danger">Edit</a>
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
