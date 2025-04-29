@extends('layouts.main')
@section('content')
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                                                        {{ $post->created_at->diffForHumans() }}
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
                                            <div class="comment-form mt-3 px-4 pb-3" id="comment-form-{{ $post->id }}"
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
                                        <a href="{{ $post->post->getDetailUrlAttribute() }}" class="listing-card">
                                            <div class="listing-image-container">
                                                <div class="image-carousel">
                                                    <div class="carousel-images">
                                                        @foreach ($post->post->images as $image)
                                                            <img src="{{ asset($image->image_path) }}"
                                                                class="img-fluid rounded" alt="Post image">
                                                        @endforeach
                                                    </div>
                                                    <button class="carousel-nav prev"
                                                        onclick="event.preventDefault(); prevImage(this);">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </button>
                                                    <button class="carousel-nav next"
                                                        onclick="event.preventDefault(); nextImage(this);">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </button>
                                                    <div class="carousel-dots">
                                                        @for ($i = 0; $i < count($post->post->images); $i++)
                                                            <span class="dot {{ $i === 0 ? 'active' : '' }}"></span>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <form action="{{ route('trustlist.toggle', ['id' => $post->post->id]) }}"
                                                    method="POST" class="trustlist-form">
                                                    @csrf
                                                    <button type="button" class="trustlist-button trustlist-btn"
                                                        data-post-id="{{ $post->post->id }}"
                                                        data-saved="{{ Auth::check() && $post->isSaved ? 'true' : 'false' }}"
                                                        data-authenticated="{{ Auth::check() ? 'true' : 'false' }}"
                                                        onclick="event.preventDefault(); handleSave(this);">
                                                        <i
                                                            class="{{ Auth::check() && $post->isSaved ? 'fas' : 'far' }} fa-bookmark {{ Auth::check() && $post->isSaved ? 'text-primary' : '' }}"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="listing-content">
                                                <div class="listing-header">
                                                    <h3 class="listing-title">{{ $post->post->title }}</h3>
                                                    <div class="listing-rating">
                                                        <i class="fas fa-star"></i>
                                                        <span>4.96</span>
                                                    </div>
                                                </div>
                                                <p class="listing-location">{{ $post->post->location }}</p>
                                                <p class="listing-dates">{{ $post->post->content }}</p>
                                            </div>
                                        </a>
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
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('progress', () => ({
                message: '',
                unreadCount: 0,
                init() {
                    unreadCount = this.fetchNotificationCount();
                    Echo.channel('followers')
                        .subscribed(() => {
                            console.log('Subscribed to followers');
                        })
                        .listen('FollowEventReverb', (e) => {
                            console.log('event:', e);
                            if({{ auth()->user()->id }} === e.follower_id){
                                showToast('Bạn đang theo dõi ' + e.following_name, 'success');
                            }
                            if({{ auth()->user()->id }} === e.following_id) {
                                this.unreadCount++;
                                showToast(e.following_name + ' đang theo dõi bạn', 'success');
                            }
                            console.log('unreadCount:', this.unreadCount);
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
            },
            }))
        });
    </script>
@endsection
