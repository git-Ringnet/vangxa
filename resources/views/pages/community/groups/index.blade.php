@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container py-4">
            <div class="row">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <!-- Nút tạo nhóm mới ở đầu -->
                        <div class="swiper-slide">
                            <a href="{{ route('groupss.create') }}" class="text-decoration-none">
                                <div class="category-item text-center">
                                    <div class="category-name create-group">
                                        <i class="fas fa-plus me-1"></i>
                                        Tạo nhóm mới
                                    </div>
                                </div>
                            </a>
                        </div>
                        @foreach ($groups as $group)
                            <div class="swiper-slide">
                                <a href="{{ route('groupss.show', $group) }}" class="text-decoration-none">
                                    <div class="category-item text-center">
                                        <div class="category-name">{{ $group->name }}</div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev custom-nav"></div>
                    <div class="swiper-button-next custom-nav"></div>
                </div>
                <!-- Main Content -->
                <div class="col-lg-12">
                    <!-- Posts -->
                    <div class="posts-container">
                        @forelse($posts as $post)
                            <div class="card shadow-sm mb-4" data-post-id="{{ $post->id }}">
                                <div class="card-body">
                                    <div class="border-bottom pb-2">
                                        <div class="d-flex align-items-center mb-3">
                                            <div>
                                                <span>
                                                    <b>{{ $post->user->name }}</b>
                                                </span>
                                                @if ($post->group)
                                                    <span>></span>
                                                    <span><b>{{ $post->group->name }}</b></span>
                                                @endif
                                                <span>
                                                    {{ $post->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="post-content mb-3">
                                            {{ $post->description }}
                                        </div>
                                        <div class="d-flex gap-4 text-muted">
                                            <button class="btn btn-link text-decoration-none p-0 like-btn" 
                                                    data-post-id="{{ $post->id }}"
                                                    data-liked="{{ $post->likes->contains(auth()->id()) ? 'true' : 'false' }}">
                                                <i class="{{ $post->likes->contains(auth()->id()) ? 'fas' : 'far' }} fa-heart me-1 {{ $post->likes->contains(auth()->id()) ? 'text-danger' : '' }}"></i>
                                                <span class="like-count">{{ $post->likes->count() }}</span>
                                            </button>
                                            @if (!$post->group || ($post->group && $post->group->members->contains(auth()->id())))
                                                <button class="btn btn-link text-decoration-none p-0 comment-toggle"
                                                        data-post-id="{{ $post->id }}">
                                                    <i class="far fa-comment me-1"></i>
                                                    {{ count($post->comments) }}
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
            </div>
        </div>
        <!-- Button trigger modal -->
        <div class="create-post-btn mx-2 pb-3" data-bs-toggle="modal" data-bs-target="#postModal">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 2V18M18 10H2" stroke="white" stroke-width="3" stroke-linecap="round" />
            </svg>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('communities.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <textarea name="description" rows="3" class="form-control" placeholder="Bạn viết gì đi..." autocomplete="off"></textarea>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Đăng
                                </button>
                            </div>
                        </div>
                    </form>
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
                            loadMoreBtn.innerHTML =
                                '<i class="fas fa-spinner fa-spin me-2"></i>Tải thêm bài viết';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading more posts:', error);
                        loadMoreBtn.innerHTML =
                            '<i class="fas fa-exclamation-circle me-2"></i>Lỗi khi tải bài viết';
                        // Reset button state after 3 seconds
                        setTimeout(() => {
                            loadMoreBtn.innerHTML =
                                '<i class="fas fa-spinner fa-spin me-2"></i>Tải thêm bài viết';
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
                                <button class="btn btn-link text-decoration-none p-0 like-btn" 
                                        data-post-id="${post.id}"
                                        data-liked="${post.likes.is_liked}">
                                    <i class="${post.likes.is_liked ? 'fas' : 'far'} fa-heart me-1 ${post.likes.is_liked ? 'text-danger' : ''}"></i>
                                    <span class="like-count">${post.likes.count}</span>
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

            // Handle like button clicks
            document.querySelectorAll('.like-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.dataset.postId;
                    const isLiked = this.dataset.liked === 'true';
                    const icon = this.querySelector('i');
                    const countSpan = this.querySelector('.like-count');
                    const currentCount = parseInt(countSpan.textContent);

                    // Toggle like status
                    fetch(`/posts/${postId}/like`, {
                        method: isLiked ? 'DELETE' : 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update button state
                            this.dataset.liked = data.is_liked;
                            if (data.is_liked) {
                                icon.classList.remove('far');
                                icon.classList.add('fas', 'text-danger');
                            } else {
                                icon.classList.remove('fas', 'text-danger');
                                icon.classList.add('far');
                            }
                            
                            // Update count
                            countSpan.textContent = data.count;
                        } else {
                            console.error(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });

            const swiper = new Swiper(".mySwiper", {
                slidesPerView: "auto",
                spaceBetween: 15,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    320: {
                        slidesPerView: 3,
                    },
                    480: {
                        slidesPerView: 4,
                    },
                    768: {
                        slidesPerView: 6,
                    },
                    1024: {
                        slidesPerView: 8,
                    }
                },
                on: {
                    init: function() {
                        // Ẩn nút prev khi khởi tạo
                        document.querySelector('.swiper-button-prev').style.display = 'none';
                    },
                    slideChange: function() {
                        const prevButton = document.querySelector('.swiper-button-prev');
                        // Hiển thị/ẩn nút prev dựa vào vị trí slide
                        if (this.activeIndex > 0) {
                            prevButton.style.display = 'flex';
                        } else {
                            prevButton.style.display = 'none';
                        }

                        // Thêm hiệu ứng mờ cho slide tiếp theo
                        const slides = this.slides;
                        slides.forEach((slide, index) => {
                            if (index > this.activeIndex + this.params.slidesPerView - 1) {
                                slide.style.opacity = '0.5';
                            } else {
                                slide.style.opacity = '1';
                            }
                        });
                    }
                }
            });
        });
    </script>

    <style>
        @media (max-width: 768px) {
            .d-flex.gap-4 {
                flex-direction: column;
                gap: 1rem !important;
            }

            .swiper {
                padding: 10px 30px;
            }

            .category-button {
                width: 50px;
                height: 50px;
                font-size: 1rem;
            }

            .category-name {
                font-size: 0.8rem;
                max-width: 80px;
            }
        }

        .swiper {
            width: 100%;
            padding: 10px 40px;
            margin-bottom: 20px;
            background: white;
            position: relative;
        }

        .swiper-slide {
            width: auto;
            display: flex;
            justify-content: center;
            transition: opacity 0.3s ease;
        }

        /* Tạo hiệu ứng gradient mờ dần cho phần cuối */
        .swiper::after {
            content: '';
            position: absolute;
            right: 40px;
            top: 0;
            height: 100%;
            width: 100px;
            background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1));
            pointer-events: none;
            z-index: 1;
        }

        .category-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 5px;
        }

        .category-name {
            font-size: 0.9rem;
            color: #495057;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
            text-align: center;
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.2s ease;
        }

        a:hover .category-name {
            background: #e9ecef;
            color: #212529;
        }

        .custom-nav {
            width: 32px;
            height: 32px;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 50%;
            color: #495057;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .custom-nav:hover {
            background: #f8f9fa;
            color: #212529;
        }

        .swiper-button-prev::after,
        .swiper-button-next::after {
            font-size: 14px;
            font-weight: bold;
        }

        .swiper-button-disabled {
            opacity: 0;
            pointer-events: none;
        }

        .swiper-button-prev {
            left: 5px;
            opacity: 1 !important;
        }

        .swiper-button-next {
            right: 5px;
        }

        @media (max-width: 768px) {
            .swiper {
                padding: 10px 30px;
            }

            .category-name {
                font-size: 0.8rem;
                max-width: 80px;
                padding: 6px 12px;
            }

            .swiper::after {
                width: 60px;
                right: 30px;
            }
        }

        .category-name.create-group {
            background: #e7f1ff;
            color: #0d6efd;
            border: 2px dashed #0d6efd;
            font-weight: 500;
        }

        .category-name.create-group:hover {
            background: #0d6efd;
            color: white;
            border-style: solid;
        }
    </style>
@endsection
