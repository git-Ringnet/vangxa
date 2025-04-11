@extends('layouts.main')

@section('content')
<div class="container-custom detail-dining-page">
    <!-- Image Gallery -->
    <div class="detail-gallery">
        <div class="gallery-main" onclick="openPreview(0)">
            @if($post->images->isNotEmpty())
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
        @if($post->images->count() > 5)
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
    <div class="modal fade" id="imageGalleryModal" tabindex="-1" aria-labelledby="imageGalleryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageGalleryModalLabel">Tất cả ảnh ({{ $post->images->count() }})</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        @foreach($post->images as $index => $image)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="gallery-item" onclick="openPreview({{ $index }})">
                                <img src="{{ asset($image->image_path) }}" alt="{{ $post->title }}"
                                    class="img-fluid rounded modal-image">
                                <div class="gallery-item-overlay">
                                    <span class="image-number">{{ $index + 1 }}/{{ $post->images->count() }}</span>
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
</div>

<!-- Detail Content -->
<div class="detail-content">
    <div class="content-main">
        <!-- Restaurant Title -->
        <div class="detail-header">
            <h1 class="detail-title">{{ $post->title }}</h1>
            <div class="detail-badges">
                <span class="badge-item"><i class="fas fa-award"></i> Đạt chứng nhận vệ sinh an toàn thực phẩm</span>
                <span class="badge-item"><i class="fas fa-check-circle"></i> Đã xác minh</span>
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
            <p>{{ $post->content }}</p>
        </div>

        <!-- Menu Highlights -->
        <div class="menu-highlights">
            <h2>Món ăn đặc trưng</h2>
            <div class="highlight-grid">
                @foreach($post->images->take(3) as $image)
                <div class="highlight-item">
                    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $post->title }}" class="highlight-image">
                    <div class="highlight-info">
                        <h3>{{ $post->title }}</h3>
                        <p>{{ $post->content }}</p>
                        <span class="highlight-price">350,000₫</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Rating & Reviews -->
        <div class="rating-section">
            <h2>Đánh giá và nhận xét</h2>
            <div class="rating-overview">
                <div class="rating-score">
                    <span class="score">4.8</span>
                    <div class="score-details">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="reviews-count">458 đánh giá</span>
                    </div>
                </div>
                <div class="rating-bars">
                    <div class="rating-bar-item">
                        <span class="rating-label">Đồ ăn</span>
                        <div class="rating-progress">
                            <div class="progress-fill" style="width: 96%"></div>
                        </div>
                        <span class="rating-value">4.8</span>
                    </div>
                    <div class="rating-bar-item">
                        <span class="rating-label">Dịch vụ</span>
                        <div class="rating-progress">
                            <div class="progress-fill" style="width: 92%"></div>
                        </div>
                        <span class="rating-value">4.6</span>
                    </div>
                    <div class="rating-bar-item">
                        <span class="rating-label">Không gian</span>
                        <div class="rating-progress">
                            <div class="progress-fill" style="width: 98%"></div>
                        </div>
                        <span class="rating-value">4.9</span>
                    </div>
                    <div class="rating-bar-item">
                        <span class="rating-label">Giá cả</span>
                        <div class="rating-progress">
                            <div class="progress-fill" style="width: 84%"></div>
                        </div>
                        <span class="rating-value">4.2</span>
                    </div>
                </div>
            </div>

            <!-- User Reviews -->
            <div class="user-reviews">
                <div class="review-item">
                    <div class="review-header">
                        <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="User" class="reviewer-avatar">
                        <div class="reviewer-info">
                            <h4>Nguyễn Minh Tâm</h4>
                            <div class="review-meta">
                                <div class="review-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="review-date">Đã đánh giá vào tháng 6, 2023</span>
                            </div>
                        </div>
                    </div>
                    <div class="review-content">
                        <p>Nhà hàng có không gian rất sang trọng và thoáng đãng. Đồ ăn tươi ngon, đặc biệt là các món hải sản. Nhân viên phục vụ nhiệt tình, chu đáo. Mình đã tổ chức sinh nhật tại đây và rất hài lòng với dịch vụ.</p>
                    </div>
                    <div class="review-actions">
                        <button class="review-like-btn"><i class="far fa-thumbs-up"></i> Hữu ích (23)</button>
                        <button class="review-reply-btn"><i class="far fa-comment"></i> Phản hồi</button>
                    </div>
                </div>

                <div class="review-item">
                    <div class="review-header">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="reviewer-avatar">
                        <div class="reviewer-info">
                            <h4>Trần Quốc Bảo</h4>
                            <div class="review-meta">
                                <div class="review-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="review-date">Đã đánh giá vào tháng 5, 2023</span>
                            </div>
                        </div>
                    </div>
                    <div class="review-content">
                        <p>Buffet hải sản rất đa dạng và chất lượng. Tôi đặc biệt thích món ghẹ rang muối ở đây. Không gian nhà hàng rộng rãi, thoáng mát. Giá cả hơi cao nhưng xứng đáng với chất lượng. Sẽ quay lại.</p>
                    </div>
                    <div class="review-actions">
                        <button class="review-like-btn"><i class="far fa-thumbs-up"></i> Hữu ích (15)</button>
                        <button class="review-reply-btn"><i class="far fa-comment"></i> Phản hồi</button>
                    </div>
                </div>
            </div>

            <div class="load-more-reviews">
                <button class="load-more-button">Xem thêm đánh giá</button>
            </div>
        </div>

        <!-- Location Map -->
        <div class="location-section">
            <h2>Vị trí</h2>
            <div class="location-map">
                <img src="https://maps.googleapis.com/maps/api/staticmap?center=21.0236,105.8109&zoom=15&size=600x300&maptype=roadmap&markers=color:red%7C21.0236,105.8109&key=YOUR_API_KEY" alt="Restaurant Location Map" class="map-image">
            </div>
            <div class="location-address">
                <p><i class="fas fa-map-marker-alt"></i> {{ $post->location }}</p>
                <button class="get-directions-btn"><i class="fas fa-directions"></i> Chỉ đường</button>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="content-sidebar">
        <!-- Reservation Card -->
        <div class="reservation-card">
            <h3>Đặt bàn</h3>
            <div class="price-info">
                <span class="price">200,000₫ - 500,000₫</span>
                <span class="price-per-person">/ người</span>
            </div>

            <div class="reservation-form">
                <!-- Date Picker -->
                <div class="form-group">
                    <label><i class="far fa-calendar-alt"></i> Ngày</label>
                    <input type="date" class="form-control">
                </div>

                <!-- Time Picker -->
                <div class="form-group">
                    <label><i class="far fa-clock"></i> Thời gian</label>
                    <select class="form-control">
                        <option>11:00</option>
                        <option>11:30</option>
                        <option>12:00</option>
                        <option>12:30</option>
                        <option>13:00</option>
                        <option>13:30</option>
                        <option>18:00</option>
                        <option>18:30</option>
                        <option>19:00</option>
                        <option>19:30</option>
                        <option>20:00</option>
                        <option>20:30</option>
                        <option>21:00</option>
                    </select>
                </div>

                <!-- Guests Picker -->
                <div class="form-group">
                    <label><i class="fas fa-user-friends"></i> Số người</label>
                    <select class="form-control">
                        <option>1 người</option>
                        <option>2 người</option>
                        <option>3 người</option>
                        <option>4 người</option>
                        <option>5 người</option>
                        <option>6 người</option>
                        <option>7 người</option>
                        <option>8 người</option>
                        <option>Nhiều hơn 8 người</option>
                    </select>
                </div>

                <button class="reservation-button">Đặt bàn ngay</button>
            </div>

            <div class="reservation-info">
                <p><i class="fas fa-info-circle"></i> Miễn phí hủy trước 24 giờ</p>
                <p><i class="fas fa-check-circle"></i> Xác nhận đặt chỗ tức thì</p>
            </div>
        </div>

        <!-- Similar Restaurants -->

    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const images = @json($post->images->pluck('image_path'));
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

        // Toggle like button
        const likeButtons = document.querySelectorAll('.review-like-btn');
        likeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    // Update like count logic would go here
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
            });
        });

        // Reply button functionality
        const replyButtons = document.querySelectorAll('.review-reply-btn');
        replyButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Reply form logic would go here
                alert('Tính năng đang được phát triển');
            });
        });

        // Load more reviews
        const loadMoreButton = document.querySelector('.load-more-button');
        if (loadMoreButton) {
            loadMoreButton.addEventListener('click', function() {
                // Load more reviews logic would go here
                alert('Đang tải thêm đánh giá...');
            });
        }
    });
</script>
@endpush

