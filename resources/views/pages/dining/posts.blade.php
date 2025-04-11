@foreach($posts as $post)
<a href="{{ route('dining.detail-dining', ['id' => $post->id]) }}" class="listing-card">
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
                @for($i = 0; $i < count($post->images); $i++)
                <span class="dot {{ $i === 0 ? 'active' : '' }}"></span>
                @endfor
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
        <p class="listing-location">{{ $post->location }}</p>
        <p class="listing-dates">{{ $post->content }}</p>
        <p class="listing-price">
            <span class="price-amount">200,000₫</span>
            <span class="price-period">/ người</span>
        </p>
    </div>
</a>
@endforeach 