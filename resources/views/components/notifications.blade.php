@props(['notifications' => []])
<div x-data="notificationBell" class="relative">
    <!-- Chuông thông báo -->
    <button @click="toggleDropdown" class="relative focus:outline-none">
        <div class="d-flex">
            <svg class="w-6 h-6 text-gray-600 hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                </path>
            </svg>
            <span class="pl-3">Thông báo</span>
        </div>
        <!-- Đếm số lượng thông báo chưa đọc -->
        <span x-show="unreadCount > 0"
            class="absolute -top-2 left-3 bg-red-500 text-white rounded-full px-1.5 py-0.5 text-xs">
            <span x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
        </span>
    </button>

    <!-- Dropdown thông báo -->
    <div x-show="isOpen" @click.away="isOpen = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute left-0 mt-2 w-80 max-h-96 overflow-y-auto bg-white rounded-md shadow-lg py-1 z-50">
        <div class="px-4 py-2 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-700">Thông báo</h3>
            <!-- Nút đánh dấu tất cả là đã đọc -->
            <button @click="markAllAsRead" class="text-sm text-blue-500 hover:text-blue-700 focus:outline-none">
                Đánh dấu đã đọc
            </button>
        </div>

        <!-- Danh sách thông báo -->
        <template x-if="notifications.length === 0">
            <div class="px-4 py-3 text-sm text-gray-500 text-center">
                Không có thông báo nào
            </div>
        </template>

        <template x-for="notification in notifications" :key="notification.id">
            <div @click="openNotification(notification)" :class="{ 'bg-blue-50': !notification.read_at }"
                class="px-4 py-3 hover:bg-gray-100 cursor-pointer border-b border-gray-100">
                <div class="flex items-start">
                    <!-- Icon tùy theo loại thông báo -->
                    <div class="mr-3">
                        <template x-if="notification.type === 'follow'">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                        </template>
                        <template x-if="notification.type === 'like'">
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                        </template>
                        <template x-if="notification.type === 'unlike'">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </template>
                        <template x-if="notification.type === 'trustlist'">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/>
                            </svg>
                        </template>
                        <template x-if="notification.type === 'untrust'">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </template>
                        <template x-if="notification.type === 'comment'">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </template>
                        <template
                            x-if="notification.type !== 'follow' && notification.type !== 'like' && notification.type !== 'unlike' && notification.type !== 'trustlist' && notification.type !== 'untrust'"
                        >
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </template>
                    </div>
                    <!-- Nội dung thông báo -->
                    <div class="flex-1">
                        <p class="text-sm text-gray-800" x-text="notification.message"></p>
                        <p class="text-xs text-gray-500 mt-1" x-text="notification.created_at"></p>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Đảm bảo Pusher đã được khởi tạo từ bootstrap.js
        if (typeof window.Echo === 'undefined') {
            console.error('Echo không được định nghĩa. Hãy kiểm tra bootstrap.js');
            return;
        }
    });

    document.addEventListener('alpine:init', () => {
        Alpine.data('notificationBell', () => ({
            isOpen: false,
            notifications: [],
            unreadCount: 0,
            currentUserId: {{ auth()->id() ?? 'null' }},

            init() {
                if (this.currentUserId) {
                    this.fetchNotifications();

                    // Lắng nghe trên kênh private của user hiện tại
                    window.Echo.private(`user.${this.currentUserId}`)
                        .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated',
                            (notification) => {
                                console.log('Notification system event received:', notification);
                                this.handleNewNotification(notification);
                            })
                        .listen('FollowEventReverb', (e) => {
                            console.log('Private FollowEventReverb received:', e);
                            this.handleNewNotification(e);
                        })
                        .listen('UnfollowEvent', (e) => {
                            console.log('Private UnfollowEvent received:', e);
                            this.handleNewNotification(e);
                        })
                        .listen('.like.created', (e) => {
                            console.log('Private LikeEvent received:', e);
                            this.handleNewNotification({
                                id: `like-${Date.now()}`,
                                message: `${e.liker_name} đã thích bài viết của bạn`,
                                type: 'like',
                                link: e.link || `/posts/${e.post_id}`,
                                created_at: 'Vừa xong',
                                read_at: null
                            });
                        })
                        .listen('.like.deleted', (e) => {
                            console.log('Private UnlikeEvent received:', e);
                            this.handleNewNotification({
                                id: `unlike-${Date.now()}`,
                                message: `${e.unliker_name} đã bỏ thích bài viết của bạn`,
                                type: 'unlike',
                                link: e.link || `/posts/${e.post_id}`,
                                created_at: 'Vừa xong',
                                read_at: null
                            });
                        })
                        .listen('.trustlist.created', (e) => {
                            console.log('Private TrustlistEvent received:', e);
                            this.handleNewNotification({
                                id: `trustlist-${Date.now()}`,
                                message: `${e.user_name} đã thêm bài viết của bạn vào danh sách tin cậy`,
                                type: 'trustlist',
                                link: e.link || `/posts/${e.post_id}`,
                                created_at: 'Vừa xong',
                                read_at: null
                            });
                        })
                        .listen('.untrust.created', (e) => {
                            console.log('Private UntrustEvent received:', e);
                            this.handleNewNotification({
                                id: `untrust-${Date.now()}`,
                                message: `${e.user_name} đã xóa bài viết của bạn khỏi danh sách tin cậy`,
                                type: 'untrust',
                                link: e.link || `/posts/${e.post_id}`,
                                created_at: 'Vừa xong',
                                read_at: null
                            });
                        })
                        .listen('.comment.created', (e) => {
                            console.log('Private CommentEvent received:', e);
                            this.handleNewNotification({
                                id: `comment-${Date.now()}`,
                                message: `${e.user_name} đã bình luận bài viết của bạn`,
                                type: 'comment',
                                link: e.link || `/posts/${e.post_id}#comment-${e.comment_id}`,
                                created_at: 'Vừa xong',
                                read_at: null
                            });
                        });
                }
            },

            // Xử lý thông báo mới
            handleNewNotification(notification) {
                // Format dữ liệu nếu cần thiết
                let formattedNotification = {
                    id: notification.id || `temp-${Date.now()}`,
                    message: notification.message,
                    type: notification.type || 'general',
                    link: notification.link,
                    created_at: 'Vừa xong',
                    read_at: null
                };

                // Thêm vào đầu danh sách
                this.notifications.unshift(formattedNotification);
                this.unreadCount++;

                // Hiển thị toast thông báo với kiểu phù hợp
                if (typeof showToast === 'function') {
                    // Xác định kiểu thông báo dựa vào nội dung
                    let toastType = 'info';
                    if (formattedNotification.message.includes('đã bắt đầu theo dõi')) {
                        toastType = 'success';
                    } else if (formattedNotification.message.includes('đã hủy theo dõi')) {
                        toastType = 'info';
                    } else if (formattedNotification.message.includes('đã thích')) {
                        toastType = 'success';
                    } else if (formattedNotification.message.includes('đã bỏ thích')) {
                        toastType = 'info';
                    } else if (formattedNotification.message.includes('đã thêm bài viết của bạn vào danh sách tin cậy')) {
                        toastType = 'success';
                    } else if (formattedNotification.message.includes('đã xóa bài viết của bạn khỏi danh sách tin cậy')) {
                        toastType = 'info';
                    } else if (formattedNotification.message.includes('đã bình luận bài viết của bạn')) {
                        toastType = 'info';
                    }

                    showToast(formattedNotification.message, toastType);
                }
            },

            toggleDropdown() {
                this.isOpen = !this.isOpen;
            },

            fetchNotifications() {
                fetch('/notifications/fetch')
                    .then(response => response.json())
                    .then(data => {
                        // console.log('Fetched notifications:', data);
                        this.notifications = data.notifications;
                        this.unreadCount = data.unread_count;
                    })
                    .catch(error => {
                        console.error('Error fetching notifications:', error);
                    });
            },

            markAllAsRead() {
                if (this.unreadCount === 0) return;

                fetch('/notifications/mark-all-read', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.notifications.forEach(notification => {
                                notification.read_at = new Date().toISOString();
                            });
                            this.unreadCount = 0;
                        }
                    })
                    .catch(error => {
                        console.error('Error marking all as read:', error);
                    });
            },

            openNotification(notification) {
                // Nếu notification có link thì chuyển hướng đến link đó
                if (notification.link) {
                    // Đánh dấu là đã đọc trước khi chuyển hướng
                    if (!notification.read_at) {
                        this.markAsRead(notification.id);
                    }
                    window.location.href = notification.link;
                } else {
                    // Nếu không có link thì chỉ đánh dấu là đã đọc
                    if (!notification.read_at) {
                        this.markAsRead(notification.id);
                    }
                }
            },

            markAsRead(id) {
                fetch(`/notifications/mark-read/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let notification = this.notifications.find(n => n.id === id);
                            if (notification) {
                                notification.read_at = new Date().toISOString();
                                this.unreadCount = Math.max(0, this.unreadCount - 1);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error marking as read:', error);
                    });
            }
        }));
    });
</script>

<style>
    /* Tùy chỉnh giao diện dropdown */
    .max-h-64.overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }

    .max-h-64.overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .max-h-64.overflow-y-auto::-webkitScrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .max-h-64.overflow-y-auto::-webkitScrollbar-thumb:hover {
        background: #555;
    }
</style>
