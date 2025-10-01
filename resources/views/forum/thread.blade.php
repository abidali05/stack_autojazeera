
@extends('layout.website_layout.bikes.car_main')
@section('title', $thread->title . ' - Forum')
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
    .blu img {
    width: 100px !important;
    height: 100px !important;
    object-fit: cover;
    border-radius: 6px; /* optional */
    margin-right: 10px;
}
</style>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('forum.index') }}" class="blu">Forum</a></li>
                        <li class="breadcrumb-item"><a class="blu"
                                href="{{ route('forum.category', $thread->category->id) }}">{{ $thread->category->name }}</a>
                        </li>
                        <li class="breadcrumb-item active" style="color: #F40000">{{ Str::limit($thread->title, 50) }}</li>
                    </ol>
                </nav>

                <div class="card mb-4">
                    <div class="card-header" style="background-color: #281F48; color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                       <div>
                             <h5 class="mb-0">{{ $thread->title }}</h5>
                                 <small class="d-block mt-2">
                            <i class="fas fa-eye"></i> {{ $thread->views_count }} views •
                            <i class="fas fa-comments"></i> {{ $thread->posts()->count() }} posts •
                            <i class="fas fa-users"></i> {{ $thread->posts()->select('user_id')->distinct()->count() + 1 }}
                            participants
                        </small>
                       </div>
                            @auth
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-light like-btn" data-type="thread"
                                        data-id="{{ $thread->id }}"
                                        data-liked="{{ $thread->isLikedBy() ? 'true' : 'false' }}">
                                        <i class="fas fa-heart {{ $thread->isLikedBy() ? 'text-danger' : '' }}"></i>
                                        <span class="likes-count">{{ $thread->likes_count }}</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-light copy-link"
                                        data-url="{{ route('forum.thread', $thread->id) }}">
                                        <i class="fas fa-link"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-light favorite-btn"
                                        data-thread-id="{{ $thread->id }}"
                                        data-favorited="{{ $thread->isFavoritedBy() ? 'true' : 'false' }}">
                                        <i class="fas fa-star {{ $thread->isFavoritedBy() ? 'text-warning' : '' }}"></i>
                                    </button>
                                </div>
                            @endauth
                        </div>
                   
                    </div>
                </div>

                @foreach ($posts as $post)
                    <div class=" mb-3 rounded" style="border: 1px solid #281F48" id="post-{{ $post->id }}">
                        <div class="card-body">
                            <div class="row d-flex align-items-center">
                                <div class="col-md-2 text-center border-end">
                                    <div class="mb-2">
                                        <img src="{{ $post->user->image ? asset('web/profile/' . $post->user->image) : asset('web/images/avatar.png') }}"
                                            class="rounded-circle" width="50" height="50" alt="User">
                                    </div>
                                    <strong>{{ $post->user->name }}</strong><br>
                                    <small class="blu">{{ $post->created_at->format('M d, Y') }}</small><br>
                                    <small class="blu">Posts: {{ $post->user->forumPosts()->count() }}</small>
                                </div>
                                <div class="col-md-10 p-3">
                                    <div class="mb-3 blu">{!! $post->body !!}</div>

                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="d-flex gap-2">
                                            @auth
                                                <button class="btn btn-sm btn-outline-primary like-btn" data-type="post"
                                                    data-id="{{ $post->id }}"
                                                    data-liked="{{ $post->isLikedBy() ? 'true' : 'false' }}">
                                                    <i class="fas fa-heart {{ $post->isLikedBy() ? 'text-danger' : '' }}"></i>
                                                    <span class="likes-count">{{ $post->likes_count }}</span>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary reply-btn"
                                                    data-post-id="{{ $post->id }}"
                                                    data-post-author="{{ $post->user->name }}">
                                                    <i class="fas fa-reply"></i> Reply
                                                </button>
                                                <button class="btn btn-sm btn-outline-info copy-link"
                                                    data-url="{{ route('forum.thread', $thread->id) }}#post-{{ $post->id }}">
                                                    <i class="fas fa-link"></i>
                                                </button>
                                            @endauth
                                        </div>
                                        <div>
                                            @auth
                                                @if ($post->user_id === Auth::id())
                                                    <form action="{{ route('forum.delete-post', $post->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>

                                    <!-- Nested Replies -->
                                    @foreach ($post->replies as $reply)
                                        <div class="ms-4 mt-3 px-3" id="post-{{ $reply->id }}">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong>{{ $reply->user->name }}</strong>
                                                    <small
                                                        class="text-muted ms-2">({{ $reply->user->forumPosts()->count() }}
                                                        posts)</small>
                                                </div>
                                                <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="mt-2 blu">{!! $reply->body !!}</div>
                                            @auth
                                                <div class="d-flex gap-2 mt-2">
                                                    <button class="btn btn-sm btn-outline-primary like-btn" data-type="post"
                                                        data-id="{{ $reply->id }}"
                                                        data-liked="{{ $reply->isLikedBy() ? 'true' : 'false' }}">
                                                        <i
                                                            class="fas fa-heart {{ $reply->isLikedBy() ? 'text-danger' : '' }}"></i>
                                                        <span class="likes-count">{{ $reply->likes_count }}</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-secondary reply-btn"
                                                        data-post-id="{{ $reply->id }}"
                                                        data-post-author="{{ $reply->user->name }}">
                                                        <i class="fas fa-reply"></i> Reply
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info copy-link"
                                                        data-url="{{ route('forum.thread', $thread->id) }}#post-{{ $reply->id }}">
                                                        <i class="fas fa-link"></i>
                                                    </button>
                                                </div>
                                            @endauth
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $posts->links() }}

                @auth
                    @if (!$thread->is_locked)
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-lg main-reply-btn btnb mb-2"
                            >
                                <i class="fas fa-comment"></i> Post Reply
                            </button>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            This thread is locked. No new replies can be posted.
                        </div>
                    @endif
                @else
                    <div class="alert alert-info">
                       <p> Please <a href="{{ route('login') }}" style="color: #F40000">login</a> to post a reply.</p>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Reply Containers -->
    @auth
        @if (!$thread->is_locked)
            <div class="reply-modal-container" id="mainReplyContainer">
                <div class="reply-modal-content">
                    <div class="reply-modal-header">
                        <h5>Post Reply to: {{ Str::limit($thread->title, 50) }}</h5>
                        <button type="button" class="close-reply-btn">&times;</button>
                    </div>
                    <form action="{{ route('forum.store-reply', $thread->id) }}" method="POST">
                        @csrf
                        <div class="reply-modal-body">
                            <div class="mb-3">
                                <label class="form-label">Your Reply</label>
                                <textarea name="body" class="form-control rounded-1 mb-4 " id="main-editor" rows="6"
                                    placeholder="Description"></textarea>
                            </div>
                            <button type="submit" class="btn btnb" >Post
                                Reply</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <div class="reply-modal-container" id="nestedReplyContainer">
            <div class="reply-modal-content">
                <div class="reply-modal-header">
                    <h5>Reply to <span id="reply-author"></span></h5>
                    <button type="button" class="close-nested-btn">&times;</button>
                </div>
                <form action="{{ route('forum.store-reply', $thread->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" id="reply-parent-id">
                    <div class="reply-modal-body">
                        <div class="mb-3">
                            <label class="form-label">Your Reply</label>
                            <div id="nested-editor"></div>
                            {{-- <textarea name="body" id="nested-body" style="display: none;"></textarea> --}}
                            <textarea name="body" class="form-control rounded-1 mb-4 " id="editor" rows="6"
                                placeholder="Description"></textarea>
                        </div>
                        <button type="submit" class="btn btnb" >Post
                            Reply</button>
                    </div>
                </form>
            </div>
        </div>
    @endauth

    <style>
        .reply-modal-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            display: none;
        }

        .reply-modal-content {
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

        .reply-modal-container.show .reply-modal-content {
            transform: translateX(-50%) translateY(0);
        }

        .reply-modal-header {
            background-color: #281F48;
            color: white;
            padding: 15px 20px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reply-modal-body {
            padding: 20px;
        }

        .reply-modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .close-reply-btn,
        .close-nested-btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        .ck-editor .ck-content img {
            max-width: 300px;
            height: auto;
        }

        .cke_notification_warning {
            display: none !important;
        }
    </style>

   <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let mainEditor, nestedEditor;
        const mainReplyContainer = document.getElementById('mainReplyContainer');
        const nestedReplyContainer = document.getElementById('nestedReplyContainer');
        const mainReplyBtn = document.querySelector('.main-reply-btn');
        const replyBtns = document.querySelectorAll('.reply-btn');

        // ---------- Image Button Override ----------
      // ---------- Image Button Override ----------
CKEDITOR.on('dialogDefinition', function (ev) {
    if (ev.data.name === 'image') {
        ev.data.definition.onShow = function () {
            this.hide(); // CKEditor ka default modal hide karo

            let input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/png, image/jpeg'; // ✅ sirf jpg + jpeg + png

            input.onchange = function (e) {
                let file = e.target.files[0];
                if (file) {
                    // ✅ allowed mime types
                    const allowedTypes = ['image/jpeg', 'image/png'];

                    if (!allowedTypes.includes(file.type)) {
                        alert("Only JPG, JPEG, and PNG images are allowed.");
                        return;
                    }

                    // ✅ max size check (2MB = 2 * 1024 * 1024 bytes)
                    const maxSize = 10 * 1024 * 1024;
                    if (file.size > maxSize) {
                        alert("Image size must be less than 2MB.");
                        return;
                    }

                    // ✅ insert image if valid
                    let reader = new FileReader();
                    reader.onload = function (evt) {
                        let editor = ev.editor;
                        editor.insertHtml(
                            '<img src="' + evt.target.result + '" style="max-width:200px; height:auto;"/>'
                        );
                    };
                    reader.readAsDataURL(file);
                }
            };

            input.click();
        };
    }
});

        // --------------------------------------------

        // Main reply modal
        if (mainReplyBtn) {
            mainReplyBtn.addEventListener('click', function() {
                mainReplyContainer.style.display = 'block';
                setTimeout(() => {
                    mainReplyContainer.classList.add('show');
                }, 10);

                mainEditor = CKEDITOR.replace('main-editor', {
                    contentsCss: 'body { max-width: 100%; } img { width:100px !important; height:100px !important; object-fit:cover; }',
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
                        { name: 'insert', items: ['Image'] },
                        { name: 'styles', items: ['Format'] }
                    ]
                });
            });
        }

        // Nested reply modal
        replyBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const postId = this.dataset.postId;
                const postAuthor = this.dataset.postAuthor;

                document.getElementById('reply-parent-id').value = postId;
                document.getElementById('reply-author').textContent = postAuthor;

                nestedReplyContainer.style.display = 'block';
                setTimeout(() => {
                    nestedReplyContainer.classList.add('show');
                }, 10);

                nestedEditor = CKEDITOR.replace('editor', {
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
                        { name: 'insert', items: ['Image'] },
                        { name: 'styles', items: ['Format'] }
                    ]
                });
            });
        });

        // Close main reply
        document.querySelectorAll('.close-reply-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                mainReplyContainer.classList.remove('show');
                setTimeout(() => {
                    mainReplyContainer.style.display = 'none';
                    if (mainEditor) {
                        mainEditor.destroy();
                        mainEditor = null;
                    }
                }, 300);
            });
        });

        // Close nested reply
        document.querySelectorAll('.close-nested-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                nestedReplyContainer.classList.remove('show');
                setTimeout(() => {
                    nestedReplyContainer.style.display = 'none';
                    if (nestedEditor) {
                        nestedEditor.destroy();
                        nestedEditor = null;
                    }
                }, 300);
            });
        });

        // ---------------- Form Submissions ----------------

        // Main Reply form
        if (mainReplyContainer) {
            const mainForm = mainReplyContainer.querySelector('form');
            const mainBtn = mainForm.querySelector('button[type=submit]');

            mainForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                if (mainEditor) {
                    formData.set('body', mainEditor.getData());
                }

                // Loader show
                const oldHtml = mainBtn.innerHTML;
                mainBtn.disabled = true;
                mainBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Posting...';

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    if (response.ok) location.reload();
                })
                .catch(() => location.reload())
                .finally(() => {
                    mainBtn.disabled = false;
                    mainBtn.innerHTML = oldHtml;
                });
            });
        }

        // Nested Reply form
        const nestedForm = nestedReplyContainer.querySelector('form');
        const nestedBtn = nestedForm.querySelector('button[type=submit]');

        nestedForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            if (nestedEditor) {
                formData.set('body', nestedEditor.getData());
            }

            // Loader show
            const oldHtml = nestedBtn.innerHTML;
            nestedBtn.disabled = true;
            nestedBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Posting...';

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => {
                if (response.ok) location.reload();
            })
            .catch(() => location.reload())
            .finally(() => {
                nestedBtn.disabled = false;
                nestedBtn.innerHTML = oldHtml;
            });
        });

        // ---------------- Like functionality ----------------
        document.addEventListener('click', function(e) {
            if (e.target.closest('.like-btn')) {
                e.preventDefault();
                const button = e.target.closest('.like-btn');
                const type = button.dataset.type;
                const id = button.dataset.id;

                fetch('{{ route('forum.toggle-like') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ type, id })
                })
                .then(response => response.json())
                .then(data => {
                    const icon = button.querySelector('svg.fa-heart, i.fa-heart');
                    const count = button.querySelector('.likes-count');

                    if (icon && count) {
                        if (data.liked) {
                            icon.classList.add('text-danger');
                            button.dataset.liked = 'true';
                        } else {
                            icon.classList.remove('text-danger');
                            button.dataset.liked = 'false';
                        }
                        count.textContent = data.likes_count;
                    }
                })
                .catch(() => alert('Please login to like posts.'));
            }
        });

        // ---------------- Favorite functionality ----------------
        document.addEventListener('click', function(e) {
            if (e.target.closest('.favorite-btn')) {
                e.preventDefault();
                const button = e.target.closest('.favorite-btn');
                const threadId = button.dataset.threadId;

                fetch('{{ route('forum.toggle-favorite') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ thread_id: threadId })
                })
                .then(response => response.json())
                .then(data => {
                    const icon = button.querySelector('svg.fa-star, i.fa-star');
                    if (icon) {
                        if (data.favorited) {
                            icon.classList.add('text-warning');
                            button.dataset.favorited = 'true';
                        } else {
                            icon.classList.remove('text-warning');
                            button.dataset.favorited = 'false';
                        }
                    }
                })
                .catch(() => alert('Please login to add favorites.'));
            }
        });

        // ---------------- Copy link functionality ----------------
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
                alert('Copy failed. Please copy manually: ' + text);
            }

            document.body.removeChild(textArea);
        }
    });
</script>

@endsection
