$(document).ready(function() {
    function isValidEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $('#contactForm').on('submit', function(event) {
        event.preventDefault();

        $('#responseMessage').empty();
        $('.error-message').remove();
        $('input, textarea').removeClass('input-error');

        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var message = $('#message').val().trim();
        var isValid = true;

        if (name === '') {
            $('#name').addClass('input-error');
            $('#name').after('<span class="error-message">Name is required.</span>');
            isValid = false;
        }

        if (email === '') {
            $('#email').addClass('input-error');
            $('#email').after('<span class="error-message">Email is required.</span>');
            isValid = false;
        } else if (!isValidEmail(email)) {
            $('#email').addClass('input-error');
            $('#email').after('<span class="error-message">Please enter a valid email address.</span>');
            isValid = false;
        }

        if (message === '') {
            $('#message').addClass('input-error');
            $('#message').after('<span class="error-message">Message is required.</span>');
            isValid = false;
        }

        if (isValid) {
            var formData = $(this).serialize();
            var submitButton = $(this).find('button[type="submit"]');
            var originalButtonHtml = submitButton.html();

            submitButton.html('<i class="fas fa-spinner fa-spin"></i> Sending...');
            submitButton.prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: 'https://jsonplaceholder.typicode.com/posts',
                data: formData,
                dataType: 'json',
                encode: true
            })
            .done(function(data) {
                $('#responseMessage').html("<p>Thank you for contacting us, we will get back to you shortly.</p>");
                $('#contactForm')[0].reset();
            })
            .fail(function(data) {
                $('#responseMessage').html("<p style='color: #dc3545;'>Sorry, an error occurred. Please try again.</p>");
            })
            .always(function() {
                submitButton.html(originalButtonHtml);
                submitButton.prop('disabled', false);
            });
        }
    });
});
