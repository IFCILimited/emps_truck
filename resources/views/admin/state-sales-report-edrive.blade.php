
@extends('layouts.dashboard_master')

@section('title')
    OEM EMPS EV Sales Details
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Vehicles subsidized State/UT wise under the {{$heading}} Scheme</h1>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <form method="GET" action="{{ route('state-sales-report', $portal) }}">
                                <div class="row align-items-center">
                                  
                                    <div class="col-md-2">
                                        <label for="segment_filter" class="form-label">Select State/UT</label>
                                        <select name="state" id="segment_filter" class="form-control">
                                            <option selected disabled>Select State/UT</option>
                                            <option value="all" {{ request('state') == 'all' ? 'selected' : '' }}>ALL STATE/UT</option>
                                            @foreach ($allStates as $state)
                                                <option value="{{ $state->state_exist }}" 
                                                        {{ request('state') == $state->state_exist ? 'selected' : '' }}>
                                                    {{ $state->state_exist }}
                                                </option>
                                            @endforeach
                                        </select>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="form-label">Invoice From Date</label>
                                        <input type="date" class="form-control" name="from_date" value="{{request('from_date')}}" onchange="addValidationIndate(this, 'min','to_date')"/>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="form-label">Invoice To Date</label>
                                        <input type="date" class="form-control" name="to_date" value="{{request('to_date')}}" onchange="addValidationIndate(this, 'max','from_date')"/>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('state-sales-report', $portal) }}';">
                                            Reset
                                        </button>
                                    </div>
                                                                    
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar">
                                <table class="table table-bordered table-striped" id="basic-13">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th rowspan="2" class="text-center">SN</th>
                                            <th rowspan="2" class="text-center">State/UT Name</th>
                                            <th colspan="2" class="text-center">No. of Vehicles for which claims raised</th>
                                            <th colspan="2" class="text-center">Amount of claim raised(₹)</th>
                                            <th colspan="2" class="text-center">No. of Vehicles for which claim paid</th>
                                            <th colspan="2" class="text-center">Amount of claim paid(₹)</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">e-2W</th>
                                            <th class="text-center">e-3W</th>

                                            <th class="text-center">e-2W</th>
                                            <th class="text-center">e-3W</th>

                                            <th class="text-center">e-2W</th>
                                            <th class="text-center">e-3W</th>

                                            <th class="text-center">e-2W</th>
                                            <th class="text-center">e-3W</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn = 1;
                                            $tot_2w_veh = 0;
                                            $tot_3w_veh = 0;

                                            $tot_2w_inc = 0;
                                            $tot_3w_inc = 0;
                                        @endphp
                                        @foreach($details as $detail)
                                            <tr>
                                                <td>{{$sn++}}</td>
                                                <td>{{$detail->state_exist}}</td>

                                                <td class="text-end">
                                                    {{number_format($detail->e2w_veh)}}
                                                    @php $tot_2w_veh +=  $detail->e2w_veh @endphp
                                                </td>
                                                <td class="text-end">
                                                    {{number_format($detail->e3w_veh)}}
                                                    @php $tot_3w_veh +=  $detail->e3w_veh @endphp
                                                </td>

                                                <td class="text-end">
                                                    {{number_format($detail->e2w_inc)}}
                                                    @php $tot_2w_inc +=  $detail->e2w_inc @endphp
                                                </td>
                                                <td class="text-end">
                                                    {{number_format($detail->e3w_inc)}}
                                                    @php $tot_3w_inc +=  $detail->e3w_inc @endphp
                                                </td>

                                                <td class="text-end">0</td>
                                                <td class="text-end">0</td>

                                                <td class="text-end">0</td>
                                                <td class="text-end">0</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th  class="text-end">{{number_format($tot_2w_veh)}}</th>
                                            <th  class="text-end">{{number_format($tot_3w_veh)}}</th>

                                            <th  class="text-end">{{number_format($tot_2w_inc)}}</th>
                                            <th  class="text-end">{{number_format($tot_3w_inc)}}</th>

                                            <th  class="text-end">0</th>
                                            <th  class="text-end">0</th>

                                            <th  class="text-end">0</th>
                                            <th  class="text-end">0</th>

                                        </tr>
                                    </tfoot>
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
   <script>
    function addValidationIndate(elem, atr, target)
    {
        $(`input[name=${target}]`).attr(atr, elem.value);
    }

   </script>
   @endpush
