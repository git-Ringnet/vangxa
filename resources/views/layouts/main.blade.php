<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vangxa.vn - Nhà nghỉ dưỡng cho thuê, Cabin, Nhà trên bãi biển</title>
    <link rel="icon" href="/image/ship.png" type="image/x-icon">
    @vite(['resources/css/main.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


</head>
@stack('scripts')

<body>
    <!-- Navbar -->
    <nav class="navbar-custom">
        <div class="container-custom">
            <div class="navbar-content">
                <!-- Logo -->
                <a href="/" class="navbar-brand" style="display: flex; align-items: center; text-decoration: none;">
                    <img src="/image/ship.png" alt="Logo" width="50" height="52" />
                    <span style="margin-left: 8px; font-size: 26px;     font-weight: bold; color: #008cff; font-family: Verdana, sans-serif;">
                        Vangxa
                    </span>
                </a>

                <!-- Navigation Links -->
                <div class="nav-links">
                    <a href="{{ route('lodging') }}" class="nav-link {{ request()->is('lodging') ? 'active' : '' }}">Lưu Trú</a>
                    <a href="{{ route('dining') }}" class="nav-link {{ request()->is('dining') ? 'active' : '' }}">Ăn Uống</a>
                    <a href="#" class="nav-link" id="rankingLink">Bảng xếp hạng</a>
                    <a href="{{ route('community.index') }}" class="nav-link {{ request()->routeIs('community.*') ? 'active' : '' }}">Cộng đồng</a>
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

                        <div class="rankings-tabs">
                            <button class="ranking-tab active" data-tab="contributors">
                                <i class="fas fa-trophy"></i>
                                Người đóng góp tích cực
                            </button>
                            <button class="ranking-tab" data-tab="engagement">
                                <i class="fas fa-heart"></i>
                                Tương tác nhiều nhất
                            </button>
                            <button class="ranking-tab" data-tab="early">
                                <i class="fas fa-clock"></i>
                                Thành viên đầu tiên
                            </button>
                        </div>

                        <div class="rankings-content-area">
                            <!-- Contributors Ranking -->
                            <div class="ranking-section active" id="contributorsRanking">
                                <div class="ranking-list">
                                    <!-- Top 3 with special styling -->
                                    <div class="ranking-item top-three rank-1">
                                        <div class="rank"><i class="fas fa-crown"></i></div>
                                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User" class="ranking-avatar">
                                        <div class="ranking-info">
                                            <h4>Nguyễn Văn A</h4>
                                            <div class="contribution-stats">
                                                <span><i class="fas fa-comment"></i> 150</span>
                                                <span><i class="fas fa-heart"></i> 320</span>
                                                <span><i class="fas fa-star"></i> 89</span>
                                            </div>
                                        </div>
                                        <div class="ranking-score">2,300 điểm</div>
                                    </div>
                                    <div class="ranking-item top-three rank-2">
                                        <div class="rank"><i class="fas fa-crown"></i></div>
                                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User" class="ranking-avatar">
                                        <div class="ranking-info">
                                            <h4>Nguyễn Văn A</h4>
                                            <div class="contribution-stats">
                                                <span><i class="fas fa-comment"></i> 150</span>
                                                <span><i class="fas fa-heart"></i> 320</span>
                                                <span><i class="fas fa-star"></i> 89</span>
                                            </div>
                                        </div>
                                        <div class="ranking-score">2,200 điểm</div>
                                    </div>
                                    <div class="ranking-item top-three rank-3">
                                        <div class="rank"><i class="fas fa-crown"></i></div>
                                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User" class="ranking-avatar">
                                        <div class="ranking-info">
                                            <h4>Nguyễn Văn A</h4>
                                            <div class="contribution-stats">
                                                <span><i class="fas fa-comment"></i> 150</span>
                                                <span><i class="fas fa-heart"></i> 320</span>
                                                <span><i class="fas fa-star"></i> 89</span>
                                            </div>
                                        </div>
                                        <div class="ranking-score">2,400 điểm</div>
                                    </div>
                                    <!-- More ranking items -->
                                </div>
                            </div>

                            <!-- Engagement Ranking -->
                            <div class="ranking-section" id="engagementRanking">
                                <div class="ranking-list">
                                    <div class="ranking-item">
                                        <div class="rank">1</div>
                                        <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="User" class="ranking-avatar">
                                        <div class="ranking-info">
                                            <h4>Trần Thị B</h4>
                                            <div class="engagement-stats">
                                                <span><i class="fas fa-thumbs-up"></i> 450</span>
                                                <span><i class="fas fa-comment"></i> 230</span>
                                            </div>
                                        </div>
                                        <div class="ranking-score">1,800 tương tác</div>
                                    </div>
                                    <div class="ranking-item">
                                        <div class="rank">2</div>
                                        <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="User" class="ranking-avatar">
                                        <div class="ranking-info">
                                            <h4>Trần Thị B</h4>
                                            <div class="engagement-stats">
                                                <span><i class="fas fa-thumbs-up"></i> 450</span>
                                                <span><i class="fas fa-comment"></i> 230</span>
                                            </div>
                                        </div>
                                        <div class="ranking-score">1,800 tương tác</div>
                                    </div>
                                    <div class="ranking-item">
                                        <div class="rank">3</div>
                                        <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="User" class="ranking-avatar">
                                        <div class="ranking-info">
                                            <h4>Trần Thị B</h4>
                                            <div class="engagement-stats">
                                                <span><i class="fas fa-thumbs-up"></i> 450</span>
                                                <span><i class="fas fa-comment"></i> 230</span>
                                            </div>
                                        </div>
                                        <div class="ranking-score">1,800 tương tác</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Early Members Ranking -->
                            <div class="ranking-section" id="earlyRanking">
                                <div class="ranking-list">
                                    <div class="ranking-item">
                                        <div class="rank">#1</div>
                                        <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="User" class="ranking-avatar">
                                        <div class="ranking-info">
                                            <h4>Lê Văn C</h4>
                                            <p class="join-date">Tham gia: 01/01/2020</p>
                                        </div>
                                        <div class="member-badge">Thành viên đầu tiên</div>
                                    </div>
                                    <div class="ranking-item">
                                        <div class="rank">#1</div>
                                        <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="User" class="ranking-avatar">
                                        <div class="ranking-info">
                                            <h4>Lê Văn C</h4>
                                            <p class="join-date">Tham gia: 01/01/2020</p>
                                        </div>
                                        <div class="member-badge">Thành viên đầu tiên</div>
                                    </div>
                                    <div class="ranking-item">
                                        <div class="rank">#1</div>
                                        <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="User" class="ranking-avatar">
                                        <div class="ranking-info">
                                            <h4>Lê Văn C</h4>
                                            <p class="join-date">Tham gia: 01/01/2020</p>
                                        </div>
                                        <div class="member-badge">Thành viên đầu tiên</div>
                                    </div>
                                </div>
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
                    <div class="user-menu">
                        <button class="menu-button">
                            <i class="fas fa-bars"></i>
                            <i class="fas fa-user-circle"></i>
                        </button>
                        <div class="dropdown-menu" id="userDropdown">
                            <div class="dropdown-section">
                                <a href="#" class="dropdown-item"><strong>Đăng ký</strong></a>
                                <a href="#" class="dropdown-item">Đăng nhập</a>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-section">
                                <a href="#" class="dropdown-item">Cho thuê chỗ ở qua Vangxa</a>
                                <a href="#" class="dropdown-item">Tổ chức trải nghiệm</a>
                                <a href="#" class="dropdown-item">Trung tâm trợ giúp</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <div class="search-container">
                    <div class="search-item">
                        <div class="search-label">Địa điểm</div>
                        <input type="text" placeholder="{{ request()->is('dining') ? 'Tìm nhà hàng, món ăn...' : 'Tìm kiếm điểm đến' }}" class="search-input">
                    </div>

                    @if(!request()->is('dining'))
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

    <script>
        // Rankings Modal Control
        document.addEventListener('DOMContentLoaded', function() {
            const rankingLink = document.getElementById('rankingLink');
            const rankingsModal = document.getElementById('rankingsModal');
            const closeRankingsBtn = document.getElementById('closeRankingsBtn');
            const rankingTabs = document.querySelectorAll('.ranking-tab');
            const rankingSections = document.querySelectorAll('.ranking-section');

            if (rankingLink && rankingsModal && closeRankingsBtn) {
                // Open Rankings Modal
                rankingLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    rankingsModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });

                // Close Rankings Modal
                const closeRankings = () => {
                    rankingsModal.classList.remove('show');
                    document.body.style.overflow = '';
                };

                // Add click event for close button
                closeRankingsBtn.addEventListener('click', closeRankings);

                // Tab Switching
                rankingTabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        // Remove active class from all tabs and sections
                        rankingTabs.forEach(t => t.classList.remove('active'));
                        rankingSections.forEach(s => s.classList.remove('active'));

                        // Add active class to clicked tab
                        tab.classList.add('active');

                        // Show corresponding section
                        const targetSection = document.getElementById(tab.dataset.tab + 'Ranking');
                        if (targetSection) {
                            targetSection.classList.add('active');
                        }
                    });
                });

                // Close modal when clicking outside
                rankingsModal.addEventListener('click', (e) => {
                    if (e.target === rankingsModal) {
                        closeRankings();
                    }
                });

                // Close modal with Escape key
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && rankingsModal.classList.contains('show')) {
                        closeRankings();
                    }
                });
            }
        });
    </script>
</body>

</html>