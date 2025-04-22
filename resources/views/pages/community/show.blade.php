@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="post-header mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $post->user->avatar ?? asset('images/default-avatar.png') }}"
                                class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                            <div>
                                <h5 class="mb-0">{{ $post->user->name }}</h5>
                                <small class="text-muted">{{ $post->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        <h1 class="post-title">{{ $post->title }}</h1>
                    </div>

                    <div class="post-content mb-4">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    @if ($post->images->count() > 0)
                        <div class="post-images mb-4">
                            <div class="row g-3">
                                @foreach ($post->images as $image)
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded"
                                            style="width: 100%; height: 200px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="post-actions mb-4">
                        <button class="btn btn-outline-primary me-2">
                            <i class="far fa-heart"></i> Thích
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="far fa-bookmark"></i> Lưu
                        </button>
                    </div>

                    <!-- Comments Section -->
                    <div x-data="progressBar" class="comments-section">
                        <h3 class="mb-4">Bình luận ({{ $post->comments->count() }})</h3>

                        <form action="{{ route('comments.store') }}" method="POST" class="comment-form mb-4">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="form-group">
                                <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận của bạn..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">
                                Đăng bình luận
                            </button>
                        </form>

                        <div class="comments-list">
                            @foreach ($post->comments->where('parent_id', null) as $comment)
                                @include('comments.partials.comment', ['comment' => $comment])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('progressBar', () => ({
                currentStatus: '{{ $post->status }}',
                message: '',
                init() {
                    this.currentStatus = '{{ $post->status }}';
                    this.updateProgressBar();

                    Echo.private('posts.1')
                        .subscribed(() => {
                            console.log('Subscribed to posts.1');
                        })
                        .listen('TestReverbEvent', (e) => {
                            console.log('event:', e);
                        });
                },
                updateProgressBar() {
                    if (this.currentStatus === 0) {
                        console.log('Status: 0');
                    } else if (this.currentStatus === 1) {
                        console.log('Status: 1');
                    } else if (this.currentStatus === 2) {
                        console.log('Status: 2');
                    }
                }
            }));
        });
    </script>
    <style>
        /* Post Styles */
        .post-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .post-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
        }

        .post-images img {
            transition: transform 0.3s;
        }

        .post-images img:hover {
            transform: scale(1.05);
        }

        .post-actions {
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 1rem 0;
        }

        /* Comment Form */
        .comment-form textarea {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px;
            resize: vertical;
            min-height: 100px;
        }

        .comment-form textarea:focus {
            border-color: #0056b3;
            box-shadow: 0 0 0 0.2rem rgba(0, 86, 179, 0.25);
        }

        /* Comments List */
        .comments-list {
            margin-top: 2rem;
        }

        .comment {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .comment-header {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .comment-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .comment-author {
            font-weight: 600;
            color: #333;
        }

        .comment-date {
            font-size: 0.85rem;
            color: #666;
            margin-left: 0.5rem;
        }

        .comment-content {
            color: #444;
            line-height: 1.6;
            margin-bottom: 0.5rem;
        }

        .comment-actions {
            display: flex;
            gap: 1rem;
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

        /* Nested Comments */
        .comment .comment {
            margin-left: 2rem;
            background: #fff;
            border: 1px solid #eee;
        }

        /* Reply Form */
        .reply-form {
            margin-top: 1rem;
            padding: 1rem;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .post-title {
                font-size: 1.5rem;
            }

            .post-content {
                font-size: 1rem;
            }

            .comment .comment {
                margin-left: 1rem;
            }
        }
    </style>
@endsection
