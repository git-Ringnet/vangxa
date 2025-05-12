@foreach ($posts as $post)
    <div class="listing-card custom-card">
        <a href="{{ route('dining.detail-dining', $post->id) }}">
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
                    <span class="distance-text" data-lat="{{ $post->latitude ?? '' }}"
                        data-lng="{{ $post->longitude ?? '' }}">-- km</span>
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
    // Hàm tính khoảng cách Haversine
    function haversine(lat1, lon1, lat2, lon2) {
        function toRad(x) {
            return x * Math.PI / 180;
        }
        var R = 6371; // km
        var dLat = toRad(lat2 - lat1);
        var dLon = toRad(lon2 - lon1);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    // Hàm cập nhật khoảng cách
    function updateDistances() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLat = position.coords.latitude;
                var userLng = position.coords.longitude;
                document.querySelectorAll('.distance-text').forEach(function(el) {
                    var lat = el.dataset.lat;
                    var lng = el.dataset.lng;
                    if (lat && lng) {
                        var dist = haversine(userLat, userLng, parseFloat(lat), parseFloat(lng));
                        el.textContent = dist.toFixed(1) + ' km';
                    }
                });
            });
        }
    }

    // Gọi hàm cập nhật khoảng cách khi trang được load
    document.addEventListener('DOMContentLoaded', function() {
        updateDistances();
    });

    function handleSave(button) {
        const postId = button.dataset.postId;
        const isAuthenticated = button.dataset.authenticated === 'true';

        if (!isAuthenticated) {
            showToast('Vui lòng đăng nhập để thêm vào danh sách tin cậy', 'warning');
            return;
        }

        const form = button.closest('.trustlist-form');
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const icon = button.querySelector('i');
                    const savesCount = button.querySelector('.saves-count');
                    if (data.saved) {
                        icon.classList.remove('far');
                        icon.classList.add('fas', 'text-primary');
                        button.dataset.saved = 'true';
                        showToast(data.message, 'success');
                    } else {
                        icon.classList.remove('fas', 'text-primary');
                        icon.classList.add('far');
                        button.dataset.saved = 'false';
                        showToast(data.message, 'info');
                    }
                    if (savesCount) {
                        savesCount.textContent = data.savesCount;
                    }
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra, vui lòng thử lại sau', 'error');
            });
    }

    function showStoryModal(postId) {
        const modal = document.getElementById(`storyModal-${postId}`);
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeStoryModal(postId) {
        const modal = document.getElementById(`storyModal-${postId}`);
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.querySelectorAll('.story-modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });
    });
</script>
