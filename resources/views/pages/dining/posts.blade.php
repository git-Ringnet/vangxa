@foreach($posts as $post)
<a href="{{ route('dining.detail-dining', ['id' => $post->id]) }}" class="listing-card">
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
        <form action="{{ route('trustlist.toggle', ['id' => $post->id]) }}" method="POST" class="trustlist-form" data-post-id="{{ $post->id }}">
            @csrf
            <button type="button" class="trustlist-button trustlist-btn" data-post-id="{{ $post->id }}" data-saved="{{ Auth::check() && $post->isSaved ? 'true' : 'false' }}" data-authenticated="{{ Auth::check() ? 'true' : 'false' }}" onclick="event.preventDefault(); handleSave(this);">
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

<script>
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
</script>