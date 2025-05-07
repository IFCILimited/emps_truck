<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Request- Bank Details
@endsection

@push('styles')
@endpush

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4> Bank Details</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dt-ext table-responsive  custom-scrollbar">
                            <table class="display table-bordered  table-striped" id="export-button">
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
                                    @foreach ($tempBank as $key => $bankDetail)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $bankDetail->account_holder_name }}</td>
                                            <td>{{ $bankDetail->bank_name }}</td>
                                            <td>{{ $bankDetail->branch_name }}</td>
                                            <td>{{ $bankDetail->account_no }}</td>
                                            <td>{{ $bankDetail->account_type }}</td>
                                            <td>{{ $bankDetail->ifsc_code }}</td>
                                            <td>{{ $bankDetail->micr_code }}</td>
                                            <td>
                                                <a href="{{ route('bankApproval.show', $bankDetail->id) }}"
                                                    class="btn btn-success">View</a>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Model Approval</h5>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action=" " method="POST" id="creApproval" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="reason">Reason for rejection</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\ModelOEMApprovalRequest', '#creApproval') !!}
@endpush
