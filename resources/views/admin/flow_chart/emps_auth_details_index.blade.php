@extends('layouts.dashboard_master')
@section('title')
    Admin - Claim Processing
@endsection

@push('styles')
<script>

</script>
@endpush
@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>EMPS Auth Reoprt</h4>
                </div>
            </div>
        </div>
    </div>
<div class="container">
    <div class="card">
        <div class="card-body">
            <form id="filterForm" method="get">
                <div class="row">
                    <div class="col-md-4 offset-2">
                        <label for="select_oem">List of OEM:</label>
                        <select name="oem_id" class="form-select" id="select_oem">
                            <option value="" disabled selected>SELECT</option>
                            <option value="All" {{ request()->query('oem_id') == 'All' ? 'selected' :''  }} >All</option>
                            @foreach($oemDetails as $oem)
                                <option value="{{ $oem->id }}" {{ request()->query('oem_id') == $oem->id ? 'selected' :''  }} >{{ strtoupper($oem->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="select_seg">List of Segment:</label>
                        <select name="segment_id" class="form-select" id="select_seg">
                            <option value="" disabled selected>SELECT</option>
                            <option value="All" {{ request()->query('segment_id') == 'All' ? 'selected' :''  }} >All</option>
                            @foreach($segMaster as $seg)
                                <option value="{{ $seg->segment_name }}" {{ request()->query('segment_id') == $seg->segment_name ? 'selected' :''  }} >{{ $seg->segment_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            <br>
                <div class="row">
                    <div class="text-center">
                        <button type="submit" id="search" class="btn btn-primary">Search</button>
                        <a href="{{ route('EmpsAuthDetails.index') }}">
                            <button type="button" class="btn btn-danger btnApp" id="clear">Clear</button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@if(isset($data))
    <div class="card">
        <div class="card-header">List of OEMs</div>
        <div class="card-body">
            <table class="table table-bordered table-striped header-fix">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Segment Name</th>
                        <th>Total Customer IDs</th>
                        <th>Generated Customer IDs</th>
                        <th>Pending Customer IDs</th>
                        <th>Face Auth</th>
                        <th>Generated E-Vouchers</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->segment_name }}</td>
                            <td class="text-end">{{ $value->buyer_id_generated + $value->buyer_id_null_count }}</td>
                            <td class="text-end">{{ $value->buyer_id_generated }}</td>
                            <td class="text-end"><strong>{{( $value->buyer_id_generated + $value->buyer_id_null_count)- $value->buyer_id_generated }}</strong></td>
                            <td class="text-end">{{ $value->adh_verify_y_count }}</td>
                            <td class="text-end">{{ $value->evoucher_generated }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>Total</td>
                        <td></td>
                        <td class="text-end">{{ $data->sum('buyer_id_generated') + $data->sum('buyer_id_null_count') }}</td>
                        <td class="text-end">{{ $data->sum('buyer_id_generated') }}</td>
                        <td class="text-end">{{ $data->sum('buyer_id_generated') + $data->sum('buyer_id_null_count') -  $data->sum('buyer_id_generated') }}</td>
                        <td class="text-end">{{ $data->sum('adh_verify_y_count')}}</td>
                        <td class="text-end">{{ $data->sum('evoucher_generated') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endif
</div>
</div>

@endsection
@push('scripts')
{{-- <script>
    $(document).ready(function() {
    //  $('#search').click(function(e) {
    //      var modSeg = $('#select_oem').val();
    //      var modName = $('#select_seg').val();

    //      var link = '/EmpsAuthDetails/search/' + modSeg + '/' + modName;
    //      window.location.href = link;

    //  });

     $('#clear').click(function(e) {

         var link = '../../../EmpsAuthDetails';
         window.location.href = link;

     });


    });
    document.getElementById('clear').addEventListener('click', function() {
 document.getElementById('select_oem').selectedIndex = 0;
 document.getElementById('select_seg').selectedIndex = 0;
 document.getElementById('filterForm').submit();
});

</script> --}}
@endpush

