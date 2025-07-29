<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Auto Jazeera</title>
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('web/bikes/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/bikes/css/bike_home.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Add these links in the <head> section of your HTML document -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" /> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('web/images/Jazeera App logo.png') }}" type="image/x-icon" sizes="512x512">

</head>
<style>
    .subscription-card {
        background-color: #2e2b45;
        /* Card background color */
        border: 1px solid #6c6783;
        /* Border color */
        border-radius: 10px;
        padding: 20px;
        color: #fff;
    }


    .card-header i {
        margin-right: 8px;
        color: #fd5631;
        /* Icon color */
        font-size: 18px;
    }

    .card-body {
        margin-bottom: 15px;
    }

    .plan-name {
        font-size: 22px;
        color: #fd5631;
        /* Highlighted text color */
        margin: 0;
    }

    .plan-name .price {
        font-weight: bold;
    }

    .plan-name .duration {
        font-size: 14px;
        color: #a09fb5;
    }

    .next-billing {
        font-size: 12px;
        color: #a09fb5;
        margin-top: 8px;
    }

    .card-footer {
        display: flex;
        gap: 10px;
        justify-content: space-between;
        align-items: center;
    }

    /*
    .btn {
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    } */

    .change-plan {
        background-color: #fd5631;
        color: #fff;
        transition: background-color 0.3s;
    }

    .change-plan:hover {
        background-color: #e65028;
    }

    .cancel-plan {
        background-color: #2e2b45;
        color: #fff;
        border: 1px solid #6c6783;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .cancel-plan:hover {
        background-color: #393656;
        border-color: #fd5631;
    }

    .credit-card {
        background-color: #2e2b45;
        border: 1px solid #6c6783;
        border-radius: 10px;
        width: 300px;
        padding: 20px;
        margin-bottom: 20px;
        position: relative;
    }


    .card-logo {
        font-size: 24px;
        font-weight: bold;
        color: #fff;
    }

    .card-actions i {
        font-size: 18px;
        margin-left: 10px;
        cursor: pointer;
    }

    .edit-icon {
        color: #fd5631;
    }

    .delete-icon {
        color: #e74c3c;
    }

    .card-number {
        font-size: 20px;
        letter-spacing: 3px;
        margin-bottom: 15px;
    }

    .last-digits {
        font-weight: bold;
    }

    .card-details {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
    }

    .card-details span {
        font-size: 12px;
        color: #a09fb5;
    }

    .card-holder p,
    .card-expiry p {
        margin: 0;
        font-size: 14px;
        font-weight: bold;
    }

    .add-card-btn {
        background-color: #fd5631;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .add-card-btn i {
        font-size: 18px;
    }

    .add-card-btn:hover {
        background-color: #e65028;
    }

    /*
    th {
        color: #FD5631 !important;
    }

    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border: none !important;
    }

    .col-form-label {
        font-family: Maven Pro;
        font-size: 17.6px;
        font-weight: 400;
        line-height: 20.68px;
        text-align: left;
        color: #FD5631;
    }
    */
</style>
<style>
    .profile-card {
        padding: 20px;
        background-color: #282435;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: 20px auto;
    }

    .profile-image {
        flex-shrink: 0;
        margin-right: 15px;
    }

    .profile-image img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 2px solid #ddd;
        object-fit: cover;
    }

    hr {
        border-top: 1px solid #ddd;
    }

    .upload-box {

        border: 2px dashed #6c6783;
        /* Dashed border color */
        border-radius: 10px;
        /* Rounded corners */
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: #a09fb5;
        /* Text color */
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        /* Smooth hover effect */
    }

    .upload-box:hover {
        border-color: #fd5631;
        /* Border color on hover */
        color: #fd5631;
        /* Text color on hover */
    }


    #brochurePreview img {
        max-width: 50px;
        /* Set the maximum width */
        max-height: 50px;
        /* Set the maximum height */
        width: auto;
        /* Maintain aspect ratio */
        height: auto;
        /* Maintain aspect ratio */
    }

    #brochurePreview1 img {
        max-width: 50px;
        /* Set the maximum width */
        max-height: 50px;
        /* Set the maximum height */
        width: auto;
        /* Maintain aspect ratio */
        height: auto;
        /* Maintain aspect ratio */
    }

    #brochurePreview2 img {
        max-width: 50px;
        /* Set the maximum width */
        max-height: 50px;
        /* Set the maximum height */
        width: auto;
        /* Maintain aspect ratio */
        height: auto;
        /* Maintain aspect ratio */
    }

    #brochurePreview3 img {
        max-width: 50px;
        /* Set the maximum width */
        max-height: 50px;
        /* Set the maximum height */
        width: auto;
        /* Maintain aspect ratio */
        height: auto;
        /* Maintain aspect ratio */
    }

    .image-preview img {
        max-width: 50px;
        /* Set the maximum width */
        max-height: 50px;
        /* Set the maximum height */
        width: auto;
        /* Maintain aspect ratio */
        height: auto;
        /* Maintain aspect ratio */
    }

    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border: none !important;
    }

    .modal-content {
        background-color: #1F1B2D !important;
    }

    .col-form-label {
        font-family: Maven Pro;
        font-size: 17.6px;
        font-weight: 400;
        line-height: 20.68px;
        text-align: left;
        color: #281F48;
    }

    th,
    td {
        vertical-align: middle;
        /* Aligns text vertically in the center */
        white-space: nowrap;
        /* Prevents text from wrapping */
    }

    .color-box {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 2px solid #333;
    }

    .btn-close {
        --bs-btn-close-color: #000;
        --bs-btn-close-bg: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e);
        --bs-btn-close-opacity: 0.5;
        --bs-btn-close-hover-opacity: 0.75;
        --bs-btn-close-focus-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        --bs-btn-close-focus-opacity: 1;
        --bs-btn-close-disabled-opacity: 0.25;
        --bs-btn-close-white-filter: invert(1) grayscale(100%) brightness(200%);
        box-sizing: content-box;
        width: 1em;
        height: 1em;
        padding: .25em .25em;
        color: var(--bs-btn-close-color);
        background: #ffffff var(--bs-btn-close-bg) center / 1em auto no-repeat !important;
        border: 0;
        border-radius: .375rem;
        opacity: 1 !important;
    }

    a {
        text-decoration: none;
    }

    .step-header {
        font-weight: bold;
        margin-bottom: 20px;
    }

    .step-content {
        display: none;
    }

    .step-content.active {
        display: block;
    }

    .char-counter {
        text-align: right;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .carousel-control-next-icon {
        background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e);
    }

    ;
    height:60px;
    width:60px;
    }

    .step-header {
        color: #FD5631;
    }

    .alert {
        background-color: unset;
        border: none;
        color: red;
    }

    #goToTop,
    #goToBottom {
        position: fixed;
        right: 20px;
        padding: 10px;
        padding-left: 15px;
        padding-right: 15px;
        font-size: 20px;
        background-color: #F40000 !important;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        opacity: 0;
        /* Start hidden */
        visibility: hidden;
        /* Prevent interaction when hidden */
        transition: opacity 0.3s ease, visibility 0.3s ease;
        /* Smooth transition */
    }

    #goToTop {
        bottom: 80px;
    }

    #goToBottom {
        bottom: 20px;
    }

    #goToTop:hover,
    #goToBottom:hover {
        background-color: #F40000 !important;
    }

    /* Show buttons with fade-in effect */
    #goToTop.show,
    #goToBottom.show {
        opacity: 1;
        visibility: visible;
    }
</style>
<style>
    /* Add padding to the select2 container */
    .select2-container--default .select2-selection--single {
        padding: 10px 20px;
        /* Adjust top/bottom and left/right padding */
        border: 1px solid #ddd;
        /* Optional: Add a border for better visibility */
        border-radius: 5px;
        /* Optional: Add rounded corners */
        height: 40px;
        /* Let it adapt to the padding */
    }

    /* Add padding to the search box inside the dropdown */
    .select2-container--default .select2-search--dropdown .select2-search__field {
        padding: 10px 20px;
        /* Adjust top/bottom and left/right padding */
        font-size: 14px;
        /* Optional: Adjust font size */
    }

    /* Dropdown item styling */
    .select2-container--default .select2-results__option {
        padding: 10px 20px;
        /* Add padding to dropdown items */
    }
</style>

<body style="background-color: #FBFBFB !important;">
    @include('layout.firebase')
    @if (Request::is('superadmin/*'))
        @include('layout.website_layout.bikes.nav')
    @else
        @include('layout.website_layout.bikes.nav')
    @endif
    <!-- Header -->

    <!-- Banner -->
    <?php
    
    use App\Models\User;
    
    $provinces = \App\Models\Province::all();
    $users = User::where('role', 1)->get();
    
    ?>
    @yield('content')

    <!-- Section -->
    @if (!Request::is('superadmin/*'))
        @include('layout.website_layout.bikes.footer')
    @endif
    @include('superadmin.modal.main_modal')
    @include('superadmin.modal.supperadmin_add_user')
    @include('superadmin.modal.dealer_user_modal')


    <button id="goToTop" onclick="scrollToTop()">
        <i class="bi bi-arrow-up"></i>
    </button>
    <button id="goToBottom" onclick="scrollToBottom()">
        <i class="bi bi-arrow-down"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        const goToTopButton = document.getElementById('goToTop');
        const goToBottomButton = document.getElementById('goToBottom');

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function scrollToBottom() {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        }

        window.addEventListener('scroll', () => {
            const scrollPosition = window.scrollY;
            const scrollHeight = document.body.scrollHeight;
            const clientHeight = window.innerHeight;

            // Show or hide "Go to Top" button
            if (scrollPosition > 200) {
                goToTopButton.classList.add('show');
            } else {
                goToTopButton.classList.remove('show');
            }

            // Show or hide "Go to Bottom" button
            if (scrollPosition + clientHeight < scrollHeight - 100) {
                goToBottomButton.classList.add('show');
            } else {
                goToBottomButton.classList.remove('show');
            }
        });

        $(document).on('click', '.cancel', function(e) {

            $('#deleted_id').val($(this).data('id'));

        });
        $(document).on('click', '.roleid', function(e) {
            const dealershipNameRow = document.getElementById('dealershipNameRow');
            const dealershipNamedeaderRow = document.getElementById('dealershipNamedeaderRow');
            const dealershipNamedeaderRow1 = document.getElementById('dealershipNamedeaderRow1');
            const dealershipNamedeadereditRow = document.getElementById('dealershipNamedeadereditRow');
            const dealershipNamedeadereditRow1 = document.getElementById('dealershipNamedeadereditRow1');
            $('#role_id').val($(this).data('role'));
            var role = $(this).data('role')
            if (role === 0) {
                // If role is 0, hide the dealership name row
                dealershipNameRow.style.display = 'none';
                dealershipNamedeaderRow1.style.display = 'none';
                dealershipNamedeadereditRow1.style.display = 'none';
            }
            if (role === 1) {
                // If role is 0, hide the dealership name row

                dealershipNamedeaderRow.style.display = 'none';
                dealershipNamedeadereditRow1.style.display = 'none';
            }

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#addDealerForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this); // Includes all form inputs, including the file

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    dataType: 'json',
                    processData: false, // Prevent jQuery from processing `FormData`
                    contentType: false, // Ensure proper headers for `FormData`
                    success: function(response) {
                        console.log('AJAX success response:', response);
                        if (response.success) {
                            $('#addDealerModal').modal('hide');
                            alert('Data added successfully!');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul>';

                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                                $('[name=' + key + ']').next('.alert').remove();
                                $('[name=' + key + ']').after(
                                    '<div class="alert alert-danger">' + value[0] +
                                    '</div>');
                            });
                            errorHtml += '</ul>';
                            $('#addDealerModal .modal-body').prepend(errorHtml);
                        }
                    }
                });

                $('#superadmin_add_userForm').on('submit', function(e) {
                    e.preventDefault();

                    let formData = new FormData(
                        this); // Includes all form inputs, including the file

                    $.ajax({
                        url: $(this).attr('action'),
                        method: $(this).attr('method'),
                        data: formData,
                        dataType: 'json',
                        processData: false, // Prevent jQuery from processing `FormData`
                        contentType: false, // Ensure proper headers for `FormData`
                        success: function(response) {
                            console.log('AJAX success response:', response);
                            if (response.success) {
                                $('#superadmin_add_userModal').modal('hide');
                                alert('Data added successfully!');
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                let errorHtml = '<ul>';

                                $.each(errors, function(key, value) {
                                    errorHtml += '<li>' + value[0] + '</li>';
                                    $('[name=' + key + ']').next('.alert')
                                        .remove();
                                    $('[name=' + key + ']').after(
                                        '<div class="alert alert-danger">' +
                                        value[0] + '</div>');
                                });
                                errorHtml += '</ul>';
                                $('#superadmin_add_userModal .modal-body').prepend(
                                    errorHtml);
                            }
                        }
                    });
                });


            });
        });
        $(document).ready(function() {
            $('#addappointmentForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    dataType: 'json', // Specify JSON to handle the response correctly
                    cache: false,
                    success: function(response) {
                        console.log('AJAX success response:', response); // Debug

                        if (response.success) {
                            $('#appoinment').modal('hide'); // Close modal

                            location.reload();
                        }
                        if (response.warning) {
                            $('#appoinment').modal('hide'); // Close modal

                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Validation error
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul>';

                            $.each(errors, function(key, value) {
                                errorHtml +=
                                    '<li>' + value[0] +
                                    '</li>'; // Display each error
                                // Show the error next to each field
                                $('[name=' + key + ']').next('.alert')
                                    .remove(); // Remove previous errors
                                $('[name=' + key + ']').after(
                                    '<div class="alert alert-danger">' +
                                    value[0] + '</div>');
                            });
                            errorHtml += '</ul>';
                            $('#appoinment .modal-body').prepend(
                                errorHtml); // Show errors at top of modal
                        }
                    }
                });
            });
            $('#inquiryform').on('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    dataType: 'json', // Specify JSON to handle the response correctly
                    cache: false,
                    success: function(response) {
                        console.log('AJAX success response:', response); // Debug

                        if (response.success) {
                            $('#appoinment').modal('hide'); // Close modal
                            alert('Data added successfully!');
                            location.reload();
                        }
                        if (response.warning) {
                            $('#appoinment').modal('hide'); // Close modal
                            alert('already in list');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Validation error
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul>';

                            $.each(errors, function(key, value) {
                                errorHtml +=
                                    '<li>' + value[0] +
                                    '</li>'; // Display each error
                                // Show the error next to each field
                                $('[name=' + key + ']').next('.alert')
                                    .remove(); // Remove previous errors
                                $('[name=' + key + ']').after(
                                    '<div class="alert alert-danger">' +
                                    value[0] + '</div>');
                            });
                            errorHtml += '</ul>';
                            $('#appoinment .modal-body').prepend(
                                errorHtml); // Show errors at top of modal
                        }
                    }
                });
            });
            $('#testdriveform').on('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    dataType: 'json', // Specify JSON to handle the response correctly
                    cache: false,
                    success: function(response) {
                        console.log('AJAX success response:', response); // Debug

                        if (response.success) {
                            $('#appoinment').modal('hide'); // Close modal
                            alert('Data added successfully!');
                            location.reload();
                        }
                        if (response.warning) {
                            $('#appoinment').modal('hide'); // Close modal
                            alert('already in list');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Validation error
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul>';

                            $.each(errors, function(key, value) {
                                errorHtml +=
                                    '<li>' + value[0] +
                                    '</li>'; // Display each error
                                // Show the error next to each field
                                $('[name=' + key + ']').next('.alert')
                                    .remove(); // Remove previous errors
                                $('[name=' + key + ']').after(
                                    '<div class="alert alert-danger">' +
                                    value[0] + '</div>');
                            });
                            errorHtml += '</ul>';
                            $('#appoinment .modal-body').prepend(
                                errorHtml); // Show errors at top of modal
                        }
                    }
                });
            });
            $('#informationform').on('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    dataType: 'json', // Specify JSON to handle the response correctly
                    cache: false,
                    success: function(response) {
                        console.log('AJAX success response:', response); // Debug

                        if (response.success) {
                            $('#appoinment').modal('hide'); // Close modal

                            location.reload();
                        }
                        if (response.warning) {
                            $('#appoinment').modal('hide'); // Close modal

                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Validation error
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul>';

                            $.each(errors, function(key, value) {
                                errorHtml +=
                                    '<li>' + value[0] +
                                    '</li>'; // Display each error
                                // Show the error next to each field
                                $('[name=' + key + ']').next('.alert')
                                    .remove(); // Remove previous errors
                                $('[name=' + key + ']').after(
                                    '<div class="alert alert-danger">' +
                                    value[0] + '</div>');
                            });
                            errorHtml += '</ul>';
                            $('#appoinment .modal-body').prepend(
                                errorHtml); // Show errors at top of modal
                        }
                    }
                });
            });
            $('#emailfriendform').on('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    dataType: 'json', // Specify JSON to handle the response correctly
                    cache: false,
                    success: function(response) {
                        console.log('AJAX success response:', response); // Debug

                        if (response.success) {
                            $('#appoinment').modal('hide'); // Close modal
                            alert('Data added successfully!');
                            location.reload();
                        }
                        if (response.warning) {
                            $('#appoinment').modal('hide'); // Close modal
                            alert('already in list');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Validation error
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul>';

                            $.each(errors, function(key, value) {
                                errorHtml +=
                                    '<li>' + value[0] +
                                    '</li>'; // Display each error
                                // Show the error next to each field
                                $('[name=' + key + ']').next('.alert')
                                    .remove(); // Remove previous errors
                                $('[name=' + key + ']').after(
                                    '<div class="alert alert-danger">' +
                                    value[0] + '</div>');
                            });
                            errorHtml += '</ul>';
                            $('#appoinment .modal-body').prepend(
                                errorHtml); // Show errors at top of modal
                        }
                    }
                });
            });
        });
    </script>
    <script>
        function showStep(step) {
            document.querySelectorAll('.step-content').forEach((content) => {
                content.classList.remove('active');
            });
            document.getElementById(`step${step}`).classList.add('active');
        }

        function nextStep(step) {
            showStep(step);
        }

        function previousStep(step) {
            showStep(step);
        }

        function showMore(featureId) {
            const moreOptions = document.getElementById(featureId);
            moreOptions.classList.toggle('d-none');
        }

        function handleFiles(files) {
            const previewContainer = document.getElementById('previewContainer');
            const maxFiles = 5; // Limit the number of uploads
            const maxImageSize = 8 * 1024 * 1024; // 8 MB
            const maxVideoSize = 10 * 1024 * 1024; // 10 MB
            const allowedVideoFormats = /\.(mp4|mov)$/i;

            // Ensure previous previews aren't cleared and limit total file count
            const currentPreviews = previewContainer.children.length;
            if (currentPreviews >= maxFiles) {
                alert(`Maximum of ${maxFiles} files can be uploaded.`);
                return;
            }

            Array.from(files).forEach((file) => {
                if (currentPreviews >= maxFiles) {
                    alert(`Maximum of ${maxFiles} files can be uploaded.`);
                    return;
                }

                // Validate file size and type
                if (file.type.startsWith('image/') && file.size <= maxImageSize) {
                    // Preview image
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail me-2 mb-2';
                        img.style.width = '150px';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else if (allowedVideoFormats.test(file.name) && file.size <= maxVideoSize) {
                    // Preview video
                    const video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    video.className = 'me-2 mb-2';
                    video.style.width = '150px';
                    previewContainer.appendChild(video);
                } else {
                    // Invalid file
                    const error = document.createElement('p');
                    error.textContent = `File "${file.name}" is invalid or exceeds size limits.`;
                    error.className = 'text-danger';
                    previewContainer.appendChild(error);
                }
            });
        }

        function handleDrop(event) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            handleFiles(files);
        }
        document.getElementById('province').addEventListener('change', function() {
            var provinceId = this.value;

            var citySelect = document.getElementById('city');

            // Clear the current city options
            citySelect.innerHTML = '<option value="" selected>Any</option>';

            // Fetch cities based on selected province
            if (provinceId) {
                fetch(`/getCities/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(city => {
                            var option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);

                        });

                    })
                    .catch(error => console.error('Error fetching cities:', error));
            }
        });
        document.getElementById('makecompanydata').addEventListener('change', function() {
            var makeId = this.value;
            //alert(makeId);
            var modelSelect = document.getElementById('model');

            // Clear the current city options
            modelSelect.innerHTML = '<option value="" selected>Any</option>';

            // Fetch cities based on selected province
            if (makeId) {
                fetch(`/getmodels/${makeId}`)
                    .then(response => response.json())
                    .then(data => {
                        //console.log(data);
                        data.forEach(model => {
                            var option = document.createElement('option');
                            option.value = model.id;
                            option.textContent = model.name;
                            modelSelect.appendChild(option);

                        });

                    })
                    .catch(error => console.error('Error fetching models:', error));
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#adForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Clear previous error messages
                $('.alert').remove();

                $.ajax({
                    url: $(this).attr('action'), // The action URL from your form
                    method: $(this).attr('method'), // Form method (POST)
                    data: new FormData(this), // Send form data
                    contentType: false, // Prevent jQuery from overriding content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: 'json', // Expect JSON response
                    success: function(response) {
                        if (response.success) {
                            // If the response indicates success, refresh the page
                            //location.reload(); // Refresh the page
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Check for validation errors
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul class="alert alert-danger">';

                            // Clear previous error messages
                            $('.alert').remove();

                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] +
                                    '</li>'; // Display each error
                                // Show the error next to each field
                                $('[name=' + key + ']').next('.alert')
                                    .remove(); // Remove previous error messages
                                $('[name=' + key + ']').after(
                                    '<div class="alert alert-danger">' + value[0] +
                                    '</div>');
                            });

                            errorHtml += '</ul>';
                            $('#adForm').prepend(
                                errorHtml); // Show errors at the top of the form
                        }
                    }
                });
            });
        });
    </script>
    <script>
        function handleDocumentUpload(input, previewId) {
            const previewElement = document.getElementById(previewId);

            // Clear previous messages
            previewElement.textContent = '';

            // Check if a file was selected
            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Check if the file is a PDF
                if (file.type === "application/pdf") {
                    if (file.size <= 16 * 1024 * 1024) { // Check if file size is less than or equal to 16 MB
                        // Show the file name in the preview element
                        previewElement.textContent = `Uploaded: ${file.name}`;
                    } else {
                        // If the file size exceeds 16 MB, show an error message
                        previewElement.textContent = 'File size exceeds 16 MB. Please upload a smaller file.';
                        previewElement.classList.add('text-danger');
                    }
                } else {
                    // If the file is not a PDF, show an error message
                    previewElement.textContent = 'Please upload a valid PDF file.';
                    previewElement.classList.add('text-danger');
                }
            }
        }
    </script>
    <script>
        function handleimageUpload(input, previewElementId) {
            const previewElement = document.getElementById(previewElementId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Check if the file is an image
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = function() {
                        // If it's a valid image, display it
                        previewElement.innerHTML = '';
                        previewElement.appendChild(img);
                    };
                    img.onerror = function() {
                        // Handle the case where the file is not a valid image
                        previewElement.textContent = 'Uploaded file is not a valid image.';
                    };
                };

                reader.readAsDataURL(file);
            } else {
                previewElement.textContent = 'No file uploaded.';
            }
        }

        function handleimageUpload3(input, previewElementId) {
            const previewElement = document.getElementById(previewElementId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Check if the file is an image
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = function() {
                        // If it's a valid image, display it
                        previewElement.innerHTML = '';
                        previewElement.appendChild(img);
                    };
                    img.onerror = function() {
                        // Handle the case where the file is not a valid image
                        previewElement.textContent = 'Uploaded file is not a valid image.';
                    };
                };

                reader.readAsDataURL(file);
            } else {
                previewElement.textContent = 'No file uploaded.';
            }
        }

        function handleimageUpload1(input, previewElementId) {
            const previewElement = document.getElementById(previewElementId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Check if the file is an image
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = function() {
                        // If it's a valid image, display it
                        previewElement.innerHTML = '';
                        previewElement.appendChild(img);
                    };
                    img.onerror = function() {
                        // Handle the case where the file is not a valid image
                        previewElement.textContent = 'Uploaded file is not a valid image.';
                    };
                };

                reader.readAsDataURL(file);
            } else {
                previewElement.textContent = 'No file uploaded.';
            }
        }
        $(document).ready(function() {
            $('.datatable').DataTable({
                paging: false, // Disable pagination
                lengthChange: false, // Hide page length dropdown
                searching: true, // Enable the search bar
                info: false, // Hide table information
                ordering: true, // Disable column ordering (optional, can be removed if sorting is needed)
                language: {
                    search: "Search: " // Customize the search bar label
                }
            });
        });
    </script>
    <script>
        function validateStep1() {
            const dealerSelect = document.getElementById('dealerSelect');
            const errorContainer = dealerSelect.closest('.mb-3').querySelector('.alert');

            if (!dealerSelect.value) {
                if (!errorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select a dealer.';
                    dealerSelect.closest('.mb-3').appendChild(errorDiv);
                }
                return false;
            }
            // Clear existing errors
            if (errorContainer) errorContainer.remove();
            return true;
        }

        function validateStep2() {
            const fields = [{
                    id: 'adTitle',
                    message: 'Please enter an Ad Title.'
                },
                {
                    id: 'vehicleCondition',
                    message: 'Please select Vehicle Condition.'
                },
                {
                    id: 'assembly',
                    message: 'Please select Assembly.'
                },
            ];
            let isValid = true;

            // Validate fields
            fields.forEach(({
                id,
                message
            }) => {
                const field = document.getElementById(id);
                const errorContainer = field.closest('.mb-3').querySelector('.alert');
                if (!field.value.trim()) {
                    if (!errorContainer) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'alert alert-danger mt-1';
                        errorDiv.textContent = message;
                        field.closest('.mb-3').appendChild(errorDiv);
                    }
                    isValid = false;
                } else if (errorContainer) {
                    errorContainer.remove();
                }
            });

            // Validate radio buttons
            const dealerType = document.querySelector('input[name="dealerType"]:checked');
            const radioErrorContainer = document
                .querySelector('input[name="dealerType"]')
                .closest('.mb-3')
                .querySelector('.alert');
            if (!dealerType) {
                if (!radioErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select a Dealer Type.';
                    document
                        .querySelector('input[name="dealerType"]')
                        .closest('.mb-3')
                        .appendChild(errorDiv);
                }
                isValid = false;
            } else if (radioErrorContainer) {
                radioErrorContainer.remove();
            }

            return isValid;
        }

        function validateStep3() {
            const priceInput = document.getElementById('priceInput');
            const errorContainer = priceInput.closest('.mb-3').querySelector('.alert');

            if (!priceInput.value || parseFloat(priceInput.value) <= 0) {
                if (!errorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please enter a valid price.';
                    priceInput.closest('.mb-3').appendChild(errorDiv);
                }
                return false;
            }
            if (errorContainer) errorContainer.remove();
            return true;
        }

        function validateStep4() {
            let isValid = true;

            // Validate Make
            const makeSelect = document.getElementById('makecompanydata');
            const makeErrorContainer = makeSelect.closest('.mb-3').querySelector('.alert');
            if (!makeSelect.value) {
                if (!makeErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select a Make.';
                    makeSelect.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (makeErrorContainer) {
                makeErrorContainer.remove();
            }

            // Validate Model
            const modelSelect = document.getElementById('model');
            const modelErrorContainer = modelSelect.closest('.mb-3').querySelector('.alert');
            if (!modelSelect.value) {
                if (!modelErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select a Model.';
                    modelSelect.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (modelErrorContainer) {
                modelErrorContainer.remove();
            }

            // Validate Year
            const yearSelect = document.getElementById('years');
            const yearErrorContainer = yearSelect.closest('.mb-3').querySelector('.alert');
            if (!yearSelect.value) {
                if (!yearErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select a Year.';
                    yearSelect.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (yearErrorContainer) {
                yearErrorContainer.remove();
            }

            // Validate Mileage
            const mileageInput = document.getElementById('mileage');
            const mileageErrorContainer = mileageInput.closest('.mb-3').querySelector('.alert');
            if (!mileageInput.value || parseFloat(mileageInput.value) < 0) {
                if (!mileageErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please enter a valid Mileage (greater than or equal to 0).';
                    mileageInput.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (mileageErrorContainer) {
                mileageErrorContainer.remove();
            }

            // Validate Body Type
            const bodyTypeSelect = document.getElementById('bodyType');
            const bodyTypeErrorContainer = bodyTypeSelect.closest('.mb-3').querySelector('.alert');
            if (!bodyTypeSelect.value) {
                if (!bodyTypeErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select a Body Type.';
                    bodyTypeSelect.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (bodyTypeErrorContainer) {
                bodyTypeErrorContainer.remove();
            }
            $(document).ready(function() {
                $('#bodyType').select2({
                    placeholder: "", // Empty placeholder to remove it
                    allowClear: false // Prevents the clear button from showing
                });
            });
            // Validate Door Count
            const doorCountSelect = document.getElementById('doorCount');
            const doorCountErrorContainer = doorCountSelect.closest('.mb-3').querySelector('.alert');
            if (!doorCountSelect.value) {
                console.log('data', doorCountErrorContainer)
                if (!doorCountErrorContainer) {

                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select a Door Count.';
                    doorCountSelect.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (doorCountErrorContainer) {
                doorCountErrorContainer.remove();
            }

            // Validate Fuel Type
            const fuelTypeSelect = document.getElementById('fuelType');
            const fuelTypeErrorContainer = fuelTypeSelect.closest('.mb-3').querySelector('.alert');
            if (!fuelTypeSelect.value) {
                if (!fuelTypeErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select a Fuel Type.';
                    fuelTypeSelect.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (fuelTypeErrorContainer) {
                fuelTypeErrorContainer.remove();
            }

            // Validate Seating Capacity
            const seatingCapacitySelect = document.getElementById('seatingCapacity');
            const seatingCapacityErrorContainer = seatingCapacitySelect.closest('.mb-3').querySelector('.alert');
            if (!seatingCapacitySelect.value) {
                if (!seatingCapacityErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select a Seating Capacity.';
                    seatingCapacitySelect.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (seatingCapacityErrorContainer) {
                seatingCapacityErrorContainer.remove();
            }

            // Validate Engine Capacity
            const engineCapacitySelect = document.getElementById('engineCapacity');
            const engineCapacityErrorContainer = engineCapacitySelect.closest('.mb-3').querySelector('.alert');
            if (!engineCapacitySelect.value) {
                if (!engineCapacityErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select an Engine Capacity.';
                    engineCapacitySelect.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (engineCapacityErrorContainer) {
                engineCapacityErrorContainer.remove();
            }

            // Validate Transmission
            const transmissionSelect = document.getElementById('transmission');
            const transmissionErrorContainer = transmissionSelect.closest('.mb-3').querySelector('.alert');
            if (!transmissionSelect.value) {
                if (!transmissionErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select a Transmission type.';
                    transmissionSelect.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (transmissionErrorContainer) {
                transmissionErrorContainer.remove();
            }

            // Validate Drive Type
            const driveTypeSelect = document.getElementById('driveType');
            const driveTypeErrorContainer = driveTypeSelect.closest('.mb-3').querySelector('.alert');
            if (!driveTypeSelect.value) {
                if (!driveTypeErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select a Drive Type.';
                    driveTypeSelect.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (driveTypeErrorContainer) {
                driveTypeErrorContainer.remove();
            }

            // Validate Exterior Color
            const colorSelect = document.getElementById(
                'driveType'); // Note: This ID seems incorrect; it should be the ID for the color select
            const colorErrorContainer = colorSelect.closest('.mb-3').querySelector('.alert');
            if (!colorSelect.value) {
                if (!colorErrorContainer) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger mt-1';
                    errorDiv.textContent = 'Please select an Exterior Color.';
                    colorSelect.closest('.mb-3').appendChild(errorDiv);
                }
                isValid = false;
            } else if (colorErrorContainer) {
                colorErrorContainer.remove();
            }


            return isValid;
        }

        function validateStep5() {
            let isValid = true;

            // Function to validate features
            function validateFeatureSection(featureType) {
                const features = document.querySelectorAll(`input[name^="Features['${featureType}']"]`);
                const errorContainer = document.querySelector(`.feature-section h5:contains("${featureType}")`).closest(
                    '.feature-section').querySelector('.alert');

                // Check if at least one feature is selected
                const isChecked = Array.from(features).some(feature => feature.checked);

                // If no feature is selected, show an error
                if (!isChecked) {
                    if (!errorContainer) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'alert alert-danger mt-1';
                        errorDiv.textContent = `Please select at least one ${featureType} feature.`;
                        features[0].closest('.feature-section').appendChild(errorDiv);
                    }
                    isValid = false;
                } else if (errorContainer) {
                    errorContainer.remove();
                }
            }

            // Validate each feature section
            validateFeatureSection('Exterior');
            validateFeatureSection('Interior');
            validateFeatureSection('Safety');

            return isValid;
        }

        function nextStep(step) {
            let isValid = true;

            if (step <= 5) {
                if (step === 2) isValid = validateStep1();
                else if (step === 3) isValid = validateStep2();
                else if (step === 4) isValid = validateStep3();
                else if (step === 5) isValid = validateStep4();
            }
            if (step > 4) {
                isValid = true; // Allow transition to the next step
            }

            if (isValid) {
                showStep(step);
            }
        }

        function previousStep(step) {
            showStep(step);
        }

        function showStep(step) {
            document.querySelectorAll('.step-content').forEach((content) => {
                content.classList.remove('active');
            });
            document.getElementById(`step${step}`).classList.add('active');
        }
    </script>
    <script>
        function setStepValue(value) {
            // Update the hidden input with the provided step value
            document.getElementById('stepInput').value = value;
        }
    </script>
    <script src="{{ asset('customjs/common.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        var base_url = "{{ url('/') }}";

        $(document).on('keyup', "[type=number]", function(e) {

            if (this.value < 0) {
                this.value = '';

            }
        });
    </script>
    <script>
        let inactivityTime = 60 * 60 * 1000; // 1 hour in milliseconds
        let logoutTimer;

        function resetTimer() {
            clearTimeout(logoutTimer);
            logoutTimer = setTimeout(logoutUser, inactivityTime);
        }

        function logoutUser() {
            let isSuperAdmin = "{{ request()->is('superadmin/*') ? 'true' : 'false' }}";
            let logoutUrl = isSuperAdmin === "true" ? "{{ route('superadmin.logout') }}" : "{{ route('logout') }}";
            let redirectUrl = isSuperAdmin === "true" ? "{{ route('superadmin.login') }}" : "{{ route('login') }}";

            fetch(logoutUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
            }).then(response => {
                window.location.href = redirectUrl; // Manually redirect after logout
            }).catch(error => console.error("Logout failed:", error));
        }

        // Reset the timer on user activity
        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keypress', resetTimer);
        document.addEventListener('scroll', resetTimer);
        document.addEventListener('click', resetTimer);

        // Start the timer when the page loads
        resetTimer();
    </script>

    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


</body>

</html>
