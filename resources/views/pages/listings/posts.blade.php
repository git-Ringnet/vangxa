@foreach ($posts as $post)
<a href="{{ route('detail', $post->id) }}" class="listing-card">
    <div class="listing-image-container">
        <div class="image-carousel">
            <div class="carousel-images">
                @foreach ($post->images as $image)
                <img src="{{ asset($image->image_path) }}"
                    class="img-fluid rounded"
                    alt="Post image">
                @endforeach
            </div>
            <button class="carousel-nav prev" onclick="event.preventDefault(); prevImage(this);">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-nav next" onclick="event.preventDefault(); nextImage(this);">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="carousel-dots">
                @foreach ($post->images as $index => $image)
                <span class="dot {{ $index == 0 ? 'active' : '' }}"></span>
                @endforeach
            </div>
        </div>
        <form action="{{ route('favorites.favorite', ['id' => $post->id]) }}" method="POST" class="favorite-form" data-post-id="{{ $post->id }}">
            @csrf
            <button type="button" class="favorite-button favorite-btn" data-post-id="{{ $post->id }}" data-favorited="{{ Auth::check() && $post->isFavorited ? 'true' : 'false' }}" data-authenticated="{{ Auth::check() ? 'true' : 'false' }}" onclick="event.preventDefault(); handleFavorite(this);">
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
        <!-- <p class="listing-location">{{ $post->address }}</p> -->
        <!-- <p class="listing-dates">22-27 tháng 5</p>
        <p class="listing-price">
            <span class="price-amount">2,000,000₫</span>
            <span class="price-period">đêm</span>
        </p> -->
    </div>
</a>
@endforeach

<script>
function handleFavoriteClick(button, postId, isAuthenticated) {
    event.preventDefault();
    
    if (!isAuthenticated) {
        showToast('Vui lòng đăng nhập để thêm vào yêu thích', 'warning');
        return false;
    }
    
    toggleFavorite(button, postId);
}
</script> 