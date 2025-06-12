   <script>
       $("#update_incentive").on("click", function() {
           let vin = document.getElementById("vin_number").value;
           let row_id = {{ $bankDetail->id }};
           let oemid = document.getElementById("oem_id").value;
           let invoice_amt = document.getElementById("invoice_amt").value;
           $.ajax({
               url: "{{ route('e-trucks.buyerdetail.update.incentive') }}",
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
                   eVoucherDiv.style.display = 'block';
               } else {
                   eVoucherDiv.style.display = 'none';
               }
           }
           $('.reg_num').on('input', toggleButton);
       });
       document.getElementById('e_voucher_div').addEventListener('click', function() {
           event.preventDefault();
           let isTempReg = false;
           let isPermReg = false;
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
                       url: "{{ route('e-trucks.update-temp-reg') }}", // Laravel route
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
                           // window.open(
                           //     "{{ route('dealer.view_certificate', encrypt($bankDetail->buyer_id)) }}",
                           //     '_blank');
                           window.open(
                               "{{ route('e-trucks.dealer.multiBuyerVoucher', encrypt($bankDetail->id)) }}",
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

       $(function() {
           $('#e_voucher_div').hide();
           if ($('#temp_reg').val().trim() != '' || $('#vhcl_regis_no').val().trim() != '') {
               $('#e_voucher_div').show();
           }
       });
       $('#fetchDetails').on("click", function() {
           $('#fetchDetails').text("Fetching...");
           $('#fetchDetails').attr("disabled", true);

           var val = document.getElementById("vin_number").value;
           var oemid = document.getElementById("oem_id").value;

           var token = $("input[name='_token']").val();

           $.ajax({
               url: '/e-trucks/vin/getcode/' + val + '/' + oemid,
               method: 'GET',
               success: function(responce) {
                   if (responce.data4 == true && responce.data5) {
                       $('#temp_reg').val("");
                       $('#vhcl_regis_no').val("");
                       $('#vihcle_dt').val("");

                       $('#temp_reg').val(responce.data7);
                       $('#vhcl_regis_no').val(responce.data5);


                       $('#vihcle_dt').attr("type", "text");
                       let dateFetched = responce.data6;
                       $('#vihcle_dt').val(dateFetched);

                       $('#temp_reg').attr("readonly", true);
                       $('#temp_reg').addClass("readonly");

                       $('#vhcl_regis_no').attr("readonly", true);
                       $('#vhcl_regis_no').addClass("readonly");

                       $('#vihcle_dt').attr("readonly", true);
                       $('#vihcle_dt').addClass("readonly");

                       $('#e_voucher_div').show();

                   } else {
                       console.log(responce);
                       if (responce.data4 == false && responce.data5 == 'TEL' && responce.data6 ==
                           'TEL') {
                           Swal.fire({
                               title: 'RC Details Not Found!',
                               text: "'RC detail not found in vahan, Please Enter it Manually.",
                               icon: 'warning',
                               confirmButtonColor: '#3085d6'
                           });

                           // $('#vhcl_regis_no').attr("readonly", false);
                           // $('#vhcl_regis_no').addClass("readonly");

                           // $('#vihcle_dt').attr("readonly", false);
                           // $('#vihcle_dt').addClass("readonly");

                           $('#vhcl_regis_no').prop('readonly', false).removeClass('readonly');
                           // $('#vihcle_dt').prop('readonly', false).removeClass('readonly');
                           let minDate = '2024-04-01';
                           let maxDate = new Date().toISOString().split('T')[
                               0]; // Gets today's date in YYYY-MM-DD format

                           // $('#vihcle_dt').attr('min', minDate).attr('max', maxDate);

                           $('#vihcle_dt').prop('readonly', false).removeClass('readonly').attr('type',
                               'date').attr('min', minDate).attr('max', maxDate);

                       } else {
                           Swal.fire({
                               title: 'RC Details Not Found!',
                               text: "RC details for the entered VIN were not found. Please register your VIN on the Vahan portal first.",
                               icon: 'warning',
                               confirmButtonColor: '#3085d6'
                           });
                           if ($('#vhcl_regis_no').val()) {
                               $('#vhcl_regis_no').prop('readonly', true).addClass('readonly');
                           }

                           if ($('#vihcle_dt').val()) {
                               $('#vihcle_dt').prop('readonly', true).addClass('readonly');
                           }
                       }

                   }

                   $('#fetchDetails').text("Fetch RC Details");
                   $('#fetchDetails').removeAttr("disabled");

               },
               error: function(err) {
                   console.error(err);
                   $('#fetchDetails').text("Fetch RC Details");
                   $('#fetchDetails').removeAttr("disabled");
               }
           });
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

       $('#print_ack').on('click', function() {
           const invRange = $('#range').val().trim();
           const invDate = $('#invoice_dt').val().trim();
           const invAmt = $('#invoice_amt').val().trim();

           $('#invoice_no_err').text("");
           $('#invoice_date_err').text("");
           $('#invoice_amt_err').text("");

           if (!invRange) {
               $('#invoice_no_err').text("This field is required");
               return;
           }

           if (!invDate) {
               $('#invoice_date_err').text("This field is required");
               return;
           }

           if (!invAmt || parseInt(invAmt, 10) == 0) {
               $('#invoice_amt_err').text("This field is required");
               return;
           }

           var token = $("input[name='_token']").val();

           $.ajax({
               url: "{{ route('e-trucks.save.invoice') }}",
               method: 'POST',
               data: {
                   '_token': '{{ csrf_token() }}',
                   invRange,
                   invDate,
                   invAmt,
                   invAdmisAmt: $('#addmi_inc_amt').val(),
                   invTotAmt: $('#tot_inv_amt').val(),
                   invTotAdmisAmt: $('#tot_adm_inc_amt').val(),
                   invPayCust: $('#amt_custmr').val(),
                   id: $('#bankDetailRowId').val()
               },
               success: function(responce) {
                   console.log(responce);
                   if (!responce.status) {
                       Swal.fire({
                           title: 'Error',
                           text: responce.message,
                           icon: 'error',
                           confirmButtonColor: '#3085d6'
                       });
                       return;
                   }

                   $('#acknowledgeButton').show();
               },
               error: function(err) {
                   Swal.fire({
                       title: 'Error',
                       text: "Something went wrong!",
                       icon: 'error',
                       confirmButtonColor: '#3085d6'
                   });
                   console.error(err);
               }
           });

       });

       $(document).ready(function() {
           $('#model_create').on('submit', function(event) {

               document.getElementById('vhcl_reg_file_error').innerText = "";
               let prmt_reg_val = document.getElementById('vhcl_regis_no').value;
               let prev_upl_reg_file = document.getElementById('vhcl_reg_file_exist').value;
               let prmt_reg_file = document.getElementById('vhcl_reg_file').value;
               // console.log(prmt_reg_val, prev_upl_reg_file);
               if (prmt_reg_val && !prev_upl_reg_file) {
                   if (!prmt_reg_file) {
                       document.getElementById('vhcl_reg_file_error').innerText = "This field is required";
                       document.getElementById('Vehicle_details').scrollIntoView();
                       event.preventDefault();
                   }
               }

               $(this).find('#callFunctionBtn').prop('disabled', true);
               var buttons = $(this).find('#callFunctionBtn');
               setTimeout(function() {
                   buttons.prop('disabled', false);
               }, 20000); // 25 seconds in milliseconds
           });

           $('#final_submit_form').on('submit', function(event) {
               event.preventDefault();

               if (!$("#model_create").valid()) {
                   return;
               }


               $(this).find('#final_submit_btn').prop('disabled', true);
               var buttons = $(this).find('#final_submit_btn');
               setTimeout(function() {
                   buttons.prop('disabled', false);
               }, 20000); // 25 seconds in milliseconds

               Swal.fire({
                   title: 'Are you sure you want to submit details?',
                   text: "Once submitted, you can not make any changes.",
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Yes, submit it!'
               }).then((result) => {
                   if (result.isConfirmed) {
                       document.getElementById('final_submit_form').submit(); // Submit the form
                   }
               });
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
                            .presentCdOwnerName) {
                            swal.fire('Warning', 'All CD entries must have the same CD Owner Name.',
                                'warning');
                            return;
                        }
                        $(`[name="data[${index}][cd_owner_name]"]`).val(response.presentCdOwnerName ||
                            '');
                        $(`[name="data[${index}][gvw]"]`).val(response.gvw || '');
                        $(`[name="data[${index}][vin_no]"]`).val(response.chassisNo || '');
                        $(`[name="data[${index}][status]"]`).val(response.statusFlag || '');
                        $(`[name="data[${index}][cd_issue_date]"]`).val(response.issueDate || '');
                        $(`[name="data[${index}][cd_validation_date]"]`).val(response.validUpto ||
                            '');

                        const cdData = {
                            cdNumber: cdNumber,
                            index: index,
                            data: {
                                cd_owner_name: response.presentCdOwnerName || '',
                                gvw: response.gvw || '',
                                vin_no: response.chassisNo || '',
                                status: response.statusFlag || '',
                                cd_issue_date: response.issueDate || '',
                                cd_validation_date: response.validUpto || ''
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
                Swal.fire('Warning', 'Total Scraped GVW is less than Model GVW', 'warning');
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

   {{-- <script>
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
               return;
           }
        //    let usedCdData = [];

           console.log(usedCdData);
          
           $.ajax({
               url: `/e-trucks/get_cd_data/${cdNumber}`,
               type: 'GET',
               success: function(response) {
                   console.log(response);
                   if (response.error) {
                       swal.fire('Error', response.error, 'error');
                   } else {
                       // Fill in the form fields
                       $(`[name="data[${index}][cd_owner_name]"]`).val(response.present_owner_name ||
                           '');
                       $(`[name="data[${index}][gvw]"]`).val(response.vehicle_gvw || '');
                       $(`[name="data[${index}][vin_no]"]`).val(response.scrapped_vin || '');
                       $(`[name="data[${index}][status]"]`).val(response.status_flag || '');
                       $(`[name="data[${index}][cd_issue_date]"]`).val(response.issue_date || '');
                       $(`[name="data[${index}][cd_validation_date]"]`).val(response.valid_upto_date ||
                           '');

                       // Add full data to the array
                       usedCdData.push({
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
                       });
                       checkGvwAndToggleButton();

                       $(`[name="data[${index}][cdnumber]"]`).attr('data-used-cd', cdNumber);
                   }
               },
               error: function(xhr) {
                   alert("AJAX Error: " + xhr.responseText);
               }
           });
       });


       function validateDates() {
           var manu_date = new Date($("#manufacturing_date").val());
           var invoiceDate = new Date($("#invoice_dt").val());
           var vehicleDate = new Date($("#vihcle_dt").val());
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
               return;
           }

           if (invoiceDate > vehicleDate) {
               alert("Invoice date cannot be greater than vehicle registration date");
               $("#invoice_dt").val("");
           }
       }
       $("#invoice_dt, #vihcle_dt").change(validateDates);
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
               callFunctionBtn.innerHTML = 'Update';
           } else {
               callFunctionBtn.disabled = false;
               callFunctionBtn.innerHTML = 'Update';
           }
       }
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
   </script> --}}
