@extends('layouts.main')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 mb-0">Câu chuyện từ {{ $vendor->name }}</h1>
            <p class="text-muted">Khám phá câu chuyện thú vị về doanh nghiệp và trải nghiệm.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('profile.show', $vendor->id) }}" class="btn btn-outline-primary">
                <i class="fas fa-user me-2"></i>Xem hồ sơ
            </a>
        </div>
    </div>

    <div class="row">
        @if($stories->count() > 0)
            <div class="col-md-8">
                @foreach($stories as $story)
                    <div class="card mb-4 shadow-sm">
                        @if($story->image_path)
                            <img src="{{ asset('storage/' . $story->image_path) }}" class="card-img-top" alt="Story image" style="max-height: 400px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $vendor->avatar }}" class="rounded-circle me-3" width="50" height="50" alt="{{ $vendor->name }}">
                                <div>
                                    <h5 class="card-title mb-0">{{ $story->title ?? 'Câu chuyện từ ' . $vendor->name }}</h5>
                                    <p class="text-muted small mb-0">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $story->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="card-text story-content">
                                {!! nl2br(e($story->content)) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $vendor->avatar }}" class="rounded-circle me-3" width="80" height="80" alt="{{ $vendor->name }}">
                            <div>
                                <h5 class="mb-1">{{ $vendor->name }}</h5>
                                <p class="text-muted small mb-0">Thành viên từ {{ $vendor->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <hr>
                        <h6 class="mb-2">Thông tin liên hệ</h6>
                        @if(isset($vendor->phone))
                            <p class="mb-2">
                                <i class="fas fa-phone-alt me-2 text-muted"></i>{{ $vendor->phone }}
                            </p>
                        @endif
                        <p class="mb-2">
                            <i class="fas fa-envelope me-2 text-muted"></i>{{ $vendor->email }}
                        </p>
                        <hr>
                        <h6 class="mb-3">Câu chuyện ({{ $stories->count() }})</h6>
                        <div class="list-group list-group-flush">
                            @foreach($stories as $story)
                                <a href="#story-{{ $story->id }}" class="list-group-item list-group-item-action border-0 px-0">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 text-truncate">{{ $story->title ?? 'Câu chuyện không tiêu đề' }}</h6>
                                        <small>{{ $story->created_at->format('d/m/Y') }}</small>
                                    </div>
                                    <small class="text-muted">{{ Str::limit($story->content, 60) }}</small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                <div class="alert alert-warning text-center py-5">
                    <i class="fas fa-book fa-3x mb-3"></i>
                    <h3>Chưa có câu chuyện nào</h3>
                    <p>{{ $vendor->name }} chưa chia sẻ câu chuyện nào.</p>
                    <a href="{{ route('profile.show', $vendor->id) }}" class="btn btn-primary mt-3">
                        <i class="fas fa-user me-2"></i>Xem hồ sơ
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .story-content {
        font-size: 1.1rem;
        line-height: 1.7;
        white-space: pre-line;
    }
</style>
@endsection 