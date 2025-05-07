   <!-- Nav Bar Ends here -->
      @extends('layouts.dashboard_master')
   @section('title')
       Admin - Manufacturing xEV Plants Create
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
                           <h4>Manufacturing xEV Plants Create</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage Plants</li>
                               <li class="breadcrumb-item active">Manufacturing xEV Plants Create</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <!-- Container-fluid starts-->
           <div class="container-fluid">
               <div class="row">



                   <div class="col-sm-12">
                       <form action="{{ route('xEVPlants.update',encrypt($plant->id)) }}" id="plant" role="form" method="POST"
                           class='form-horizontal ' files=true enctype='multipart/form-data' accept-charset="utf-8">
                           @csrf
                           {!! method_field('patch') !!}
                           <div class="card">
                               {{-- <div class="card-header pb-0 card-no-border">
                    <h4>HTML5 Export Buttons</h4>
                  </div> --}}
                               <div class="card-body">
                                   <div class="row g-2">

                                       <div class="table-responsive">
                                           <table class="table " id="plantTable">
                                               <thead>
                                                   <tr>
                                                       <th scope="col">S.No.</th>
                                                       <th scope="col">Plant Name</th>
                                                       <th scope="col">Address</th>
                                                       <th scope="col">Pincode</th>
                                                       <th scope="col">State</th>
                                                       <th scope="col">District</th>
                                                       <th scope="col">City</th>
                                                       <th scope="col">Email Id</th>
                                                       <th scope="col">Landline No.</th>
                                                      
                                                   </tr>
                                               </thead>
                                               <tbody>
                                                   <tr>
                                                       <th scope="row">1</th>
                                                       <td><input class="form-control" type="text"
                                                               placeholder="Plant Name" value="{{$plant->plant_name}}" name="plant_name"></td>
                                                       <td><input class="form-control" value="{{$plant->address}}" type="text" placeholder="Address"
                                                               name="plant_address">
                                                       </td>
                                                       <td><input class="form-control" type="number"
                                                               onkeyup="GetCityByPinCode('PLANT', this.value, 0)"
                                                               placeholder="Pincode" value="{{$plant->pincode}}" name="plant_pincode">
                                                       </td>
                                                       <td>
                                                           <input type="text" class="form-control readonly" value="{{$plant->state}}" placeholder="State" readonly
                                                               name="plant_state" id="PLANTAddState0">
                                                       </td>
                                                       <td>
                                                           <input type="text" class="form-control readonly"
                                                               placeholder="District" value="{{$plant->district}}" readonly
                                                               name="plant_district" id="PLANTAddDistrict0">
                                                       </td>
                                                       <td>
                                                           <input type="text" class="form-control" value="{{$plant->city}}" placeholder="City"
                                                               name="plant_city">
                                                       </td>
                                                       <td><input class="form-control" type="email" value="{{$plant->email}}" placeholder="Email Id"
                                                               name="plant_email">
                                                       </td>
                                                       <td><input class="form-control" type="text"
                                                               placeholder="Landline No." value="{{$plant->landline_no}}" name="plant_landline">
                                                       </td>
                                                       
                                                   </tr>
                                               </tbody>
                                           </table>
                                       </div>


                                   </div>

                               </div>

                           </div>
                           <div class="row">
                            <div class="col-md-4 text-left">
                                <a href="{{ route('xEVPlants.index') }}" class="btn btn-warning">Back</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                       </form>
                   </div>


               </div>
           </div>
           <!-- Container-fluid Ends-->
       </div>
   @endsection
   @push('scripts')
       <script>
           $(document).ready(function() {
               var rowCounter = 1;

               // Function to add a new row
               function addRow() {
                   rowCounter++;

                   var newRow = `<tr>
                          <th scope="row">${rowCounter}</th>
                          <td><input class="form-control" type="text" placeholder="Plant Name" name="evplant[${rowCounter}][plant_name]"></td>
                          <td><input class="form-control" type="text" placeholder="Address" name="evplant[${rowCounter}][plant_address]"></td>
                          <td><input class="form-control" type="number" placeholder="Pincode" name="evplant[${rowCounter}][plant_pincode]"  onkeyup="GetCityByPinCode('PLANT', this.value, ${rowCounter})"></td>
                          <td><input class="form-control readonly" readonly placeholder="State" type="text"name="evplant[${rowCounter}][plant_state]" id="PLANTAddState${rowCounter}"></td>
                          <td><input class="form-control readonly" readonly placeholder="District"type="text"name="evplant[${rowCounter}][plant_district]" id="PLANTAddDistrict${rowCounter}"></td>
                          <td><input class="form-control" type="text" placeholder="City" name="evplant[${rowCounter}][plant_city]"></td>
                          <td><input class="form-control" type="email" placeholder="Email Id" name="evplant[${rowCounter}][plant_email]"></td>
                          <td><input class="form-control" type="text" placeholder="Landline No." name="evplant[${rowCounter}][plant_landline]"></td>
                          <td><button type="button" class="btn btn-sm btn-danger removeRowBtn">Remove</button></td>
                      </tr>`;

                   // Append the new row to the table body
                   $('#plantTable tbody').append(newRow);
               }

               // Function to remove a row
               function removeRow() {
                   $(this).closest('tr').remove();

                   // Update the row numbers
                   $('#plantTable tbody tr').each(function(index) {
                       $(this).find('th').text(index + 1);
                   });
               }

               // Event listener for the Add button
               $('#addRowBtn').click(function() {
                   addRow();
               });

               // Event listener for the Remove button
               $(document).on('click', '.removeRowBtn', removeRow);
           });
       </script>
       {!! JsValidator::formRequest('App\Http\Requests\XrvPlantRequest', '#plant') !!}

       @include('partials.js.pincode')
   @endpush
