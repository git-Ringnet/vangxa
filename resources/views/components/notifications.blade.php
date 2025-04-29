@props(['notifications' => []])
<div x-data="notificationBell" class="relative">
    <!-- Chuông thông báo -->
    <button @click="toggleDropdown" class="relative focus:outline-none" x-data="progress">
        <svg class="w-6 h-6 text-gray-600 hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <!-- Đếm số lượng thông báo chưa đọc -->
        <span x-show="unreadCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" x-text="unreadCount"></span>
    </button>
    <!-- Dropdown thông báo -->
    <div x-show="isOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
        <div class="p-4">
            <h3 class="text-sm font-semibold text-gray-800 mb-3">Thông báo</h3>
            <div class="max-h-64 overflow-y-auto">
                <template x-for="notification in notifications" :key="notification.id">
                    <div class="py-2 px-3 hover:bg-gray-100 rounded-md cursor-pointer"
                         :class="{ 'bg-blue-50': !notification.read_at }"
                         @click="markAsRead(notification.id)">
                        <p class="text-sm text-gray-700" x-text="notification.message"></p>
                        <p class="text-xs text-gray-500 mt-1" x-text="notification.created_at"></p>
                    </div>
                </template>
                <div x-show="notifications.length === 0" class="text-sm text-gray-500 text-center py-4">
                    Không có thông báo nào
                </div>
            </div>
            <div class="border-t border-gray-200 mt-3 pt-3">
                <button @click="markAllAsRead" class="text-sm text-blue-500 hover:text-blue-700 w-full text-left" x-show="unreadCount > 0">
                    Đánh dấu tất cả đã đọc
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('progress', () => ({
            unreadCount: 0,
            init() {
                // Fetch initial notification count
                this.fetchNotificationCount();

                // Listen for new notifications
                Echo.private('App.Models.User.' + {{ auth()->id() }})
                    .notification((notification) => {
                        this.unreadCount++;
                        showToast('Bạn có thông báo mới', 'info');
                    });
            },
            fetchNotificationCount() {
                fetch('/notifications/count')
                    .then(response => response.json())
                    .then(data => {
                        this.unreadCount = data.count;
                    })
                    .catch(error => {
                        console.error('Lỗi khi lấy số thông báo:', error);
                    });
            },
            updateNotificationCount(increment = true) {
                if (increment) {
                    this.unreadCount++;
                } else if (this.unreadCount > 0) {
                    this.unreadCount--;
                }
            }
        }));

        Alpine.data('notificationBell', () => ({
            isOpen: false,
            notifications: @json($notifications),
            init() {
                // Cập nhật lại danh sách thông báo từ server nếu cần
                this.fetchNotifications();
            },

            fetchNotifications() {
                fetch('{{ route('notifications.fetch') }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    this.notifications = data;
                })
                .catch(error => {
                    console.error('Lỗi khi lấy thông báo:', error);
                });
            },
            markAsRead(notificationId) {
                fetch('{{ route('notifications.read') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ id: notificationId })
                })
                .then(response => response.json())
                .then(data => {
                    this.notifications = this.notifications.map(n =>
                        n.id === notificationId ? { ...n, read_at: new Date().toISOString() } : n
                    );
                })
                .catch(error => {
                    console.error('Lỗi khi đánh dấu đã đọc:', error);
                });
            },
            markAllAsRead() {
                fetch('{{ route('notifications.read-all') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    this.notifications = this.notifications.map(n => ({ ...n, read_at: new Date().toISOString() }));

                    // Update the notification count in the progress component
                    if (Alpine.$data(this.$root.querySelector('[x-data="progress"]'))) {
                        Alpine.$data(this.$root.querySelector('[x-data="progress"]')).unreadCount = 0;
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi đánh dấu tất cả đã đọc:', error);
                });
            },
            get unreadCount() {
                return this.notifications.filter(n => !n.read_at).length;
            },
            toggleDropdown() {
                this.isOpen = !this.isOpen;

                // Reset notification count when opening dropdown
                if (this.isOpen && Alpine.$data(this.$root.querySelector('[x-data="progress"]'))) {
                    Alpine.$data(this.$root.querySelector('[x-data="progress"]')).unreadCount = this.unreadCount;
                }
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