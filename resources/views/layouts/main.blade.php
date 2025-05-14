<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" href="/image/ship.png" type="image/x-icon">
    @vite(['resources/css/main.css', 'resources/js/app.js', 'resources/css/leaderboard/leaderboard.css'])
    <link rel="stylesheet" href="{{ asset('community/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- <style>
        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 350px;
        }
        .toast {
            padding: 15px;
            border-radius: 8px;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }
        .toast-success {
            background-color: #4caf50;
        }
        .toast-error {
            background-color: #f44336;
        }
        .toast-warning {
            background-color: #ff9800;
        }
        .toast-info {
            background-color: #2196f3;
        }
        .toast-content {
            flex-grow: 1;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .toast-content i {
            font-size: 20px;
        }
        .toast-content span {
            word-break: break-word;
        }
        .toast-close {
            cursor: pointer;
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            opacity: 0.8;
            padding: 0 5px;
        }
        .toast-close:hover {
            opacity: 1;
        }
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background-color: rgba(255, 255, 255, 0.4);
            width: 100%;
            transform-origin: left;
        }
    </style> -->
</head>
@stack('scripts')

<body data-user-id="{{ auth()->check() ? auth()->id() : '' }}">
    <!-- Navbar -->
    <nav class="navbar-custom">
        <div class="container-custom">
            <div class="navbar-content">
                <!-- Logo -->
                <a href="/" class="navbar-brand"
                    style="display: flex; align-items: center; text-decoration: none;">
                    <img src="/image/ship.png" alt="Logo" width="50" height="52" />
                    <span
                        style="margin-left: 8px; font-size: 26px;     font-weight: bold; color: #008cff; font-family: Verdana, sans-serif;">
                        Vangxa
                    </span>
                </a>

                <!-- Navigation Links -->
                <div class="nav-links">
                    <a href="{{ route('lodging') }}" class="nav-link {{ request()->is('lodging') ? 'active' : '' }}">Lưu
                        Trú</a>
                    <a href="{{ route('dining') }}" class="nav-link {{ request()->is('dining') ? 'active' : '' }}">Ăn
                        Uống</a>
                    <a href="#" class="nav-link" id="rankingLink">Bảng xếp hạng</a>
                    <a href="{{ route('groupss.index') }}"
                        class="nav-link {{ request()->routeIs('groupss.*') ? 'active' : '' }}">Cộng đồng</a>
                </div>

                <!-- Rankings Modal -->
                <div class="rankings-modal" id="rankingsModal">
                    <div class="rankings-content">
                        <div class="rankings-header">
                            <h3>Bảng xếp hạng</h3>
                            <button class="close-button" id="closeRankingsBtn">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="rankings-preview">
                            <div class="preview-header">
                                <h4>Top 10 người đóng góp tích cực</h4>
                                <span class="preview-period">Tháng {{ now()->format('m/Y') }}</span>
                            </div>

                            <div class="preview-list">
                                @foreach($topContributors ?? [] as $index => $user)
                                    <div class="preview-item {{ $index < 3 ? 'top-three rank-' . ($index + 1) : '' }}">
                                        <div class="rank">
                                            @if($index < 3)
                                                <i class="fas fa-crown"></i>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </div>
                                        <img src="{{ $user->avatar ?? asset('image/default/default-group-avatar.jpg') }}" alt="User" class="preview-avatar">
                                        <div class="preview-info">
                                            <h5>{{ $user->name }}</h5>
                                            <div class="preview-stats">
                                                <span class="points">{{ number_format($user->total_points) }} điểm</span>
                                                <span class="tier {{ strtolower($user->tier) }}">{{ $user->tier }}</span>
                                                <span class="posts"><i class="fas fa-comment"></i> {{ $user->posts_count }} bài viết</span>
                                                <span class="trustlist"><i class="fas fa-bookmark"></i> {{ $user->trustlist_count }} trustlist</span>
                                                <span class="share"><i class="fas fa-share"></i> {{ $user->share_count }} chia sẻ</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="preview-footer">
                                <a href="{{ route('leaderboard') }}" class="view-full-btn">
                                    Xem bảng xếp hạng đầy đủ
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Menu -->
                <div class="navbar-right">
                    <a href="#" class="host-button">Cho thuê chỗ ở qua Vangxa</a>
                    <button class="globe-button">
                        <i class="fas fa-globe"></i>
                    </button>
                    <div class="settings-notifi pr-4">
                        <x-notifications :notifications="auth()->user()->notifications ?? []" />
                    </div>
                    <div class="user-menu">
                        <button class="menu-button">
                            <i class="fas fa-bars"></i>
                            <i class="fas fa-user-circle"></i>
                        </button>
                        <div class="dropdown-menu" id="userDropdown">
                            @auth
                                <div class="dropdown-section">
                                    <a href="{{ route('profile') }}" class="dropdown-item"><strong>Hồ sơ</strong></a>
                                    <a href="{{ route('trustlist') }}" class="dropdown-item">Danh sách đáng tin cậy</a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-section">
                                    <a href="#" class="dropdown-item">Cho thuê chỗ ở qua Vangxa</a>
                                    <a href="#" class="dropdown-item">Tổ chức trải nghiệm</a>
                                    <a href="#" class="dropdown-item">Trung tâm trợ giúp</a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-section">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Đăng xuất</button>
                                    </form>
                                </div>
                            @else
                                <div class="dropdown-section">
                                    <a href="{{ route('register') }}" class="dropdown-item"><strong>Đăng ký</strong></a>
                                    <a href="{{ route('login') }}" class="dropdown-item">Đăng nhập</a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-section">
                                    <a href="#" class="dropdown-item">Cho thuê chỗ ở qua Vangxa</a>
                                    <a href="#" class="dropdown-item">Tổ chức trải nghiệm</a>
                                    <a href="#" class="dropdown-item">Trung tâm trợ giúp</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <div class="search-container">
                    {{-- <div x-data="searchComponent()" class="search-item">
                        <div class="search-label">Địa điểm</div>
                        <input type="text"
                            placeholder="{{ request()->is('dining') ? 'Tìm nhà hàng, món ăn...' : 'Tìm kiếm điểm đến' }}"
                            class="search-input" x-model="query" @input.debounce.500ms="search">
                    </div> --}}

                    @if (!request()->is('dining'))
                        <div class="search-divider"></div>
                        <div class="search-item">
                            <div class="search-label">Nhận phòng</div>
                            <div class="search-input">Thêm ngày</div>
                        </div>
                        <div class="search-divider"></div>
                        <div class="search-item">
                            <div class="search-label">Trả phòng</div>
                            <div class="search-input">Thêm ngày</div>
                        </div>
                        <div class="search-divider"></div>
                        <div class="search-item">
                            <div class="search-label">Khách</div>
                            <div class="search-input">Thêm khách</div>
                        </div>
                    @else
                        <div class="search-divider"></div>
                        <div class="search-item">
                            <div class="search-label">Món ăn</div>
                            <div class="search-input">Loại món</div>
                        </div>
                    @endif

                    <button class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/like-handler.js') }}"></script>

    <script>
        // Rankings Modal Control
        document.addEventListener('DOMContentLoaded', function() {
            const rankingLink = document.getElementById('rankingLink');
            const rankingsModal = document.getElementById('rankingsModal');
            const closeRankingsBtn = document.getElementById('closeRankingsBtn');

            if (rankingLink && rankingsModal && closeRankingsBtn) {
                rankingLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    rankingsModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });

                const closeRankings = () => {
                    rankingsModal.classList.remove('show');
                    document.body.style.overflow = '';
                };

                closeRankingsBtn.addEventListener('click', closeRankings);

                rankingsModal.addEventListener('click', (e) => {
                    if (e.target === rankingsModal) {
                        closeRankings();
                    }
                });

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && rankingsModal.classList.contains('show')) {
                        closeRankings();
                    }
                });
            }
        });

        // Toast notification function
        function showToast(message, type = 'success') {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;

            // Create toast content
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

            // Add close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'toast-close';
            closeBtn.innerHTML = '<i class="fas fa-times"></i>';
            closeBtn.addEventListener('click', () => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            });
            toast.appendChild(closeBtn);

            // Add toast to container
            const toastContainer = document.querySelector('.toast-container') || (() => {
                const container = document.createElement('div');
                container.className = 'toast-container';
                document.body.appendChild(container);
                return container;
            })();

            toastContainer.appendChild(toast);

            // Show toast
            setTimeout(() => toast.classList.add('show'), 100);

            // Remove toast after 5 seconds
            const timeoutId = setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 60000);

            // Cancel timeout if close button is clicked
            closeBtn.addEventListener('click', () => {
                clearTimeout(timeoutId);
            });
        }

        // Hàm gửi sự kiện thăng hạng
        function dispatchTierUpgradeEvent(data) {
            const event = new CustomEvent('tierUpgrade', { detail: data });
            document.dispatchEvent(event);
        }

        // Override fetch để xử lý thông báo thăng hạng
        const originalFetch = window.fetch;
        window.fetch = async function(...args) {
            const response = await originalFetch(...args);
            const clone = response.clone();

            try {
                const data = await clone.json();
                if (data.tier_upgrade && data.tier_upgrade.upgraded) {
                    dispatchTierUpgradeEvent(data.tier_upgrade);
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
            }

            return response;
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Kiểm tra thăng hạng từ session
            @if(session('tier_upgrade'))
                showTierUpgradeAnimation(@json(session('tier_upgrade')));
            @endif

            // Hàm hiển thị thông báo thăng hạng
            function showTierUpgradeAnimation(data) {
                // Tạo modal thông báo
                const modal = document.createElement('div');
                modal.className = 'tier-upgrade-modal';
                modal.innerHTML = `
                    <div class="tier-upgrade-content">
                        <div class="tier-upgrade-icon" style="color: ${data.color}">${data.icon}</div>
                        <h3>Chúc mừng!</h3>
                        <p>Bạn đã đạt hạng ${data.new_tier}</p>
                        <p>Với ${data.points} điểm trong tháng này</p>
                        <button class="close-tier-upgrade">Đóng</button>
                    </div>
                `;

                document.body.appendChild(modal);

                // Thêm animation
                setTimeout(() => {
                    modal.classList.add('show');
                }, 100);

                // Xử lý đóng modal
                modal.querySelector('.close-tier-upgrade').addEventListener('click', () => {
                    modal.classList.remove('show');
                    setTimeout(() => {
                        modal.remove();
                    }, 300);
                });
            }

            // Xử lý thông báo thăng hạng từ AJAX response
            document.addEventListener('tierUpgrade', function(e) {
                if (e.detail && e.detail.upgraded) {
                    showTierUpgradeAnimation(e.detail);
                }
            });
        });
    </script>

    @auth
        @if (!auth()->user()->phone)
            <x-register-popup />

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    window.dispatchEvent(new CustomEvent('open-register-popup'));
                });
            </script>
        @endif
    @endauth

</body>

</html>
