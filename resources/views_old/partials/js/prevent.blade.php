
<script>

$(function(){
    $('.prevent-multiple-submit').on('click', function(event){
        // event.preventDefault(); // Prevent default button click behavior

        // Check if all form fields are filled
        var allFieldsFilled = true;
        $('form :input').each(function() {
            if ($(this).val().trim() === '') {
                allFieldsFilled = false;
                return false; // Break the loop if any field is empty
            }
        });

        // If all fields are filled, proceed with form submission
        if (allFieldsFilled) {
            var $form = $(this).closest('form');
            var $buttons = $('.btn');

            // Hide all buttons
            $buttons.hide();

            // Create loader element
            var $loader = $('<div id="loader" class="text-center"></div>');
            var $spinner = $('<div class="spinner-border text-primary" role="status"></div>');
            var $message = $('<div class="mt-2">Please wait...</div>');

            // Append spinner and message to loader
            $loader.append($spinner, $message);

            // Insert loader after the buttons
            $buttons.last().after($loader);

            // Submit the form
            $form.submit();
        } else {
            // If any field is empty, do not proceed with form submission
            // Optionally, you can display an error message or handle it as per your requirement
            console.log('Please fill in all fields before submitting the form.');
        }
    });
});


</script>