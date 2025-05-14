<input type="hidden" id="page" value="{{ $name ?? 0 }}">
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
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script>
    let page = document.getElementById("page").value;
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
            if (modalImage) {
                modalImage.src = postImages[currentImageIndex];
                updateNavigationButtons();
            }
        }
    }

    function nextImage() {
        if (currentImageIndex < totalImages - 1) {
            currentImageIndex++;
            const modalImage = document.getElementById("modalImage");
            if (modalImage) {
                modalImage.src = postImages[currentImageIndex];
                updateNavigationButtons();
            }
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

        // Add CSRF token to all AJAX requests
        const csrfToken = '{{ csrf_token() }}';

        // Like functionality
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (!this.classList.contains('processing')) {
                    this.classList.add('processing');

                    const postId = this.dataset.postId;
                    const isLiked = this.dataset.liked === 'true';
                    const icon = this.querySelector('.like-icon');
                    const countSpan = this.querySelector('.like-count');
                    const currentCount = parseInt(countSpan.textContent);

                    const url = `/posts/${postId}/like`;
                    const method = isLiked ? 'DELETE' : 'POST';

                    fetch(url, {
                            method: method,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Update UI
                            if (isLiked) {
                                icon.setAttribute('fill', 'none');
                                countSpan.textContent = currentCount - 1;
                                this.dataset.liked = 'false';
                            } else {
                                icon.setAttribute('fill', 'white');
                                countSpan.textContent = currentCount + 1;
                                this.dataset.liked = 'true';
                            }

                            // Add animation class
                            icon.classList.add('like-animation');
                            setTimeout(() => {
                                icon.classList.remove('like-animation');
                            }, 300);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Có lỗi xảy ra khi thực hiện thao tác này', 'error');
                        })
                        .finally(() => {
                            this.classList.remove('processing');
                        });
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (page == "congdong") {
            let currentPage = 1;
            let isLoading = false;
            const postsContainer = document.querySelector('.posts-container');
            const loadMoreBtn = document.querySelector('.load-more-posts');

            // Show load more button if there are posts
            if (document.querySelectorAll('.card[data-post-id]').length > 0) {
                loadMoreBtn.style.display = 'block';
            }

            // Load more posts
            if (loadMoreBtn) {
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
                                postsContainer.insertBefore(postElement, loadMoreBtn
                                    .parentElement);
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
            }

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

    function deleteImage(imageId, button) {
        if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
            fetch(`/posts/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Remove the image container
                        button.closest('.col-4').remove();
                    } else {
                        alert('Có lỗi xảy ra khi xóa ảnh');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi xóa ảnh');
                });
        }
    }

    function copyPostLink(postId) {
        const postUrl = `${window.location.origin}/communities/${postId}`;
        navigator.clipboard.writeText(postUrl).then(() => {
            alert('Đã sao chép liên kết vào clipboard');
        }).catch(err => {
            console.error('Failed to copy text: ', err);
        });
    }

    function sharePostAsImage(el, postId) {
        const postCard = el.closest('[data-post-id]');
        if (!postCard) {
            alert('Không tìm thấy bài viết để chụp ảnh!');
            return;
        }

        // Clone node và điều chỉnh style
        const clone = postCard.cloneNode(true);
        adjustPostCardForCapture(clone);

        // Ẩn clone khỏi màn hình thật, nhưng vẫn render được
        clone.style.position = 'fixed';
        clone.style.left = '-99999px';
        clone.style.top = '0';
        clone.style.zIndex = '-1';
        clone.style.width = postCard.offsetWidth + 'px';
        document.body.appendChild(clone);

        // Ẩn dropdown khi chụp (trên giao diện thật)
        const dropdownMenu = el.closest('.dropdown-menu');
        if (dropdownMenu) dropdownMenu.style.display = 'none';

        // Sử dụng màu nền cụ thể
        const bodyBgColor = '#faf6e9';

        html2canvas(clone, {
            backgroundColor: bodyBgColor,
            useCORS: true,
            scale: 2
        }).then(canvas => {
            canvas.toBlob(blob => {
                if (navigator.clipboard && window.ClipboardItem) {
                    const item = new ClipboardItem({
                        'image/png': blob
                    });
                    navigator.clipboard.write([item]).then(() => {
                        alert(
                            'Đã sao chép ảnh vào clipboard! Bạn có thể dán (Ctrl+V) vào Facebook, Zalo, Messenger...'
                        );
                    }, () => {
                        alert('Không thể sao chép ảnh. Trình duyệt của bạn không hỗ trợ.');
                    });
                } else {
                    alert('Trình duyệt của bạn không hỗ trợ sao chép ảnh vào clipboard.');
                }
            });
        }).finally(() => {
            // Hiện lại dropdown thật
            if (dropdownMenu) setTimeout(() => {
                dropdownMenu.style.display = '';
            }, 300);
            // Xóa clone khỏi DOM
            document.body.removeChild(clone);
        });
    }

    async function sharePost(postId, type = 'link') {
        const postUrl = `${window.location.origin}/communities/${postId}`;
        const title = 'Chia sẻ từ Vangxa';
        const text = 'Xem bài viết này trên Vangxa';

        // Nếu là chia sẻ dạng hình
        if (type === 'image') {
            const postCard = document.querySelector(`[data-post-id="${postId}"]`);
            if (!postCard) {
                alert('Không tìm thấy bài viết để chia sẻ!');
                return;
            }

            try {
                const clone = postCard.cloneNode(true);
                adjustPostCardForCapture(clone);

                // Ẩn clone khỏi màn hình thật, nhưng vẫn render được
                clone.style.position = 'fixed';
                clone.style.left = '-99999px';
                clone.style.top = '0';
                clone.style.zIndex = '-1';
                clone.style.width = postCard.offsetWidth + 'px';
                document.body.appendChild(clone);

                // Sử dụng màu nền cụ thể
                const bodyBgColor = '#faf6e9';

                const canvas = await html2canvas(clone, {
                    backgroundColor: bodyBgColor,
                    useCORS: true,
                    scale: 2
                });

                // Chuyển canvas thành blob
                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));
                const file = new File([blob], `vangxa_post_${postId}.png`, {
                    type: 'image/png'
                });

                // Xóa clone khỏi DOM
                document.body.removeChild(clone);

                // Kiểm tra hỗ trợ Web Share API với files
                if (navigator.canShare && navigator.canShare({
                        files: [file]
                    })) {
                    await navigator.share({
                        files: [file],
                        title: title,
                        text: text,
                        url: postUrl
                    });
                } else {
                    // Fallback nếu không hỗ trợ chia sẻ file
                    await navigator.share({
                        title: title,
                        text: text,
                        url: postUrl
                    });
                }
            } catch (error) {
                console.error('Error sharing:', error);
                if (error.name === 'AbortError') {
                    // Người dùng hủy chia sẻ
                    return;
                }
                alert('Không thể chia sẻ bài viết. Vui lòng thử lại sau.');
            }
        } else {
            // Chia sẻ link thông thường
            try {
                await navigator.share({
                    title: title,
                    text: text,
                    url: postUrl
                });
            } catch (error) {
                console.error('Error sharing:', error);
                if (error.name === 'AbortError') {
                    // Người dùng hủy chia sẻ
                    return;
                }
                // Fallback to copy link if sharing fails
                copyPostLink(postId);
            }
        }
    }

    function adjustPostCardForCapture(clone) {
        // Ẩn tất cả dropdown menu trong bản clone
        const allDropdowns = clone.querySelectorAll('.dropdown-menu');
        allDropdowns.forEach(menu => menu.style.display = 'none');

        // Sử dụng màu nền cụ thể thay vì lấy từ body
        const bodyBgColor = '#faf6e9';

        // Sử dụng màu nền thay vì background image
        const cloneBg = clone.classList.contains('post-card-bg') ? clone : clone.querySelector('.post-card-bg');
        if (cloneBg) {
            cloneBg.style.backgroundColor = bodyBgColor;
            cloneBg.style.backgroundImage = 'none'; // Xóa background image nếu có
            cloneBg.style.padding = '12px'; // Giảm padding tổng thể
            cloneBg.style.borderRadius = '8px'; // Thêm bo tròn
        }

        // Thêm màu nền cho toàn bộ post card nếu cần
        clone.style.backgroundColor = bodyBgColor;
        
        // Điều chỉnh header và user info
        const userInfo = clone.querySelector('.d-flex.align-items-center.mb-3');
        if (userInfo) {
            userInfo.style.marginBottom = '4px !important'; // Giảm margin bottom
            userInfo.style.paddingBottom = '0';
            // Điều chỉnh avatar nếu có
            const avatar = userInfo.querySelector('img');
            if (avatar) {
                avatar.style.width = '32px';
                avatar.style.height = '32px';
            }
        }

        // Điều chỉnh description
        const desc = clone.querySelector('.description-post');
        if (desc) {
            desc.classList.remove('description-post');
            desc.style.display = 'block';
            desc.style.webkitLineClamp = '';
            desc.style.overflow = 'visible';
            desc.style['-webkit-box-orient'] = '';
            desc.style['-webkit-line-clamp'] = '';
            desc.style.maxHeight = 'none';
            desc.style.height = 'auto';
            desc.style.whiteSpace = 'pre-line';
            desc.style.marginBottom = '8px';
            desc.style.marginTop = '0';
            desc.style.fontSize = '14px';
            desc.style.lineHeight = '1.4';
            desc.style.padding = '0';
        }

        // Điều chỉnh khoảng cách của images
        const images = clone.querySelector('.post-images');
        if (images) {
            images.style.margin = '0';
            images.style.marginBottom = '8px';
        }

        // Căn chỉnh phần tương tác (like, comment, share)
        const interactionContainer = clone.querySelector('.d-flex.justify-content-between');
        if (interactionContainer) {
            interactionContainer.style.display = 'flex';
            interactionContainer.style.alignItems = 'center';
            interactionContainer.style.justifyContent = 'space-between';
            interactionContainer.style.marginTop = '4px';

            // Container bên trái (like và comment)
            const leftContainer = interactionContainer.querySelector('.d-flex.gap-4');
            if (leftContainer) {
                leftContainer.style.display = 'flex';
                leftContainer.style.alignItems = 'center';
                leftContainer.style.gap = '20px';

                // Điều chỉnh các nút like và comment
                const buttons = leftContainer.querySelectorAll('button');
                buttons.forEach(btn => {
                    btn.style.cssText = `
                        display: inline-flex !important;
                        align-items: center !important;
                        gap: 4px !important;
                        padding: 0 !important;
                        margin: 0 !important;
                        height: 20px !important;
                    `;

                    // Điều chỉnh icon
                    const icon = btn.querySelector('svg, i');
                    if (icon) {
                        icon.style.cssText = `
                            width: 20px !important;
                            height: 20px !important;
                            vertical-align: middle !important;
                            margin: 0 !important;
                            display: inline-block !important;
                        `;
                    }

                    // Điều chỉnh số liệu
                    const count = btn.querySelector('.like-count, span');
                    if (count) {
                        count.style.cssText = `
                            font-size: 14px !important;
                            line-height: 20px !important;
                            height: 20px !important;
                            margin: 0 !important;
                            padding: 0 !important;
                            display: inline-flex !important;
                            align-items: center !important;
                        `;
                    }
                });
            }

            // Điều chỉnh nút share bên phải
            const shareButton = interactionContainer.querySelector('button:last-child');
            if (shareButton) {
                shareButton.style.cssText = `
                    display: inline-flex !important;
                    align-items: center !important;
                    gap: 4px !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    height: 20px !important;
                `;
            }
        }

        return clone;
    }

    function downloadPostAsImage(el, postId) {
        const postCard = el.closest('[data-post-id]');
        if (!postCard) {
            alert('Không tìm thấy bài viết để tải ảnh!');
            return;
        }

        // Clone node và điều chỉnh style
        const clone = postCard.cloneNode(true);
        adjustPostCardForCapture(clone);

        // Ẩn clone khỏi màn hình thật, nhưng vẫn render được
        clone.style.position = 'fixed';
        clone.style.left = '-99999px';
        clone.style.top = '0';
        clone.style.zIndex = '-1';
        clone.style.width = postCard.offsetWidth + 'px';
        document.body.appendChild(clone);

        // Ẩn dropdown khi chụp (trên giao diện thật)
        const dropdownMenu = el.closest('.dropdown-menu');
        if (dropdownMenu) dropdownMenu.style.display = 'none';

        // Sử dụng màu nền cụ thể
        const bodyBgColor = '#faf6e9';

        html2canvas(clone, {
            backgroundColor: bodyBgColor,
            useCORS: true,
            scale: 2
        }).then(canvas => {
            // Tạo link tải xuống
            const link = document.createElement('a');
            link.download = `post_${postId}_${new Date().getTime()}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        }).finally(() => {
            // Hiện lại dropdown thật
            if (dropdownMenu) setTimeout(() => {
                dropdownMenu.style.display = '';
            }, 300);
            // Xóa clone khỏi DOM
            document.body.removeChild(clone);
        });
    }
</script>
