@extends('layout.superadmin_layout.main')
@section('content')
<style>
 .form-select{
	max-width:100%;
	}
		
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: white;
    line-height: 24px;
	  max-width:100% !important;
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
    border:none;
}
	.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent white transparent;
    border-width: 0 6px 7px 6px;
}.select2-container--default .select2-selection--single .select2-selection__arrow b {
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
	/* Target the scrollable container */
.table-responsive {
    scrollbar-width: thin;               /* For Firefox */
    scrollbar-color: #281F48 #f1f1f1;    /* Thumb and track for Firefox */
}

/* Webkit-based browsers (Chrome, Edge, Safari) */
.table-responsive::-webkit-scrollbar {
    width: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1; /* Light background */
}



</style>
<div class="container mt-5">
        <div class="row align-items-center mb-4">
            <div class="col-auto">
                <a href="{{route('superadmin.dashboard')}}" class="text-white me-3">
                    <img src="{{asset('web/images/icon.svg')}}" alt="back-arrow" width="50px" height="35px">
                </a>
            </div>
            <div class="col-auto">
                <h2 class="sec mb-0 primary-color-custom">Dealer Management </h2>
            </div>
        </div>
        <div class="row align-items-center mb-4">
            <div class="col-md-4 mb-md-0 mb-2">
                <div class="input-group " style="width:100%">
                    <!-- <span class="input-group-text" id="search-addon">
                        <i class="bi bi-search"></i>
                    </span> -->
                    <form id="dealerForm" action="" method="get"  style="width:100%">
                    <select class="form-select  select-search "  style="width:100%" name="user_id" style="color:black !important"  aria-label="Search Dealer" aria-describedby="search-addon">
                        <option selected>Select Dealer</option>
                        <option value="0" >All</option>
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->dealershipName}}</option>
                  @endforeach
                    </select>
                    </form>
                </div>
            </div>			<div class="col-md-8">@if ($users->hasPages())
    <nav class="d-flex justify-content-end align-items-center">
        <!-- Page Info -->
     

        <!-- Pagination -->
     <ul class="pagination"
    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
    @if ($users->onFirstPage())
        <li style="display: inline-block;">
            <span
                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
        </li>
    @else
        @if (request()->isMethod('post'))
            <li style="display: inline-block;">
                <form method="POST" action="{{ url()->current() }}">
                    @csrf
                    <input type="hidden" name="page" value="{{ $posts->currentPage() - 1 }}">
                    <button type="submit"
                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                </form>
            </li>
        @else
            <li style="display: inline-block;">
                <a href="{{ $users->previousPageUrl() }}"
                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
            </li>
        @endif
    @endif

    @foreach ($users->links()->elements as $element)
        @if (is_string($element))
            <li style="display: inline-block;">
                <span
                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
            </li>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $users->currentPage())
                    <li style="display: inline-block;">
                        <span
                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #281F48; color: #fff;">{{ $page }}</span>
                    </li>
                @else
                    @if (request()->isMethod('post'))
                        <li style="display: inline-block;">
                            <form method="POST" action="{{ url()->current() }}">
                                @csrf
                                <input type="hidden" name="page" value="{{ $page }}">
                                <button type="submit"
                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">{{ $page }}</button>
                            </form>
                        </li>
                    @else
                        <li style="display: inline-block;">
                            <a href="{{ $url }}"
                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $page }}</a>
                        </li>
                    @endif
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($users->hasMorePages())
        @if (request()->isMethod('post'))
            <li style="display: inline-block;">
                <form method="POST" action="{{ url()->current() }}">
                    @csrf
                    <input type="hidden" name="page" value="{{ $users->currentPage() + 1 }}">
                    <button type="submit"
                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                </form>
            </li>
        @else
            <li style="display: inline-block;">
                <a href="{{ $users->nextPageUrl() }}"
                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</a>
            </li>
        @endif
    @else
        <li style="display: inline-block;">
            <span
                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</span>
        </li>
    @endif
</ul>

@endif</div>	<div class="col-4">	<span class="pt-md-3 pagination_count" style="font-size: 18px; color: #281F48; font-weight:700;">
 {{ ($users->currentPage() - 1) * $users->perPage() + 1 }}
    - {{ min($users->currentPage() * $users->perPage(), $users->total()) }}
    of {{ $users->total() }} Results
</span></div>
            <div class="col-md-8 text-end">
                <button class="btn custom-btn-nav rounded roleid p-0 " data-role="{{'1'}}"  data-bs-toggle="modal" data-bs-target="#addDealerModal">
					<span>  <i  class="bi bi-plus fs-4 p-0 m-0 "></i></span> <span class="pb-3">Add New Dealer</span>
                </button>
            </div>
        </div>
    </div>
    <div class="container table-responsive">
        <div class="row">
            <table class="table table-striped transparent-table align-middle datatable">
                <thead>
                    <tr>
                        <th>Sr#</th>
                        <th>Action</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Dealership Name</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Repeat this block for each row -->
                    @foreach($users as $key=> $user)
                    <tr>
						<td>{{$key+1}}</td>
                        <td>
                            <a  class=" me-2 " style="text-decoration:none;" title="Edit" data-bs-toggle="modal" data-bs-target="#editDealerModal{{$user->id}}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="#" class="primary-color-custom cancel" data-id="{{$user->id}}"  title="Delete"  data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                        <!-- <td><a  href="{{route('superadmin.dealeruser',$user->id)}}" >{{$user->name}}</a></td> -->
						<td>{{$user->name}}</td>
                        <td>{{$user->number}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->dealershipName}}</td>
                       
                        <td>{{$user->created_at->format('d M Y')}}</td>
                        <td>{{$user->updated_at ? $user->updated_at->format('d M Y') : 'N/A'}}</td>
                        <td>
                        @if($user->status == 'active')
                        <span class="badge text-bg-active">Active</span>
                        
                        @elseif($user->status == 'inactive')
                        
                        <span class="badge text-bg-danger">Inactive</span>
                        @endif
                    </td>
                       
                    </tr>
                    @include('superadmin.modal.edit_dealer')
                    @endforeach

                </tbody>
            </table>
        </div>
		          </div>       
<div class="container my-3">
		<div class="row d-flex justify-content-between">
			<div class="col-4">	<span class="pt-md-3 pagination_count" style="font-size: 18px; color: #281F48; font-weight:700;">
 {{ ($users->currentPage() - 1) * $users->perPage() + 1 }}
    - {{ min($users->currentPage() * $users->perPage(), $users->total()) }}
    of {{ $users->total() }} Results
</span></div>
					<div class="col-4">@if ($users->hasPages())
    <nav class="d-flex justify-content-end align-items-center">
        <!-- Page Info -->
     

        <!-- Pagination -->
        <ul class="pagination"
    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
    @if ($users->onFirstPage())
        <li style="display: inline-block;">
            <span
                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
        </li>
    @else
        @if (request()->isMethod('post'))
            <li style="display: inline-block;">
                <form method="POST" action="{{ url()->current() }}">
                    @csrf
                    <input type="hidden" name="page" value="{{ $posts->currentPage() - 1 }}">
                    <button type="submit"
                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                </form>
            </li>
        @else
            <li style="display: inline-block;">
                <a href="{{ $users->previousPageUrl() }}"
                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
            </li>
        @endif
    @endif

    @foreach ($users->links()->elements as $element)
        @if (is_string($element))
            <li style="display: inline-block;">
                <span
                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
            </li>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $users->currentPage())
                    <li style="display: inline-block;">
                        <span
                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #281F48; color: #fff;">{{ $page }}</span>
                    </li>
                @else
                    @if (request()->isMethod('post'))
                        <li style="display: inline-block;">
                            <form method="POST" action="{{ url()->current() }}">
                                @csrf
                                <input type="hidden" name="page" value="{{ $page }}">
                                <button type="submit"
                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">{{ $page }}</button>
                            </form>
                        </li>
                    @else
                        <li style="display: inline-block;">
                            <a href="{{ $url }}"
                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $page }}</a>
                        </li>
                    @endif
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($users->hasMorePages())
        @if (request()->isMethod('post'))
            <li style="display: inline-block;">
                <form method="POST" action="{{ url()->current() }}">
                    @csrf
                    <input type="hidden" name="page" value="{{ $users->currentPage() + 1 }}">
                    <button type="submit"
                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                </form>
            </li>
        @else
            <li style="display: inline-block;">
                <a href="{{ $users->nextPageUrl() }}"
                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</a>
            </li>
        @endif
    @else
        <li style="display: inline-block;">
            <span
                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</span>
        </li>
    @endif
</ul>
    </nav>
@endif</div>
		</div></div>

    @if(isset($user))

    <form action="{{route('superadmin.dealer.destroy',$user->id)}}" method="post">
    @include('superadmin.modal.delete')
    </form>
    @endif
@endsection