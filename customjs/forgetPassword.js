function togglePasswordVisibility(fieldId, iconElement) {
    var field = document.getElementById(fieldId);
    var icon = iconElement.querySelector('i');

    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

$('#forgetBtn').click(function (e) {
    
    let form = document.getElementById('forgetPasswordForm');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/sendForgetOtp';
    SendAjaxRequestToServer(type, url, data, '', forgotPasswordResponse, '', 'forgetBtn');

});

function forgotPasswordResponse(response) {
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });

        $('#forgetSection').addClass('d-none');
        $('#otpSection').removeClass('d-none');
        $('#uiBlocker').hide();

        

    }

    if (response.status == 402) {

        error = response.message;

    } else {

        error = response.responseJSON.message;
        var is_invalid = response.responseJSON.errors;

        $.each(is_invalid, function (key) {
            // Assuming 'key' corresponds to the form field name
            var inputField = $('[name="' + key + '"]');
            // Add the 'is-invalid' class to the input field's parent or any desired container
            inputField.addClass('is-invalid');

        });
    }
    toastr.error(error, '', {
        timeOut: 3000
    });
}


$('#VerifyOtpBtn').click(function (e) {
    $('#uiBlocker').show();
    let form = document.getElementById('forgetPasswordForm');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/verifyForgetOtp';
    SendAjaxRequestToServer(type, url, data, '', verifyForgetOtpResponse, '', 'forgetBtn');

});

function verifyForgetOtpResponse(response) {
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });

        $('#otpSection').addClass('d-none');
        $('#passwordSection').removeClass('d-none');
        $('#uiBlocker').hide();

        

    }

    if (response.status == 402) {

        error = response.message;

    } else {

        error = response.responseJSON.message;
        var is_invalid = response.responseJSON.errors;

        $.each(is_invalid, function (key) {
            // Assuming 'key' corresponds to the form field name
            var inputField = $('[name="' + key + '"]');
            // Add the 'is-invalid' class to the input field's parent or any desired container
            inputField.addClass('is-invalid');

        });
    }
    toastr.error(error, '', {
        timeOut: 3000
    });
}


$('#updatePassBtn').click(function (e) {
    $('#uiBlocker').show();
    
    let form = document.getElementById('forgetPasswordForm');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/updateForgetPassword';
    SendAjaxRequestToServer(type, url, data, '', updateForgetPasswordResponse, '', 'forgetBtn');

});

function updateForgetPasswordResponse(response) {
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });

        
        
        $('#uiBlocker').hide();

        setTimeout(function(){
            window.location = '/login'
        }, 3000);

        

    }

    if (response.status == 402) {

        error = response.message;

    } else {

        error = response.responseJSON.message;
        var is_invalid = response.responseJSON.errors;

        $.each(is_invalid, function (key) {
            // Assuming 'key' corresponds to the form field name
            var inputField = $('[name="' + key + '"]');
            // Add the 'is-invalid' class to the input field's parent or any desired container
            inputField.addClass('is-invalid');

        });
    }
    toastr.error(error, '', {
        timeOut: 3000
    });
}