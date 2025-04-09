@extends('layouts.main')

@section('content')
<div class="detail-page">
    <div class="container-custom">
        <div class="detail-page__header">
            <h1 class="detail-page__title">Căn hộ sang trọng tại trung tâm</h1>
            <p class="detail-page__location">Quận 1, Hồ Chí Minh</p>
            <div class="detail-page__rating">
                <i class="fas fa-star"></i>
                <span>4.92</span>
            </div>
            <div class="detail-page__actions">
                <button class="detail-page__action-button detail-page__action-button--share">
                    <i class="fas fa-share"></i>
                    <span>Chia sẻ</span>
                </button>
                <button class="detail-page__action-button detail-page__action-button--save">
                    <i class="fas fa-heart"></i>
                    <span>Lưu</span>
                </button>
            </div>
        </div>

        <!-- Rating Details Section -->
        <!-- <div class="detail-page__rating-details">
            <div class="rating-overview">
                <div class="rating-laurel">
                    <span class="rating-score">4,92</span>
                </div>
                <h2 class="rating-title">Được khách yêu thích</h2>
                <p class="rating-subtitle">Nhà này được khách yêu thích dựa trên điểm xếp hạng, lượt đánh giá và độ tin cậy</p>
            </div>

            <div class="rating-criteria">
                <div class="rating-row">
                    <span class="criteria-label">Xếp hạng tổng thể</span>
                    <div class="rating-bar-container">
                        <div class="rating-bar" style="width: 100%"></div>
                    </div>
                    <span class="criteria-score">5</span>
                </div>
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
                    <span class="criteria-label">Nhận phòng</span>
                    <div class="rating-bar-container">
                        <div class="rating-bar" style="width: 98%"></div>
                    </div>
                    <span class="criteria-score">4.9</span>
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
                <div class="rating-row">
                    <span class="criteria-label">Giá trị</span>
                    <div class="rating-bar-container">
                        <div class="rating-bar" style="width: 98%"></div>
                    </div>
                    <span class="criteria-score">4.9</span>
                </div>
            </div>
        </div> -->

        <div class="detail-page__gallery">
            <div class="detail-page__main-image" onclick="openPreview(0)">
                <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/134475469.jpg?k=986e0385365fa9e17ef6497e2fb7d5e16552358ad343c4ad8fc35b29802eacac&o=&hp=1" alt="Căn hộ sang trọng">
                <div class="image-overlay">Xem tất cả ảnh</div>
            </div>
            <div class="detail-page__gallery-item" onclick="openPreview(1)">
                <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Phòng khách">
                <div class="image-number">1/5</div>
                <i class="fas fa-search-plus zoom-icon"></i>
            </div>
            <div class="detail-page__gallery-item" onclick="openPreview(2)">
                <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Phòng ngủ">
                <div class="image-number">2/5</div>
                <i class="fas fa-search-plus zoom-icon"></i>
            </div>
            <div class="detail-page__gallery-item" onclick="openPreview(3)">
                <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Nhà bếp">
                <div class="image-number">3/5</div>
                <i class="fas fa-search-plus zoom-icon"></i>
            </div>
            <div class="detail-page__gallery-item" onclick="openPreview(4)">
                <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Phòng tắm">
                <div class="image-number">4/5</div>
                <i class="fas fa-search-plus zoom-icon"></i>
            </div>
        </div>

        <!-- Image Preview Modal -->
        <div class="image-preview-modal" id="previewModal">
            <div class="image-preview-content">
                <img src="" alt="" id="previewImage">
                <i class="fas fa-times close-preview" onclick="closePreview()"></i>
                <i class="fas fa-chevron-left nav-preview prev" onclick="prevImage()"></i>
                <i class="fas fa-chevron-right nav-preview next" onclick="nextImage()"></i>
            </div>
        </div>

        <div class="detail-page__content">
            <div class="detail-page__info">
                <div class="detail-page__host">
                    <div class="detail-page__host-avatar">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Chủ nhà">
                    </div>
                    <div class="detail-page__host-info">
                        <h3>Chủ nhà: Nguyễn Văn A</h3>
                        <p>Đã tham gia từ tháng 1, 2020</p>
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

<script>
    const images = [
        'https://cf.bstatic.com/xdata/images/hotel/max1024x768/134475469.jpg?k=986e0385365fa9e17ef6497e2fb7d5e16552358ad343c4ad8fc35b29802eacac&o=&hp=1',
        'https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D',
        'https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D',
        'https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D',
        'https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D'
    ];

    let currentImageIndex = 0;

    function openPreview(index) {
        currentImageIndex = index;
        const modal = document.getElementById('previewModal');
        const previewImage = document.getElementById('previewImage');
        previewImage.src = images[index];
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closePreview() {
        const modal = document.getElementById('previewModal');
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    function prevImage() {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        document.getElementById('previewImage').src = images[currentImageIndex];
    }

    function nextImage() {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        document.getElementById('previewImage').src = images[currentImageIndex];
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
</script>
@endsection

@push('styles')
<!-- <style>
    /* Listing Header */
    .listing-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .listing-title {
        font-size: 26px;
        font-weight: 600;
        margin: 0;
    }

    .listing-actions {
        display: flex;
        gap: 16px;
    }

.share-button, .save-button {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

.share-button:hover, .save-button:hover {
        background: #f7f7f7;
    }

    /* Image Gallery */
    .image-gallery {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 8px;
        margin-bottom: 32px;
    }

    .main-image {
        aspect-ratio: 16/9;
        overflow: hidden;
        border-radius: 12px;
    }

    .main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .thumbnail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .thumbnail {
        aspect-ratio: 1;
        overflow: hidden;
        border-radius: 12px;
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Listing Content */
    .listing-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 32px;
    }

    .listing-details {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    /* Host Info */
    .listing-host {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-bottom: 24px;
        border-bottom: 1px solid #ddd;
    }

    .host-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
    }

    .host-info h3 {
        margin: 0;
        font-size: 18px;
    }

    .host-info p {
        margin: 4px 0 0;
        color: #666;
    }

    /* Features */
    .listing-features {
        display: flex;
        gap: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid #ddd;
    }

    .feature {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .feature i {
        font-size: 20px;
    }

    /* Description */
    .listing-description {
        padding-bottom: 24px;
        border-bottom: 1px solid #ddd;
    }

    /* Booking Form */
    .booking-form {
        position: sticky;
        top: 20px;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 24px;
    }

    .price-info {
        margin-bottom: 24px;
    }

    .price {
        font-size: 22px;
        font-weight: 600;
    }

    .period {
        color: #666;
    }

    .date-picker {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    .check-in,
    .check-out {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    input[type="date"],
    select {
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 100%;
    }

    .guests-selector {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 24px;
    }

    .book-button {
        width: 100%;
        padding: 16px;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .book-button:hover {
        background-color: #e31c5f;
    }

    .price-breakdown {
        text-align: center;
        margin-top: 16px;
        color: #666;
    }

    /* Amenities */
    .amenities-section {
        margin-top: 48px;
    }

    .amenities-section h2 {
        margin-bottom: 24px;
    }

    .amenities-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .amenity {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .amenity i {
        font-size: 20px;
    }

    /* Reviews */
    .reviews-section {
        margin-top: 48px;
    }

    .reviews-section h2 {
        margin-bottom: 24px;
    }

    .review-summary {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 32px;
    }

    .rating {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .rating i {
        color: #ff385c;
    }

    .reviews-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }

    .review {
        padding: 24px;
        border: 1px solid #ddd;
        border-radius: 12px;
    }

    .reviewer {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .reviewer img {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }

    .reviewer-info h4 {
        margin: 0;
        font-size: 16px;
    }

    .reviewer-info p {
        margin: 4px 0 0;
        color: #666;
    }

    .review-text {
        margin: 0;
        line-height: 1.5;
    }
</style> -->
@endpush