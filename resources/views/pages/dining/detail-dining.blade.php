@extends('layouts.main')

@section('content')
    <div class="container-custom detail-dining-page">
        <!-- Image Gallery -->
        <div class="detail-gallery">
            <div class="gallery-main">
                <img src="https://statics.vincom.com.vn/xu-huong/anh_thumbnail/Nha-hang-Ngoc-Suong.jpg" alt="Nhà hàng Sen"
                    class="main-image">
            </div>
            <div class="gallery-grid">
                <img src="https://statics.vincom.com.vn/xu-huong/anh_thumbnail/Nha-hang-Ngoc-Suong.jpg" alt="Nhà hàng Sen"
                    class="grid-image">
                <img src="https://simg.zalopay.com.vn/zlp-website/assets/nha_hang_17_ae655c3ea8.jpg" alt="Nhà hàng Sen"
                    class="grid-image">
                <img src="https://simg.zalopay.com.vn/zlp-website/assets/nha_hang_17_ae655c3ea8.jpg" alt="Nhà hàng Sen"
                    class="grid-image">
                <img src="https://simg.zalopay.com.vn/zlp-website/assets/nha_hang_17_ae655c3ea8.jpg" alt="Nhà hàng Sen"
                    class="grid-image">
            </div>
            <button class="view-all-photos">
                <i class="fas fa-th"></i>
                Xem tất cả ảnh
            </button>
        </div>

        <!-- Detail Content -->
        <div class="">
            <div class="content-main">
                <!-- Restaurant Title -->
                <div class="detail-header">
                    <h1 class="detail-title">Nhà hàng Sen - Buffet Hải Sản & Món Việt</h1>
                    {{-- <div class="detail-badges">
                    <span class="badge-item"><i class="fas fa-award"></i> Đạt chứng nhận vệ sinh an toàn thực phẩm</span>
                    <span class="badge-item"><i class="fas fa-check-circle"></i> Đã xác minh</span>
                </div> --}}
                </div>

                <!-- Restaurant Info -->
                {{-- <div class="detail-info">
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
            </div> --}}

                <!-- Description -->
                <div class="detail-description">
                    <h2>Giới thiệu</h2>
                    <p>Nhà hàng Sen tọa lạc tại trung tâm Hà Nội, mang đến trải nghiệm ẩm thực đẳng cấp với các món ăn Việt
                        Nam truyền thống được chế biến tinh tế. Không gian nhà hàng được thiết kế theo phong cách hiện đại
                        pha lẫn nét truyền thống, tạo cảm giác sang trọng nhưng vẫn gần gũi.</p>
                    <p>Nhà hàng Sen nổi tiếng với các món ăn từ hải sản tươi sống và các món đặc sản Việt Nam được chế biến
                        bởi đội ngũ đầu bếp giàu kinh nghiệm. Đặc biệt, nhà hàng còn phục vụ buffet hải sản cao cấp vào buổi
                        tối với hơn 100 món ăn đa dạng.</p>
                </div>

                <!-- Menu Highlights -->
                {{-- <div class="menu-highlights">
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
            </div> --}}

                <!-- Rating & Reviews -->
                <div class="rating-section" id="ratingSection">
                    <h2>Đánh giá và nhận xét</h2>

                    <!-- Toast Notifications -->
                    <div id="toastContainer" class="toast-container"></div>

                    <!-- Review Form -->
                    <div class="write-review">
                        <h3>Viết đánh giá của bạn</h3>
                        <form action="{{ route('reviews.store') }}" method="POST" id="reviewForm">
                            @csrf
                            <div class="form-group my-3">
                                <label>Đánh giá món ăn <span class="text-danger">*</span></label>
                                <div class="rating">
                                    <input type="radio" name="food_rating" value="5" id="food-5"
                                        {{ old('food_rating') == 5 ? 'checked' : '' }}><label for="food-5">5</label>
                                    <input type="radio" name="food_rating" value="4" id="food-4"
                                        {{ old('food_rating') == 4 ? 'checked' : '' }}><label for="food-4">4</label>
                                    <input type="radio" name="food_rating" value="3" id="food-3"
                                        {{ old('food_rating') == 3 ? 'checked' : '' }}><label for="food-3">3</label>
                                    <input type="radio" name="food_rating" value="2" id="food-2"
                                        {{ old('food_rating') == 2 ? 'checked' : '' }}><label for="food-2">2</label>
                                    <input type="radio" name="food_rating" value="1" id="food-1"
                                        {{ old('food_rating') == 1 ? 'checked' : '' }}><label for="food-1">1</label>
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
                    {{-- <div class="reviews-list">
                        @foreach ($post->reviews()->with('user')->latest()->get() as $review)
                            <div class="review-item">
                                <div class="review-header">
                                    <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($review->user->name) }}" 
                                         alt="{{ $review->user->name }}" class="reviewer-avatar">
                                    <div class="reviewer-info">
                                        <h4>{{ $review->user->name }}</h4>
                                        <div class="review-meta">
                                            <div class="review-stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->food_rating ? 'text-warning' : 'text-muted' }}"></i>
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
                    </div> --}}
                </div>

                <!-- Location Map -->
                <div class="location-section">
                    <h2>Vị trí</h2>
                    {{-- <div class="location-map">
                        <img src="https://maps.googleapis.com/maps/api/staticmap?center=21.0236,105.8109&zoom=15&size=600x300&maptype=roadmap&markers=color:red%7C21.0236,105.8109&key=YOUR_API_KEY"
                            alt="Restaurant Location Map" class="map-image">
                    </div> --}}
                    <div class="location-address">
                        <p><i class="fas fa-map-marker-alt"></i> 57-59 Láng Hạ, Quận Ba Đình, Hà Nội</p>
                        <button class="get-directions-btn"><i class="fas fa-directions"></i> Chỉ đường</button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            {{-- <div class="content-sidebar">
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
        </div> --}}
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

            // Hiển thị thông báo toast
            function showToast(message, type = 'success') {
                // Xóa tất cả toast cũ
                const toastContainer = document.getElementById('toastContainer');
                toastContainer.innerHTML = '';

                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;
                toast.innerHTML = `
                    <div class="toast-content">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                        <span>${message}</span>
                    </div>
                    <button class="toast-close">&times;</button>
                `;

                toastContainer.appendChild(toast);

                // Hiển thị toast
                setTimeout(() => {
                    toast.classList.add('show');
                }, 10);

                // Tự động ẩn sau 5 giây
                const timeout = setTimeout(() => {
                    hideToast(toast);
                }, 5000);

                // Nút đóng toast
                const closeBtn = toast.querySelector('.toast-close');
                closeBtn.addEventListener('click', () => {
                    clearTimeout(timeout);
                    hideToast(toast);
                });
            }

            // Ẩn toast
            function hideToast(toast) {
                toast.classList.remove('show');
                toast.classList.add('hide');

                // Xóa toast sau khi animation kết thúc
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }

            // Kiểm tra và hiển thị thông báo từ session
            @if (session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif

            // Kiểm tra và hiển thị lỗi validation
            @if ($errors->any())
                showToast("{{ $errors->first() }}", 'error');
            @endif

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
        });
    </script>
@endpush
