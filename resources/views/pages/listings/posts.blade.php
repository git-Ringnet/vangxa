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
        <form action="{{ route('trustlist.toggle', ['id' => $post->id]) }}" method="POST" class="trustlist-form" data-post-id="{{ $post->id }}">
            @csrf
            <button type="button" class="trustlist-button trustlist-btn" data-post-id="{{ $post->id }}" data-saved="{{ Auth::check() && $post->isSaved ? 'true' : 'false' }}" data-authenticated="{{ Auth::check() ? 'true' : 'false' }}" onclick="event.preventDefault(); handleSave(this);">
                <i class="{{ Auth::check() && $post->isSaved ? 'fas' : 'far' }} fa-bookmark {{ Auth::check() && $post->isSaved ? 'text-primary' : '' }}"></i>
            </button>
        </form>
        <div class="bookWrap" onclick="event.preventDefault(); event.stopPropagation(); showStoryModal({{ $post->id }})">
            <div class="book">
                <div class="cover">
                    <img src="image/sách.png" style="width: 100%; height: 100%; object-fit: cover;">
                    <div class="circleImage">
                        <img src="https://img.tripi.vn/cdn-cgi/image/width=700,height=700/https://gcs.tripi.vn/public-tripi/tripi-feed/img/474090Ypg/hinh-anh-girl-xinh-dep-de-thuong_025104504.jpg" alt="Avatar">
                    </div>
                </div>
                <div class="spine"></div>
            </div>
        </div>
    </div>
    <div class="listing-content">
        <div class="listing-header">
            <h3 class="listing-title">{{ $post->title }}</h3>
            {{-- <div class="listing-rating">
                <i class="fas fa-star"></i>
                <span>4.96</span>
            </div> --}}
        </div>
        <!-- <p class="listing-location">{{ $post->address }}</p> -->
        <!-- <p class="listing-dates">22-27 tháng 5</p>
        <p class="listing-price">
            <span class="price-amount">2,000,000₫</span>
            <span class="price-period">đêm</span>
        </p> -->
    </div>
    
</a>
<!-- Story Modal -->
<div class="story-modal" id="storyModal-{{ $post->id }}">
    <div class="story-modal-content">
        <!-- User Profile Section -->
        <div class="story-profile-section">
            <div class="story-profile-header">
                <div class="story-user-main">
                    <div class="story-avatar">
                        <img src="{{ $post->user->avatar ?? 'https://via.placeholder.com/150' }}" alt="User Avatar">
                        @if($post->user->is_verified)
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
                    <span class="stat-number">{{ number_format($post->rating ?? 4.95, 2) }} <i class="fas fa-star"></i></span>
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
</script>
