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
                            <i class="fas fa-bowl-rice"></i>
                        </div>
                        <span class="category-name">Việt Nam</span>
                    </div>
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-fish"></i>
                        </div>
                        <span class="category-name">Nhật Bản</span>
                    </div>
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-pizza-slice"></i>
                        </div>
                        <span class="category-name">Ý</span>
                    </div>
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <span class="category-name">Trung Hoa</span>
                    </div>
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-pepper-hot"></i>
                        </div>
                        <span class="category-name">Hàn Quốc</span>
                    </div>
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-lemon"></i>
                        </div>
                        <span class="category-name">Thái Lan</span>
                    </div>
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-shrimp"></i>
                        </div>
                        <span class="category-name">Hải Sản</span>
                    </div>
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-fire"></i>
                        </div>
                        <span class="category-name">BQQ</span>
                    </div>
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <span class="category-name">Chay</span>
                    </div>
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-cake-candles"></i>
                        </div>
                        <span class="category-name">Bánh Ngọt</span>
                    </div>
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-mug-hot"></i>
                        </div>
                        <span class="category-name">Đồ Uống</span>
                    </div>
                    <div class="category-item">
                        <div class="category-icon">
                            <i class="fas fa-mortar-pestle"></i>
                        </div>
                        <span class="category-name">Fusion</span>
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
                    <h4>Loại nhà hàng</h4>
                    <div class="checkbox-group">
                        <label><input type="checkbox"> Nhà hàng cao cấp</label><br>
                        <label><input type="checkbox"> Quán ăn bình dân</label><br>
                        <label><input type="checkbox"> Đồ ăn đường phố</label>
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
            <div class="listings-grid" id="post-list">
                @include('pages.dining.posts')
            </div>

            <div class="load-more">
                <h4>Tiếp tục khám phá ẩm thực</h4>
                <button class="load-more-button" id="loadMoreButton">
                    Hiển thị thêm
                </button>
            </div>
        </section>
    </div>
@endsection
<script>
    function searchComponent() {
            return {
                query: '',
                search() {
                    fetch(`/search/dining?search=${this.query}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('post-list').innerHTML = data.html;
                        })
                        .catch(err => console.error(err));
                }
            }
        }
    // Define carousel navigation functions in global scope
    window.prevImage = function(button) {
        const carousel = button.closest('.image-carousel');
        const images = carousel.querySelector('.carousel-images');
        const dots = carousel.querySelectorAll('.dot');
        let currentIndex = parseInt(images.dataset.currentIndex || 0);
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel(images, dots, currentIndex);
        }
    };

    window.nextImage = function(button) {
        const carousel = button.closest('.image-carousel');
        const images = carousel.querySelector('.carousel-images');
        const dots = carousel.querySelectorAll('.dot');
        let currentIndex = parseInt(images.dataset.currentIndex || 0);
        const maxIndex = images.children.length - 1;
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateCarousel(images, dots, currentIndex);
        }
    };

    // Helper function for carousel update
    function updateCarousel(images, dots, index) {
        images.dataset.currentIndex = index;
        const percentage = (index * (100 / images.children.length));
        images.style.transform = `translateX(-${percentage}%)`;
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOMContentLoaded fired for dining.blade.php'); // Debug: Confirm single execution

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

        // Load more functionality
        const loadMoreButton = document.getElementById('loadMoreButton');
        const listingsGrid = document.querySelector('.listings-grid');
        let offset = 30; // Initial offset
        let isLoading = false;

        loadMoreButton.addEventListener('click', function() {
            if (isLoading) return;

            isLoading = true;
            this.classList.add('loading');

            fetch(`{{ route('dining.load-more') }}?offset=${offset}`, {
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

                    // Update offset for next request
                    offset = data.nextOffset;

                    // Hide button if no more posts
                    if (!data.hasMore) {
                        loadMoreButton.style.display = 'none';
                    }

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

        // Kiểm tra và hiển thị thông báo từ session
        @if (session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif
        @if ($errors->any())
            showToast("{{ $errors->first() }}", 'error');
        @endif

        function initializeCarousels(container = document) {
            container.querySelectorAll('.image-carousel').forEach(carousel => {
                const dots = carousel.querySelectorAll('.dot');
                const images = carousel.querySelector('.carousel-images');
                const imageCount = images.children.length;
                images.style.width = `${imageCount * 100}%`;
                Array.from(images.children).forEach(img => {
                    img.style.width = `${100 / imageCount}%`;
                });
                images.dataset.currentIndex = 0;
                dots.forEach((dot, index) => {
                    dot.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        updateCarousel(images, dots, index);
                    });
                });
                const navButtons = carousel.querySelectorAll('.carousel-nav');
                navButtons.forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });
            });
        }
    });
</script>
