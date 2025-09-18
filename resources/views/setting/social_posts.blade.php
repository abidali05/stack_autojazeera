@extends('layout.panel_layout.main')
@section('content')
    <style>
        div.dt-container .dt-length,
        div.dt-container .dt-search,
        div.dt-container .dt-info,
        div.dt-container .dt-processing,
        div.dt-container .dt-paging {
            color: inherit;
            display: flex;
            justify-content: end;
            padding: 5px 0px;
            font-size: 14px;
            font-weight: 600;
            align-items: center;
        }

        .table>:not(caption)>*>* {
            padding: 0.4rem .5rem;
        }

        table.dataTable>thead>tr>th {
            padding: 0px 10px 5px 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.3);
        }

        .badge {
            font-size: 12px;
            padding: 5px 10px;
        }

        img.post-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .nav-tabs .nav-link.active {
            font-weight: bold;
            border-color: #D90600;
            color: #D90600;
        }
    </style>

    <div class="container-fluid py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold primary-color-custom">Social Posts</h2>
            <p class="text-muted">Manage posts shared to your connected accounts</p>
        </div>

        {{-- ✅ Tabs --}}
        <ul class="nav nav-tabs justify-content-start mb-4" id="socialTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="facebook-tab" data-bs-toggle="tab" data-bs-target="#facebook"
                    type="button" role="tab">Facebook</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="instagram-tab" data-bs-toggle="tab" data-bs-target="#instagram" type="button"
                    role="tab">Instagram</button>
            </li>
        </ul>

        <div class="tab-content" id="socialTabsContent">

            {{-- Facebook Table --}}
            <div class="tab-pane fade show active" id="facebook" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-striped align-middle facebook-datatable">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Image</th>
                                <th>Type</th>
                                <th>Message</th>
                                {{-- <th>Created</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $facebookPosts = collect($posts)->where('platform', 'facebook'); @endphp
                            @foreach ($facebookPosts as $i => $post)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        @if (isset($post['data']['full_picture']))
                                            <img src="{{ $post['data']['full_picture'] }}" class="post-thumb"
                                                alt="fb-post">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($post['type']) }}</td>
                                    <td>{{ Str::limit($post['data']['message'] ?? 'No content', 60, '...') }}</td>
                                    {{-- <td>{{ \Carbon\Carbon::parse($post['created_at'])->format('d M Y H:i') }}</td> --}}
                                    <td>
                                        @if (isset($post['data']['permalink_url']))
                                            <a href="{{ $post['data']['permalink_url'] }}" target="_blank"
                                                class="btn btn-sm btn-primary text-decoration-none text-white"><i class="bi bi-eye"></i></a>
                                        @endif
                                        <form action="{{ route('social.delete', $post['id']) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this post?')"> <i class="bi bi-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Instagram Table --}}
            <div class="tab-pane fade" id="instagram" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-striped align-middle instagram-datatable">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Image</th>
                                <th>Type</th>
                                <th>Caption</th>
                                {{-- <th>Created</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $instagramPosts = collect($posts)->where('platform', 'instagram'); @endphp
                            @foreach ($instagramPosts as $i => $post)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        @if (isset($post['data']['media_url']))
                                            <img src="{{ $post['data']['media_url'] }}" class="post-thumb" alt="ig-post">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($post['type']) }}</td>
                                    <td>{{ Str::limit($post['data']['caption'] ?? 'No content', 60, '...') }}</td>
                                    {{-- <td>{{ \Carbon\Carbon::parse($post['created_at'])->format('d M Y H:i') }}</td> --}}
                                    <td>
                                        @if (isset($post['data']['permalink']))
                                            <a href="{{ $post['data']['permalink'] }}" target="_blank"
                                                class="btn btn-sm btn-primary text-decoration-none text-white"><i class="bi bi-eye"></i></a>
                                        @endif
                                        {{-- ❌ Delete not available for Instagram --}}
                                    </td>
                                </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.facebook-datatable, .instagram-datatable').DataTable({
                paging: true,
                pageLength: 10,
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
                `
            });
        });
    </script>
@endsection
