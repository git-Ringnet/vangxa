@extends('layouts.main')
@stack('scripts')

@section('content')
    <div class="container-custom">
        <!-- Search Bar & Filter Pills -->
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

        <!-- Listings Grid -->
        <section class="listings-section">
            <div class="listings-grid" id="post-list">
                @if(count($posts) > 0)
                    @include('pages.dining.posts')
                @else
                    <div class="no-results">
                        <i class="fas fa-search"></i> Không tìm thấy kết quả phù hợp với bộ lọc của bạn.
                    </div>
                @endif
            </div>

            <div class="load-more">
                <button class="load-more-button" id="loadMoreButton" style="display: none;" data-dining-load-more="{{ route('dining.load-more') }}">
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
    
    .search-filter-section {
        background-color: #faf6e9;
        border-radius: 12px;
        padding: 15px;
    }
    
    .search-bar-container {
        width: 100%;
    }
    
    .search-input-wrapper {
        position: relative;
        width: 100%;
    }
    
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #8d6e63;
    }
    
    .search-input {
        width: 100%;
        padding: 12px 20px 12px 45px;
        border-radius: 30px;
        border: 1px solid #e0e0e0;
        background-color: white;
        font-size: 16px;
        outline: none;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        border-color: #7a5c2e;
        box-shadow: 0 0 0 2px rgba(122, 92, 46, 0.1);
    }
    
    .filter-pills-container {
        display: flex;
        overflow-x: auto;
        gap: 10px;
        padding: 10px 0;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    .filter-pills-container::-webkit-scrollbar {
        display: none;
    }
    
    .filter-pill {
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
    
    .filter-pill.active {
        background-color: #7a5c2e;
        color: white;
    }
    
    .filter-pill:hover:not(.active) {
        background-color: #e0e0e0;
    }
    
    .filter-button {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 8px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 6px 16px;
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
        
        // Get references to key elements on the page
        const postCards = document.querySelectorAll('.listing-card');
        const hasMore = {{ isset($hasMore) ? ($hasMore ? 'true' : 'false') : 'false' }};
        const loadMoreButton = document.getElementById('loadMoreButton');
        const listingsGrid = document.querySelector('.listings-grid');
        
        // Define global variables if they don't exist
        window.isLoading = window.isLoading || false;
        window.offset = window.offset || 30;
        
        // Only show the load more button if we have posts and hasMore is true
        if (postCards.length > 0 && hasMore) {
            loadMoreButton.style.display = 'block';
        } else {
            loadMoreButton.style.display = 'none';
        }

        loadMoreButton.addEventListener('click', function() {
            if (window.isLoading) return;

            window.isLoading = true;
            this.classList.add('loading');

            fetch(`{{ route('dining.load-more') }}?offset=${window.offset}`, {
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

                    // Hide button if no more posts or if no HTML was returned
                    if (!data.hasMore || !data.html || data.html.trim() === '') {
                        loadMoreButton.style.display = 'none';
                    }

                    window.isLoading = false;
                    loadMoreButton.classList.remove('loading');

                    // Reinitialize carousels for new posts
                    if (typeof initializeCarousels === 'function') {
                        initializeCarousels();
                    }

                    // Update distances for new posts
                    setTimeout(function() {
                        if (typeof updateDistances === 'function') {
                            updateDistances();
                        }
                    }, 500);
                })
                .catch(error => {
                    console.error('Error loading more posts:', error);
                    window.isLoading = false;
                    loadMoreButton.classList.remove('loading');
                    
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
    });
</script>
