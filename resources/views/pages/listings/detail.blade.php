@extends('layouts.main')

@section('content')
<div class="detail-page">
    <div class="container-custom">
        <div class="detail-page__header">
            <h1 class="detail-page__title">{{ $post->title }}</h1>
            <p class="detail-page__location">{{ $post->address }}</p>
            <div class="detail-page__rating">
                <i class="fas fa-star"></i>
                <span>4.92</span> <!-- Thêm cột rating nếu cần -->
            </div>
            <div class="detail-page__actions">
            <button class="btn-share" onclick="sharePost()" title="Chia sẻ">
                            <i class="fas fa-share-alt"></i>
                        </button>
                <form action="{{ route('favorites.favorite', ['id' => $post->id]) }}" method="POST" class="favorite-form" data-post-id="{{ $post->id }}">
                    @csrf
                    <button type="button" class="detail-page__action-button detail-page__action-button--save btn-favorite" data-post-id="{{ $post->id }}" data-favorited="{{ Auth::check() && $post->isFavorited ? 'true' : 'false' }}" data-authenticated="{{ Auth::check() ? 'true' : 'false' }}" onclick="event.preventDefault(); handleFavorite(this);">
                        <i class="{{ Auth::check() && $post->isFavorited ? 'fas' : 'far' }} fa-heart {{ Auth::check() && $post->isFavorited ? 'text-danger' : '' }}"></i>
                        <!-- <span>Lưu</span> -->
                        <span class="favorite-count">{{ $post->favorites_count ?? 0 }}</span>
                    </button>
                </form>
            </div>
        </div>



        <div class="detail-page__gallery">
            <div class="detail-page__main-image" onclick="openPreview(0)">
                <img src="{{ $post->images->isNotEmpty() ? asset($post->images->first()->image_path) : asset('default-image.jpg') }}" alt="{{ $post->title }}">
            </div>
            @foreach ($post->images->skip(1)->take(4) as $index => $image)
            <div class="detail-page__gallery-item" onclick="openPreview({{ $index + 1 }})">
                <img src="{{ asset($image->image_path) }}" class="img-fluid rounded" alt="Post image">
                <div class="image-number">{{ $index + 1 }}/{{ $post->images->count() }}</div>
                <i class="fas fa-search-plus zoom-icon"></i>
            </div>
            @endforeach
            <button class="view-all-photos" data-bs-toggle="modal" data-bs-target="#imageGalleryModal">
            <i class="fas fa-th"></i>
            Xem tất cả {{ $post->images->count() }} ảnh
        </button>
        </div>

        <!-- Image Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-black">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center position-relative">
                        <img src="" alt="" id="previewImage">
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
        <div class="detail-page__content">
            <div class="detail-page__info">
                <div class="detail-page__host">
                    <div class="detail-page__host-avatar">
                        <img src="{{ $post->user->avatar ?? 'https://randomuser.me/api/portraits/men/32.jpg' }}" alt="Chủ nhà">
                    </div>
                    <div class="detail-page__host-info">
                        <h3>Chủ nhà: {{ $post->user->name }}</h3>
                        <p>Đã tham gia từ {{ $post->user->created_at->format('F, Y') }}</p>
                    </div>
                </div>

                <div class="detail-page__description">
                    <p>Chào mừng bạn đến với căn hộ sang trọng của chúng tôi tại trung tâm thành phố. Căn hộ được trang bị đầy đủ tiện nghi hiện đại, nội thất cao cấp và không gian thoáng đãng.</p>
                    <p>Vị trí thuận lợi, gần các điểm tham quan, trung tâm mua sắm và nhà hàng. Bạn sẽ có trải nghiệm tuyệt vời khi lưu trú tại đây.</p>
                </div>

                <div class="detail-page__amenities">
                    <h3>Tiện nghi</h3>
                    <div class="detail-page__amenities-grid">
                        <div class="detail-page__amenity">
                            <i class="fas fa-wifi"></i>
                            <span>WiFi miễn phí</span>
                        </div>
                        <div class="detail-page__amenity">
                            <i class="fas fa-parking"></i>
                            <span>Bãi đỗ xe</span>
                        </div>
                        <div class="detail-page__amenity">
                            <i class="fas fa-swimming-pool"></i>
                            <span>Hồ bơi</span>
                        </div>
                        <div class="detail-page__amenity">
                            <i class="fas fa-utensils"></i>
                            <span>Bếp đầy đủ</span>
                        </div>
                        <div class="detail-page__amenity">
                            <i class="fas fa-tv"></i>
                            <span>TV thông minh</span>
                        </div>
                        <div class="detail-page__amenity">
                            <i class="fas fa-air-conditioner"></i>
                            <span>Điều hòa</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-page__booking">
                <div class="detail-page__price">
                    <span class="detail-page__price-amount">2,000,000₫</span>
                    <span class="detail-page__price-period">/đêm</span>
                </div>

                <form class="detail-page__booking-form">
                    <div class="detail-page__date-inputs">
                        <input type="date" class="detail-page__date-input" placeholder="Nhận phòng">
                        <input type="date" class="detail-page__date-input" placeholder="Trả phòng">
                    </div>
                    <select class="detail-page__guest-select">
                        <option value="">Số khách</option>
                        <option value="1">1 khách</option>
                        <option value="2">2 khách</option>
                        <option value="3">3 khách</option>
                        <option value="4">4 khách</option>
                    </select>
                    <button type="submit" class="detail-page__booking-button">Đặt phòng</button>
                </form>

                <div class="detail-page__price-breakdown">
                    <div class="detail-page__price-item">
                        <span>2,000,000₫ x 5 đêm</span>
                        <span>10,000,000₫</span>
                    </div>
                    <div class="detail-page__price-item">
                        <span>Phí dịch vụ</span>
                        <span>1,500,000₫</span>
                    </div>
                    <div class="detail-page__price-total">
                        <span>Tổng cộng</span>
                        <span>11,500,000₫</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rating & Reviews Section -->
<div class="detail-page__reviews">
    <div class="container-custom">
        <div class="reviews-header">
            <div class="reviews-summary">
                <div class="reviews-score">
                    <span class="score-number">4,92</span>
                    <div class="score-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="reviews-count">· 128 đánh giá</span>
                </div>

                <div class="rating-criteria">
                    <div class="rating-row">
                        <span class="criteria-label">Mức độ sạch sẽ</span>
                        <div class="rating-bar-container">
                            <div class="rating-bar" style="width: 100%"></div>
                        </div>
                        <span class="criteria-score">5.0</span>
                    </div>
                    <div class="rating-row">
                        <span class="criteria-label">Độ chính xác</span>
                        <div class="rating-bar-container">
                            <div class="rating-bar" style="width: 100%"></div>
                        </div>
                        <span class="criteria-score">5.0</span>
                    </div>
                    <div class="rating-row">
                        <span class="criteria-label">Giao tiếp</span>
                        <div class="rating-bar-container">
                            <div class="rating-bar" style="width: 100%"></div>
                        </div>
                        <span class="criteria-score">5.0</span>
                    </div>
                    <div class="rating-row">
                        <span class="criteria-label">Vị trí</span>
                        <div class="rating-bar-container">
                            <div class="rating-bar" style="width: 96%"></div>
                        </div>
                        <span class="criteria-score">4.8</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="reviews-list">
            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Reviewer" class="reviewer-avatar">
                        <div class="reviewer-details">
                            <h4>Bogdan-Lucian</h4>
                            <p>1 tuần trước · Đã ở 3 đêm</p>
                        </div>
                    </div>
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <span>5.0</span>
                    </div>
                </div>
                <div class="review-content">
                    <p>Tôi đã có một kỳ nghỉ tuyệt vời tại nhà của David ở Paris. Căn hộ rất sạch sẽ, âm cúng và rất yên tĩnh, làm cho nó trở thành một nơi nghỉ ngơi tuyệt vời sau khi khám phá thành phố. Vị trí thuận tiện để đi lại và gần các điểm tham quan.</p>
                </div>
                <div class="review-actions">
                    <button class="review-like-btn" onclick="toggleLike(this)">
                        <i class="far fa-heart"></i>
                        <span class="like-count">12</span>
                    </button>
                    <button class="review-reply-btn" onclick="toggleReplyForm(this)">
                        <i class="far fa-comment"></i>
                        <span>Trả lời</span>
                    </button>
                </div>
                <div class="review-replies">
                    <div class="reply-form" style="display: none;">
                        <textarea placeholder="Viết phản hồi của bạn..."></textarea>
                        <button class="reply-submit">Gửi</button>
                    </div>
                </div>
            </div>

            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Reviewer" class="reviewer-avatar">
                        <div class="reviewer-details">
                            <h4>Hasan</h4>
                            <p>3 tuần trước · Đã ở 2 đêm</p>
                        </div>
                    </div>
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <span>4.8</span>
                    </div>
                </div>
                <div class="review-content">
                    <p>Là một chỗ ở tuyệt vời với phần hồi nhanh và thân thiện, thích các cuộc trò chuyện của chúng tôi và cả những lời khuyên về khu vực xung quanh. Căm ơn David!</p>
                </div>
                <div class="review-actions">
                    <button class="review-like-btn" onclick="toggleLike(this)">
                        <i class="far fa-heart"></i>
                        <span class="like-count">8</span>
                    </button>
                    <button class="review-reply-btn" onclick="toggleReplyForm(this)">
                        <i class="far fa-comment"></i>
                        <span>Trả lời</span>
                    </button>
                </div>
                <div class="review-replies">
                    <div class="reply-form" style="display: none;">
                        <textarea placeholder="Viết phản hồi của bạn..."></textarea>
                        <button class="reply-submit">Gửi</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="reviews-pagination">
            <button class="load-more-reviews">Xem thêm đánh giá</button>
        </div>

        <!-- Write Review Form -->
        <div class="write-review">
            <h3>Viết đánh giá của bạn</h3>
            <div class="rating-input">
                <div class="rating-stars">
                    <i class="far fa-star" data-rating="1"></i>
                    <i class="far fa-star" data-rating="2"></i>
                    <i class="far fa-star" data-rating="3"></i>
                    <i class="far fa-star" data-rating="4"></i>
                    <i class="far fa-star" data-rating="5"></i>
                </div>
                <span class="rating-text">Chọn đánh giá của bạn</span>
            </div>
            <textarea class="review-textarea" placeholder="Chia sẻ trải nghiệm của bạn..."></textarea>
            <button class="submit-review">Gửi đánh giá</button>
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

<!-- Share Modal -->
<div class="share-modal" id="shareModal">
    <div class="share-content">
        <div class="share-header">
            <h3>Chia sẻ</h3>
            <button class="share-close" onclick="closeShareModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="share-body">
            <div class="share-url-container">
                <input type="text" class="share-url-input" id="shareUrl" readonly>
                <button class="share-copy-btn" onclick="copyShareUrl()">Sao chép</button>
            </div>
            <div class="share-social">
                <a href="#" class="share-social-btn facebook" onclick="shareToFacebook()">
                    <i class="fab fa-facebook"></i>
                    <span>Facebook</span>
                </a>
                <a href="#" class="share-social-btn twitter" onclick="shareToTwitter()">
                    <i class="fab fa-twitter"></i>
                    <span>Twitter</span>
                </a>
                <a href="#" class="share-social-btn telegram" onclick="shareToTelegram()">
                    <i class="fab fa-telegram"></i>
                    <span>Telegram</span>
                </a>
                <a href="#" class="share-social-btn whatsapp" onclick="shareToWhatsApp()">
                    <i class="fab fa-whatsapp"></i>
                    <span>WhatsApp</span>
                </a>
                <a href="#" class="share-social-btn email" onclick="shareToEmail()">
                    <i class="fas fa-envelope"></i>
                    <span>Email</span>
                </a>
                <a href="#" class="share-social-btn messenger" onclick="shareToMessenger()">
                    <i class="fab fa-facebook-messenger"></i>
                    <span>Messenger</span>
                </a>
                <a href="#" class="share-social-btn line" onclick="shareToLine()">
                    <i class="fab fa-line"></i>
                    <span>Line</span>
                </a>
                <a href="#" class="share-social-btn zalo" onclick="shareToZalo()">
                    <i class="fas fa-comment"></i>
                    <span>Zalo</span>
                </a>
            </div>
        </div>
        <div class="share-footer">
            <p>Chia sẻ trang này với bạn bè của bạn</p>
        </div>
    </div>
</div>

<script>
   const images = [
        @foreach ($post->images as $image)
            "{{ asset($image->image_path) }}",
        @endforeach
    ];

    let currentImageIndex = 0;
    const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
    const previewImage = document.getElementById('previewImage');
    const imageCounter = document.querySelector('.image-counter');

    function openPreview(index) {
        currentImageIndex = index;
        updatePreviewImage();
        previewModal.show();
    }

    function closePreview() {
        previewModal.hide();
    }

    function prevImage() {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        updatePreviewImage();
    }

    function nextImage() {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        updatePreviewImage();
    }

    function updatePreviewImage() {
        previewImage.src = images[currentImageIndex];
        imageCounter.textContent = `${currentImageIndex + 1}/${images.length}`;
    }

    // Close modal when clicking outside
    document.getElementById('previewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePreview();
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (document.getElementById('previewModal').classList.contains('show')) {
            if (e.key === 'Escape') {
                closePreview();
            } else if (e.key === 'ArrowLeft') {
                prevImage();
            } else if (e.key === 'ArrowRight') {
                nextImage();
            }
        }
    });

    // New review functions
    function toggleLike(button) {
        const icon = button.querySelector('i');
        const count = button.querySelector('.like-count');
        if (icon.classList.contains('far')) {
            icon.classList.replace('far', 'fas');
            count.textContent = parseInt(count.textContent) + 1;
        } else {
            icon.classList.replace('fas', 'far');
            count.textContent = parseInt(count.textContent) - 1;
        }
    }

    function toggleReplyForm(button) {
        const replyForm = button.closest('.review-item').querySelector('.reply-form');
        replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
    }

    // Rating stars interaction
    document.querySelectorAll('.rating-input .rating-stars i').forEach(star => {
        star.addEventListener('mouseover', function() {
            const rating = this.dataset.rating;
            updateStars(rating);
        });

        star.addEventListener('click', function() {
            const rating = this.dataset.rating;
            document.querySelector('.rating-text').textContent = `Bạn đã chọn ${rating} sao`;
            this.parentElement.dataset.selected = rating;
        });
    });

    document.querySelector('.rating-input .rating-stars').addEventListener('mouseleave', function() {
        const selected = this.dataset.selected;
        if (selected) {
            updateStars(selected);
        } else {
            clearStars();
        }
    });

    function updateStars(rating) {
        document.querySelectorAll('.rating-input .rating-stars i').forEach((star, index) => {
            if (index < rating) {
                star.classList.replace('far', 'fas');
            } else {
                star.classList.replace('fas', 'far');
            }
        });
    }

    function clearStars() {
        document.querySelectorAll('.rating-input .rating-stars i').forEach(star => {
            star.classList.replace('fas', 'far');
        });
    }

    // Function to open gallery modal
    function openGallery() {
        const modal = new bootstrap.Modal(document.getElementById('imageGalleryModal'));
        modal.show();
    }

    // Function to close gallery modal
    function closeGallery() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('imageGalleryModal'));
        modal.hide();
    }

    // Function to handle favorite button click
    window.handleFavorite = function(button) {
        const isAuthenticated = button.dataset.authenticated === 'true';
        const postId = button.dataset.postId;
        
        if (!isAuthenticated) {
            showToast('Vui lòng đăng nhập để thêm vào yêu thích', 'warning');
            return false;
        }
        
        toggleFavorite(button, postId);
    };

    // Function to toggle favorite status
    window.toggleFavorite = function(button, postId) {
        button.disabled = true; // Prevent rapid clicks
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
                    window.location.href = '/login';
                    return;
                }
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (!data) return;
            const icon = button.querySelector('i');
            const text = button.querySelector('.favorite-count');
            if (data.favorited) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                icon.classList.add('text-danger');
                button.classList.add('active');
                button.setAttribute('data-favorited', 'true');
                button.title = 'Bỏ yêu thích';
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                icon.classList.remove('text-danger');
                button.classList.remove('active');
                button.setAttribute('data-favorited', 'false');
                button.title = 'Yêu thích';
            }
            if (text) {
                text.textContent = data.favoritesCount;
            }
            showToast(data.message, data.favorited ? 'success' : 'info');
            document.querySelectorAll(`.favorite-btn[data-post-id="${postId}"], .btn-favorite[data-post-id="${postId}"]`).forEach(btn => {
                if (btn !== button) {
                    const btnIcon = btn.querySelector('i');
                    const btnText = btn.querySelector('.favorite-count');
                    if (data.favorited) {
                        btnIcon.classList.remove('far');
                        btnIcon.classList.add('fas');
                        btnIcon.classList.add('text-danger');
                        btn.classList.add('active');
                        btn.setAttribute('data-favorited', 'true');
                        btn.title = 'Bỏ yêu thích';
                    } else {
                        btnIcon.classList.remove('fas');
                        btnIcon.classList.add('far');
                        btnIcon.classList.remove('text-danger');
                        btn.classList.remove('active');
                        btn.setAttribute('data-favorited', 'false');
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
        })
        .finally(() => {
            button.disabled = false; // Re-enable button
        });
    };

    // Share functions
    function sharePost() {
        const modal = document.getElementById('shareModal');
        const shareUrl = document.getElementById('shareUrl');
        shareUrl.value = window.location.href;
        modal.classList.add('show');
    }

    function closeShareModal() {
        const modal = document.getElementById('shareModal');
        modal.classList.remove('show');
    }

    function copyShareUrl() {
        const shareUrl = document.getElementById('shareUrl');
        const copyBtn = document.querySelector('.share-copy-btn');
        
        shareUrl.select();
        document.execCommand('copy');
        
        copyBtn.textContent = 'Đã sao chép!';
        copyBtn.classList.add('copied');
        
        setTimeout(() => {
            copyBtn.textContent = 'Sao chép';
            copyBtn.classList.remove('copied');
        }, 2000);
    }

    // function shareToFacebook() {
    //     const url = encodeURIComponent(window.location.href);
    //     const title = encodeURIComponent(document.title);
    //     window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
    // }

    // function shareToTwitter() {
    //     const url = encodeURIComponent(window.location.href);
    //     const title = encodeURIComponent(document.title);
    //     window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank');
    // }

    // function shareToTelegram() {
    //     const url = encodeURIComponent(window.location.href);
    //     const title = encodeURIComponent(document.title);
    //     window.open(`https://t.me/share/url?url=${url}&text=${title}`, '_blank');
    // }

    // function shareToWhatsApp() {
    //     const url = encodeURIComponent(window.location.href);
    //     const title = encodeURIComponent(document.title);
    //     window.open(`https://wa.me/?text=${title}%20${url}`, '_blank');
    // }

    // function shareToEmail() {
    //     const url = encodeURIComponent(window.location.href);
    //     const title = encodeURIComponent(document.title);
    //     window.open(`mailto:?subject=${title}&body=${url}`, '_blank');
    // }

    // function shareToMessenger() {
    //     const url = encodeURIComponent(window.location.href);
    //     window.open(`https://www.facebook.com/dialog/send?link=${url}&app_id=YOUR_APP_ID`, '_blank');
    // }

    // function shareToLine() {
    //     const url = encodeURIComponent(window.location.href);
    //     const title = encodeURIComponent(document.title);
    //     window.open(`https://line.me/R/share?text=${title}%0A${url}`, '_blank');
    // }

    // function shareToZalo() {
    //     const url = encodeURIComponent(window.location.href);
    //     const title = encodeURIComponent(document.title);
    //     window.open(`https://zalo.me/share?u=${url}&t=${title}`, '_blank');
    // }

    // Close modal when clicking outside
    document.getElementById('shareModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeShareModal();
        }
    });
</script>
@endsection

@push('styles')

@endpush