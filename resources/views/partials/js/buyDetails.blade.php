<script>
           $(document).ready(function() {
               // Initialize select2 for all role-specific remark fields
               $('[id^="role_id1"], [id^="role_id2"], [id^="role_id3"]').select2({
                   placeholder: 'Select Remarks',
                   allowClear: true,
                   width: 'resolve'
               });
           });
           $('.action-btn1').click(function(e) {
               e.preventDefault();
               const $button = $(this);
               const title = $button.data('title');
               const confirmText = $button.data('confirm');
               Swal.fire({
                   title: title,
                   html: `<p class="mt-2 text-left"></p>`,
                   icon: 'question',
                   showCancelButton: true,
                   confirmButtonText: confirmText,
                   cancelButtonText: 'Cancel',
                   reverseButtons: true,
                   focusConfirm: false,
               }).then((result) => {
                   if (result.isConfirmed) {
                       $('#freezeDataBtn').addClass('disabled').prop('disabled', true);
                       const claimId = {{ $claimId }};
                       const link = `/claimEvaluation/submit/${claimId}/${0}`;
                       window.location.href = link;
                   }
               });
           });

           $('.action-btn').click(function(e) {
    e.preventDefault();
    const $button = $(this);
    const title = $button.data('title');
    const type = $button.data('type');
    const confirmText = $button.data('confirm');
    const remarks = $('#hiddenRemarks').val();

    if (!remarks.trim()) {
        Swal.fire('Remarks Required', 'Please enter your remarks before submitting.', 'warning');
        return;
    }

    Swal.fire({
        title: title,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: 'Cancel',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            // Disable button to prevent multiple submits
            $button.prop('disabled', true);

            // Set the action type
            $('#action_type').val(type);

            // Submit the form
            $('#actionForms').submit();
        }
    });
});

$('.action-btn2').click(function(e) {
    e.preventDefault();
    const $button = $(this);
    const title = $button.data('title');
    const type = $button.data('type');
    const confirmText = $button.data('confirm');
    const remarks = $('#hiddenRemarks').val();

    if (!remarks.trim()) {
        Swal.fire('Remarks Required', 'Please enter your remarks before submitting.', 'warning');
        return;
    }

    Swal.fire({
        title: title,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: 'Cancel',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            const claimId = {{ $claimId }}; // Make sure this is rendered correctly by your server
            const url = `/claimEvaluation/claimstagesubmit/${claimId}/${type}`;
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    remarks: remarks,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire('Success', 'Action completed successfully.', 'success')
                        .then(() => {
                            // Optionally redirect or update the UI
                            location.reload();
                        });
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                }
            });
        }
    });
});


           $('.btnApp').click(function(e) {
               e.preventDefault();
               Swal.fire({
                   title: 'Forward to Auditor',
                   html: `
                <div class="form-group text-left">
                    <label for="auditorSelect">Select Auditor <span class="text-danger">*</span></label>
                    <select id="auditorSelect" class="form-control" required>
                        <option value="">-- Choose Auditor --</option>
                        @foreach ($auditors as $auditor)
                            <option value="{{ $auditor->id }}">{{ $auditor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="mt-2 text-left">Kindly confirm the selected auditor before proceeding with the claim  evaluation.</p>
            `,
                   icon: 'question',
                   showCancelButton: true,
                   confirmButtonText: 'Yes, Forward',
                   cancelButtonText: 'Cancel',
                   reverseButtons: true,
                   focusConfirm: false,
                   preConfirm: () => {
                       const selectedAuditor = document.getElementById('auditorSelect').value;
                       if (!selectedAuditor) {
                           Swal.showValidationMessage('Auditor selection is required.');
                           return false;
                       }
                       return selectedAuditor;
                   }
               }).then((result) => {
                   if (result.isConfirmed) {
                       const auditorId = result.value;
                       $('.btnApp').addClass('disabled').prop('disabled', true);
                       const claimId = {{ $claimId }};
                       const link = `/claimEvaluation/submit/${claimId}/${auditorId}`;
                       window.location.href = link;
                   }
               });
           });
           function upVal(selectElement) {
               let selectedValue = selectElement.value;
               let [selectedId, selectedText] = selectedValue.split("|").map(val => val.trim());
               let row = $(selectElement).closest('tr');
               let inputField = row.find('input[name^="data"][name$="[approved_amt]"]');
               let inputField1 = row.find('input[name^="data"][name$="[rejected_amt]"]');
               let inputField2 = row.find('input[name^="data"][name$="[withheld_amt]"]');
               let oldValue = inputField.attr('data-old-value');
               if (selectedId === "1" && selectedText === "Maybe Approved") {
                   inputField.val(oldValue);
                   inputField1.val(0);
                   inputField2.val(0);
               } else if (selectedId === "2") {
                   inputField1.val(oldValue);
                   inputField2.val(0);
                   inputField.val(0);
               } else if (selectedId === "3") {
                   inputField2.val(oldValue);
                   inputField.val(0);
                   inputField1.val(0);
               }
           }
           document.getElementById('addMoreFilesBtn').addEventListener('click', function() {
               const container = document.getElementById('additionalFilesContainer');
               const colDiv = document.createElement('div');
               colDiv.classList.add('col-md-6');
               const newFileInputGroup = document.createElement('div');
               newFileInputGroup.classList.add('input-group', 'mb-3');
               const fileInput = document.createElement('input');
               fileInput.type = 'file';
               fileInput.classList.add('form-control');
               fileInput.name = 'additional_files[]';
               fileInput.accept = '.pdf,.doc,.docx,.zip,.rar';
               const removeButton = document.createElement('button');
               removeButton.type = 'button';
               removeButton.classList.add('btn', 'btn-danger', 'removeFileBtn');
               removeButton.textContent = 'Remove';
               newFileInputGroup.appendChild(fileInput);
               newFileInputGroup.appendChild(removeButton);
               colDiv.appendChild(newFileInputGroup);
               container.appendChild(colDiv);
           });
           document.getElementById('additionalFilesContainer').addEventListener('click', function(event) {
               if (event.target && event.target.classList.contains('removeFileBtn')) {
                   const fileInputGroup = event.target.closest('.input-group');
                   if (fileInputGroup) {
                       fileInputGroup.remove();
                   }
               }
           });
       </script>