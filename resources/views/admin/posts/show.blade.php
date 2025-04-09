@extends('admin.layouts.app')

@section('title', $post->title)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết bài viết</h1>
        <div>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Sửa bài viết
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{ $post->title }}</h2>
                    
                    <div class="mb-4">
                        <h5 class="text-muted mb-2">Địa chỉ</h5>
                        <p class="mb-0">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            {{ $post->address }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-muted mb-2">Mô tả</h5>
                        <div class="post-content">
                            {!! $post->description !!}
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-muted mb-2">Thông tin bài viết</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="fas fa-user text-primary"></i>
                                    <strong>Người đăng:</strong> {{ $post->user->name ?? 'Anonymous' }}
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-clock text-primary"></i>
                                    <strong>Ngày tạo:</strong> {{ $post->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="fas fa-edit text-primary"></i>
                                    <strong>Cập nhật lần cuối:</strong> {{ $post->updated_at->format('d/m/Y H:i') }}
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-check-circle text-primary"></i>
                                    <strong>Trạng thái:</strong>
                                    <span class="badge bg-success">Đã đăng</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hình ảnh</h6>
                </div>
                <div class="card-body">
                    @if($post->images->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có hình ảnh nào</p>
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach($post->images as $image)
                                <div class="col-6">
                                    <a href="{{ asset('storage/' . $image->image_path) }}" data-lightbox="post-images" class="d-block">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             class="img-fluid rounded" 
                                             alt="Post image"
                                             style="width: 100%; height: 150px; object-fit: cover;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thao tác</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-grid">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                            <i class="fas fa-trash"></i> Xóa bài viết
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    });
</script>
@endpush
