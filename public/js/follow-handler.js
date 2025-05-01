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
        followBtn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const action = this.getAttribute('data-action');

            // Gửi request đến server
            fetch(`/follow-toggle/${userId}`, {
                method: 'POST',
                headers: headers
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật UI
                    updateFollowButton(followBtn, data.isFollowing);

                    // Cập nhật số lượng người theo dõi
                    const followersCountEl = document.querySelector('.followers-count');
                    if (followersCountEl) {
                        followersCountEl.textContent = data.followersCount;
                    }

                    // Hiển thị thông báo
                    showNotification(data.message);
                } else {
                    showNotification(data.message || 'Đã xảy ra lỗi', 'error');
                }
            })
            .catch(error => {
                console.error('Follow toggle error:', error);
                showNotification('Đã xảy ra lỗi khi thực hiện thao tác', 'error');
            });
        });
    }

    /**
     * Cập nhật giao diện nút follow/unfollow
     *
     * @param {HTMLElement} button Nút follow/unfollow
     * @param {boolean} isFollowing Trạng thái theo dõi
     */
    function updateFollowButton(button, isFollowing) {
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
    }

    /**
     * Hiển thị thông báo
     *
     * @param {string} message Nội dung thông báo
     * @param {string} type Loại thông báo ('success' hoặc 'error')
     */
    function showNotification(message, type = 'success') {
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
            }
        }, 3000);
    }
});
