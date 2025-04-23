@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container py-4">
            <div class="row">
                <div class="swiper-container">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @if (Auth::check())
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
                            @endif
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
                                                    <a class="text-decoration-none text-dark" href="{{ route('groupss.show', $post->group) }}">
                                                        <span><b>{{ $post->group->name }}</b></span>
                                                    </a>
                                                @endif
                                                <span>
                                                    {{ $post->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="post-content mb-3">
                                            {{ $post->description }}
                                        </div>
                                        @if ($post->images->count() > 0)
                                            <div class="post-images mb-3" data-post-id="{{ $post->id }}"
                                                data-total-images="{{ $post->images->count() }}"
                                                data-images='@json($post->images->pluck('image_path'))'>
                                                @if ($post->images->count() == 1)
                                                    <div class="single-image">
                                                        <img src="{{ asset($post->images[0]->image_path) }}"
                                                            alt="Ảnh bài viết" class="img-fluid rounded cursor-pointer"
                                                            onclick="showImage(this.src, {{ $post->id }}, 0)">
                                                    </div>
                                                @else
                                                    <div class="row g-2">
                                                        @foreach ($post->images->take(4) as $index => $image)
                                                            <div
                                                                class="{{ $post->images->count() == 2 ? 'col-6' : 'col-4' }}">
                                                                <div class="position-relative">
                                                                    <img src="{{ asset($image->image_path) }}"
                                                                        alt="Ảnh bài viết"
                                                                        class="img-fluid rounded cursor-pointer"
                                                                        onclick="showImage(this.src, {{ $post->id }}, {{ $index }})">
                                                                    @if ($index == 3 && $post->images->count() > 4)
                                                                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 rounded d-flex align-items-center justify-content-center cursor-pointer"
                                                                            onclick="showImage(this.parentElement.querySelector('img').src, {{ $post->id }}, 3)">
                                                                            <span
                                                                                class="text-white fs-4">+{{ $post->images->count() - 4 }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="d-flex gap-4 text-muted">
                                            @if (Auth::check())
                                                <button class="btn btn-link text-decoration-none p-0 like-btn"
                                                    data-post-id="{{ $post->id }}"
                                                    data-liked="{{ $post->likes->contains(auth()->id()) ? 'true' : 'false' }}">
                                                    <i
                                                        class="{{ $post->likes->contains(auth()->id()) ? 'fas' : 'far' }} fa-heart me-1 {{ $post->likes->contains(auth()->id()) ? 'text-danger' : '' }}"></i>
                                                    <span class="like-count">{{ $post->likes->count() }}</span>
                                                </button>
                                                @if (!$post->group || ($post->group && $post->group->members->contains(auth()->id())))
                                                    <button class="btn btn-link text-decoration-none p-0 comment-toggle"
                                                        data-post-id="{{ $post->id }}">
                                                        <i class="far fa-comment me-1"></i>
                                                        {{ count($post->comments) }}
                                                    </button>
                                                @endif
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
                                        @if (!Auth::check())
                                            <div class="alert alert-info mt-3">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Bạn cần đăng nhập để bình luận
                                            </div>
                                        @endif
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
        @if (Auth::check())
            <div class="create-post-btn mx-2 pb-3" data-bs-toggle="modal" data-bs-target="#postModal">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 2V18M18 10H2" stroke="white" stroke-width="3" stroke-linecap="round" />
                </svg>
            </div>
        @endif
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
                            <textarea name="description" rows="3" class="form-control" placeholder="Bạn viết gì đi..."
                                autocomplete="off"></textarea>
                            <div class="mb-3">
                                <label for="images" class="form-label">Thêm ảnh</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple
                                    accept="image/*">
                                <div class="form-text">Bạn có thể chọn nhiều ảnh cùng lúc</div>
                            </div>
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
    <x-community.community-js />
    <style>
        /* Container cha bao quanh .swiper */
        .swiper-container {
            position: relative;
            width: 80%;
            max-width: 800px;
            /* Tăng max-width để hiển thị nhiều slide hơn */
            margin: 0 auto;
        }

        /* Container của Swiper */
        .swiper {
            width: 100%;
            padding: 10px 20px;
            /* Tăng padding phải để gradient không che nội dung */
            margin-bottom: 20px;
            background: white;
            position: relative;
            overflow: hidden;
        }

        /* Wrapper chứa các slide */
        .swiper-wrapper {
            display: flex;
            transition: transform 0.3s ease;
        }

        /* Slide */
        .swiper-slide {
            width: 120px !important;
            display: flex;
            justify-content: center;
            transition: opacity 0.3s ease;
            margin-right: 10px !important;
        }

        /* Gradient mờ dần */
        .swiper::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 60px;
            /* Giảm width của gradient để không che nội dung */
            background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1));
            pointer-events: none;
            z-index: 1;
        }

        /* Nút prev/next */
        .custom-nav {
            width: 32px;
            height: 32px;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 50%;
            color: #495057;
            display: flex !important;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 60%;
            transform: translateY(-50%);
            z-index: 2;
            transition: all 0.3s ease;
        }

        .custom-nav:hover {
            background: #f8f9fa;
            color: #212529;
        }

        .swiper-button-prev {
            left: -40px;
            opacity: 1 !important;
        }

        .swiper-button-next {
            right: -40px;
            opacity: 1 !important;
        }

        .swiper-button-prev::after {
            content: '\2039';
            font-size: 14px;
            font-weight: bold;
        }

        .swiper-button-next::after {
            content: '\203A';
            font-size: 14px;
            font-weight: bold;
        }

        .swiper-button-disabled {
            opacity: 0.5 !important;
            pointer-events: none;
        }

        /* Category item */
        .category-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 5px;
        }

        /* Category name */
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

        /* Responsive với các breakpoint */
        @media (max-width: 240px) {
            .swiper-container {
                width: 95%;
            }

            .swiper {
                padding: 10px 10px;
            }

            .swiper-slide {
                width: 90px !important;
                margin-right: 8px !important;
            }

            .category-name {
                font-size: 0.7rem;
                max-width: 70px;
                padding: 6px 10px;
            }

            .swiper::after {
                width: 30px;
                right: 0;
            }

            .swiper-button-prev {
                left: -20px;
            }

            .swiper-button-next {
                right: -20px;
            }
        }

        @media (max-width: 320px) {
            .swiper-container {
                width: 90%;
            }

            .swiper {
                padding: 10px 15px;
            }

            .swiper-slide {
                width: 100px !important;
                margin-right: 8px !important;
            }

            .category-name {
                font-size: 0.7rem;
                max-width: 80px;
                padding: 6px 10px;
            }

            .swiper::after {
                width: 40px;
                right: 0;
            }

            .swiper-button-prev {
                left: -25px;
            }

            .swiper-button-next {
                right: -25px;
            }
        }

        @media (max-width: 480px) {
            .swiper-container {
                width: 90%;
            }

            .swiper {
                padding: 10px 15px;
            }

            .swiper-slide {
                width: 100px !important;
                margin-right: 8px !important;
            }

            .category-name {
                font-size: 0.8rem;
                max-width: 80px;
                padding: 6px 12px;
            }

            .swiper::after {
                width: 50px;
                right: 0;
            }

            .swiper-button-prev {
                left: -30px;
            }

            .swiper-button-next {
                right: -30px;
            }
        }

        @media (max-width: 768px) {
            .swiper-container {
                width: 90%;
            }

            .swiper {
                padding: 10px 20px;
            }

            .swiper-slide {
                width: 100px !important;
                margin-right: 8px !important;
            }

            .category-name {
                font-size: 0.8rem;
                max-width: 80px;
                padding: 6px 12px;
            }

            .swiper::after {
                width: 60px;
                right: 0;
            }

            .swiper-button-prev {
                left: -30px;
            }

            .swiper-button-next {
                right: -30px;
            }
        }

        @media (min-width: 1024px) {
            .swiper-container {
                width: 80%;
                max-width: 1000px;
                /* Tăng max-width để hiển thị nhiều slide */
            }

            .swiper {
                padding: 10px 20px;
            }

            .swiper-slide {
                width: 120px !important;
                margin-right: 10px !important;
            }

            .category-name {
                font-size: 0.9rem;
                max-width: 150px;
                padding: 8px 16px;
            }

            .swiper::after {
                width: 80px;
                right: 0;
            }

            .swiper-button-prev {
                left: -40px;
            }

            .swiper-button-next {
                right: -40px;
            }
        }

        @media (min-width: 1440px) {
            .swiper-container {
                width: 80%;
                max-width: 1200px;
            }

            .swiper {
                padding: 10px 20px;
            }

            .swiper-slide {
                width: 120px !important;
                margin-right: 30px !important;
            }

            .category-name {
                font-size: 1rem;
                max-width: 160px;
                padding: 8px 16px;
            }

            .swiper::after {
                width: 100px;
                right: 0;
            }

            .swiper-button-prev {
                left: -50px;
            }

            .swiper-button-next {
                right: -50px;
            }
        }

        /* Style cho nút tạo nhóm mới */
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
