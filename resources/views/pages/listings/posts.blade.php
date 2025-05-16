@foreach ($posts as $post)
    <div class="listing-card custom-card border-post"
        style="background-color: #faf6e9; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <a href="{{ route('detail', $post->id) }}">
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
                                <img src="image/book.png" style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="circleImage">
                                    <img src="{{ asset($post->user->avatar ?? 'image/default/default-avatar.jpg') }}"
                                        alt="User Avatar" style="width: 100%; height: 100%; object-fit: cover;">
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
                    <span class="distance-text" data-lat="{{ $post->latitude }}" data-lng="{{ $post->longitude }}"
                        data-post-id="{{ $post->id }}">-- km</span>
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
    <x-modal-story :post="$post"></x-modal-story>
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
    // Biến toàn cục để lưu vị trí người dùng
    let userPosition = null;

    // Hàm tính khoảng cách Haversine
    function haversine(lat1, lon1, lat2, lon2) {
        function toRad(x) {
            return x * Math.PI / 180;
        }
        var R = 6371; // km - bán kính trái đất

        // Xử lý các giá trị không hợp lệ
        lat1 = parseFloat(lat1);
        lon1 = parseFloat(lon1);
        lat2 = parseFloat(lat2);
        lon2 = parseFloat(lon2);

        if (isNaN(lat1) || isNaN(lon1) || isNaN(lat2) || isNaN(lon2)) {
            console.error('Invalid coordinates in haversine calculation', {
                lat1,
                lon1,
                lat2,
                lon2
            });
            return 0;
        }

        var dLat = toRad(lat2 - lat1);
        var dLon = toRad(lon2 - lon1);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = R * c;

        return d;
    }

    // Hàm lấy vị trí người dùng
    function getUserPosition() {
        return new Promise((resolve, reject) => {
            if (userPosition) {
                // Nếu đã có vị trí từ trước, sử dụng lại
                resolve(userPosition);
                return;
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userPosition = {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        };
                        console.log('Got user position:', userPosition);
                        resolve(userPosition);
                    },
                    (error) => {
                        console.error('Error getting location:', error);
                        reject(error);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                );
            } else {
                const error = new Error('Geolocation is not supported by this browser.');
                console.error(error);
                reject(error);
            }
        });
    }

    // Hàm cập nhật khoảng cách
    function updateDistances() {
        console.log('Updating distances...');

        getUserPosition()
            .then(position => {
                const userLat = position.latitude;
                const userLng = position.longitude;

                document.querySelectorAll('.distance-text').forEach(function(el) {
                    const lat = parseFloat(el.dataset.lat);
                    const lng = parseFloat(el.dataset.lng);
                    const postId = el.dataset.postId;

                    if (!isNaN(lat) && !isNaN(lng)) {
                        const dist = haversine(userLat, userLng, lat, lng);
                        el.textContent = dist.toFixed(1) + ' km';
                    }
                });
            })
            .catch(error => {
                console.error('Failed to update distances:', error);
            });
    }

    // Story Modal functions
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

    // Initialize Swiper instances
    function initSwipers() {
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
    }

    // DOM ready function
    document.addEventListener('DOMContentLoaded', function() {
        updateDistances();
        initSwipers();

        // Close modal when clicking outside
        document.querySelectorAll('.story-modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                    document.body.style.overflow = 'auto';
                }
            });
        });
    });

    // AJAX events
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'loadMoreBtn') {
            setTimeout(function() {
                updateDistances();
                initSwipers();
            }, 1000);
        }
    });

    $(document).ajaxComplete(function() {
        updateDistances();
        initSwipers();
    });

    // MutationObserver
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                updateDistances();
                initSwipers();
            }
        });
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
</script>
