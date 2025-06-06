   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Model Details
   @endsection

   @push('styles')
   <style>
    /* Ensure table layout and column alignment */
    
    table th {
        
    white-space: nowrap;  /* Prevent text from breaking onto a new line */
   
}


/* Optional: Scrollbar styling for better UX */

   </style>
   @endpush
   @section('content')
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4>Model Details</h4>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid">
               <div class="row">
                   <div class="col-sm-12">
                        {{-- <div class="card">
                            <div class="card-header">
                                <h3>Sorting</h3>
                            </div>
                            {{-- <div class="card-body">
                                <div class="row d-flex">
                                    <div class="col-4 offset-2">
                                        <label for="" class="form-label">Colunm</label>
                                        <select name="colunm" class="form-control" id="colunm">
                                            <option value="" selected disabled>Select Column</option>
                                            {{-- <option {{($colunm == 'sno'?'selected':'')}} value="sno">S.No.</option> 
                                            <option {{($colunm == 'oem_name'?'selected':'')}} value="oem_name">OEM Name</option>
                                            <option {{($colunm == 'model_name'?'selected':'')}} value="model_name">xEV Model Name</option>
                                            <option {{($colunm == 'variant_name'?'selected':'')}} value="variant_name">Variant Name</option>
                                            <option {{($colunm == 'segment'?'selected':'')}} value="segment">Vehicle Segment</option>
                                            <option {{($colunm == 'vehicle_cat'?'selected':'')}} value="vehicle_cat">Vehicle Category</option>
                                            <option {{($colunm == 'submitted_at'?'selected':'')}} value="submitted_at">OEM Submitted Date</option>
                                            <option {{($colunm == 'testing_certificate_no'?'selected':'')}} value="testing_certificate_no">CMVR Certificate</option>
                                            <option {{($colunm == 'testing_cmvr_date'?'selected':'')}} value="testing_cmvr_date">CMVR Date</option>
                                            <option {{($colunm == 'valid_from'?'selected':'')}} value="valid_from">Valid From</option>
                                            <option {{($colunm == 'valid_upto'?'selected':'')}} value="valid_upto">Valid Upto</option>
                                            {{-- <option {{($colunm == 'testing_flag'?'selected':'')}} value="testing_flag">Testing Agency Status</option> --}}
                                            {{-- <option {{($colunm == 'mhi_flag'?'selected':'')}} value="mhi_flag">MHI Status</option> 
                                            <option {{($colunm == 'testing_created_at'?'selected':'')}} value="testing_created_at">Testing Agency Submitted Date</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label">Filter</label>
                                        {{-- {{dd($order)}} 
                                        <select name="order" class="form-control" id="order">
                                            @if($order == null)
                                               
                                                    <option  value="" selected disabled >Select Order</option>
                                                    <option {{$order == 'asc'?'selected':''}} value="asc">Ascending</option>
                                                    <option {{$order == 'desc'?'selected':''}} value="desc">Descending</option>
                                               
                                            @else
                                               
                                                    <option  value="" selected disabled >Select Order</option>
                                                    <option {{$order == 'asc'?'selected':''}} value="asc">Ascending</option>
                                                    <option {{$order == 'desc'?'selected':''}} value="desc">Descending</option>
                                                @if($order == 'approved' || $order == 'pending' || $order == 'rejected')
                                                    <option  value="" selected disabled >Select Satatus</option>
                                                    <option {{$order == 'approved'?'selected':''}} value="approved">Approved</option>
                                                    <option {{$order == 'pending'?'selected':''}} value="pending">Pending</option>
                                                    <option {{$order == 'rejected'?'selected':''}} value="rejected">Rejected</option>
                                                @endif 
                                            @endif    
                                        </select>
                                    </div>
                            </div>
                            <button class="btn btn-success mt-3 offset-5 filterBtn" id="" type="button">Search</button>
                            <a href="{{route('modelDetails')}} " class="btn btn-primary mt-3">Reset</a> 
                        </div>                    
                        </div>                     --}}
                       <div class="card">
                           <div class="card-body">
                               <div class="dt-ext table-responsive   custom-scrollbar">
                                   
                                   <table class="display table-bordered table-striped" id="basic-12" style="width:100%">
                                     
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>OEM Name</th>
                                            <th>xEV Model Name</th>
                                            <th>Variant Name </th>
                                            <th>Vehicle Segment</th>
                                            <th>Vehicle Category</th>
                                            <th> OEM Submitted Date </th>
                                            <th> PM E-Drive Certificate </th>
                                            <th> PM E-Drive Date </th>
                                            <th> Valid From </th>
                                            <th> Valid Upto </th>
                                            <th>Testing Agency Status</th>
                                            <th>Testing Agency Submitted Date</th>
                                            <th>PMA Status</th>
                                            <th>PMA Recommended Date</th>
                                            <th>MHI Status</th>
                                            <th>MHI Approved Date</th>
                                            <th>MHI Approved By</th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($models as $model)
                                            <tr>
                                                <td >{{ $loop->iteration }}</td>
                                                <td >{{ $model->oem_name }}</td>
                                                <td > {{ $model->model_name }}</td>
                                                <td >{{ $model->variant_name }} </td>
                                                <td >{{ $model->segment }}</td>
                                                <td >{{ $model->vehicle_cat }}</td>
                                                @php 
                                                $submitted_time = strtotime($model->submitted_at); 
                                                $submitted_format = date('d-m-Y', $submitted_time);

                                                $testing_cmvr_time = strtotime($model->testing_cmvr_date); 
                                                $testing_cmvr_format = date('d-m-Y', $testing_cmvr_time);

                                                $valid_from_time = strtotime($model->valid_from); 
                                                $valid_from_format = date('d-m-Y', $valid_from_time);

                                                $valid_upto_time = strtotime($model->valid_upto); 
                                                $valid_upto_format = date('d-m-Y', $valid_upto_time);
                                                
                                            @endphp
                                               <td  data-sort={{$submitted_time}} class="text-center">{{$submitted_format}}</td>
                                                <td >{{ $model->testing_certificate_no }}</td>
                                                <td  data-sort={{$testing_cmvr_time}} class="text-center">{{$testing_cmvr_format}}</td>
                                                <td  data-sort={{$valid_from_time}} class="text-center">{{$valid_from_format}}</td>
                                                <td  data-sort={{$valid_upto_time}} class="text-center">{{$valid_upto_format }}</td>
                                                <td  class="text-center"
                                                    @if ($model->testing_flag == 'A') bgcolor="lightgreen" @elseif($model->testing_flag == 'R') bgcolor="red" @else bgcolor="orange" @endif>
                                                    {{ $model->testing_flag == 'A' ? 'Approved' : ($model->testing_flag == 'R' ? 'Rejected' : 'Pending') }}
                                                </td>
                                                @php 
                                                $strToTimeDate = strtotime($model->testing_created_at); 
                                                $formated = date('d-m-Y', $strToTimeDate);

                                                $mhi_time = strtotime($model->mhi_created_at); 
                                                $mhi_format = date('d-m-Y', $mhi_time);
                                            @endphp
                                               <td  data-sort={{$strToTimeDate}} class="text-center">{{$formated}}</td>
                                                <td class="text-center"
                                                @if ($model->pma_status == 'A') bgcolor="lightgreen" @elseif($model->pma_status == 'R') bgcolor="red" @else bgcolor="orange" @endif>
                                                {{-- {{ $model->pma_status == 'A' ? 'Approved' : ($model->pma_status == 'R' ? 'Rejected' : ($model->testing_flag == 'R' ? '-' : 'Pending')) }} --}}
                                                {{ $model->pma_status == 'A' ? 'Recommended' : ($model->pma_status == 'R' ? 'Rejected' : 'Pending') }}

                                                </td>
                                                    @php
                                                    $pma_time = strtotime($model->pma_created_at); 
                                                    $pma_format = date('d-m-Y', $pma_time);
                                                    @endphp
                                                <td  data-sort={{$pma_time}} class="text-center">{{($model->pma_created_at != null) ? $pma_format : '-' }}</td>
                                                <td  class="text-center"
                                                    @if ($model->mhi_flag == 'A') bgcolor="lightgreen" @elseif($model->mhi_flag == 'R') bgcolor="red" @else bgcolor="orange" @endif>
                                                    {{ $model->mhi_flag == 'A' ? 'Approved' : ($model->mhi_flag == 'R' ? 'Rejected' : 'Pending') }}
                                                </td>
                                                <td  data-sort={{$mhi_time}} class="text-center">{{($model->mhi_created_at != null) ? $mhi_format : '-' }}</td>
                                               <td >
                                                {{-- {{dd($model->mhi_id)}} --}}
                                                   @if($model->mhi_id == null)
                                                        -
                                                   @else
                                                   {{ $users->where('id', $model->mhi_id)->first()->name }}
                                                   @endif         
                                                </td>
                                               
                                                <td >
                                                    <a href="{{route('e-trucks.modelShow',encrypt($model->model_detail_id))}}"
                                                        class="btn btn-success">Process</a>
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
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
   
    $(document).ready(function() {
        $('.btnApp').click(function(e) {
            
            $('#formApprove').submit();
        });
        $('.btnReject').click(function(e) {
            
            $('#formReject').submit();
        });

        $('.filterBtn').click(function(e) {
    e.preventDefault(); // Prevent default button behavior

    // Get column and order values
    var col = document.getElementById("colunm");
    var odr = document.getElementById("order");
    var colunm = col.value;
    var order = odr.value;

    // Check if either column or order is not selected
    if (!colunm || !order) {
        // Show SweetAlert if either is missing
        Swal.fire({
            icon: 'warning',
            title: 'Selection Required',
            text: 'Please select both Column and Order before applying the filter.',
            confirmButtonText: 'OK'
        });
        return false; // Prevent further action
    }

    // Proceed to redirect if both column and order are selected
    window.location.href = "/modelDetails/" + colunm + "/" + order;
});


document.getElementById('colunm').addEventListener('change', function() {
    var selectedValue = this.value;
    var orderSelect = document.getElementById('order');
    
    if(selectedValue === 'testing_flag' || selectedValue === 'mhi_flag') {
        orderSelect.innerHTML = '<option value="" selected disabled>Select Status</option>';
        var options = ['Approved', 'Pending', 'Rejected'];
        options.forEach(function(option) {
            var optionElement = document.createElement('option');
            optionElement.value = option.toLowerCase();
            optionElement.text = option;
            orderSelect.appendChild(optionElement);
        });
    } else {
        // Reset the Order field to default options
        orderSelect.innerHTML = '<option value="" selected disabled>Select Order</option>';
        var defaultOptions = ['Ascending', 'Descending'];
        defaultOptions.forEach(function(option) {
            var optionElement = document.createElement('option');
            // optionElement.value = option.toLowerCase();
            var optionValue = option.toLowerCase();
            if(optionValue === 'ascending') {
                optionElement.value = 'asc';
            }else if(optionValue === 'descending') {
                optionElement.value = 'desc';
            }
            optionElement.text = option;
            orderSelect.appendChild(optionElement);
        });
    }
});


    });
    
    
    </script>
    
   @endpush
