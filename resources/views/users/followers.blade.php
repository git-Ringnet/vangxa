@extends('layouts.main')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('profile.show', $user->id) }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="mb-0">Người theo dõi của {{ $user->name }}</h2>
            </div>
            <p class="text-muted">{{ $followers->total() }} người theo dõi</p>
        </div>
    </div>

    @if($followers->count() > 0)
        <div class="row">
            @foreach($followers as $follower)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('profile.show', $follower->id) }}" class="me-3">
                                    <img src="{{ $follower->avatar }}" alt="{{ $follower->name }}" class="rounded-circle" width="50" height="50">
                                </a>
                                <div class="flex-grow-1">
                                    <a href="{{ route('profile.show', $follower->id) }}" class="text-decoration-none">
                                        <h5 class="mb-0">{{ $follower->name }}</h5>
                                    </a>
                                    <p class="text-muted small mb-0">{{ $follower->bio ?? 'Chưa có giới thiệu' }}</p>
                                </div>
                                @if(Auth::check() && Auth::id() != $follower->id)
                                    @php
                                        $isFollowing = Auth::user()->following()->where('following_id', $follower->id)->exists();
                                    @endphp
                                    <button class="btn btn-sm {{ $isFollowing ? 'btn-secondary' : 'btn-primary' }} follow-btn" 
                                            data-user-id="{{ $follower->id }}" 
                                            data-action="{{ $isFollowing ? 'unfollow' : 'follow' }}">
                                        <i class="fas {{ $isFollowing ? 'fa-user-minus' : 'fa-user-plus' }}"></i>
                                        <span class="follow-text">{{ $isFollowing ? 'Đang theo dõi' : 'Theo dõi' }}</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $followers->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <h3 class="h4">Chưa có người theo dõi</h3>
            <p class="text-muted">Hãy tích cực đăng bài và tương tác để thu hút người theo dõi.</p>
        </div>
    @endif
</div>

<!-- Script xử lý follow/unfollow -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tạo header cho AJAX request với CSRF token
        const headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };
        
        // Xử lý nút follow/unfollow
        document.querySelectorAll('.follow-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const action = this.getAttribute('data-action');
                
                // Gửi request đến server
                fetch(`/follow-toggle/${userId}`, {
                    method: 'POST',
                    headers: headers
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật UI
                        updateFollowButton(this, data.isFollowing);
                        
                        // Hiển thị thông báo
                        showNotification(data.message);
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    showNotification('Đã xảy ra lỗi khi xử lý yêu cầu', 'error');
                });
            });
        });
        
        // Hàm cập nhật giao diện nút follow/unfollow
        function updateFollowButton(button, isFollowing) {
            if (isFollowing) {
                button.classList.remove('btn-primary');
                button.classList.add('btn-secondary');
                button.querySelector('i').classList.remove('fa-user-plus');
                button.querySelector('i').classList.add('fa-user-minus');
                button.querySelector('.follow-text').textContent = 'Đang theo dõi';
                button.setAttribute('data-action', 'unfollow');
            } else {
                button.classList.remove('btn-secondary');
                button.classList.add('btn-primary');
                button.querySelector('i').classList.remove('fa-user-minus');
                button.querySelector('i').classList.add('fa-user-plus');
                button.querySelector('.follow-text').textContent = 'Theo dõi';
                button.setAttribute('data-action', 'follow');
            }
        }
        
        // Hàm hiển thị thông báo
        function showNotification(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
            alertDiv.setAttribute('role', 'alert');
            alertDiv.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(alertDiv);
            
            // Tự động đóng thông báo sau 3 giây
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.parentNode.removeChild(alertDiv);
                }
            }, 3000);
        }
    });
</script>
@endsection
