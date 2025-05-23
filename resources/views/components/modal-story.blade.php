<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

<div class="story-modal" id="storyModal-{{ $post->id }}">
    <div class="story-modal-content">
        <!-- Header với thông tin vendor và nút đóng -->
        <div class="story-modal-header">
            <div class="vendor-info d-flex align-items-center">
                <img src="{{ $post->user->avatar ?? asset('image/default/default-avatar.jpg') }}" alt="{{ $post->user->name }}" class="rounded-circle me-3" width="50" height="50">
                <div>
                    <h4 class="mb-0">{{ $post->user->name }}</h4>
                    <p class="text-muted small mb-0">
                        Vendor
                    </p>
                </div>
            </div>
            <button type="button" class="btn-close" onclick="closeStoryModal('{{ $post->id }}')" aria-label="Close"></button>
        </div>

        <!-- Nội dung câu chuyện -->
        <div class="story-modal-body">
            @if($post->user->stories->count() > 0)
                <div class="swiper story-swiper" id="storySwiper-{{ $post->id }}">
                    <div class="swiper-wrapper">
                        @foreach($post->user->stories as $index => $story)
                            <div class="swiper-slide">
                                <div class="story-item">
                                    @if($story->image_path)
                                        <div class="story-image mb-3">
                                            <img src="{{ asset('storage/' . $story->image_path) }}" alt="Story Image" class="img-fluid rounded">
                                        </div>
                                    @endif
                                    <div class="story-content">
                                        @if($story->title)
                                            <h3 class="story-title mb-2">{{ $story->title }}</h3>
                                        @endif
                                        <div class="story-text">
                                            {!! nl2br(e($story->content)) !!}
                                        </div>
                                        <div class="story-date text-muted mt-2">
                                            <small><i class="far fa-calendar-alt me-1"></i>{{ $story->created_at->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination dots (move outside swiper-wrapper) -->
                    <div class="swiper-pagination"></div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-book fa-3x mb-3 text-muted"></i>
                    <h5>Chưa có câu chuyện nào</h5>
                    <p class="text-muted">Vendor này chưa chia sẻ câu chuyện nào.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.story-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: none;
    z-index: 9999;
    overflow-y: auto;
    padding: 30px 0;
}

.story-modal-content {
    max-width: 700px;
    margin: 0 auto;
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    max-height: 85vh;
    display: flex;
    flex-direction: column;
}

.story-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    border-bottom: 1px solid #eee;
    flex-shrink: 0;
}

.story-modal-body {
    padding: 25px;
    overflow-y: auto;
    flex-grow: 1;
    position: relative;
}

.story-image img {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
}

.story-title {
    font-weight: 600;
    color: #333;
    font-size: 1.5rem;
}

.story-text {
    font-size: 1.05rem;
    line-height: 1.7;
    color: #444;
    white-space: pre-line;
    overflow-wrap: break-word;
    word-wrap: break-word;
}

.story-date {
    text-align: right;
}

/* Swiper custom style */
.story-swiper {
    width: 100%;
    min-height: 200px;
}
.swiper-pagination {
    position: relative;
    margin-top: 18px;
    text-align: center;
}
.swiper-pagination-bullet {
    width: 14px;
    height: 14px;
    background: rgba(0,0,0,0.18) !important;
    opacity: 1 !important;
    margin: 0 5px !important;
    border-radius: 50%;
    transition: background 0.3s;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}
.swiper-pagination-bullet-active {
    background: rgba(0,0,0,0.7) !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.18);
}

.swiper-slide,
.story-item {
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
    box-sizing: border-box;
    display: block;
}
.swiper-wrapper {
    align-items: stretch;
}
</style>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.story-swiper').forEach(function(swiperEl) {
        new Swiper(swiperEl, {
            loop: true,
            pagination: {
                el: swiperEl.querySelector('.swiper-pagination'),
                clickable: true,
            },
            grabCursor: true,
        });
    });
});

// Nếu bạn có logic mở modal, hãy đảm bảo Swiper được khởi tạo lại nếu modal được render động
</script>
