@extends('layouts.main')

@section('content')
<div class="container-custom main-content">
    <!-- Filter Section -->
    <section class="filter-section mb-6">
        <div class="flex justify-center space-x-4">
            <a href="{{ route('favorites') }}"
                class="filter-btn {{ !$type ? 'active' : '' }}">
                <i class="fas fa-heart mr-2"></i>
                Tất cả
            </a>
            <a href="{{ route('favorites', ['type' => 2]) }}"
                class="filter-btn {{ $type == 2 ? 'active' : '' }}">
                <i class="fas fa-utensils mr-2"></i>
                Ẩm thực
            </a>
            <a href="{{ route('favorites', ['type' => 1]) }}"
                class="filter-btn {{ $type == 1 ? 'active' : '' }}">
                <i class="fas fa-bed mr-2"></i>
                Nghỉ dưỡng
            </a>
        </div>
    </section>

    <!-- Listings -->
    <section class="listings-section">
        <div class="listings-grid">
            @if($posts->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">Bạn chưa có bài viết yêu thích nào.</p>
            </div>
            @else
            @foreach($posts as $post)
            <a href="{{ $post->type == 2 ? route('dining.detail-dining', ['id' => $post->id]) : route('detail', ['id' => $post->id]) }}" class="listing-card">
                <div class="listing-image-container">
                    <div class="image-carousel">
                        <div class="carousel-images">
                            @foreach ($post->images as $image)
                            <img src="{{ asset($image->image_path) }}" class="img-fluid rounded" alt="Post image">
                            @endforeach
                        </div>
                        <button class="carousel-nav prev" onclick="event.preventDefault(); prevImage(this);">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="carousel-nav next" onclick="event.preventDefault(); nextImage(this);">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <div class="carousel-dots">
                            @for($i = 0; $i < count($post->images); $i++)
                                <span class="dot {{ $i === 0 ? 'active' : '' }}"></span>
                                @endfor
                        </div>
                    </div>
                    <form action="{{ route('favorites.favorite', ['id' => $post->id]) }}" method="POST" class="favorite-form">
                        @csrf
                        <button type="button" class="favorite-button favorite-btn"
                            data-post-id="{{ $post->id }}"
                            data-favorited="{{ Auth::check() && $post->isFavorited ? 'true' : 'false' }}"
                            data-authenticated="{{ Auth::check() ? 'true' : 'false' }}"
                            onclick="event.preventDefault(); handleFavorite(this);">
                            <i class="{{ Auth::check() && $post->isFavorited ? 'fas' : 'far' }} fa-heart {{ Auth::check() && $post->isFavorited ? 'text-danger' : '' }}"></i>
                        </button>
                    </form>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">{{ $post->title }}</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.96</span>
                        </div>
                    </div>
                    <p class="listing-location">{{ $post->location }}</p>
                    <p class="listing-dates">{{ $post->content }}</p>
                </div>
            </a>
            @endforeach
            @endif
        </div>
    </section>
</div>

<style>
    .filter-section {
        padding: 1rem 0;
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
    }

    .filter-btn {
        padding: 0.5rem 1.5rem;
        border-radius: 9999px;
        font-weight: 500;
        color: #6b7280;
        transition: all 0.3s ease;
        background: #f3f4f6;
        text-decoration: none;

    }

    .filter-btn:hover {
        background: #e5e7eb;
        color: #374151;
    }

    .filter-btn.active {
        background: #3b82f6;
        color: white;
    }

    .filter-btn i {
        font-size: 1rem;
        text-decoration: none;

    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeCarousels();
        preventFavoriteFormSubmit();
    });

    function preventFavoriteFormSubmit() {
        document.querySelectorAll('.favorite-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
            });
        });
    }

    function handleFavorite(button) {
        const form = button.closest('form');
        const isAuthenticated = button.dataset.authenticated === 'true';
        const postId = button.dataset.postId;

        if (!isAuthenticated) {
            showToast('Vui lòng đăng nhập để thêm vào yêu thích', 'warning');
            return false;
        }

        // Vô hiệu hóa nút để tránh click liên tục
        button.disabled = true;

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message && data.favorited !== undefined) {
                    const icon = button.querySelector('i');
                    const listingCard = button.closest('.listing-card');

                    if (data.favorited) {
                        // Thêm vào yêu thích
                        icon.classList.remove('far');
                        icon.classList.add('fas', 'text-danger');
                        button.setAttribute('data-favorited', 'true');
                        showToast(data.message, 'success');
                    } else {
                        // Bỏ yêu thích
                        if (listingCard) {
                            // Thêm hiệu ứng mờ dần trước khi xóa
                            listingCard.style.transition = 'opacity 0.3s ease';
                            listingCard.style.opacity = '0';
                            setTimeout(() => {
                                listingCard.remove();
                                // Kiểm tra danh sách bài viết sau khi xóa
                                const listingsGrid = document.querySelector('.listings-grid');
                                const remainingCards = listingsGrid.querySelectorAll('.listing-card');
                                if (remainingCards.length === 0) {
                                    listingsGrid.innerHTML = `
                                <div class="text-center py-8">
                                    <p class="text-gray-500">Bạn chưa có bài viết yêu thích nào.</p>
                                </div>
                            `;
                                }
                            }, 300); // Đợi hiệu ứng hoàn tất
                        }
                        button.setAttribute('data-favorited', 'false');
                        showToast(data.message, 'error');
                    }
                } else {
                    showToast(data.error || 'Có lỗi xảy ra', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra, vui lòng thử lại sau', 'error');
            })
            .finally(() => {
                // Kích hoạt lại nút sau khi hoàn tất
                button.disabled = false;
            });
    }



    function prevImage(button) {
        const carousel = button.closest('.image-carousel');
        const images = carousel.querySelector('.carousel-images');
        const dots = carousel.querySelectorAll('.dot');
        let currentIndex = parseInt(images.dataset.currentIndex || 0);
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel(images, dots, currentIndex);
        }
    }

    function nextImage(button) {
        const carousel = button.closest('.image-carousel');
        const images = carousel.querySelector('.carousel-images');
        const dots = carousel.querySelectorAll('.dot');
        let currentIndex = parseInt(images.dataset.currentIndex || 0);
        const maxIndex = images.children.length - 1;
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateCarousel(images, dots, currentIndex);
        }
    }

    function updateCarousel(images, dots, index) {
        images.dataset.currentIndex = index;
        const percentage = (index * (100 / images.children.length));
        images.style.transform = `translateX(-${percentage}%)`;
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initializeCarousels();
    });

    function initializeCarousels() {
        document.querySelectorAll('.image-carousel').forEach(carousel => {
            const dots = carousel.querySelectorAll('.dot');
            const images = carousel.querySelector('.carousel-images');
            const imageCount = images.children.length;
            images.style.width = `${imageCount * 100}%`;
            Array.from(images.children).forEach(img => {
                img.style.width = `${100 / imageCount}%`;
            });
            images.dataset.currentIndex = 0;
            dots.forEach((dot, index) => {
                dot.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    updateCarousel(images, dots, index);
                });
            });
            const navButtons = carousel.querySelectorAll('.carousel-nav');
            navButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                });
            });
        });
    }
</script>
@endpush