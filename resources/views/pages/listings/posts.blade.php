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
        <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
            <i class="fas fa-heart"></i>
        </button>
    </div>
    <div class="listing-content">
        <div class="listing-header">
            <h3 class="listing-title">{{ $post->title }}</h3>
            <div class="listing-rating">
                <i class="fas fa-star"></i>
                <span>4.96</span>
            </div>
        </div>
        <p class="listing-location">{{ $post->address }}</p>
        <p class="listing-dates">22-27 tháng 5</p>
        <p class="listing-price">
            <span class="price-amount">2,000,000₫</span>
            <span class="price-period">đêm</span>
        </p>
    </div>
</a>
@endforeach 