@extends('layouts.main')

@section('content')
<div class="container-custom main-content">
    <!-- Filter Section -->
    <section class="filter-section mb-6">
        <div class="flex justify-center space-x-4">
            <a href="{{ route('trustlist') }}"
                class="filter-btn {{ !$type ? 'active' : '' }}">
                <i class="fas fa-bookmark mr-2"></i>
                Tất cả
            </a>
            <a href="{{ route('trustlist', ['type' => 2]) }}"
                class="filter-btn {{ $type == 2 ? 'active' : '' }}">
                <i class="fas fa-utensils mr-2"></i>
                Ẩm thực
            </a>
            <a href="{{ route('trustlist', ['type' => 1]) }}"
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
                <p class="text-gray-500">Bạn chưa có nhà cung cấp nào trong danh sách tin cậy.</p>
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
                    <form action="{{ route('trustlist.toggle', ['id' => $post->id]) }}" method="POST" class="trustlist-form">
                        @csrf
                        <button type="button" class="trustlist-button trustlist-btn"
                            data-post-id="{{ $post->id }}"
                            data-saved="{{ Auth::check() && $post->isSaved ? 'true' : 'false' }}"
                            data-authenticated="{{ Auth::check() ? 'true' : 'false' }}"
                            onclick="event.preventDefault(); handleSave(this);">
                            <i class="{{ Auth::check() && $post->isSaved ? 'fas' : 'far' }} fa-bookmark {{ Auth::check() && $post->isSaved ? 'text-primary' : '' }}"></i>
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

</style>
@endsection

@push('scripts')
<script src="{{ asset('js/carousel.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeCarousels();
        preventTrustlistFormSubmit();
    });

    function preventTrustlistFormSubmit() {
        document.querySelectorAll('.trustlist-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
            });
        });
    }

    function handleSave(button) {
        const form = button.closest('form');
        const isAuthenticated = button.dataset.authenticated === 'true';
        const postId = button.dataset.postId;

        if (!isAuthenticated) {
            showToast('Vui lòng đăng nhập để thêm vào danh sách tin cậy', 'warning');
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
                if (data.message && data.saved !== undefined) {
                    const icon = button.querySelector('i');
                    const listingCard = button.closest('.listing-card');

                    if (data.saved) {
                        // Thêm vào danh sách tin cậy
                        icon.classList.remove('far');
                        icon.classList.add('fas', 'text-primary');
                        button.setAttribute('data-saved', 'true');
                        showToast(data.message, 'success');
                    } else {
                        // Bỏ khỏi danh sách tin cậy
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
                                    <p class="text-gray-500">Bạn chưa có nhà cung cấp nào trong danh sách tin cậy.</p>
                                </div>
                            `;
                                }
                            }, 300); // Đợi hiệu ứng hoàn tất
                        }
                        button.setAttribute('data-saved', 'false');
                        showToast(data.message, 'info');
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

    // Carousel functions are now in external carousel.js file
</script>
@endpush