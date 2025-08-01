{{-- @dd($bookings[0]) --}}
@extends('layout.panel_layout.main')

@section('content')
    <div class="container mt-3">
        <!-- Header Section -->
        <div class="d-flex align-items-center mb-3">

            <h2 class="sec mb-0 primary-color-custom">Service Quotes</h2>
        </div>

        <div class="table-section table-responsive">
            <table class="table table-striped transparent-table align-middle datatable1">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>User Phone</th>
                        <th>Vehicle Type</th>
                        <th>Vehicle</th>
                        {{-- <th>Model</th> --}}
                        <th>Body Type</th>
                        {{-- <th>Year</th> --}}
                        <th>Services</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $i => $booking)
                        <tr class="table-row">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->user->email }}</td>
                            <td>{{ $booking->user->number }}</td>
                            <td class="text-capitalize">{{ $booking->type }}</td>
                            <td>{{ $booking->make_r->name ?? ('' . ' ' . $booking->model_r->name ?? ('' . ' ' . '(' . $booking->year ?? '' . ')')) }}
                            </td>
                            {{-- <td>{{ $booking->model_r->name ?? 'N/A' }}</td> --}}
                            <td>{{ $booking->bodytype_r->name ?? 'N/A' }}</td>
                            {{-- <td>{{ $booking->year }}</td> --}}
                            {{-- <td>{{ $booking->comments }}</td> --}}
                            <td class="text-center">
                                <button class="btn " type="button" data-bs-toggle="modal"
                                    data-bs-target="#services-modal-{{ $booking->id }}">
                                    <i class="bi bi-eye me-1"></i>
                                </button>
                            </td>

                            <!-- Modal -->
                            <div class="modal fade" id="services-modal-{{ $booking->id }}" tabindex="-1"
                                aria-labelledby="servicesLabel-{{ $booking->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="servicesLabel-{{ $booking->id }}">
                                                <i class="bi bi-wrench-adjustable-circle me-2"></i>Services for
                                                {{ $booking->shop->name }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            @if ($booking->booking_services->count())
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach ($booking->booking_services as $service)
                                                        <span class="badge rounded-pill px-3 py-2"
                                                            style="background-color: #282435;">
                                                            {{ $service->shop_service->service->name ?? 'N/A' }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted mb-0">No services listed.</p>
                                            @endif

                                            <div class="mt-2">
                                                <h4 class="text-dark">Description</h4>
                                                {{ $booking->comments }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <td class="text-center">
                            @if ($booking->status == '0')
                                <span class="badge rounded-pill bg-danger" style="cursor: pointer">Pending</span>
                            @else
                                <span class="badge rounded-pill bg-success" style="cursor: pointer">Completed</span>
                            @endif
                            
                        </td> --}}
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $bookings->links('pagination::bootstrap-5') }}
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.datatable1').each(function() {
                var table = $(this).DataTable({
                    paging: true,
                    pageLength: 25,
                    lengthChange: false,
                    searching: true,
                    ordering: true,
                    scrollX: false,
                    order: [
                        [0, 'asc']
                    ],
                    language: {
                        search: "Search: "
                    },
                    dom: `
  <"search-wrapper mb-3"f>
  <"pagination-wrapper d-flex justify-content-between align-items-center mb-3"i p>
  rt
  <"pagination-wrapper d-flex justify-content-between align-items-center mt-3"i p>
  <"clear">
`

                });

                // Add search row
                $(this).find('thead').append('<tr class="search-row"></tr>');

                $(this).find('thead th').each(function(index) {
                    var title = $(this).text().trim();
                    var searchHtml = '';

                    if (title === 'Status') {
                        searchHtml =
                            '<select class="ads-column-search"><option value="">Any</option><option value="Active">Active</option><option value="InActive">InActive</option></select>';
                    }
                    // Create text inputs for other specified columns
                    else if (['User Name', 'User Email', 'User Phone', 'Vehicle Type','Vehicle','Body Type']
                        .includes(title)) {
                        searchHtml = '<input type="text" placeholder="Search ' + title +
                            '" class="ads-column-search"/>';
                    }

                    $(this).closest('thead').find('.search-row').append('<th>' + searchHtml +
                        '</th>');
                });

                // Apply search functionality
                $(this).find('.search-row input, .search-row select').on('keyup change', function() {
                    var columnIndex = $(this).closest('th').index();
                    table.column(columnIndex).search(this.value).draw();
                });
            });
        });
    </script>
@endsection
