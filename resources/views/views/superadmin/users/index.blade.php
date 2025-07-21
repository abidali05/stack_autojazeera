@extends('layout.superadmin_layout.main')

@section('content')
    <style>
        .form-select {
            max-width: 100%;
        }

        .new {
            padding: 10px 20px !important;
        }

        .active-btn {
            background-color: white !important;
            color: #281F48 !important;
            border: 1px solid black !important;
        }

        .dataTables_wrapper {
            overflow-x: hidden;
        }

        .table-container {
            overflow-x: auto;
        }

        table.dataTable {
            width: 100% !important;
        }
    </style>
    @php
        $dealershipNames = \App\Models\User::where('role', 1)->pluck('dealershipName')->toArray();
    @endphp
    <div class="container mt-3">
        <div class="row align-items-center mb-2">
            <div class="col-auto">
                <h2 class="sec mb-0 primary-color-custom">User Management</h2>
            </div>
        </div>

        <div class="row align-items-center justify-content-end mb-4">
            <div class="row">
                <div class="col-md-8">
                    <ul class="nav nav-tabs" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link  active" id="private-seller-tab" data-bs-toggle="tab"
                                data-bs-target="#private-seller" type="button" role="tab">Private Seller</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="dealer-tab" data-bs-toggle="tab" data-bs-target="#dealer"
                                type="button" role="tab">Dealer</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="dealer-user-tab" data-bs-toggle="tab"
                                data-bs-target="#dealer-user" type="button" role="tab">Dealer User</button>
                        </li>
                    </ul>
                </div>
        
            </div>
        </div>

        <div class="tab-content p-3 border border-top-0" id="userTabsContent">
            <div class="tab-pane fade show active" id="private-seller" role="tabpanel">
                <div class="table-container">
                    <table class="table table-striped align-middle datatable12" style="min-width: 1000px;">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Action</th>
                                <th>Name</th>
                                <th>Dealership Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($privateSellers as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <i class="bi bi-pencil-square me-2" title="Edit" data-bs-toggle="modal"
                                            data-bs-target="#editUsererModal{{ $user->id }}"></i>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}">
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->dealershipName }}</td>
                                    <td>{{ $user->number }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>{{ $user->updated_at ? $user->updated_at->format('d M Y') : 'N/A' }}</td>
                                    <td><span
                                            class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($user->status) }}</span>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editUsererModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="editUsererModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content" style="background-color:#F0F3F6 !important;">
                                            <form method="post" action="{{ route('superadmin.user.update', $user->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body" style="background-color:#F0F3F6 !important;">
                                                    <div class="mb-4 row">
                                                        <div class="col-6 mb-3">
                                                            <h3 style="color: #281F48; font-weight: 600;">Edit User</h3>
                                                        </div>

                                                        <div class="col-6 mb-3 d-flex justify-content-end pe-4">
                                                            <div class="dropzone"
                                                                style="border: 2px dotted #ccc; border-radius: 8px; width: 150px; height: 150px;
                                display: flex; align-items: center; justify-content: center; text-align: center;
                                position: relative; background-color:#28223ECC;"
                                                                onmouseenter="admin_edit_user_showButtons({{ $user->id }})"
                                                                onmouseleave="admin_edit_user_hideButtons({{ $user->id }})">

                                                                <input type="file"
                                                                    id="admin_edit_user_profileimg{{ $user->id }}"
                                                                    accept="image/*" style="display: none;" name="image">

                                                                <label
                                                                    id="admin_edit_user_dropzoneLabel{{ $user->id }}"
                                                                    for="admin_edit_user_profileimg{{ $user->id }}"
                                                                    style="color: #888; cursor: pointer; font-size: 14px; padding: 10px;"
                                                                    class="dropzone-label">
                                                                    Drop an image here or click to upload
                                                                </label>

                                                                <img id="admin_edit_user_previewImage{{ $user->id }}"
                                                                    data-id="{{ $user->id }}" alt="Preview"
                                                                    src="{{ $user->image ? asset('web/profile/' . $user->image) : '' }}"
                                                                    style="{{ $user->image ? 'display: block;' : 'display: none;' }}
                                    position: absolute; max-width:150px; max-height: 150px; object-fit: contain;">

                                                                <div id="admin_edit_user_buttons{{ $user->id }}"
                                                                    class="action-buttons"
                                                                    style="display: {{ $user->image ? 'flex' : 'none' }}; position: absolute; bottom: 10px; gap: 5px;
                                    justify-content: center; align-items: center;">
                                                                    <i class="bi bi-x-circle me-auto"
                                                                        style="color: black; font-size: 18px;"
                                                                        onclick="admin_edit_user_deleteImage({{ $user->id }})"></i>
                                                                    <i class="bi bi-plus-circle ms-auto"
                                                                        onclick="admin_edit_user_triggerFileInput({{ $user->id }})"
                                                                        style="color: black; font-size: 18px;"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="alert alert-danger" style="display:none;"></div>

                                                        <div class="row mb-3">
                                                            <label for="dealershipName"
                                                                class="col-sm-4 col-form-label">Dealership Name*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <select name="dealershipName" class="form-select"
                                                                    style="color:#281F48;background-color:white;border:1px solid #281F48;text-align:center">
                                                                    @foreach ($dealershipNames as $dealershipName)
                                                                        <option value="{{ $dealershipName }}"
                                                                            {{ $user->dealershipName == $dealershipName ? 'selected' : '' }}>
                                                                            {{ $dealershipName }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="fullName" class="col-sm-4 col-form-label">Full
                                                                Name*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <input type="text" class="form-control" name="name"
                                                                    value="{{ $user->name }}"
                                                                    placeholder="Enter full name">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-4 col-form-label">Phone*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <input type="text" class="form-control" name="number"
                                                                    value="{{ $user->number }}"
                                                                    placeholder="Enter phone">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-4 col-form-label">Email*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <input type="email" class="form-control" name="email"
                                                                    value="{{ $user->email }}"
                                                                    placeholder="Enter email">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-4 col-form-label">Status*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <select name="status" class="form-select"
                                                                    style="color:#281F48;background-color:white;border:1px solid #281F48;text-align:center">
                                                                    <option value="active"
                                                                        {{ $user->status == 'active' ? 'selected' : '' }}>
                                                                        Active</option>
                                                                    <option value="inactive"
                                                                        {{ $user->status == 'inactive' ? 'selected' : '' }}>
                                                                        Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit"
                                                        class="btn custom-btn-nav rounded">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <!-- Delete User Modal -->
                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color:#F0F3F6 !important;">
                                            <form method="POST"
                                                action="{{ route('superadmin.user.destroy', $user->id) }}">
                                                @csrf
                                                <input type="hidden" name="deleted_id" value="{{ $user->id }}">

                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">
                                                        Confirm Deletion</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete user
                                                    <strong>{{ $user->name }}</strong>?
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="dealer" role="tabpanel">
                <div class="table-container">
                    <table class="table table-striped align-middle datatable12" style="min-width: 1000px;">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Action</th>
                                <th>Name</th>
                                <th>Dealership Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dealers as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <i class="bi bi-pencil-square me-2" title="Edit"
                                            data-bs-target="#editUsererModal{{ $user->id }}"
                                            data-bs-toggle="modal"></i>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}">
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->dealershipName }}</td>
                                    <td>{{ $user->number }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>{{ $user->updated_at ? $user->updated_at->format('d M Y') : 'N/A' }}</td>
                                    <td><span
                                            class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($user->status) }}</span>
                                    </td>
                                </tr>



                                <!-- Edit Modal -->
                                <div class="modal fade" id="editUsererModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="editUsererModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content" style="background-color:#F0F3F6 !important;">
                                            <form method="post"
                                                action="{{ route('superadmin.user.update', $user->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body" style="background-color:#F0F3F6 !important;">
                                                    <div class="mb-4 row">
                                                        <div class="col-6 mb-3">
                                                            <h3 style="color: #281F48; font-weight: 600;">Edit User</h3>
                                                        </div>

                                                        <div class="col-6 mb-3 d-flex justify-content-end pe-4">
                                                            <div class="dropzone"
                                                                style="border: 2px dotted #ccc; border-radius: 8px; width: 150px; height: 150px;
                                display: flex; align-items: center; justify-content: center; text-align: center;
                                position: relative; background-color:#28223ECC;"
                                                                onmouseenter="admin_edit_user_showButtons({{ $user->id }})"
                                                                onmouseleave="admin_edit_user_hideButtons({{ $user->id }})">

                                                                <input type="file"
                                                                    id="admin_edit_user_profileimg{{ $user->id }}"
                                                                    accept="image/*" style="display: none;"
                                                                    name="image">

                                                                <label
                                                                    id="admin_edit_user_dropzoneLabel{{ $user->id }}"
                                                                    for="admin_edit_user_profileimg{{ $user->id }}"
                                                                    style="color: #888; cursor: pointer; font-size: 14px; padding: 10px;"
                                                                    class="dropzone-label">
                                                                    Drop an image here or click to upload
                                                                </label>

                                                                <img id="admin_edit_user_previewImage{{ $user->id }}"
                                                                    data-id="{{ $user->id }}" alt="Preview"
                                                                    src="{{ $user->image ? asset('web/profile/' . $user->image) : '' }}"
                                                                    style="{{ $user->image ? 'display: block;' : 'display: none;' }}
                                    position: absolute; max-width:150px; max-height: 150px; object-fit: contain;">

                                                                <div id="admin_edit_user_buttons{{ $user->id }}"
                                                                    class="action-buttons"
                                                                    style="display: {{ $user->image ? 'flex' : 'none' }}; position: absolute; bottom: 10px; gap: 5px;
                                    justify-content: center; align-items: center;">
                                                                    <i class="bi bi-x-circle me-auto"
                                                                        style="color: black; font-size: 18px;"
                                                                        onclick="admin_edit_user_deleteImage({{ $user->id }})"></i>
                                                                    <i class="bi bi-plus-circle ms-auto"
                                                                        onclick="admin_edit_user_triggerFileInput({{ $user->id }})"
                                                                        style="color: black; font-size: 18px;"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="alert alert-danger" style="display:none;"></div>

                                                        <div class="row mb-3">
                                                            <label for="dealershipName"
                                                                class="col-sm-4 col-form-label">Dealership Name*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <select name="dealershipName" class="form-select"
                                                                    style="color:#281F48;background-color:white;border:1px solid #281F48;text-align:center">
                                                                    @foreach ($dealershipNames as $dealershipName)
                                                                        <option value="{{ $dealershipName }}"
                                                                            {{ $user->dealershipName == $dealershipName ? 'selected' : '' }}>
                                                                            {{ $dealershipName }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="fullName" class="col-sm-4 col-form-label">Full
                                                                Name*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <input type="text" class="form-control" name="name"
                                                                    value="{{ $user->name }}"
                                                                    placeholder="Enter full name">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-4 col-form-label">Phone*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <input type="text" class="form-control" name="number"
                                                                    value="{{ $user->number }}"
                                                                    placeholder="Enter phone">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-4 col-form-label">Email*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <input type="email" class="form-control" name="email"
                                                                    value="{{ $user->email }}"
                                                                    placeholder="Enter email">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-4 col-form-label">Status*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <select name="status" class="form-select"
                                                                    style="color:#281F48;background-color:white;border:1px solid #281F48;text-align:center">
                                                                    <option value="active"
                                                                        {{ $user->status == 'active' ? 'selected' : '' }}>
                                                                        Active</option>
                                                                    <option value="inactive"
                                                                        {{ $user->status == 'inactive' ? 'selected' : '' }}>
                                                                        Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit"
                                                        class="btn custom-btn-nav rounded">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete User Modal -->
                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color:#F0F3F6 !important;">
                                            <form method="POST"
                                                action="{{ route('superadmin.user.destroy', $user->id) }}">
                                                <input type="hidden" name="deleted_id" value="{{ $user->id }}">

                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">
                                                        Confirm Deletion</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete user
                                                    <strong>{{ $user->name }}</strong>?
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="dealer-user" role="tabpanel">
				        <div class="col-md-12 text-end">
                    <button class="btn custom-btn-nav new py-0 rounded roleid" data-role="0" data-bs-toggle="modal"
                        data-bs-target="#superadmin_add_userModal">Add New User</button>
                </div>
                <div class="table-container">
                    <table class="table table-striped align-middle datatable12" style="min-width: 1000px;">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Action</th>
                                <th>Name</th>
                                <th>Dealership Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dealerusers as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <i class="bi bi-pencil-square me-2" data-bs-toggle="modal"
                                            data-bs-target="#editUsererModal{{ $user->id }}" title="Edit"></i>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}">
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->dealershipName }}</td>
                                    <td>{{ $user->number }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>{{ $user->updated_at ? $user->updated_at->format('d M Y') : 'N/A' }}</td>
                                    <td><span
                                            class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($user->status) }}</span>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editUsererModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="editUsererModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content" style="background-color:#F0F3F6 !important;">
                                            <form method="post"
                                                action="{{ route('superadmin.user.update', $user->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body" style="background-color:#F0F3F6 !important;">
                                                    <div class="mb-4 row">
                                                        <div class="col-6 mb-3">
                                                            <h3 style="color: #281F48; font-weight: 600;">Edit User</h3>
                                                        </div>

                                                        <div class="col-6 mb-3 d-flex justify-content-end pe-4">
                                                            <div class="dropzone"
                                                                style="border: 2px dotted #ccc; border-radius: 8px; width: 150px; height: 150px;
                                display: flex; align-items: center; justify-content: center; text-align: center;
                                position: relative; background-color:#28223ECC;"
                                                                onmouseenter="admin_edit_user_showButtons({{ $user->id }})"
                                                                onmouseleave="admin_edit_user_hideButtons({{ $user->id }})">

                                                                <input type="file"
                                                                    id="admin_edit_user_profileimg{{ $user->id }}"
                                                                    accept="image/*" style="display: none;"
                                                                    name="image">

                                                                <label
                                                                    id="admin_edit_user_dropzoneLabel{{ $user->id }}"
                                                                    for="admin_edit_user_profileimg{{ $user->id }}"
                                                                    style="color: #888; cursor: pointer; font-size: 14px; padding: 10px;"
                                                                    class="dropzone-label">
                                                                    Drop an image here or click to upload
                                                                </label>

                                                                <img id="admin_edit_user_previewImage{{ $user->id }}"
                                                                    data-id="{{ $user->id }}" alt="Preview"
                                                                    src="{{ $user->image ? asset('web/profile/' . $user->image) : '' }}"
                                                                    style="{{ $user->image ? 'display: block;' : 'display: none;' }}
                                    position: absolute; max-width:150px; max-height: 150px; object-fit: contain;">

                                                                <div id="admin_edit_user_buttons{{ $user->id }}"
                                                                    class="action-buttons"
                                                                    style="display: {{ $user->image ? 'flex' : 'none' }}; position: absolute; bottom: 10px; gap: 5px;
                                    justify-content: center; align-items: center;">
                                                                    <i class="bi bi-x-circle me-auto"
                                                                        style="color: black; font-size: 18px;"
                                                                        onclick="admin_edit_user_deleteImage({{ $user->id }})"></i>
                                                                    <i class="bi bi-plus-circle ms-auto"
                                                                        onclick="admin_edit_user_triggerFileInput({{ $user->id }})"
                                                                        style="color: black; font-size: 18px;"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="alert alert-danger" style="display:none;"></div>

                                                        <div class="row mb-3">
                                                            <label for="dealershipName"
                                                                class="col-sm-4 col-form-label">Dealership Name*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <select name="dealershipName" class="form-select"
                                                                    style="color:#281F48;background-color:white;border:1px solid #281F48;text-align:center">
                                                                    @foreach ($dealershipNames as $dealershipName)
                                                                        <option value="{{ $dealershipName }}"
                                                                            {{ $user->dealershipName == $dealershipName ? 'selected' : '' }}>
                                                                            {{ $dealershipName }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="fullName" class="col-sm-4 col-form-label">Full
                                                                Name*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <input type="text" class="form-control" name="name"
                                                                    value="{{ $user->name }}"
                                                                    placeholder="Enter full name">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-4 col-form-label">Phone*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <input type="text" class="form-control" name="number"
                                                                    value="{{ $user->number }}"
                                                                    placeholder="Enter phone">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-4 col-form-label">Email*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <input type="email" class="form-control" name="email"
                                                                    value="{{ $user->email }}"
                                                                    placeholder="Enter email">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-4 col-form-label">Status*</label>
                                                            <div class="col-sm-8 pe-0">
                                                                <select name="status" class="form-select"
                                                                    style="color:#281F48;background-color:white;border:1px solid #281F48;text-align:center">
                                                                    <option value="active"
                                                                        {{ $user->status == 'active' ? 'selected' : '' }}>
                                                                        Active</option>
                                                                    <option value="inactive"
                                                                        {{ $user->status == 'inactive' ? 'selected' : '' }}>
                                                                        Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit"
                                                        class="btn custom-btn-nav rounded">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete User Modal -->
                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color:#F0F3F6 !important;">
                                            <form method="POST"
                                                action="{{ route('superadmin.user.destroy', $user->id) }}">
                                                <input type="hidden" name="deleted_id" value="{{ $user->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">
                                                        Confirm Deletion</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete user
                                                    <strong>{{ $user->name }}</strong>?
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        const initializeTables = () => {
            $('.datatable12').each(function() {
                if (!$.fn.DataTable.isDataTable(this)) {
                    $(this).DataTable({
                        pageLength: 25,
                        lengthChange: false
                    });
                }
            });
        };

        document.addEventListener('DOMContentLoaded', initializeTables);
    </script>


    <script>
        // Show buttons on hover
        function admin_edit_user_showButtons(id) {
            document.getElementById('admin_edit_user_buttons' + id).style.display = 'flex';
        }

        function admin_edit_user_hideButtons(id) {
            const image = document.getElementById('admin_edit_user_previewImage' + id);
            if (!image || image.style.display === 'none') {
                document.getElementById('admin_edit_user_buttons' + id).style.display = 'none';
            }
        }

        // Trigger file input manually
        function admin_edit_user_triggerFileInput(id) {
            const input = document.getElementById('admin_edit_user_profileimg' + id);
            if (input) {
                input.value = ''; // Clear to allow reselecting same file
                input.click();
            }
        }

        // Delete image preview
        function admin_edit_user_deleteImage(id) {
            const img = document.getElementById('admin_edit_user_previewImage' + id);
            const buttons = document.getElementById('admin_edit_user_buttons' + id);
            const input = document.getElementById('admin_edit_user_profileimg' + id);

            if (img) img.style.display = 'none';
            if (buttons) buttons.style.display = 'none';
            if (input) input.value = ''; // Reset file input
        }

        // Show preview when file is selected
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll("input[type='file'][id^='admin_edit_user_profileimg']").forEach(input => {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    const userId = this.id.replace('admin_edit_user_profileimg', '');
                    const preview = document.getElementById('admin_edit_user_previewImage' +
                        userId);
                    const buttons = document.getElementById('admin_edit_user_buttons' + userId);

                    if (file && preview) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                            if (buttons) buttons.style.display = 'flex';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        });
    </script>
@endsection
