// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const filterButton = document.getElementById('filterButton');
    const filterSidebar = document.getElementById('filterSidebar');
    const filterClose = document.getElementById('filterClose');
    const filterOverlay = document.getElementById('filterOverlay');
    const filterClear = document.querySelector('.filter-clear');
    const filterApply = document.querySelector('.filter-apply');
    const filterSearchInput = document.getElementById('filterSearchInput');
    const loadMoreButton = document.getElementById('loadMoreButton');
    
    // Filter buttons
    const priceButtons = document.querySelectorAll('.price-button');
    const styleButtons = document.querySelectorAll('.style-button');
    const locationButtons = document.querySelectorAll('.location-button');
    const filterPillItems = document.querySelectorAll('.filter-pill-item');
    const sortButtons = document.querySelectorAll('.sort-button');
    const amenityButtons = document.querySelectorAll('.amenity-button');
    const trustButtons = document.querySelectorAll('.trust-button');
    
    // Current page type
    const isDining = window.location.pathname.includes('/dining');
    const isLodging = window.location.pathname.includes('/lodging');
    
    // Active filters
    let activeFilters = {
        search: '',
        price: null,
        style: [],
        location: null,
        distance: null,
        amenities: [],
        trust: null,
        sort: 'latest',
        quickFilter: 'all' // Default quick filter is 'all'
    };
    
    // Default filter state (to compare for changes)
    const defaultFilters = {
        search: '',
        price: null,
        style: [],
        location: null,
        distance: null,
        amenities: [],
        trust: null,
        sort: 'latest',
        quickFilter: 'all'
    };
    
    // Store original scrollbar width and position
    let scrollbarWidth = 0;
    let scrollY = 0;
    
    // Open filter sidebar with smooth animation
    if (filterButton) {
        filterButton.addEventListener('click', function() {
            openFilter();
        });
    }
    
    function openFilter() {
        // Show overlay
        if (!filterOverlay) {
            // Create overlay if it doesn't exist
            const overlay = document.createElement('div');
            overlay.id = 'filterOverlay';
            overlay.className = 'filter-overlay';
            document.body.appendChild(overlay);
            overlay.addEventListener('click', closeFilter);
            
            // Show overlay
            overlay.style.display = 'block';
            setTimeout(() => {
                overlay.classList.add('show');
            }, 10);
        } else {
            filterOverlay.style.display = 'block';
            setTimeout(() => {
                filterOverlay.classList.add('show');
            }, 10);
        }
        
        // Store current scroll position
        scrollY = window.scrollY;
        
        // Calculate scrollbar width
        scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
        
        // Show sidebar
        filterSidebar.classList.add('show');
        
        // Add special class to body to prevent scroll but keep scrollbar visible
        document.body.classList.add('no-scroll-but-keep-bar');
        document.body.style.top = `-${scrollY}px`;
        
        // Apply padding to body to prevent layout shift
        if (scrollbarWidth > 0) {
            document.body.style.paddingRight = scrollbarWidth + 'px';
            
            // Also adjust navbar if it exists
            const navbar = document.querySelector('.navbar-custom');
            if (navbar) {
                navbar.style.paddingRight = scrollbarWidth + 'px';
            }
            
            // Adjust filter controls
            const filterControls = document.querySelector('.filter-controls');
            if (filterControls) {
                filterControls.style.paddingRight = scrollbarWidth + 'px';
            }
        }
    }
    
    // Close filter sidebar
    function closeFilter() {
        // Start sidebar closing animation
        filterSidebar.classList.remove('show');
        
        // Fade out overlay
        if (filterOverlay) {
            filterOverlay.classList.remove('show');
            setTimeout(() => {
                filterOverlay.style.display = 'none';
            }, 300);
        }
        
        // Remove special body class
        document.body.classList.remove('no-scroll-but-keep-bar');
        document.body.style.paddingRight = '';
        document.body.style.top = '';
        
        // Reset padding on navbar
        const navbar = document.querySelector('.navbar-custom');
        if (navbar) {
            navbar.style.paddingRight = '';
        }
        
        // Reset padding on filter controls
        const filterControls = document.querySelector('.filter-controls');
        if (filterControls) {
            filterControls.style.paddingRight = '';
        }
        
        // Restore scroll position
        window.scrollTo(0, scrollY);
    }
    
    if (filterClose) {
        filterClose.addEventListener('click', closeFilter);
    }
    
    // Check if any filters are active and update apply button
    function checkFiltersActive() {
        const hasActiveFilters = 
            activeFilters.search !== defaultFilters.search ||
            activeFilters.price !== defaultFilters.price ||
            activeFilters.style.length > 0 ||
            activeFilters.location !== defaultFilters.location ||
            activeFilters.distance !== defaultFilters.distance ||
            activeFilters.amenities.length > 0 ||
            activeFilters.trust !== defaultFilters.trust ||
            activeFilters.sort !== defaultFilters.sort ||
            activeFilters.quickFilter !== defaultFilters.quickFilter;
        
        // Toggle active class on apply button
        if (filterApply) {
            if (hasActiveFilters) {
                filterApply.classList.add('active');
            } else {
                filterApply.classList.remove('active');
            }
        }
        
        return hasActiveFilters;
    }
    
    // Toggle button selection with ripple effect
    function toggleButtonSelection(buttons, isMultiSelect = false) {
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                if (isMultiSelect) {
                    // For multi-select buttons like style
                    this.classList.toggle('active');
                } else {
                    // For single-select buttons like price
                    buttons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                }
                
                // Update filters and activate apply button
                updateActiveFilters();
                checkFiltersActive();
            });
        });
    }
    
    // Initialize button selection
    toggleButtonSelection(priceButtons);
    toggleButtonSelection(styleButtons, true);
    toggleButtonSelection(locationButtons);
    toggleButtonSelection(sortButtons);
    toggleButtonSelection(amenityButtons, true);
    toggleButtonSelection(trustButtons);
    
    // Add click handler for filter pill items
    if (filterPillItems.length > 0) {
        filterPillItems.forEach(pill => {
            pill.addEventListener('click', function() {
                // Remove active class from all pills
                filterPillItems.forEach(p => p.classList.remove('active'));
                // Add active class to clicked pill
                this.classList.add('active');
                
                // Set quick filter value
                activeFilters.quickFilter = this.dataset.filter;
                
                // Update filters and activate apply button
                updateActiveFilters();
                checkFiltersActive();
            });
        });
    }
    
    // Handle search input
    if (filterSearchInput) {
        filterSearchInput.addEventListener('input', function() {
            activeFilters.search = this.value.trim();
            checkFiltersActive();
        });
        
        // Handle Enter key in search
        filterSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                updateActiveFilters();
                applyFilters();
            }
        });
        
        // Focus effect
        filterSearchInput.addEventListener('focus', function() {
            this.closest('.search-input-wrapper').classList.add('focused');
        });
        
        filterSearchInput.addEventListener('blur', function() {
            this.closest('.search-input-wrapper').classList.remove('focused');
        });
    }
    
    // Update active filters
    function updateActiveFilters() {
        // Search filter
        activeFilters.search = filterSearchInput ? filterSearchInput.value.trim() : '';
        
        // Price filter
        const activePrice = document.querySelector('.price-button.active');
        activeFilters.price = activePrice ? activePrice.dataset.price : null;
        
        // Style filters
        activeFilters.style = [];
        document.querySelectorAll('.style-button.active').forEach(button => {
            activeFilters.style.push(button.dataset.style);
        });
        
        // Amenity filters
        activeFilters.amenities = [];
        document.querySelectorAll('.amenity-button.active').forEach(button => {
            activeFilters.amenities.push(button.dataset.amenity);
        });
        
        // Location and distance filters
        const activeLocation = document.querySelector('.location-button[data-location].active');
        const activeDistance = document.querySelector('.location-button[data-distance].active');
        activeFilters.location = activeLocation ? activeLocation.dataset.location : null;
        activeFilters.distance = activeDistance ? activeDistance.dataset.distance : null;
        
        // Trust filter
        const activeTrust = document.querySelector('.trust-button.active');
        activeFilters.trust = activeTrust ? activeTrust.dataset.trust : null;
        
        // Sort option
        const activeSort = document.querySelector('.sort-button.active');
        activeFilters.sort = activeSort ? activeSort.dataset.sort : 'latest';
        
        // Quick filter
        const activeQuickFilter = document.querySelector('.filter-pill-item.active');
        activeFilters.quickFilter = activeQuickFilter ? activeQuickFilter.dataset.filter : 'all';
        
        // Check for changes
        checkFiltersActive();
    }
    
    // Clear all filters
    if (filterClear) {
        filterClear.addEventListener('click', function() {
            // Reset search input
            if (filterSearchInput) {
                filterSearchInput.value = '';
            }
            
            // Reset all buttons
            document.querySelectorAll('.price-button.active, .style-button.active, .location-button.active, .amenity-button.active, .trust-button.active').forEach(button => {
                button.classList.remove('active');
            });
            
            // Reset sort buttons but keep the default "latest" active
            document.querySelectorAll('.sort-button.active').forEach(button => {
                button.classList.remove('active');
            });
            document.querySelector('.sort-button[data-sort="latest"]').classList.add('active');
            
            // Reset quick filter pills but keep "all" active
            document.querySelectorAll('.filter-pill-item.active').forEach(pill => {
                pill.classList.remove('active');
            });
            document.querySelector('.filter-pill-item[data-filter="all"]').classList.add('active');
            
            // Reset active filters object
            activeFilters = { ...defaultFilters };
            
            // Update UI
            checkFiltersActive();
            
            // Optional: apply filters immediately after clearing
            // applyFilters();
        });
    }
    
    // Apply filters
    if (filterApply) {
        filterApply.addEventListener('click', function() {
            applyFilters();
        });
    }
    
    function applyFilters() {
        // Close filter sidebar
        closeFilter();
        
        // Update active filters one last time
        updateActiveFilters();
        
        // Build query parameters
        const params = new URLSearchParams();
        
        // Add each filter to query params
        if (activeFilters.search) {
            params.append('search', activeFilters.search);
        }
        
        if (activeFilters.price) {
            params.append('price', activeFilters.price);
        }
        
        if (activeFilters.style.length > 0) {
            activeFilters.style.forEach(style => {
                params.append('style[]', style);
            });
        }
        
        if (activeFilters.amenities.length > 0) {
            activeFilters.amenities.forEach(amenity => {
                params.append('amenities[]', amenity);
            });
        }
        
        if (activeFilters.location) {
            params.append('location', activeFilters.location);
        }
        
        if (activeFilters.distance) {
            params.append('distance', activeFilters.distance);
        }
        
        if (activeFilters.trust) {
            params.append('trust', activeFilters.trust);
        }
        
        if (activeFilters.sort !== 'latest') {
            params.append('sort', activeFilters.sort);
        }
        
        if (activeFilters.quickFilter !== 'all') {
            params.append('quickFilter', activeFilters.quickFilter);
        }
        
        // Determine endpoint URL
        let searchEndpoint;
        if (isDining) {
            searchEndpoint = '/dining/search';
        } else if (isLodging) {
            searchEndpoint = '/lodging/search';
        } else {
            // Default fallback
            searchEndpoint = '/search';
        }
        
        // Show loading indicator
        const postList = document.getElementById('post-list');
        
        if (postList) {
            postList.innerHTML = '<div class="loading-indicator"><i class="fas fa-spinner fa-spin"></i> Đang tải...</div>';
        }
        
        // Hide load more button while loading
        if (loadMoreButton) {
            loadMoreButton.style.display = 'none';
        }
        
        // Fetch filtered results
        fetch(`${searchEndpoint}?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update DOM with new results
            if (postList) {
                if (data.html && data.html.trim() !== '') {
                    postList.innerHTML = data.html;
                    
                    // Show result count if available
                    if (data.count) {
                        const resultCount = document.createElement('div');
                        resultCount.className = 'result-count';
                        resultCount.innerHTML = `<span>Tìm thấy ${data.count} kết quả</span>`;
                        postList.insertAdjacentElement('beforebegin', resultCount);
                        
                        // Remove previous result count if exists
                        setTimeout(() => {
                            const oldCounts = document.querySelectorAll('.result-count:not(:first-child)');
                            oldCounts.forEach(el => el.remove());
                        }, 100);
                        
                        // Show load more button if there are more results
                        if (data.count > 30 && data.hasMore) {
                            loadMoreButton.style.display = 'block';
                        } else {
                            loadMoreButton.style.display = 'none';
                        }
                    }
                } else {
                    postList.innerHTML = '<div class="no-results"><i class="fas fa-search"></i> Không tìm thấy kết quả phù hợp với bộ lọc của bạn.</div>';
                    
                    // Remove any result count
                    const resultCounts = document.querySelectorAll('.result-count');
                    resultCounts.forEach(el => el.remove());
                    
                    // Hide load more button when no results
                    loadMoreButton.style.display = 'none';
                }
            }
            
            // Update URL to reflect filters (for shareable links and browser history)
            // We do this without reloading the page
            const url = new URL(window.location.href);
            
            // Clear existing params
            url.search = '';
            
            // Add new params
            for (const [key, value] of params.entries()) {
                url.searchParams.append(key, value);
            }
            
            // Update browser history without reloading
            window.history.pushState({ path: url.href }, '', url.href);
            
            // Reset load more functionality
            resetLoadMore();
        })
        .catch(error => {
            console.error('Error applying filters:', error);
            if (postList) {
                postList.innerHTML = '<div class="error-message">Có lỗi xảy ra khi lọc kết quả. Vui lòng thử lại.</div>';
            }
        });
    }
    
    // Reset load more button after filtering
    function resetLoadMore() {
        const loadMoreButton = document.getElementById('loadMoreButton');
        if (loadMoreButton) {
            // Reset to initial state
            loadMoreButton.style.display = 'block';
            loadMoreButton.classList.remove('loading');
            
            // Get current endpoint based on page
            let loadMoreEndpoint;
            if (isDining) {
                loadMoreEndpoint = '/dining/load-more';
            } else if (isLodging) {
                loadMoreEndpoint = '/lodging/load-more';
            }
            
            // Update click handler
            loadMoreButton.onclick = function() {
                // Your existing load more logic
                if (this.classList.contains('loading')) return;
                
                this.classList.add('loading');
                
                // Build query with active filters
                const params = new URLSearchParams();
                params.append('offset', '30'); // Reset to first page of additional results
                
                // Add current filters to load more request
                if (activeFilters.search) {
                    params.append('search', activeFilters.search);
                }
                
                if (activeFilters.price) {
                    params.append('price', activeFilters.price);
                }
                
                if (activeFilters.style.length > 0) {
                    activeFilters.style.forEach(style => {
                        params.append('style[]', style);
                    });
                }
                
                if (activeFilters.amenities.length > 0) {
                    activeFilters.amenities.forEach(amenity => {
                        params.append('amenities[]', amenity);
                    });
                }
                
                if (activeFilters.location) {
                    params.append('location', activeFilters.location);
                }
                
                if (activeFilters.distance) {
                    params.append('distance', activeFilters.distance);
                }
                
                if (activeFilters.trust) {
                    params.append('trust', activeFilters.trust);
                }
                
                if (activeFilters.sort !== 'latest') {
                    params.append('sort', activeFilters.sort);
                }
                
                if (activeFilters.quickFilter !== 'all') {
                    params.append('quickFilter', activeFilters.quickFilter);
                }
                
                fetch(`${loadMoreEndpoint}?${params.toString()}`)
                    .then(response => response.json())
                    .then(data => {
                        this.classList.remove('loading');
                        
                        // Check if there are results
                        if (data.html && data.html.trim() !== '') {
                            const postList = document.getElementById('post-list');
                            if (postList) {
                                postList.insertAdjacentHTML('beforeend', data.html);
                            }
                            
                            // Hide button if no more results
                            if (!data.hasMore) {
                                this.style.display = 'none';
                            }
                        } else {
                            // No more results
                            this.style.display = 'none';
                            
                            // Show a message that there are no more results
                            const noMoreResults = document.createElement('div');
                            noMoreResults.className = 'no-more-results';
                            noMoreResults.innerHTML = 'Không còn kết quả nào khác.';
                            this.parentNode.insertBefore(noMoreResults, this);
                            
                            // Remove message after 3 seconds
                            setTimeout(() => {
                                noMoreResults.style.opacity = '0';
                                setTimeout(() => {
                                    noMoreResults.remove();
                                }, 500);
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error loading more:', error);
                        this.classList.remove('loading');
                    });
            };
        }
    }
    
    // Initialize filters from URL on page load
    function initFiltersFromURL() {
        const url = new URL(window.location.href);
        
        // Search
        if (url.searchParams.has('search')) {
            const search = url.searchParams.get('search');
            if (filterSearchInput) {
                filterSearchInput.value = search;
            }
            activeFilters.search = search;
        }
        
        // Price
        if (url.searchParams.has('price')) {
            const price = url.searchParams.get('price');
            const priceButton = document.querySelector(`.price-button[data-price="${price}"]`);
            if (priceButton) {
                priceButton.classList.add('active');
            }
            activeFilters.price = price;
        }
        
        // Styles (multiple)
        if (url.searchParams.has('style[]')) {
            const styles = url.searchParams.getAll('style[]');
            styles.forEach(style => {
                const styleButton = document.querySelector(`.style-button[data-style="${style}"]`);
                if (styleButton) {
                    styleButton.classList.add('active');
                }
                activeFilters.style.push(style);
            });
        }
        
        // Amenities (multiple)
        if (url.searchParams.has('amenities[]')) {
            const amenities = url.searchParams.getAll('amenities[]');
            amenities.forEach(amenity => {
                const amenityButton = document.querySelector(`.amenity-button[data-amenity="${amenity}"]`);
                if (amenityButton) {
                    amenityButton.classList.add('active');
                }
                activeFilters.amenities.push(amenity);
            });
        }
        
        // Location
        if (url.searchParams.has('location')) {
            const location = url.searchParams.get('location');
            const locationButton = document.querySelector(`.location-button[data-location="${location}"]`);
            if (locationButton) {
                locationButton.classList.add('active');
            }
            activeFilters.location = location;
        }
        
        // Distance
        if (url.searchParams.has('distance')) {
            const distance = url.searchParams.get('distance');
            const distanceButton = document.querySelector(`.location-button[data-distance="${distance}"]`);
            if (distanceButton) {
                distanceButton.classList.add('active');
            }
            activeFilters.distance = distance;
        }
        
        // Trust
        if (url.searchParams.has('trust')) {
            const trust = url.searchParams.get('trust');
            const trustButton = document.querySelector(`.trust-button[data-trust="${trust}"]`);
            if (trustButton) {
                trustButton.classList.add('active');
            }
            activeFilters.trust = trust;
        }
        
        // Sort
        if (url.searchParams.has('sort')) {
            const sort = url.searchParams.get('sort');
            // Reset default sort button
            document.querySelectorAll('.sort-button.active').forEach(btn => btn.classList.remove('active'));
            // Set active sort button
            const sortButton = document.querySelector(`.sort-button[data-sort="${sort}"]`);
            if (sortButton) {
                sortButton.classList.add('active');
            }
            activeFilters.sort = sort;
        }
        
        // Quick filter
        if (url.searchParams.has('quickFilter')) {
            const quickFilter = url.searchParams.get('quickFilter');
            // Reset default pill
            document.querySelectorAll('.filter-pill-item.active').forEach(pill => pill.classList.remove('active'));
            // Set active pill
            const pillItem = document.querySelector(`.filter-pill-item[data-filter="${quickFilter}"]`);
            if (pillItem) {
                pillItem.classList.add('active');
            }
            activeFilters.quickFilter = quickFilter;
        }
        
        // Update UI
        checkFiltersActive();
    }
    
    // Initialize filters from URL
    initFiltersFromURL();
    
    // Check if we need to show the load more button initially
    if (loadMoreButton && document.querySelectorAll('#post-list .post-card').length > 0) {
        // Only show if we have post cards and it's likely we have more than one page
        loadMoreButton.style.display = 'block';
    }
}); 