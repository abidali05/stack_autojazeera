@extends('layout.panel_layout.main')
@section('content')
    <style>
        .form-select {
            max-width: 100%;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: white;
            line-height: 24px;
            max-width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            height: 45px;
            background: #281F48;
        }

        .select2-container--default .select2-results__option {
            padding: 10px 20px;
            background: white;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #281F48;
            color: white;
        }

        .select2-search--dropdown {
            display: block;
            padding: 4px;
            background: #281F48;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 10px 20px;
            font-size: 14px;
            background: #281F48;
            color: white;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: none;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent white transparent;
            border-width: 0 6px 7px 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            left: -118%;
            margin-left: -4px;
            margin-top: 10px;
            position: absolute;
            top: 50%;
            width: 0;
        }
    </style>


    <div class="container mt-3">
        <div class="row align-items-center mb-2">
          
            <div class="col-lg-8">
                <h2 class="sec mb-0 primary-color-custom">Service Users Management </h2>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn custom-btn-nav rounded roleuserid" data-role="{{ '2' }}" data-bs-toggle="modal"
                    data-bs-target="#addServiceuserModal">
                    <i class="bi bi-plus-circle"></i> Add New user
                </button>
            </div>
        </div>

    </div>
    <div class="container table-responsive">
        @if (session('warning'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    @if (session('warning'))
                        var warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
                        warningModal.show();
                    @endif
                });
            </script>
        @endif
        <!-- Warning Modal -->
        <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content  " style="border-radius: 10px; overflow: hidden;">

                    <div class="modal-header  " style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                        <h5 class="modal-title" id="warningModalLabel"><strong> Warning</strong></h5>
                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center  " style="background-color: #F0F3F6; color: #FD5631;">
                        {{ session('warning') }}
                    </div>
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    @if ($errors->any())
                        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                        errorModal.show();
                    @endif
                });
            </script>
        @endif
        <!-- Validation Error Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content " style="border-radius: 10px; overflow: hidden;">
                    <div class="modal-header " style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                        <h5 class="modal-title" id="errorModalLabel"><strong> Validation Errors</strong></h5>
                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center"  style="background-color: #F0F3F6; color: #FD5631;">

                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach

                    </div>
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <table class="table table-striped transparent-table align-middle datatable">
                <thead>
                    <tr>

                        <th class="d-none">S.No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th> Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $key => $user)
                        <tr>

                            <td class="d-none"> {{ $key + 1 }} </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->number }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('dealer_user.change_status', $user->id) }}">
                                    <span
                                        class="badge {{ $user->status == 'active' ? 'text-bg-active' : 'text-bg-danger' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </a>
                            </td>
                            <td>
                                <a class=" me-2" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editServiceuserModal{{ $user->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="#" class="primary-color-custom cancel" data-id="{{ $user->id }}"
                                    title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>


                        </tr>
                        <div class="modal fade" id="editServiceuserModal{{ $user->id }}" tabindex="-1"
                            aria-labelledby="addDealerModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content"
                                   style="border-radius: 10px; overflow: hidden;">
                                    <div class="modal-header border-0" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                        <h5 class="modal-title" id="addDealerModalLabel"><strong> Add New Service User</strong></h5>
                                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="{{ route('service.users.update', $user->id) }}">
                                        @csrf
                                        <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;" >

                                            <div class="row mb-3">
                                                <label for="fullName" class="col-sm-4 col-form-label">Full Name*</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control " id="fullName"
                                                        name="name" placeholder="Enter full name" required value="{{ $user->name }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="phone" class="col-sm-4 col-form-label">Phone*</label>
                                                <div class="col-sm-8">
                                                    <input type="tel" class="form-control " id="phone-number"
                                                        name="PhoneNumber" placeholder="+92 000 0000000" required value="{{ $user->number }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="email" class="col-sm-4 col-form-label">Email*</label>
                                                <div class="col-sm-8">
                                                    <input type="email" class="form-control " name="email"
                                                        id="email" placeholder="Enter email" required value="{{ $user->email }}">
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="row mb-3">
                                                <label for="email" class="col-sm-4 col-form-label">Status*</label>
                                                <div class="col-sm-8">
                                                  <select name="status" class="form-select">
                                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                  </select>
                                                </div>
                                            </div>





                                        </div>
                                        <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                            <button type="button"  class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit"  class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                            aria-labelledby="addDealerModalLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content"
                                   style="border-radius: 10px; overflow: hidden;">
                                    <div class="modal-header border-0" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                        <h5 class="modal-title" id="editDealerModalLabel"><strong> Delete</strong></h5>
                                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body text-center"  style="background-color: #F0F3F6; color: #FD5631;">
                                        <form action="{{ route('service.users.delete', $user->id) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <h4 style="color:#281F48 !important;">Are you sure to delete this record? </h4>
                                            <div class="row mb-3">

                                                <div class="col-sm-8">
                                                    <input type="hidden" class="form-control" name="deleted_id"
                                                        id="deleted_id" name="dealershipName" required>
                                                </div>
                                            </div>




                                    </div>
                                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                        <button type="button" class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;">Delete</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $users->links('pagination::bootstrap-5') }}
                    {{-- @endif --}}

                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addServiceuserModal" tabindex="-1" aria-labelledby="addDealerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                <div class="modal-header border-0"  style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                    <h5 class="modal-title" id="addDealerModalLabel"><strong> Add New Service User</strong></h5>
                    <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('service.users.store') }}">
                    @csrf
                    <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">

                        <div class="row mb-3">
                            <label for="fullName" class="col-sm-4 col-form-label">Full Name*</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control " id="fullName" name="name"
                                    placeholder="Enter full name" required value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone" class="col-sm-4 col-form-label">Phone*</label>
                            <div class="col-sm-8">
                                <input type="tel" class="form-control " id="phone-number" name="PhoneNumber"
                                    placeholder="+92 000 0000000" required value="{{ old('PhoneNumber') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-4 col-form-label">Email*</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control " name="email" id="email"
                                    placeholder="Enter email" required value="{{ old('email') }}">
                            </div>
                        </div>





                    </div>
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <button type="button" class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <script>
        $(document).ready(function() {
            $('#phone-number').on('input', function() {
                let phoneValue = $(this).val().replace(/[^0-9]/g, '').replace(/^92/,
                    ''); // Remove non-numeric & extra 92
                let formatted = '+92 ' + phoneValue.substring(0, 3) + (phoneValue.length > 3 ? ' ' +
                    phoneValue.substring(3, 11) : '');
                $(this).val(formatted.substring(0, 15)); // Limit max length of "+92 XXX XXXXXXXX"

                // Show/hide error message based on correct format
                $('#phone-error').toggle(!/^\+92 \d{3} \d{8}$/.test(formatted));
            });
        });
    </script>
@endsection
