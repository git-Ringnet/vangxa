@extends('layouts.app')

@section('content')
<div class="container-custom detail-dining-page">
    <!-- Image Gallery -->
    <div class="detail-gallery">
        <div class="gallery-main">
            <img src="https://statics.vincom.com.vn/xu-huong/anh_thumbnail/Nha-hang-Ngoc-Suong.jpg" alt="Nhà hàng Sen" class="main-image">
        </div>
        <div class="gallery-grid">
            <img src="https://statics.vincom.com.vn/xu-huong/anh_thumbnail/Nha-hang-Ngoc-Suong.jpg" alt="Nhà hàng Sen" class="grid-image">
            <img src="https://simg.zalopay.com.vn/zlp-website/assets/nha_hang_17_ae655c3ea8.jpg" alt="Nhà hàng Sen" class="grid-image">
            <img src="https://simg.zalopay.com.vn/zlp-website/assets/nha_hang_17_ae655c3ea8.jpg" alt="Nhà hàng Sen" class="grid-image">
            <img src="https://simg.zalopay.com.vn/zlp-website/assets/nha_hang_17_ae655c3ea8.jpg" alt="Nhà hàng Sen" class="grid-image">
        </div>
        <button class="view-all-photos">
            <i class="fas fa-th"></i>
            Xem tất cả ảnh
        </button>
    </div>

    <!-- Detail Content -->
    <div class="detail-content">
        <div class="content-main">
            <!-- Restaurant Title -->
            <div class="detail-header">
                <h1 class="detail-title">Nhà hàng Sen - Buffet Hải Sản & Món Việt</h1>
                <div class="detail-badges">
                    <span class="badge-item"><i class="fas fa-award"></i> Đạt chứng nhận vệ sinh an toàn thực phẩm</span>
                    <span class="badge-item"><i class="fas fa-check-circle"></i> Đã xác minh</span>
                </div>
            </div>

            <!-- Restaurant Info -->
            <div class="detail-info">
                <div class="info-item">
                    <span class="info-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>57-59 Láng Hạ, Quận Ba Đình, Hà Nội</span>
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
                <p>Nhà hàng Sen tọa lạc tại trung tâm Hà Nội, mang đến trải nghiệm ẩm thực đẳng cấp với các món ăn Việt Nam truyền thống được chế biến tinh tế. Không gian nhà hàng được thiết kế theo phong cách hiện đại pha lẫn nét truyền thống, tạo cảm giác sang trọng nhưng vẫn gần gũi.</p>
                <p>Nhà hàng Sen nổi tiếng với các món ăn từ hải sản tươi sống và các món đặc sản Việt Nam được chế biến bởi đội ngũ đầu bếp giàu kinh nghiệm. Đặc biệt, nhà hàng còn phục vụ buffet hải sản cao cấp vào buổi tối với hơn 100 món ăn đa dạng.</p>
            </div>

            <!-- Menu Highlights -->
            <div class="menu-highlights">
                <h2>Món ăn đặc trưng</h2>
                <div class="highlight-grid">
                    <div class="highlight-item">
                        <img src="https://danhgiachuan.vn/wp-content/uploads/2020/09/buffet-sen-6.jpg" alt="Hải sản tươi" class="highlight-image">
                        <div class="highlight-info">
                            <h3>Hải sản tươi sống</h3>
                            <p>Các loại hải sản tươi ngon nhất từ các vùng biển Việt Nam</p>
                            <span class="highlight-price">350,000₫</span>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <img src="https://images.foody.vn/res/g1/3228/prof/s576x330/foody-mobile-sen-jpg-606-635744114268054380.jpg" alt="Gỏi cuốn tôm thịt" class="highlight-image">
                        <div class="highlight-info">
                            <h3>Gỏi cuốn tôm thịt</h3>
                            <p>Gỏi cuốn truyền thống với tôm tươi, thịt heo, rau thơm và bún</p>
                            <span class="highlight-price">120,000₫</span>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <img src="https://i.ytimg.com/vi/2oOqNgKBEng/maxresdefault.jpg" alt="Bún chả Hà Nội" class="highlight-image">
                        <div class="highlight-info">
                            <h3>Bún chả Hà Nội</h3>
                            <p>Bún ăn kèm với chả thịt lợn nướng và nước mắm pha chua ngọt</p>
                            <span class="highlight-price">150,000₫</span>
                        </div>
                    </div>
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
                    <p><i class="fas fa-map-marker-alt"></i> 57-59 Láng Hạ, Quận Ba Đình, Hà Nội</p>
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
            <div class="similar-restaurants">
                <h3>Nhà hàng tương tự</h3>
                <div class="similar-list">
                    <a href="#" class="similar-item">
                        <img src="https://media-cdn.tripadvisor.com/media/photo-s/08/98/e0/af/getlstd-property-photo.jpg" alt="Quán Ăn Ngon" class="similar-image">
                        <div class="similar-info">
                            <h4>Quán Ăn Ngon</h4>
                            <div class="similar-rating">
                                <i class="fas fa-star"></i>
                                <span>4.7</span>
                            </div>
                            <p>Ẩm thực Việt Nam</p>
                        </div>
                    </a>
                    <a href="#" class="similar-item">
                        <img src="https://media-cdn.tripadvisor.com/media/photo-s/11/87/f3/03/cuc-gach-restaurant.jpg" alt="Cục Gạch Quán" class="similar-image">
                        <div class="similar-info">
                            <h4>Cục Gạch Quán</h4>
                            <div class="similar-rating">
                                <i class="fas fa-star"></i>
                                <span>4.6</span>
                            </div>
                            <p>Ẩm thực Việt Nam</p>
                        </div>
                    </a>
                    <a href="#" class="similar-item">
                        <img src="https://media-cdn.tripadvisor.com/media/photo-s/17/7a/67/a0/pizza-4p-s-saigon-centre.jpg" alt="Pizza 4P's" class="similar-image">
                        <div class="similar-info">
                            <h4>Pizza 4P's</h4>
                            <div class="similar-rating">
                                <i class="fas fa-star"></i>
                                <span>4.9</span>
                            </div>
                            <p>Ý, Fusion</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // View all photos
        const viewAllPhotosBtn = document.querySelector('.view-all-photos');
        if (viewAllPhotosBtn) {
            viewAllPhotosBtn.addEventListener('click', function() {
                // Photo gallery modal logic would go here
                alert('Tính năng xem tất cả ảnh đang được phát triển');
            });
        }
    });
</script>
@endpush 