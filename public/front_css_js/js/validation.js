$(function() {

    $("#front_login").validate({

        rules: {
            user_fullname: "required",
            user_email: {
                required: true,
                email: true
            },
            user_password: {
                required: true,
                minlength: 5
            },
            user_confirm_password: {
                required: true,
                minlength: 5
            }
        },

        messages: {
            user_fullname: "Please enter Full Name",
            password: {
                required: "Please enter Password",
                minlength: "Your password must be at least 5 characters long"
            },
            user_confirm_password: {
                required: "Please enter Password",
                minlength: "Your password must be at least 5 characters long"
            },
            email: "Please enter a valid email address"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});