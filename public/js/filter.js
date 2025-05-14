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
    
    // Filter buttons
    const priceButtons = document.querySelectorAll('.price-button');
    const styleButtons = document.querySelectorAll('.style-button');
    const locationButtons = document.querySelectorAll('.location-button');
    const filterPillItems = document.querySelectorAll('.filter-pill-item');
    
    // Active filters
    let activeFilters = {
        search: '',
        price: null,
        style: [],
        location: null,
        distance: null,
        quickFilter: 'all' // Default quick filter is 'all'
    };
    
    // Default filter state (to compare for changes)
    const defaultFilters = {
        search: '',
        price: null,
        style: [],
        location: null,
        distance: null,
        quickFilter: 'all'
    };
    
    // Open filter sidebar with smooth animation
    if (filterButton) {
        filterButton.addEventListener('click', function() {
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
                    overlay.style.opacity = '1';
                }, 10);
            } else {
                filterOverlay.style.display = 'block';
                setTimeout(() => {
                    filterOverlay.style.opacity = '1';
                }, 10);
            }
            
            // Show sidebar
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
                const filterControls = document.querySelector('.filter-controls');
                if (filterControls) {
                    filterControls.style.paddingRight = scrollbarWidth + 'px';
                }
            }
        });
    }
    
    // Close filter sidebar
    function closeFilter() {
        // Close sidebar
        filterSidebar.classList.remove('show');
        
        // Fade out overlay
        if (filterOverlay) {
            filterOverlay.style.opacity = '0';
            setTimeout(() => {
                filterOverlay.style.display = 'none';
            }, 300);
        }
        
        // Restore scrolling without layout shift
        const scrollY = parseInt(document.body.style.top || '0');
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.width = '';
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Reset padding on filter controls as well
        const filterControls = document.querySelector('.filter-controls');
        if (filterControls) {
            filterControls.style.paddingRight = '';
        }
        
        window.scrollTo(0, -scrollY);
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
        
        // Location and distance filters
        const activeLocation = document.querySelector('.location-button[data-location].active');
        const activeDistance = document.querySelector('.location-button[data-distance].active');
        activeFilters.location = activeLocation ? activeLocation.dataset.location : null;
        activeFilters.distance = activeDistance ? activeDistance.dataset.distance : null;
        
        // Trust filter
        const activeTrust = document.querySelector('.trust-button.active');
        activeFilters.trust = activeTrust ? activeTrust.dataset.trust : null;
        
        // Quick filter
        const activeQuickFilter = document.querySelector('.filter-pill-item.active');
        activeFilters.quickFilter = activeQuickFilter ? activeQuickFilter.dataset.filter : 'all';
        
        // Check for changes
        checkFiltersActive();
    }
    
    // Clear all filters
    if (filterClear) {
        filterClear.addEventListener('click', function() {
            // Clear search input
            if (filterSearchInput) {
                filterSearchInput.value = '';
            }
            
            // Remove active class from buttons
            document.querySelectorAll('.price-button.active, .style-button.active, .location-button.active, .trust-button.active').forEach(button => {
                button.classList.remove('active');
            });
            
            // Reset the pill filters to "All"
            filterPillItems.forEach(pill => {
                pill.classList.remove('active');
                if (pill.dataset.filter === 'all') {
                    pill.classList.add('active');
                }
            });
            
            // Reset active filters
            activeFilters = {
                search: '',
                price: null,
                style: [],
                location: null,
                distance: null,
                trust: null,
                quickFilter: 'all'
            };
            
            // Update apply button state
            filterApply.classList.remove('active');
        });
    }
    
    // Apply filters function
    function applyFilters() {
        // Update filters before applying
        updateActiveFilters();
        
        // Add loading state to button
        if (filterApply) {
            filterApply.classList.add('loading');
            filterApply.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Áp dụng';
        }
        
        // Build query parameters
        const params = new URLSearchParams();
        
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
        
        if (activeFilters.location) {
            params.append('location', activeFilters.location);
        }
        
        if (activeFilters.distance) {
            params.append('distance', activeFilters.distance);
        }
        
        if (activeFilters.trust) {
            params.append('trust', activeFilters.trust);
        }
        
        if (activeFilters.quickFilter && activeFilters.quickFilter !== 'all') {
            params.append('quick_filter', activeFilters.quickFilter);
        }
        
        // Get current page type (dining or lodging)
        const isDining = window.location.pathname.includes('dining');
        const isLodging = window.location.pathname.includes('lodging');
        
        // Apply filters via AJAX
        let endpoint = '/filter?';
        if (isDining) {
            endpoint = '/dining/filter?';
        } else if (isLodging) {
            endpoint = '/lodging/filter?';
        }
        
        fetch(endpoint + params.toString(), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Reset loading state
            if (filterApply) {
                filterApply.classList.remove('loading');
                filterApply.innerHTML = 'Áp dụng';
            }
            
            // Handle successful filter
            if (data.success && data.html) {
                // Update listings
                const listingsGrid = document.getElementById('post-list');
                if (listingsGrid) {
                    listingsGrid.innerHTML = data.html;
                    
                    // Reinitialize carousels or any other component
                    if (typeof initializeCarousels === 'function') {
                        initializeCarousels();
                    }
                }
                
                // Close filter sidebar
                closeFilter();
                
                // Show filter count if available
                if (data.count) {
                    // TODO: Show filter result count
                }
            } else {
                // Handle error
                console.error('Error applying filters:', data.message || 'Unknown error');
            }
        })
        .catch(error => {
            console.error('Filter application error:', error);
            
            // Reset button state
            if (filterApply) {
                filterApply.classList.remove('loading');
                filterApply.innerHTML = 'Áp dụng';
            }
        });
    }
    
    // Apply filters on click
    if (filterApply) {
        filterApply.addEventListener('click', applyFilters);
    }
    
    // Initialize any existing filter state from URL
    function initFiltersFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Search parameter
        const searchParam = urlParams.get('search');
        if (searchParam && filterSearchInput) {
            filterSearchInput.value = searchParam;
            activeFilters.search = searchParam;
        }
        
        // Price parameter
        const priceParam = urlParams.get('price');
        if (priceParam) {
            const matchingButton = document.querySelector(`.price-button[data-price="${priceParam}"]`);
            if (matchingButton) {
                matchingButton.classList.add('active');
                activeFilters.price = priceParam;
            }
        }
        
        // Style parameters
        const styleParams = urlParams.getAll('style[]');
        if (styleParams.length > 0) {
            styleParams.forEach(style => {
                const matchingButton = document.querySelector(`.style-button[data-style="${style}"]`);
                if (matchingButton) {
                    matchingButton.classList.add('active');
                    activeFilters.style.push(style);
                }
            });
        }
        
        // Quick filter parameter
        const quickFilterParam = urlParams.get('quick_filter');
        if (quickFilterParam) {
            const matchingPill = document.querySelector(`.filter-pill-item[data-filter="${quickFilterParam}"]`);
            if (matchingPill) {
                document.querySelectorAll('.filter-pill-item').forEach(pill => pill.classList.remove('active'));
                matchingPill.classList.add('active');
                activeFilters.quickFilter = quickFilterParam;
            }
        }
        
        // Update button state
        checkFiltersActive();
    }
    
    // Initialize filters from URL on page load
    initFiltersFromURL();
}); 