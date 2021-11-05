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
            },
            user_checkbox : "required"

            
        },

        messages: {
            user_fullname: "Please enter Full Name",
            user_password: {
                required: "Please enter Password",
                minlength: "Your password must be at least 5 characters long"
            },
            user_confirm_password: {
                required: "Please enter Password",
                minlength: "Your password must be at least 5 characters long"
            },
            user_email: "Please enter a valid email address",
            user_checkbox: "Please check terms and Condtions"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#dashboard_form").validate({


        rules: {

            room_type: {
                required: true,
            },
            room_start_date: {
                required: true
            },
            room_end_date: {
                required: true
            },
            room_no_of_adult: {
                required: true
            },
            room_no_of_children: {
                required: true
            }


        },

        messages: {
            room_type: "Please Select Room Type",
            room_start_date: "Please Select Date",
            room_end_date: "Please Select Date",
            room_no_of_adult: "Please Select Number of Adult",
            room_no_of_children: "Please Select Number of Children",

        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#front_forgotPassword").validate({

        rules: {
            user_email: {
                required: true,
                email: true
            }

        },
        messages: {
            user_email: "Please enter a valid email address"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#front_register").validate({

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
            },
            user_checkbox : "required"

            
        },

        messages: {
            user_fullname: "Please enter Full Name",
            user_password: {
                required: "Please enter Password",
                minlength: "Your password must be at least 5 characters long"
            },
            user_confirm_password: {
                required: "Please enter Password",
                minlength: "Your password must be at least 5 characters long"
            },
            user_email: "Please enter a valid email address",
            user_checkbox: "Please check terms and Condtions"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    

    
});


function registrationFormReset(){
    $('#front_register')[0].reset();
}