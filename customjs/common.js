

$(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
});

$(document).on('keyup', "[type=number], [type=email]", function (e) {
    if ($(this).attr('maxlength')) {
        if (this.value.length > this.maxLength) {
            this.value = this.value.slice(0, this.maxLength);
        }
    }
});

$(document).ready(function(){
    toastr.options = {
        timeOut : 0,
        extendedTimeOut : 100,
        tapToDismiss : true,
        debug : false,
        fadeOut: 10,
        positionClass : "toast-top-center"
    };

    // Show the UI blocker when an AJAX request starts
    $(document).ajaxStart(function() {
        $('#uiBlocker').show();
    });

    // Hide the UI blocker when an AJAX request completes (whether it succeeds or fails)
    $(document).ajaxStop(function() {
        setTimeout(function(){
            $('#uiBlocker').hide();
        },500);
    });

    // Alternatively, you can use ajaxComplete for specific handling
    $(document).ajaxComplete(function(event, xhr, settings) {
        setTimeout(function(){
            $('#uiBlocker').hide();
        },500);
        
    });
});

function SendAjaxRequestToServer(
    requestType = "GET",
    url,
    data,
    dataType = "json",
    callBack = "",
    spinner_button,
    submit_button
) {
    // console.log(data, url, dataType);
    $.ajax({
        type: requestType,
        url: base_url+url,
        data: data,
        dataType: dataType,
        processData: false,
        contentType: false,
        beforeSend: function (response) {
            $(spinner_button).toggle();
            $(submit_button).attr('disabled', true);
            // $(submit_button).toggle();
        },
        success: function (response) {
            if (typeof callBack === "function") {
                callBack(response);
            } else {
                console.log("error");
            }
        },
        complete: function (data) {
            $(spinner_button).toggle();
            $(submit_button).attr('disabled', false);
            // $(submit_button).toggle();
        },
        error: function (response) {
            if (typeof callBack === "function") {
                callBack(response);
            } else {
                console.log("error");
            }
        },
    });
}

