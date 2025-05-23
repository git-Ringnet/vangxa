@extends('layouts.main')
@stack('scripts')

@section('content')
    <div class="container-custom">
        <!-- Filter Controls -->
        <div class="filter-controls">
            <button class="filter-button my-2" id="filterButton" onclick="openFilter()">
                <i class="fas fa-sliders"></i>
                <span>Bộ lọc</span>
            </button>
        </div>

        <!-- Filter Sidebar -->
        @include('components.filter-sidebar')

        <!-- Overlay for Filter -->
        <div class="filter-overlay" id="filterOverlay" onclick="closeFilter()"></div>

        <!-- Listings -->
        <section class="listings-section">
            <div class="listings-grid" id="post-list">
                @if(count($posts) > 0)
                    @include('pages.listings.posts')
                @else
                    <div class="no-results">
                        <i class="fas fa-search"></i> Không tìm thấy kết quả phù hợp với bộ lọc của bạn.
                    </div>
                @endif
            </div>

            <div class="load-more">
                <button class="load-more-button" id="loadMoreButton" style="display: none;" data-load-more-offset="30" data-lodging-load-more="{{ route('lodging.load-more') }}">
                    Hiển thị thêm
                </button>
            </div>
        </section>
    </div>
@endsection

<style>
    .filter-controls {
        display: flex;
        justify-content: flex-end;
    }
    
    .filter-button {
        display: flex;
        align-items: center;
        gap: 8px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 8px 16px;
        font-size: 14px;
        color: #555;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .filter-button:hover {
        background-color: #f8f8f8;
    }
</style>

<script>
    // Filter Functions
    function openFilter() {
        console.log("Opening filter");
        const filterSidebar = document.getElementById('filterSidebar');
        const filterOverlay = document.getElementById('filterOverlay');
        const filterControls = document.querySelector('.filter-controls');
        
        // Show overlay first
        filterOverlay.style.display = 'block';
        
        // Force reflow to ensure transition works
        void filterOverlay.offsetWidth;
        
        // Start overlay fade-in animation
        filterOverlay.style.opacity = '1';
        
        // Show sidebar
        setTimeout(() => {
            filterSidebar.style.visibility = 'visible';
            filterSidebar.classList.add('show');
            
            // Store current scroll position
            const scrollY = window.scrollY;
            
            // Calculate scrollbar width
            const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
            
            // Apply fixed position without layout shift
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollY}px`;
            document.body.style.width = '100%';
            document.body.style.overflow = 'hidden';
            
            // Compensate for scrollbar width to prevent layout shift
            if (scrollbarWidth > 0) {
                document.body.style.paddingRight = scrollbarWidth + 'px';
                
                // Also apply to filter controls to prevent button misalignment
                if (filterControls) {
                    filterControls.style.paddingRight = scrollbarWidth + 'px';
                }
            }
        }, 100);
    }
    
    function closeFilter() {
        console.log("Closing filter");
        const filterSidebar = document.getElementById('filterSidebar');
        const filterOverlay = document.getElementById('filterOverlay');
        const filterControls = document.querySelector('.filter-controls');
        
        // Start sidebar closing animation
        filterSidebar.classList.remove('show');
        
        // Restore scrolling without layout shift
        const scrollY = parseInt(document.body.style.top || '0');
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.width = '';
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Reset padding on filter controls as well
        if (filterControls) {
            filterControls.style.paddingRight = '';
        }
        
        window.scrollTo(0, -scrollY);
        
        // Start overlay fade-out animation
        filterOverlay.style.opacity = '0';
        
        // Wait for animation to complete
        setTimeout(() => {
            filterOverlay.style.display = 'none';
            filterSidebar.style.visibility = 'hidden';
        }, 300);
    }

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
    
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure scrolling is always enabled
        function restoreScrolling() {
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.width = '';
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            document.body.classList.remove('no-scroll-but-keep-bar');
        }
        
        // Call immediately when page loads
        restoreScrolling();
        
        // Also call after any AJAX request completes
        document.addEventListener('ajaxComplete', restoreScrolling);
        
        // Initialize carousels
        initializeCarousels();
        
        // Setup close button for filter
        const filterClose = document.getElementById('filterClose');
        if (filterClose) {
            filterClose.addEventListener('click', closeFilter);
        }
        
        const loadMoreButton = document.getElementById('loadMoreButton');
        const listingsGrid = document.querySelector('.listings-grid');
        
        // Define global variables if they don't exist
        window.isLoading = window.isLoading || false;
        window.offset = window.offset || 30;

        loadMoreButton.addEventListener('click', function() {
            if (window.isLoading) return;

            window.isLoading = true;
            this.classList.add('loading');

            // Use the correct endpoint for lodging
            fetch(`/lodging/load-more?offset=${window.offset}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
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
                    window.offset = data.nextOffset;

                    // Hide button if no more posts
                    if (!data.hasMore) {
                        loadMoreButton.style.display = 'none';
                    }

                    window.isLoading = false;
                    loadMoreButton.classList.remove('loading');

                    // Reinitialize carousels for new posts
                    initializeCarousels();

                    // Update distances for new posts
                    console.log('Load more completed, updating distances for new posts...');
                    setTimeout(function() {
                        if (typeof updateDistances === 'function') {
                            updateDistances();
                        } else {
                            console.error('updateDistances function not found');
                        }
                    }, 500);
                })
                .catch(error => {
                    console.error('Error loading more posts:', error);
                    window.isLoading = false;
                    loadMoreButton.classList.remove('loading');
                    
                    // Log detailed information for debugging
                    console.log('Fetch URL was:', `/lodging/load-more?offset=${window.offset}`);
                    
                    // Display error message to user
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'load-more-error';
                    errorMsg.innerHTML = 'Có lỗi xảy ra khi tải thêm kết quả. Vui lòng thử lại sau.';
                    loadMoreButton.parentNode.insertBefore(errorMsg, loadMoreButton);
                    
                    // Remove error message after 5 seconds
                    setTimeout(() => {
                        errorMsg.style.opacity = '0';
                        setTimeout(() => errorMsg.remove(), 500);
                    }, 5000);
                });
        });

        // Check if there are posts and if hasMore is true
        const postCards = document.querySelectorAll('.listing-card');
        const hasMore = {{ isset($hasMore) ? ($hasMore ? 'true' : 'false') : 'false' }};
        
        // Only show the load more button if we have posts and hasMore is true
        if (postCards.length > 0 && hasMore) {
            loadMoreButton.style.display = 'block';
        } else {
            loadMoreButton.style.display = 'none';
        }
    });
</script>
