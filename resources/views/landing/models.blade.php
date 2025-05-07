@extends('layouts.master')
@section('title')
    Scheme Notifications - {{ env('APP_NAME') }}
@endsection
@push('styles')
<style>
    #export-button_filter {
  float: right;
  margin-bottom: 10px;
}
</style>
@endpush
@section('content')

    <!-- Start Subheader -->
    <div class="sub-header p-relative">
        <div class="overlay overlay-bg-black"></div>
        <div class="pattern"></div>
        <div class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="sub-header-content p-relative">
                            <h1 class="text-custom-white lh-default fw-600">Model Approval Under PM E-DRIVE</h1>
                            <ul class="custom">
                                <li> <a href="/" class="text-custom-white">Home</a>
                                </li>
                                <li class="text-custom-white active">Model Details</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Subheader -->
    <!-- start aboutus -->
    <section class="mt-20 m-5">
        
        <div class="card" style="margin-bottom: 25px;border: 1px solid #E6E9EB !important;-webkit-transition: all 0.3s ease;transition: all 0.3s ease;letter-spacing: 0.5px;border-radius: 8px;-webkit-box-shadow: 0px 9px 20px rgba(46, 35, 94, 0.07);box-shadow: 0px 9px 20px rgba(46, 35, 94, 0.07);padding: 25px;">
                <div class="row">
                
                <div class="col-3">
                    <label for="">Select OEM</label>
                    <select name="oem" class="form-select" id="oem">
                        <option value="">Select</option>
                        @foreach($oemname as $name)
                        <option value="{{$name->oem_id}}" {{ $oem_id == $name->oem_id ? 'selected': ''}}>{{$name->oem_name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <label for="">Select Segment</label>
                    <select name="segment" class="form-select" id="segment">
                        <option value="">Select</option>
                        <option value="1" {{$segment == 1 ? 'selected':''}}>e-2W</option>
                        <option value="2" {{$segment == 2 ? 'selected':''}}>e-3W</option>
                    </select>
                </div>
              
                <div class="col-3">
                   <button type="button" style="margin-top: 21px;width: 100%;" class="btn btn-primary filterBtn">Search</button>
                </div>
                <div class="col-3">
                    <a href="{{route('models')}}" style="margin-top: 21px;width: 100%;" class="btn btn-success">Reset</a>
                 </div>
            </div>
        </div>


        {{-- @foreach ($oem_name as $key => $val)
            <div class="border-primary">
                <div class="card-header w-100" style="background-color: #009cde; color: white;">
                    <b>{{ $key + 1 }}. <b>OEM Name: </b>{{ $val->oem_name }}</b>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-12">
                    <div class="card" style="max-width: 100% !important;">
                     
                      <div class="card-body">
                        <ul class="simple-wrapper nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item"><a class="nav-link active text-success" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Active</a></li>
                          <li class="nav-item"><a class="nav-link  text-danger" id="profile-tabs" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Expired</a></li>
                          {{-- <li class="nav-item"><a class="nav-link txt-primary" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a></li> --}}
                        </ul>
                        <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display dataTable table-bordered" id="export-button">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.No.</th>
                                            <th class="text-center">OEM Name</th>
                                            <th class="text-center">xEV Model Name</th>
                                            <th class="text-center">Variant Name</th>
                                            <th class="text-center">Vehicle Type & Segment</th>
                                            <th class="text-center">Vehicle CMVR Category</th>
                                            <th class="text-center">Valid From</th>
                                            <th class="text-center">Valid Upto</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $srNo = 1; @endphp
                                        @foreach ($model_detail as $item)
                                            {{-- @if ($item->oem_id == $val->oem_id) --}}
                                            @if (strtotime($item->valid_from) <= time() && strtotime($item->valid_upto) >= time())
                                                <tr>
                                                    <td class="text-center" style="width: 50px;">{{ $srNo++ }}</td>
                                                    <td style="width: 200px;">{{ $oem_name->where('oem_id',$item->oem_id)->first()->oem_name }}</td>
                                                    <td style="width: 200px;">{{ $item->model_name }}</td>
                                                    <td style="width: 150px;">{{ $item->variant_name }}</td>
                                                    <td style="width: 120px;">{{ $item->segment }}</td>
                                                    <td style="width: 150px;">{{ $item->vehicle_cat }}</td>
                                                    <td class="text-center" style="width: 120px;">
                                                        {{ date('d-m-y', strtotime($item->valid_from)) }}</td>
                                                    <td class="text-center" style="width: 120px;">
                                                        {{ date('d-m-y', strtotime($item->valid_upto)) }}</td>
                                                    <td class="text-center"
                                                        style="
                                                        width: 100px;
                                                        @if (strtotime($item->valid_from) <= time() && strtotime($item->valid_upto) >= time()) background-color: green; color: white;
                                                        @else
                                                            background-color: red; color: white; @endif
                                                    ">
                                                        {{-- @if (strtotime($item->valid_from) <= time() && strtotime($item->valid_upto) >= time())
                                                            Active
                                                        @else
                                                            Expired
                                                        @endif --}}
                                                        {{$item->acstatus}}
                                                    </td>
                    
                                                    <td style="width: 150px;" class="text-center">
                                                        <button type="button" class="btn btn-info btn-sm btn-block" data-toggle="modal"
                                                            data-target="#editModal{{ $item->model_detail_id }}">View</button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="editModal{{ $item->model_detail_id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                    
                                                                        <h5 class="modal-title" id="editModalLabel">Model Details</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="card-header mt-2"
                                                                        style="background-color: #009cde; color: white; font-size: 20px;">
                                                                        Brief Technical Specifications of PMEDRIVE Cases
                                                                    </div>
                                                                    <div class="text-center" style="font-size: 20px">
                                                                        <b>{{ $item->oem_name }}</b>({{ $item->segment }})
                                                                    </div>
                                                                    <div class="modal-body text-center">
                    
                    
                                                                        <div class="row">
                                                                            <div class="col-md-6" style="margin: auto">
                                                                                {{-- {{ dd($item->model_detail_id) }} --}}
                                                                                @if ($item->vehicle_img_upload_id)
                                                                                    <a href="{{ route('doc.down', encrypt($item->vehicle_img_upload_id)) }}"
                                                                                        class="btn btn-info">Download Image</a>
                                                                                @else
                                                                                    <button href="" class="btn btn-info">Vehicle Image not available</button>
                                                                                @endif
                    
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <table class="table table-sm table-bordered table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th colspan="2">Performance and Efficiency of
                                                                                                vehicle</th>
                    
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td class="text-left">Range (Km)</td>
                                                                                            <td style="width: 70px">{{ $item->range }}</td>
                    
                    
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="text-left">Max. Speed (Km/Hr)</td>
                                                                                            <td>{{ $item->min_max_speed }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="text-left">Acceleration (m/s2)</td>
                                                                                            <td>{{ $item->min_acceleration }}</td>
                                                                                        </tr>
                                                                                        <td class="text-left">Warranty (In Years)</td>
                                                                                        <td>
                                                                                            @if ($item->warranty_period_indicate)
                                                                                                {{ $item->warranty_period_indicate }}
                                                                                            @else
                                                                                                ---
                                                                                            @endif
                    
                                                                                        </td>
                    
                                                                                        <tr>
                                                                                            <td class="text-left">Electric Energy consumption
                                                                                                (KWh per 100KM)</td>
                                                                                            <td>{{ $item->max_elect_consumption }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="text-left">Valid From</td>
                                                                                            <td style="background-color: 
                                                                                                @if (strtotime($item->valid_from) <= time() && strtotime($item->valid_upto) >= time())
                                                                                                    green;
                                                                                                @else
                                                                                                    red;
                                                                                                @endif
                                                                                            ">
                                                                                                {{ date('d-m-y', strtotime($item->valid_from)) }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="text-left">Valid Upto</td>
                                                                                            <td style="background-color: 
                                                                                                @if (strtotime($item->valid_from) <= time() && strtotime($item->valid_upto) >= time())
                                                                                                    green;
                                                                                                @else
                                                                                                    red;
                                                                                                @endif
                                                                                            ">
                                                                                                {{ date('d-m-y', strtotime($item->valid_upto)) }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        
                    
                                                                                        <tr>
                                                                                            <th colspan="2" class="text-left">
                                                                                                <b>Battery</b>
                                                                                            </th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="text-left">Battery Technology</td>
                                                                                            <td>{{ $item->battery_type }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="text-left">
                                                                                                Battery Capacity (kWh)
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($item->tot_energy)
                                                                                                    {{ $item->tot_energy }}
                                                                                                @else
                                                                                                    ---
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="text-left">
                                                                                                Battery Density (Wh/Kg)
                                                                                            </td>
                                                                                            <td>{{ $item->spec_density }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="text-left">Battery cycle (No. of Cycles)
                                                                                            </td>
                                                                                            <td>{{ $item->no_of_battery }}</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                    
                                                                            </div>
                                                                        </div>
                    
                    
                    
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                {{-- @endif --}}
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                        </div>
                          <div class="tab-pane fade 
                          " id="profile" role="tabpanel" aria-labelledby="profile-tabs">
                          <div class="dt-ext table-responsive  custom-scrollbar">
                            <table class="display dataTable table-bordered" id="export3">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.No.</th>
                                        <th class="text-center">OEM Name</th>
                                        <th class="text-center">xEV Model Name</th>
                                        <th class="text-center">Variant Name</th>
                                        <th class="text-center">Vehicle Type & Segment</th>
                                        <th class="text-center">Vehicle CMVR Category</th>
                                        <th class="text-center">Valid From</th>
                                        <th class="text-center">Valid Upto</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $srNo = 1; @endphp
                                    @foreach ($model_detail as $item)
                                        {{-- @if ($item->oem_id == $val->oem_id) --}}
                                        @if (strtotime($item->valid_upto) <= time())
                                            <tr>
                                                <td class="text-center" style="width: 50px;">{{ $srNo++ }}</td>
                                                <td style="width: 200px;">{{ $oem_name->where('oem_id',$item->oem_id)->first()->oem_name }}</td>
                                                <td style="width: 200px;">{{ $item->model_name }}</td>
                                                <td style="width: 150px;">{{ $item->variant_name }}</td>
                                                <td style="width: 120px;">{{ $item->segment }}</td>
                                                <td style="width: 150px;">{{ $item->vehicle_cat }}</td>
                                                <td class="text-center" style="width: 120px;">
                                                    {{ date('d-m-y', strtotime($item->valid_from)) }}</td>
                                                <td class="text-center" style="width: 120px;">
                                                    {{ date('d-m-y', strtotime($item->valid_upto)) }}</td>
                                                <td class="text-center"
                                                    style="
                                                    width: 100px;
                                                    @if (strtotime($item->valid_from) <= time() && strtotime($item->valid_upto) >= time()) background-color: green; color: white;
                                                    @else
                                                        background-color: red; color: white; @endif
                                                ">
                                                    {{-- @if (strtotime($item->valid_from) <= time() && strtotime($item->valid_upto) >= time())
                                                        Active
                                                    @else
                                                        Expired
                                                    @endif --}}
                                                    {{$item->acstatus}}
                                                </td>
                
                                                <td style="width: 150px;" class="text-center">
                                                    <button type="button" class="btn btn-info btn-sm btn-block" data-toggle="modal"
                                                        data-target="#editModal{{ $item->model_detail_id }}">View</button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="editModal{{ $item->model_detail_id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                
                                                                    <h5 class="modal-title" id="editModalLabel">Model Details</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="card-header mt-2"
                                                                    style="background-color: #009cde; color: white; font-size: 20px;">
                                                                    Brief Technical Specifications of PMEDRIVE Cases
                                                                </div>
                                                                <div class="text-center" style="font-size: 20px">
                                                                    <b>{{ $item->oem_name }}</b>({{ $item->segment }})
                                                                </div>
                                                                <div class="modal-body text-center">
                
                
                                                                    <div class="row">
                                                                        <div class="col-md-6" style="margin: auto">
                                                                            {{-- {{ dd($item->model_detail_id) }} --}}
                                                                            @if ($item->vehicle_img_upload_id)
                                                                                <a href="{{ route('doc.down', encrypt($item->vehicle_img_upload_id)) }}"
                                                                                    class="btn btn-info">Download Image</a>
                                                                            @else
                                                                                <button href="" class="btn btn-info">Vehicle Image not available</button>
                                                                            @endif
                
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <table class="table table-sm table-bordered table-hover">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th colspan="2">Performance and Efficiency of
                                                                                            vehicle</th>
                
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="text-left">Range (Km)</td>
                                                                                        <td style="width: 70px">{{ $item->range }}</td>
                
                
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-left">Max. Speed (Km/Hr)</td>
                                                                                        <td>{{ $item->min_max_speed }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-left">Acceleration (m/s2)</td>
                                                                                        <td>{{ $item->min_acceleration }}</td>
                                                                                    </tr>
                                                                                    <td class="text-left">Warranty (In Years)</td>
                                                                                    <td>
                                                                                        @if ($item->warranty_period_indicate)
                                                                                            {{ $item->warranty_period_indicate }}
                                                                                        @else
                                                                                            ---
                                                                                        @endif
                
                                                                                    </td>
                
                                                                                    <tr>
                                                                                        <td class="text-left">Electric Energy consumption
                                                                                            (KWh per 100KM)</td>
                                                                                        <td>{{ $item->max_elect_consumption }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-left">Valid From</td>
                                                                                        <td style="background-color: 
                                                                                            @if (strtotime($item->valid_from) <= time() && strtotime($item->valid_upto) >= time())
                                                                                                green;
                                                                                            @else
                                                                                                red;
                                                                                            @endif
                                                                                        ">
                                                                                            {{ date('d-m-y', strtotime($item->valid_from)) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-left">Valid Upto</td>
                                                                                        <td style="background-color: 
                                                                                            @if (strtotime($item->valid_from) <= time() && strtotime($item->valid_upto) >= time())
                                                                                                green;
                                                                                            @else
                                                                                                red;
                                                                                            @endif
                                                                                        ">
                                                                                            {{ date('d-m-y', strtotime($item->valid_upto)) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    
                
                                                                                    <tr>
                                                                                        <th colspan="2" class="text-left">
                                                                                            <b>Battery</b>
                                                                                        </th>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-left">Battery Technology</td>
                                                                                        <td>{{ $item->battery_type }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-left">
                                                                                            Battery Capacity (kWh)
                                                                                        </td>
                                                                                        <td>
                                                                                            @if ($item->tot_energy)
                                                                                                {{ $item->tot_energy }}
                                                                                            @else
                                                                                                ---
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-left">
                                                                                            Battery Density (Wh/Kg)
                                                                                        </td>
                                                                                        <td>{{ $item->spec_density }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="text-left">Battery cycle (No. of Cycles)
                                                                                        </td>
                                                                                        <td>{{ $item->no_of_battery }}</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                
                                                                        </div>
                                                                    </div>
                
                
                
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            {{-- @endif --}}
                                        @endif
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
            
        {{-- @endforeach --}}

    </section>
    @push('scripts');
        <script>
             $('.filterBtn').click(function(e) {
        e.preventDefault(); // Prevent default button behavior

        // Get column and order values
        var col = document.getElementById("oem");
        var odr = document.getElementById("segment");
        var stat = document.getElementById("status");
        var oem = col.value;
        var segment = odr.value;
        // var status = stat.value;

        // Check if either column or order is not selected
        if (!oem || !segment) {
            // Show SweetAlert if either is missing
           alert('Please select both OEM and Segment before applying the filter.');
            return false; // Prevent further action
        }

        // Proceed to redirect if both column and order are selected
        window.location.href = "/models/" + oem + "/" + segment + "/" + status;
});
        </script>
    @endpush
@endsection
