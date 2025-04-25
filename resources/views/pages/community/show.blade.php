@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="post-header mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <span><b>{{ $post->user->name }}</b></span>
                                @if ($post->group)
                                    <span>></span>
                                    <a class="text-decoration-none text-dark"
                                        href="{{ route('groupss.show', $post->group) }}">
                                        <span><b>{{ $post->group->name }}</b></span>
                                    </a>
                                @endif
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <h1 class="post-title">{{ $post->title }}</h1>
                    </div>

                    <div class="post-content mb-4">
                        {!! nl2br(e($post->description)) !!}
                    </div>

                    @if ($post->images->count() > 0)
                        <div class="post-images mb-3" data-post-id="{{ $post->id }}"
                            data-total-images="{{ $post->images->count() }}" data-images='@json($post->images->pluck('image_path'))'>
                            @if ($post->images->count() == 1)
                                <div class="single-image">
                                    <img src="{{ asset($post->images[0]->image_path) }}" alt="Ảnh bài viết"
                                        class="img-fluid rounded cursor-pointer"
                                        onclick="showImage(this.src, {{ $post->id }}, 0)">
                                </div>
                            @else
                                <div class="row g-2 images-container">
                                    @foreach ($post->images->take(4) as $index => $image)
                                        <div class="{{ $post->images->count() == 2 ? 'col-6' : 'col-4' }}">
                                            <div class="position-relative">
                                                <img src="{{ asset($image->image_path) }}" alt="Ảnh bài viết"
                                                    class="img-fluid rounded cursor-pointer"
                                                    onclick="showImage(this.src, {{ $post->id }}, {{ $index }})">
                                                @if ($index == 3 && $post->images->count() > 4)
                                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 rounded d-flex align-items-center justify-content-center cursor-pointer"
                                                        onclick="showImage(this.parentElement.querySelector('img').src, {{ $post->id }}, 3)">
                                                        <span
                                                            class="text-white fs-4">+{{ $post->images->count() - 4 }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Comments Section -->
                    <div class="comments-section">
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
    <x-community.community-js name="chitietbaiviet" />
@endsection
