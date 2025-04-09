@extends('admin.layouts.app')

@section('title', 'Quản lý bài viết')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý bài viết</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tạo bài viết mới
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($posts->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Chưa có bài viết nào. Hãy tạo bài viết đầu tiên!</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>Địa chỉ</th>
                                <th>Người đăng</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>
                                        <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td>{{ $post->address }}</td>
                                    <td>{{ $post->user->name ?? 'Anonymous' }}</td>
                                    <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-success">Đã đăng</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info" title="Xem">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection