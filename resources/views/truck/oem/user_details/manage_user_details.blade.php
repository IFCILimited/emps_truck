@extends('layouts.e_truck_dashboard_master')

@section('title')
    OEM Production Data
@endsection

@section('content')
    <div class="page-body">
        <div class="container">
            <div class="col-xl-12 mt-3">
                <form id="update_profile" action="{{route('e-trucks.manageCompanyDetails.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-header">
                            <h2>Existing Details</h2>
                        </div>
                        <div class="card-body">
                            <div class="card" id="comp_details">
                                <div class="card-header">
                                    <div class="h5">
                                        Company Details
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mt-2">
                                            <label>Name</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->name}}" readonly name="exist_cust_name"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Email Id</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->email}}" readonly name="exist_cust_email"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Contact Number</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->mobile}}" readonly name="exist_cust_mobile"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>GSTIN</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->gstin_no}}" readonly name="exist_cust_gst"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Address</label>
                                            <textarea class="form-control readonly" readonly name="exist_cust_addr">{{$usersDetails->address}}</textarea>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>city</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->city}}" readonly name="exist_cust_city"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>District</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->district}}" readonly name="exist_cust_dist"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Landmark</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->landmark}}" readonly name="exist_cust_land"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>State</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->state}}" readonly name="exist_cust_state"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Pincode</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->pincode}}" readonly name="exist_cust_pincode"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card" id="auth_details">
                                <div class="card-header">
                                    <div class="h5">
                                        Authorized Person Details
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mt-2">
                                            <label> Name</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->auth_name}}" name="exist_auth_name" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label> Email Id</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->auth_email}}" name="exist_auth_email" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Contact Number</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->auth_mobile}}" name="exist_auth_mobile" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Address</label>
                                            <textarea class="form-control readonly" readonly name="exist_auth_addr">{{$usersDetails->auth_address}}</textarea>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>city</label> 
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->auth_city}}" readonly name="exist_auth_city"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>District</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->auth_district}}" readonly name="exist_auth_dist"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Landmark</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->auth_landmark}}" readonly name="exist_auth_land"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>State</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->auth_state}}" readonly name="exist_auth_state"/>
                                        </div>
                                        <div class="col-md-4 mt-2" id="auth_pincode">
                                            <label>Pincode</label>
                                            <input class="form-control readonly" type="text" value="{{$usersDetails->auth_pincode}}" readonly name="exist_auth_pincode"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <button class="btn btn-primary" type="button" id="change_details">Change Details</button>
                            </div>
                        </div>
                    </div>

                    <div id="update_card" style="display: none">
                        <div class="card" >
                            <div id="update_card_table"></div>
                        </div>

                        <div class="card">
                            <div class="card-header"><h2>Required Documents*</h2></div>
                            <div class="col-12" style="max-width: 90%;margin: 0 auto;">
                                <table class="table stripped" style="padding: 0 1rem">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Doc Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @foreach($docs as $doc)
                                    <tr>
                                        <th>{{$loop->iteration}}</th>
                                        <th>{{$doc->doc_name}}</th>
                                        <td><input class="form-control" type="file" name="{{$doc->file_name}}" /></td>
                                    </tr>
                                    @endforeach
                                </table>
                                <div class="col-12 text-center mt-2 mb-2">
                                    <button type="submit" class="btn btn-info">Create Request</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $('#change_details').on('click', function(){
        let cust_det = generateCustomerCard();
        let auth_det = generateAuthPersonCard();
        let html = `<div class="card-header">
                        <h2>Update Details</h2>
                    </div>`;
        html+= `<div class="card-body">`;
        html+= cust_det;
        html+= auth_det;
        html+= `</div>`;
        $('#update_card_table').append(html);
        // const newHtml = document.createElement('div');
        // newHtml.innerHTML = html;
        // document.getElementById('update_card_table').insertAdjacentElement('beforebegin', newHtml);
        $(this).hide();
        $('#update_card').show();
        // added = true;
    })



    function generateAuthPersonCard(){
        let html = `<div class="card-header">
                        <div class="h5">
                            Authorized Person Details
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <label> Name</label>
                                <input class="form-control" type="text" value="{{$usersDetails->auth_name}}" name="auth_name"/>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label> Email Id</label>
                                <input class="form-control" type="text" value="{{$usersDetails->auth_email}}" name="auth_email"/>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Contact Number</label>
                                <input class="form-control" type="text" value="{{$usersDetails->auth_mobile}}" name="auth_mobile"/>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Address</label>
                                <textarea class="form-control" name="auth_addr">{{$usersDetails->auth_address}}</textarea>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Landmark</label>
                                <input class="form-control" type="text" value="{{$usersDetails->auth_landmark}}" name="auth_land"/>
                            </div>
                            <div class="col-md-4 mt-2" id="auth_pincode">
                                <label class="form-label" for="Pincode">Pincode:</label>
                                    <input class="form-control" type="text" name="auth_pincode"
                                        placeholder="Pincode"
                                        onkeyup="GetCityByPinCode('AUTH', this.value, 0)" value="{{$usersDetails->auth_pincode}}">
                                    <span id="AUTHpincodeMsg0"
                                        style="color:red;font-weight:bold;display: none">
                                        @error('Pincode')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </span> 
                            </div>
                            <div class="col-md-4 mt-2">
                                <label class="form-label" for="City">City:</label>
                                    <select class="form-control" name="auth_city" id="AUTHAddCity0">
                                        <option class="form-control" selected value="{{$usersDetails->auth_city}}">{{$usersDetails->auth_city}}</option>
                                    </select>
                                    @error('City')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>District</label>
                                <input id="AUTHAddDistrict0" class="form-control readonly" type="text" value="{{$usersDetails->auth_district}}" name="auth_dist" readonly/>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>State</label>
                                <input id="AUTHAddState0" class="form-control readonly" type="text" value="{{$usersDetails->auth_state}}" name="auth_state" readonly/>
                            </div>
                            
                        </div>
                    </div>`;

        return html;
    }

    function generateCustomerCard(){
        let html = `<div class="card-header">
                        <div class="h5">
                            Company Details
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <label>Name</label>
                                <input class="form-control" type="text" value="{{$usersDetails->name}}" name="cust_name"/>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Email Id</label>
                                <input class="form-control" type="text" value="{{$usersDetails->email}}" name="cust_mail"/>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Contact Number</label>
                                <input class="form-control" type="text" value="{{$usersDetails->mobile}}" name="cust_mobile"/>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>GSTIN</label>
                                <input class="form-control" type="text" value="{{$usersDetails->gstin_no}}" name="cust_gst"/>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Address</label>
                                <textarea class="form-control" name="cust_addr">{{$usersDetails->address}}</textarea>
                            </div>
                             <div class="col-md-4 mt-2">
                                <label>Landmark</label>
                                <input class="form-control" type="text" value="{{$usersDetails->landmark}}" name="cust_land"/>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label class="form-label" for="Pincode">Pincode:</label>
                                    <input class="form-control" type="text" name="cust_pincode"
                                        placeholder="Pincode"
                                        onkeyup="GetCityByPinCode('CUST', this.value, 0)" value="{{$usersDetails->pincode}}">
                                    <span id="CUSTpincodeMsg0"
                                        style="color:red;font-weight:bold;display: none">
                                        @error('Pincode')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label class="form-label" for="City">City:</label>
                                    <select class="form-control" name="cust_city" id="CUSTAddCity0">
                                        <option class="form-control" selected value="{{$usersDetails->city}}">{{$usersDetails->city}}</option>
                                    </select>
                                    @error('City')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>District</label>
                                <input id="CUSTAddDistrict0" class="form-control readonly" type="text" value="{{$usersDetails->district}}" name="cust_dist" readonly/>
                            </div>
                           
                            <div class="col-md-4 mt-2">
                                <label>State</label>
                                <input id="CUSTAddState0" class="form-control readonly" type="text" value="{{$usersDetails->state}}" name="cust_state" readonly/>
                            </div>
                            
                        </div>
                    </div>`;

        return html;
    }
</script>
@include('partials.js.pincode')
{!! JsValidator::formRequest('App\Http\Requests\ProfileUpdateRequest', '#update_profile') !!}

@endpush
