
   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
   Admin - Dashboard
@endsection

@push('styles')
  <style>
    
  </style>
@endpush
@section('content')
<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-6">
          <h4>Dashboard</h4>
        </div>
        <div class="col-6"> 
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">                                       
                <svg class="stroke-icon">
                  <use href="admin/svg/icon-sprite.svg#stroke-home"></use>
                </svg></a></li>
            {{-- <li class="breadcrumb-item">Dashboard</li> --}}
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container-fluid"> 
    <div class="row size-column">
        <form class="form-group" action="{{ route('uploadcheck') }}" method="POST" enctype="multipart/form-data">
           @csrf
            <input type="file" name="file" id="file" class="form-control" >
            <button type="submit" class="btn btn-primary ">submit-button</button>
        </form>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>
@endsection