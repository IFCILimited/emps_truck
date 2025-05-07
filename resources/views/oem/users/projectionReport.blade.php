<!-- resources/views/oem/vin_chassis_search.blade.php -->
@extends('layouts.dashboard_master')

@section('title')
    Projection Report
@endsection

@section('content')
    <div class="page-body">
        <div class="container">
            

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-6 mb-3">
                            <h4>Projection Report</h4>
                        </div>
                        <div class="dt-ext table-responsive custom-scrollbar">
                            
                            <form action="{{route('projectionReport.storeReport')}}" method="POST" enctype="multipart/form-data" role="form">
                            @csrf
                                <table class="display" id="export-button5">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>April</th>
                                        <th>May</th>
                                        <th>June</th>
                                        <th>July</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        
                                        <th>Production Data</th>
                                        @foreach($projection as $key => $pro)
                                        <td>
                                            <input type="hidden" value="{{$pro->id}}" name="production[{{$pro->id}}][id]">
                                            <input type="hidden" value="{{$pro->month}}" name="production[{{$pro->id}}][month]">
                                            <input type="number" value="{{$pro->production}}" class="form-control form-control-sm" name="production[{{$pro->id}}][production]" >
                                        </td>
                                        @endforeach
                                        
                                       
                                        
                                    </tr>
                                    <tr>
                                        
                                        <th>Sales</th>
                                        @foreach($projection as $key => $pro)
                                        <td>
                                            {{-- <input type="hidden" value="{{$pro->month}}" name="production[{{$pro->id}}][month]"> --}}
                                            <input type="number" value="{{$pro->sales}}" class="form-control form-control-sm" name="production[{{$pro->id}}][sales]" >
                                        </td>
                                        @endforeach
                                    </tr>
                                   
                                </tbody>
                            </table>
                            <div class="col-5 offset-5 mb-3">
                                
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@endsection
@push('scripts')
<script>
    $("#export-button5").DataTable({
            dom: "Bfrtip",
            buttons: [],
            pageLength: 2000,
            order: [], // Disable initial sorting
            });
</script>
@endpush
