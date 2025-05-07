@extends('layouts.dashboard_master')
@section('title')
    Admin - Claim To MHI
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
                        <h4>Claim Generate</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                
                    
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-pane fade  show active" id="home" role="tabpanel" aria-labelledby="home-tab"> 
                                    <div class="dt-ext table-responsive  custom-scrollbar mt-5">
                                      <table class="display table-bordered table-striped" id="export-button">
                                          <thead>
                                              <tr>
                                                  {{-- <th scope="col"><input id="checkAll" type="checkbox" name=""/></th> --}}
                                                  <th scope="col">S.No.</th>
                                                  <th scope="col">Oem Name</th>
                                                  <th scope="col">Claim Number</th>
                                                  <th scope="col">No of Vehicle </th>
                                                  <th scope="col">Total Incentive Amount</th>
                                                  <th scope="col">Created Date</th>
                                                  <th scope="col">Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            
                                              @if(count($claimMaster)>0)
                                              @foreach($claimMaster as $claim)
                                              <tr>
                                                  @php
                                                      $sn = $loop->iteration;
                                                  @endphp
                                                  {{-- <td scope="row">
                                                      <input type="checkbox" name="check[{{$sn}}]" claimid="{{($claim->lot_id)}}" class="btnShowClass" value="{{($claim->lot_id)}}"/>
                                                  </td> --}}
                                                  <td>{{$sn}}</td>
                                                  <td>{{$claim->name}}</td>
                                                  <td><a href="{{route('viewclaims',encrypt($claim->claim_id))}}">{{$claim->claimnumberformat}}</a></td>
                                                  <td>{{$claim->vehicle_count}}</td>
                                                  <td>{{$claim->tot_incamt}}</td>
                                                  <td>{{date('d-m-Y', strtotime($claim->created_at))}}</td>

                                                @if($claim->claim_doc_status == null)
                                                    <td><a href="{{route('claimUploadDoc',encrypt($claim->claim_id))}}" class="btn btn-sm btn-warning">Upload Documents</a></td>
                                                @elseif($claim->claim_doc_status == 'D')
                                                    <td><a href="{{route('claimUploadDoc',encrypt($claim->claim_id))}}" class="btn btn-sm btn-info">Edit Documents</a></td>
                                                @elseif($claim->claim_doc_status == 'A')
                                                    <td><a href="{{route('claimUploadDoc',encrypt($claim->claim_id))}}" class="btn btn-sm btn-success">View Documents</a></td>
                                                @endif 
                                                    {{-- <td>
                                                      <a href="" class="btn btn-sm btn-warning">View</a>
                                                  </td> --}}
                                              </tr>
                                              @endforeach
                                              @else
                                             
                                              <td colspan="19" class="text-center">No Data Available</td>
                                          
                                              @endif
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
