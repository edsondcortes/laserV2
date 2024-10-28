$(document).ready(function () {
    // Input, Select, Textarea validations except submit button validation initialization
    $("#userCreate").validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true,
            },
            passowrd: {
                required: true,
                equalTo: "#password_confirmation"
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            }
        },
        errorElement: 'div'
    });

    $(".select2").select2();

});
