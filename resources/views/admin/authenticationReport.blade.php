@extends('layouts.dashboard_master')
@section('title')
   EMPS Authentication Report
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
                        <h4>EMPS Authentication Report</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                
                    
                    <div class="col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-pane fade  show active" id="home" role="tabpanel" aria-labelledby="home-tab"> 
                                    <div class="dt-ext table-responsive  custom-scrollbar mt-5">
                                      <table class="display table-bordered table-striped" id="export-button">
                                          <thead>
                                              <tr>
                                                  {{-- <th scope="col"><input id="checkAll" type="checkbox" name=""/></th> --}}
                                                  <th scope="col">S.No.</th>
                                                  <th scope="col">Dealer Name</th>
                                                  {{-- <th scope="col">Dealer Code</th> --}}
                                                  {{-- <th scope="col">Email </th> --}}
                                                  <th scope="col">Vin Chassis No. </th>

                                                  {{-- <th scope="col">Vehicle Count</th> --}}
                                                  <th scope="col">Customer Id Generated</th>
                                                  <th scope="col">Self Copy Uploaded</th>
                                                  <th scope="col">E-Voucher Generated</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            @foreach($misData as $mis)
                                              
                                              <tr>
                                                
                                                  {{-- <td scope="row">
                                                      <input type="checkbox" name="check[{{$sn}}]" claimid="{{($claim->lot_id)}}" class="btnShowClass" value="{{($claim->lot_id)}}"/>
                                                  </td> --}}
                                                  
                                                  <td>{{$loop->iteration}}</td>
                                                  <td>{{$mis->dealer_name}}</td>
                                                  <td>{{$mis->vin_chassis_no}}</td>
                                                  {{-- <td>{{$mis->vin_chassis_no != null ? 'Y' : 'N'}} </td> --}}
                                                  <td>{{$mis->buyer_id != null ? 'Y' : 'N'}} </td>
                                                  <td>{{$mis->pmedrive_self_copy_id != null ? 'Y' : 'N'}} </td>
                                                  <td>{{$mis->pmedrive_evoucher_copy_id != null ? 'Y' : 'N'}} </td>
                                                 
                                                  
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
        <!-- Container-fluid Ends-->
    </div>
@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\ClaimToMhiRequest', '#proceedGeneration') !!}
    <script>
        $(document).ready(function() {
            $('#checkAll').click(function(e) {
                var isChecked = $('input[type=checkbox]').not(this).is(':checked');
                $('input[type=checkbox]').prop('checked', !isChecked);
            });

            $('#generateClaim').click(function(e) {
                e.preventDefault();
                var claimIds = [];
                $('input[type=checkbox].btnShowClass:checked').each(function() {
                    var claimId = $(this).attr('claimid');
                    claimIds.push(claimId);
                });
                var selectedMonth = $('#month').val();
                if (claimIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Please select Claim to proceed',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                } else if (!selectedMonth) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Please select a Month to proceed',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $('#proceedGeneration').submit();
                }
            });
        });
    </script>
@endpush
