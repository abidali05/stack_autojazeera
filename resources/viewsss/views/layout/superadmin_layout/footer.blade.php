<style>
    .ankere {
        text-decoration: none;
    }

    .divborder {
        border: 1px solid #BFBEC34D;
        background-color: #281F48;
    }

    .ab {
        font-size: 16px !important;
        color: white;
        font-weight: 500;
    }

    .footertag a {

        color: #B4B3B8;
        /* Set text color */

    }

    .footertag {
        list-style: none;
        /* removes bullets */
        padding-left: 0;
        /* removes extra space on left */
    }

    .footerl {
        font-size: 16px;
        font-weight: 500;
        color: #B4B3B8;
    }

    .firstpp {
        color: #B4B3B8;
        font-size: 14px;
        font-weight: 500;
    }

    .input-group {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%;
    }

    .custom-input-group {
        background-color: #281F48;
        border: 1px solid #4b6179;
        border-radius: 8px;
    }

    .input-group-text {
        display: flex;
        align-items: center;
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: var(--bs-body-color);
        text-align: center;
        white-space: nowrap;
        background-color: var(--bs-tertiary-bg);
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: var(--bs-border-radius);
    }

    .custom-input-group input {
        background-color: transparent;
        border: none;
        color: #bfc7d5;
    }

    .custom-input-group .input-group-text {
        background-color: transparent;
        border: none;
    }

    .form-control {
        border-right: 0;
        border-left: 0;
        padding: 10px;
        font-size: 16px;
        color: #281f48 !important;
        background-color: #281F48 !important;
    }

    .form-control::placeholder {
        color: #bfc7d5 !important;
    }
</style>
<div class="container-fluid divborder" style="border: none !important;position: static; border-radius: 0px !important;">
    <div class="row justify-content-center footercontainer p-4">
        <div class="col-md-10">
            <div class="row">
               


                <div class="row">
                    <div class="col-5 copyright">
                        <p class="ankere" style="color:#B4B3B8">© 2025 AutoJazeera, All Rights Reserved.</p>
                    </div>
                    <div class="col-3 ms-auto copyright">
                        <p><span class="me-3"><a class="ankere" style="color:#B4B3B8" target="_blank"
                                    href="{{ route('term_condition') }}">Terms of use</a></span> <a class="ankere"
                                style="color:#B4B3B8" target="_blank" href="{{ route('privacy_policy') }}">Privacy
                                policy</a> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
