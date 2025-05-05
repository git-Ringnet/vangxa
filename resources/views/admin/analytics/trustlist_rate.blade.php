@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <h1 class="h3 mb-4 text-gray-800">Tỷ lệ lưu vào danh sách tin cậy (Save-to-Trustlist)</h1>

    <!-- Thông tin tổng quan -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng lượt lưu vào Trustlist</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTrustlists }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bookmark fa-2x text-gray-300"></i>
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
                                Người dùng sử dụng Trustlist</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usersWithTrustlist }} ({{ $userAdoptionRate }}%)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                Trung bình Trustlist/Người dùng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $avgTrustlistsPerUser }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
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
                                Tỷ lệ Trustlist 7 ngày qua</div>
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

    <!-- Biểu đồ tỷ lệ Trustlist -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tỷ lệ lưu vào Trustlist theo ngày</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="trustlistRateChart"></canvas>
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
                    <form action="{{ route('admin.analytics.trustlist_rate') }}" method="GET" class="d-flex">
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

    <!-- Top 10 bài viết có lượt trustlist cao nhất -->
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top 10 bài viết có lượt trustlist cao nhất</h6>
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
                                    <th>Số lượng trustlist</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topTrustlistedPosts as $index => $post)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ $post->url }}" target="_blank" class="text-decoration-none">
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td>{{ $post->trustlist_count }}</td>
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
                    <h6 class="m-0 font-weight-bold text-primary">So sánh người dùng và lượt lưu Trustlist</h6>
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
    const trustlistRates = @json($trustlistRates);
    const viewCounts = @json($viewCounts);
    const trustlistCounts = @json($trustlistCounts);

    // Tạo biểu đồ tỷ lệ
    const rateCtx = document.getElementById('trustlistRateChart').getContext('2d');
    const trustlistRateChart = new Chart(rateCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tỷ lệ Save-to-Trustlist (%)',
                    data: trustlistRates,
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
                    yAxisID: 'y',
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
                    beginAtZero: true,
                    grid: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
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
                            label += context.parsed.y + '%';
                            return label;
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
                    label: 'Người dùng hoạt động',
                    data: viewCounts,
                    backgroundColor: 'rgba(28, 200, 138, 0.2)',
                    borderColor: 'rgba(28, 200, 138, 1)',
                    borderWidth: 1,
                    yAxisID: 'y',
                },
                {
                    label: 'Lượt lưu vào Trustlist',
                    data: trustlistCounts,
                    backgroundColor: 'rgba(246, 194, 62, 0.2)',
                    borderColor: 'rgba(246, 194, 62, 1)',
                    borderWidth: 1,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Người dùng'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Lượt lưu Trustlist'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            },
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
</script>
@endpush
