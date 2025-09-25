@extends('layout.website_layout.bikes.car_main')
@section('title', $category->name . ' - Forum')
@section('content')
<style>
    .btnb{
color: #281F48;
background-color:white;
border: 1px solid #281F48;
padding: 10px 20px;
border-radius: 5px;
font-size: 14px;
font-weight: 500;
    }
    .redd{
        color: #D90600;
    }
    .blu{
        color: #281F48;
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
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item "><a href="{{ route('forum.index') }}" class="blu">Forum</a></li>
                        <li class="breadcrumb-item active redd" style="color: #F40000">{{ $category->name }}</li>
                    </ol>
                </nav>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 style="color: #281F48; font-weight: 700;">{{ $category->name }}</h2>
                    @auth
                        <button type="button" class="btn btnb new-thread-btn" >
                            New Thread
                        </button>
                    @endauth
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        @forelse($threads as $thread)
                            <div class="border-bottom p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <div class="d-flex align-items-center">
                                            @if ($thread->is_pinned)
                                                <i class="fas fa-thumbtack text-warning me-2"></i>
                                            @endif
                                            @if ($thread->is_locked)
                                                <i class="fas fa-lock text-danger me-2"></i>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">
                                                    <a href="{{ route('forum.thread', $thread->id) }}"
                                                        style="color: #281F48; text-decoration: none; font-weight: 600;">
                                                        {{ $thread->title }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">
                                                    by {{ $thread->user->name }}
                                                    {{ $thread->created_at->diffForHumans() }}
                                                </small>
                                                <div class="mt-1">
                                                    <small class="text-muted me-3">
                                                        <i class="fas fa-heart text-danger"></i> {{ $thread->likes_count }}
                                                    </small>
                                                    <small class="text-muted me-3">
                                                        <i class="fas fa-eye"></i> {{ $thread->views_count }}
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="fas fa-comments"></i> {{ $thread->posts_count }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        @if ($thread->latestPost)
                                            <small>
                                                Last post by {{ $thread->latestPost->user->name }}<br>
                                                {{ $thread->latestPost->created_at->diffForHumans() }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        @auth
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-outline-primary copy-link"
                                                    data-url="{{ route('forum.thread', $thread->id) }}">
                                                    <i class="fas fa-link"></i>
                                                </button>
                                                <button
                                                    class="btn btn-sm {{ $thread->isFavoritedBy() ? 'btn-warning' : 'btn-outline-secondary' }} favorite-btn"
                                                    data-thread-id="{{ $thread->id }}"
                                                    data-favorited="{{ $thread->isFavoritedBy() ? 'true' : 'false' }}">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted">
                                No threads in this category yet.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{ $threads->links() }}
            </div>
        </div>
    </div>

    <!-- New Thread Container -->
    @auth
        <div class="thread-modal-container" id="threadModalContainer">
            <div class="thread-modal-content">
                <div class="thread-modal-header">
                    <h5>Create New Thread in {{ $category->name }}</h5>
                    <button type="button" class="close-modal-btn">&times;</button>
                </div>
                <form action="{{ route('forum.store-thread', $category->id) }}" method="POST">
                    @csrf
                    <div class="thread-modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Thread Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="body" class="form-label">Message</label>
                            {{-- <div id="editor"></div> --}}
                            {{-- <textarea name="body" id="body" style="display: none;"></textarea> --}}
                            <textarea name="body" class="form-control rounded-1 mb-4 " id="editor" rows="6" placeholder="Description"></textarea>
                        </div>
                        <button type="submit" class="btn" style="background-color: #F40000; color: white;">Create
                            Thread</button>
                    </div>
                </form>
            </div>
        </div>
    @endauth

    <style>
        .thread-modal-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            display: none;
        }

        .thread-modal-content {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) translateY(100%);
            width: 90%;
            max-width: 800px;
            background: white;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-out;
        }

        .thread-modal-container.show .thread-modal-content {
            transform: translateX(-50%) translateY(0);
        }

        .thread-modal-header {
            background-color: #281F48;
            color: white;
            padding: 15px 20px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .thread-modal-body {
            padding: 20px;
        }

        .thread-modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .close-modal-btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        .favorite-btn:hover {
            font-weight: bold;
            transform: scale(1.05);
        }

        .ck-editor .ck-content img {
            max-width: 300px;
            height: auto;
        }

        .cke_notification_warning {
            display: none !important;
        }

    </style>

    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/upload/upload.js"></script> --}}
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Favorite functionality
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const threadId = this.dataset.threadId;
                    const button = this;

                    fetch('{{ route('forum.toggle-favorite') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                thread_id: threadId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.favorited) {
                                button.className = 'btn btn-sm btn-warning favorite-btn';
                                button.dataset.favorited = 'true';
                            } else {
                                button.className =
                                    'btn btn-sm btn-outline-secondary favorite-btn';
                                button.dataset.favorited = 'false';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Please login to add favorites.');
                        });
                });
            });

            // Copy link functionality
            document.querySelectorAll('.copy-link').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.dataset.url;
                    const button = this;

                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(url).then(() => {
                            showCopySuccess(button);
                        }).catch(() => {
                            fallbackCopyTextToClipboard(url, button);
                        });
                    } else {
                        fallbackCopyTextToClipboard(url, button);
                    }
                });
            });

            function showCopySuccess(button) {
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check"></i>';
                setTimeout(() => {
                    button.innerHTML = originalText;
                }, 1000);
            }

            function fallbackCopyTextToClipboard(text, button) {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                try {
                    document.execCommand('copy');
                    showCopySuccess(button);
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                    alert('Copy failed. Please copy manually: ' + text);
                }

                document.body.removeChild(textArea);
            }

            // Thread modal functionality
            let editor;
            const threadModal = document.getElementById('threadModalContainer');
            const newThreadBtn = document.querySelector('.new-thread-btn');
            const closeModalBtns = document.querySelectorAll('.close-modal-btn');

            newThreadBtn.addEventListener('click', function() {
                threadModal.style.display = 'block';
                setTimeout(() => {
                    threadModal.classList.add('show');
                }, 10);

                CKEDITOR.replace('editor', {
                    filebrowserUploadUrl: "{{ route('forum.upload-image', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form',
                    toolbar: [{
                            name: 'basicstyles',
                            items: ['Bold', 'Italic']
                        },
                        {
                            name: 'paragraph',
                            items: ['NumberedList', 'BulletedList']
                        }, // comma = lists
                        {
                            name: 'insert',
                            items: ['Image']
                        },
                        {
                            name: 'styles',
                            items: ['Format']
                        }
                    ],
                    removeButtons: '' // ensures only above remain
                });

            });

            closeModalBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    threadModal.classList.remove('show');
                    setTimeout(() => {
                        threadModal.style.display = 'none';
                        if (editor) {
                            editor.destroy();
                            editor = null;
                        }
                    }, 300);
                });
            });

            // Handle form submission
            threadModal.querySelector('form').addEventListener('submit', function(e) {
                if (editor) {
                    document.getElementById('body').value = editor.getData();
                }
            });
        });
    </script>

@endsection
