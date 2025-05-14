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
            <button class="filter-pill-item" data-filter="cheap">
                < 50k </button>
                    <button class="filter-pill-item" data-filter="snack">Ăn vặt</button>
                    <button class="filter-pill-item" data-filter="stylish">Có gu</button>
                    <button class="filter-pill-item" data-filter="cool">Mát mẻ</button>
        </div>

        <!-- Filter Sections -->
        <div class="filter-sections">
            <!-- Price Range -->
            <div class="filter-section">
                <h4>Khoảng Giá</h4>
                <div class="price-range-buttons">
                    <button class="price-button" data-price="50"> < 50k </button>
                    <button class="price-button" data-price="100">50k-100k</button>
                    <button class="price-button" data-price="101">>100k</button>
                </div>
            </div>

            <!-- Style -->
            <div class="filter-section">
                <h4>Phong Cách</h4>
                <div class="style-buttons">
                    <button class="style-button" data-style="cotam">
                        <i class="far fa-heart"></i> Có Tâm
                    </button>
                    <button class="style-button" data-style="family">
                        <i class="fas fa-users"></i> Family-Friendly
                    </button>
                </div>
            </div>

            <!-- Location -->
            <div class="filter-section">
                <h4>Vị Trí</h4>
                <div class="location-options">
                    <button class="location-button" data-location="current">
                        <i class="fas fa-map-marker-alt"></i> Current Location
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
