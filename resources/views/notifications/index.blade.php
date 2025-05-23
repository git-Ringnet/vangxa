@extends('layouts.main')

@section('title', 'Thông báo - Vangxa')

@section('content')
<div class="notifications-page" x-data="notificationsPage">
    <div class="container-custom">
        <div class="notifications-header">
            <div class="notification-title">
                <h2>Thông báo</h2>
                <div class="notification-actions">
                    <button id="markAllReadBtn" class="mark-all-btn" @click="markAllAsRead">Đánh dấu đã đọc</button>
                    <button id="notificationSettingsBtn"><i class="fas fa-cog"></i></button>
                </div>
            </div>

            <div class="notification-tabs">
                <button class="notification-tab" :class="{ 'active': currentFilter === 'all' }" @click="setFilter('all')">Tất cả</button>
                <button class="notification-tab" :class="{ 'active': currentFilter === 'mention' }" @click="setFilter('mention')">Nhắc đến</button>
                <button class="notification-tab" :class="{ 'active': currentFilter === 'like' }" @click="setFilter('like')">Thích</button>
                <button class="notification-tab" :class="{ 'active': currentFilter === 'unlike' }" @click="setFilter('unlike')">Bỏ thích</button>
                <button class="notification-tab" :class="{ 'active': currentFilter === 'comment' }" @click="setFilter('comment')">Bình luận</button>
                <button class="notification-tab" :class="{ 'active': currentFilter === 'trustlist' }" @click="setFilter('trustlist')">Tin cậy</button>
                <button class="notification-tab" :class="{ 'active': currentFilter === 'untrust' }" @click="setFilter('untrust')">Bỏ tin cậy</button>
                <button class="notification-tab" :class="{ 'active': currentFilter === 'follow' }" @click="setFilter('follow')">Theo dõi</button>
                <button class="notification-tab" :class="{ 'active': currentFilter === 'unfollow' }" @click="setFilter('unfollow')">Hủy theo dõi</button>
                <button class="notification-tab" :class="{ 'active': currentFilter === 'other' }" @click="setFilter('other')">Khác</button>
            </div>
        </div>

        <div class="notifications-content">
            <div class="notification-list">
                <template x-if="filteredNotifications.length > 0">
                    <template x-for="notification in filteredNotifications" :key="notification.id">
                        <div class="notification-item" :class="{ 'unread': !notification.read_at }" @click="openNotification(notification)">
                        <div class="notification-icon">
                                        <!-- Icons for different notification types -->
                                        <template x-if="notification.data.type === 'follow'">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                                </path>
                                            </svg>
                                        </template>
                                        <template x-if="notification.data.type === 'unfollow'">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                                </path>
                                            </svg>
                                        </template>
                                        <template x-if="notification.data.type === 'like'">
                                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                            </svg>
                                        </template>
                                        <template x-if="notification.data.type === 'unlike'">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </template>
                                        <template x-if="notification.data.type === 'trustlist'">
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/>
                                            </svg>
                                        </template>
                                        <template x-if="notification.data.type === 'untrust'">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </template>
                                        <template x-if="notification.data.type === 'comment'">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                            </svg>
                                        </template>
                                        <template x-if="notification.data.type === 'mention'">
                                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                            </svg>
                                        </template>
                                        <template x-if="!['follow', 'unfollow', 'like', 'unlike', 'trustlist', 'untrust', 'comment', 'mention'].includes(notification.data.type)">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </template>
                                    </div>
                    <div class="notification-avatar">
                                <template x-if="notification.data.user_avatar">
                                    <img :src="notification.data.user_avatar" alt="Avatar">
                                </template>
                                <template x-if="!notification.data.user_avatar">
                        <div class="default-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                                </template>
                    </div>
                    <div class="notification-content">
                                <div class="user-name-row">
                                    <span class="user-name" x-text="notification.data.user_name || 'Người dùng'"></span>
                                </div>
                                <div class="notification-info-row">
                                    <span class="action-text" x-text="getActionText(notification)"></span>
                                    <span class="dot-separator">•</span>
                                    <span class="notification-time" x-text="formatTime(notification.created_at)"></span>
                        </div>
                                <template x-if="notification.data.post_title">
                                    <div class="notification-post-info" x-text="notification.data.post_title"></div>
                                </template>
                        </div>
                        </div>
                    </template>
                </template>
                <template x-if="filteredNotifications.length === 0">
                <div class="no-notifications">
                    <div class="empty-icon">
                        <i class="far fa-bell"></i>
                    </div>
                    <p>Không có thông báo nào</p>
                </div>
                </template>
            </div>
        </div>
    </div>
</div>

<style>
    .notifications-page {
        padding-top: 20px;
        background-color: #faf6e9;
        min-height: calc(100vh - 60px);
    }

    .notifications-header {
        background-color: #faf6e9;
        padding: 15px;
        border-bottom: 1px solid rgba(122, 92, 46, 0.1);
        margin-bottom: 12px;
        will-change: transform;
        transform: translateZ(0);
        -webkit-transform: translateZ(0);
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }

    .notification-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .notification-title h2 {
        font-size: 24px;
        font-weight: 600;
        color: #7C4D28;
        margin: 0;
    }

    .notification-actions {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .mark-all-btn {
        background: none;
        border: 1px solid #7C4D28;
        color: #7C4D28;
        border-radius: 20px;
        padding: 5px 15px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .mark-all-btn:hover {
        background-color: rgba(124, 77, 40, 0.1);
    }

    .notification-actions button {
        background: none;
        border: none;
        font-size: 18px;
        color: #7C4D28;
        cursor: pointer;
    }

    .notification-tabs {
        display: flex;
        overflow-x: auto;
        gap: 10px;
        padding-bottom: 5px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .notification-tabs::-webkit-scrollbar {
        display: none;
    }

    .notification-tab {
        white-space: nowrap;
        padding: 8px 16px;
        border: none;
        background-color: #fff;
        border-radius: 20px;
        font-size: 14px;
        color: #333;
        cursor: pointer;
    }

    .notification-tab.active {
        background-color: #7C4D28;
        color: white;
    }

   

    .notification-list {
     
        flex-direction: column;
      
        max-width: 800px;
        margin: 0 auto;
    }

    .notification-item {
        display: flex;
        gap: 15px;
        padding: 15px;
        /* background-color: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); */
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .notification-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    .notification-item.unread {
        background-color: rgba(124, 77, 40, 0.05);
    }

    .notification-avatar {
        width: 50px;
        height: 50px;
        flex-shrink: 0;
    }

    .notification-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .default-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #777;
    }

    .notification-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
/* 
    .user-name-row {
        margin-bottom: 4px;
    } */

    .user-name {
        font-weight: 600;
        color: #7C4D28;
    }
    .notification-text {
        font-size: 15px;
        margin-bottom: 5px;
        color: #333;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .notification-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        margin-right: 5px;
        margin-top: 13px;
    }
    .notification-info-row {
       
        align-items: center;
        color: #666;
        font-size: 12px;
    }

    .action-text {
        color: #666;
    }

    .dot-separator {
        margin: 0 5px;
        font-size: 10px;
        color: #999;
    }

    .notification-time {
        color: #999;
        font-size: 13px;
    }

    .notification-post-info {
        margin-top: 8px;
        padding: 8px;
        background-color: #f5f5f5;
        border-radius: 6px;
        font-size: 14px;
        color: #555;
    }

    .no-notifications {
        text-align: center;
        padding: 40px 0;
        color: #777;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 15px;
        color: #ddd;
    }

    @media (max-width: 768px) {
        .notifications-page {
            padding-top: 10px;
        }

        .notification-title h2 {
            font-size: 20px;
        }

        .notification-avatar {
            width: 40px;
            height: 40px;
        }

        .notification-text {
            font-size: 14px;
        }

        .notification-item {
            padding: 12px;
        }
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notificationsPage', () => ({
            notifications: @json($notifications ?? []),
            currentFilter: 'all',
            currentUserId: {{ auth()->id() ?? 'null' }},

            init() {
                // Initialize real-time updates if Echo is available
                if (typeof window.Echo !== 'undefined' && this.currentUserId) {
                    this.initializeRealTimeUpdates();
                }
            },

            initializeRealTimeUpdates() {
                window.Echo.private(`user.${this.currentUserId}`)
                    // Listen for broadcast notification created events
                    .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (notification) => {
                        console.log('Notification received:', notification);
                        this.handleNewNotification(notification);
                    })
                    // Follow event
                    .listen('FollowEventReverb', (e) => {
                        console.log('Follow event received:', e);
                        this.handleNewNotification({
                            id: `follow-${Date.now()}`,
                            data: {
                                user_name: e.follower_name || 'Người dùng',
                                type: 'follow',
                                user_avatar: e.follower_avatar,
                                message: `${e.follower_name || 'Người dùng'} đã bắt đầu theo dõi bạn`
                            },
                            created_at: new Date().toISOString(),
                            read_at: null
                        });
                    })
                    // Unfollow event
                    .listen('UnfollowEvent', (e) => {
                        console.log('Unfollow event received:', e);
                        this.handleNewNotification({
                            id: `unfollow-${Date.now()}`,
                            data: {
                                user_name: e.unfollower_name || e.follower_name || 'Người dùng',
                                type: 'unfollow',
                                user_avatar: e.unfollower_avatar || e.avatar,
                                message: `${e.unfollower_name || e.follower_name || 'Người dùng'} đã hủy theo dõi bạn`
                            },
                            created_at: new Date().toISOString(),
                            read_at: null
                        });
                    })
                    // Like event
                    .listen('.like.created', (e) => {
                        console.log('Like event received:', e);
                        this.handleNewNotification({
                            id: `like-${Date.now()}`,
                            data: {
                                user_name: e.liker_name || 'Người dùng',
                                type: 'like',
                                user_avatar: e.liker_avatar,
                                post_title: e.post_title,
                                post_type: e.post_type,
                                link: e.link,
                                message: `${e.liker_name || 'Người dùng'} đã thích bài viết của bạn`
                            },
                            created_at: new Date().toISOString(),
                            read_at: null
                        });
                    })
                    // Unlike event
                    .listen('.like.deleted', (e) => {
                        console.log('Unlike event received:', e);
                        this.handleNewNotification({
                            id: `unlike-${Date.now()}`,
                            data: {
                                user_name: e.unliker_name || 'Người dùng',
                                type: 'unlike',
                                user_avatar: e.unliker_avatar,
                                post_title: e.post_title,
                                post_type: e.post_type,
                                link: e.link,
                                message: `${e.unliker_name || 'Người dùng'} đã bỏ thích bài viết của bạn`
                            },
                            created_at: new Date().toISOString(),
                            read_at: null
                        });
                    })
                    // Trustlist event
                    .listen('.trustlist.created', (e) => {
                        console.log('Trustlist event received:', e);
                        this.handleNewNotification({
                            id: `trustlist-${Date.now()}`,
                            data: {
                                user_name: e.user_name || 'Người dùng',
                                type: 'trustlist',
                                user_avatar: e.user_avatar,
                                post_title: e.post_title,
                                post_type: e.post_type,
                                link: e.link,
                                message: `${e.user_name || 'Người dùng'} đã thêm bài viết của bạn vào danh sách tin cậy`
                            },
                            created_at: new Date().toISOString(),
                            read_at: null
                        });
                    })
                    // Untrust event
                    .listen('.untrust.created', (e) => {
                        console.log('Untrust event received:', e);
                        this.handleNewNotification({
                            id: `untrust-${Date.now()}`,
                            data: {
                                user_name: e.user_name || 'Người dùng',
                                type: 'untrust',
                                user_avatar: e.user_avatar,
                                post_title: e.post_title,
                                post_type: e.post_type,
                                link: e.link,
                                message: `${e.user_name || 'Người dùng'} đã xóa bài viết của bạn khỏi danh sách tin cậy`
                            },
                            created_at: new Date().toISOString(),
                            read_at: null
                        });
                    })
                    // Comment event
                    .listen('.comment.created', (e) => {
                        console.log('Comment event received:', e);
                        this.handleNewNotification({
                            id: `comment-${Date.now()}`,
                            data: {
                                user_name: e.user_name || 'Người dùng',
                                type: 'comment',
                                user_avatar: e.user_avatar,
                                post_title: e.post_title,
                                post_type: e.post_type,
                                link: e.link,
                                message: `${e.user_name || 'Người dùng'} đã bình luận bài viết của bạn`
                            },
                            created_at: new Date().toISOString(),
                            read_at: null
            });
        });
            },

            // Filter notifications by type
            get filteredNotifications() {
                if (this.currentFilter === 'all') {
                    return this.notifications;
                }
                return this.notifications.filter(notification => 
                    notification.data && notification.data.type === this.currentFilter
                );
            },

            // Change current filter
            setFilter(filter) {
                this.currentFilter = filter;
            },

            // Handle new incoming notifications
            handleNewNotification(notification) {
                this.notifications.unshift(notification);
            },

            // Get formatted notification message
            getNotificationMessage(notification) {
                if (!notification.data) return 'Bạn có thông báo mới';
                
                const userName = notification.data.user_name || 'Người dùng';
                const type = notification.data.type;
                
                switch (type) {
                    case 'like': return `${userName} đã thích bài viết của bạn`;
                    case 'unlike': return `${userName} đã bỏ thích bài viết của bạn`;
                    case 'follow': return `${userName} đã bắt đầu theo dõi bạn`;
                    case 'unfollow': return `${userName} đã hủy theo dõi bạn`;
                    case 'trustlist': return `${userName} đã thêm bài viết của bạn vào danh sách tin cậy`;
                    case 'untrust': return `${userName} đã xóa bài viết của bạn khỏi danh sách tin cậy`;
                    case 'comment': return `${userName} đã bình luận bài viết của bạn`;
                    case 'mention': return `${userName} đã nhắc đến bạn`;
                    default: return notification.data.message || 'Bạn có thông báo mới';
                }
            },

            // Get action text for notification
            getActionText(notification) {
                if (!notification.data) return 'đã tương tác với bạn';
                
                const type = notification.data.type;
                
                // If user_name exists, use it directly
                if (notification.data.user_name) {
                    switch (type) {
                        case 'like': return 'đã thích bài viết của bạn';
                        case 'unlike': return 'đã bỏ thích bài viết của bạn';
                        case 'follow': return 'đã bắt đầu theo dõi bạn';
                        case 'unfollow': return 'đã hủy theo dõi bạn';
                        case 'trustlist': return 'đã thêm bài viết của bạn vào danh sách tin cậy';
                        case 'untrust': return 'đã xóa bài viết của bạn khỏi danh sách tin cậy';
                        case 'comment': return 'đã bình luận bài viết của bạn';
                        case 'mention': return 'đã nhắc đến bạn';
                        default: return notification.data.message || 'đã tương tác với bạn';
                    }
                } else {
                    // If user_name is not directly available, try to extract it from the message
                    if (notification.data.message) {
                        // Most messages follow pattern: "[Username] đã [action]"
                        const message = notification.data.message;
                        const match = message.match(/(.*?) đã/);
                        
                        if (match && match[1]) {
                            // Extract and assign the username to make it consistent
                            notification.data.user_name = match[1];
                            // Return only the action part without the username
                            return message.replace(match[1], '').trim();
                        }
                    }
                    
                    // Fallback to just showing the complete message
                    return notification.data.message || 'đã tương tác với bạn';
                }
            },

            // Format timestamp to readable format
            formatTime(timestamp) {
                if (!timestamp) return '';
                
                const date = new Date(timestamp);
                const now = new Date();
                const diffInSeconds = Math.floor((now - date) / 1000);
                
                if (diffInSeconds < 60) return 'Vừa xong';
                if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} phút trước`;
                if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} giờ trước`;
                if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} ngày trước`;
                
                return date.toLocaleDateString('vi-VN');
            },

            // Mark all notifications as read
            markAllAsRead() {
                fetch('/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update all notifications in the list to be read
                        this.notifications.forEach(notification => {
                            notification.read_at = new Date().toISOString();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error marking all as read:', error);
                });
            },

            // Open a notification and mark it as read
            openNotification(notification) {
                // Mark notification as read if it's unread
                if (!notification.read_at) {
                    this.markAsRead(notification.id);
                }

                // Đối với thông báo theo dõi, điều hướng đến trang cá nhân
                if (notification.data && (notification.data.type === 'follow' || notification.data.type === 'unfollow')) {
                    if (notification.data.user_id) {
                        window.location.href = `/profile/${notification.data.user_id}`;
                        return;
                    }
                }
                
                // Nếu có link trực tiếp trong notification data, sử dụng nó
                if (notification.data && notification.data.link) {
                    window.location.href = notification.data.link;
                    return;
                }
                
                // Đối với thông báo liên quan đến bài đăng
                if (notification.data && notification.data.post_id) {
                    const postId = notification.data.post_id;
                    const postType = notification.data.post_type;
                    
                    // Sử dụng post_type để xác định URL chính xác
                    if (postType) {
                        switch (postType) {
                            case 1: // Lodging
                            case 'lodging': 
                                window.location.href = `/lodging/detail/${postId}`;
                                break;
                            case 2: // Dining
                            case 'dining':
                                window.location.href = `/dining/detail/${postId}`;
                                break;
                            case 3: // Community
                            case 'community':
                                window.location.href = `/communities/${postId}`;
                                break;
                            default:
                                // Fallback to API check if post_type is unknown
                                this.checkPostTypeViaAjax(postId);
                                return;
                        }
                    }
                }
                
                // Fallback to console log if we can't determine where to go
                console.log("Không tìm thấy URL cụ thể cho thông báo:", notification);
            },

            // Mark a single notification as read
            markAsRead(id) {
                fetch(`/notifications/mark-read/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Find and update the notification in our local array
                        const notification = this.notifications.find(n => n.id === id);
                        if (notification) {
                            notification.read_at = new Date().toISOString();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                });
        }
        }));
    });
</script>
@endsection