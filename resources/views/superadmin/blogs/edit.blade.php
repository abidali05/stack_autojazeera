@extends('layout.superadmin_layout.main')
@section('content')
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        * {
            padding: 0;
            margin: 0;
        }
    /* ✅ Headings ka default color black set */
    .ck-content h1,
    .ck-content h2,
    .ck-content h3,
    .ck-content h4,
    .ck-content h5,
    .ck-content h6 {
      color: #000 !important;
    }
        .time-picker-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .time-picker-wrapper input[type="time"] {
            padding-right: 0px;
        }

        .time-picker-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #555;
            font-size: 18px;
        }

        .buttons {
            background-color: white;
            color: #1f1b2d;
            border: 1px solid #1f1b2d;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 800px;
        }

        .button11 {
            background-color: #d90600;
            color: white;
            border: 1px solid #d90600;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 700px;
        }

        .button111 {
            background-color: #d90600;
            color: white;
            border: 1px solid #d90600;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 10px;
            font-weight: 700px;
        }

        .sixteen {
            color: #281f48;
            font-weight: 500;
            font-size: 16px;
        }

        .twentyfour {
            color: #281f48;
            font-weight: 700;
            font-size: 24px;
        }

        .twentyfourgrey {
            color: #bfbec3;
            font-weight: 600;
            font-size: 24px;
        }

        .twentyfourlabel {
            color: #281f48;
            font-weight: 500;
            font-size: 18px;
        }

        .eighteen {
            color: #281f48;
            font-size: 18px;
            font-weight: 600;
        }

        .twentyeight {
            color: #281f48;
            font-weight: 700;
            font-size: 28px;
        }

        .fourteen {
            color: #281f48;
            font-weight: 600;
            font-size: 14px;
        }

        .twelve {
            color: #281f48;
            font-weight: 600;
            font-size: 11px;
        }

        .twelvebold {
            color: #281f48;
            font-weight: 700;
            font-size: 11px;
        }

        .fourtyeight {
            color: #281f48;
            font-weight: 700;
            font-size: 48px;
        }

        .sixteen {
            color: #281f48;
            font-weight: 600;
            font-size: 16px;
        }

        .imagewidth {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .imagediv {
            overflow: hidden;
            width: 100%;
            height: 100%;
            border-radius: 20px 0px 0px 20px;
        }

        .breadcrumb-item a {
            color: #0000004d;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #281f48;
            font-size: 18px;
            font-weight: 600;
        }

        .wishlist-card {
            background-color: #f0f3f6;
        }

        .backcolor {
            background-color: #f0f3f6;
        }

        .backblueclr {
            background-color: #281f48;
        }

        .whitebtn {
            background-color: white;
            border: 1px solid #281f48;
            color: #281f48;
            padding: 5px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
        }

        .bluebtn {
            background-color: #281f48;
            border: 1px solid #281f48;
            color: white;
            padding: 5px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
        }

        .mapbutton {
            background-color: transparent;
            border: 1px solid #281f48;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .rating-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stars {
            display: flex;
            gap: 5px;
            cursor: pointer;
        }

        .star-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
            background-color: #d6d6d6;
            /* default inactive bg */
        }

        .star-circle.active {
            background-color: #281f48;
            /* active purple bg */
        }

        .star {
            font-size: 14px;
            color: #ffffff88;
            /* faint white by default */
            transition: color 0.2s;
        }

        .star.filled {
            color: #ffffff;
            /* bright white */
        }

        .star.clicked {
            color: #f1c40f;
            /* yellow on click */
        }

        .review-text {
            font-size: 14px;
            color: #333;
        }

        .borderleft {
            border-left: 1px solid #1f1b2d;
        }

        .borderbottom {
            border-bottom: 1px solid #66666680;
        }

        .rating-wrapper {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .star-group {
            display: flex;
            gap: 5px;
            cursor: pointer;
        }

        .star-wrapper {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
            background-color: #d6d6d6;
            /* default inactive */
        }

        .star-wrapper.active-star {
            background-color: #281f48;
            /* active purple */
        }

        .star-icon {
            font-size: 14px;
            color: #ffffff88;
            /* faint white */
            transition: color 0.2s;
        }

        .star-icon.filled-star {
            color: #ffffff;
            /* bright white */
        }

        .star-icon.clicked-star {
            color: #f1c40f;
            /* yellow after click */
        }

        .rating-label {
            font-size: 14px;
            color: #333;
        }

        /* Optional extra classes */
        .border-left {
            border-left: 1px solid #1f1b2d;
        }

        .border-bottom {
            border-bottom: 1px solid #66666680;
        }

        /* home page */
        .bakgimg {
            background-image: url("./images/Frame\ 1618873199.svg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 150px;
            width: 100% !important;
        }

        .input-group {
            width: 100%;
            padding: 10px;
        }

        .form-control,
        .form-selects {
            border-right: 0;
            border-left: 0;
            padding: 10px;
            font-size: 16px;
            color: #281f48 !important;
        }

        .form-selects {
            --bs-form-select-bg-img: url(data:image/svg + xml,
     %3csvgxmlns="http://www.w3.org/2000/svg"viewBox="0 0 16 16" %3e%3cpathfill="none" stroke="%23343a40" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m2 5 6 6 6-6" /%3e%3c/svg%3e);
            display: block;
            width: 100%;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #281f48;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: var(--bs-body-bg);
            background-image: var(--bs-form-select-bg-img),
                var(--bs-form-select-bg-icon, none);
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border: var(--bs-border-width) solid var(--bs-border-color);
            border-radius: var(--bs-border-radius);
            max-width: 200px !important;
            text-align: start;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control::placeholder {
            color: #281f48;
        }

        .btn {
            border-left: 0;
            font-size: 16px;
        }

        .bbrder {
            position: relative;
            height: 90%;
            margin: auto;
        }

        .bbrder::before {
            content: "";
            position: absolute;
            left: 0;
            top: 10%;
            height: 80%;
            width: 2px;
            background-color: #281f48;
        }

        .imgbak {
            background-image: url("./images/Frame\ 1171275423.svg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .colors {
            color: #281f48;
        }

        .crouserheading1 {
            color: #281f48;
            font-size: 35px;
            padding-left: 100px;
            padding-top: 60px;
            font-weight: 700;
        }

        .crouserheading11 {
            color: #281f48;
            font-size: 34px;
            padding-left: 100px;
            padding-top: 100px;
            font-weight: 700;
        }

        .imgcrs {
            height: 400px;
            width: 570px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 15px;
            /* Adjust arrow size */
            height: 15px;
            filter: brightness(0) invert(1);
            /* Make arrows white */
        }

        .img-bg-home-2 {
            width: 100%;

            overflow: hidden;
            border-radius: 20px 0px 0px 20px;
        }

        .img-adj-card {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .crouserheading {
            color: #281f48;
            font-size: 35px;
            padding-left: 100px;
            padding-top: 70px;
            font-weight: 800;
        }

        .carousel-indicators .active {
            opacity: 1;

            background-color: #d90600 !important;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            /* Adjust size */
            height: 40px;
            background-color: #281f48;
            /* Dark background */
            border-radius: 50%;
            /* Circular shape */
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            /* Full visibility */
            position: absolute;
            top: 50%;
            /* Center vertically */
            transform: translateY(-50%);
            /* Adjust vertical alignment */
            z-index: 10;
        }

        .carousel-indicators [data-bs-target] {
            box-sizing: content-box;
            flex: 0 1 auto;
            width: 20px;
            height: 20px;
            padding: 0;
            margin-right: 3px;
            margin-left: 9px;
            text-indent: -999px;
            cursor: pointer;
            background-color: #d6d6d6;
            background-clip: padding-box;
            border: 0;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            opacity: 0.5;
            transition: opacity 0.6s ease;
            border-radius: 50%;
        }

        #customCarousel {
            background-image: url("/web/images/backimgrola.svg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 450px;
        }

        .paddingthis {
            padding-left: 100px;
            padding-top: 30px;
        }

        .search-box {
            display: flex;
            align-items: center;
            background-color: red;
            border-radius: 50px;
            padding: 10px 20px;
            width: 300px;
        }

        .search-box input {
            border: none;
            outline: none;
            background: none;
            color: white;
            font-size: 16px;
            flex: 1;
        }

        .search-box input::placeholder {
            color: white;
        }

        .search-box i {
            color: white;
            font-size: 18px;
        }

        a {
            text-decoration: none;
        }

        .form-controles {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 12px;
            font-weight: 400;
            line-height: 2.3;
            color: #281f48;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: #f0f3f6;
            background-clip: padding-box;
            border: var(--bs-border-width) solid #f0f3f6;
            border-radius: var(--bs-border-radius);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-select {
            --bs-form-select-bg-img: url(data:image/svg + xml,
     %3csvgxmlns="http://www.w3.org/2000/svg"viewBox="0 0 16 16" %3e%3cpathfill="none" stroke="%23343a40" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m2 5 6 6 6-6" /%3e%3c/svg%3e);
            display: block;
            width: 100%;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #281f48;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: #f0f3f6;
            background-image: var(--bs-form-select-bg-img),
                var(--bs-form-select-bg-icon, none);
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border: var(--bs-border-width) solid #f0f3f6;
            border-radius: var(--bs-border-radius);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .feature_ad {
            width: 18px;
            height: 18px;
            background-color: transparent;
            border: 2px solid #00000080;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .feature_ad:checked {
            background-color: #281f48;
            border-color: #281f48;
        }

        .custom-modal-width {
            width: 80%;
            max-width: 80%;
        }

        #dropzone {
            border: 2px dashed #6c5ce7;
            padding: 30px;
            text-align: center;
            cursor: pointer;
        }

        .preview-img {
            max-width: 120px;
            margin: 10px;
            position: relative;
        }

        .remove-btn {
            position: absolute;
            top: 2px;
            right: 2px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 12px;
            cursor: pointer;
            width: 20px;
            height: 20px;
        }

        .ck-editor__editable_inline {
            min-height: 200px !important;
        }
    </style>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
    <style>
        .dropzone {
            width: 100%;
            height: 150px;
            border: 2px dashed #7e6592;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
            overflow: hidden;
            position: relative;
        }

        .upload-icon {
            width: 30px;
            opacity: 0.6;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }

        .upload-text {
            color: #aaa;
            font-size: 12px;
            text-align: center;
            margin: 0;
            transition: all 0.3s ease;
        }

        .dropzone img.upload-preview {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>

    <style>
        /* Add these styles to your existing CSS */
        #preview-services-container p,
        #preview-amenities-container p {
            margin-bottom: 0.5rem;
        }

        #preview-shop-images img {
            transition: transform 0.3s ease;
        }

        #preview-shop-images img:hover {
            transform: scale(1.02);
        }

        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-body {
            padding: 2rem;
        }

        /* Social media icons */
        #preview-facebook img,
        #preview-instagram img,
        #preview-twitter img,
        #preview-website img {
            width: 16px;
            height: 16px;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="m-0 fourtyeight">Edit Blog</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('superadmin.blogs.update', $blog->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}"
                            required>
                    </div>

                    {{-- Featured Image --}}
                    <div class="mb-3">
                        <label class="form-label">Featured Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if ($blog->image)
                            <div class="mt-2">
                                <a href="{{ asset($blog->image) }}" target="_blank">
                                    <img src="{{ asset($blog->image) }}" alt="Blog Image" width="50"
                                        style="height: 50px;" class="rounded">
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Description with CKEditor --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="ckeditor" class="form-control" rows="6">{{ old('description', $blog->description) }}</textarea>
                    </div>

                    {{-- Tags --}}
                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <input type="text" id="tagInput" class="form-control" placeholder="Type a tag and press Enter">
                        <div id="tagsContainer" class="mt-2"></div>

                        <!-- hidden field for saving tags as CSV -->
                        <input type="hidden" name="tags" id="tagsHidden"
                           value="{{ old('tags', $blog->tags ?? '') }}
">
                    </div>

                    <div class="d-flex justify-content-end mb-3">
                        <button type="submit" class="btn custom-btn-nav rounded">Update Blog</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('shopForm');

                // Rules matching your Laravel validation
                const rules = {
                    dealer_id: {
                        required: true
                    },
                    shop_name: {
                        required: true,
                        max: 255
                    },
                    shop_contact: {
                        required: true,
                        min: 13,
                        max: 20
                    },
                    shop_email: {
                        required: true,
                        email: true,
                        max: 255
                    },
                    services: {
                        required: true
                    },
                    days: {
                        required: true
                    },
                    province: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    postal_code: {
                        required: true,
                        max: 20
                    },
                    shop_address: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    shop_logo: {
                        required: true,
                        filetypes: ['jpg', 'jpeg', 'png'],
                        maxsize: 8192
                    },
                    website: {
                        url: true,
                        max: 255
                    },
                    facebook: {
                        url: true,
                        max: 255
                    },
                    instagram: {
                        url: true,
                        max: 255
                    },
                    twitter: {
                        url: true,
                        max: 255
                    }
                };

                function showError(field, message) {
                    removeError(field);
                    field.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'text-danger mt-1 field-error';
                    errorDiv.innerText = message;
                    field.parentNode.appendChild(errorDiv);
                }

                function removeError(field) {
                    field.classList.remove('is-invalid');
                    const existingError = field.parentNode.querySelector('.field-error');
                    if (existingError) existingError.remove();
                }

                function validateField(name, field) {
                    const rule = rules[name];
                    if (!rule) return true;

                    let value = field.value?.trim?.() ?? '';
                    let file = field.files && field.files[0];

                    // Special case: services[]
                    if (name == 'services') {
                        alert('hello');
                        let servicesChecked = form.querySelectorAll('input[name="services[]"]:checked').length;
                        if (rule.required && servicesChecked === 0) {
                            showError(field.closest('.backcolor') || field, 'Please select at least one service.');
                            return false;
                        }
                        removeError(field.closest('.backcolor') || field);
                        return true;
                    }

                    // Special case: days
                    if (name === 'days') {
                        let dayBlocks = form.querySelectorAll('input[name^="days["][type="checkbox"]');
                        let validDays = false;
                        let daysError = '';

                        dayBlocks.forEach(cb => {
                            if (cb.checked) {
                                validDays = true;
                                let dayName = cb.name.match(/days\[(.*?)\]/)[1];
                                let start = form.querySelector(`[name="days[${dayName}][start]"]`)?.value;
                                let end = form.querySelector(`[name="days[${dayName}][end]"]`)?.value;
                                if (!start || !end) {
                                    daysError = `Please provide start and end time for ${dayName}.`;
                                }
                            }
                        });

                        if (!validDays) {
                            showError(dayBlocks[0].closest('.border'), 'Please select at least one day.');
                            return false;
                        }
                        if (daysError) {
                            showError(dayBlocks[0].closest('.border'), daysError);
                            return false;
                        }

                        removeError(dayBlocks[0].closest('.border'));
                        return true;
                    }

                    // Required
                    if (rule.required && (!value && !file)) {
                        showError(field, 'This field is required.');
                        return false;
                    }

                    // Max length
                    if (rule.max && value.length > rule.max) {
                        showError(field, `Maximum ${rule.max} characters allowed.`);
                        return false;
                    }

                    // Min length
                    if (rule.min && value.length < rule.min) {
                        showError(field, `Minimum ${rule.min} characters required.`);
                        return false;
                    }

                    // Email format
                    if (rule.email && value && !/^\S+@\S+\.\S+$/.test(value)) {
                        showError(field, 'Please enter a valid email.');
                        return false;
                    }

                    // URL format
                    if (rule.url && value && !/^(https?:\/\/)?([\w-]+\.)+[\w-]{2,}(\/.*)?$/.test(value)) {
                        showError(field, 'Please enter a valid URL.');
                        return false;
                    }

                    // File type check
                    if (file && rule.filetypes) {
                        const ext = file.name.split('.').pop().toLowerCase();
                        if (!rule.filetypes.includes(ext)) {
                            showError(field, `Allowed file types: ${rule.filetypes.join(', ')}`);
                            return false;
                        }
                    }

                    // File size check (KB)
                    if (file && rule.maxsize) {
                        const sizeKB = file.size / 1024;
                        if (sizeKB > rule.maxsize) {
                            showError(field, `Max file size is ${rule.maxsize / 1024} MB`);
                            return false;
                        }
                    }

                    removeError(field);
                    return true;
                }


                form.addEventListener('submit', function(e) {
                    let valid = true;
                    console.log('rules', rules)
                    Object.keys(rules).forEach(name => {
                        let field = null;

                        // special cases
                        if (name === "services") {
                            field = form.querySelector('input[name="services[]"]');
                        } else if (name === "days") {
                            field = form.querySelector('input[name^="days["][type="checkbox"]');
                        } else {
                            // normal fields
                            field = document.getElementById(name) || form.querySelector(
                                `[name="${name}"]`);
                        }
                        console.log('field', name, field)
                        if (field && !validateField(name, field)) {
                            valid = false;
                        }
                    });

                    if (!valid) e.preventDefault();
                });




                // Live validation
                Object.keys(rules).forEach(name => {
                    let field = null;

                    if (name === "services") {
                        field = form.querySelector('input[name="services[]"]');
                    } else if (name === "days") {
                        field = form.querySelector('input[name^="days["][type="checkbox"]');
                    } else {
                        field = document.getElementById(name) || form.querySelector(`[name="${name}"]`);
                    }

                    if (field) {
                        field.addEventListener('input', () => validateField(name, field));
                        field.addEventListener('change', () => validateField(name, field));
                    }
                });

            });
        </script>

        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

        <script>
            ClassicEditor
                .create(document.querySelector('#ckeditor'), {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'bulletedList', 'numberedList', '|',
                        'link', 'blockQuote', 'insertTable', '|',
                        'undo', 'redo'
                    ],
                    removePlugins: [
                        'Image', 'ImageToolbar', 'ImageCaption', 'ImageStyle',
                        'ImageUpload', 'MediaEmbed', 'EasyImage', 'CKFinder'
                    ]
                })
                .then(editor => {
                    editor.ui.view.editable.element.style.minHeight = '400px';
                })
                .catch(error => console.error(error));

            // --- Tags handling ---
            const tagInput = document.getElementById("tagInput");
            const tagsContainer = document.getElementById("tagsContainer");
            const tagsHidden = document.getElementById("tagsHidden");

            let tags = tagsHidden.value ? tagsHidden.value.split(",") : [];

            function renderTags() {
                tagsContainer.innerHTML = "";
                tags.forEach((tag, index) => {
                    const tagEl = document.createElement("span");
                    tagEl.classList.add("badge", "bg-secondary", "me-1", "mb-1");
                    tagEl.innerHTML = tag +
                        ` <button type="button" class="btn-close btn-close-white btn-sm ms-1" onclick="removeTag(${index})"></button>`;
                    tagsContainer.appendChild(tagEl);
                });
                tagsHidden.value = tags.join(",");
            }

            function removeTag(index) {
                tags.splice(index, 1);
                renderTags();
            }

            tagInput.addEventListener("keydown", function(e) {
                if (e.key === "Enter" && this.value.trim() !== "") {
                    e.preventDefault();
                    tags.push(this.value.trim());
                    this.value = "";
                    renderTags();
                }
            });

            // Load existing tags on edit
            renderTags();
        </script>

        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHTfGE9bbvleasezO-T-j1u5UVm6aTnl0&libraries=places&callback=initAutocomplete"
            async defer></script>

        <script>
            let selectedPlace = false;

            function initAutocomplete() {
                const input = document.getElementById("shop_address");
                const latitudeInput = document.getElementById("latitude");
                const longitudeInput = document.getElementById("longitude");


                const autocomplete = new google.maps.places.Autocomplete(input, {
                    fields: ["formatted_address", "geometry"],
                });

                autocomplete.addListener("place_changed", () => {
                    const place = autocomplete.getPlace();
                    if (place.geometry) {
                        selectedPlace = true;
                        input.value = place.formatted_address;
                        latitudeInput.value = place.geometry.location.lat();
                        longitudeInput.value = place.geometry.location.lng();

                    } else {
                        selectedPlace = false;
                    }
                });

                input.addEventListener("blur", () => {
                    if (!selectedPlace) {
                        input.value = "";
                        latitudeInput.value = "";
                        longitudeInput.value = "";

                    }
                });

                input.addEventListener("input", () => {
                    selectedPlace = false;
                });
            }

            window.initAutocomplete = initAutocomplete;
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const imagesDropzone = document.getElementById('imagesDropzone');
                const imagesInput = document.getElementById('shop_images');
                const previewContainer = document.getElementById('shop_images_preview');
                const errorMsg = document.getElementById('error-msg');
                const maxAllowedImages = parseInt(document.getElementById('maxImagesAllowed').textContent) || 10;
                let uploadedFiles = [];

                // Handle click
                imagesDropzone.addEventListener('click', function() {
                    imagesInput.click();
                });

                // Handle drag and drop
                imagesDropzone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('border-primary');
                });

                imagesDropzone.addEventListener('dragleave', function() {
                    this.classList.remove('border-primary');
                });

                imagesDropzone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('border-primary');

                    if (e.dataTransfer.files.length) {
                        handleImageFiles(e.dataTransfer.files);
                    }
                });

                // Handle file selection
                imagesInput.addEventListener('change', function() {
                    if (this.files.length) {
                        handleImageFiles(this.files);
                    }
                });

                function handleImageFiles(files) {
                    errorMsg.textContent = '';

                    // Check total files count
                    if (uploadedFiles.length + files.length > maxAllowedImages) {
                        errorMsg.textContent = `You can upload maximum ${maxAllowedImages} images.`;
                        return;
                    }

                    // Process each file
                    Array.from(files).forEach(file => {
                        // Check if file already exists
                        if (uploadedFiles.some(f => f.name === file.name && f.size === file.size)) {
                            return;
                        }

                        // Validate file type
                        if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                            errorMsg.textContent = 'Only JPG, JPEG, and PNG files are allowed.';
                            return;
                        }

                        // Validate file size
                        if (file.size > 8 * 1024 * 1024) {
                            errorMsg.textContent = 'Each image must be smaller than 8MB.';
                            return;
                        }

                        // Add to uploaded files
                        uploadedFiles.push(file);

                        // Create preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const previewItem = document.createElement('div');
                            previewItem.className = 'position-relative';
                            previewItem.style.width = '120px';
                            previewItem.style.height = '120px';

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'img-thumbnail w-100 h-100';
                            img.style.objectFit = 'cover';

                            const removeBtn = document.createElement('button');
                            removeBtn.innerHTML = '×';
                            removeBtn.className =
                                'btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle';
                            removeBtn.style.transform = 'translate(50%, -50%)';
                            removeBtn.onclick = function() {
                                uploadedFiles = uploadedFiles.filter(f => f !== file);
                                previewItem.remove();
                                updateImagesInput();
                            };

                            previewItem.appendChild(img);
                            previewItem.appendChild(removeBtn);
                            previewContainer.appendChild(previewItem);

                            updateImagesInput();
                        };
                        reader.readAsDataURL(file);
                    });
                }

                function updateImagesInput() {
                    const dataTransfer = new DataTransfer();
                    uploadedFiles.forEach(file => dataTransfer.items.add(file));
                    imagesInput.files = dataTransfer.files;
                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dayCheckboxes = document.querySelectorAll('input[type="checkbox"][id^="check_"]');

                dayCheckboxes.forEach(checkbox => {
                    const day = checkbox.id.replace('check_', '');
                    const startInput = document.querySelector(`input[name="days[${day}][start]"]`);
                    const endInput = document.querySelector(`input[name="days[${day}][end]"]`);

                    // Initial state
                    toggleTimeFields(checkbox, startInput, endInput);

                    checkbox.addEventListener('change', function() {
                        toggleTimeFields(checkbox, startInput, endInput);
                    });
                });

                function toggleTimeFields(checkbox, startInput, endInput) {
                    const enabled = checkbox.checked;
                    startInput.disabled = !enabled;
                    endInput.disabled = !enabled;
                }
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('[data-bs-target="#previewmodal"]').addEventListener('click', function() {
                    // Basic info
                    document.getElementById('preview-shop-name').textContent =
                        document.getElementById('shop_name').value || 'Business Name';

                    document.getElementById('preview-shop-address').textContent =
                        document.getElementById('shop_address').value || 'Address not provided';

                    document.getElementById('preview-shop-phone').innerHTML =
                        '<i class="bi bi-telephone me-2"></i>' +
                        (document.getElementById('shop_contact').value || 'Not provided');

                    document.getElementById('preview-shop-email').innerHTML =
                        '<i class="bi bi-envelope me-2"></i>' +
                        (document.getElementById('shop_email').value || 'Not provided');

                    document.getElementById('preview-shop-description').textContent =
                        document.getElementById('description').value || 'No description provided';

                    // Map update
                    const address = document.getElementById('shop_address').value || 'Unknown Location';

                    document.getElementById('preview-map').src =
                        `https://www.google.com/maps?q=${encodeURIComponent(address)}&output=embed`;
                    document.getElementById('preview-map-address').textContent = address;

                    // Days and hours
                    const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    days.forEach(day => {
                        const checkbox = document.getElementById(`check_${day}`);
                        const startTime = document.querySelector(`input[name="days[${day}][start]"]`)
                            .value;
                        const endTime = document.querySelector(`input[name="days[${day}][end]"]`).value;

                        const dayHours = document.getElementById(`preview-${day.toLowerCase()}-hours`);

                        if (checkbox.checked && startTime && endTime) {
                            dayHours.textContent = `${startTime} - ${endTime}`;
                            dayHours.style.color = 'green';
                        } else {
                            dayHours.textContent = 'Closed';
                            dayHours.style.color = 'orangered';
                        }
                    });

                    // Services (without icons/images)
                    const servicesContainer = document.getElementById('preview-services-container');
                    servicesContainer.innerHTML = '';

                    const selectedServices = Array.from(document.querySelectorAll(
                            'input[name="services[]"]:checked'))
                        .map(service => ({
                            id: service.value,
                            name: service.nextElementSibling.textContent.trim()
                        }));

                    if (selectedServices.length === 0) {
                        servicesContainer.innerHTML = '<p class="sixteen">No services selected</p>';
                    } else {
                        const chunkSize = Math.ceil(selectedServices.length / 3);
                        for (let i = 0; i < 3; i++) {
                            const colDiv = document.createElement('div');
                            colDiv.className = 'col-md-4 col-6';

                            const servicesChunk = selectedServices.slice(i * chunkSize, (i + 1) * chunkSize);
                            servicesChunk.forEach(service => {
                                const serviceElement = document.createElement('p');
                                serviceElement.className = 'eighteen';
                                serviceElement.textContent = service.name;
                                colDiv.appendChild(serviceElement);
                            });

                            servicesContainer.appendChild(colDiv);
                        }
                    }

                    // Amenities
                    const amenitiesContainer = document.getElementById('preview-amenities-container');
                    amenitiesContainer.innerHTML = '';

                    const selectedAmenities = Array.from(document.querySelectorAll(
                            'input[name="amenities[]"]:checked'))
                        .map(amenity => amenity.nextElementSibling.textContent.trim());

                    if (selectedAmenities.length === 0) {
                        amenitiesContainer.innerHTML = '<p class="sixteen">No amenities selected</p>';
                    } else {
                        const chunkSize = Math.ceil(selectedAmenities.length / 2);
                        for (let i = 0; i < 2; i++) {
                            const colDiv = document.createElement('div');
                            colDiv.className = 'col-md-6';

                            const amenitiesChunk = selectedAmenities.slice(i * chunkSize, (i + 1) * chunkSize);
                            amenitiesChunk.forEach(amenity => {
                                const amenityElement = document.createElement('p');
                                amenityElement.className = 'sixteen';
                                amenityElement.innerHTML =
                                    `<i class="bi bi-check-circle me-2"></i>${amenity}`;
                                colDiv.appendChild(amenityElement);
                            });

                            amenitiesContainer.appendChild(colDiv);
                        }
                    }

                    // Social media
                    const website = document.getElementById('website').value;
                    const facebook = document.getElementById('facebook').value;
                    const instagram = document.getElementById('instagram').value;
                    const twitter = document.getElementById('twitter').value;

                    const previewWebsite = document.getElementById('preview-website');
                    const previewFacebook = document.getElementById('preview-facebook');
                    const previewInstagram = document.getElementById('preview-instagram');
                    const previewTwitter = document.getElementById('preview-twitter');



                    if (facebook) {
                        previewFacebook.classList.remove('d-none');
                        previewFacebook.innerHTML =
                            `<img src="{{ asset('web/services/images/facebook.svg') }}" class="img-fluid me-2" alt="..."> ${facebook}`;
                    } else {
                        previewFacebook.classList.add('d-none');
                    }

                    if (instagram) {
                        previewInstagram.classList.remove('d-none');
                        previewInstagram.innerHTML =
                            `<img src="{{ asset('web/services/images/instagram.svg') }}" class="img-fluid me-2" alt="..."> ${instagram}`;
                    } else {
                        previewInstagram.classList.add('d-none');
                    }

                    if (twitter) {
                        previewTwitter.classList.remove('d-none');
                        previewTwitter.innerHTML =
                            `<img src="{{ asset('web/services/images/Social Iconsxxx.svg') }}" class="img-fluid me-2" alt="..."> ${twitter}`;
                    } else {
                        previewTwitter.classList.add('d-none');
                    }

                    const imagesPreview = document.getElementById('preview-shop-images');
                    imagesPreview.innerHTML = '';

                    const imageThumbnails = document.querySelectorAll('#shop_images_preview img');

                    if (imageThumbnails.length > 0) {
                        imageThumbnails.forEach((img, index) => {
                            const colDiv = document.createElement('div');
                            colDiv.className = index === 0 ? 'col-md-9' : 'col-md-3';

                            const imgDiv = document.createElement('div');
                            imgDiv.className = 'col-12 mt-md-0 mt-3';

                            const newImg = document.createElement('img');
                            newImg.src = img.src;
                            newImg.className = 'img-fluid';
                            newImg.alt = 'Shop image';
                            newImg.style.borderRadius = '8px';
                            newImg.style.maxHeight = index === 0 ? '300px' : '140px';
                            newImg.style.width = '100%';
                            newImg.style.objectFit = 'cover';

                            imgDiv.appendChild(newImg);
                            colDiv.appendChild(imgDiv);
                            imagesPreview.appendChild(colDiv);
                        });
                    } else {
                        imagesPreview.innerHTML = '<p class="sixteen">No images uploaded</p>';
                    }

                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const logoDropzone = document.getElementById('logoDropzone');
                const logoInput = document.getElementById('shop_logo');
                const logoPreviewContainer = document.getElementById('logoPreviewContainer');
                const logoDropText = document.getElementById('logoDropText');

                // Handle click
                logoDropzone.addEventListener('click', function() {
                    logoInput.click();
                });

                // Handle drag and drop
                logoDropzone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('border-primary');
                });

                logoDropzone.addEventListener('dragleave', function() {
                    this.classList.remove('border-primary');
                });

                logoDropzone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('border-primary');

                    if (e.dataTransfer.files.length) {
                        logoInput.files = e.dataTransfer.files;
                        handleLogoFile(e.dataTransfer.files[0]);
                    }
                });

                // Handle file selection
                logoInput.addEventListener('change', function() {
                    if (this.files.length) {
                        handleLogoFile(this.files[0]);
                    }
                });

                function handleLogoFile(file) {
                    // Validate file type
                    if (!['image/png', 'image/svg+xml'].includes(file.type)) {
                        alert('Only PNG and SVG files are allowed for the logo.');
                        return;
                    }

                    // Validate file size
                    if (file.size > 8 * 1024 * 1024) {
                        alert('Logo must be smaller than 8MB.');
                        return;
                    }

                    // Create preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        logoPreviewContainer.innerHTML = '';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '100%';
                        img.style.maxHeight = '100%';
                        img.style.objectFit = 'contain';

                        logoPreviewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.getElementById('shop_contact');

                function formatPhoneNumber(input) {
                    let value = input.value.replace(/\D/g, ''); // Remove non-digits

                    if (!value.startsWith('92')) {
                        value = '92' + value;
                    }

                    value = value.substring(0, 13); // Max: 92 + 11 digits

                    // Format: +92 XXX XXXXXXX
                    let formatted = '+92';
                    if (value.length > 2) {
                        formatted += ' ' + value.substring(2, 5);
                    }
                    if (value.length > 5) {
                        formatted += ' ' + value.substring(5, 12);
                    }

                    input.value = formatted;
                }

                input.addEventListener('input', function() {
                    formatPhoneNumber(this);
                });

                input.addEventListener('keydown', function(e) {
                    if (this.selectionStart <= 4 && (e.key === 'Backspace' || e.key === 'Delete')) {
                        e.preventDefault(); // Prevent deleting "+92"
                    }
                });

                // Optional: format existing value on page load
                formatPhoneNumber(input);
            });
        </script>

        <!-- In your <head> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- Replace the icon span -->
        <span class="time-picker-icon" onclick="document.getElementById('startTimeInput').showPicker()">

        </span>
    @endsection
