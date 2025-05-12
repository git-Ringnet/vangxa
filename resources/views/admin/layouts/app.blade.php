<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Vang Xa Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/dropdown.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('vangxa.index') }}" class="text-decoration-none">
                    <div class="d-flex align-items-center">
                        <div class="w-50px"><img src="{{ asset('image/ship.png') }}" alt="" class="w-100"></div>
                        <h3 style="color: #3889fa;">Vangxa</h3>
                    </div>
                </a>
            </div>

            <ul class="list-unstyled components">
                <li class="{{ request()->routeIs('vangxa.index') ? 'active' : '' }}">
                    <a href="{{ route('vangxa.index') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('posts.*') ? 'active' : '' }}">
                    <a href="{{ route('posts.index') }}">
                        <i class="fas fa-newspaper"></i>
                        <span>Quản lý bài viết</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Quản lý người dùng</span>
                    </a>
                </li>
                <!-- Dropdown menu cho thống kê -->
                <li class="{{ request()->routeIs('analytics.*') ? 'active' : '' }}">
                    <a href="#analyticsSubmenu" data-toggle="collapse" aria-expanded="{{ request()->routeIs('analytics.*') ? 'true' : 'false' }}" class="dropdown-toggle">
                        <i class="fas fa-chart-line"></i>
                        <span>Thống kê dữ liệu</span>
                    </a>
                    <ul class="collapse list-unstyled {{ request()->routeIs('analytics.*') ? 'show' : '' }}" id="analyticsSubmenu">
                        <li class="{{ request()->routeIs('analytics.user-activity') ? 'active' : '' }}">
                            <a href="{{ route('analytics.user-activity') }}" class="pl-4">
                                <i class="fas fa-users mr-2"></i>Thống kê DAU/WAU
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('analytics.trustlist-rate') ? 'active' : '' }}">
                            <a href="{{ route('analytics.trustlist-rate') }}" class="pl-4">
                                <i class="fas fa-bookmark mr-2"></i>Tỷ lệ Save-to-Trustlist
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('analytics.story-post-rate') ? 'active' : '' }}">
                            <a href="{{ route('analytics.story-post-rate') }}" class="pl-4">
                                <i class="fas fa-utensils mr-2"></i>Tỷ lệ vendor đăng dịch vụ
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('analytics.vendor-profile-views') ? 'active' : '' }}">
                            <a href="{{ route('analytics.vendor-profile-views') }}" class="pl-4">
                                <i class="fas fa-store mr-2"></i>Xem hồ sơ người bán
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('analytics.community-post-rate') ? 'active' : '' }}">
                            <a href="{{ route('analytics.community-post-rate') }}" class="pl-4">
                                <i class="fas fa-users mr-2"></i>Tỷ lệ đăng bài cộng đồng
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('analytics.posts-with-engagements') ? 'active' : '' }}">
                            <a href="{{ route('analytics.posts-with-engagements') }}" class="pl-4">
                                <i class="fas fa-star mr-2"></i>Bài viết Vendor có tương tác
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('analytics.community-posts-with-reactions') ? 'active' : '' }}">
                            <a href="{{ route('analytics.community-posts-with-reactions') }}" class="pl-4">
                                <i class="fas fa-comments mr-2"></i>Bài viết Community có tương tác
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('roles-permissions.index') }}">
                        <i class="fas fa-cog"></i>
                        <span>Cài đặt</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-light">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bell"></i>
                                    <span class="badge bg-danger">3</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Thông báo 1</a></li>
                                    <li><a class="dropdown-item" href="#">Thông báo 2</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Xem tất cả</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Admin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>
                                            Hồ sơ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-cog me-2"></i>
                                            Cài đặt
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            Đăng xuất
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('admin/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Toggle sidebar
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
            // Toggle dropdown menu với hiệu ứng mượt mà
            $('.dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                const target = $(this).attr('href');
                if (!$(target).hasClass('show')) {
                    $('.collapse.show').not(target).removeClass('show');
                    $('.dropdown-toggle[aria-expanded="true"]').not(this).attr('aria-expanded', 'false');
                }
                $(target).toggleClass('show');
                const isExpanded = $(target).hasClass('show');
                $(this).attr('aria-expanded', isExpanded ? 'true' : 'false');
            });
        });
    </script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
