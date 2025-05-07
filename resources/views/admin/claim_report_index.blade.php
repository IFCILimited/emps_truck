@extends('layouts.dashboard_master')
@section('title')
   EMPS Authentication Report
@endsection

@push('styles')

<style>
    /*----------------genealogy-scroll----------*/

.genealogy-scroll::-webkit-scrollbar {
  width: 5px;
  height: 8px;
}
.genealogy-scroll::-webkit-scrollbar-track {
  border-radius: 10px;
  background-color: #e4e4e4;
}
.genealogy-scroll::-webkit-scrollbar-thumb {
  background: #212121;
  border-radius: 10px;
  transition: 0.5s;
}
.genealogy-scroll::-webkit-scrollbar-thumb:hover {
  background: #d5b14c;
  transition: 0.5s;
}

/*----------------genealogy-tree----------*/
.genealogy-body {
  white-space: nowrap;
  overflow-y: hidden;
  padding: 50px;
  min-height: 500px;
  /* padding-top: 10px; */
  text-align: center;
}
.genealogy-tree {
  display: inline-block;
}
.genealogy-tree ul {
  padding-top: 20px;
  position: relative;
  padding-left: 0px;
  display: flex;
  justify-content: center;
  /* margin-left: -45px; */
}
.genealogy-tree li {
  float: left;
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 20px 5px 0 5px;
}
.genealogy-tree li::before,
.genealogy-tree li::after {
  content: "";
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 2px solid #ccc;
  width: 50%;
  height: 18px;
}
.genealogy-tree li::after {
  right: auto;
  left: 50%;
  border-left: 2px solid #ccc;
}
.genealogy-tree li:only-child::after,
.genealogy-tree li:only-child::before {
  display: none;
}
.genealogy-tree li:only-child {
  padding-top: 0;
}
.genealogy-tree li:first-child::before,
.genealogy-tree li:last-child::after {
  border: 0 none;
}
.genealogy-tree li:last-child::before {
  border-right: 2px solid #ccc;
  border-radius: 0 5px 0 0;
  -webkit-border-radius: 0 5px 0 0;
  -moz-border-radius: 0 5px 0 0;
}
.genealogy-tree li:first-child::after {
  border-radius: 5px 0 0 0;
  -webkit-border-radius: 5px 0 0 0;
  -moz-border-radius: 5px 0 0 0;
}
.genealogy-tree ul ul::before {
  content: "";
  position: absolute;
  top: 0;
  left: 50%;
  border-left: 2px solid #ccc;
  width: 0;
  height: 20px;
}
.genealogy-tree li a {
  text-decoration: none;
  color: #666;
  font-family: arial, verdana, tahoma;
  font-size: 11px;
  display: inline-block;
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  /* width: 100%; */
  /* margin-left: 50px; */
}

.genealogy-tree li a:hover,
.genealogy-tree li a:hover + ul li a {
  background: #c8e4f8;
  color: #000;
}

.genealogy-tree li a:hover + ul li::after,
.genealogy-tree li a:hover + ul li::before,
.genealogy-tree li a:hover + ul::before,
.genealogy-tree li a:hover + ul ul::before {
  border-color: #fbba00;
}

/*--------------memeber-card-design----------*/

.member-view-box {
  padding-bottom: 10px;
  text-align: center;
  border-radius: 4px;
  position: relative;
  border: 1px;
  border-color: #e4e4e4;
  border-style: solid;
  max-width: 100%;
}
.member-image {
  padding: 10px;
  width: 100%;
  position: relative;
}
.member-image img {
  width: 100px;
  height: 100px;
  border-radius: 6px;
  background-color: #fff;
  z-index: 1;
}
.member-header {
  padding: 5px 0;
  text-align: center;
  background: #345;
  color: #fff;
  font-size: 14px;
  border-radius: 4px 4px 0 0;
}
.member-footer {
  text-align: center;
}
.member-footer div.name {
  color: #000;
  font-size: 14px;
  margin-bottom: 5px;
}
.member-footer div.downline {
  color: #000;
  font-size: 12px;
  font-weight: bold;
  margin-bottom: 5px;
}
.custom-table {
            /* width: 100%; */
            /* margin: auto; */
            /* border-radius: 10px; */
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .custom-table th {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 7px;
        }

        .custom-table td {
            text-align: center;
            padding: 7px;
        }

        .custom-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .custom-table tbody tr:hover {
            background-color: #e9ecef;
            transition: 0.3s;
        }

        #loader {
    display: none; /* Hidden by default */
    text-align: center;
    margin: 20px 0;
}

#loader .spinner-border {
    width: 3rem;
    height: 3rem;
}

</style>
@endpush
@section('content')
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Claim Report</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container">
            {{-- <div class="row"> --}}
                        <div class="card">
                            {{-- <div class="container"> --}}
                            <div class="body genealogy-body genealogy-scroll">
                                <div class="genealogy-tree" style="margin-left: -28px">
                                <ul>
                                    <li>
                                    <a href="javascript:void(0);" style="width: 30%;">
                                        <div class="member-view-box">
                                        <div class="member-header">
                                            <span>Claim Submitted</span>
                                        </div>
                                        <div class="member-image">
                                                <table class="table table-bordered custom-table" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Of <br> Claims</th>
                                                            <th>Claim Amount <br> (in Cr)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-end">{{$claimReport->claim_id_count}}</td>
                                                            <td class="text-end">{{$claimReport->incentive_amount}}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                        </div>

                                        </div>
                                    </a>
                                    <ul class="active">
                                        <li>
                                            <a href="javascript:void(0);" style="width: 100%;" onclick="modalshow()">
                                            <div class="member-view-box">
                                            <div class="member-header">
                                                <span>Pending with PMA</span>
                                            </div>
                                            <div class="member-image">
                                                <table class="table table-bordered custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Of <br> Claims</th>
                                                            <th>Claim Amount <br> (in Cr)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-end">{{$claimReport->pending_count}}</td>
                                                            <td class="text-end">{{$claimReport->pending_amt}}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                            </div>
                                        </a>
                                        <ul>


                                        </ul>
                                        </li>
                                        <li>
                                        <a href=""style="width: 100%; " >
                                            <div class="member-view-box">
                                            <div class="member-header">
                                                <span>Recommended by PMA</span>
                                            </div>
                                            <div class="member-image">
                                                <table class="table table-bordered custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Of <br> Claims</th>
                                                            <th>Claim Amount <br> (in Cr)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-end">{{$claimReport->recommended_count}}</td>
                                                            <td class="text-end">{{$claimReport->recommended_amt}}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            {{-- <div class="member-footer">
                                                <div class="name"><span>Name</span></div>
                                                <div class="downline"><span>2 | 3</span></div>
                                            </div> --}}
                                            </div>
                                        </a>
                                        <ul>


                                        </ul>
                                        </li>
                                        <li>
                                            <a href="" style="width: 100%; ">
                                            <div class="member-view-box">
                                                <div class="member-header">
                                                <span>Paid</span>
                                                </div>
                                                <div class="member-image">
                                                <table class="table table-bordered custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Of <br> Claims</th>
                                                            <th>Claim Amount <br> (in Cr)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-end">{{$claimReport->claim_paid_count}}</td>
                                                            <td class="text-end">{{$claimReport->claim_paid_amt}}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                </div>

                                            </div>
                                            </a>
                                            <ul>


                                            </ul>
                                        </li>
                                        <li>
                                            <a href="" style="width: 100%; ">
                                            <div class="member-view-box">
                                                <div class="member-header">
                                                <span>Withheld</span>
                                                </div>
                                                <div class="member-image">
                                                <table class="table table-bordered custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Of <br> Claims</th>
                                                            <th>Claim Amount <br> (in Cr)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-end">{{$claimReport->withheld_count}}</td>
                                                            <td class="text-end">{{$claimReport->withheld_amt}}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                </div>

                                            </div>
                                            </a>
                                            <ul>


                                            </ul>
                                        </li>
                                        <li>
                                            <a href="" style="width: 100%; ">
                                            <div class="member-view-box">
                                                <div class="member-header">
                                                <span>Rejected</span>
                                                </div>
                                                <div class="member-image">
                                                <table class="table table-bordered custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Of <br> Claims</th>
                                                            <th>Claim Amount <br> (in Cr)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-end">{{$claimReport->rejected_count}}</td>
                                                            <td class="text-end">{{$claimReport->rejected_amt}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                            </a>
                                            <ul>
                                            </ul>
                                        </li>

                                    </ul>
                                    </li>
                                </ul>
                                </div>
                            </div>
                        {{-- </div> --}}
                </div>
                {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </div>
        <!-- Container-fluid Ends-->



        <div class="modal fade" id="claimModal" tabindex="-1" role="dialog" aria-labelledby="claimModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="claimModalLabel">Claim Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="oemDropdown">OEM</label>
                                        <select class="form-control" name="oem_id" id="oem_id">
                                            <option value="all">All</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ ($oem_id == $user->id) ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="segmentDropdown">Segment</label>
                                        <select class="form-control" name="seg_id" id="seg_id">
                                            <option value="all">All</option>
                                            @foreach($segment as $segments)
                                                <option value="{{ $segments->id }}" {{ ($oem_id == $segments->id) ? 'selected' : '' }}>
                                                    {{ $segments->segment_name }}
                                                </option>
                                            @endforeach
                                        </select>
                        </div>
                            <div class="form-group col-md-4">
                                <label class="d-none d-md-block">&nbsp;</label>
                                    <button class="btn btn-primary filterBtn" id="fetchDetailBtn" type="button">Search</button>
                            </div>
                    </div>
                        <hr>
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>OEM Name</th>
                                    <th>Segment Name</th>
                                    <th>No. of Claim</th>
                                    <th>Incentive Amount(in Cr)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="claimTableBody">

                            </tbody>
                        </table>
                        <div id="loader" class="text-center loader">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p>Fetching data, please wait...</p>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <!-- Close Button -->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                    </div>
                </div>
            </div>
        </div>

            <div id="claimModalOem" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Claim Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="modal-body">
                                    <h4>OEM Name: <span id="oemNameDisplay"></span></h4><br>
                                    <h4>Segment Name: <span id="segNameDisplay"></span></h4>
                                </div>

                            </div>
                            <hr>
                            <table class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>Claim Number</th>
                                        <th>Segment Name</th>
                                        <th>No. of Vin</th>
                                        <th>Incentive Amount(in Cr)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="VinTableBody">

                                </tbody>
                            </table>
                            <div id="loader" class="text-center loader">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <p>Fetching data, please wait...</p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                        </div>
                    </div>
                </div>
            </div>



@endsection
@push('scripts')
<script>

$(function () {
  $(".genealogy-tree ul").hide();
  $(".genealogy-tree>ul").show();
  $(".genealogy-tree ul.active").show();
  $(".genealogy-tree li").on("click", function (e) {
    var children = $(this).find("> ul");
   // if (children.is(":visible")) children.hide("fast").removeClass("active");
    //else children.show("fast").addClass("active");
    e.stopPropagation();
  });
});

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

//         $(document).ready(function() {
//     // When any card link is clicked, open the modal and load details
//     $(".member-view-box a").on("click", function(e) {
//         e.preventDefault();  // Prevent default link behavior

//         // Example data - you can replace this with actual dynamic data if needed
//         var claimTitle = $(this).find(".member-header span").text();
//         var claimIdCount = $(this).closest('a').find("td:eq(0)").text();
//         var claimAmount = $(this).closest('a').find("td:eq(1)").text();

//         // Set the modal content dynamically
//         var modalContent = `
//             <strong>${claimTitle}</strong><br>
//             <strong>No. of Claims:</strong> ${claimIdCount}<br>
//             <strong>Claim Amount (in Cr):</strong> ${claimAmount}
//         `;

//         // Insert the data into the modal
//         $("#modalshow").html(modalContent);

//         // Show the modal
//         $("#claimModal").modal('show');
//     });
// });

$('#fetchDetailBtn').click(function (e) {
    e.preventDefault();

    let oem_id = $('#oem_id').val();
    let seg_id = $('#seg_id').val();

    if (!oem_id || !seg_id) {
        alert("Please choose both options");
        return false;
    }

    console.log("Fetching data...");

    // Show Loader (Optional: You can add a loading animation in UI)
    $('#claimTableBody').html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');

    $.ajax({
        type: "post",
        url: "{{ route('fetchClaimDetails') }}",
        data: { oem_id: oem_id, seg_id: seg_id, _token: '{{ csrf_token() }}' },
        dataType: "json",
        success: function (response) {
            $('#claimTableBody').empty(); // Clear previous data

            let totalCount = 0;
            let totalAmount = 0;

            if (response.success && response.data.length > 0) {
                $.each(response.data, function (index, item) {
                    let row = '<tr>';
                    row += '<td>' + item.oem_name + '</td>';
                    row += '<td>' + item.segment_name + '</td>';
                    row += '<td class="text-end">' + item.claim_count + '</td>';
                    row += '<td class="text-end">' + item.incentive_amount + '</td>';
                    row += '<td><button class="btn btn-info" onclick="viewDetails(' + item.oem_id + ')">View</button></td>';
                    row += '</tr>';

                    $('#claimTableBody').append(row);

                    totalCount += parseFloat(item.claim_count);
                    totalAmount += parseFloat(item.incentive_amount);
                });

                // Append the total row AFTER the loop
                let totalRow = '<tr>';
                totalRow += '<td colspan="2" class="text-end"><strong>Total:</strong></td>';
                totalRow += '<td class="text-end"><strong>' + totalCount + '</strong></td>';
                totalRow += '<td class="text-end"><strong>' + totalAmount.toFixed(2) + '</strong></td>';
                totalRow += '<td></td>';
                totalRow += '</tr>';

                $('#claimTableBody').append(totalRow);
            } else {
                $('#claimTableBody').append('<tr><td colspan="5" class="text-center">No records found.</td></tr>');
            }
        },
        error: function () {
            $('#claimTableBody').html('<tr><td colspan="5" class="text-center text-danger">Error fetching data. Please try again.</td></tr>');
        }
    });
});

// function modalshow() {
//         $('#claimModal').modal('show');

//         $.ajax({
//                 type: "post",
//                 url: "{{ route('fetchClaimDetails') }}",
//                 data: {_token: '{{ csrf_token() }}' },
//                 dataType: "json",
//                 success: function (response) {
//                     // console.log();
//                     $('#claimTableBody').empty();
//                     // Check if the response is successful and contains data
//                     if (response.success && response.data.length > 0) {
//                         // Loop through the data array and create a table row for each entry
//                         $.each(response.data, function(index, item) {
//                             var row = '<tr>';
//                             row += '<td>' + item.oem_name + '</td>';
//                             row += '<td>' + item.segment_name + '</td>';
//                             row += '<td class="text-end">' + item.claim_count + '</td>';
//                             row += '<td class="text-end">' + item.incentive_amount + '</td>';
//                             row += '<td><button class="btn btn-info" onclick="viewDetails(' + item.oem_id + ')">View</button></td>';
//                             row += '</tr>';

//                             // Append the row to the table body
//                             $('#claimTableBody').append(row);
//                         });
//                     } else {
//                         // If no data found, show a message
//                         $('#claimTableBody').append('<tr><td colspan="5" class="text-center">No records found.</td></tr>');
//                     }
//                 }
//         });
//     }

function modalshow() {
    $('#claimModal').modal('show');

    $('.loader').show();
    $('#claimTableBody').empty();

    $.ajax({
        type: "post",
        url: "{{ route('fetchClaimDetails') }}",
        data: {_token: '{{ csrf_token() }}' },
        dataType: "json",
        success: function (response) {
            $('#claimTableBody').empty();

            // Initialize total count and total amount variables
            var totalCount = 0;
            var totalAmount = 0;

            // Check if the response is successful and contains data
            if (response.success && response.data.length > 0) {
                // Loop through the data array and create a table row for each entry
                $.each(response.data, function(index, item) {
                    var row = '<tr>';
                    row += '<td>' + item.oem_name + '</td>';
                    row += '<td>' + item.segment_name + '</td>';
                    row += '<td class="text-end">' + item.claim_count + '</td>';
                    row += '<td class="text-end">' + item.incentive_amount + '</td>';
                    row += '<td><button class="btn btn-info" onclick="viewDetails(' + item.oem_id + ', ' + item.segment_id + ')">View</button></td>';
                    row += '</tr>';

                    // Append the row to the table body
                    $('#claimTableBody').append(row);

                    // Add the claim count and incentive amount to the totals
                    totalCount += parseFloat(item.claim_count);
                    totalAmount += parseFloat(item.incentive_amount);
                });

                // Append the total count and total amount in the same row
                var totalRow = '<tr>';
                totalRow += '<td colspan="2"></td>';  // Empty cell for spacing
                totalRow += '<td class="text-end"><strong>' + totalCount + '</strong></td>';  // Total Count
                totalRow += '<td class="text-end"><strong>' + totalAmount.toFixed(2) + '</strong></td>';  // Total Amount
                totalRow += '<td></td>';  // Empty cell
                totalRow += '</tr>';

                // Append the total row to the table body
                $('#claimTableBody').append(totalRow);
                $('.loader').hide();
            } else {
                // If no data found, show a message
                $('#claimTableBody').append('<tr><td colspan="5" class="text-center">No records found.</td></tr>');
            }
        }
    });
}


function viewDetails(oemId, segment_id) {
    // Show the modal
    $('#claimModalOem').modal('show');
    $('#claimModal').modal('hide');

    $('.loader').show();
    $('#VinTableBody').empty();

    // Get the selected oem_id from the dropdown
    var selectedOemId = $('#oem_id').val();

    $.ajax({
        url: '/fetchClaimVin/' + oemId + "/" + segment_id,
        type: "GET",
        data: {
            _token: '{{ csrf_token() }}',
            oem_id: selectedOemId  // Pass the selected oem_id to the server
        },
        dataType: "json",
        success: function (response) {
            $('#VinTableBody').empty();
            $('#oem_id').empty();  // Empty the existing options in the dropdown

            // Add a default option
            $('#oem_id').append('<option value="all">All</option>');

            // Initialize total count and total amount variables
            var totalCount = 0;
            var totalAmount = 0;

            // Check if the response is successful and contains data
            if (response.success && response.data.length > 0) {
                $('#oemNameDisplay').text(response.oem_id);  // Display the OEM name
                $('#segNameDisplay').text(response.segment_id);
                // Loop through the data array and create a table row for each entry
                $.each(response.data, function(index, item) {
                    console.log(response.data);
                    var row = '<tr>';
                    row += '<td>' + item.claimnumberformat + '</td>';
                    row += '<td>' + item.segment_name + '</td>';
                    row += '<td class="text-end">' + item.vin_count + '</td>';
                    row += '<td class="text-end">' + item.incentive_amount + '</td>';
                    row += '<td><button class="btn btn-info" onclick="viewMore(' + item.oem_id + ', \'' + item.claimnumberformat + '\')">View</button></td>';
                    row += '</tr>';


                    // Append the row to the table body
                    $('#VinTableBody').append(row);


                    // Add the claim count and incentive amount to the totals
                    totalCount += parseFloat(item.vin_count);
                    totalAmount += parseFloat(item.incentive_amount);
                });

                // Append the total count and total amount in the same row
                var totalRow = '<tr>';
                totalRow += '<td colspan="2"></td>';  // Empty cell for spacing
                totalRow += '<td class="text-end"><strong>' + totalCount + '</strong></td>';  // Total Count
                totalRow += '<td class="text-end"><strong>' + totalAmount.toFixed(2) + '</strong></td>';  // Total Amount
                totalRow += '<td></td>';  // Empty cell
                totalRow += '</tr>';

                // Append the total row to the table body
                $('#VinTableBody').append(totalRow);
                $('.loader').hide();
            } else {
                // If no data found, show a message
                $('#VinTableBody').append('<tr><td colspan="5" class="text-center">No records found.</td></tr>');
            }
        }
    });
}



function viewMore(oemId, claimnumberformat) {
    // Redirect to the 'viewDetails' route with oem_id as a parameter
    // let enc = encodeURI(claimnumberformat)
    // let encBase64 = atob(claimnumberformat);
    let formatedEnc = claimnumberformat.replaceAll('/', '-');
    // console.log(oemId, enc, atob(claimnumberformat));
    // return;

    window.location.href = "{{ route('viewDetails', [':oemId', ':claimnumberformat']) }}"
        .replace(':oemId', oemId)
        .replace(':claimnumberformat', formatedEnc);
}

$(document).ready(function(){
    $('#claimModal').modal({
        backdrop: 'static',
        keyboard: false
    });
});

$(document).ready(function () {
    $("#claimModal .close, #claimModal #close").click(function () {
        $("#claimModal").modal("hide");
    });
});

$(document).ready(function(){
    $('#claimModalOem').modal({
        backdrop: 'static',
        keyboard: false
    });
});

$(document).ready(function () {
    $("#claimModalOem .close, #claimModalOem  #close").click(function () {
        $("#claimModalOem").modal("hide");
    });
});

    </script>
@endpush
