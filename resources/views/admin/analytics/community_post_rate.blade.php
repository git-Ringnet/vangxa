@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <h1 class="h3 mb-4 text-gray-800">Tỷ lệ người dùng đăng bài trong cộng đồng (% of users who post in community)</h1>

    <!-- Thông tin tổng quan -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng số người dùng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                Người dùng đã đăng bài trong cộng đồng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usersWithCommunityPosts }} ({{ $userCommunityPostRate }}%)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-edit fa-2x text-gray-300"></i>
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
                                Bài đăng cộng đồng 7 ngày qua</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $communityPostsLast7Days }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
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
                                Tỷ lệ đăng bài 7 ngày qua</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $weeklyCommunityPostRate }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ tỷ lệ đăng bài -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tỷ lệ người dùng đăng bài trong cộng đồng theo ngày (%)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="communityPostRateChart"></canvas>
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
                    <h6 class="m-0 font-weight-bold text-primary">So sánh người dùng và bài đăng trong cộng đồng</h6>
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
    const communityPostRates = @json($communityPostRates);
    const activeUserCounts = @json($activeUserCounts);
    const postUserCounts = @json($postUserCounts);
    const postCounts = @json($postCounts);

    // Tạo biểu đồ tỷ lệ
    const rateCtx = document.getElementById('communityPostRateChart').getContext('2d');
    const communityPostRateChart = new Chart(rateCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tỷ lệ người dùng đăng bài trong cộng đồng (%)',
                    data: communityPostRates,
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
                    data: activeUserCounts,
                    backgroundColor: 'rgba(78, 115, 223, 0.8)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                },
                {
                    label: 'Người dùng đăng bài cộng đồng',
                    data: postUserCounts,
                    backgroundColor: 'rgba(28, 200, 138, 0.8)',
                    borderColor: 'rgba(28, 200, 138, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                },
                {
                    label: 'Số bài đăng cộng đồng',
                    data: postCounts,
                    backgroundColor: 'rgba(246, 194, 62, 0.8)',
                    borderColor: 'rgba(246, 194, 62, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
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
                    mode: 'index'
                }
            }
        }
    });
</script>
@endpush
