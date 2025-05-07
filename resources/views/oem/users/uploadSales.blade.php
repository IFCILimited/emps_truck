<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
   Upload Sales
@endsection

@push('styles')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Upload Sales Data</h4>
                    </div>
                    {{-- <div class="col-3 d-flex justify-content-end">
                        <a href="{{ route('downloadFile.productiondata') }}" class="btn btn-success"><i
                                class="fa fa-cloud-download"></i> Format for Sales Data.</a>
                    </div> --}}
			<div class="col-3 justify-content-end">
                        <a href="{{ asset('files/SalesData.xlsx') }}" class="btn btn-success"><i
                                class="fa fa-cloud-download"></i> Format for Sales Data.</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <th class="text-center">S.No.</th>
                                        <th class="text-center">Vehicle Segment</th>
                                        <th class="text-center">Variant Category</th>
                                       
                                        <th class="text-center">Action</th>
                                        <th class="text-center">All Data</th>
                                        
                                    </thead>
                                    <tbody>
                                        
                                          @foreach($catSeg as $cs)
                                            
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$cs->segment_name}}</td>
                                                    <td>{{$cs->category_name}}</td>
                                                    <td> <button class="btn btn-primary " data-bs-toggle="modal"
                                                        data-original-title="test"
                                                        data-bs-target="#uploadProdData{{$cs->sid}}-{{$cs->cid}}">Upload</button></td>
                                                        @php 
                                                            $data = array(
                                                                'sid' => $cs->sid,
                                                                'cid' => $cs->cid
                                                    );
                                                        @endphp
                                                        <td>
                                                            <a href="{{ route('sales.download',encrypt($data)) }}" class="btn btn-sm btn-success mt-2"><i class='fa fa-download'></i></a>
                                                        </td>

                                                          
                                                </tr>
                                                <div class="modal fade"
                                                id="uploadProdData{{$cs->sid}}-{{$cs->cid}}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Upload Excel
                                                                File</h5>
                                                            <button class="btn-close py-0" type="button"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('uploadSalesData') }}"
                                                                method="POST" class="prevent-multiple-submit" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="hidden" name="sid"
                                                                        value="{{$cs->sid}}">
                                                                    <input type="hidden" name="cid"
                                                                        value="{{$cs->cid}}">
                                                                    <label for="excel_file">Choose Excel File:</label>
                                                                    <input type="file" name="excel_file"
                                                                        id="excel_file"
                                                                        class="form-control form-control-file"
                                                                        accept=".xlsx, .xls">
                                                                  
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Upload</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
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
    <script>
        $(document).ready(function() {
           $('.prevent-multiple-submit').on('submit', function() {
               $(this).find('button[type="submit"]').prop('disabled', true);
               var buttons = $(this).find('button[type="submit"]');
               setTimeout(function() {
                   buttons.prop('disabled', false);
               }, 20000); // 25 seconds in milliseconds
           });
       });
    </script>
@endsection
