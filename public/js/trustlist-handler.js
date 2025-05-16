// Trustlist handler
document.addEventListener('DOMContentLoaded', function() {
    // Nếu không có user đăng nhập, không cần thiết lập các event
    const userId = document.body.dataset.userId;
    if (!userId) return;

    // Thiết lập sự kiện click cho tất cả nút trustlist
    setupTrustlistButtons();

    // Thiết lập lắng nghe sự kiện realtime
    setupRealtimeListeners();
});

/**
 * Thiết lập sự kiện click cho các nút trustlist
 */
function setupTrustlistButtons() {
    document.querySelectorAll('.trustlist-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.trustlist-form');
            const postId = this.dataset.postId;
            toggleTrustlist(postId, this);
        });
    });
}

/**
 * Gọi API để thay đổi trạng thái trustlist
 */
function toggleTrustlist(postId, button) {
    button.disabled = true; // Ngăn click liên tục
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/trustlist/${postId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Cập nhật trạng thái button
            updateTrustlistButton(button, data.saved, data.saves_count);
            // Hiển thị thông báo
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Đã xảy ra lỗi, vui lòng thử lại sau.', 'error');
    })
    .finally(() => {
        button.disabled = false;
    });
}

// Biến để kiểm tra đã đăng ký event listeners chưa
let eventListenersRegistered = false;

/**
 * Thiết lập lắng nghe sự kiện realtime
 */
function setupRealtimeListeners() {
    // Kiểm tra xem đã đăng ký event listeners chưa
    if (eventListenersRegistered) {
        return;
    }
    
    // Đánh dấu đã đăng ký
    eventListenersRegistered = true;
    
    // Lắng nghe sự kiện thêm vào trustlist
    if (window.Echo) {
        // Trên kênh public
        window.Echo.channel('trustlist')
            .listen('TrustlistEvent', (e) => {
                console.log('Nhận được sự kiện trustlist:', e);
                
                // Cập nhật UI nếu cần thiết
            });
        
        // Trên kênh public
        window.Echo.channel('untrust')
            .listen('UntrustEvent', (e) => {
                console.log('Nhận được sự kiện untrust:', e);
                
                // Cập nhật UI nếu cần thiết
            });
    }
}

/**
 * Cập nhật trạng thái của button trustlist
 */
function updateTrustlistButton(button, isSaved, savesCount) {
    // Find the icon and text elements
    const icon = button.querySelector('i');
    
    if (isSaved) {
        button.classList.add('active');
        if (icon) {
            icon.classList.remove('far');
            icon.classList.add('fas');
        }
    } else {
        button.classList.remove('active');
        if (icon) {
            icon.classList.remove('fas');
            icon.classList.add('far');
        }
    }
    
    // Cập nhật số lượng trustlist nếu có element hiển thị
    const countElement = document.querySelector(`.trustlist-count[data-post-id="${button.dataset.postId}"]`);
    if (countElement) {
        countElement.textContent = savesCount;
    }
}

/**
 * Hiển thị thông báo
 */
function showNotification(message, type = 'success') {
    if (typeof window.showToast === 'function') {
        // Sử dụng hàm showToast global nếu có
        window.showToast(message, type);
    } else {
        // Triển khai một phiên bản đơn giản nếu không có hàm global
        const toast = document.createElement('div');
        toast.className = `toast toast-${type} show`;
        
        const toastContent = document.createElement('div');
        toastContent.className = 'toast-content';
        
        // Add icon based on type
        const icon = document.createElement('i');
        if (type === 'success') {
            icon.className = 'fas fa-check-circle';
        } else if (type === 'error') {
            icon.className = 'fas fa-exclamation-circle';
        } else if (type === 'warning') {
            icon.className = 'fas fa-exclamation-triangle';
        } else if (type === 'info') {
            icon.className = 'fas fa-info-circle';
        }
        toastContent.appendChild(icon);
        
        // Add message
        const messageSpan = document.createElement('span');
        messageSpan.textContent = message;
        toastContent.appendChild(messageSpan);
        
        toast.appendChild(toastContent);
        
        // Add to container
        const toastContainer = document.querySelector('.toast-container') || (() => {
            const container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
            return container;
        })();
        
        toastContainer.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }
    
    // Cập nhật số lượng thông báo chưa đọc
    updateNotificationCount();
}

/**
 * Cập nhật số lượng thông báo chưa đọc
 */
function updateNotificationCount() {
    const notificationCountElement = document.getElementById('notification-count');
    if (notificationCountElement) {
        const currentCount = parseInt(notificationCountElement.textContent || '0');
        notificationCountElement.textContent = currentCount + 1;
        notificationCountElement.style.display = 'inline-block';
    }
} 