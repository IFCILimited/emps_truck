@extends('layouts.dashboard_master')
@section('title')
    Open Vin For Edit
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
                        <h4>Manage Vin Chassis</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Manage Vin Chassis</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <form action="{{ route('vinEdit.create') }}" method="POST" enctype="multipart/form-data"
                      class="form-horizontal prevent-multiple-submit" id="vinsedit" accept-charset="utf-8">
                    @csrf
                    <div class="col-sm-12" style="margin-top: 20px;">
                        @if($oem_id == null)
                        <div class="card p-10">
                            <div class="row">
                                <div class="col-9">
                                    <select class="form-control" name="oem" id="oem_id">
                                        <option value="">Select</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ ($oem_id == $user->id) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-primary filterBtn" type="button">Search</button>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="card p-10">
                            <div class="row">
                                <div class="col-12">
                                    <h4>OEM Name :: {{ $users }}</h4>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($oem_id != null || (isset($openVins) && count($openVins) > 0 ))
                        @if(Route::currentRouteName() != 'vinSearch')
                        <div class="card">
                            <div class="card-body">
                                <div class="dt-ext table-responsive custom-scrollbar">
                                    <table class="table table-bordered table-striped" id="basic-13">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Oem Name</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Reason</th>
                                                <th>Document</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($oem_id != null)
                                                @foreach($selusers as $suser)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ $suser->name }}
                                                            <input type="hidden" name="oem_id" value="{{ $suser->id }}">
                                                        </td>
                                                        <td><input type="date" name="validFrom" class="form-control-sm" required></td>
                                                        <td><input type="date" name="validTo" class="form-control-sm" required></td>
                                                        <td><input type="text" name="reason" class="form-control-sm" required></td>
                                                        <td><input type="file" name="vin_doc" class="form-control-sm" required></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                @if(isset($openVins))
                                                    @foreach($openVins as $ovin)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $users->where('id', $ovin->oem_id)->first()->name }}</td>
                                                            <td data-sort="{{ strtotime($ovin->valid_from) }}">
                                                                {{ date('d-m-Y', strtotime($ovin->valid_from)) }}
                                                            </td>
                                                            <td data-sort="{{ strtotime($ovin->valid_to) }}">
                                                                {{ date('d-m-Y', strtotime($ovin->valid_to)) }}
                                                            </td>
                                                            <td>{{ $ovin->reason }}</td>
                                                            <td>
                                                                <a href="{{ route('doc.down', encrypt($ovin->vin_document)) }}" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
                        <input type="hidden" name="oem_id" value="{{$oem_id}}">
                        @if($oem_id != null)
                            <div class="card">
                                <div class="card-header">
                                    <h4>Vin Chassis
                                        <button type="button" class="btn btn-primary ml-2 btn-sm add-more" style="float:right;">
                                            Add More
                                        </button>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div id="vinchassis-container" class="row">
                                        <div class="col-4">
                                            <div class="form-group d-flex align-items-center mb-2">
                                                <input type="text" name="vinchassis[1]" class="form-control" placeholder="Enter VIN Chassis">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success" style="margin: 0 auto; display: grid;">
                                        Check
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        let fieldCount = 1;

        // Add a new VIN chassis field
        $(document).on('click', '.add-more', function (e) {
            e.preventDefault();
            fieldCount++;
            const newField = `
                <div class="col-4">
                    <div class="form-group d-flex align-items-center mb-2">
                        <input type="text" name="vinchassis[${fieldCount}]" class="form-control" placeholder="Enter VIN Chassis ${fieldCount}">
                        <button type="button" class="btn btn-danger ml-2 btn-sm remove-field">Remove</button>
                    </div>
                </div>
            `;
            $('#vinchassis-container').append(newField);
        });

        // Remove VIN chassis field
        $(document).on('click', '.remove-field', function (e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();
        });

        // Filter OEM selection
        $('.filterBtn').click(function (e) {
            e.preventDefault();
            const oem_id = $('#oem_id').val();
            if (!oem_id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selection Required',
                    text: 'Please select OEM before applying the filter.',
                    confirmButtonText: 'OK'
                });
                return;
            }
            window.location.href = "/vinSearch/" + oem_id;
        });
    });
</script>
@include('partials.js.prevent')
@endpush
