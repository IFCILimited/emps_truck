<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Pincodes
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
                        <h4>Manage Pincodes</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            {{-- <li class="breadcrumb-item">Manage OEM</li>
                            <li class="breadcrumb-item active">OEM Post-Registration</li> --}}
                            <li class="breadcrumb-item">Manage Pincodes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                {{-- <span class="pull-right">
                    <button class="btn btn-primary" type="button">
                        <a href="{{ route('manageDealer.create') }}" class="text-light" style="text-decoration: none;"><i class="fa fa-user"></i>  Add Single Dealer</a>
                    </button>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#AddBulkDearlers"><i class="fa fa-users"></i>  Add Bulk Dealer</button>
                </span> --}}
                
                <div class="col-sm-12">
                <div class="card p-10">
                    <div class="row">
                        
                        <div class="col-lg-3 offset-3">
                        <input type="text" name="pincode" id='pincode' placeholder="Pincode" class="form-control" >
                    </div>
                    <div class="col-lg-3">
                        <button class="btn btn-primary" type="button" onclick="filterBtn()">Filter</button>
                        <button class="btn btn-success" type="button"data-bs-toggle="modal" data-original-title="test" data-bs-target="#reject" >Add</button>
                    </div>
                
                    </div>
                    
                </div>    
                </div>  
            &nbsp;
            
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th>ID.</th>
                                            <th>Pincode</th>
                                            <th>City </th>
                                            <th>State</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($pin))
                                            <tr>
                                                <td>{{$pin->id}}</td>
                                                <td>{{$pin->pincode}}</td>
                                                <td>{{$pin->city}}</td>
                                                <td>{{$pin->state}}</td>
                                                
                                            </tr>
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
    <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="reject" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div class="modal-toggle-wrapper"> 
                <form action="{{route('addpin')}}"  id="formReject" role="form" method="POST"
                   class='form-horizontal modelVer' accept-charset="utf-8" enctype='multipart/form-data' files=true>
                   @csrf
               
                  
                    <div class="row">
                        <div class="col-12">
                            <label>Pincode</label>
                            <input type="number" name="pincode" id="" class="form-control">
                        </div> 
                        <div class="col-12">
                            <abel>City</abel>
                            <input type="text" name="city" id="" class="form-control">
                        </div> 
                        <div class="col-12">
                            <label>State</label>
                            <input type="text" name="state" id="" class="form-control">
                        </div> 
                    </div>
                    <div class="col-12">
                        <button class="btn bg-primary mt-2 d-flex align-items-center gap-2 text-light ms-auto btnReject" type="submit">Add<i data-feather="arrow-right"></i></button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    
@endsection

@push('scripts')
<script>
    function filterBtn() {
            var status = document.getElementById("pincode");
            var statusid = status.value;

            window.location.href = "/pincodes/" + statusid;
        }
</script>
@include('partials.js.prevent')
@endpush
