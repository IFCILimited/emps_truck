@extends('layouts.dashboard_master')

@section('title')
    OEM Production Data
@endsection

@section('content')
    <div class="page-body">
        <div class="container">
            <div class="col-xl-12 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Profile Update Requests</h3>
                        @if(!Auth::user()->hasRole('PMA'))
                            <a class="btn btn-info" href="{{ route('manageCompanyDetails.create') }}">New Request</a>
                        @endif
                    </div>
                    <div class="col-12 pt-2 pb-2" style="max-width: 90%;margin: 0 auto;">
                        @if($details && count($details) > 0)
                        <table class="table stripped" style="padding: 0 1rem">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>OEM Name</th>
                                    @if(Auth::user()->hasRole('PMA'))
                                    <th>Submitted On</th>
                                    @else
                                    <th>Created On</th>
                                    @endif
                                    <th>Status</th>
                                    <th>PMA Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach($details as $det)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$det->name}}</td>
                                <td>{{Auth::user()->hasRole('PMA') ? $det->submited_at : $det->created_at}}</td>
                                <td class="text-center @if($det->status == 'S') bg-success @else bg-warning @endif">
                                    @if($det->status == 'S')
                                        SUBMITTED
                                    @else
                                        PENDING
                                    @endif
                                </td>
                                <td class="text-center @if($det->pma_status == 'A') bg-success @elseif($det->pma_status == 'R') bg-danger @elseif($det->pma_status == 'P') bg-warning @endif">
                                    @if(!$det->pma_status) 
                                        - 
                                    @else 
                                        @if($det->pma_status == 'P')
                                            PENDING
                                        @elseif($det->pma_status == 'A')
                                            APPROVED
                                        @else
                                            REJECTED
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{route('manageCompanyDetails.show', $det->id)}}">
                                        @if($det->pma_status == 'P' || !$det->pma_status)
                                            @if($det->status == 'D')
                                                Edit Details
                                            @else
                                                View Details
                                            @endif
                                        @else
                                        view details
                                        @endif
                                    </a>

                                    {{-- @if($det->status == 'S')
                                        <a class="btn btn-success" href="{{route('manageCompanyDetails.show', $det->id)}}">view details</a>
                                    @else
                                        <a class="btn btn-info" href="{{route('manageCompanyDetails.show', $det->id)}}">view details</a>
                                    @endif --}}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        <h4 class="text-danger">No Records</h4>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

{{-- {!! JsValidator::formRequest('App\Http\Requests\CreateMultiBuyerIdRequest', '#model_create') !!} --}}

@endpush
