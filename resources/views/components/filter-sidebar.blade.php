<!-- Filter Sidebar Component -->
<div class="filter-sidebar {{ $show ?? false ? 'show' : '' }}" id="filterSidebar">
    <div class="filter-content">
        <div class="filter-header">
            <h3>Bộ lọc</h3>
            <button class="filter-close" id="filterClose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Search Box -->
        <div class="filter-search">
            <div class="search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Tìm địa điểm" class="filter-search-input" id="filterSearchInput">
            </div>
        </div>

        <!-- Filter Pills -->
        <div class="filter-pills-container">
            <button class="filter-pill-item active" data-filter="all">Tất cả</button>
            <button class="filter-pill-item" data-filter="nearby">Gần đây</button>
            
            @if(request()->routeIs('dining'))
            <!-- Dining specific pills -->
            <button class="filter-pill-item" data-filter="cheap">< 50k</button>
            <button class="filter-pill-item" data-filter="snack">Ăn vặt</button>
            <button class="filter-pill-item" data-filter="stylish">Có gu</button>
            <button class="filter-pill-item" data-filter="cool">Mát mẻ</button>
            @elseif(request()->routeIs('lodging'))
            <!-- Lodging specific pills -->
            <button class="filter-pill-item" data-filter="homestay">Homestay</button>
            <button class="filter-pill-item" data-filter="hotel">Khách sạn</button>
            <button class="filter-pill-item" data-filter="apartment">Căn hộ</button>
            <button class="filter-pill-item" data-filter="view">View đẹp</button>
            @endif
        </div>

        <!-- Sorting Options -->
        <div class="filter-section">
            <h4>Sắp xếp theo</h4>
            <div class="sort-options">
                <button class="sort-button active" data-sort="latest">Mới nhất</button>
                <button class="sort-button" data-sort="price_asc">Giá tăng dần</button>
                <button class="sort-button" data-sort="price_desc">Giá giảm dần</button>
                <button class="sort-button" data-sort="rating_desc">Đánh giá cao</button>
            </div>
        </div>

        <!-- Filter Sections -->
        <div class="filter-sections">
            <!-- Price Range - Different for dining and lodging -->
            <div class="filter-section">
                <h4>Khoảng Giá</h4>
                <div class="price-range-buttons">
                    @if(request()->routeIs('dining'))
                    <!-- Dining prices -->
                    <button class="price-button" data-price="50">< 50k</button>
                    <button class="price-button" data-price="100">50k-100k</button>
                    <button class="price-button" data-price="101">>100k</button>
                    @elseif(request()->routeIs('lodging'))
                    <!-- Lodging prices -->
                    <button class="price-button" data-price="budget">Tiết kiệm</button>
                    <button class="price-button" data-price="mid">Trung bình</button>
                    <button class="price-button" data-price="luxury">Cao cấp</button>
                    @endif
                </div>
            </div>

            <!-- Style - Different for dining and lodging -->
            <div class="filter-section">
                <h4>Phong Cách</h4>
                <div class="style-buttons">
                    @if(request()->routeIs('dining'))
                    <!-- Dining styles -->
                    <button class="style-button" data-style="cotam">
                        <i class="far fa-heart"></i> Có Tâm
                    </button>
                    <button class="style-button" data-style="family">
                        <i class="fas fa-users"></i> Gia đình
                    </button>
                    <button class="style-button" data-style="romantic">
                        <i class="fas fa-heart"></i> Lãng mạn
                    </button>
                    <button class="style-button" data-style="groups">
                        <i class="fas fa-users"></i> Nhóm bạn
                    </button>
                    @elseif(request()->routeIs('lodging'))
                    <!-- Lodging styles -->
                    <button class="style-button" data-style="modern">
                        <i class="fas fa-building"></i> Hiện đại
                    </button>
                    <button class="style-button" data-style="traditional">
                        <i class="fas fa-home"></i> Truyền thống
                    </button>
                    <button class="style-button" data-style="luxury">
                        <i class="fas fa-crown"></i> Sang trọng
                    </button>
                    <button class="style-button" data-style="cozy">
                        <i class="fas fa-couch"></i> Ấm cúng
                    </button>
                    @endif
                </div>
            </div>

            <!-- Amenities section for lodging only -->
            @if(request()->routeIs('lodging'))
            <div class="filter-section">
                <h4>Tiện nghi</h4>
                <div class="amenities-options">
                    <button class="amenity-button" data-amenity="wifi">
                        <i class="fas fa-wifi"></i> Wifi
                    </button>
                    <button class="amenity-button" data-amenity="pool">
                        <i class="fas fa-swimming-pool"></i> Hồ bơi
                    </button>
                    <button class="amenity-button" data-amenity="parking">
                        <i class="fas fa-parking"></i> Đỗ xe
                    </button>
                    <button class="amenity-button" data-amenity="kitchen">
                        <i class="fas fa-utensils"></i> Bếp
                    </button>
                    <button class="amenity-button" data-amenity="ac">
                        <i class="fas fa-snowflake"></i> Điều hòa
                    </button>
                </div>
            </div>
            @endif

            <!-- Location -->
            <div class="filter-section">
                <h4>Vị Trí</h4>
                <div class="location-options">
                    <button class="location-button" data-location="current">
                        <i class="fas fa-map-marker-alt"></i> Vị trí hiện tại
                    </button>
                    <button class="location-button" data-distance="1">1km</button>
                    <button class="location-button" data-distance="3">3km</button>
                    <button class="location-button" data-distance="5">5km</button>
                </div>
            </div>
        </div>

        <div class="filter-buttons">
            <button class="filter-clear">Xóa tất cả</button>
            <button class="filter-apply">Áp dụng</button>
        </div>
    </div>
</div>

<style>
    /* Sort Options */
    .sort-options {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 15px;
    }

    .sort-button {
        background-color: #f0e9d2;
        border: 1px solid #d9c9a3;
        border-radius: 20px;
        padding: 8px 16px;
        font-size: 14px;
        color: #5d4037;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sort-button:hover {
        background-color: #e6ddc4;
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .sort-button.active {
        background-color: #c8b790;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    /* Amenities Options */
    .amenities-options {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .amenity-button {
        background-color: #f0e9d2;
        border: 1px solid #d9c9a3;
        border-radius: 20px;
        padding: 8px 16px;
        font-size: 14px;
        color: #5d4037;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .amenity-button:hover {
        background-color: #e6ddc4;
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .amenity-button.active {
        background-color: #c8b790;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }
    
    .amenity-button i, .sort-button i {
        font-size: 14px;
        transition: transform 0.3s ease;
    }
    
    .amenity-button.active i, .sort-button.active i {
        transform: scale(1.2);
    }

    /* Filter Pills Container */
    .filter-pills-container {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 10px;
        padding: 5px 0 15px 0;
        margin-bottom: 15px;
        border-bottom: 1px solid #e0d8c0;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .filter-pills-container::-webkit-scrollbar {
        display: none;
    }

    .filter-pill-item {
        white-space: nowrap;
        padding: 8px 16px;
        border-radius: 20px;
        border: none;
        background-color: #f0f0f0;
        color: #5d4037;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-pill-item.active {
        background-color: #7a5c2e;
        color: white;
    }

    .filter-pill-item:hover:not(.active) {
        background-color: #e0e0e0;
    }

    /* Filter Sections Styling */
    .filter-sections {
        margin-top: 10px;
    }
</style>
