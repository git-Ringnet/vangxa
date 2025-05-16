@extends('layouts.main')

@section('content')
    <div>
        <div class="container">
            <div class="border p-4 rounded-3 mb-3">
                <div class="card-body">
                    <div class="post-header mb-4">
                        <div class="d-flex align-items-center mb-3 justify-content-between">
                            <div>
                                <span><b>{{ $post->user->name }}</b></span>
                                @if ($post->group)
                                    <span>></span>
                                    <a class="text-decoration-none"
                                        href="{{ route('groupss.show', $post->group) }}">
                                        <span><b>{{ $post->group->name }}</b></span>
                                    </a>
                                    <span>></span>
                                    @if ($post->taggedVendors->count() > 0)
                                        <span>
                                            @foreach ($post->taggedVendors as $vendor)
                                                <a href="{{ route('profile.show', $vendor->id) }}"
                                                    class="text-decoration-none">
                                                    {{ $vendor->name }}
                                                </a>
                                            @endforeach
                                        </span>
                                    @endif
                                @endif
                                <p>
                                    <small class="text-white-blur">{{ $post->created_at->diffForHumans() }}</small>
                                </p>
                            </div>
                            @if (Auth::check() && Auth::id() == $post->user_id)
                                <div class="dropdown">
                                    <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M12 14C10.8954 14 10 13.1046 10 12C10 10.8954 10.8954 10 12 10C13.1046 10 14 10.8954 14 12C14 13.1046 13.1046 14 12 14Z"
                                                fill="#7c4d28" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5 14C3.89543 14 3 13.1046 3 12C3 10.8954 3.89543 10 5 10C6.10457 10 7 10.8954 7 12C7 13.1046 6.10457 14 5 14Z"
                                                fill="#7c4d28" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M19 14C17.8954 14 17 13.1046 17 12C17 10.8954 17.8954 10 19 10C20.1046 10 21 10.8954 21 12C21 13.1046 20.1046 14 19 14Z"
                                                fill="#7c4d28" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#editPostModal{{ $post->id }}">
                                                <i class="fas fa-edit me-2"></i> Chỉnh sửa
                                            </a>
                                        </li>
                                        <li>
                                            <form onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                                                action="{{ route('communities.destroy', $post) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash me-2"></i> Xóa
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="post-content mb-4 break-word">
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
    <!-- Edit Post Modal -->
    <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1"
        aria-labelledby="editPostModalLabel{{ $post->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPostModalLabel{{ $post->id }}">Chỉnh sửa bài viết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('communities.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <textarea name="description" rows="3" class="form-control" placeholder="Bạn viết gì đi..." autocomplete="off">{{ $post->description }}</textarea>
                        <div class="mb-3">
                            <label for="tagged_vendors" class="form-label">Tag vendor</label>
                            <select class="form-select" id="tagged_vendors" name="tagged_vendors[]" multiple>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        {{ $post->taggedVendors->contains($vendor->id) ? 'selected' : '' }}>
                                        {{ $vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Bạn có thể chọn nhiều vendor để tag</div>
                        </div>

                        @if ($post->images->count() > 0)
                            <div class="mb-3">
                                <label class="form-label">Ảnh hiện tại</label>
                                <div class="row g-2">
                                    @foreach ($post->images as $image)
                                        <div class="col-4">
                                            <div class="position-relative">
                                                <img src="{{ asset($image->image_path) }}" class="img-fluid rounded"
                                                    alt="Ảnh bài viết">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                    onclick="deleteImage({{ $image->id }}, this)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="images" class="form-label">Thêm ảnh mới</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple
                                accept="image/*">
                            <div class="form-text">Bạn có thể chọn nhiều ảnh cùng lúc</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-community.community-js name="chitietbaiviet" />
    <style>
        body {
            background-image: url('{{ asset('image/default/Window.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
@endsection
