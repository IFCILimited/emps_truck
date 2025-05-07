   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - Generate Vahan Report
   @endsection

   @push('styles')
   @endpush
   @section('content')
       <div class="page-body">
           <div class="container-fluid">
                <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4>Generate Vahan Report</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item active">Generate Vahan Report</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid">
            <form action="{{route("e-trucks.vahanReport.generate")}}" method="post">
                @csrf
                <input type="hidden" name="portal" value="{{$portal}}"/>

                <div class="d-flex justify-content-center align-items-center">
                    <div class="card mt-4" style="width: 80% !important;">
                        {{-- <div class="card-header pb-0 card-no-border">
                            <h6>Select Segment</h6>
                        </div> --}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="segment">Select Segment</label>
                                    <select class="form-control" id="segment" name="segment">
                                        <option value="">Select Segment</option>
                                        <option value="all">All</option>
                                        <option value="1">e-2W</option>
                                        <option value="2">e-3W</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="segment">From:</label>
                                            <input class="form-control" type="date" name="from_date" placeholder="YYYY-MM-DD" onchange="addValidationIndate(this, 'min','to_date')"/>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="segment">To:</label>
                                            <input class="form-control" type="date" name="to_date" placeholder="YYYY-MM-DD" onchange="addValidationIndate(this, 'max','from_date')"/>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-3 mt-2 d-flex align-items-center">
                                    <button type="submit" class="btn btn-success w-100">Download</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </form>
            
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
