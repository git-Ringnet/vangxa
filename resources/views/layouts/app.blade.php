<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vangxa.vn - Nhà nghỉ dưỡng cho thuê, Cabin, Nhà trên bãi biển</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    <a href="#" class="nav-link active">Nhà</a>
                    <a href="#" class="nav-link">Trải nghiệm</a>
                </div>

                <!-- Right Menu -->
                <div class="navbar-right">
                    <a href="#" class="host-button">Cho thuê chỗ ở qua Vangxa</a>
                    <button class="globe-button">
                        <i class="fas fa-globe"></i>
                    </button>
                    <div class="user-menu">
                        <button class="menu-button" >
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
                        <input type="text" placeholder="Tìm kiếm điểm đến" class="search-input">
                    </div>
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
                        <button class="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')

    @push('scripts')
    <script>
   

   
    </script>
    @endpush
</body>
</html> 