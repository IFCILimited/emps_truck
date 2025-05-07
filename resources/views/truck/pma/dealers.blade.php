<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Dealers
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
                        <h4>Manage Dealer</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            {{-- <li class="breadcrumb-item">Manage OEM</li>
                            <li class="breadcrumb-item active">OEM Post-Registration</li> --}}
                            <li class="breadcrumb-item">Manage Dealer</li>
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
                            <select class="form-control" name="status" id="status">
                               
                                <option value="all" {{($id  == 'all')?'selected':''}}>All</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" {{($id  == $user->id)?'selected':''}}>{{$user->name}}</option>
                                @endforeach
                                {{--  <option value="P" >Pending</option>
                                <option value="R" >Rejected</option> --}}
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <button class="btn btn-primary" type="button" onclick="filterBtn()">Filter</button>
                        </div>
                    
                        </div>
                        
                    </div>    
                    </div>  
                &nbsp;
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="basic-13">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Dealer Name</th>
                                            <th>Dealer Code</th>
                                            <th>GSTIN Number</th>
                                            <th>Mobile Number</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dealerReg as $key => $dealerRegs)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $dealerRegs->name }}</td>
                                                <td>{{ $dealerRegs->dealer_code }}</td>
                                                <td>{{ $dealerRegs->dealer_gstin_no }}</td>
                                                <td>{{ $dealerRegs->mobile }}</td>
                                                <td>
                                                    <ul class="action">
                                                        <li class=""><a href="{{ route('e-trucks.dealersShow', encrypt($dealerRegs->id)) }}" class="btn btn-sm btn-success">View</a></li>&nbsp;
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
    </div>
    
@endsection

@push('scripts')
<script>
    function filterBtn() {
            var status = document.getElementById("status");
            var statusid = status.value;

            window.location.href = "/dealers/" + statusid;
        }
</script>
@include('partials.js.prevent')
@endpush
