<!-- resources/views/oem/vin_chassis_search.blade.php -->
@extends('layouts.e_truck_dashboard_master')

@section('title')
    OEM Production Data
@endsection

@section('content')
    <div class="page-body">
        <div class="container">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 mb-3 d-flex" style="justify-content: space-between;">
                            <h4>Customer's & Dealer's Details</h4>
                        </div>
                        <div class="dt-ext table-responsive custom-scrollbar mt-5">
                            <table class="display table-bordered table-striped" id="export-button">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>UserName</th>
					<th>Dealer Code</th>
                                        <th>Device Code</th>
                                        <th>CPU Id</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($dealersData) && $dealersData)
                                        @php $counter = 1; @endphp
                                        @foreach($dealersData as $dealer)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $dealer->name }}</td>
					    <td>{{ $dealer->username }}</td>
					    <td>{{ $dealer->dealer_code}}</td>
                                            <td>{{ $dealer->auth_designation}}</td>
                                            <td>{{ $dealer->device_code }}</td>
                                            <td>{{ $dealer->cpuid }}</td>
                                            <td>
                                                @if ($dealer->device_status == 1)
                                                    <button data-id="{{ $dealer->id }}" class="deactive_user btn btn-success">Active</button>
                                                @else
                                                    <button class="btn btn-danger" disabled>Inactive</button>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                        @php $counter++; @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="12" class="text-center">No data available in table</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #0070ba">
                                <h3 class="modal-title"><b>Deactivate User!</b></h3>
                                <button type="button" class="close btn-lg" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="updateForm" action="{{route("e-trucks.unactiveUser.update")}}" method="post">
                                @csrf
                                @method("PUT")
                                <div class="modal-body" style="display: block;">
                                    
                                        <div class="col-12">
                                            <div class="form-group" id="form_field">
                                                <label>Remarks*</label>
                                                <textarea id="remkr" class="form-control" name="remarks"></textarea>
                                                <input id="user_id" type="hidden" name="user_id" readonly value=""/>
                                            </div>
                                        </div>
                                    
                                    <div class="col-12 form-error text-danger"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="close btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button id="check_btn" type="button" class="btn btn-primary">Deactivate User</button>
                                    <a></a>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $('#check_btn').on("click", function(){
        $('#form-error').text("");
        if($('#remkr').val().trim() == ""){
            $('.form-error').text("The remarks field is required!");
            return;
        }

        Swal.fire({
            title: "Proceeding this request will deactivate the user and you will not be able to reactive it again?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Cancel",
            denyButtonText: `Deactive user`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isDenied) {
                $('#updateForm').submit();
            }
        });
        // $('#updateForm').submit();
    });

    $('.deactive_user').on("click", function(){
        $('#remkr').val("");
        $('#user_id').val(event.target.getAttribute("data-id"));
        $('#confirm').modal('show');
    })

    $('.close').on("click", function(){
        $('#confirm').modal('hide');
    })
</script>
@endpush
