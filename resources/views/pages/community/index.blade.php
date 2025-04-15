@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container-custom">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">Cộng đồng</h2>
                        <a href="{{ route('community.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tạo bài viết mới
                        </a>
                    </div>

                    @if ($posts->isEmpty())
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <h4>Chưa có bài viết nào</h4>
                                <p class="text-muted">Hãy là người đầu tiên chia sẻ bài viết với cộng đồng!</p>
                                <a href="{{ route('community.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tạo bài viết đầu tiên
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-md-6 mb-4">
                                    <div class="post-card h-100">
                                        <div class="post-header">
                                            <div class="d-flex align-items-center mb-3">
                                                <div>
                                                    <h6 class="mb-0">{{ $post->user->name }}</h6>
                                                    <small
                                                        class="text-muted">{{ $post->created_at->format('d/m/Y H:i') }}</small>
                                                </div>
                                            </div>
                                            <h3 class="post-title">
                                                <a href="{{ route('community.show', $post->id) }}"
                                                    class="text-decoration-none text-dark">
                                                    {{ $post->title }}
                                                </a>
                                            </h3>
                                        </div>

                                        <div class="post-content mb-3">
                                            {{ Str::limit($post->content, 150) }}
                                        </div>

                                        @if ($post->images->count() > 0)
                                            <div class="post-images mb-3">
                                                <div class="row g-2">
                                                    @foreach ($post->images->take(2) as $image)
                                                        <div class="col-6">
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
                                                    <i class="far fa-comment"></i> {{ $post->comments->count() }}
                                                </span>
                                            </div>
                                            <a href="{{ route('community.show', $post->id) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                Xem chi tiết
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $posts->links() }}
                        </div>
                    @endif
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            border: 1px solid #eee;
        }

        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .post-title {
            font-size: 1.25rem;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .post-title a:hover {
            color: #0056b3 !important;
        }

        .post-content {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
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

        /* Sidebar Styles */
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-title {
            color: #333;
            font-weight: 600;
        }

        .form-select {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px 12px;
        }

        .form-select:focus {
            border-color: #0056b3;
            box-shadow: 0 0 0 0.2rem rgba(0, 86, 179, 0.25);
        }

        /* Empty State */
        .text-muted {
            color: #6c757d !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .col-md-3 {
                margin-bottom: 2rem;
            }

            .post-card {
                padding: 15px;
            }

            .post-title {
                font-size: 1.1rem;
            }

            .post-images img {
                height: 120px;
            }
        }
    </style>
@endsection
