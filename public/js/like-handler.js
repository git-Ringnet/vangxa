document.addEventListener('DOMContentLoaded', function() {
    // Lắng nghe các nút like trong toàn bộ trang
    const likeButtons = document.querySelectorAll('.like-btn');
    console.log('Like Handler initialized, found buttons:', likeButtons.length);
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Ngăn chặn nhiều lần click liên tiếp
            if (button.classList.contains('processing')) {
                return;
            }
            
            // Thêm class processing để ngăn nhiều lần click
            button.classList.add('processing');
            
            const postId = this.getAttribute('data-post-id');
            const isLiked = this.getAttribute('data-liked') === 'true';
            
            console.log('Like button clicked:', { postId, isLiked });
            
            // Tạo URL API dựa trên trạng thái hiện tại
            const url = isLiked 
                ? `/unlike/${postId}` 
                : `/like/${postId}`;
            
            // Gửi yêu cầu API
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                console.log('API Response:', data);
                // Cập nhật UI dựa trên kết quả
                if (data.success) {
                    updateLikeButton(button, !isLiked, data.likes_count);
                    
                    // Hiển thị thông báo tùy chọn
                    if (data.message) {
                        showNotification(data.message, 'success');
                    }
                } else {
                    showNotification(data.message || 'Đã xảy ra lỗi', 'error');
                }
            })
            .catch(error => {
                console.error('Lỗi khi thực hiện like/unlike:', error);
                showNotification('Đã xảy ra lỗi khi xử lý yêu cầu', 'error');
            })
            .finally(() => {
                // Loại bỏ trạng thái processing
                button.classList.remove('processing');
            });
        });
    });
    
    // Lắng nghe sự kiện realtime cho like/unlike thông qua Laravel Echo
    // Chỉ lắng nghe kênh private để tránh trùng lặp thông báo
    const currentUserId = document.body.getAttribute('data-user-id');
    if (typeof window.Echo !== 'undefined' && currentUserId) {
        console.log('Echo is available, setting up private channel listener for user:', currentUserId);
        
        // Lắng nghe trên kênh private của user hiện tại
        window.Echo.private(`user.${currentUserId}`)
            .listen('.like.created', (e) => {
                console.log('Received LikeEvent in private channel:', e);
                updateNotificationCount();
            })
            .listen('.like.deleted', (e) => {
                console.log('Received UnlikeEvent in private channel:', e);
                updateNotificationCount();
            });
    } else {
        console.warn('Echo is not defined or user is not logged in - real-time updates will not work');
    }
    
    // Hàm cập nhật UI của nút like
    function updateLikeButton(button, isLiked, likesCount) {
        console.log('Updating like button:', { isLiked, likesCount });
        // Cập nhật trạng thái data-liked
        button.setAttribute('data-liked', isLiked.toString());
        
        // Tìm icon và số lượng like trong button
        const likeIcon = button.querySelector('.like-icon');
        const countElement = button.querySelector('.like-count');
        
        // Cập nhật UI icon
        if (isLiked) {
            likeIcon.setAttribute('fill', 'white');
            likeIcon.classList.add('like-animation');
            setTimeout(() => {
                likeIcon.classList.remove('like-animation');
            }, 300);
        } else {
            likeIcon.setAttribute('fill', 'none');
        }
        
        // Cập nhật số lượng like
        if (countElement) {
            countElement.textContent = likesCount;
        }
    }
    
    // Hàm hiển thị thông báo
    function showNotification(message, type = 'success') {
        console.log('Showing notification:', message, type);
        // Kiểm tra nếu hàm này đã tồn tại trong global scope
        if (typeof window.showToast === 'function') {
            window.showToast(message, type);
        } else {
            // Tạo toast notification nếu chưa có hàm global
            const toastContainer = document.querySelector('.toast-container') || (() => {
                const container = document.createElement('div');
                container.className = 'toast-container';
                document.body.appendChild(container);
                return container;
            })();
            
            const toast = document.createElement('div');
            toast.className = `toast toast-${type} show`;
            toast.innerHTML = `
                <div class="toast-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    <span>${message}</span>
                </div>
                <button class="toast-close"><i class="fas fa-times"></i></button>
            `;
            
            toastContainer.appendChild(toast);
            
            // Xử lý đóng toast
            const closeBtn = toast.querySelector('.toast-close');
            closeBtn.addEventListener('click', () => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            });
            
            // Tự động đóng sau 60 giây
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 60000);
        }
    }
    
    // Hàm cập nhật số lượng thông báo
    function updateNotificationCount() {
        const notificationCountElement = document.querySelector('.notification-count');
        if (notificationCountElement) {
            console.log('Updating notification count');
            fetch('/notifications/count', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Notification count:', data);
                if (data.count > 0) {
                    notificationCountElement.textContent = data.count;
                    notificationCountElement.style.display = 'flex';
                } else {
                    notificationCountElement.textContent = '';
                    notificationCountElement.style.display = 'none';
                }
            })
            .catch(error => console.error('Lỗi khi cập nhật số thông báo:', error));
        }
    }
}); 