$(document).ready(function() {
    $('#contactForm').on('submit', function(event) {
        event.preventDefault();

        var formData = {
            'name': $('input[name=name]').val(),
            'email': $('input[name=email]').val(),
            'message': $('textarea[name=message]').val()
        };

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
            $('#responseMessage').html("<p>Sorry, an error occurred. Please try again.</p>");
        });
    });
});