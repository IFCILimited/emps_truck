   <!-- Nav Bar Ends here -->
   @extends('layouts.e_truck_dashboard_master')
   @section('title')
       Admin - Manufacturing xEV Plants Create
   @endsection

   @push('styles')
   @endpush
   @section('content')
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
           <div class="container-fluid">
               <div class="row">
                   <div class="col-sm-12">
                       <form action="{{ route('e-trucks.xEVPlants.store') }}" id="plant" role="form" method="POST"
                           class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                           @csrf
                           <div class="card">
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
                                                       <th scope="col">Action</th>
                                                   </tr>
                                               </thead>
                                               <tbody>
                                                   <tr>
                                                       <th scope="row">1</th>
                                                       <td><input class="form-control" type="text"
                                                               placeholder="Plant Name" name="evplant[0][plant_name]"></td>
                                                       <td><input class="form-control" type="text" placeholder="Address"
                                                               name="evplant[0][plant_address]">
                                                       </td>
                                                       <td><input class="form-control" type="number"
                                                               onkeyup="GetCityByPinCode('PLANT', this.value, 0)"
                                                               placeholder="Pincode" name="evplant[0][plant_pincode]">
                                                       </td>
                                                       <td>
                                                           <input type="text" class="form-control readonly"
                                                               placeholder="State" readonly name="evplant[0][plant_state]"
                                                               id="PLANTAddState0">
                                                       </td>
                                                       <td>
                                                           <input type="text" class="form-control readonly"
                                                               placeholder="District" readonly
                                                               name="evplant[0][plant_district]" id="PLANTAddDistrict0">
                                                       </td>
                                                       <td>
                                                           <input type="text" class="form-control" placeholder="City"
                                                               name="evplant[0][plant_city]">
                                                       </td>
                                                       <td><input class="form-control" type="email" placeholder="Email Id"
                                                               name="evplant[0][plant_email]">
                                                       </td>
                                                       <td><input class="form-control" type="text"
                                                               placeholder="Landline No." name="evplant[0][plant_landline]">
                                                       </td>
                                                       <td><button id="addRowBtn" type="button"
                                                               class="btn btn-sm btn-success">Add</button>
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
                                <a href="{{ route('e-trucks.xEVPlants.index') }}" class="btn btn-warning">Back</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                        
                        
                       </form>
                   </div>
               </div>
           </div>
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
               $('.prevent-multiple-submit').on('submit', function() {
               $(this).find('button[type="submit"]').prop('disabled', true);
               var buttons = $(this).find('button[type="submit"]');
                setTimeout(function() {
                buttons.prop('disabled', false);
            }, 10000); // 25 seconds in milliseconds
           });
           });
       </script>
       {!! JsValidator::formRequest('App\Http\Requests\XrvPlantRequest', '#plant') !!}

       @include('partials.js.pincode')
   @endpush
