@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <h1 class="h3 mb-4 text-gray-800">Bài viết cộng đồng có tương tác (Likes & Comments)</h1>

    <!-- Thông tin tổng quan -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Bài viết có comments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $postsWithComments }} ({{ $commentRate }}%)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Bài viết có likes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $postsWithLikes }} ({{ $likeRate }}%)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-thumbs-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Bài viết có cả comments và likes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $postsWithBoth }} ({{ $bothRate }}%)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Tổng số bài viết trong nhóm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPosts }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Phần biểu đồ thống kê hàng ngày đã được bỏ -->

    <!-- Danh sách bài viết có nhiều tương tác nhất -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Bộ lọc thời gian</h6>
                    <form action="{{ route('admin.analytics.community_posts_with_reactions') }}" method="GET" class="d-flex">
                        <select name="time_filter" class="form-control mr-2">
                            <option value="all" {{ $timeFilter == 'all' ? 'selected' : '' }}>Tất cả thời gian</option>
                            <option value="day" {{ $timeFilter == 'day' ? 'selected' : '' }}>Hôm nay</option>
                            <option value="week" {{ $timeFilter == 'week' ? 'selected' : '' }}>Tuần này</option>
                            <option value="month" {{ $timeFilter == 'month' ? 'selected' : '' }}>Tháng này</option>
                            <option value="year" {{ $timeFilter == 'year' ? 'selected' : '' }}>Năm nay</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </form>
                </div>
                <div class="card-body">
                    <h6 class="font-weight-bold">Top 10 bài viết có nhiều tương tác nhất {{ $timeFilter == 'all' ? '' : 'trong ' . [
                        'day' => 'hôm nay',
                        'week' => 'tuần này',
                        'month' => 'tháng này',
                        'year' => 'năm nay'
                    ][$timeFilter] }}</h6>
                    
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề bài viết</th>
                                    <th>Tác giả</th>
                                    <th>Nhóm</th>
                                    <th>Số comments</th>
                                    <th>Số likes</th>
                                    <th>Tổng tương tác</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topEngagementPosts as $post)
                                <tr>
                                    <td>{{ $post['id'] }}</td>
                                    <td>
                                        <a href="{{ $post['url'] }}" target="_blank">
                                            {{ Str::limit($post['title'], 50) }}
                                        </a>
                                    </td>
                                    <td>{{ $post['author_name'] }}</td>
                                    <td>{{ $post['group_name'] }}</td>
                                    <td>{{ $post['comment_count'] }}</td>
                                    <td>{{ $post['like_count'] }}</td>
                                    <td>{{ $post['total_engagement'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($post['created_at'])->format('d/m/Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Không có dữ liệu</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê tuần này -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê 7 ngày qua</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-left-primary mb-3">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Số bài viết cộng đồng tạo trong 7 ngày qua</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $postsLast7Days }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-left-success mb-3">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Bài viết có tương tác trong 7 ngày qua</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $engagedPostsLast7Days }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-left-info mb-3">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Tỷ lệ bài viết có tương tác trong 7 ngày qua</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $last7DaysRate }}%</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Đã loại bỏ JavaScript khởi tạo biểu đồ -->
@endsection
