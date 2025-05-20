@extends('layouts.main')

@section('content')
    <div class="container-custom">
        <!-- Filter Section -->
        <section class="filter-section mb-6">
            <div class="flex justify-center space-x-4">
                <a href="{{ route('trustlist') }}" class="filter-btn {{ !$type ? 'active' : '' }}">
                    <i class="fas fa-bookmark mr-2"></i>
                    Tất cả
                </a>
                <a href="{{ route('trustlist', ['type' => 2]) }}" class="filter-btn {{ $type == 2 ? 'active' : '' }}">
                    <i class="fas fa-utensils mr-2"></i>
                    Ẩm thực
                </a>
                <a href="{{ route('trustlist', ['type' => 1]) }}" class="filter-btn {{ $type == 1 ? 'active' : '' }}">
                    <i class="fas fa-bed mr-2"></i>
                    Nghỉ dưỡng
                </a>
            </div>
        </section>

        <!-- Listings -->
        <section class="listings-section">
            <div class="listings-grid">
                @if ($posts->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500">Bạn chưa có nhà cung cấp nào trong danh sách tin cậy.</p>
                    </div>
                @else
                    @foreach ($posts as $post)
                        <div class="listing-card custom-card border-post"
                            style="background-color: #faf6e9; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <a href="{{ route('dining.detail-dining', $post->id) }}">
                                <div class="position-relative">
                                    <div class="p-3">
                                        <form action="{{ route('trustlist.toggle', ['id' => $post->id]) }}" method="POST"
                                            class="trustlist-form">
                                            @csrf
                                            <button type="button" class="trustlist-button trustlist-btn"
                                                data-post-id="{{ $post->id }}"
                                                data-saved="{{ Auth::check() && $post->isSaved ? 'true' : 'false' }}"
                                                data-authenticated="{{ Auth::check() ? 'true' : 'false' }}">
                                                <i
                                                    class="{{ Auth::check() && $post->isSaved ? 'fas' : 'far' }} fa-bookmark {{ Auth::check() && $post->isSaved ? 'text-primary' : '' }}"></i>
                                            </button>
                                        </form>
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
                                                                <img src="{{ asset($image->image_path) }}"
                                                                    class="img-fluid" alt="Post image"
                                                                    style="width: 100%; height: 400px; object-fit: cover;">
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
                                            {{ $post->description }}
                                        </div>
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($post->address) }}"
                                            target="_blank" class="btn-map rounded-pill">
                                            <svg width="50" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M15 6V21M15 6L21 3V18L15 21M15 6L9 3M15 21L9 18M9 18L3 21V6L9 3M9 18V3"
                                                    stroke="#7C4D28" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
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
                        <x-modal-story :post="$post"></x-modal-story>
                    @endforeach
                @endif
            </div>
        </section>
    </div>

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
@endsection

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
