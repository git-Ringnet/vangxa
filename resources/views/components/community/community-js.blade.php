<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 position-relative">
                <img src="" class="img-fluid" id="modalImage">
                <button class="btn btn-dark position-absolute top-50 start-0 translate-middle-y ms-3" id="prevImage">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn btn-dark position-absolute top-50 end-0 translate-middle-y me-3" id="nextImage">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    let currentPostId = null;
    let currentImageIndex = 0;
    let postImages = [];
    let totalImages = 0;

    function showImage(imageSrc, postId, imageIndex) {
        try {
            // Lưu postId và imageIndex
            currentPostId = postId;
            currentImageIndex = imageIndex;

            // Lấy phần tử chứa danh sách ảnh
            const postElement = document.querySelector(
                `.post-images[data-post-id="${postId}"]`
            );
            if (!postElement) {
                console.error(`Post element with ID ${postId} not found`);
                return;
            }

            // Lấy tổng số ảnh và danh sách ảnh
            totalImages = parseInt(postElement.dataset.totalImages) || 0;
            if (totalImages === 0) {
                console.error(`No images found for post ID ${postId}`);
                return;
            }

            postImages = JSON.parse(postElement.dataset.images).map(
                (path) => '{{ asset('') }}' + path
            );
            if (!postImages || postImages.length === 0) {
                console.error(`Failed to parse images for post ID ${postId}`);
                return;
            }

            // Xử lý trường hợp ảnh có dấu "+"
            if (imageIndex === 3 && totalImages > 4) {
                currentImageIndex = 3;
            }

            // Hiển thị ảnh trong modal
            const modalImage = document.getElementById("modalImage");
            if (!modalImage) {
                console.error("Modal image element not found");
                return;
            }
            modalImage.src = postImages[currentImageIndex];

            // Hiển thị modal
            const imageModal = new bootstrap.Modal(
                document.getElementById("imageModal")
            );
            imageModal.show();

            // Cập nhật nút điều hướng
            updateNavigationButtons();
        } catch (error) {
            console.error("Error in showImage:", error);
        }
    }

    function updateNavigationButtons() {
        const prevButton = document.getElementById("prevImage");
        const nextButton = document.getElementById("nextImage");

        if (!prevButton || !nextButton) {
            console.error("Navigation buttons not found");
            return;
        }

        // Hiển thị nút prev nếu không phải ảnh đầu tiên
        prevButton.style.display = currentImageIndex > 0 ? "block" : "none";

        // Hiển thị nút next nếu còn ảnh tiếp theo
        nextButton.style.display =
            currentImageIndex < totalImages - 1 ? "block" : "none";
    }

    function prevImage() {
        if (currentImageIndex > 0) {
            currentImageIndex--;
            const modalImage = document.getElementById("modalImage");
            modalImage.src = postImages[currentImageIndex];
            updateNavigationButtons();
        }
    }

    function nextImage() {
        if (currentImageIndex < totalImages - 1) {
            currentImageIndex++;
            const modalImage = document.getElementById("modalImage");
            modalImage.src = postImages[currentImageIndex];
            updateNavigationButtons();
        }
    }

    // Gắn sự kiện click cho nút prev/next
    document.addEventListener("DOMContentLoaded", () => {
        const prevButton = document.getElementById("prevImage");
        const nextButton = document.getElementById("nextImage");

        if (prevButton) {
            prevButton.addEventListener("click", prevImage);
        }
        if (nextButton) {
            nextButton.addEventListener("click", nextImage);
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle comment form (bình luận chính)
        document.querySelectorAll('.comment-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.dataset.postId;
                const form = document.getElementById(`comment-form-${postId}`);
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
                if (form.style.display === 'block') {
                    form.querySelector('input[name="content"]').focus();
                }
            });
        });

        // Toggle reply form (phản hồi)
        document.querySelectorAll('.reply-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.dataset.commentId;
                const form = document.getElementById(`reply-form-${commentId}`);
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
                if (form.style.display === 'block') {
                    form.querySelector('input[name="content"]').focus();
                }
            });
        });

        // Handle like button clicks
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.dataset.postId;
                const isLiked = this.dataset.liked === 'true';
                const icon = this.querySelector('i');
                const countSpan = this.querySelector('.like-count');
                const currentCount = parseInt(countSpan.textContent);

                // Toggle like status
                fetch(`/posts/${postId}/like`, {
                        method: isLiked ? 'DELETE' : 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update button state
                            this.dataset.liked = data.is_liked;
                            if (data.is_liked) {
                                icon.classList.remove('far');
                                icon.classList.add('fas', 'text-danger');
                            } else {
                                icon.classList.remove('fas', 'text-danger');
                                icon.classList.add('far');
                            }

                            // Update count
                            countSpan.textContent = data.count;
                        } else {
                            console.error(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        document.getElementById('prevImage').addEventListener('click', function() {
            if (currentImageIndex > 0) {
                currentImageIndex--;
                const modalImage = document.getElementById('modalImage');
                modalImage.src = postImages[currentImageIndex];

                // Cập nhật nút điều hướng
                const prevButton = document.getElementById('prevImage');
                const nextButton = document.getElementById('nextImage');
                const postElement = document.querySelector(
                    `.post-images[data-post-id="${currentPostId}"]`);
                const totalImages = parseInt(postElement.dataset.totalImages);

                prevButton.style.display = currentImageIndex > 0 ? 'block' : 'none';
                nextButton.style.display = currentImageIndex < totalImages - 1 ? 'block' : 'none';
            }
        });

        document.getElementById('nextImage').addEventListener('click', function() {
            const postElement = document.querySelector(`.post-images[data-post-id="${currentPostId}"]`);
            const totalImages = parseInt(postElement.dataset.totalImages);

            if (currentImageIndex < totalImages - 1) {
                currentImageIndex++;
                const modalImage = document.getElementById('modalImage');
                modalImage.src = postImages[currentImageIndex];

                // Cập nhật nút điều hướng
                const prevButton = document.getElementById('prevImage');
                const nextButton = document.getElementById('nextImage');

                prevButton.style.display = currentImageIndex > 0 ? 'block' : 'none';
                nextButton.style.display = currentImageIndex < totalImages - 1 ? 'block' : 'none';
            }
        });

        // Xử lý preview ảnh khi upload
        const imageInput = document.getElementById('images');
        const imagePreview = document.getElementById('image-preview');

        imageInput.addEventListener('change', function() {
            imagePreview.innerHTML = '';

            if (this.files) {
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.classList.add('rounded', 'cursor-pointer');
                        imagePreview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        let currentPage = 1;
        let isLoading = false;
        const postsContainer = document.querySelector('.posts-container');
        const loadMoreBtn = document.querySelector('.load-more-posts');

        // Show load more button if there are posts
        if (document.querySelectorAll('.card[data-post-id]').length > 0) {
            loadMoreBtn.style.display = 'block';
        }

        // Load more posts
        loadMoreBtn.addEventListener('click', function() {
            if (isLoading) return;
            isLoading = true;

            currentPage++;
            loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang tải...';

            fetch(`loadmore-posts?page=${currentPage}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.message);
                    }

                    data.posts.forEach(post => {
                        const postElement = createPostElement(post);
                        postsContainer.insertBefore(postElement, loadMoreBtn.parentElement);
                    });

                    if (!data.hasMore) {
                        loadMoreBtn.style.display = 'none';
                    } else {
                        loadMoreBtn.innerHTML =
                            '<i class="fas fa-spinner fa-spin me-2"></i>Tải thêm bài viết';
                    }
                })
                .catch(error => {
                    console.error('Error loading more posts:', error);
                    loadMoreBtn.innerHTML =
                        '<i class="fas fa-exclamation-circle me-2"></i>Lỗi khi tải bài viết';
                    // Reset button state after 3 seconds
                    setTimeout(() => {
                        loadMoreBtn.innerHTML =
                            '<i class="fas fa-spinner fa-spin me-2"></i>Tải thêm bài viết';
                    }, 3000);
                })
                .finally(() => {
                    isLoading = false;
                });
        });

        // Function to create post element
        function createPostElement(post) {
            const div = document.createElement('div');
            div.className = 'card shadow-sm mb-4';
            div.dataset.postId = post.id;

            let groupInfo = '';
            if (post.group) {
                groupInfo = `
                        <h5 class="mb-0">${post.group.name}</h5>
                        <div class="d-flex align-items-center gap-2">
                            <small>${post.user.name}</small>
                            <small class="d-block text-muted">${post.created_at}</small>
                        </div>
                    `;
            } else {
                groupInfo = `
                        <h5 class="mb-0">${post.user.name}</h5>
                        <small class="d-block text-muted">${post.created_at}</small>
                    `;
            }

            div.innerHTML = `
                    <div class="card-body">
                        <div class="border-bottom pb-2">
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    ${groupInfo}
                                </div>
                            </div>
                            <div class="post-content mb-3">
                                ${post.description}
                            </div>
                            <div class="d-flex gap-4 text-muted">
                                <button class="btn btn-link text-decoration-none p-0 like-btn" 
                                        data-post-id="${post.id}"
                                        data-liked="${post.likes.is_liked}">
                                    <i class="${post.likes.is_liked ? 'fas' : 'far'} fa-heart me-1 ${post.likes.is_liked ? 'text-danger' : ''}"></i>
                                    <span class="like-count">${post.likes.count}</span>
                                </button>
                                <button class="btn btn-link text-decoration-none p-0 comment-toggle" data-post-id="${post.id}">
                                    <i class="far fa-comment me-1"></i>
                                   ${post.comments.count}
                                </button>
                            </div>
                        </div>
                    </div>
                `;

            return div;
        }

        const swiper = new Swiper(".mySwiper", {
            slidesPerView: "auto",
            spaceBetween: 15,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            watchOverflow: true,
            breakpoints: {
                240: {
                    slidesPerView: 2,
                    spaceBetween: 8,
                },
                320: {
                    slidesPerView: 3,
                    spaceBetween: 8,
                },
                480: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 5, // Giảm từ 6 xuống 5 để có nhiều slide dư hơn
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 6, // Giảm từ 8 xuống 6
                    spaceBetween: 10,
                },
                1440: {
                    slidesPerView: 7, // Giảm từ 10 xuống 7
                    spaceBetween: 12,
                },
            }
        });
    });
</script>
