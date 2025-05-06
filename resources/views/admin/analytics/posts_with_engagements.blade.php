@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <h1 class="h3 mb-4 text-gray-800">Bài viết có tương tác (Reviews & Trustlist)</h1>

    <!-- Thông tin tổng quan -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Bài viết có reviews</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $postsWithReviews }} ({{ $reviewRate }}%)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
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
                                Bài viết có trustlist</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $postsWithTrustlist }} ({{ $trustlistRate }}%)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bookmark fa-2x text-gray-300"></i>
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
                                Bài viết có cả reviews và trustlist</div>
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
                                Tỷ lệ tương tác 7 ngày qua</div>
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

    <!-- Biểu đồ tỷ lệ tương tác -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tỷ lệ bài viết có tương tác theo ngày</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="engagementRateChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bộ lọc thời gian -->
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Bộ lọc thời gian</h6>
                    <form action="{{ route('admin.analytics.posts_with_engagements') }}" method="GET" class="d-flex">
                        <select name="time_filter" class="form-control mr-2">
                            <option value="all" {{ $timeFilter == 'all' ? 'selected' : '' }}>Tất cả thời gian</option>
                            <option value="day" {{ $timeFilter == 'day' ? 'selected' : '' }}>Hôm nay</option>
                            <option value="week" {{ $timeFilter == 'week' ? 'selected' : '' }}>Tuần này</option>
                            <option value="month" {{ $timeFilter == 'month' ? 'selected' : '' }}>Tháng này</option>
                            <option value="year" {{ $timeFilter == 'year' ? 'selected' : '' }}>Năm này</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Áp dụng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 10 bài viết có tương tác cao nhất -->
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top 10 bài viết có tương tác cao nhất</h6>
                    <small class="text-muted">({{ $timeFilter == 'all' ? 'Tất cả thời gian' : 
                        ($timeFilter == 'day' ? 'Hôm nay' : 
                        ($timeFilter == 'week' ? 'Tuần này' : 
                        ($timeFilter == 'month' ? 'Tháng này' : 'Năm này'))) }})</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tiêu đề bài viết</th>
                                    <th>Tác giả</th>
                                    <th>Loại</th>
                                    <th>Số reviews</th>
                                    <th>Số trustlist</th>
                                    <th>Tổng tương tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topEngagementPosts as $index => $post)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ $post['url'] }}" target="_blank" class="text-decoration-none">
                                            {{ $post['title'] }}
                                        </a>
                                    </td>
                                    <td>{{ $post['author_name'] }}</td>
                                    <td>{{ $post['type'] }}</td>
                                    <td>{{ $post['review_count'] }}</td>
                                    <td>{{ $post['trustlist_count'] }}</td>
                                    <td>{{ $post['total_engagement'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ so sánh -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">So sánh số lượng bài viết và bài viết có tương tác</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="compareChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
    // Dữ liệu cho biểu đồ
    const labels = @json($labels);
    const engagementRates = @json($engagementRates);
    const postCounts = @json($postCounts);
    const engagedPostCounts = @json($engagedPostCounts);

    // Tạo biểu đồ tỷ lệ
    const rateCtx = document.getElementById('engagementRateChart').getContext('2d');
    const engagementRateChart = new Chart(rateCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tỷ lệ bài viết có tương tác (%)',
                    data: engagementRates,
                    borderColor: 'rgba(78, 115, 223, 1)',
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHitRadius: 10,
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw + '%';
                        }
                    }
                }
            }
        }
    });

    // Tạo biểu đồ so sánh
    const compareCtx = document.getElementById('compareChart').getContext('2d');
    const compareChart = new Chart(compareCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tổng số bài viết',
                    data: postCounts,
                    backgroundColor: 'rgba(78, 115, 223, 0.7)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Bài viết có tương tác',
                    data: engagedPostCounts,
                    backgroundColor: 'rgba(28, 200, 138, 0.7)',
                    borderColor: 'rgba(28, 200, 138, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
