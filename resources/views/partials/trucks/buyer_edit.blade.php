<script>
        $("#update_incentive").on("click", function() {
            let vin = document.getElementById("vin_number").value;
            let row_id = {{ $bankDetail->id }};
            let oemid = document.getElementById("oem_id").value;
            let invoice_amt = document.getElementById("invoice_amt").value;
            $.ajax({
                url: "{{ route('buyerdetail.update.incentive') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    vin,
                    row_id,
                    oemid,
                    invoice_amt
                },
                success: function(result) {
                    if (result.status == 0) {
                        $('#addmi_inc_amt').val(result.data.invt_amt);
                        $('#tot_adm_inc_amt').val(result.data.invt_amt);
                        $('#tot_inv_amt').val(result.data.net_amt);
                        $('#amt_custmr').val(result.data.net_amt);
                        Swal.fire(
                            '',
                            'Incentive amount updated successfully!',
                            'success'
                        );
                        return;
                    }
                    Swal.fire(
                        '',
                        'Something went wrong!',
                        'error'
                    );
                    console.error(result.msg);

                },
                error: function(err) {
                    Swal.fire(
                        '',
                        'Something went wrong!',
                        'error'
                    );
                    console.error(err);
                }
            })
        });
        $('#fetch_rc_details').on("click", function() {
            var vin = document.getElementById("vin_number").value;
            // var oemid = document.getElementById("oem_id").value;

            let reqData = {
                _token: "{{ csrf_token() }}", // CSRF token for security
                id: "{{ $id }}", // The ID of the record
                vin
            }
            var token = $("input[name='_token']").val();
            // console.log(val,oemid,token);
            $.ajax({
                url: "{{ route('e-trucks.update-temp-reg') }}", // Laravel route
                method: "POST",
                data: reqData,

                success: function(response) {

                    // console.log(response);

                    if ($('#vhcl_regis_no').val()) {
                        $('#vhcl_regis_no').prop('readonly', true).addClass('readonly');
                    }

                    if ($('#vihcle_dt').val()) {
                        $('#vihcle_dt').prop('readonly', true).addClass('readonly');
                    }

                    if ($('#temp_reg').val()) {
                        $('#temp_reg').prop('readonly', true).addClass('readonly');
                    }

                    if (response.status == false) {

                        Swal.fire(
                            'Warning',
                            response.message,
                            'error'
                        );

                        // Enable the fields for editing if the status is false
                        // $('#vhcl_regis_no').prop('readonly', false).removeClass('readonly');
                        // $('#vihcle_dt').prop('readonly', false).removeClass('readonly').attr('type', 'date');
                        // $('#temp_reg').prop('readonly', false).removeClass('readonly');

                        // Apply readonly and class if values exist
                        if ($('#vhcl_regis_no').val()) {
                            $('#vhcl_regis_no').prop('readonly', true).addClass('readonly');
                        }

                        if ($('#vihcle_dt').val()) {
                            $('#vihcle_dt').prop('readonly', true).addClass('readonly');
                        }

                        if ($('#temp_reg').val()) {
                            $('#temp_reg').prop('readonly', true).addClass('readonly');
                        }

                        if (response.prcn == 'TEL' && response.prcndt == 'TEL') {
                            $('#vhcl_regis_no').prop('readonly', false).removeClass('readonly');
                            // $('#vihcle_dt').prop('readonly', false).removeClass('readonly');
                            let minDate = '2024-04-01';
                            let maxDate = new Date().toISOString().split('T')[
                                0]; // Gets today's date in YYYY-MM-DD format

                            // $('#vihcle_dt').attr('min', minDate).attr('max', maxDate);

                            $('#vihcle_dt').prop('readonly', false).removeClass('readonly').attr('type',
                                'date').attr('min', minDate).attr('max', maxDate);
                        }


                    } else if (response.status == true) {
                        Swal.fire(
                            '',
                            response.message,
                            'success'
                        );

                        // Set the values and keep the fields readonly
                        // $('#vhcl_regis_no').prop('readonly', true).addClass('readonly');
                        // $('#vihcle_dt').prop('readonly', false).removeClass('readonly').attr('type', 'text');
                        // $('#temp_reg').prop('readonly', true).addClass('readonly');

                        // Set the values from the response
                        $('#vhcl_regis_no').val(response.prcn);
                        $('#vihcle_dt').val(response.prcndt);
                        // $('#fetch_rc_details').hide();

                        //show e-voucher generation btn if vahan data fetched
                        $('#e_voucher_div').show();


                    } else {
                        Swal.fire(
                            'Warning',
                            response.message,
                            'error'
                        );


                        // Enable the fields for editing if the status is false
                        // $('#vhcl_regis_no').prop('readonly', false).removeClass('readonly');
                        // $('#vihcle_dt').prop('readonly', false).removeClass('readonly').attr('type', 'date');
                        // $('#temp_reg').prop('readonly', false).removeClass('readonly');



                        $('#vhcl_regis_no').val('');
                        $('#vihcle_dt').val('');
                        $('#temp_reg').val('');

                        // Apply readonly and class if values exist
                        if ($('#vhcl_regis_no').val()) {
                            $('#vhcl_regis_no').prop('readonly', true).addClass('readonly');
                        }

                        if ($('#vihcle_dt').val()) {
                            $('#vihcle_dt').prop('readonly', true).addClass('readonly');
                        }

                        if ($('#temp_reg').val()) {
                            $('#temp_reg').prop('readonly', true).addClass('readonly');
                        }

                    }
                }


            });
        });

        $(document).ready(function() {

            $('#vhcl_regis_no').prop('readonly', true).addClass('readonly');
            $('#vihcle_dt').prop('readonly', true).addClass('readonly');
            $('#temp_reg').prop('readonly', true).addClass('readonly');

            const customerTypeSelect = $('#cstm_typ'); // Ensure this ID matches your select element
            // Function to toggle visibility based on selected value
            function toggleCustomerInfo() {
                const customerInfo = $('.customer-info');
                var dateLabel = $('#dateLabel'); // Reference to the label for the date input


                if (customerTypeSelect.val() === '1') {
                    customerInfo.show();
                    $('.nonInv').hide();

                    // Function to toggle readonly state
                    function toggleReadonly(isReadonly) {
                        customerInfo.find('input, select').each(function() {
                            $(this).prop('readonly', isReadonly); // Set readonly for input
                            $(this).prop('disabled', isReadonly && $(this).is(
                                'select')); // Disable select if readonly
                            if (isReadonly) {
                                $(this).addClass('readonly'); // Add readonly class
                            } else {
                                $(this).removeClass('readonly'); // Remove readonly class
                            }
                        });
                        // Change the label text for the date input
                        if (isReadonly) {
                            dateLabel.text('Date of Birth'); // Change to Date of Birth
                        } else {
                            dateLabel.text('Date Of Incorporation'); // Change to Date Of Incorporation
                            // Always apply readonly logic to specific fields regardless of the readonly state
                            $("#OEMAddState0").prop('readonly', true).addClass('readonly');
                            $("#OEMAddDistrict0").prop('readonly', true).addClass('readonly');
                        }
                    }

                    // Initial check based on value when page loads
                    if (customerTypeSelect.val() === '1') {
                        // NullValues(customerIdContainer);
                        toggleReadonly(true); // Make fields readonly
                    } else {
                        toggleReadonly(false); // Enable fields
                    }
                } else {
                    customerInfo.show();
                    $('.nonInv').show();
                }
            }

            // Function to clear input values in a container
            function clearInputValues(container) {
                const inputs = container.find('input, textarea'); // Use jQuery to find inputs
                inputs.each(function() {
                    $(this).val(''); // Clear the value
                });
            }

            // Initial check on page load
            toggleCustomerInfo();

            // Add event listener to handle changes
            customerTypeSelect.change(toggleCustomerInfo);
        });

        $('#invoice_amt').on('keyup', function() {
            var val1 = parseFloat($('#invoice_amt').val()) || 0;
            var val2 = parseFloat($('#addmi_inc_amt').val()) || 0;

            // Check if val1 is smaller than val2
            if (val1 < val2) {
                $('#error_msg').text(
                    'Invoice Amount should be greater than Admissible Incentive Amount');
                $('#tot_inv_amt').val('');
                $('#amt_custmr').val('');
            } else {
                $('#error_msg').text(''); // Clear error message
                var result = val1 - val2;
                $('#tot_inv_amt').val(result);
                $('#amt_custmr').val(result);
            }
        });



        function citydata(value) {
            $('#OEMAddCity0').val('')
            GetCityByPinCode('OEM', value, 0)
        }



        function validateDates() {
            var manu_date = new Date($("#manufacturing_date").val());
            var invoiceDate = new Date($("#invoice_dt").val());
            var vehicleDate = new Date($("#vihcle_dt").val());
            var category = $('#sh_vehicle').val();

            if (invoiceDate < manu_date) {
                alert("Invoice date is less than manufacturing date");
            }
            if (invoiceDate > vehicleDate) {
                alert("Invoice date cannot be greater than vehicle registration date");
                $("#invoice_dt").val("");
                $("#vihcle_dt").val("");
            }
            // if (category == 'L5') {
            //         var selectedDate = $('#invoice_dt').val();
            //         var inputDate = new Date(selectedDate);
            //         var comparisonDate = new Date('2024-11-08');

            //         if (inputDate >= comparisonDate) {
            //             alert('Vehicle count limit exceded');
            //             $("#invoice_dt").val("");
            //         }

            //     }
        }
        $("#invoice_dt, #vihcle_dt").change(validateDates);



        $(document).ready(function() {
            $('#cstm_typ').on('change', function() {
                const customerInfo = $('.customer-info');
                var dateLabel = $('#dateLabel'); // Reference to the label for the date input
                var val = $(this).val();
                if ($(this).val() === '1') {
                    customerInfo.hide();
                    $('.nonInv').hide();
                    NullValues(customerInfo);
                    $("#cstmer_typ").empty();
                    $("#custmr_id_no").empty();
                    $("#custmr_file_copy_id").empty();
                    // toggleReadonly(true); // Make fields readonly
                } else {
                    customerInfo.show();
                    customerInfo.find('input, select').each(function() {
                        $(this).prop('readonly', false); // Remove readonly for input fields
                        $(this).prop('disabled', false); // Enable select fields
                        $(this).removeClass('readonly'); // Remove readonly class
                        dateLabel.text('Date Of Incorporation'); // Change to Date Of Incorporation
                        $("#OEMAddState0").prop('readonly', true).addClass('readonly');
                        $("#OEMAddDistrict0").prop('readonly', true).addClass('readonly');
                    });

                    if (val) {
                        var url = '/customer/type/' + val;

                        $.ajax({
                            url: url,
                            method: 'GET',
                            success: function(response) {
                                console.log('Response:', response);
                                $('#cstmer_typ').empty();

                                // Append new options
                                $.each(response, function(index, option) {
                                    //alert(option.id);
                                    $('#cstmer_typ').append('<option value="' + option
                                        .id +
                                        '"' + (option.id === 1 ? ' selected' : '') +
                                        '>' +
                                        option.name + '</option>');
                                });
                                // Handle response data here
                            },
                        });
                    }
                }

            });
        });
        // Function to clear input values and assign null
        function NullValues(container) {
            const inputs = container.find('input, select, textarea'); // Use jQuery to find inputs, selects, and textareas
            inputs.each(function() {
                if ($(this).is('select')) {
                    $(this).prop('selectedIndex', 0); // Reset select options
                } else {
                    $(this).val(null); // Assign null to input and textarea values
                }
            });
        }

        const formActionInput = document.getElementById('formAction');
        const submitBtn = document.getElementById('submitBtn');
        const regNum = document.getElementById('vhcl_regis_no');
        const regDate = document.getElementById('vihcle_dt');
        const regFile = document.getElementById('vhcl_reg_file');
        const updateBtn = document.getElementById('callFunctionBtn');

        function updateButtonText() {
            // alert(regFile.files.length)
            // Check if any of the fields have values
            // if (regNum.value || regDate.value || regFile.files.length > 0) {

            if (regFile.files.length > 0) {
                submitBtn.textContent = "Save with RC Details"; // Change button text to Submit
                submitBtn.classList.remove('btn-primary'); // Remove the new class
                submitBtn.classList.add('btn-success'); // Reset to original class
            } else if (regFile.files.length == 0) {
                submitBtn.textContent = "Save without RC Copy"; // Change button text to Submit
                submitBtn.classList.remove('btn-primary'); // Remove the new class
                submitBtn.classList.add('btn-warning'); // Reset to original class
            } else {
                submitBtn.textContent = "Save without RC Details"; // Default button text
                submitBtn.classList.remove('btn-success'); // Remove existing class
                submitBtn.classList.add('btn-primary'); // Add a new class (change to desired color)
            }
        }

        // Event listeners for input changes
        regNum.addEventListener('input', updateButtonText);
        regDate.addEventListener('input', updateButtonText);
        regFile.addEventListener('change', updateButtonText);

        // Initial button text update
        updateButtonText();

        // Assuming you have defined submitBtn, formActionInput, and regNum, regDate, regFile correctly
        submitBtn.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default button action
            if ($('.modelcreate').valid()) { // Ensure the form is valid
                if (submitBtn.textContent === "Submit with RC Details") { // Check if button text indicates submit
                    // Check if all fields are filled
                    if (regNum.value && regDate.value && regFile.files.length > 0) {
                        formActionInput.value = 'S'; // Set value for RC Submit
                        Swal.fire({
                            title: 'Are you sure you want to submit customer detail?',
                            text: "Once you submit customer details, you cannot make any changes.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, submit it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('model_create').submit(); // Submit the form
                            }
                        });
                    } else {
                        // If not all fields are filled, show an alert
                        Swal.fire({
                            title: 'RC Details Incomplete!',
                            text: "Please enter all required RC details: Permanent Registration Number, Date, and Copy.",
                            icon: 'error',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                } else {
                    // If button text is "Submit without RC Details"
                    formActionInput.value = 'P'; // Set value for Pending
                    Swal.fire({
                        title: 'RC Pending!',
                        text: "Your RC details are incomplete. You can save the data, but RC status will be marked as Pending.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Proceed to Save'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('model_create').submit(); // Submit the form
                        }
                    });
                }
            } else {
                Swal.fire({
                    title: 'Form Invalid!',
                    text: "Please fill in all required fields before submitting.",
                    icon: 'error',
                    confirmButtonColor: '#3085d6'
                });
            }
        });
        let tmpRcVal = $('#temp_reg').val();
        let prmRcVal = $('#vhcl_regis_no').val();
        if (!tmpRcVal && !prmRcVal) {
            //disable submit btn at starting
            submitBtn.disabled = true;

        }

        $(document).ready(function() {
            function toggleButton() {
                let allFilled = true;
                const eVoucherDiv = document.getElementById('e_voucher_div');
                $('.reg_num').each(function() {
                    if ($(this).val().trim() === '') {
                        allFilled = false;
                        return false; // Exit loop early
                    }
                });

                if (allFilled) {
                    // $('#submitBtn').show(); // Show button
                    eVoucherDiv.style.display = 'block';
                } else {
                    // $('#submitBtn').hide(); // Hide button
                    eVoucherDiv.style.display = 'none';
                }
            }

            // Check on input change
            $('.reg_num').on('input', toggleButton);

            // Initially hide the button
            // $('#submitBtn').hide();
            // eVoucherDiv.style.display = 'none';
        });


        // var isEvoucherShow = false;
        // $('.reg_num').on('input', function(){
        //     console.log(this, this.getAttribute("data-target"));
        //     const tempReg = this.value;
        //     const eVoucherDiv = document.getElementById('e_voucher_div');
        //     const tmp_regex = /^T[0-9]{4}[A-Z]{2}[0-9]{4}[A-Z]{1,2}$/;
        //     const prefix = tempReg.substring(0, 2);

        //     if (prefix === 'TR' || prefix === 'TG') {
        //         console.log('Prefix matches: ' + prefix);
        //         eVoucherDiv.style.display = 'block'; // Show the E-Voucher button
        //             submitBtn.disabled = false;
        //             document.getElementById("temp_reg_error").style.display = 'none';
        //             document.getElementById("perm_reg_error").style.display = 'none';

        //         return; 
        //     }

        //     let toShow = "";
        //     let toHide = "";

        //     //temperoray case
        //     if(this.getAttribute("data-target") == "temp_reg") {
        //         $('#vhcl_regis_no').val("");
        //         if (tmp_regex.test(tempReg)) {
        //             eVoucherDiv.style.display = 'block'; // Show the E-Voucher button
        //             submitBtn.disabled = false;
        //             document.getElementById("temp_reg_error").style.display = 'none';
        //             document.getElementById("perm_reg_error").style.display = 'none';
        //             return; 
        //         }else{
        //             toShow = "temp_reg_error";
        //             toHide = "perm_reg_error";
        //         }
        //     }else{
        //         $('#temp_reg').val("");
        //         //permanent number case
        //         if ($('#vhcl_regis_no').val().trim().length >= 9) {
        //                 eVoucherDiv.style.display = 'block'; // Show the E-Voucher button
        //                 submitBtn.disabled = false;
        //                 document.getElementById("temp_reg_error").style.display = 'none';
        //                 document.getElementById("perm_reg_error").style.display = 'none';
        //                 return; 
        //             }else{
        //                 toShow = "perm_reg_error";
        //                 toHide = "temp_reg_error";
        //             }

        //     }
        //     document.getElementById(toShow).style.display = 'block';
        //     document.getElementById(toHide).style.display = 'none';
        //     submitBtn.disabled = true;
        //     eVoucherDiv.style.display = 'none';
        // })

        // Add click event to the "View E-Voucher" button
        document.getElementById('e_voucher_btn').addEventListener('click', function() {
            event.preventDefault(); // Prevent the form from being submitted
            let isTempReg = false;
            let isPermReg = false;
            let vehicleRegDate = false;
            let notifyText = "This will lock the Temporary Registration Number field.";
            let target = "temp";
            let tempVal = 0;
            let permVal = 0;
            let buyer_id = {!! json_encode($bankDetail->buyer_id) !!};
            vehicleRegDate = $('#vihcle_dt').val();


            const tmp_regex = /^T[0-9]{4}[A-Z]{2}[0-9]{4}[A-Z]{1,2}$/;
            if (tmp_regex.test($('#temp_reg').val())) {
                isTempReg = true;
                tempVal = $('#temp_reg').val().trim();
            }
            if ($('#vhcl_regis_no').val().trim().length >= 9) {
                isPermReg = true;
                notifyText = "This will lock the Permanent Registration Number field.";
                target = "perm";
                permVal = $('#vhcl_regis_no').val().trim();
            }

            if (isTempReg && isPermReg) {
                notifyText = "This will lock the Temporary & Permanent Registration Number field.";
                target = "both";
                tempVal = $('#temp_reg').val().trim();
                permVal = $('#vhcl_regis_no').val().trim();
            }

            let reqData = {
                _token: "{{ csrf_token() }}", // CSRF token for security
                id: "{{ $id }}", // The ID of the record
                target,
                tempVal,
                permVal,
                buyer_id,
                vehicleRegDate
            }

            console.log(vehicleRegDate, reqData);
            Swal.fire({
                title: 'Are you sure?',
                text: notifyText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Generate E-Voucher'
            }).then((result) => {
                // return;
                if (result.isConfirmed) {
                    const tempRegField = document.getElementById('temp_reg');
                    const permRegField = document.getElementById('vhcl_regis_no');
                    const permRegDt = document.getElementById('vihcle_dt');

                    // Send AJAX request to update temp_reg in the database
                    $.ajax({
                        url: "{{ route('update-temp-reg') }}", // Laravel route
                        method: "POST",
                        data: reqData,
                        success: function(response) {
                            Swal.fire(
                                'Locked!',
                                response.message,
                                'success'
                            );

                            if (target == "both") {
                                permRegField.readOnly = true;
                                permRegField.classList.add('readonly'); // Add readonly class

                                permRegDt.readOnly = true;
                                permRegDt.classList.add('readonly'); // Add readonly class

                                tempRegField.readOnly = true;
                                tempRegField.classList.add('readonly'); // Add readonly class
                            } else if (target == "perm") {
                                permRegField.readOnly = true;
                                permRegField.classList.add('readonly'); // Add readonly class

                                permRegDt.readOnly = true;
                                permRegDt.classList.add('readonly'); // Add readonly class

                            } else {
                                tempRegField.readOnly = true;
                                tempRegField.classList.add('readonly');
                            }

                            // Hide the "View E-Voucher" button after confirmation
                            document.getElementById('e_voucher_div').style.display = 'none';

                            // Open the route in a new tab/window
                            window.open(
                                "{{ route('dealer.view_certificate', encrypt($bankDetail->buyer_id)) }}",
                                '_blank');
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'There was an error updating the Registration Number.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        let cdIndex = 1;

        $('#add_multi_cdn').on('click', function() {
            cdIndex++;
            let newRow = `
            <div class="row border p-3 mb-3 cd-block" data-index="${cdIndex}">
                <div class="col-4 mb-3 cd-entry">
                    <label class="form-label">CD Number</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input class="form-control cdnumber-input" name="data[${cdIndex}][cdnumber]">
                            <input type="hidden" name="data[${cdIndex}][production_id]" class="prod_id" />
                            <input type="hidden" name="data[${cdIndex}][segment_id]" />
                            <input type="hidden" name="data[${cdIndex}][tot_adm_inc_amt]" />
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary btn-sm p-2 fetch-cd-btn" data-index="${cdIndex}">Fetch CD Data</button>
                        </div>
                    </div>
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">CD Owner Name:</label>
                    <input class="form-control readonly" name="data[${cdIndex}][cd_owner_name]" readonly>
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">Gross Vehicle Weight (GVW in Tons):</label>
                    <input class="form-control readonly" name="data[${cdIndex}][gvw]" readonly>
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">VIN/Chassis Number:</label>
                    <input class="form-control readonly" name="data[${cdIndex}][vin_no]" readonly>
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">Status Flag:</label>
                    <input class="form-control readonly" name="data[${cdIndex}][status]" readonly>
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">CD – Issue Date:</label>
                    <input class="form-control readonly" name="data[${cdIndex}][cd_issue_date]" readonly>
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">CD - Validity Upto Date:</label>
                    <input class="form-control readonly" name="data[${cdIndex}][cd_validation_date]" readonly>
                </div>

                <div class="col-4 mt-4">
                    <button type="button" class="btn btn-danger btn-sm remove-cd-btn">Remove</button>
                </div>
            </div>`;

            $('#cd-inputs-wrapper').append(newRow);
        });

        let usedCdData = [];
        $(document).on('click', '.fetch-cd-btn', function() {
            let index = $(this).data('index');
            let cdNumber = $(`[name="data[${index}][cdnumber]"]`).val()?.trim();

            if (!cdNumber) {
                alert('Please enter a CD number.');
                return;
            }
            if (usedCdData.some(entry => entry.cdNumber === cdNumber)) {
                swal.fire('warning', 'This CD number has already been used.');
                callFunctionBtn.disabled = true;
                callFunctionBtn.innerHTML = 'Save & Next';
                return;
            }
            console.log(usedCdData);
            $.ajax({
                url: `/e-trucks/get_cd_data/${cdNumber}`,
                type: 'GET',
                success: function(response) {
                    if (response.error) {
                        swal.fire('Error', response.error, 'error');
                    } else {

                        if (usedCdData.length > 0 && usedCdData[0].data.cd_owner_name !== response
                            .present_owner_name) {
                            swal.fire('Warning', 'All CD entries must have the same CD Owner Name.',
                                'warning');
                            return;
                        }
                        $(`[name="data[${index}][cd_owner_name]"]`).val(response.present_owner_name ||
                            '');
                        $(`[name="data[${index}][gvw]"]`).val(response.vehicle_gvw || '');
                        $(`[name="data[${index}][vin_no]"]`).val(response.scrapped_vin || '');
                        $(`[name="data[${index}][status]"]`).val(response.status_flag || '');
                        $(`[name="data[${index}][cd_issue_date]"]`).val(response.issue_date || '');
                        $(`[name="data[${index}][cd_validation_date]"]`).val(response.valid_upto_date ||
                            '');

                        const cdData = {
                            cdNumber: cdNumber,
                            index: index,
                            data: {
                                cd_owner_name: response.present_owner_name || '',
                                gvw: response.vehicle_gvw || '',
                                vin_no: response.scrapped_vin || '',
                                status: response.status_flag || '',
                                cd_issue_date: response.issue_date || '',
                                cd_validation_date: response.valid_upto_date || ''
                            }
                        };

                        const existingIndex = usedCdData.findIndex(item => item.index === index);

                        if (existingIndex !== -1) {
                            // Override the existing object at the same index
                            usedCdData[existingIndex] = cdData;
                        } else {
                            // No match found — push new object
                            usedCdData.push(cdData);
                        }

                        checkGvwAndToggleButton();

                        $(`[name="data[${index}][cdnumber]"]`).attr('data-used-cd', cdNumber);
                    }
                },
                error: function(xhr) {
                    alert("AJAX Error: " + xhr.responseText);
                }
            });
        });

        function checkGvwAndToggleButton() {
            const totalGvw = usedCdData.reduce((sum, entry) => {
                const gvw = parseFloat(entry.data.gvw);
                return sum + (isNaN(gvw) ? 0 : gvw);
            }, 0);

            const invoice_dt = parseFloat($('#invoice_dt').val());
            const modelgvw = parseFloat($('#gross_weight').val());

            if (totalGvw < modelgvw) {
                Swal.fire('Warning', 'Total GVW is less than Model GVW', 'warning');
                callFunctionBtn.disabled = true;
                callFunctionBtn.innerHTML = 'Save & Next';
            } else {
                callFunctionBtn.disabled = false;
                callFunctionBtn.innerHTML = 'Save & Next';
            }
        }
        // Remove specific row and update usedCdData
        $('#cd-inputs-wrapper').on('click', '.remove-cd-btn', function() {

            let $block = $(this).closest('.cd-block');
            let $cdInput = $block.find('[name^="data["][name$="[cdnumber]"]');
            let cdNumber = $cdInput.attr('data-used-cd');

            if (cdNumber) {
                usedCdData = usedCdData.filter(entry => entry.cdNumber !== cdNumber);
            }

            $block.remove();
            checkGvwAndToggleButton();
        });


        $(document).ready(function() {
            $('.prevent-multiple-submit').on('submit', function() {
                $(this).find('button[type="submit"]').prop('disabled', true);
                var buttons = $(this).find('button[type="submit"]');
                setTimeout(function() {
                    buttons.prop('disabled', false);
                }, 20000); // 25 seconds in milliseconds
            });
        });

        // date check of invoice and registration
        function validateDates() {
            var manu_date = new Date($("#manufacturing_date").val());
            var invoiceDate = new Date($("#invoice_dt").val());
            var vehicleDate = new Date($("#vihcle_dt").val());
            var category = $('#sh_vehicle').val();

            $("input[name*='[cd_issue_date]']").each(function() {
                // Extract index from the name attribute like data[1][cd_issue_date]
                const nameAttr = $(this).attr("name");
                const match = nameAttr.match(/data\[(\d+)]\[cd_issue_date]/);

                if (match) {
                    const index = match[1];
                    const issueDateStr = $(`input[name="data[${index}][cd_issue_date]"]`).val();
                    const validDateStr = $(`input[name="data[${index}][cd_validation_date]"]`).val();
                    const issueDate = new Date(issueDateStr);
                    const validDate = new Date(validDateStr);

                    if (invoiceDate < issueDate || invoiceDate > validDate) {
                        alert(`Invoice date must be between CD issue and valid date for entry ${index}`);
                        $("#invoice_dt").val("");
                        return false; // exit loop
                    }
                }
            });
            if (invoiceDate < manu_date) {
                alert("Invoice date is less than manufacturing date");
                $("#invoice_dt").val("");
                $("#vihcle_dt").val("");
            }
            if (invoiceDate > vehicleDate) {
                alert("Invoice date cannot be greater than vehicle registration date");
                $("#invoice_dt").val("");
                $("#vihcle_dt").val("");
            }

            // if (category == 'L5') {
            //     var selectedDate = $('#invoice_dt').val();
            //     var inputDate = new Date(selectedDate);
            //     var comparisonDate = new Date('2024-11-08');

            //     if (inputDate >= comparisonDate) {
            //         alert('Vehicle count limit exceded');
            //         $("#invoice_dt").val("");
            //     }

            // }
        }
    </script>