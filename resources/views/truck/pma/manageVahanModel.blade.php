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
                           <h4>Manage Vahan Models</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item active">Manage Vahan Models</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid">
            {{-- <form action="{{route("releaseVIN.getVIN")}}" method="post">
                @csrf

                <div class="d-flex justify-content-center align-items-center">
                    <div class="card mt-4" style="width: 60% !important;">
                        <div class="card-header pb-0 card-no-border">
                            <h6>Search VIN Chassis Number</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="vin_num" value="@if(isset($buyerId)){{$buyerId}}@endif" placeholder="Enter VIN Chassis Number" required/>
                                    </div>
                                </div>
                                <div class="col-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success w-100">Fetch Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form> --}}
                
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header pb-0 card-no-border d-flex justify-content-between">
                                    <h4>Model Details</h4>
                                    <form method="get" action="{{ route('e-trucks.vahanModel.export') }}">
                                        <button class="btn btn-primary" type="submit">Export Master Vahan</button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <div class="dt-ext table-responsive  custom-scrollbar">
                                        <table id="basic-key-table" class="table table-bordered table-striped">
                                            <thead>
                                                {{-- <tr>S.No.</tr> --}}
                                                <tr>
                                                    <th class="text-center">S.No.</th>
                                                    <th class="text-center">Portal Model Name</th>
                                                    <th class="text-center" style="max-width: 10rem;">Vahan API Model Name</th>
                                                    <th class="text-center" style="max-width: 10rem;">vahan Master Model Name</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $sno = 1; @endphp
                                                @foreach($details as $detail)
                                                <tr>
                                                    <td>{{$sno}}</td>
                                                    <td class="text-left">{{$detail->portal_model_name}}</td>
                                                    <td class="text-left">{{$detail->vahan_api_model_name}}</td>
                                                    <td class="text-left">{{$detail->vahan_portal_master_model_name}}</td>
                                                    <td class="text-left 
                                                        @if($detail->status_code == 2) bg-success 
                                                        @elseif($detail->status_code == 3) bg-warning
                                                        @elseif($detail->status_code == 1) bg-info
                                                        @elseif($detail->status_code == 4) bg-danger 
                                                        @endif
                                                    ">{{$detail->status}}</td>
                                                    <td>
                                                        @if($detail->status_code == 1) 
                                                            <button 
                                                            data-vahan="{{$detail->vahan_api_model_name}}" 
                                                            data-vahan-oem="{{$detail->vahan_api_oem_name}}" 
                                                            data-name="{{$detail->portal_model_name}}" 
                                                            class="add_in_master btn btn-primary">Add in Master</button>
                                                        @else - @endif
                                                    </td>
                                                </tr>
                                                @php $sno++; @endphp
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #f8f9fa; color: #333;">
                                    <h3 class="modal-title" style="margin: 0;"><b>Model Details</b></h3>
                                    <button type="button" class="close_model" data-dismiss="modal" aria-label="Close" style="background: transparent; border: none; color: #000; border-radius: 50%; width: 30px; height: 30px; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                                    </button>
                                </div>
                                <form id="saveModel" action="{{route('e-trucks.vahanModel.save')}}" method="post">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-body model_content">
                                       
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger close_model">Cancel</button>
                                        <button id="check_btn" type="button" class="btn btn-primary" style="background-color: #007bff; border: none;">Save</button>
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
    $('.close_model').on('click', function(){
        $('#confirm').modal('hide');
    });

    $('#check_btn').on('click', function(){
        Swal.fire({
            title: "Warning!",
            text: "Are you sure?",
            icon: "warning",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Cancel",
            denyButtonText: "Proceed",
            customClass: {
                confirmButton: 'btn btn-secondary',
                denyButton: 'btn btn-primary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isDenied) {
                // console.log("Save");
                $('#saveModel').submit(); 
            }
        });
    });

    $('.add_in_master').on('click', function(){
        let btnCurrent = this;

        btnCurrent.setAttribute("disabled", true);
        btnCurrent.innerText = "Fetching...";
        // console.log($(this).attr('data-name'));
        let vahan_model = $(this).attr('data-vahan');
        let vahan_oem = $(this).attr('data-vahan-oem');

        $.ajax({
            url: "{{route('fetch-model-details')}}",
            type: 'GET',
            data: {
                model: $(this).attr('data-name'),
                vahan_model
            },
            success: function(data){
                // console.log(data);
                if(data.status) {
                    let model = data.result;
                    let html = `<input type="hidden" name="oem_id" value="${model.oem_id}"/>
                                <input type="hidden" name="segment_id" value="${model.segment_id}"/>
                                <input type="hidden" name="category_id" value="${model.vehicle_cat_id}"/>
                                <input type="hidden" name="model_id" value="${model.model_id}"/>
                                <input type="hidden" name="emps_model_id" value="${data.emps.max}"/>
                                <div class="col-12">
                                            <div class="form-group" id="form_field">
                                                <label>Portal Model Name</label>
                                                <input type="text" class="form-control readonly" value="${model.model_name}" name="portal_model_name" readonly/>
                                            </div>
                                        </div>
                                <div class="col-12">
                                            <div class="form-group" id="form_field">
                                                <label>Portal Oem Name</label>
                                                <input type="text" class="form-control readonly" value="${model.oem_name}" name="portal_oem_name" readonly/>
                                            </div>
                                        </div>
                                <div class="col-12">
                                            <div class="form-group" id="form_field">
                                                <label>Segment Name</label>
                                                <input type="text" class="form-control readonly" value="${model.segment}" name="portal_segment_name" readonly/>
                                            </div>
                                        </div>
                                <div class="col-12">
                                            <div class="form-group" id="form_field">
                                                <label>Category Name</label>
                                                <input type="text" class="form-control readonly" value="${model.vehicle_cat}" name="portal_category_name" readonly/>
                                            </div>
                                        </div>
                                <div class="col-12">
                                            <div class="form-group" id="form_field">
                                                <label>Vahan Model Name</label>
                                                <input type="text" class="form-control readonly" value="${vahan_model}" name="vahan_model_name" readonly/>
                                            </div>
                                        </div>
                                <div class="col-12">
                                            <div class="form-group" id="form_field">
                                                <label>Vahan OEM Name</label>
                                                <input type="text" class="form-control readonly" value="${vahan_oem}" name="vahan_oem_name" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group" id="form_field">
                                                <label>EMPS Certificate Valid From</label>
                                                <input type="text" class="form-control readonly" value="${data.emps.testing_approval_date}" name="emps_valid_from" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group" id="form_field">
                                                <label>EMPS Certificate Valid Upto</label>
                                                <input type="text" class="form-control readonly" value="${data.emps.testing_expiry_date}" name="emps_valid_upto" readonly/>
                                            </div>
                                        </div>`;
                        $(".model_content").empty();
                        $('.model_content').append(html);

                        // console.log(html);
                        $('#confirm').modal('show');
                
                }

                btnCurrent.removeAttribute("disabled", false);
                btnCurrent.innerText = "Add in Master";
                
            },error: function(err){
                console.error(err);
                btnCurrent.removeAttribute("disabled", false);
                btnCurrent.innerText = "Add in Master";
            }
        })
    })
   </script>
   @endpush
