// Comment handler - create namespace to avoid variable conflicts
window.CommentHandler = window.CommentHandler || {};

document.addEventListener('DOMContentLoaded', function() {
    // Nếu không có user đăng nhập, không cần thiết lập các event
    const userId = document.body.dataset.userId;
    if (!userId) return;

    // Thiết lập lắng nghe sự kiện realtime
    window.CommentHandler.setupRealtimeListeners();
});

// Initialize properties in the namespace
window.CommentHandler.eventListenersRegistered = false;

/**
 * Thiết lập lắng nghe sự kiện realtime
 */
window.CommentHandler.setupRealtimeListeners = function() {
    // Kiểm tra xem đã đăng ký event listeners chưa
    if (window.CommentHandler.eventListenersRegistered) {
        return;
    }
    
    // Đánh dấu đã đăng ký
    window.CommentHandler.eventListenersRegistered = true;
    
    // Lắng nghe sự kiện thêm comment
    if (window.Echo) {
        // Trên kênh public
        window.Echo.channel('comments')
            .listen('CommentEvent', (e) => {
                console.log('Nhận được sự kiện comment:', e);
                
                // Cập nhật UI nếu cần thiết, ví dụ: highlight comment mới
                if (window.location.pathname.includes('/posts/' + e.post_id)) {
                    window.CommentHandler.highlightNewComment(e.comment_id);
                }
            });
    }
}

/**
 * Hàm highlight comment mới nếu người dùng đang ở trang đó
 */
window.CommentHandler.highlightNewComment = function(commentId) {
    const commentElement = document.getElementById('comment-' + commentId);
    if (commentElement) {
        commentElement.classList.add('highlight-new-comment');
        setTimeout(() => {
            commentElement.classList.remove('highlight-new-comment');
        }, 5000);
    }
}

/**
 * Hiển thị thông báo
 */
window.CommentHandler.showNotification = function(message, type = 'success') {
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
} 