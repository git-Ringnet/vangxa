@extends('layouts.main')
@section('content')
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Swiper Styles */
        .swiper {
            width: 100%;
            height: 100%;
            border-radius: 12px;
        }

        .swiper-slide {
            text-align: center;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #fff;
            background: rgba(0, 0, 0, 0.3);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            --swiper-navigation-size: 20px;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 18px;
        }

        .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.8;
        }

        .swiper-pagination-bullet-active {
            background: #fff;
            opacity: 1;
        }
    </style>

    <div x-data="{}">
        <div class="flex main-container">
            <!-- Sidebar -->
            <div class="sidebar w-1/6 bg-white border-r min-h-screen p-4">
                <div x-data="{ isOpen: true }" class="dropdown">
                    <h3 class="dropdown-header" x-on:click="isOpen = !isOpen">
                        Không gian sở hữu
                        <i class="fa fa-chevron-down" :class="{ 'active': isOpen }"></i>
                    </h3>
                    <ul class="space-y-2" x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-4">

                        @if ($user->ownedPosts && $user->ownedPosts->count() > 0)
                            @foreach ($user->ownedPosts as $ownedPost)
                                <li class="dropdown-item flex items-center space-x-2">
                                    <span
                                        class="{{ ['text-blue-500', 'text-green-500', 'text-orange-500', 'text-purple-500', 'text-red-500'][rand(0, 4)] }}">
                                        <i
                                            class="fa {{ $ownedPost->type == 'dining' ? 'fa-utensils' : 'fa-building' }}"></i>
                                    </span>
                                    <a href="{{ $ownedPost->detail_url }}" class="hover:underline">
                                        <span>{{ $ownedPost->title }}</span>
                                    </a>
                                    <span class="text-xs text-gray-500">
                                        ({{ optional($ownedPost->owners->find($user->id)->pivot)->role ?? 'Chủ sở hữu' }})
                                    </span>
                                </li>
                            @endforeach
                        @else
                            <li class="dropdown-item text-gray-500">
                                <i class="fa fa-info-circle mr-2"></i>
                                Không có không gian sở hữu nào
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Main profile -->
            <div class="main-profile w-full">
                <div class="profile-header flex items-center justify-center space-x-8">
                    <div class="avatar-container">
                        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                            class="avatar-image" alt="Avatar" />
                        <!-- Chỉ hiển thị nút cập nhật ảnh đại diện nếu là profile của chính mình -->
                        @if ($isOwnProfile)
                            <div class="camera-icon-wrapper" data-bs-toggle="modal" data-bs-target="#updateAvatarModal">
                                <i class="fas fa-camera camera-icon"></i>
                            </div>
                        @endif
                    </div>
                    <div class="user-info">
                        <div class="user-name">
                            <h2>{{ $user->name }}</h2>
                            <span class="user-badge">Người đóng góp nổi bật</span>
                            @if (!$isOwnProfile && Auth::check())
                                <button
                                    class="btn btn-sm follow-btn ml-2 {{ $isFollowing ? 'btn-secondary' : 'btn-primary' }}"
                                    data-user-id="{{ $user->id }}"
                                    data-action="{{ $isFollowing ? 'unfollow' : 'follow' }}">
                                    <i class="fas {{ $isFollowing ? 'fa-user-minus' : 'fa-user-plus' }}"></i>
                                    <span class="follow-text">{{ $isFollowing ? 'Hủy theo dõi' : 'Theo dõi' }}</span>
                                </button>
                            @endif
                            <!-- Dropdown thay thế nút chia sẻ -->
                            <div class="dropdown d-inline-block ml-2">
                                <button class="btn btn-sm btn-light dropdown-toggle no-arrow" type="button"
                                    id="profileActionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="profileActionDropdown">
                                    <li>
                                        <a class="dropdown-item share-profile-btn" href="#" data-bs-toggle="modal"
                                            data-bs-target="#shareProfileModal">
                                            <i class="fas fa-share-alt mr-2"></i> Chia sẻ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item copy-profile-link" href="javascript:void(0);"
                                            data-clipboard-text="{{ route('profile.show', $user->id) }}">
                                            <i class="far fa-copy mr-2"></i> Sao chép liên kết
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item report-profile" href="javascript:void(0);">
                                            <i class="fas fa-flag mr-2"></i> Báo cáo
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="user-bio">{{ $user->bio ?? '' }}</div>
                        <div class="user-stats">
                            <span><span class="stat-count">{{ count($user->posts) }}</span> bài viết</span>
                            <a href="{{ route('user.followers', $user->id) }}" class="user-stat-link">
                                <span><span class="stat-count followers-count">{{ $followersCount }}</span> người theo
                                    dõi</span>
                            </a>
                            <a href="{{ route('user.following', $user->id) }}" class="user-stat-link">
                                <span><span class="stat-count">{{ $followingCount }}</span> đang theo dõi</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div x-data="{ tab: 'posts' }" class="tabs">
                    <div class="tabs-nav">
                        <a href="#" @click.prevent="tab = 'posts'"
                            :class="tab === 'posts' ? 'tab-link active' : 'tab-link'">Bài viết</a>
                        <a href="#" @click.prevent="tab = 'trusted'"
                            :class="tab === 'trusted' ? 'tab-link active' : 'tab-link'">Danh sách tin cậy</a>
                        <a href="#" @click.prevent="tab = 'reviews'"
                            :class="tab === 'reviews' ? 'tab-link active' : 'tab-link'">Bài đánh giá</a>
                    </div>

                    <div class="tab-content">
                        <!-- Posts Tab -->
                        <div x-show="tab === 'posts'">
                            @if (isset($user->posts) && $user->posts->count() > 0)
                                @forelse($user->posts as $post)
                                    <div class="post-item" data-post-id="{{ $post->id }}">
                                        <div class="post-header">
                                            <div class="d-flex align-items-center mb-3">
                                                <div>
                                                    <span>
                                                        <b>{{ $post->user->name }}</b>
                                                    </span>
                                                    @if ($post->group)
                                                        <span>></span>
                                                        <span><b>{{ $post->group->name }}</b></span>
                                                    @endif
                                                    <span class="text-gray-500 text-sm">
                                                        {{ $post->created_at ? $post->created_at->diffForHumans() : 'Không xác định' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="post-body">
                                            <div class="mb-3">
                                                {{ $post->description }}
                                            </div>
                                        </div>

                                        <div class="post-footer">
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
                                        </div>

                                        @if (!$post->group || ($post->group && $post->group->members->contains(auth()->id())))
                                            <!-- Comment Form (Hidden by default) -->
                                            <div class="comment-form mt-3 px-4 pb-3"
                                                id="comment-form-{{ $post->id }}" style="display: none;">
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
                                            <div class="comments-section mt-3 px-4 pb-3">
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
                                            <div class="alert alert-info mt-3 mx-3 mb-3">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Bạn cần tham gia nhóm để bình luận bài viết này
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                        <h3 class="h4">Không có bài viết</h3>
                                        <p class="text-muted">Hãy là người đầu tiên đăng bài!</p>
                                    </div>
                                @endforelse
                            @endif
                        </div>

                        <!-- Trusted List Tab -->
                        <div x-show="tab === 'trusted'" class="py-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @if ($user->trustlists !== null)
                                    @foreach ($user->trustlists as $post)
                                        <div class="listing-card custom-card border-post"
                                            style="background-color: #faf6e9; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                                            <a href="{{ $post->post->getDetailUrlAttribute() }}">
                                                <div class="position-relative">
                                                    <div class="p-3">
                                                        <div class="my-3 text-post">
                                                            <h3><b>{{ $post->post->title }}</b></h3>
                                                        </div>
                                                        <div class="image-container position-relative"
                                                            style="height: 400px; border-radius: 12px; overflow: hidden;">
                                                            @if ($post->post->images && count($post->post->images) > 0)
                                                                <div class="swiper post-swiper"
                                                                    id="swiper-{{ $post->post->id }}">
                                                                    <div class="swiper-wrapper">
                                                                        @foreach ($post->post->images as $image)
                                                                            <div class="swiper-slide">
                                                                                <img src="{{ asset($image->image_path) }}"
                                                                                    class="img-fluid" alt="Post image"
                                                                                    style="width: 100%; height: 400px; object-fit: cover;">
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    @if (count($post->post->images) > 1)
                                                                        <div class="swiper-pagination"></div>
                                                                        <div class="swiper-button-next"></div>
                                                                        <div class="swiper-button-prev"></div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div class="no-image"
                                                                    style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: #f5f5f5;">
                                                                    <i class="fas fa-image"
                                                                        style="font-size: 48px; color: #ccc;"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="bookWrap"
                                                            onclick="event.preventDefault(); event.stopPropagation(); showStoryModal({{ $post->post->id }})">
                                                            <div class="book">
                                                                <div class="cover">
                                                                    <img src="image/book.png"
                                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                                    <div class="circleImage">
                                                                        <img src="https://img.tripi.vn/cdn-cgi/image/width=700,height=700/https://gcs.tripi.vn/public-tripi/tripi-feed/img/474090Ypg/hinh-anh-girl-xinh-dep-de-thuong_025104504.jpg"
                                                                            alt="Avatar">
                                                                    </div>
                                                                </div>
                                                                <div class="spine"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="listing-content">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="fw-semibold mb-1 text-post"
                                                            style="font-size: 16px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                                            {{ $post->post->description }}
                                                        </div>
                                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($post->post->address) }}"
                                                            target="_blank" class="btn-map rounded-pill">
                                                            <svg width="50" height="24" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M15 6V21M15 6L21 3V18L15 21M15 6L9 3M15 21L9 18M9 18L3 21V6L9 3M9 18V3"
                                                                    stroke="#7C4D28" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="text-muted small mb-1"
                                                        style="font-size: 14px; color: #8d6e63 !important;">
                                                        {{ $post->post->address }}
                                                        <span class="mx-1">|</span>
                                                        <span class="distance-text"
                                                            data-lat="{{ $post->post->latitude ?? '' }}"
                                                            data-lng="{{ $post->longitude ?? '' }}">-- km</span>
                                                    </div>
                                                    <div class="small mb-2 text-post" style="font-weight: 500;">
                                                        {{ number_format($post->min_price, 0, ',', '.') }}k -
                                                        {{ number_format($post->max_price, 0, ',', '.') }}k/ng
                                                    </div>
                                                    <div style="color: #8d6e63; font-size: 13px;">
                                                        <span>Thứ 2 - thứ 7: 8g - 19g</span>
                                                    </div>
                                                    <hr class="my-2">
                                                    <div class="d-flex justify-content-between post-actions">
                                                        <button class="btn-action">
                                                            <i class="far fa-bookmark"></i>
                                                            <span>4,2K</span>
                                                        </button>
                                                        <button class="btn-action">
                                                            <i class="far fa-comment-dots"></i>
                                                            <span>4,2K</span>
                                                        </button>
                                                        <button class="btn-action">
                                                            <i class="fas fa-share"></i>
                                                            <span>4,2K</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <!-- Story Modal -->
                                        <x-modal-story :post="$post->post"></x-modal-story>
                                    @endforeach
                                @else
                                    <div class="col-span-full text-center py-5">
                                        <i class="fas fa-list fa-3x text-muted mb-3"></i>
                                        <h3 class="h4">Chưa có bài viết nào trong danh sách tin cậy</h3>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div x-show="tab === 'reviews'" class="py-4">
                            <div class="reviews-list space-y-4">
                                @if ($user->reviews != null && count($user->reviews) > 0)
                                    @foreach ($user->reviews as $review)
                                        <div class="post-item p-4">
                                            <div class="flex items-start">
                                                <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}"
                                                    alt="{{ $review->user->name }}" class="w-12 h-12 rounded-full mr-3">
                                                <div class="flex-grow">
                                                    <h4 class="font-semibold">{{ $review->user->name }}</h4>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex text-warning">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="fas fa-star {{ $i <= $review->food_rating ? 'text-warning' : 'text-gray-300' }}"></i>
                                                            @endfor
                                                        </div>
                                                        <span
                                                            class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
                                                    </div>
                                                    <div class="mt-2 flex items-center">
                                                        @switch($review->satisfaction_level)
                                                            @case(5)
                                                                <i class="fas fa-laugh-beam text-success mr-2 text-xl"></i>
                                                            @break

                                                            @case(4)
                                                                <i class="fas fa-laugh text-info mr-2 text-xl"></i>
                                                            @break

                                                            @case(3)
                                                                <i class="fas fa-meh text-warning mr-2 text-xl"></i>
                                                            @break

                                                            @case(2)
                                                                <i class="fas fa-frown text-danger mr-2 text-xl"></i>
                                                            @break

                                                            @case(1)
                                                                <i class="fas fa-sad-tear text-danger mr-2 text-xl"></i>
                                                            @break
                                                        @endswitch
                                                        <p class="text-gray-700">{{ $review->comment }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                        <h3 class="h4">Chưa có đánh giá</h3>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật avatar - chỉ hiển thị khi người dùng đang xem profile của chính họ -->
    @if ($isOwnProfile)
        <div class="modal fade" id="updateAvatarModal" tabindex="-1" aria-labelledby="updateAvatarModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateAvatarModalLabel">Cập nhật ảnh đại diện</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.update-avatar') }}" method="POST" enctype="multipart/form-data"
                        id="avatarForm">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="input-group">
                                    <input class="form-control" type="file" id="avatar" accept="image/*" required>
                                    <button type="button" class="btn btn-outline-secondary" id="resetFileInput">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="form-text">Hỗ trợ định dạng: JPG, JPEG, PNG, GIF. Kích thước tối đa: 2MB.</div>
                            </div>

                            <!-- Khu vực hiển thị và cắt ảnh -->
                            <div class="crop-container mt-4" style="display: none;">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <div class="img-container cropper-container">
                                            <img id="cropperImage" src="" class="img-fluid">
                                        </div>

                                        <!-- Thanh điều khiển chính -->
                                        <div class="cropper-controls">
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-control"
                                                data-method="rotate" data-option="-90" title="Xoay trái">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-control"
                                                data-method="rotate" data-option="90" title="Xoay phải">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-control"
                                                data-method="zoom" data-option="0.1" title="Phóng to">
                                                <i class="fas fa-search-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-control"
                                                data-method="zoom" data-option="-0.1" title="Thu nhỏ">
                                                <i class="fas fa-search-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-control"
                                                data-method="reset" title="Đặt lại">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 preview-column">
                                        <div class="preview-container text-center">
                                            <p class="mb-2 fw-bold">Xem trước</p>
                                            <div id="avatarPreview" class="preview-avatar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="avatar" id="croppedAvatar">
                        </div>
                        <div class="modal-footer">
                            <div class="w-100 d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-primary" id="saveAvatar" disabled>Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Cropper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="{{ asset('js/profile.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <script src="{{ asset('js/follow-handler.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('progress', () => ({
                message: '',
                unreadCount: 0,
                init() {
                    this.fetchNotificationCount();
                    // Chỉ lắng nghe trên kênh private để tránh thông báo trùng lặp
                    Echo.private(`user.{{ auth()->user()->id }}`)
                        .listen('FollowEventReverb', (e) => {
                            console.log('Private FollowEventReverb received:', e);
                            console.log('Status from event:', e.status);
                            console.log('Action from event:', e.action);
                            console.log('Message from event:', e.message);

                            // Debug user IDs
                            const currentUserId = {{ auth()->user()->id }};
                            console.log('Current user ID:', currentUserId);
                            console.log('Follower ID:', e.follower_id);
                            console.log('Following ID:', e.following_id);

                            // Xử lý khi người dùng hiện tại là người được theo dõi/hủy theo dõi
                            if ({{ auth()->user()->id }} === e.following_id) {
                                this.unreadCount++;
                                if (e.status) {
                                    console.log('Showing follow toast (following)');
                                    showToast(e.follower_name + ' đã bắt đầu theo dõi bạn',
                                        'success');
                                } else {
                                    console.log('Showing unfollow toast (following)');
                                    showToast(e.follower_name + ' đã hủy theo dõi bạn', 'info');
                                }
                            }
                        })
                        .listen('UnfollowEvent', (e) => {
                            console.log('Private UnfollowEvent received:', e);

                            // Xử lý khi người dùng hiện tại là người được theo dõi/hủy theo dõi
                            if ({{ auth()->user()->id }} === e.following_id) {
                                this.unreadCount++;
                                console.log('Showing unfollow toast (following)');
                                showToast(e.follower_name + ' đã hủy theo dõi bạn', 'info');
                            }
                        });
                },
                fetchNotificationCount() {
                    fetch('/notifications/count')
                        .then(response => response.json())
                        .then(data => {
                            this.unreadCount = data.count;
                        })
                        .catch(error => {
                            console.error('Lỗi khi lấy số thông báo:', error);
                        });
                }
            }));
        });

        // Global function để show toast từ bất kỳ đâu trong trang
        function showToast(message, type = 'success') {
            const toastContainer = document.querySelector('.toast-container') || (() => {
                const container = document.createElement('div');
                container.className = 'toast-container';
                document.body.appendChild(container);
                return container;
            })();

            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <div class="toast-content">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'info' ? 'fa-info-circle' : 'fa-exclamation-circle'}"></i>
                    <span>${message}</span>
                </div>
                <button class="toast-close">×</button>
                <div class="toast-progress"></div>
            `;

            toastContainer.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 10);

            const progress = toast.querySelector('.toast-progress');
            progress.style.transition = 'transform 5000ms linear';
            progress.style.transform = 'scaleX(0)';

            toast.querySelector('.toast-close').addEventListener('click', () => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            });

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 5000);

            return toast;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý sao chép liên kết profile
            var profileClipboard = new ClipboardJS('.copy-profile-link');

            profileClipboard.on('success', function(e) {
                alert('Đã sao chép liên kết vào bộ nhớ tạm');
                e.clearSelection();
            });

            // Xử lý nút báo cáo
            $('.report-profile').on('click', function() {
                alert('Chức năng báo cáo đang được phát triển');
            });
        });
        // Hàm tính khoảng cách Haversine
        function haversine(lat1, lon1, lat2, lon2) {
            function toRad(x) {
                return x * Math.PI / 180;
            }
            var R = 6371; // km
            var dLat = toRad(lat2 - lat1);
            var dLon = toRad(lon2 - lon1);
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        // Hàm cập nhật khoảng cách
        function updateDistances() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;
                    document.querySelectorAll('.distance-text').forEach(function(el) {
                        var lat = el.dataset.lat;
                        var lng = el.dataset.lng;
                        if (lat && lng) {
                            var dist = haversine(userLat, userLng, parseFloat(lat), parseFloat(lng));
                            el.textContent = dist.toFixed(1) + ' km';
                        }
                    });
                });
            }
        }

        function showStoryModal(postId) {
            const modal = document.getElementById(`storyModal-${postId}`);
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeStoryModal(postId) {
            const modal = document.getElementById(`storyModal-${postId}`);
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.querySelectorAll('.story-modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                    document.body.style.overflow = 'auto';
                }
            });
        });

        // Initialize Swiper instances
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all Swiper instances
            document.querySelectorAll('.post-swiper').forEach(function(swiperElement) {
                const swiperContainer = swiperElement;
                const postId = swiperContainer.id.split('-')[1];

                const swiper = new Swiper(`#swiper-${postId}`, {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    loop: true,
                    pagination: {
                        el: `#swiper-${postId} .swiper-pagination`,
                        clickable: true,
                    },
                    navigation: {
                        nextEl: `#swiper-${postId} .swiper-button-next`,
                        prevEl: `#swiper-${postId} .swiper-button-prev`,
                    },
                });
            });

            // Update distances
            updateDistances();
        });
    </script>

    <!-- Modal chia sẻ profile -->
    <div class="modal fade" id="shareProfileModal" tabindex="-1" aria-labelledby="shareProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareProfileModalLabel">Chia sẻ trang cá nhân</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-3">Chia sẻ trang cá nhân của {{ $user->name }} qua mạng xã hội</p>

                    @php
                        $profileUrl = route('profile.show', $user->id);
                        $profileTitle = $user->name . ' - trang cá nhân trên ' . config('app.name', 'Laravel');
                    @endphp

                    <x-social-share :url="$profileUrl" :title="$profileTitle" />
                </div>
            </div>
        </div>
    </div>
@endsection
