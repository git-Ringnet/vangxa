@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Cộng đồng</h2>
                    <a href="{{ route('community.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tạo bài viết mới
                    </a>
                </div>

                <div class="card-body">
                    @foreach($posts as $post)
                    <div class="post-card mb-4">
                        <div class="post-header">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $post->user->avatar ?? asset('images/default-avatar.png') }}" 
                                     class="rounded-circle me-2" 
                                     style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <h5 class="mb-0">{{ $post->user->name }}</h5>
                                    <small class="text-muted">{{ $post->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                            <h3 class="post-title">
                                <a href="{{ route('community.show', $post->id) }}" class="text-decoration-none text-dark">
                                    {{ $post->title }}
                                </a>
                            </h3>
                        </div>

                        <div class="post-content mb-3">
                            {{ Str::limit($post->content, 200) }}
                        </div>

                        @if($post->images->count() > 0)
                        <div class="post-images mb-3">
                            <div class="row g-2">
                                @foreach($post->images->take(3) as $image)
                                <div class="col-4">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="img-fluid rounded" 
                                         style="width: 100%; height: 150px; object-fit: cover;">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="post-footer d-flex justify-content-between align-items-center">
                            <div class="post-stats">
                                <span class="me-3">
                                    <i class="far fa-comment"></i> {{ $post->comments->count() }} bình luận
                                </span>
                                <span>
                                    <i class="far fa-heart"></i> {{ $post->likes->count() }} lượt thích
                                </span>
                            </div>
                            <a href="{{ route('community.show', $post->id) }}" class="btn btn-outline-primary btn-sm">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                    @endforeach

                    <div class="d-flex justify-content-center">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Post Card Styles */
.post-card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.post-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.post-title {
    font-size: 1.5rem;
    margin-bottom: 15px;
}

.post-title a:hover {
    color: #0056b3 !important;
}

.post-content {
    color: #666;
    line-height: 1.6;
}

.post-images img {
    transition: transform 0.3s;
}

.post-images img:hover {
    transform: scale(1.05);
}

.post-stats {
    color: #666;
    font-size: 0.9rem;
}

.post-stats i {
    margin-right: 5px;
}

/* Comment Section Styles */
.comments-section {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.comment {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
}

.comment-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.comment-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    margin-right: 10px;
}

.comment-author {
    font-weight: 600;
    color: #333;
}

.comment-date {
    font-size: 0.85rem;
    color: #666;
}

.comment-content {
    color: #444;
    line-height: 1.5;
}

.comment-actions {
    margin-top: 10px;
    display: flex;
    gap: 15px;
}

.comment-actions button {
    background: none;
    border: none;
    color: #666;
    font-size: 0.9rem;
    cursor: pointer;
    padding: 0;
}

.comment-actions button:hover {
    color: #0056b3;
}

.reply-form {
    margin-top: 15px;
    padding: 15px;
    background: #fff;
    border-radius: 8px;
    border: 1px solid #eee;
}

.reply-form textarea {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 10px;
    resize: vertical;
}

.reply-form button {
    background: #0056b3;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.reply-form button:hover {
    background: #004494;
}

/* Nested Comments */
.comment .comment {
    margin-left: 40px;
    background: #fff;
    border: 1px solid #eee;
}

/* Responsive Design */
@media (max-width: 768px) {
    .post-card {
        padding: 15px;
    }

    .post-title {
        font-size: 1.2rem;
    }

    .comment .comment {
        margin-left: 20px;
    }
}
</style>
@endsection 