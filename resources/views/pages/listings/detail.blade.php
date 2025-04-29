@extends('layouts.main')

@section('content')
    <div class="container-custom detail-dining-page">
        <div class="container-custom">
            <div class="detail-page__gallery">
                <div class="detail-page__main-image" onclick="openPreview(0)">
                    <img src="{{ $post->images->isNotEmpty() ? asset($post->images->first()->image_path) : asset('default-image.jpg') }}"
                        alt="{{ $post->title }}">
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
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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

            <div class="detail-content">
                <div class="content-main">
                    <!-- Restaurant Title -->
                    <div class="detail-header">
                        <h1 class="detail-title">{{ $post->title }}</h1>
                        <div class="detail-badges">
                            <div class="action-buttons">
                                @auth
                                    <form action="{{ route('trustlist.toggle', ['id' => $post->id]) }}" method="POST"
                                        class="trustlist-form" data-post-id="{{ $post->id }}">
                                        @csrf
                                        <button type="button" class="trustlist-btn" data-post-id="{{ $post->id }}"
                                            data-saved="{{ Auth::check() && $post->isSaved ? 'true' : 'false' }}"
                                            data-authenticated="{{ Auth::check() ? 'true' : 'false' }}"
                                            onclick="event.preventDefault(); handleSave(this);">
                                            <i
                                                class="{{ Auth::check() && $post->isSaved ? 'fas' : 'far' }} fa-bookmark {{ Auth::check() && $post->isSaved ? 'text-primary' : '' }}"></i>
                                            <span class="saves-count">{{ $post->saves_count ?? 0 }}</span>
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

                    <div class="detail-description">
                        <h2>Giới thiệu</h2>
                        <p>{!! $post->description !!}</p>
                    </div>
                </div>
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

                                <button type="submit" class="submit-review-green">Gửi đánh giá</button>
                            </form>
                        </div>

                        <!-- Reviews List -->
                        <div class="reviews-list mt-3">
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
                @endauth
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

    <!-- Include partial view modal chủ sở hữu -->
    @include('partials.owner-modal', ['post' => $post])

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
        window.handleSave = function(button) {
            const isAuthenticated = button.dataset.authenticated === 'true';
            const postId = button.dataset.postId;

            if (!isAuthenticated) {
                showToast('Vui lòng đăng nhập để thêm vào yêu thích', 'warning');
                return false;
            }

            toggleSave(button, postId);
        };

        // Function to toggle trustlist status
        window.toggleSave = function(button, postId) {
            button.disabled = true; // Prevent rapid clicks
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/trustlist/${postId}`, {
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
                    const text = button.querySelector('.saves-count');
                    if (data.saved) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        icon.classList.add('text-primary');
                        button.classList.add('active');
                        button.setAttribute('data-saved', 'true');
                        button.title = 'Bỏ lưu';
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        icon.classList.remove('text-primary');
                        button.classList.remove('active');
                        button.setAttribute('data-saved', 'false');
                        button.title = 'Lưu';
                    }
                    if (text) {
                        text.textContent = data.savesCount;
                    }
                    showToast(data.message, data.saved ? 'success' : 'info');
                    document.querySelectorAll(`.trustlist-btn[data-post-id="${postId}"]`).forEach(btn => {
                        if (btn !== button) {
                            const btnIcon = btn.querySelector('i');
                            const btnText = btn.querySelector('.saves-count');
                            if (data.saved) {
                                btnIcon.classList.remove('far');
                                btnIcon.classList.add('fas');
                                btnIcon.classList.add('text-primary');
                                btn.classList.add('active');
                                btn.setAttribute('data-saved', 'true');
                                btn.title = 'Bỏ lưu';
                            } else {
                                btnIcon.classList.remove('fas');
                                btnIcon.classList.add('far');
                                btnIcon.classList.remove('text-primary');
                                btn.classList.remove('active');
                                btn.setAttribute('data-saved', 'false');
                                btn.title = 'Lưu';
                            }
                            if (btnText) {
                                btnText.textContent = data.savesCount;
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

    @push('scripts')
        <script src="{{ asset('js/owner-search.js') }}"></script>
        <script src="{{asset('js/reviews.js')}}"></script>
        <script>
            // JavaScript hiện tại của trang
        </script>
    @endpush
@endsection
