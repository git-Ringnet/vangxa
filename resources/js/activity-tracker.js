/**
 * Activity Tracker JS
 * Theo dõi hoạt động người dùng và gửi dữ liệu đến server
 */

document.addEventListener('DOMContentLoaded', function() {
    // Danh sách các sự kiện cần theo dõi
    const events = ['mousemove', 'keydown', 'scroll', 'click'];
    
    // Thời gian delay giữa các lần ghi nhận hoạt động (ms)
    const ACTIVITY_DELAY = 5 * 60 * 1000; // 5 phút
    
    let lastActivity = Date.now();
    let activityTimeout;
    
    // Hàm xử lý sự kiện hoạt động
    function handleUserActivity() {
        const now = Date.now();
        
        // Chỉ gửi dữ liệu nếu đã qua thời gian delay
        if (now - lastActivity > ACTIVITY_DELAY) {
            recordActivity();
            lastActivity = now;
        }
        
        // Reset timeout
        clearTimeout(activityTimeout);
        activityTimeout = setTimeout(recordActivity, ACTIVITY_DELAY);
    }
    
    // Hàm gửi dữ liệu hoạt động lên server
    function recordActivity() {
        // Chỉ gửi nếu người dùng đã đăng nhập
        if (document.body.dataset.auth === 'true') {
            fetch('/analytics/record-activity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            }).catch(error => {
                console.error('Error recording user activity:', error);
            });
        }
    }
    
    // Đăng ký các sự kiện
    events.forEach(event => {
        document.addEventListener(event, handleUserActivity, { passive: true });
    });
    
    // Ghi nhận hoạt động khi trang được tải
    recordActivity();
    
    // Ghi nhận hoạt động khi người dùng rời khỏi trang
    window.addEventListener('beforeunload', recordActivity);
});
