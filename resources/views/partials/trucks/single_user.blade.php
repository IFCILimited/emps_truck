   <script>
       function getProjectCode() {
           $(".srchV").val('');
           var val = document.getElementById("vin").value;
           var oemid = document.getElementById("oem_id").value;
           var token = $("input[name='_token']").val();
           $.ajax({
               url: '/e-trucks/vin/getcode/' + val + '/' + oemid,
               method: 'GET',
               success: function(response) {
                   if (response.data2 == 1) {
                       alert('Vehicle with this VIN no is already sold')
                       $('#sh_vehicle').val();
                       $('#xevmdl').val();
                       $('#modl_vrnt').val();
                       $('#segment').val();
                       $('#ex_price').val();
                       $('#manufacturing_date').val();
                       $('#tot_adm_inc_amt').val();
                       $('#addmi_inc_amt').val();
                       $('#gross_weight').val();

                   } else if (response.data1.length == 0) {
                       $('#vin').val();
                       alert('Please enter correct VIN no')

                   } else if (response.data1[0].manufacturing_date) {
                       let manufacturingDate = new Date(response.data1[0].manufacturing_date);
                       let startDate = new Date('2024-04-01');
                       let endDate = new Date('2026-03-31');

                       if (manufacturingDate >= startDate && manufacturingDate <= endDate) {
                           if (response.data4 == true) {

                               $('#prd_id').val(response.data1[0].id);
                               $('#seg_id').val(response.data1[0].segment_id);
                               $('#sh_vehicle').val(response.data1[0].vehicle_cat);
                               $('#xevmdl').val(response.data1[0].model_name);
                               $('#modl_vrnt').val(response.data1[0].variant_name);
                               $('#segment').val(response.data1[0].segment);
                               $('#ex_price').val(response.data1[0].factory_price);
                               $('#manufacturing_date').val(response.data1[0].manufacturing_date);
                               $('#gross_weight').val(response.data1[0].gross_weight);
                               $('#tot_adm_inc_amt').val(response.data3);
                               $('#addmi_inc_amt').val(response.data3);
                               $('#permanent_reg_no').val(response.data5);
                               //$('#permanent_reg_dt').val(response.data6);
                               $('#permanent_reg_dt').val(response.data5 ? response.data6 : '');
                               $('#temp_reg_no').val(response.data7);
                               $('#temp_reg_dt').val(response.data8);
                           }
                           // } else {
                           //     //  if (response.data1[0].vehicle_cat === 'L5' && response.data4 == false) {
                           //     //     alert('Unable to fetch vahan details. Please try again.');
                           //     // } else {
                           //         alert('Vahan Details not found');

                           //         $('#prd_id').val(response.data1[0].id);
                           //         $('#seg_id').val(response.data1[0].segment_id);
                           //         $('#sh_vehicle').val(response.data1[0].vehicle_cat);
                           //         $('#xevmdl').val(response.data1[0].model_name);
                           //         $('#modl_vrnt').val(response.data1[0].variant_name);
                           //         $('#segment').val(response.data1[0].segment);
                           //         $('#ex_price').val(response.data1[0].factory_price);
                           //         $('#manufacturing_date').val(response.data1[0].manufacturing_date);
                           //         $('#tot_adm_inc_amt').val(response.data3);
                           //         $('#addmi_inc_amt').val(response.data3);
                           //         $('#permanent_reg_no').val(response.data5);
                           //         //$('#permanent_reg_dt').val(response.data6);
                           //         $('#permanent_reg_dt').val(response.data5 ? response.data6 : '');
                           //         $('#temp_reg_no').val(response.data7);
                           //         $('#temp_reg_dt').val(response.data8);

                           //     // };

                           // }

                       } else {
                           alert('The manufacturing date is not between 1 October 2024 and 31 March 2026');
                       }
                   } else if (response.data1 == 'Sold') {
                       $('#vin').val('');
                       alert('Vehicle with this VIN no is already sold in EMPS')
                   } else {
                       $('#prd_id').val(response.data1[0].id);
                       $('#seg_id').val(response.data1[0].segment_id);
                       $('#sh_vehicle').val(response.data1[0].vehicle_cat);
                       $('#xevmdl').val(response.data1[0].model_name);
                       $('#modl_vrnt').val(response.data1[0].variant_name);
                       $('#segment').val(response.data1[0].segment);
                       $('#ex_price').val(response.data1[0].factory_price);
                       $('#manufacturing_date').val(response.data1[0].manufacturing_date);
                       $('#tot_adm_inc_amt').val(response.data3);
                       $('#addmi_inc_amt').val(response.data3);
                       $('#permanent_reg_dt').val(response.data5 ? response.data6 : '');
                       $('#temp_reg_no').val(response.data7);
                       $('#temp_reg_dt').val(response.data8);
                   }
                   checkGvwAndToggleButton();
               }
           });
       }

       // invoice amt calculation
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

       // button text change
       $('#cstm_typ').on('change', function() {
           var val = $(this).val();
           if (val !== '1') {
               callFunctionBtn.innerHTML = 'Save & Next';
               $('.nonInv').show();
               $('.customer-info').show();
           } else {
               callFunctionBtn.innerHTML = 'Generate Customer ID';
               $('.nonInv').hide();
               $('.customer-info').hide();
           }
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
                    //    if (response.statusFlag=='U') {
                    //        swal.fire('Warning', response.responseMessage,
                    //            'warning');
                    //        return;
                    //    }
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
           console.log(totalGvw);

           const invoice_dt = parseFloat($('#invoice_dt').val());
           const modelgvw = parseFloat($('#gross_weight').val());
           console.log(modelgvw);

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
