@extends('layouts.main')

@section('content')
<div class="main-content container-custom favorites-page my-4">
    <div class="favorites-header">
        <h1>Danh sách yêu thích của bạn</h1>
        <p>Những địa điểm bạn đã đánh dấu yêu thích</p>
    </div>

    @if($favorites->count() > 0)
        <div class="row">
            @foreach($favorites as $favorite)
                @php $post = $favorite->post; @endphp
                @if($post)
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card favorite-card">
                            <div class="favorite-image">
                                @if($post->images->isNotEmpty())
                                    <img src="{{ asset($post->images->first()->image_path) }}" class="card-img-top" alt="{{ $post->title }}">
                                @else
                                    <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No Image">
                                @endif
                                <form action="{{ route('favorites.favorite', ['id' => $post->id]) }}" method="POST" class="favorite-form" data-post-id="{{ $post->id }}">
                                    @csrf
                                    <button type="submit" class="btn-favorite active" title="Bỏ yêu thích">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">
                                    <i class="fas fa-map-marker-alt"></i> {{ $post->location }}
                                </p>
                                <div class="favorite-footer">
                                    @if(Str::contains($post->category, 'dining'))
                                        <a href="{{ route('dining.detail-dining', $post->id) }}" class="btn btn-outline-primary">Xem chi tiết</a>
                                    @else
                                        <a href="{{ route('detail', $post->id) }}" class="btn btn-outline-primary">Xem chi tiết</a>
                                    @endif
                                    <span class="favorite-date">Đã thêm: {{ $favorite->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="empty-favorites">
            <div class="empty-content">
                <i class="far fa-heart"></i>
                <h3>Bạn chưa có địa điểm yêu thích nào</h3>
                <p>Hãy khám phá và đánh dấu những địa điểm bạn yêu thích</p>
                <div class="empty-actions">
                    <a href="{{ route('lodging') }}" class="btn btn-primary">Khám phá lưu trú</a>
                    <a href="{{ route('dining') }}" class="btn btn-outline-primary">Khám phá ẩm thực</a>
                </div>
            </div>
        </div>
    @endif

    <!-- Thông báo yêu thích -->
    <div id="favoriteNotification" class="favorite-notification">
        <div class="favorite-notification-content">
            <i class="fas fa-heart"></i>
            <span id="favoriteMessage"></span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý form yêu thích
        const favoriteForms = document.querySelectorAll('.favorite-form');
        
        favoriteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                const postId = form.dataset.postId;
                const card = form.closest('.col-md-4');
                
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    showFavoriteNotification(data.message, data.favorited);
                    
                    // Nếu đã bỏ yêu thích, xóa card sau khi animation hoàn tất
                    if (!data.favorited) {
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.remove();
                            
                            // Kiểm tra nếu không còn mục yêu thích nào
                            if (document.querySelectorAll('.favorite-card').length === 0) {
                                const container = document.querySelector('.container-custom');
                                container.innerHTML = `
                                <div class="favorites-header">
                                    <h1>Danh sách yêu thích của bạn</h1>
                                    <p>Những địa điểm bạn đã đánh dấu yêu thích</p>
                                </div>
                                <div class="empty-favorites">
                                    <div class="empty-content">
                                        <i class="far fa-heart"></i>
                                        <h3>Bạn chưa có địa điểm yêu thích nào</h3>
                                        <p>Hãy khám phá và đánh dấu những địa điểm bạn yêu thích</p>
                                        <div class="empty-actions">
                                            <a href="{{ route('lodging') }}" class="btn btn-primary">Khám phá lưu trú</a>
                                            <a href="{{ route('dining') }}" class="btn btn-outline-primary">Khám phá ẩm thực</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="favoriteNotification" class="favorite-notification">
                                    <div class="favorite-notification-content">
                                        <i class="fas fa-heart"></i>
                                        <span id="favoriteMessage"></span>
                                    </div>
                                </div>
                                `;
                            }
                        }, 300);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showFavoriteNotification('Có lỗi xảy ra, vui lòng thử lại', false);
                });
            });
        });
        
        // Hàm hiển thị thông báo yêu thích
        function showFavoriteNotification(message, isSuccess) {
            const notification = document.getElementById('favoriteNotification');
            const messageElement = document.getElementById('favoriteMessage');
            
            messageElement.textContent = message;
            if (isSuccess) {
                notification.classList.add('success');
                notification.classList.remove('error');
            } else {
                notification.classList.add('error');
                notification.classList.remove('success');
            }
            
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
    });
</script>
@endpush

<style>
    .favorites-page {
        padding: 20px 0;
    }
    
    .favorites-header {
        margin-bottom: 30px;
        text-align: center;
    }
    
    .favorites-header h1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #333;
    }
    
    .favorites-header p {
        font-size: 16px;
        color: #666;
    }
    
    .favorite-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease, opacity 0.3s ease;
    }
    
    .favorite-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    .favorite-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    
    .favorite-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .favorite-card:hover .favorite-image img {
        transform: scale(1.05);
    }
    
    .btn-favorite {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-favorite i {
        font-size: 20px;
        color: #999;
        transition: color 0.3s ease;
    }
    
    .btn-favorite.active i {
        color: #e74c3c;
    }
    
    .btn-favorite:hover {
        transform: scale(1.1);
    }
    
    .card-body {
        padding: 15px;
    }
    
    .card-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }
    
    .card-text {
        color: #666;
        margin-bottom: 15px;
    }
    
    .card-text i {
        color: #4CAF50;
        margin-right: 5px;
    }
    
    .favorite-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .favorite-date {
        font-size: 12px;
        color: #999;
    }
    
    .empty-favorites {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 400px;
        text-align: center;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
    }
    
    .empty-content {
        max-width: 500px;
    }
    
    .empty-content i {
        font-size: 60px;
        color: #ccc;
        margin-bottom: 20px;
    }
    
    .empty-content h3 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }
    
    .empty-content p {
        font-size: 16px;
        color: #666;
        margin-bottom: 20px;
    }
    
    .empty-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }
    
    /* Thông báo yêu thích */
    .favorite-notification {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(-100px);
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        padding: 15px 25px;
        z-index: 9999;
        transition: transform 0.3s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 300px;
        max-width: 80%;
    }
    
    .favorite-notification.show {
        transform: translateX(-50%) translateY(0);
    }
    
    .favorite-notification.success {
        border-left: 4px solid #4CAF50;
    }
    
    .favorite-notification.error {
        border-left: 4px solid #F44336;
    }
    
    .favorite-notification-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .favorite-notification i {
        font-size: 20px;
    }
    
    .favorite-notification.success i {
        color: #4CAF50;
    }
    
    .favorite-notification.error i {
        color: #F44336;
    }
    
    .favorite-notification span {
        font-size: 16px;
        font-weight: 500;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .favorites-header h1 {
            font-size: 28px;
        }
        
        .favorite-footer {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
    }
</style>