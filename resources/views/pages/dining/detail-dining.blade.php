@extends('layouts.main')

@section('content')
    <div class="container-custom detail-dining-page">
        {{-- emmbed tiktok --}}
        <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@vangxavn/video/7505765607565036808"
            data-video-id="7505765607565036808" style="max-width: 605px;min-width: 325px;">
            <section> <a target="_blank" title="@vangxavn" href="https://www.tiktok.com/@vangxavn?refer=embed">@vangxavn</a>
                Pizza nướng trong lò củi có mùi đặc trưng lắm 🥰 <a title="vangxa" target="_blank"
                    href="https://www.tiktok.com/tag/vangxa?refer=embed">#Vangxa</a> <a title="saigonfood" target="_blank"
                    href="https://www.tiktok.com/tag/saigonfood?refer=embed">#saigonfood</a> <a title="fyp"
                    target="_blank" href="https://www.tiktok.com/tag/fyp?refer=embed">#fyp</a> <a title="quan10"
                    target="_blank" href="https://www.tiktok.com/tag/quan10?refer=embed">#quan10</a> <a target="_blank"
                    title="♬ nhạc nền  - Vangxa"
                    href="https://www.tiktok.com/music/nhạc-nền-Vangxa-7505765805570575105?refer=embed">♬ nhạc nền -
                    Vangxa</a> </section>
        </blockquote>
        <script async src="https://www.tiktok.com/embed.js"></script>
        <!-- Image Gallery -->
        <div class="detail-gallery">
            {{-- <div class="gallery-main" onclick="openPreview(0)">
                @if ($post->images->isNotEmpty())
                    <img src="{{ asset($post->images->first()->image_path) }}" alt="{{ $post->title }}" class="main-image">
                @endif
            </div> --}}
            {{-- <div class="gallery-grid">
                @foreach ($post->images->skip(1)->take(4) as $index => $image)
                    <div class="detail-page__gallery-item" onclick="openPreview({{ $index + 1 }})">
                        <img src="{{ asset($image->image_path) }}" class="img-fluid rounded" alt="Post image">
                        <div class="image-number">{{ $index + 1 }}/{{ $post->images->count() }}</div>
                        <i class="fas fa-search-plus zoom-icon"></i>
                    </div>
                @endforeach
            </div> --}}
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
                        {{-- <span class="badge-item"><i class="fas fa-award"></i> Đạt chứng nhận vệ sinh an toàn thực
                        phẩm</span>
                    <span class="badge-item"><i class="fas fa-check-circle"></i> Đã xác minh</span> --}}
                        <div class="action-buttons">
                            @auth
                                <form action="{{ route('trustlist.toggle', ['id' => $post->id]) }}" method="POST"
                                    class="trustlist-form" data-post-id="{{ $post->id }}">
                                    @csrf
                                    <button type="button" class="trustlist-btn" data-post-id="{{ $post->id }}"
                                        data-saved="{{ Auth::check() && $post->isSaved ? 'true' : 'false' }}"
                                        data-authenticated="{{ Auth::check() ? 'true' : 'false' }}">
                                        <i
                                            class="{{ Auth::check() && $post->isSaved ? 'fas' : 'far' }} fa-bookmark {{ Auth::check() && $post->isSaved ? 'text-primary' : '' }}"></i>
                                        <span class="trustlist-count"
                                            data-post-id="{{ $post->id }}">{{ $post->saves_count ?? 0 }}</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn-trustlist" title="Thêm vào danh sách tin cậy"
                                    onclick="showToast('Vui lòng đăng nhập để thêm vào danh sách tin cậy', 'warning'); return false;">
                                    <i class="far fa-bookmark"></i>
                                    <span class="trustlist-count">{{ $post->saves_count ?? 0 }}</span>
                                </a>
                            @endauth
                            <button class="btn-share" onclick="sharePost()" title="Chia sẻ">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Restaurant Info -->
                {{-- <div class="detail-info">
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

                <!-- Thêm phần thông tin chủ sở hữu/vendor -->
                <div class="info-item">
                    <span class="info-icon"><i class="fas fa-user-tie"></i></span>
                    <span>
                        Chủ sở hữu/Vendor:
                        @if (isset($post->owner) && $post->owner)
                            <a href="{{ route('profile.show', $post->owner->id) }}">{{ $post->owner->name }}</a>
                        @else
                            Chưa có thông tin
                        @endif
                        @auth
                            @if (Auth::user()->hasRole('Admin') || Auth::user()->id == $post->user_id)
                                <button class="btn btn-sm btn-outline-primary ml-2" data-bs-toggle="modal" data-bs-target="#addOwnerModal">
                                    <i class="fas fa-plus-circle"></i> Thêm/Chỉnh sửa
                                </button>
                            @endif
                        @endauth
                    </span>
                </div>
            </div> --}}

                <!-- Thông tin người bán/chủ sở hữu -->
                <div class="vendor-profile mb-4">
                    <h2 class="mb-3">Thông tin chủ sở hữu</h2>
                    <div class="vendor-card d-flex align-items-center p-3"
                        style="background-color: #f8f9fa; border-radius: 10px;">
                        @php
                            // Lấy người bán/chủ sở hữu
                            $vendor = $post->user;
                            // Nếu bài đăng có owner_id riêng
                            if ($post->owner_id) {
                                $vendor = \App\Models\User::find($post->owner_id);
                            }
                        @endphp

                        <a href="{{ route('profile.show', ['id' => $vendor->id]) }}" class="vendor-avatar me-3">
                            <img src="{{ $vendor->avatar ? asset('image/avatars/' . basename($vendor->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode($vendor->name) }}"
                                alt="{{ $vendor->name }}"
                                style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover;">
                        </a>
                        <div class="vendor-info">
                            <h5 class="mb-1">
                                <a href="{{ route('profile.show', ['id' => $vendor->id]) }}"
                                    class="text-decoration-none">
                                    {{ $vendor->name }}
                                </a>
                            </h5>
                            <p class="text-muted mb-2"><small>Thành viên từ
                                    {{ $vendor->created_at->format('d/m/Y') }}</small></p>
                            <!-- <div>
                                                            <a href="{{ route('profile.show', ['id' => $vendor->id]) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-user me-1"></i> Xem hồ sơ
                                                            </a>
                                                        </div> -->
                        </div>
                    </div>
                </div>

                {{-- Hiển thị các section dạng box + slide --}}
                @foreach ($post->sections as $section)
                    <div class="section-box mb-4 p-4"
                        style="background: #f9f6ef; border-radius: 18px; border: 2px solid #eee3d0;">
                        <h2 class="section-title mb-2" style="font-weight:bold; color:#7c5c2b;">{{ $section->title }}
                        </h2>
                        <div class="section-description mb-3" style="color:#444;">{!! $section->content !!}</div>
                        @php
                            $images = $section->images->all();
                            $chunks = array_chunk($images, 3);
                        @endphp
                        <div id="sectionCarousel{{ $section->id }}" class="carousel slide mb-2"
                            data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($chunks as $idx => $chunk)
                                    <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}">
                                        <div class="row g-2">
                                            @foreach ($chunk as $img)
                                                <div class="col-4">
                                                    <img src="{{ asset($img->image_path) }}"
                                                        class="d-block w-100 rounded"
                                                        style="height: 180px; object-fit: cover;" alt="Ảnh section">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if (count($chunks) > 1)
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#sectionCarousel{{ $section->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#sectionCarousel{{ $section->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            @endif
                        </div>
                        @if ($section->embed_type && $section->embed_url)
                            <div class="section-embed mt-2">
                                @if ($section->embed_type == 'youtube')
                                    {!! $section->embed_url !!}
                                @elseif($section->embed_type == 'tiktok')
                                    {!! $section->embed_url !!}
                                @elseif($section->embed_type == 'map')
                                    {!! $section->embed_url !!}
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach

                <!-- Menu Highlights -->
                {{-- <div class="menu-highlights">
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
            </div> --}}

                <!-- Rating & Reviews -->
                @auth
                    <div class="rating-section" id="ratingSection">
                        <h2>Đánh giá và nhận xét</h2>

                        <!-- Review Form -->
                        <div class="write-review">
                            <h3>Viết đánh giá của bạn</h3>
                            <form action="{{ route('reviews.store') }}" method="POST" id="reviewForm">
                                @csrf
                                <div class="form-group my-3">
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="hidden" name="type" value="{{ $post->type }}">
                                    <label>Đánh giá chất lượng</label>
                                    <div class="rating">
                                        <input type="radio" name="food_rating" value="5" id="food-5"
                                            {{ old('food_rating') == 5 ? 'checked' : '' }}><label for="food-5"><i
                                                class="fas fa-star"></i></label>
                                        <input type="radio" name="food_rating" value="4" id="food-4"
                                            {{ old('food_rating') == 4 ? 'checked' : '' }}><label for="food-4"><i
                                                class="fas fa-star"></i></label>
                                        <input type="radio" name="food_rating" value="3" id="food-3"
                                            {{ old('food_rating') == 3 ? 'checked' : '' }}><label for="food-3"><i
                                                class="fas fa-star"></i></label>
                                        <input type="radio" name="food_rating" value="2" id="food-2"
                                            {{ old('food_rating') == 2 ? 'checked' : '' }}><label for="food-2"><i
                                                class="fas fa-star"></i></label>
                                        <input type="radio" name="food_rating" value="1" id="food-1"
                                            {{ old('food_rating') == 1 ? 'checked' : '' }}><label for="food-1"><i
                                                class="fas fa-star"></i></label>
                                    </div>
                                    <div class="error-message" id="foodRatingError"></div>
                                </div>

                                <div class="form-group my-3">
                                    <label>Mức độ hài lòng</label>
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
                                    <label for="comment">Nhận xét của bạn</label>
                                    <textarea name="comment" id="comment" rows="4" class="form-control"
                                        placeholder="Chia sẻ trải nghiệm của bạn...">{{ old('comment') }}</textarea>
                                    <div class="error-message" id="commentError"></div>
                                </div>

                                <div class="error-message" id="generalError"></div>

                                <button type="submit" class="submit-review-green">Gửi đánh giá</button>
                            </form>
                        </div>

                        <!-- Reviews List -->
                        <div class="reviews-list mt-3">
                            @foreach ($post->reviews()->with('user')->latest()->get() as $review)
                                <div class="review-item">
                                    <div class="review-header">
                                        <img src="{{ $review->user->avatar ? asset('image/avatars/' . basename($review->user->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}"
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
                @endauth

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

        <!-- Share Modal -->
        <div class="modal" id="shareModal">
            <div class="share-modal-content">
                <div class="share-header">
                    <h3>Chia sẻ</h3>
                    <button class="close-button" onclick="closeShareModal()">&times;</button>
                </div>
                <div class="share-body">
                    <div class="social-buttons">
                        <a href="#" class="share-social-btn facebook" onclick="shareToFacebook()">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="#" class="share-social-btn twitter" onclick="shareToTwitter()">
                            <i class="fab fa-twitter"></i>
                            <span>Twitter</span>
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

        <!-- Include modal chủ sở hữu từ partial view -->
        @include('partials.owner-modal', ['post' => $post])
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

            // Những hàm handleSave và toggleSave đã được chuyển sang file trustlist-handler.js
        });

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

        function shareToFacebook() {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
        }

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
        //     window.open(`https://www.facebook.com/dialog/send?app_id=YOUR_APP_ID&link=${url}&redirect_uri=${url}`, '_blank');
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

        // Đóng modal khi click bên ngoài
        document.getElementById('shareModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeShareModal();
            }
        });

        // Hàm để xóa chủ sở hữu
        function removeOwner(e) {
            e.preventDefault();
            const selectedOwner = document.getElementById('selectedOwner');
            selectedOwner.innerHTML = '<div class="text-muted">Chưa có chủ sở hữu được chọn</div>';
            document.getElementById('ownerIdInput').value = '';
        }

        // Thêm sự kiện remove-owner nếu đã có chủ sở hữu
        const removeBtn = document.querySelector('.remove-owner');
        if (removeBtn) {
            removeBtn.addEventListener('click', removeOwner);
        }
    </script>
    <!-- Load owner search JavaScript -->
    {{-- <script src="{{ asset('js/owner-search.js') }}"></script> --}}
    <script src="{{ asset('js/reviews.js') }}"></script>
    <script src="{{ asset('js/trustlist-handler.js') }}"></script>
@endpush
