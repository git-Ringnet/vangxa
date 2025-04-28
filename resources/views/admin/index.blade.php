@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tạo bài viết mới
            </a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Total Posts Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card primary h-100 py-2">
              <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Tổng số bài viết</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPosts }}</div>
                   </div>
                            <div class="col-auto">
                                <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                </div>
              </div>
                    </div>
                </div>
                        </div>

            <!-- Total Images Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card success h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Tổng số hình ảnh</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalImages }}</div>
                        </div>
                            <div class="col-auto">
                                <i class="fas fa-images fa-2x text-gray-300"></i>
                        </div>
                        </div>
                        </div>
                </div>
            </div>

            <!-- Recent Posts Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card info h-100 py-2">
              <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Bài viết gần đây</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $recentPosts }}</div>
                    </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                    </div>
                    </div>
              </div>
            </div>
                </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Recent Posts Table -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Bài viết gần đây</h6>
                        <a href="#" class="btn btn-sm btn-primary">Xem tất cả</a>
              </div>
              <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tiêu đề</th>
                                        <th>Địa chỉ</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestPosts as $post)
                                        <tr>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->address }}</td>
                                            <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
