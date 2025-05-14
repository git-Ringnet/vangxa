@foreach ($posts as $post)
    <div class="listing-card custom-card border-post"
        style="background-color: #faf6e9; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <a href="{{ route('dining.detail-dining', $post->id) }}">
            <div class="position-relative">
                <div class="p-3">
                    <div class="my-3 text-post">
                        <h3><b>{{ $post->title }}</b></h3>
                    </div>
                    <div class="image-container position-relative"
                        style="height: 400px; border-radius: 12px; overflow: hidden;">
                        @if (count($post->images) > 0)
                            <div class="swiper post-swiper" id="swiper-{{ $post->id }}">
                                <div class="swiper-wrapper">
                                    @foreach ($post->images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ asset($image->image_path) }}" class="img-fluid"
                                                alt="Post image" style="width: 100%; height: 400px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                                @if (count($post->images) > 1)
                                    <div class="swiper-pagination"></div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                @endif
                            </div>
                        @else
                            <div class="no-image"
                                style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: #f5f5f5;">
                                <i class="fas fa-image" style="font-size: 48px; color: #ccc;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="bookWrap"
                        onclick="event.preventDefault(); event.stopPropagation(); showStoryModal({{ $post->id }})">
                        <div class="book">
                            <div class="cover">
                                <img src="image/sách.png" style="width: 100%; height: 100%; object-fit: cover;">
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
                        {{ $post->description }}
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($post->address) }}"
                        target="_blank" class="btn-map rounded-pill">
                        <svg width="50" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 6V21M15 6L21 3V18L15 21M15 6L9 3M15 21L9 18M9 18L3 21V6L9 3M9 18V3"
                                stroke="#7C4D28" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
                <div class="text-muted small mb-1" style="font-size: 14px; color: #8d6e63 !important;">
                    {{ $post->address }}
                    <span class="mx-1">|</span>
                    <span class="distance-text" data-lat="{{ $post->latitude ?? '' }}"
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
    <div class="story-modal" id="storyModal-{{ $post->id }}">
        <div class="story-modal-content">
            <!-- User Profile Section -->
            <div class="story-profile-section">
                <div class="story-profile-header">
                    <div class="story-user-main">
                        <div class="story-avatar">
                            <img src="{{ $post->user->avatar ?? 'https://via.placeholder.com/150' }}"
                                alt="User Avatar">
                            @if ($post->user->is_verified ?? false)
                                <span class="verified-badge">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            @endif
                        </div>
                        <div class="story-user-info">
                            <h2>{{ $post->user->name ?? 'Anonymous' }}</h2>
                            <p class="user-type">Chủ nhà siêu cấp</p>
                        </div>
                    </div>
                    <button class="story-close-btn" onclick="closeStoryModal({{ $post->id }})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Stats Section -->
                <div class="story-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $post->reviews_count ?? 19 }}</span>
                        <span class="stat-label">Bài đánh giá</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($post->rating ?? 4.95, 2) }} <i
                                class="fas fa-star"></i></span>
                        <span class="stat-label">Xếp hạng</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $post->years_active ?? 9 }}</span>
                        <span class="stat-label">Năm kinh nghiệm đón tiếp khách</span>
                    </div>
                </div>

                <!-- User Details -->
                <div class="story-details">
                    <div class="detail-item">
                        <i class="fas fa-briefcase"></i>
                        <div class="detail-text">
                            <strong>Công việc:</strong>
                            <p>{{ $post->user->occupation ?? 'The Nature\'s Grove' }}</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-graduation-cap"></i>
                        <div class="detail-text">
                            <strong>Nơi từng theo học:</strong>
                            <p>{{ $post->user->education ?? 'St. Josephs' }}</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-language"></i>
                        <div class="detail-text">
                            <strong>Ngôn ngữ:</strong>
                            <p>Tiếng Anh, Tiếng Việt</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="detail-text">
                            <strong>Sống tại:</strong>
                            <p>{{ $post->address ?? 'Chưa cập nhật' }}</p>
                        </div>
                    </div>
                </div>

                <!-- About Section -->
                <div class="story-about">
                    <p>{{ $post->description ?? 'Chưa có mô tả' }}</p>
                </div>

                <!-- Interests Section -->
                <div class="story-interests">
                    <h3>Sở thích</h3>
                    <div class="interest-tags">
                        <span class="interest-tag">
                            <i class="fas fa-hiking"></i>
                            Hoạt động ngoài trời
                        </span>
                        <span class="interest-tag">
                            <i class="fas fa-camera"></i>
                            Nhiếp ảnh
                        </span>
                        <span class="interest-tag">
                            <i class="fas fa-music"></i>
                            Nhạc sống
                        </span>
                        <span class="interest-tag">
                            <i class="fas fa-utensils"></i>
                            Nấu ăn
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

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

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
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

    function handleSave(button) {
        const postId = button.dataset.postId;
        const isAuthenticated = button.dataset.authenticated === 'true';

        if (!isAuthenticated) {
            showToast('Vui lòng đăng nhập để thêm vào danh sách tin cậy', 'warning');
            return;
        }

        const form = button.closest('.trustlist-form');
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const icon = button.querySelector('i');
                    const savesCount = button.querySelector('.saves-count');
                    if (data.saved) {
                        icon.classList.remove('far');
                        icon.classList.add('fas', 'text-primary');
                        button.dataset.saved = 'true';
                        showToast(data.message, 'success');
                    } else {
                        icon.classList.remove('fas', 'text-primary');
                        icon.classList.add('far');
                        button.dataset.saved = 'false';
                        showToast(data.message, 'info');
                    }
                    if (savesCount) {
                        savesCount.textContent = data.savesCount;
                    }
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra, vui lòng thử lại sau', 'error');
            });
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
