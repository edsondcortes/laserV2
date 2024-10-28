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
                equalTo: "#password_confirmation"
            },
            password_confirmation: {
                equalTo: "#password"
            }
        },
        errorElement: 'div'
    });

    $(".select2").select2();
});
