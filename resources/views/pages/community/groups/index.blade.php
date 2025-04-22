@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container py-4">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Create Post Form -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <form action="{{ route('community.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="description" rows="3" class="form-control" placeholder="Bạn viết gì đi..." autocomplete="off"></textarea>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Đăng
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Posts -->
                    <div class="posts-container">
                        @forelse($posts as $post)
                            <div class="card shadow-sm mb-4" data-post-id="{{ $post->id }}">
                                <div class="card-body">
                                    <div class="border-bottom pb-2">
                                        <div class="d-flex align-items-center mb-3">
                                            <div>
                                                @if ($post->group)
                                                    <h5 class="mb-0">
                                                        {{ $post->group->name }}
                                                    </h5>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <small>{{ $post->user->name }}</small>
                                                        <small
                                                            class="d-block text-muted">{{ $post->created_at->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                @else
                                                    <h5 class="mb-0">{{ $post->user->name }}</h5>
                                                    <small
                                                        class="d-block text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="post-content mb-3">
                                            {{ $post->description }}
                                        </div>
                                        <div class="d-flex gap-4 text-muted">
                                            <button class="btn btn-link text-decoration-none p-0">
                                                <i class="far fa-heart me-1"></i>
                                                Thích
                                            </button>
                                            @if (!$post->group || ($post->group && $post->group->members->contains(auth()->id())))
                                                <button class="btn btn-link text-decoration-none p-0 comment-toggle"
                                                    data-post-id="{{ $post->id }}">
                                                    <i class="far fa-comment me-1"></i>
                                                    Bình luận
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    @if (!$post->group || ($post->group && $post->group->members->contains(auth()->id())))
                                        <!-- Comment Form (Hidden by default) -->
                                        <div class="comment-form mt-3" id="comment-form-{{ $post->id }}"
                                            style="display: none;">
                                            <form action="{{ route('comments.store', $post) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <input type="hidden" name="group_id" value="{{ $post->group_id }}">
                                                <div class="input-group">
                                                    <input type="text" name="content" class="form-control"
                                                        placeholder="Viết bình luận..." autocomplete="off">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Comments Section -->
                                        <div class="comments-section mt-3">
                                            @if ($post->group)
                                                @if ($post->group->members->contains(auth()->id()))
                                                    <div class="comments-list">
                                                        @foreach ($post->comments->where('parent_id', null) as $comment)
                                                            @include('comments.partials.comment', [
                                                                'comment' => $comment,
                                                            ])
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        Bạn cần tham gia nhóm để xem bình luận
                                                    </div>
                                                @endif
                                            @else
                                                <div class="comments-list">
                                                    @foreach ($post->comments->where('parent_id', null) as $comment)
                                                        @include('comments.partials.comment', [
                                                            'comment' => $comment,
                                                        ])
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-info mt-3">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Bạn cần tham gia nhóm để bình luận bài viết này
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="card shadow-sm text-center py-5">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <h3 class="h4">Không có bài viết</h3>
                                <p class="text-muted">Hãy là người đầu tiên đăng bài!</p>
                            </div>
                        @endforelse

                        <!-- Load More Button -->
                        <div class="text-center mt-4">
                            <button class="btn btn-primary load-more-posts" style="display: none;">
                                <i class="fas fa-spinner fa-spin me-2"></i>
                                Tải thêm bài viết
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Create Group Button -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <a href="{{ route('groupss.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus-circle me-2"></i>
                                Tạo nhóm mới
                            </a>
                        </div>
                    </div>

                    <!-- Groups -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Tất cả các nhóm</h5>
                            @forelse($userGroups as $group)
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ $group->avatar ? asset($group->avatar) : asset('image/default/default-group-avatar.jpg') }}"
                                        class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <a href="{{ route('groupss.show', $group) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $group->name }}
                                        </a>
                                        <small class="d-block text-muted">{{ $group->member_count }} thành viên</small>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Bạn chưa tham gia nhóm nào</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentPage = 1;
            let isLoading = false;
            const postsContainer = document.querySelector('.posts-container');
            const loadMoreBtn = document.querySelector('.load-more-posts');

            // Show load more button if there are posts
            if (document.querySelectorAll('.card[data-post-id]').length > 0) {
                loadMoreBtn.style.display = 'block';
            }

            // Load more posts
            loadMoreBtn.addEventListener('click', function() {
                if (isLoading) return;
                isLoading = true;
                
                currentPage++;
                loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang tải...';
                
                fetch(`posts?page=${currentPage}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.message);
                    }
                    
                    data.posts.forEach(post => {
                        const postElement = createPostElement(post);
                        postsContainer.insertBefore(postElement, loadMoreBtn.parentElement);
                    });
                    
                    if (!data.hasMore) {
                        loadMoreBtn.style.display = 'none';
                    } else {
                        loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Tải thêm bài viết';
                    }
                })
                .catch(error => {
                    console.error('Error loading more posts:', error);
                    loadMoreBtn.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Lỗi khi tải bài viết';
                    // Reset button state after 3 seconds
                    setTimeout(() => {
                        loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Tải thêm bài viết';
                    }, 3000);
                })
                .finally(() => {
                    isLoading = false;
                });
            });

            // Function to create post element
            function createPostElement(post) {
                const div = document.createElement('div');
                div.className = 'card shadow-sm mb-4';
                div.dataset.postId = post.id;
                
                let groupInfo = '';
                if (post.group) {
                    groupInfo = `
                        <h5 class="mb-0">${post.group.name}</h5>
                        <div class="d-flex align-items-center gap-2">
                            <small>${post.user.name}</small>
                            <small class="d-block text-muted">${post.created_at}</small>
                        </div>
                    `;
                } else {
                    groupInfo = `
                        <h5 class="mb-0">${post.user.name}</h5>
                        <small class="d-block text-muted">${post.created_at}</small>
                    `;
                }
                
                div.innerHTML = `
                    <div class="card-body">
                        <div class="border-bottom pb-2">
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    ${groupInfo}
                                </div>
                            </div>
                            <div class="post-content mb-3">
                                ${post.description}
                            </div>
                            <div class="d-flex gap-4 text-muted">
                                <button class="btn btn-link text-decoration-none p-0">
                                    <i class="far fa-heart me-1"></i>
                                    Thích
                                </button>
                                <button class="btn btn-link text-decoration-none p-0 comment-toggle" data-post-id="${post.id}">
                                    <i class="far fa-comment me-1"></i>
                                    Bình luận
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                return div;
            }

            // Toggle comment form (bình luận chính)
            document.querySelectorAll('.comment-toggle').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.dataset.postId;
                    const form = document.getElementById(`comment-form-${postId}`);
                    form.style.display = form.style.display === 'none' ? 'block' : 'none';
                    if (form.style.display === 'block') {
                        form.querySelector('input[name="content"]').focus();
                    }
                });
            });

            // Toggle reply form (phản hồi)
            document.querySelectorAll('.reply-toggle').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.dataset.commentId;
                    const form = document.getElementById(`reply-form-${commentId}`);
                    form.style.display = form.style.display === 'none' ? 'block' : 'none';
                    if (form.style.display === 'block') {
                        form.querySelector('input[name="content"]').focus();
                    }
                });
            });
        });
    </script>

    <style>
        .post-content {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .btn-link:hover {
            color: #0d6efd !important;
        }

        @media (max-width: 768px) {
            .d-flex.gap-4 {
                flex-direction: column;
                gap: 1rem !important;
            }
        }
    </style>
@endsection
