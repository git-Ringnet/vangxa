@foreach ($posts as $post)
    <div class="listing-card custom-card">
        <a href="{{ route('detail', $post->id) }}">
            <div>
                <img src="{{ asset(optional($post->images->first())->image_path) }}" class="img-fluid rounded"
                    alt="Post image">
            </div>
            <div class="listing-content">
                <div class="fw-semibold mb-1"
                    style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                    {{ $post->description }}</div>
                <div class="text-muted small mb-1">
                    {{ $post->address }}
                    <span class="mx-1">|</span>
                    <span class="distance-text" data-lat="{{ $post->latitude }}" data-lng="{{ $post->longitude }}" data-post-id="{{ $post->id }}">-- km</span>
                </div>
                <div class="text-muted small mb-2">
                    {{ number_format($post->min_price, 0, ',', '.') }}k -
                    {{ number_format($post->max_price, 0, ',', '.') }}k/ng
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($post->address) }}"
                        target="_blank" class="btn btn-map rounded-pill" style="background:#e2c9a0;color:#7a5c2e;">
                        <i class="fas fa-map-marked-alt"></i>
                    </a>
                </div>
            </div>
        </a>
    </div>
@endforeach

<script>
    // Biến toàn cục để lưu vị trí người dùng
    let userPosition = null;

    // Hàm tính khoảng cách Haversine
    function haversine(lat1, lon1, lat2, lon2) {
        function toRad(x) {
            return x * Math.PI / 180;
        }
        var R = 6371; // km - bán kính trái đất
        
        // Xử lý các giá trị không hợp lệ
        lat1 = parseFloat(lat1);
        lon1 = parseFloat(lon1);
        lat2 = parseFloat(lat2);
        lon2 = parseFloat(lon2);
        
        if (isNaN(lat1) || isNaN(lon1) || isNaN(lat2) || isNaN(lon2)) {
            console.error('Invalid coordinates in haversine calculation', {lat1, lon1, lat2, lon2});
            return 0;
        }
        
        var dLat = toRad(lat2 - lat1);
        var dLon = toRad(lon2 - lon1);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = R * c;
        
        return d;
    }

    // Hàm lấy vị trí người dùng
    function getUserPosition() {
        return new Promise((resolve, reject) => {
            if (userPosition) {
                // Nếu đã có vị trí từ trước, sử dụng lại
                resolve(userPosition);
                return;
            }
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userPosition = {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        };
                        console.log('Got user position:', userPosition);
                        resolve(userPosition);
                    },
                    (error) => {
                        console.error('Error getting location:', error);
                        reject(error);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                );
            } else {
                const error = new Error('Geolocation is not supported by this browser.');
                console.error(error);
                reject(error);
            }
        });
    }

    // Hàm cập nhật khoảng cách
    function updateDistances() {
        console.log('Updating distances...');
        
        getUserPosition()
            .then(position => {
                const userLat = position.latitude;
                const userLng = position.longitude;
                
                document.querySelectorAll('.distance-text').forEach(function(el) {
                    const lat = parseFloat(el.dataset.lat);
                    const lng = parseFloat(el.dataset.lng);
                    const postId = el.dataset.postId;
                    
                    if (!isNaN(lat) && !isNaN(lng)) {
                        const dist = haversine(userLat, userLng, lat, lng);
                        el.textContent = dist.toFixed(1) + ' km';
                    } else {
                        console.log('Invalid coordinates for post', postId, ':', lat, lng);
                    }
                });
            })
            .catch(error => {
                console.error('Failed to update distances:', error);
            });
    }

    // Gọi hàm cập nhật khoảng cách khi trang được load
    document.addEventListener('DOMContentLoaded', function() {
        updateDistances();
    });

    // Thêm sự kiện cho nút Load More
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'loadMoreBtn') {
            setTimeout(function() {
                updateDistances();
            }, 1000);
        }
    });

    // Thêm sự kiện cho AJAX load more
    $(document).ajaxComplete(function() {
        updateDistances();
    });

    // Thêm MutationObserver để theo dõi thay đổi DOM
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                updateDistances();
            }
        });
    });

    // Bắt đầu quan sát thay đổi DOM
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
</script>
