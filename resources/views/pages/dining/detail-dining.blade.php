@extends('layouts.main')

@section('content')
<div class="container-custom detail-dining-page">
    <!-- Image Gallery -->
    <div class="detail-gallery">
        <div class="gallery-main" onclick="openPreview(0)">
            @if ($post->images->isNotEmpty())
            <img src="{{ asset($post->images->first()->image_path) }}" alt="{{ $post->title }}" class="main-image">
            @endif
        </div>
        <div class="gallery-grid">
            @foreach ($post->images->skip(1)->take(4) as $index => $image)
            <div class="detail-page__gallery-item" onclick="openPreview({{ $index + 1 }})">
                <img src="{{ asset($image->image_path) }}" class="img-fluid rounded" alt="Post image">
                <div class="image-number">{{ $index + 1 }}/{{ $post->images->count() }}</div>
                <i class="fas fa-search-plus zoom-icon"></i>
            </div>
            @endforeach
        </div>
        @if ($post->images->count() > 5)
        <button class="view-all-photos" data-bs-toggle="modal" data-bs-target="#imageGalleryModal">
            <i class="fas fa-th"></i>
            Xem tất cả {{ $post->images->count() }} ảnh
        </button>
        @endif
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-black">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center position-relative">
                    <img src="" alt="" class="preview-image">
                    <button class="nav-button prev" onclick="prevImage()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="nav-button next" onclick="nextImage()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <span class="text-white image-counter"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Gallery Modal -->
    <div class="modal fade" id="imageGalleryModal" tabindex="-1" aria-labelledby="imageGalleryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageGalleryModalLabel">Tất cả ảnh ({{ $post->images->count() }})</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        @foreach ($post->images as $index => $image)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="gallery-item" onclick="openPreview({{ $index }})">
                                <img src="{{ asset($image->image_path) }}" alt="{{ $post->title }}"
                                    class="img-fluid rounded modal-image">
                                <div class="gallery-item-overlay">
                                    <span
                                        class="image-number">{{ $index + 1 }}/{{ $post->images->count() }}</span>
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Content -->
    <div class="detail-content">
        <div class="content-main">
            <!-- Restaurant Title -->
            <div class="detail-header">
                <h1 class="detail-title">{{ $post->title }}</h1>
                <div class="detail-badges">
                    <span class="badge-item"><i class="fas fa-award"></i> Đạt chứng nhận vệ sinh an toàn thực
                        phẩm</span>
                    <span class="badge-item"><i class="fas fa-check-circle"></i> Đã xác minh</span>
                    <div class="action-buttons">
                        @auth
                        <form action="{{ route('favorites.favorite', ['id' => $post->id]) }}" method="POST" class="favorite-form" data-post-id="{{ $post->id }}">
                            @csrf
                            <button type="button" class="btn-favorite {{ $isFavorited ? 'active' : '' }}" onclick="toggleFavorite(this, {{ $post->id }})" title="{{ $isFavorited ? 'Bỏ yêu thích' : 'Yêu thích' }}">
                                <i class="{{ $isFavorited ? 'fas' : 'far' }} fa-heart"></i>
                                <span class="favorite-count">{{ $post->favorites_count ?? 0 }}</span>
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="btn-favorite" title="Yêu thích" onclick="showToast('Vui lòng đăng nhập để thêm vào yêu thích', 'warning'); return false;">
                            <i class="far fa-heart"></i>
                            <span class="favorite-count">{{ $post->favorites_count ?? 0 }}</span>
                        </a>
                        @endauth
                        <button class="btn-share" onclick="sharePost()" title="Chia sẻ">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Restaurant Info -->
            <div class="detail-info">
                <div class="info-item">
                    <span class="info-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>{{ $post->location }}</span>
                </div>
                <div class="info-item">
                    <span class="info-icon"><i class="fas fa-utensils"></i></span>
                    <span>Ẩm thực Việt Nam, Buffet Hải sản</span>
                </div>
                <div class="info-item">
                    <span class="info-icon"><i class="fas fa-clock"></i></span>
                    <span>Giờ mở cửa: 11:00 - 14:00, 17:30 - 22:00</span>
                </div>
                <div class="info-item">
                    <span class="info-icon"><i class="fas fa-phone"></i></span>
                    <span>024 3835 2222</span>
                </div>
            </div>

            <!-- Description -->
            <div class="detail-description">
                <h2>Giới thiệu</h2>
                <p>{!! $post->description !!}</p>
            </div>

            <!-- Menu Highlights -->
            <div class="menu-highlights">
                <h2>Món ăn đặc trưng</h2>
                <div class="highlight-grid">
                    @foreach ($post->images->take(3) as $image)
                    <div class="highlight-item">
                        <img src="{{ asset($image->image_path) }}" alt="{{ $post->title }}"
                            class="highlight-image">
                        <div class="highlight-info">
                            <h3>{{ $post->title }}</h3>
                            <p>{!! $post->description !!}</p>
                            <span class="highlight-price">350,000₫</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Rating & Reviews -->
            <div class="rating-section" id="ratingSection">
                <h2>Đánh giá và nhận xét</h2>

                <!-- Review Form -->
                <div class="write-review">
                    <h3>Viết đánh giá của bạn</h3>
                    <form action="{{ route('reviews.store') }}" method="POST" id="reviewForm">
                        @csrf
                        <div class="form-group my-3">
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <label>Đánh giá món ăn <span class="text-danger">*</span></label>
                            <div class="rating">
                                <input type="radio" name="food_rating" value="5" id="food-5"
                                    {{ old('food_rating') == 5 ? 'checked' : '' }}><label for="food-5"><i class="fas fa-star"></i></label>
                                <input type="radio" name="food_rating" value="4" id="food-4"
                                    {{ old('food_rating') == 4 ? 'checked' : '' }}><label for="food-4"><i class="fas fa-star"></i></label>
                                <input type="radio" name="food_rating" value="3" id="food-3"
                                    {{ old('food_rating') == 3 ? 'checked' : '' }}><label for="food-3"><i class="fas fa-star"></i></label>
                                <input type="radio" name="food_rating" value="2" id="food-2"
                                    {{ old('food_rating') == 2 ? 'checked' : '' }}><label for="food-2"><i class="fas fa-star"></i></label>
                                <input type="radio" name="food_rating" value="1" id="food-1"
                                    {{ old('food_rating') == 1 ? 'checked' : '' }}><label for="food-1"><i class="fas fa-star"></i></label>
                            </div>
                            <div class="error-message" id="foodRatingError"></div>
                        </div>

                        <div class="form-group my-3">
                            <label>Mức độ hài lòng <span class="text-danger">*</span></label>
                            <div class="satisfaction-icons">
                                <input type="radio" name="satisfaction_level" value="5" id="satisfaction-5"
                                    {{ old('satisfaction_level') == 5 ? 'checked' : '' }}>
                                <label for="satisfaction-5"><i class="fas fa-laugh-beam"></i></label>

                                <input type="radio" name="satisfaction_level" value="4" id="satisfaction-4"
                                    {{ old('satisfaction_level') == 4 ? 'checked' : '' }}>
                                <label for="satisfaction-4"><i class="fas fa-laugh"></i></label>

                                <input type="radio" name="satisfaction_level" value="3" id="satisfaction-3"
                                    {{ old('satisfaction_level') == 3 ? 'checked' : '' }}>
                                <label for="satisfaction-3"><i class="fas fa-meh"></i></label>

                                <input type="radio" name="satisfaction_level" value="2" id="satisfaction-2"
                                    {{ old('satisfaction_level') == 2 ? 'checked' : '' }}>
                                <label for="satisfaction-2"><i class="fas fa-frown"></i></label>

                                <input type="radio" name="satisfaction_level" value="1" id="satisfaction-1"
                                    {{ old('satisfaction_level') == 1 ? 'checked' : '' }}>
                                <label for="satisfaction-1"><i class="fas fa-sad-tear"></i></label>
                            </div>
                            <div class="error-message" id="satisfactionLevelError"></div>
                        </div>

                        <div class="form-group my-3">
                            <label for="comment">Nhận xét của bạn <span class="text-danger">*</span></label>
                            <textarea name="comment" id="comment" rows="4" class="form-control"
                                placeholder="Chia sẻ trải nghiệm của bạn...">{{ old('comment') }}</textarea>
                            <div class="error-message" id="commentError"></div>
                        </div>

                        <button type="submit" class="submit-review-green">Gửi đánh giá</button>
                    </form>
                </div>

                <!-- Reviews List -->
                <div class="reviews-list">
                    @foreach ($post->reviews()->with('user')->latest()->get() as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}"
                                alt="{{ $review->user->name }}" class="reviewer-avatar">
                            <div class="reviewer-info">
                                <h4>{{ $review->user->name }}</h4>
                                <div class="review-meta">
                                    <div class="review-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                            class="fas fa-star {{ $i <= $review->food_rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                    </div>
                                    <span class="review-date">{{ $review->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="review-content">
                            <div class="satisfaction-icon">
                                @switch($review->satisfaction_level)
                                @case(5)
                                <i class="fas fa-laugh-beam text-success"></i>
                                @break

                                @case(4)
                                <i class="fas fa-laugh text-info"></i>
                                @break

                                @case(3)
                                <i class="fas fa-meh text-warning"></i>
                                @break

                                @case(2)
                                <i class="fas fa-frown text-danger"></i>
                                @break

                                @case(1)
                                <i class="fas fa-sad-tear text-danger"></i>
                                @break
                                @endswitch
                            </div>
                            <p>{{ $review->comment }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Location Map -->
            <div class="location-section">
                <h2>Vị trí</h2>
                <div class="location-address">
                    <p><i class="fas fa-map-marker-alt"></i> 57-59 Láng Hạ, Quận Ba Đình, Hà Nội</p>
                    <button class="get-directions-btn"><i class="fas fa-directions"></i> Chỉ đường</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const images = @json($post -> images -> pluck('image_path'));
        let currentImageIndex = 0;
        const previewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        const previewImage = document.querySelector('.preview-image');
        const imageCounter = document.querySelector('.image-counter');
        const modalElement = document.getElementById('imagePreviewModal');

        // Function to open image preview
        window.openPreview = function(index) {
            currentImageIndex = index;
            updatePreviewImage();
            previewModal.show();
        };

        // Function to show previous image
        window.prevImage = function() {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            updatePreviewImage();
        };

        // Function to show next image
        window.nextImage = function() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            updatePreviewImage();
        };

        // Update preview image and counter
        function updatePreviewImage() {
            previewImage.src = images[currentImageIndex];
            imageCounter.textContent = `${currentImageIndex + 1}/${images.length}`;
        }

        // Close modal when clicking outside
        modalElement.addEventListener('click', function(e) {
            if (e.target === modalElement) {
                previewModal.hide();
            }
        });

        // Close modal when clicking close button
        document.querySelector('.btn-close').addEventListener('click', function() {
            previewModal.hide();
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (modalElement.classList.contains('show')) {
                if (e.key === 'ArrowLeft') {
                    prevImage();
                } else if (e.key === 'ArrowRight') {
                    nextImage();
                } else if (e.key === 'Escape') {
                    previewModal.hide();
                }
            }
        });


        // Client-side validation
        const form = document.getElementById('reviewForm');
        const foodRatingError = document.getElementById('foodRatingError');
        const satisfactionLevelError = document.getElementById('satisfactionLevelError');
        const commentError = document.getElementById('commentError');

        form.addEventListener('submit', function(e) {
            let isValid = true;

            // Reset error messages
            foodRatingError.textContent = '';
            satisfactionLevelError.textContent = '';
            commentError.textContent = '';

            // Kiểm tra đánh giá sao
            const foodRating = document.querySelector('input[name="food_rating"]:checked');
            if (!foodRating) {
                foodRatingError.textContent = 'Vui lòng chọn đánh giá sao cho món ăn';
                isValid = false;
            } else {
                const ratingValue = parseInt(foodRating.value);
                if (isNaN(ratingValue) || ratingValue < 1 || ratingValue > 5) {
                    foodRatingError.textContent = 'Đánh giá sao phải từ 1-5';
                    isValid = false;
                }
            }

            // Kiểm tra mức độ hài lòng
            const satisfactionLevel = document.querySelector(
                'input[name="satisfaction_level"]:checked');
            if (!satisfactionLevel) {
                satisfactionLevelError.textContent = 'Vui lòng chọn mức độ hài lòng';
                isValid = false;
            } else {
                const satisfactionValue = parseInt(satisfactionLevel.value);
                if (isNaN(satisfactionValue) || satisfactionValue < 1 || satisfactionValue > 5) {
                    satisfactionLevelError.textContent = 'Mức độ hài lòng phải từ 1-5';
                    isValid = false;
                }
            }

            // Kiểm tra nhận xét
            const comment = document.getElementById('comment').value.trim();
            if (!comment) {
                commentError.textContent = 'Vui lòng viết nhận xét của bạn';
                isValid = false;
            } else if (comment.length < 10) {
                commentError.textContent = 'Nhận xét phải có ít nhất 10 ký tự';
                isValid = false;
            } else if (comment.length > 1000) {
                commentError.textContent = 'Nhận xét không được vượt quá 1000 ký tự';
                isValid = false;
            }

            // Nếu có lỗi, ngăn form submit
            if (!isValid) {
                e.preventDefault();
            }
        });

        // Function to toggle favorite status
        window.toggleFavorite = function(button, postId) {
            // Prevent the default action
            event.preventDefault();
            event.stopPropagation();
            
            // Get the CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Send AJAX request
            fetch(`/favorites/${postId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 401) {
                        // Redirect to login page if not authenticated
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (!data) return; // Handle case where we redirected to login
                
                // Update button appearance
                const icon = button.querySelector('i');
                const text = button.querySelector('span.favorite-count');
                
                if (data.favorited) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    button.classList.add('active');
                    button.title = 'Bỏ yêu thích';
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    button.classList.remove('active');
                    button.title = 'Yêu thích';
                }
                
                // Update favorite count if it exists
                if (text) {
                    text.textContent = data.favoritesCount;
                }
                
                // Show toast notification
                showToast(data.message, data.favorited ? 'success' : 'info');
                
                // Update all other favorite buttons for this post
                document.querySelectorAll(`.favorite-form[data-post-id="${postId}"] .btn-favorite`).forEach(btn => {
                    if (btn !== button) {
                        const btnIcon = btn.querySelector('i');
                        const btnText = btn.querySelector('span.favorite-count');
                        if (data.favorited) {
                            btnIcon.classList.remove('far');
                            btnIcon.classList.add('fas');
                            btn.classList.add('active');
                            btn.title = 'Bỏ yêu thích';
                        } else {
                            btnIcon.classList.remove('fas');
                            btnIcon.classList.add('far');
                            btn.classList.remove('active');
                            btn.title = 'Yêu thích';
                        }
                        if (btnText) {
                            btnText.textContent = data.favoritesCount;
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra, vui lòng thử lại sau', 'error');
            });
        };
    });
</script>
@endpush