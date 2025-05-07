<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- 
    <link rel="icon" href="admin/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="admin/images/favicon.png" type="image/x-icon">
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&amp;display=swap"
      rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="admin/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="admin/css/vendors/icofont.css">
    <link rel="stylesheet" type="text/css" href="admin/css/vendors/themify.css">
    <link rel="stylesheet" type="text/css" href="admin/css/vendors/flag-icon.css">
    <link rel="stylesheet" type="text/css" href="admin/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="admin/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="admin/css/style.css">
    <link id="color" rel="stylesheet" href="admin/css/color-1.css" media="screen">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="admin/css/responsive.css">
    --}}
    <link rel="icon" href="{{ asset('admin/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" type="image/x-icon">
    <title>Register</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&amp;display=swap"
      rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('admin/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/responsive.css') }}">
    <style>
      .login-dark {
      background-image: radial-gradient(at top left, #05C09B 0%, #3BE78E 50%, #3BE78E 100%);
      }
      .border-top {
      border-color: var(--border-color) !important;
      }
    </style>
  </head>
  <body>
    <!-- login page start-->
    <div class="container-fluid p-0">
      <div class="row m-0">
        <div class="col-12 p-0">
          <div class="login-card login-dark">
            <div>
              <div class="card w-100">
                <div class="card-header">
                  <img class="" src="{{ asset('admin/images/logo/logo.png') }}" alt="logo-dark">
                  <img class="" style="float: right;"
                    src="{{ asset('admin/images/logo/logo_dark.png') }}" alt="logo-dark">
                </div>
                <div class="card-body">
                  <div class="horizontal-wizard-wrapper">
                    <div class="row g-3">
                      <div class="col-12 main-horizontal-header">
                        <div class="nav nav-pills horizontal-options" id="horizontal-wizard-tab"
                          role="tablist" aria-orientation="vertical">
                          <a class="nav-link active"
                            id="registration-form-tab" data-bs-toggle="pill"
                            href="#registration-form" role="tab"
                            aria-controls="registration-form" aria-selected="true">
                            <div class="horizontal-wizard">
                              <div class="stroke-icon-wizard"><i class="fa fa-user"> </i>
                              </div>
                              <div class="horizontal-wizard-content">
                                <h6>Registration Form</h6>
                              </div>
                            </div>
                          </a>
                          <a class="nav-link disabled" id="manufacturing-information-tab"
                            data-bs-toggle="pill" href="#manufacturing-information"
                            role="tab" aria-controls="manufacturing-information"
                            aria-selected="false" tabindex="-1">
                            <div class="horizontal-wizard">
                              <div class="stroke-icon-wizard"> <i class="fa fa-chain-broken">
                                </i>
                              </div>
                              <div class="horizontal-wizard-content">
                                <h6>Manufacturing information</h6>
                              </div>
                            </div>
                          </a>
                          <a class="nav-link disabled" id="registered-office-wizard-tab"
                            data-bs-toggle="pill" href="#registered-office-wizard"
                            role="tab" aria-controls="registered-office-wizard"
                            aria-selected="false" tabindex="-1">
                            <div class="horizontal-wizard">
                              <div class="stroke-icon-wizard"><i class="fa fa-group"></i>
                              </div>
                              <div class="horizontal-wizard-content">
                                <h6>Registered Office </h6>
                              </div>
                            </div>
                          </a>
                          <a class="nav-link disabled" id="manufacturing-plants-wizard-tab"
                            data-bs-toggle="pill" href="#manufacturing-plants-wizard"
                            role="tab" aria-controls="manufacturing-plants-wizard"
                            aria-selected="false" tabindex="-1">
                            <div class="horizontal-wizard">
                              <div class="stroke-icon-wizard"><i class="fa fa-group"></i>
                              </div>
                              <div class="horizontal-wizard-content">
                                <h6>Manufacturing xEV Plants </h6>
                              </div>
                            </div>
                          </a>
                          <a class="nav-link disabled" id="authorized-person-details-wizard-tab"
                            data-bs-toggle="pill" href="#authorized-person-details-wizard"
                            role="tab" aria-controls="authorized-person-details-wizard"
                            aria-selected="false" tabindex="-1">
                            <div class="horizontal-wizard">
                              <div class="stroke-icon-wizard"><i class="fa fa-group"></i>
                              </div>
                              <div class="horizontal-wizard-content">
                                <h6>Authorized Person Details </h6>
                              </div>
                            </div>
                          </a>
                          <a class="nav-link disabled" id="bank-details-wizard-tab"
                            data-bs-toggle="pill" href="#bank-details-wizard" role="tab"
                            aria-controls="bank-details-wizard" aria-selected="false"
                            tabindex="-1">
                            <div class="horizontal-wizard">
                              <div class="stroke-icon-wizard"><i class="fa fa-group"></i>
                              </div>
                              <div class="horizontal-wizard-content">
                                <h6>Bank Details</h6>
                              </div>
                            </div>
                          </a>
                          <a class="nav-link disabled" id="other-details-wizard-tab"
                            data-bs-toggle="pill" href="#other-details-wizard" role="tab"
                            aria-controls="other-details-wizard" aria-selected="false"
                            tabindex="-1">
                            <div class="horizontal-wizard">
                              <div class="stroke-icon-wizard"><i class="fa fa-group"></i>
                              </div>
                              <div class="horizontal-wizard-content">
                                <h6>Other Details</h6>
                              </div>
                            </div>
                          </a>
                        </div>
                      </div>
                      <form action="{{ route('oem.store') }}" id="PostRegForm" role="form"
                        method="post" class='form-horizontal' files=true
                        enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        <div class="col-12">
                          <div class="tab-content dark-field" id="horizontal-wizard-tabContent">
                            <div class="tab-pane fade show active" id="registration-form"
                              role="tabpanel" aria-labelledby="wizard-info-tab">
                              <div class="row g-3">
                                <div class="col-xl-4 col-sm-6">
                                  <label class="form-label">Name of OEM<span
                                    class="txt-danger">*</span></label>
                                  <input class="form-control" type="text"
                                    placeholder="Enter name" name="name_of_oem">
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Type of
                                    OEM:<span class="text-danger">*</span></label>
                                    <select class="form-control" name="type_of_oem">
                                      <option selected disabled value="">Select
                                      </option>
                                      <option value="Proprietorship">Proprietorship
                                      </option>
                                      <option value="Partnership/LLP">Partnership/LLP
                                      </option>
                                      <option value="Company">Company</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                  <label class="form-label">Username<span
                                    class="txt-danger">*</span></label>
                                  <input class="form-control" type="text"
                                    placeholder="Enter username" name="username">
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                  <label class="form-label">Password<span
                                    class="txt-danger">*</span></label>
                                  <input class="form-control" type="password"
                                    placeholder="Enter password" name="password">
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                  <label class="form-label">Confirm Password<span
                                    class="txt-danger">*</span></label>
                                  <input class="form-control" type="password"
                                    placeholder="Confirm password"
                                    name="password_confirmation">
                                </div>
                                <div class="col-12">
                                  <p>Note: The password should be between 8 to 15
                                    Characters. The password must have at least one
                                    alphabet, one digit, and one special character
                                    (@#$&).
                                  </p>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="manufacturing-information"
                              role="tabpanel" aria-labelledby="bank-wizard-tab">
                              <div class="row g-3">
                                <div class="col-6">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Company
                                    Registration No.<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Company Registration No"
                                      name="company_registration_no">
                                    <span>For Partnership and Proprietorship please
                                    enter 00000 </span>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Company
                                    Registration Certificate No.<span
                                      class="text-danger">*</span></label>
                                    {{-- <br><a href="#" class="btn btn-success"><i
                                      class="fa fa-download"></i>
                                    Download</a><br> --}}
                                    <input class="form-control" type="file"
                                      name="company_registration_file">
                                    <span>(ROC for Company, MOA & Rules/Deed for
                                    Partnership/Proprietorship)</span>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">GSTIN No.<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="GSTIN No." name="gstin_no">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">GSTIN
                                    Registration File<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="file"
                                      name="gstin_registration_file">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">OEM PAN<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="OEM PAN" name="oem_pan">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">OEM PAN
                                    File<span class="text-danger">*</span></label>
                                    <input class="form-control" type="file"
                                      name="oem_pan_file">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <p>Details of R&D Facilities like total annual
                                    expenditure on R&D, No of employee, total patent if
                                    any, whether R&D facility recognized by any Govt
                                    agency etc. on Company Letter Head duly signed by
                                    authorized person.
                                  </p>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">R&D Facilities
                                    File <span class="text-danger">*</span></label>
                                    <input class="form-control" type="file"
                                      name="r_and_d_facilities_file">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Annual Turnover
                                    (INR in cr)<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Annual Turnover (INR in cr)"
                                      name="annual_turnover">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="registered-office-wizard"
                              role="tabpanel"
                              aria-labelledby="registered-office-wizard-tab">
                              <div class="row g-3">
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Address<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Address"
                                      name="registered_office_address">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Landmark<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Landmark"
                                      name="registered_office_landmark">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Pincode<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="number"
                                      placeholder="Pincode"
                                      onkeyup="GetCityByPinCode('REG', this.value, 0)"
                                      name="registered_office_pincode">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0 ">State<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control readonly" readonly
                                      type="text" placeholder="State"
                                      id="REGAddState0"
                                      name="registered_office_state">
                                    {{-- 
                                    <select class="form-control"
                                      name="registered_office_state">
                                      <option selected="selected" value="0">
                                        Please select
                                      </option>
                                      <option value="1">Delhi</option>
                                    </select>
                                    --}}
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0 ">District<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control readonly" readonly
                                      type="text" placeholder="District"
                                      id="REGAddDistrict0"
                                      name="registered_office_district">
                                    {{-- 
                                    <select class="form-control"
                                      name="registered_office_district">
                                      <option selected="selected" value="0">
                                        Select
                                      </option>
                                      <option value="1">Delhi</option>
                                    </select>
                                    --}}
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0 ">City<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="City"
                                      name="registered_office_city">
                                    {{-- 
                                    <select class="form-control"
                                      name="registered_office_city">
                                      <option selected="selected" value="0">
                                        Select
                                      </option>
                                      <option value="1">Delhi</option>
                                    </select>
                                    --}}
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Landline
                                    No.<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Landline No."
                                      name="registered_office_landline_no">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Fax No<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Fax No"
                                      name="registered_office_fax_no">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">E-Mail<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="E-Mail"
                                      name="registered_office_email">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="manufacturing-plants-wizard"
                              role="tabpanel"
                              aria-labelledby="manufacturing-plants-wizard-tab">
                              <div class="row g-3">
                                <div class="table-responsive">
                                  <table class="table table-bordered" id="plantTable">
                                    <thead>
                                      <tr>
                                        <th scope="col">S.No.</th>
                                        <th scope="col">Plant Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Pincode</th>
                                        <th scope="col">State</th>
                                        <th scope="col">District</th>
                                        <th scope="col">City</th>
                                        <th scope="col">Email Id</th>
                                        <th scope="col">Landline No.</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <th scope="row">1</th>
                                        <td><input class="form-control"
                                          type="text"
                                          placeholder="Plant Name"
                                          name="evplant[0][plant_name]"></td>
                                        <td><input class="form-control"
                                          type="text"
                                          placeholder="Address"
                                          name="evplant[0][plant_address]">
                                        </td>
                                        <td><input class="form-control"
                                          type="number"
                                          onkeyup="GetCityByPinCode('PLANT', this.value, 0)"
                                          placeholder="Pincode"
                                          name="evplant[0][plant_pincode]">
                                        </td>
                                        <td>
                                          <input type="text"
                                            class="form-control readonly"placeholder="State"
                                            readonly
                                            name="evplant[0][plant_state]"
                                            id="PLANTAddState0">
                                        </td>
                                        <td>
                                          <input type="text"
                                            class="form-control readonly"
                                            placeholder="District" readonly
                                            name="evplant[0][plant_district]"
                                            id="PLANTAddDistrict0">
                                        </td>
                                        <td>
                                          <input type="text"
                                            class="form-control"
                                            placeholder="City"
                                            name="evplant[0][plant_city]">
                                        </td>
                                        <td><input class="form-control"
                                          type="email"
                                          placeholder="Email Id"
                                          name="evplant[0][plant_email]">
                                        </td>
                                        <td><input class="form-control"
                                          type="text"
                                          placeholder="Landline No."
                                          name="evplant[0][plant_landline]">
                                        </td>
                                        <td><button id="addRowBtn" type="button"
                                          class="btn btn-sm btn-success">Add</button>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="authorized-person-details-wizard"
                              role="tabpanel"
                              aria-labelledby="authorized-person-details-wizard-tab">
                              <div class="row g-3">
                                <div class="col-xl-4 col-sm-6">
                                  <label class="form-label">Name<span
                                    class="txt-danger">*</span></label>
                                  <input class="form-control" type="text"
                                    placeholder="Enter first name"
                                    name="authorized_person_name">
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Address<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Address"
                                      name="authorized_person_address">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Landmark<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Landmark"
                                      name="authorized_person_landmark">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Pincode<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="number"
                                      placeholder="Pincode"
                                      onkeyup="GetCityByPinCode('auth', this.value, 0)"
                                      name="authorized_person_pincode">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">State<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="State"
                                      name="authorized_person_state"
                                      id="authAddState0">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">District<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="District"
                                      name="authorized_person_district"
                                      id="authAddDistrict0">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">City<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="City"
                                      name="authorized_person_city">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Mobile No.<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Mobile No."
                                      name="authorized_person_mobile">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Fax No<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Fax No"
                                      name="authorized_person_fax">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">E-Mail<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="E-Mail"
                                      name="authorized_person_email">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="bank-details-wizard"
                              role="tabpanel" aria-labelledby="bank-details-wizard-tab">
                              <div class="row g-3">
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">IFSC Code<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="IFSC Code" name="ifsc_code">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Account Holder
                                    Name<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Account Holder Name"
                                      name="account_holder_name">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Name of
                                    Bank<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Name of Bank" name="bank_name">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Name of
                                    Branch<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Name of Branch"
                                      name="branch_name">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Address<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Address" name="bank_address">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Pincode.<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="number"
                                      placeholder="Branch Pincode."
                                      onkeyup="GetCityByPinCode('bank', this.value, 0)"
                                      name="branch_pincode">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">State.<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control readonly" readonly
                                      type="text" id="bankAddState0"
                                      placeholder="Branch State"
                                      name="branch_state">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">District.<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control readonly" readonly
                                      type="text" id="bankAddDistrict0"
                                      placeholder="Branch District"
                                      name="branch_district">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Branch City<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Branch City" name="branch_city">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Account No.<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="Account No."
                                      name="account_number">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">MICR Code<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="MICR Code" name="micr_code">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0"> Account
                                    Type<span class="text-danger">*</span></label>
                                    <select class="form-control" name="account_type">
                                      <option selected="selected" value="0">
                                        Please select
                                      </option>
                                      <option value="1">Saving</option>
                                      <option value="2">Current</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="other-details-wizard"
                              role="tabpanel" aria-labelledby="other-details-wizard-tab">
                              <div class="row g-3">
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Dealer Mode<span
                                      class="text-danger">*</span></label>
                                    <select class="form-control" name="dealer_mode">
                                      <option selected="selected" value="0">
                                        Please select
                                      </option>
                                      <option value="1">Online</option>
                                      <option value="2">Current</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Dealer
                                    Numbers<span
                                      class="text-danger">*</span></label>
                                    <select class="form-control"
                                      name="dealer_numbers">
                                      <option selected="selected" value="0">
                                        Please select
                                      </option>
                                      <option value="1">Less than 25</option>
                                      <option value="2">More than and equal to
                                        25
                                      </option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">No. of
                                    Dealer<span
                                      class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                      placeholder="No. of Dealer"
                                      name="no_of_dealer">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">Dealer List
                                    File<span class="text-danger">*</span></label>
                                    <input class="form-control" type="file"
                                      name="dealer_list_file">
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <label class="col-form-label pt-0">State of dealer
                                    presence<span
                                      class="text-danger">*</span></label>
                                    <select class="form-control" multiple
                                      name="state_of_dealer_presence[]">
                                      <option selected disabled>Please select</option>
                                      @foreach ($states as $name)
                                      <option value="{{ $name }}">
                                        {{ $name }}
                                      </option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div class="form-check">
                                    <input class="form-check-input"
                                      id="flexCheckDefault" type="checkbox"
                                      value="" name="declaration">
                                    <label class="form-check-label"
                                      for="flexCheckDefault">Declaration :* As per
                                    Guidelines: - I/ We declare that information
                                    provided here – in – above are correct and true
                                    to the best of our knowledge and also I/ we
                                    undertake to abide by all terms and conditions
                                    of the scheme as well as the
                                    instructions/guidelines/decisions to be
                                    issued/taken by DHI/NAB from time to time with
                                    respect to the scheme.</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 mt-3">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/validation.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('admin/js/icons/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ asset('admin/js/config.js') }}"></script>
    <script src="{{ asset('admin/js/script.js') }}"></script>
    <script src="{{ asset('admin/js/script.js') }}"></script>
    <script>
      $(document).ready(function() {
          var rowCounter = 1;
      
          // Function to add a new row
          function addRow() {
              rowCounter++;
      
              var newRow = `<tr>
                          <th scope="row">${rowCounter}</th>
                          <td><input class="form-control" type="text" placeholder="Plant Name" name="evplant[${rowCounter}][plant_name]"></td>
                          <td><input class="form-control" type="text" placeholder="Address" name="evplant[${rowCounter}][plant_address]"></td>
                          <td><input class="form-control" type="number" placeholder="Pincode" name="evplant[${rowCounter}][plant_pincode]"  onkeyup="GetCityByPinCode('PLANT', this.value, ${rowCounter})"></td>
                          <td><input class="form-control readonly" readonly placeholder="State" type="text"name="evplant[${rowCounter}][plant_state]" id="PLANTAddState${rowCounter}"></td>
                          <td><input class="form-control readonly" readonly placeholder="District"type="text"name="evplant[${rowCounter}][plant_district]" id="PLANTAddDistrict${rowCounter}"></td>
                          <td><input class="form-control" type="text" placeholder="City" name="evplant[${rowCounter}][plant_city]"></td>
                          <td><input class="form-control" type="email" placeholder="Email Id" name="evplant[${rowCounter}][plant_email]"></td>
                          <td><input class="form-control" type="text" placeholder="Landline No." name="evplant[${rowCounter}][plant_landline]"></td>
                          <td><button type="button" class="btn btn-sm btn-danger removeRowBtn">Remove</button></td>
                      </tr>`;
      
              // Append the new row to the table body
              $('#plantTable tbody').append(newRow);
          }
      
          // Function to remove a row
          function removeRow() {
              $(this).closest('tr').remove();
      
              // Update the row numbers
              $('#plantTable tbody tr').each(function(index) {
                  $(this).find('th').text(index + 1);
              });
          }
      
          // Event listener for the Add button
          $('#addRowBtn').click(function() {
              addRow();
          });
      
          // Event listener for the Remove button
          $(document).on('click', '.removeRowBtn', removeRow);
      });

      $(document).ready(function() {
    // Function to check if all fields in the current tab are filled
    function checkFieldsFilled(tab) {
        var inputs = tab.find('input[type="text"], input[type="password"], input[type="file"], select'); // Find all input and select elements in the active tab

        // Check if any field is empty
        var allFilled = true;
        inputs.each(function() {
            if ($(this).val() === '' || $(this).val() === null) {
                allFilled = false;
                return false; // Break the loop if any field is empty
            }
        });

        return allFilled;
    }

    // Function to switch to the next tab
    function switchToNextTab() {
        var activeTab = $('.tab-pane.active');
        var nextTab = activeTab.next('.tab-pane');

        if (nextTab.length > 0) {
            // Change nav-link automatically
            var currentNavLink = activeTab.attr('id');
            var nextNavLink = nextTab.attr('id');
            $('a.nav-link[href="#' + currentNavLink + '"]').removeClass('active');
            $('a.nav-link[href="#' + nextNavLink + '"]').addClass('active');

            activeTab.removeClass('show active');
            nextTab.addClass('show active');
        }
    }

    // Disable default click behavior for nav links
    $('.nav-link').on('click', function(event) {
        event.preventDefault();
    });

    // Listen for changes in input fields and select elements
    $('.tab-pane input[type="text"], .tab-pane input[type="password"], .tab-pane input[type="file"], .tab-pane select').on('change', function() {
        var currentTab = $(this).closest('.tab-pane');

        if (checkFieldsFilled(currentTab)) {
            switchToNextTab();
        }
    });

    // Function to switch to the next tab when all fields are filled
    function autoSwitchTabs() {
        var tabs = $('.tab-pane');
        tabs.each(function(index) {
            if (checkFieldsFilled($(this))) {
                $(this).removeClass('show active');
                tabs.eq(index + 1).addClass('show active');
                // Change nav-link automatically
                var currentNavLink = $(this).attr('id');
                var nextNavLink = tabs.eq(index + 1).attr('id');
                $('a.nav-link[href="#' + currentNavLink + '"]').removeClass('active');
                $('a.nav-link[href="#' + nextNavLink + '"]').addClass('active');
            }
        });
    }

    // Call autoSwitchTabs function initially
    autoSwitchTabs();
});


    </script>
    
    @include('partials.js.pincode')
    {!! JsValidator::formRequest('App\Http\Requests\PostRegistrationRequest', '#PostRegForm') !!}
  </body>
</html>
