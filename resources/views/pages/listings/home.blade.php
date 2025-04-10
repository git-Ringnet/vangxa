@extends('layouts.main')
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
            @include('pages.listings.posts', ['posts' => $posts])
        </div>

        <div class="load-more">
            <h4>Tiếp tục khám phá danh mục phòng</h4>
            <button class="load-more-button" id="loadMoreButton">
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

        // Initialize all carousels
        initializeCarousels();
    });

    function toggleFavorite(button) {
        button.querySelector('i').style.color =
            button.querySelector('i').style.color === 'red' ? 'white' : 'red';
    }

    function prevImage(button) {
        const carousel = button.closest('.image-carousel');
        const images = carousel.querySelector('.carousel-images');
        const dots = carousel.querySelectorAll('.dot');
        let currentIndex = parseInt(images.dataset.currentIndex || 0);

        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel(images, dots, currentIndex);
        }
    }

    function nextImage(button) {
        const carousel = button.closest('.image-carousel');
        const images = carousel.querySelector('.carousel-images');
        const dots = carousel.querySelectorAll('.dot');
        let currentIndex = parseInt(images.dataset.currentIndex || 0);
        const maxIndex = images.children.length - 1;

        if (currentIndex < maxIndex) {
            currentIndex++;
            updateCarousel(images, dots, currentIndex);
        }
    }

    function updateCarousel(images, dots, index) {
        // Update data attribute
        images.dataset.currentIndex = index;

        // Calculate the correct percentage based on number of images
        const percentage = (index * (100 / images.children.length));

        // Apply transform
        images.style.transform = `translateX(-${percentage}%)`;

        // Update dots
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }
    // Hàm khởi tạo các carousel (bộ sưu tập hình ảnh) trên trang
    function initializeCarousels() {
        const carousels = document.querySelectorAll('.image-carousel');

        carousels.forEach(carousel => {
            const dots = carousel.querySelectorAll('.dot');
            const images = carousel.querySelector('.carousel-images');
            // Đếm số lượng hình ảnh trong carousel
            const imageCount = images.children.length;

            // Set correct width for the carousel images container based on number of images
            images.style.width = `${imageCount * 100}%`;

            // Thiết lập chiều rộng cho từng hình ảnh bên trong container
            Array.from(images.children).forEach(img => {
                img.style.width = `${100 / imageCount}%`;
            });

            // Set initial index
            images.dataset.currentIndex = 0;

            // Add click events to dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    updateCarousel(images, dots, index);
                });
            });

            // Prevent carousel navigation from triggering card click
            const navButtons = carousel.querySelectorAll('.carousel-nav');
            navButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                });
            });
        });
    }
    document.addEventListener('DOMContentLoaded', function () {
        const loadMoreButton = document.getElementById('loadMoreButton');
        const listingsGrid = document.querySelector('.listings-grid');
        let offset = 18;
        let isLoading = false;

        loadMoreButton.addEventListener('click', function () {
            if (isLoading) return;
            
            isLoading = true;
            this.classList.add('loading');
            
            fetch(`/load-more?offset=${offset}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.html) {
                    listingsGrid.insertAdjacentHTML('beforeend', data.html);
                }
                
                if (!data.hasMore) {
                    loadMoreButton.style.display = 'none';
                }
                
                offset += 18;
                isLoading = false;
                loadMoreButton.classList.remove('loading');
                
                // Reinitialize carousels for new posts
                initializeCarousels();
            })
            .catch(error => {
                console.error('Error loading more posts:', error);
                isLoading = false;
                loadMoreButton.classList.remove('loading');
            });
        });
    });
   
</script>
@endpush