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

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-4" id="postTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ !request('type') ? 'active' : '' }}" href="#" role="tab">
                            Tất cả
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request('type') == 1 ? 'active' : '' }}"
                            href="{{ route('posts.index', ['type' => 1]) }}" role="tab">
                            Du lịch
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request('type') == 2 ? 'active' : '' }}"
                            href="{{ route('posts.index', ['type' => 2]) }}" role="tab">
                            Ẩm thực
                        </a>
                    </li>
                </ul>

                @if ($posts->isEmpty())
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Chưa có bài viết nào.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tiêu đề</th>
                                    <th>Địa chỉ</th>
                                    <th>Người đăng</th>
                                    <th>Ngày tạo</th>
                                    <th>Loại</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $stt = 1;
                                @endphp
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $stt++ }}</td>
                                        <td class="text-overflow-ellipsis">{{ $post->title }}</td>
                                        <td>{{ $post->address }}</td>
                                        <td>{{ $post->user->name }}</td>
                                        <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if ($post->type == 1)
                                                <span class="badge bg-primary">Du lịch</span>
                                            @elseif ($post->type == 2)
                                                <span class="badge bg-success">Ẩm thực</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('posts.show', $post) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
