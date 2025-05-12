/**
 * Xử lý chức năng theo dõi/hủy theo dõi người dùng
 */
document.addEventListener('DOMContentLoaded', function() {
    // Tạo header cho AJAX request với CSRF token
    const headers = {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    };

    // Xử lý nút follow/unfollow
    const followBtn = document.querySelector('.follow-btn');
    if (followBtn) {
        console.log('Follow button found:', followBtn);
        console.log('Initial data-action:', followBtn.getAttribute('data-action'));
        
        followBtn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const action = this.getAttribute('data-action');
            console.log(`Follow button clicked. Action: ${action}, User ID: ${userId}`);

            // Gửi request đến server
            fetch(`/follow-toggle/${userId}`, {
                method: 'POST',
                headers: headers
            })
            .then(response => response.json())
            .then(data => {
                console.log('Follow toggle response:', data);
                
                if (data.success) {
                    // Cập nhật UI
                    updateFollowButton(followBtn, data.isFollowing);
                    console.log('Button updated. New state:', data.isFollowing ? 'following' : 'not following');

                    // Cập nhật số lượng người theo dõi
                    const followersCountEl = document.querySelector('.followers-count');
                    if (followersCountEl) {
                        followersCountEl.textContent = data.followersCount;
                        console.log('Updated followers count:', data.followersCount);
                    }

                    // Hiển thị thông báo
                    console.log('Showing notification:', data.message);
                    showNotification(data.message);
                } else {
                    console.error('Follow toggle failed:', data.message);
                    showNotification(data.message || 'Đã xảy ra lỗi', 'error');
                }
            })
            .catch(error => {
                console.error('Follow toggle error:', error);
                showNotification('Đã xảy ra lỗi khi thực hiện thao tác', 'error');
            });
        });
    } else {
        
    }

    /**
     * Cập nhật giao diện nút follow/unfollow
     *
     * @param {HTMLElement} button Nút follow/unfollow
     * @param {boolean} isFollowing Trạng thái theo dõi
     */
    function updateFollowButton(button, isFollowing) {
        console.log('Updating button to state:', isFollowing ? 'following' : 'not following');
        
        if (isFollowing) {
            button.classList.remove('btn-primary');
            button.classList.add('btn-secondary');
            button.querySelector('i').classList.remove('fa-user-plus');
            button.querySelector('i').classList.add('fa-user-minus');
            button.querySelector('.follow-text').textContent = 'Đang theo dõi';
            button.setAttribute('data-action', 'unfollow');
        } else {
            button.classList.remove('btn-secondary');
            button.classList.add('btn-primary');
            button.querySelector('i').classList.remove('fa-user-minus');
            button.querySelector('i').classList.add('fa-user-plus');
            button.querySelector('.follow-text').textContent = 'Theo dõi';
            button.setAttribute('data-action', 'follow');
        }
        
        console.log('Button updated. New data-action:', button.getAttribute('data-action'));
    }

    /**
     * Hiển thị thông báo
     *
     * @param {string} message Nội dung thông báo
     * @param {string} type Loại thông báo ('success' hoặc 'error')
     */
    function showNotification(message, type = 'success') {
        console.log(`Showing notification. Message: "${message}", Type: ${type}`);
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.body.appendChild(alertDiv);

        // Tự động đóng thông báo sau 3 giây
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
                console.log('Notification removed after timeout');
            }
        }, 3000);
    }
    
    // Check for direct showToast function
    if (typeof showToast === 'function') {
        // console.log('showToast function is available globally');
    } else {
        console.log('showToast function is NOT available globally');
    }
});
