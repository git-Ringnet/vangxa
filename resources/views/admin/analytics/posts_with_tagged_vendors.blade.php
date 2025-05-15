@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <h1 class="h3 mb-4 text-gray-800">Thống kê bài đăng có gắn thẻ vendor</h1>

    <!-- Bộ lọc thời gian -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bộ lọc</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('analytics.posts-with-tagged-vendors') }}" method="GET" class="d-flex align-items-center">
                <div class="form-group mb-0 mr-3">
                    <label for="time_filter" class="mr-2">Khoảng thời gian:</label>
                    <select class="form-control" id="time_filter" name="time_filter" onchange="this.form.submit()">
                        <option value="all" {{ $timeFilter == 'all' ? 'selected' : '' }}>Tất cả thời gian</option>
                        <option value="day" {{ $timeFilter == 'day' ? 'selected' : '' }}>24 giờ qua</option>
                        <option value="week" {{ $timeFilter == 'week' ? 'selected' : '' }}>7 ngày qua</option>
                        <option value="month" {{ $timeFilter == 'month' ? 'selected' : '' }}>30 ngày qua</option>
                        <option value="year" {{ $timeFilter == 'year' ? 'selected' : '' }}>365 ngày qua</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Thông tin tổng quan -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng số bài đăng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPosts }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
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
                                Bài đăng có gắn thẻ vendor</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $postsWithTaggedVendors }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
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
                                Tỷ lệ gắn thẻ vendor (tổng thể)</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $overallTaggedRate }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $overallTaggedRate }}%"
                                            aria-valuenow="{{ $overallTaggedRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
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
                                Tỷ lệ gắn thẻ trong nhóm</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $groupTaggedRate }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $groupTaggedRate }}%"
                                            aria-valuenow="{{ $groupTaggedRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin chi tiết vendor -->
    <div class="row mb-4">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê vendor được gắn thẻ</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Tổng số vendor:</th>
                                <td>{{ $totalVendors }}</td>
                            </tr>
                            <tr>
                                <th>Số vendor đã được gắn thẻ:</th>
                                <td>{{ $distinctTaggedVendors }}</td>
                            </tr>
                            <tr>
                                <th>Tỷ lệ vendor đã được gắn thẻ:</th>
                                <td>{{ $vendorTaggedRate }}%</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê 7 ngày gần đây</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Số bài đăng trong 7 ngày qua:</th>
                                <td>{{ $postsLast7Days }}</td>
                            </tr>
                            <tr>
                                <th>Số bài đăng có gắn thẻ:</th>
                                <td>{{ $taggedPostsLast7Days }}</td>
                            </tr>
                            <tr>
                                <th>Tỷ lệ bài đăng có gắn thẻ:</th>
                                <td>{{ $weeklyTaggedRate }}%</td>
                            </tr>
                            <tr>
                                <th>Số bài đăng trong nhóm:</th>
                                <td>{{ $groupPostsLast7Days }}</td>
                            </tr>
                            <tr>
                                <th>Số bài đăng trong nhóm có gắn thẻ:</th>
                                <td>{{ $taggedGroupPostsLast7Days }}</td>
                            </tr>
                            <tr>
                                <th>Tỷ lệ bài đăng trong nhóm có gắn thẻ:</th>
                                <td>{{ $weeklyGroupTaggedRate }}%</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ thống kê gắn thẻ theo ngày -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Biểu đồ tỷ lệ bài đăng có gắn thẻ vendor theo ngày</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="taggedVendorChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 10 vendor được gắn thẻ nhiều nhất -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top 10 vendor được gắn thẻ nhiều nhất</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Vendor</th>
                                    <th>Số lần được gắn thẻ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topTaggedVendors as $index => $vendor)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('profile.show', $vendor->id) }}" target="_blank">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $vendor->avatar ?? asset('image/default/avt.png') }}" class="rounded-circle mr-2" width="30" height="30">
                                                <span>{{ $vendor->name }}</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>{{ $vendor->tag_count }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Không có dữ liệu</td>
                                </tr>
                                @endforelse
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
    // Dữ liệu cho biểu đồ
    const labels = @json($labels);
    const vendorTaggedRates = @json($vendorTaggedRates);
    const postCounts = @json($postCounts);
    const taggedPostCounts = @json($taggedPostCounts);

    // Tạo biểu đồ
    const ctx = document.getElementById('taggedVendorChart').getContext('2d');
    const taggedVendorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tỷ lệ bài đăng có gắn thẻ vendor (%)',
                    type: 'line',
                    data: vendorTaggedRates,
                    borderColor: 'rgba(78, 115, 223, 1)',
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'Số bài đăng',
                    type: 'bar',
                    data: postCounts,
                    backgroundColor: 'rgba(28, 200, 138, 0.4)',
                    borderColor: 'rgba(28, 200, 138, 1)',
                    borderWidth: 1,
                    yAxisID: 'y1'
                },
                {
                    label: 'Số bài đăng có gắn thẻ',
                    type: 'bar',
                    data: taggedPostCounts,
                    backgroundColor: 'rgba(246, 194, 62, 0.4)',
                    borderColor: 'rgba(246, 194, 62, 1)',
                    borderWidth: 1,
                    yAxisID: 'y1'
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
                        display: false,
                    }
                },
                y: {
                    position: 'left',
                    beginAtZero: true,
                    grid: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    },
                    ticks: {
                        max: 100,
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                y1: {
                    position: 'right',
                    beginAtZero: true,
                    grid: {
                        display: false,
                    },
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    titleMarginBottom: 10,
                    titleColor: '#6e707e',
                    titleFont: {
                        size: 14
                    },
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    padding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.datasetIndex === 0) {
                                label += context.raw + '%';
                            } else {
                                label += context.raw;
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush 