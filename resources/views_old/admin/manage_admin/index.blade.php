<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Admin - Dashboard
@endsection

@push('styles')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Admin List</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Manage Admin</li>
                            <li class="breadcrumb-item active">Admin List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            @if (Auth::user()->hasRole('PMA'))
                
            <div class="container">
                <div class="row">
                    <div class="col-12 text-end m-2">
                        <!-- Button aligned to the right -->
                        <a class="btn btn-success" href="{{route('superAdmin.create')}}"><i class="fa fa-user"></i> <i class="fa fa-plus"></i> Create User</a>
                    </div>
                </div>
            </div>
                
            @endif
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">S.No.</th>
                                            <th style="text-align: center;">Name</th>
                                            <th style="text-align: center;">User Name</th>
                                            <th style="text-align: center;">Email Id</th>
                                            <th style="text-align: center;">Mobile No.</th>
                                            <th style="text-align: center;">Designation</th>
                                            <th style="text-align: center;">User Type</th>
                                            <th style="text-align: center;">Status</th>
                                            @if (Auth::user()->hasRole('PMA'))
                                            <th style="text-align: center;">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->username}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->mobile}}</td>
                                            <td>{{$item->auth_designation}}</td>
                                            <td>{{$item->role}}</td>
                                            {{-- <td>
                                                <span class="badge bg-{{ $item->isactive === 'Y' ? 'success' : 'danger' }}">
                                                    {{ $item->isactive === 'Y' ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td> --}}

                                            <td class="text-center"  @if($item->isactive == 'Y') bgcolor="lightgreen" @else bgcolor="red" @endif>
                                                {{ $item->isactive === 'Y' ? 'Active' : 'Inactive' }}
                                               </td>
                                            {{-- <td>
                                                <a href="{{ route('superAdmin.show', $item->id) }}" class="badge bg-primary"><i class="fa fa-eye"></i> View</a>
                                            </td> --}}
                                            @if (Auth::user()->hasRole('PMA'))
                                            <td>
                                                <a href="{{ route('superAdmin.edit', $item->id) }}" class="badge bg-warning"><i class="fa fa-edit"></i> Edit</a>
                                            </td>
                                            @endif
                                        
                                        </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
        </div>
    </div>
@endsection
