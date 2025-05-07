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

/* Modal Style */
.modal, .modalPost {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    /* margin-left: 20%; */
    padding: 20px;
    border: 1px solid #888;
    width: 90%;
}


.close, .close_post {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}



.close:hover,
.close:focus,.close_post {
    color: black;
    text-decoration: none;
    cursor: pointer;
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
                        <div class="card">
                            <div class="body genealogy-body genealogy-scroll">
                                <div class="genealogy-tree" style="margin-left: -28px">
                                <ul>
                                    <li>
                                    <a href="javascript:void(0);" style="width: 30%;">
                                        <div class="member-view-box">
                                        <div class="member-header">
                                            <span>OEM Detail</span>
                                        </div>
                                        </div>
                                    </a>
                                    <ul class="active">
                                        <li>
                                            <a href="javascript:void(0);" style="width: 100%;">
                                                <div class="member-view-box">
                                                    <div class="member-header">
                                                        <span>Pre-Registration (Submitted-{{$oemCount->submitted}})</span>
                                                    </div>
                                                    <div class="member-image">
                                                        <table class="table table-bordered custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="status-cell" data-status="Pending">Pending</th>
                                                                    <th class="status-cell" data-status="Rejected">Rejected</th>
                                                                    <th class="status-cell" data-status="Approved">Approved for <br> Post Registration</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-end status-cell" style="font-weight: bold;" data-status="Pending">{{$oemCount->pending}}</td>
                                                                    <td class="text-end status-cell" style="font-weight: bold;" data-status="Rejected">{{$oemCount->rejected}}</td>
                                                                    <td class="text-end status-cell" style="font-weight: bold;" data-status="Approved">{{$oemCount->approved}}</td>
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
                                        <a href="javascript:void(0);"style="width: 100%; " >
                                            <div class="member-view-box">
                                            <div class="member-header">
                                                <span>Post Registration (Submitted-{{$oemCount->approved}})</span>
                                            </div>
                                            <div class="member-image">
                                                <table class="table table-bordered custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Not Submitted <br> By OEM</th>
                                                            <th>Pending at DS</th>
                                                            <th>Recommended <br> By DS</th>
                                                            <th>Rejected <br> By DS</th>
                                                            <th>Pending <br> at AS</th>
                                                            <th>Approved <br> By AS</th>
                                                            <th>Rejected <br> By AS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-end status-post" style="font-weight: bold;" data-post="not_submitted">{{ $oemPostCount->not_submitted ?? 0 }}</td>
                                                            <td class="text-end status-post" style="font-weight: bold;" data-post="post_pending">{{ $oemPostCount->pending_at_ds ?? 0 }}</td>
                                                            <td class="text-end status-post" style="font-weight: bold;" data-post="recommended_ds">{{ $oemPostCount->recommended_by_ds ?? 0 }}</td>
                                                            <td class="text-end status-post" style="font-weight: bold;" data-post="rejected_ds">{{ $oemPostCount->rejected_by_ds ?? 0 }}</td>
                                                            <td class="text-end status-post" style="font-weight: bold;" data-post="pending_as">{{ $oemPostCount->pending_at_as ?? 0 }}</td>
                                                            <td class="text-end status-post" style="font-weight: bold;" data-post="approved_as">{{ $oemPostCount->approved_by_as ?? 0 }}</td>
                                                            <td class="text-end status-post" style="font-weight: bold;" data-post="rejected_as">{{ $oemPostCount->rejected_by_as ?? 0 }}</td>
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
                </div>
        </div>
    </div>
        <!-- Container-fluid Ends-->


        <div id="statusModal" class="modal modal-lg" style="display: none; z-index:999 ;">
            <div class="modal-content">
                <span class="close text-right" style="float: right;">&times;</span>
                <h2 id="statusText" style="text-align: center;">Status Details</h2>
                <br>
                <div id="oemChartDetails"></div>
            </div>
        </div>


        <div id="postModal" class="modalPost modal-lg" style="display: none;z-index:999 ;">
            <div class="modal-content">
                <span class="close_post text-right" style="float: right;">&times;</span>
                <h2 id="status-post" style="text-align: center;">Status Details</h2>
                <br>
                <div id="oemPostChartDetails"></div>
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
    // else children.show("fast").addClass("active");
    e.stopPropagation();
  });
});

const oemChartData = @json($oemChart);
const statusMapping = {
    "Pending": "P",
    "Approved": "A",
    "Rejected": "R"
};

const statusCells = document.querySelectorAll('.status-cell');
const modal = document.getElementById('statusModal');
const closeModal = document.querySelector('.close');
const statusText = document.getElementById('statusText');
const oemChartDetails = document.getElementById('oemChartDetails');

statusCells.forEach(cell => {
    cell.addEventListener('click', function() {
        const selectedStatus = cell.getAttribute('data-status');
        const statusValue = statusMapping[selectedStatus];
        const filteredOemChart = oemChartData.filter(item => item.status === statusValue);

        if (filteredOemChart.length > 0) {
            statusText.textContent = `Details for status: ${selectedStatus}`;
            oemChartDetails.innerHTML = '';

            let tableHTML = `
            <div class="table-responsive">
                <table id="pendingTable" class="pendingTable display nowrap" style="width: 100%; border: 1px solid #ddd; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">S.No</th>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">Name</th>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">Email</th>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">Authorized Person's Name</th>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">Authorized Person's Designation</th>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            let serialNumber = 1;

            filteredOemChart.forEach(item => {
                const viewRoute = `/oemRegistration/${item.id}`;
                console.log(viewRoute);

                tableHTML += `
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;">${serialNumber}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${item.name}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${item.email}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${item.auth_name}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${item.auth_designation}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">
                            <a href="${viewRoute}" class="btn btn-primary">View</a>
                        </td>
                    </tr>
                `;
                serialNumber++;
            });

            tableHTML += `</tbody></table></div><hr>`;

            oemChartDetails.innerHTML += tableHTML;

            modal.style.display = 'block';


            setTimeout(() => {
                if ($.fn.DataTable.isDataTable('.pendingTable')) {
                    $(".pendingTable").DataTable().destroy();
                }

                $(".pendingTable").DataTable({
                    dom: "Bfrtip",
                    buttons: ["csvHtml5"],
                    paging: true,
                    pageLength: 50,
                    order: [],
                });
            }, 100);
        } else {
            statusText.textContent = `No data found for status: ${selectedStatus}`;
            oemChartDetails.innerHTML = '';
            modal.style.display = 'block';
        }
    });
});


closeModal.addEventListener('click', function() {
    modal.style.display = 'none';
});


window.addEventListener('click', function(event) {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

$(document).ready(function () {

    const oemPostChartData = @json($oemPostChart);

    console.log("oemPostChartData:", oemPostChartData);

    const statusPostMapping = {
        "Not Submitted": "not_submitted",
        "Pending at DS": "post_pending",
        "Recommended by DS": "recommended_ds",
        "Rejected by DS": "rejected_ds",
        "Pending at AS": "pending_as",
        "Approved by AS": "approved_as",
        "Rejected by AS": "rejected_as"
    };

    const modalPost = $("#postModal");
    const statusTextPost = $("#status-post");
    const oemPostChartDetails = $("#oemPostChartDetails");

    $(".status-post").on("click", function () {
        console.log("Clicked status:", $(this).data("post"));

        const selectedPostStatus = $(this).data("post");
        const statusPostValue = Object.keys(statusPostMapping).find(
            key => statusPostMapping[key] === selectedPostStatus
        );

        if (!statusPostValue) {
            console.error("Invalid status clicked!");
            return;
        }

        const filteredOemPostChart = oemPostChartData.filter(item => item.post_reg_status_desc === statusPostValue);

        if (filteredOemPostChart.length > 0) {
            statusTextPost.text(`Details for status: ${statusPostValue}`);
            oemPostChartDetails.html("");

            const showActionColumn = !["post_pending", "not_submitted"].includes(selectedPostStatus);

            let tableHTML = `
             <div class="table-responsive">
                <table id="pendingTable" class="pendingTable display nowrap" style="width: 100%; border: 1px solid #ddd; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">S.No</th>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">Name</th>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">Email</th>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">Authorized Person's <br> Name</th>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">Authorized Person's <br> Designation</th>
                            <th style="text-align: left; padding: 8px; background-color: #f4f4f4;">Mobile</th>
                            ${showActionColumn ? '<th style="text-align: left; padding: 8px; background-color: #f4f4f4;">Action</th>' : ''}
                        </tr>
                    </thead>
                    <tbody>
            `;

            filteredOemPostChart.forEach((item, index) => {
                const viewRoute = `/oemRegistration/${item.id}/edit`;

                const actionColumn = showActionColumn
                    ? `<td style="padding: 8px; border: 1px solid #ddd;">
                            <a href="${viewRoute}" class="btn btn-primary">View</a>
                       </td>`
                    : '';

                tableHTML += `
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;">${index + 1}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${item.name}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${item.email}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${item.auth_name}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${item.auth_designation}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${item.mobile}</td>
                        ${actionColumn}
                    </tr>
                `;
            });

            tableHTML += `</tbody></table></div><hr>`;

            oemPostChartDetails.append(tableHTML);
            modalPost.show();

            setTimeout(() => {
                if ($.fn.DataTable.isDataTable('.pendingTable')) {
                    $(".pendingTable").DataTable().destroy();
                }

                $(".pendingTable").DataTable({
                    dom: "Bfrtip",
                    buttons: ["csvHtml5"],
                    paging: true,
                    pageLength: 50,
                    order: [],
                });
            }, 100);
        } else {
            statusTextPost.text(`No data found for status: ${statusPostValue}`);
            oemPostChartDetails.html("");
            modalPost.show();
        }
    });

    $(".close_post").on("click", function () {
        modalPost.hide();
    });

    $(window).on("click", function (event) {
        if ($(event.target).is(modalPost)) {
            modalPost.hide();
        }
    });
});

    </script>
@endpush

