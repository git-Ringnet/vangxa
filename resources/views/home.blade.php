@extends('layouts.app')
@stack('scripts')

@section('content')
<div class="container-custom">
    <!-- Categories -->
    <section class="categories-section">
        <div class="categories-wrapper">
            <button class="categories-nav-button prev" id="prevButton" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="categories-container" id="categoriesContainer">
                <div class="category-item active">
                    <div class="category-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="category-name">Nhà</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-mountain"></i>
                    </div>
                    <span class="category-name">Cabin</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-umbrella-beach"></i>
                    </div>
                    <span class="category-name">Bãi biển</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-swimming-pool"></i>
                    </div>
                    <span class="category-name">Hồ bơi</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-campground"></i>
                    </div>
                    <span class="category-name">Cắm trại</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-tree"></i>
                    </div>
                    <span class="category-name">Công viên</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-city"></i>
                    </div>
                    <span class="category-name">Thành phố</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <span class="category-name">Ven hồ</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-skiing"></i>
                    </div>
                    <span class="category-name">Trượt tuyết</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-island-tropical"></i>
                    </div>
                    <span class="category-name">Đảo</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <span class="category-name">Ven hồ</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-skiing"></i>
                    </div>
                    <span class="category-name">Trượt tuyết</span>
                </div>   <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <span class="category-name">Ven hồ</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-skiing"></i>
                    </div>
                    <span class="category-name">Trượt tuyết</span>
                </div>   <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <span class="category-name">Ven hồ</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-skiing"></i>
                    </div>
                    <span class="category-name">Trượt tuyết</span>
                </div>   <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <span class="category-name">Ven hồ</span>
                </div>
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-skiing"></i>
                    </div>
                    <span class="category-name">Trượt tuyết</span>
                </div>
            </div>
            <button class="categories-nav-button next" id="nextButton">
                <i class="fas fa-chevron-right"></i>
            </button>
            
        </div>
        <button class="filter-button" id="filterButton">
                <i class="fas fa-sliders"></i>
                <span>Bộ lọc</span>
            </button>
    </section>

    <!-- Filter Modal -->
    <div class="filter-modal" id="filterModal">
        <div class="filter-content">
            <div class="filter-header">
                <h3>Bộ lọc</h3>
                <button class="filter-close" id="filterClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="filter-section">
                <h4>Khoảng giá</h4>
                <div class="price-range">
                    <input type="number" class="price-input" placeholder="Giá tối thiểu">
                    <input type="number" class="price-input" placeholder="Giá tối đa">
                </div>
            </div>
            <div class="filter-section">
                <h4>Loại chỗ ở</h4>
                <div class="checkbox-group">
                    <label><input type="checkbox"> Nhà nguyên căn</label><br>
                    <label><input type="checkbox"> Phòng riêng</label><br>
                    <label><input type="checkbox"> Phòng chung</label>
                </div>
            </div>
            <div class="filter-buttons">
                <button class="filter-clear">Xóa tất cả</button>
                <button class="filter-apply">Áp dụng</button>
            </div>
        </div>
    </div>

    <!-- Listings -->
    <section class="listings-section">
        <div class="listings-grid">
            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/134475469.jpg?k=986e0385365fa9e17ef6497e2fb7d5e16552358ad343c4ad8fc35b29802eacac&o=&hp=1" alt="Căn hộ sang trọng tại trung tâm" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Căn hộ sang trọng tại trung tâm</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.96</span>
                        </div>
                    </div>
                    <p class="listing-location">Quận 1, Hồ Chí Minh</p>
                    <p class="listing-dates">22-27 tháng 5</p>
                    <p class="listing-price">
                        <span class="price-amount">2,000,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>

            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Biệt thự ven biển" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Biệt thự ven biển</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.89</span>
                        </div>
                    </div>
                    <p class="listing-location">Nha Trang, Khánh Hòa</p>
                    <p class="listing-dates">1-7 tháng 6</p>
                    <p class="listing-price">
                        <span class="price-amount">3,500,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>

            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/134475469.jpg?k=986e0385365fa9e17ef6497e2fb7d5e16552358ad343c4ad8fc35b29802eacac&o=&hp=1" alt="Căn hộ sang trọng tại trung tâm" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Căn hộ sang trọng tại trung tâm</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.96</span>
                        </div>
                    </div>
                    <p class="listing-location">Quận 1, Hồ Chí Minh</p>
                    <p class="listing-dates">22-27 tháng 5</p>
                    <p class="listing-price">
                        <span class="price-amount">2,000,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>

            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Biệt thự ven biển" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Biệt thự ven biển</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.89</span>
                        </div>
                    </div>
                    <p class="listing-location">Nha Trang, Khánh Hòa</p>
                    <p class="listing-dates">1-7 tháng 6</p>
                    <p class="listing-price">
                        <span class="price-amount">3,500,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>
            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/134475469.jpg?k=986e0385365fa9e17ef6497e2fb7d5e16552358ad343c4ad8fc35b29802eacac&o=&hp=1" alt="Căn hộ sang trọng tại trung tâm" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Căn hộ sang trọng tại trung tâm</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.96</span>
                        </div>
                    </div>
                    <p class="listing-location">Quận 1, Hồ Chí Minh</p>
                    <p class="listing-dates">22-27 tháng 5</p>
                    <p class="listing-price">
                        <span class="price-amount">2,000,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>

            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Biệt thự ven biển" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Biệt thự ven biển</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.89</span>
                        </div>
                    </div>
                    <p class="listing-location">Nha Trang, Khánh Hòa</p>
                    <p class="listing-dates">1-7 tháng 6</p>
                    <p class="listing-price">
                        <span class="price-amount">3,500,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>
            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/134475469.jpg?k=986e0385365fa9e17ef6497e2fb7d5e16552358ad343c4ad8fc35b29802eacac&o=&hp=1" alt="Căn hộ sang trọng tại trung tâm" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Căn hộ sang trọng tại trung tâm</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.96</span>
                        </div>
                    </div>
                    <p class="listing-location">Quận 1, Hồ Chí Minh</p>
                    <p class="listing-dates">22-27 tháng 5</p>
                    <p class="listing-price">
                        <span class="price-amount">2,000,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>

            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Biệt thự ven biển" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Biệt thự ven biển</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.89</span>
                        </div>
                    </div>
                    <p class="listing-location">Nha Trang, Khánh Hòa</p>
                    <p class="listing-dates">1-7 tháng 6</p>
                    <p class="listing-price">
                        <span class="price-amount">3,500,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>
            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/134475469.jpg?k=986e0385365fa9e17ef6497e2fb7d5e16552358ad343c4ad8fc35b29802eacac&o=&hp=1" alt="Căn hộ sang trọng tại trung tâm" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Căn hộ sang trọng tại trung tâm</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.96</span>
                        </div>
                    </div>
                    <p class="listing-location">Quận 1, Hồ Chí Minh</p>
                    <p class="listing-dates">22-27 tháng 5</p>
                    <p class="listing-price">
                        <span class="price-amount">2,000,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>

            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Biệt thự ven biển" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Biệt thự ven biển</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.89</span>
                        </div>
                    </div>
                    <p class="listing-location">Nha Trang, Khánh Hòa</p>
                    <p class="listing-dates">1-7 tháng 6</p>
                    <p class="listing-price">
                        <span class="price-amount">3,500,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>
            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/134475469.jpg?k=986e0385365fa9e17ef6497e2fb7d5e16552358ad343c4ad8fc35b29802eacac&o=&hp=1" alt="Căn hộ sang trọng tại trung tâm" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Căn hộ sang trọng tại trung tâm</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.96</span>
                        </div>
                    </div>
                    <p class="listing-location">Quận 1, Hồ Chí Minh</p>
                    <p class="listing-dates">22-27 tháng 5</p>
                    <p class="listing-price">
                        <span class="price-amount">2,000,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>

            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Biệt thự ven biển" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Biệt thự ven biển</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.89</span>
                        </div>
                    </div>
                    <p class="listing-location">Nha Trang, Khánh Hòa</p>
                    <p class="listing-dates">1-7 tháng 6</p>
                    <p class="listing-price">
                        <span class="price-amount">3,500,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>
            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/134475469.jpg?k=986e0385365fa9e17ef6497e2fb7d5e16552358ad343c4ad8fc35b29802eacac&o=&hp=1" alt="Căn hộ sang trọng tại trung tâm" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Căn hộ sang trọng tại trung tâm</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.96</span>
                        </div>
                    </div>
                    <p class="listing-location">Quận 1, Hồ Chí Minh</p>
                    <p class="listing-dates">22-27 tháng 5</p>
                    <p class="listing-price">
                        <span class="price-amount">2,000,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>

            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Biệt thự ven biển" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Biệt thự ven biển</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.89</span>
                        </div>
                    </div>
                    <p class="listing-location">Nha Trang, Khánh Hòa</p>
                    <p class="listing-dates">1-7 tháng 6</p>
                    <p class="listing-price">
                        <span class="price-amount">3,500,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>   <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/134475469.jpg?k=986e0385365fa9e17ef6497e2fb7d5e16552358ad343c4ad8fc35b29802eacac&o=&hp=1" alt="Căn hộ sang trọng tại trung tâm" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Căn hộ sang trọng tại trung tâm</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.96</span>
                        </div>
                    </div>
                    <p class="listing-location">Quận 1, Hồ Chí Minh</p>
                    <p class="listing-dates">22-27 tháng 5</p>
                    <p class="listing-price">
                        <span class="price-amount">2,000,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>

            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Biệt thự ven biển" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Biệt thự ven biển</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.89</span>
                        </div>
                    </div>
                    <p class="listing-location">Nha Trang, Khánh Hòa</p>
                    <p class="listing-dates">1-7 tháng 6</p>
                    <p class="listing-price">
                        <span class="price-amount">3,500,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>   <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/134475469.jpg?k=986e0385365fa9e17ef6497e2fb7d5e16552358ad343c4ad8fc35b29802eacac&o=&hp=1" alt="Căn hộ sang trọng tại trung tâm" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Căn hộ sang trọng tại trung tâm</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.96</span>
                        </div>
                    </div>
                    <p class="listing-location">Quận 1, Hồ Chí Minh</p>
                    <p class="listing-dates">22-27 tháng 5</p>
                    <p class="listing-price">
                        <span class="price-amount">2,000,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>

            <a href="{{ route('detail') }}" class="listing-card">
                <div class="listing-image-container">
                    <img src="https://plus.unsplash.com/premium_photo-1682377521753-58d1fd9fa5ce?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bHV4dXJ5JTIwdmlsbGF8ZW58MHx8MHx8fDA%3D" alt="Biệt thự ven biển" class="listing-image">
                    <button class="favorite-button" onclick="event.preventDefault(); toggleFavorite(this);">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="listing-content">
                    <div class="listing-header">
                        <h3 class="listing-title">Biệt thự ven biển</h3>
                        <div class="listing-rating">
                            <i class="fas fa-star"></i>
                            <span>4.89</span>
                        </div>
                    </div>
                    <p class="listing-location">Nha Trang, Khánh Hòa</p>
                    <p class="listing-dates">1-7 tháng 6</p>
                    <p class="listing-price">
                        <span class="price-amount">3,500,000₫</span>
                        <span class="price-period">đêm</span>
                    </p>
                </div>
            </a>
        </div>

        <div class="load-more">
            <h4>Tiếp tục khám phá danh mục phòng</h4>
            <button class="load-more-button">
                Hiển thị thêm
            </button>
        </div>
    </section>
</div>
@endsection 

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('categoriesContainer');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    const filterButton = document.getElementById('filterButton');
    const filterModal = document.getElementById('filterModal');
    const filterClose = document.getElementById('filterClose');

    // Categories navigation
    let scrollPosition = 0;
    const scrollAmount = 200;

    function updateButtonStates() {
        prevButton.disabled = scrollPosition <= 0;
        nextButton.disabled = scrollPosition >= container.scrollWidth - container.clientWidth;
    }

    prevButton.addEventListener('click', () => {
        scrollPosition = Math.max(0, scrollPosition - scrollAmount);
        container.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
        });
        updateButtonStates();
    });

    nextButton.addEventListener('click', () => {
        scrollPosition = Math.min(
            container.scrollWidth - container.clientWidth,
            scrollPosition + scrollAmount
        );
        container.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
        });
        updateButtonStates();
    });

    // Filter modal
    filterButton.addEventListener('click', () => {
        filterModal.classList.add('show');
    });

    filterClose.addEventListener('click', () => {
        filterModal.classList.remove('show');
    });

    filterModal.addEventListener('click', (e) => {
        if (e.target === filterModal) {
            filterModal.classList.remove('show');
        }
    });

    // Category item click
    const categoryItems = document.querySelectorAll('.category-item');
    categoryItems.forEach(item => {
        item.addEventListener('click', () => {
            categoryItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
        });
    });

    // Initial button states
    updateButtonStates();
});

function toggleFavorite(button) {
    button.querySelector('i').style.color = 
        button.querySelector('i').style.color === 'red' ? 'white' : 'red';
}
</script>
@endpush 