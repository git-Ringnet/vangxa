@extends('layouts.main')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 mb-0">Câu chuyện của tôi</h1>
            <p class="text-muted">Chia sẻ những câu chuyện về doanh nghiệp, sản phẩm hoặc trải nghiệm của bạn.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('vendor.stories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tạo câu chuyện mới
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @if($stories->count() > 0)
            @foreach($stories as $story)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($story->image_path)
                            <img src="{{ asset('storage/' . $story->image_path) }}" class="card-img-top" alt="Story image" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex justify-content-center align-items-center" style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $story->title ?? 'Câu chuyện không tiêu đề' }}</h5>
                            <p class="card-text text-muted small">
                                <i class="far fa-clock me-1"></i>
                                {{ $story->created_at->format('d/m/Y H:i') }}
                            </p>
                            <p class="card-text">{{ Str::limit($story->content, 100) }}</p>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('vendor.stories.edit', $story) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit me-1"></i>Chỉnh sửa
                                </a>
                                <form action="{{ route('vendor.stories.destroy', $story) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa câu chuyện này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt me-1"></i>Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-warning text-center py-5">
                    <i class="fas fa-book fa-3x mb-3"></i>
                    <h3>Chưa có câu chuyện nào</h3>
                    <p>Hãy bắt đầu chia sẻ câu chuyện của bạn với người dùng!</p>
                    <a href="{{ route('vendor.stories.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Tạo câu chuyện đầu tiên
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 