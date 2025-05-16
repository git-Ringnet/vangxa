<div class="story-modal" id="storyModal-{{ $post->id }}">
    <div class="story-modal-content">
        <!-- User Profile Section -->
        <div class="story-profile-section">
            <div class="story-profile-header">
                <div class="story-user-main">
                    <div class="story-avatar">
                        <img src="{{ $post->user->avatar ?? 'https://via.placeholder.com/150' }}" alt="User Avatar">
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
                    <span class="stat-number">{{ number_format($post->rating ?? 4.95, 2) }} <i
                            class="fas fa-star"></i></span>
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
