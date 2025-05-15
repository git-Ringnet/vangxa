@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-4">
        <h1 class="h3 mb-4 text-gray-800">Tỷ lệ xem hồ sơ người bán (Vendor profile views)</h1>


        <!-- Thông tin tổng quan -->
        <div class="row mb-4">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Lượt xem người bán 7 ngày</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $vendorViewsLast7Days }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-eye fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Tỷ lệ xem 7 ngày qua (Vendor profile views / DAU)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $weeklyViewRate }}%</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percentage fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin tổng quan từ nguồn ngoài -->
        <div class="row mb-4">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <a href="#collapseExternalStats" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseExternalStats">
                        <h6 class="m-0 font-weight-bold text-primary">Thống kê lượt xem từ các nền tảng ngoài</h6>
                    </a>
                    <div class="collapse show" id="collapseExternalStats">
                        <div class="card-body">
                            @if($weeklyExternalStats['totalExternalViews'] > 0)
                                <div class="row">
                                    @foreach($weeklyExternalStats['weeklyExternalStats'] as $platform => $count)
                                    <div class="col-md-4 mb-4">
                                        <div class="card @if($platform == 'facebook') border-left-primary @elseif($platform == 'instagram') border-left-danger @elseif($platform == 'twitter') border-left-info @elseif($platform == 'tiktok') border-left-dark @elseif($platform == 'google') border-left-success @elseif($platform == 'youtube') border-left-danger @elseif($platform == 'linkedin') border-left-info @elseif($platform == 'pinterest') border-left-danger @elseif($platform == 'zalo') border-left-success @else border-left-secondary @endif shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold @if($platform == 'facebook') text-primary @elseif($platform == 'instagram') text-danger @elseif($platform == 'twitter') text-info @elseif($platform == 'tiktok') text-dark @elseif($platform == 'google') text-success @elseif($platform == 'youtube') text-danger @elseif($platform == 'linkedin') text-info @elseif($platform == 'pinterest') text-danger @elseif($platform == 'zalo') text-success @else text-secondary @endif text-uppercase mb-1">
                                                            Lượt xem từ {{ ucfirst($platform) }}</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count }} <small>({{ $weeklyExternalStats['totalExternalViews'] > 0 ? round(($count / $weeklyExternalStats['totalExternalViews']) * 100, 1) : 0 }}%)</small></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas @if($platform == 'facebook') fa-facebook @elseif($platform == 'instagram') fa-instagram @elseif($platform == 'twitter') fa-twitter @elseif($platform == 'tiktok') fa-tiktok @elseif($platform == 'google') fa-google @elseif($platform == 'youtube') fa-youtube @elseif($platform == 'linkedin') fa-linkedin @elseif($platform == 'pinterest') fa-pinterest @elseif($platform == 'zalo') fa-zalo @else fa-globe @endif fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="text-center">
                                    <p class="mb-0">Tổng lượt xem từ các nền tảng ngoài trong 7 ngày qua: <strong>{{ $weeklyExternalStats['totalExternalViews'] }}</strong></p>
                                </div>
                            @else
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle mr-2"></i> Chưa có dữ liệu lượt xem từ các nền tảng ngoài trong 7 ngày qua
                                </div>
                            @endif
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
                        <form action="{{ route('admin.analytics.vendor_profile_views') }}" method="GET" class="d-flex">
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

        <!-- Top 5 vendor có lượt xem cao nhất -->
        <div class="row mb-4">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Top 5 vendor có lượt xem cao nhất</h6>
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
                                        <th>Tên vendor</th>
                                        <th>Số lượng xem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topViewedVendors as $index => $vendor)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <a href="{{ $vendor['url'] }}" target="_blank" class="text-decoration-none">
                                                    {{ $vendor['name'] }}
                                                </a>
                                            </td>
                                            <td>{{ $vendor['view_count'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 5 vendor có lượt xem từ nền tảng ngoài cao nhất -->
        <div class="row mb-4">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Top 5 vendor có lượt xem từ nền tảng ngoài cao nhất</h6>
                        <small class="text-muted">({{ $timeFilter == 'all' ? 'Tất cả thời gian' :
        ($timeFilter == 'day' ? 'Hôm nay' :
            ($timeFilter == 'week' ? 'Tuần này' :
                ($timeFilter == 'month' ? 'Tháng này' : 'Năm này'))) }})</small>
                    </div>
                    <div class="card-body">
                        @if(count($topViewedFromExternal) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên vendor</th>
                                            <th>Nền tảng</th>
                                            <th>Số lượng xem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topViewedFromExternal as $index => $vendor)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <a href="{{ $vendor['url'] }}" target="_blank" class="text-decoration-none">
                                                        {{ $vendor['name'] }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill 
                                                        @if($vendor['referrer_platform'] == 'facebook') badge-primary 
                                                        @elseif($vendor['referrer_platform'] == 'instagram') badge-danger 
                                                        @elseif($vendor['referrer_platform'] == 'twitter') badge-info 
                                                        @elseif($vendor['referrer_platform'] == 'tiktok') badge-dark 
                                                        @elseif($vendor['referrer_platform'] == 'google') badge-success 
                                                        @elseif($vendor['referrer_platform'] == 'youtube') badge-danger 
                                                        @elseif($vendor['referrer_platform'] == 'linkedin') badge-info 
                                                        @elseif($vendor['referrer_platform'] == 'pinterest') badge-danger 
                                                        @elseif($vendor['referrer_platform'] == 'zalo') badge-success 
                                                        @else badge-secondary @endif">
                                                        {{ ucfirst($vendor['referrer_platform']) }}
                                                    </span>
                                                </td>
                                                <td>{{ $vendor['view_count'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle mr-2"></i> Chưa có dữ liệu lượt xem từ các nền tảng ngoài
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ tỷ lệ xem hồ sơ -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Tỷ lệ xem hồ sơ người bán theo ngày (%)</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="vendorViewRateChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ phân bố nguồn truy cập -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Phân bố lượt xem theo nguồn truy cập</h6>
                    </div>
                    <div class="card-body">
                        @if(count($platformStats) > 0)
                            <div class="chart-area">
                                <canvas id="platformDistributionChart"></canvas>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle mr-2"></i> Chưa có dữ liệu phân bố lượt xem từ các nền tảng
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ lượt xem theo nền tảng -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Lượt xem theo nền tảng trong 14 ngày qua</h6>
                    </div>
                    <div class="card-body">
                        @php 
                            $hasData = false;
                            foreach($dailyExternalStats['dailyExternalStats'] as $platformData) {
                                if(array_sum($platformData) > 0) {
                                    $hasData = true;
                                    break;
                                }
                            }
                        @endphp
                        
                        @if($hasData)
                            <div class="chart-area">
                                <canvas id="platformViewsChart"></canvas>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle mr-2"></i> Chưa có dữ liệu lượt xem theo nền tảng trong 14 ngày qua
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ so sánh -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">So sánh người dùng và lượt xem hồ sơ người bán</h6>
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
        const vendorViewRates = @json($vendorViewRates);
        const dauCounts = @json($dauCounts);
        const vendorViewCounts = @json($vendorViewCounts);

        // Dữ liệu cho các biểu đồ nền tảng
        const externalLabels = @json($dailyExternalStats['externalLabels']);
        const dailyExternalStats = @json($dailyExternalStats['dailyExternalStats']);
        const platformStats = @json($platformStats);
        
        // Màu sắc cho các nền tảng
        const platformColors = {
            'facebook': 'rgba(59, 89, 152, 0.7)',
            'instagram': 'rgba(193, 53, 132, 0.7)',
            'twitter': 'rgba(29, 161, 242, 0.7)',
            'tiktok': 'rgba(0, 0, 0, 0.7)',
            'google': 'rgba(66, 133, 244, 0.7)',
            'youtube': 'rgba(255, 0, 0, 0.7)',
            'linkedin': 'rgba(0, 119, 181, 0.7)',
            'pinterest': 'rgba(189, 8, 28, 0.7)',
            'zalo': 'rgba(0, 170, 238, 0.7)',
            'khác': 'rgba(128, 128, 128, 0.7)'
        };
        
        const platformBorderColors = {
            'facebook': 'rgba(59, 89, 152, 1)',
            'instagram': 'rgba(193, 53, 132, 1)',
            'twitter': 'rgba(29, 161, 242, 1)',
            'tiktok': 'rgba(0, 0, 0, 1)',
            'google': 'rgba(66, 133, 244, 1)',
            'youtube': 'rgba(255, 0, 0, 1)',
            'linkedin': 'rgba(0, 119, 181, 1)',
            'pinterest': 'rgba(189, 8, 28, 1)',
            'zalo': 'rgba(0, 170, 238, 1)',
            'khác': 'rgba(128, 128, 128, 1)'
        };

        // Tạo biểu đồ tỷ lệ
        const rateCtx = document.getElementById('vendorViewRateChart').getContext('2d');
        const vendorViewRateChart = new Chart(rateCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Tỷ lệ xem hồ sơ người bán (%)',
                        data: vendorViewRates,
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
                        backgroundColor: "rgb(255, 255, 255)",
                        bodyColor: "#858796",
                        titleMarginBottom: 10,
                        titleColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        padding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + '%';
                            }
                        }
                    }
                }
            }
        });

        // Biểu đồ phân bố nguồn truy cập
        const platformDistCtx = document.getElementById('platformDistributionChart').getContext('2d');
        const platformLabels = platformStats.map(item => item.referrer_platform);
        const platformData = platformStats.map(item => item.view_count);
        const platformColorsArray = platformLabels.map(platform => platformColors[platform] || 'rgba(128, 128, 128, 0.7)');
        const platformBorderColorsArray = platformLabels.map(platform => platformBorderColors[platform] || 'rgba(128, 128, 128, 1)');

        const platformDistChart = new Chart(platformDistCtx, {
            type: 'doughnut',
            data: {
                labels: platformLabels.map(label => label.charAt(0).toUpperCase() + label.slice(1)),
                datasets: [{
                    data: platformData,
                    backgroundColor: platformColorsArray,
                    borderColor: platformBorderColorsArray,
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((acc, curr) => acc + curr, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });

        // Biểu đồ lượt xem theo nền tảng
        const platformViewsCtx = document.getElementById('platformViewsChart').getContext('2d');
        const platformViewsDatasets = Object.keys(dailyExternalStats).map(platform => {
            return {
                label: platform.charAt(0).toUpperCase() + platform.slice(1),
                data: dailyExternalStats[platform],
                borderColor: platformBorderColors[platform] || 'rgba(128, 128, 128, 1)',
                backgroundColor: platformColors[platform] || 'rgba(128, 128, 128, 0.7)',
                fill: false,
                tension: 0.3,
                borderWidth: 2,
                pointRadius: 3,
                pointHoverRadius: 5
            };
        });

        const platformViewsChart = new Chart(platformViewsCtx, {
            type: 'line',
            data: {
                labels: externalLabels,
                datasets: platformViewsDatasets
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
                        label: 'Người dùng hoạt động (DAU)',
                        data: dauCounts,
                        backgroundColor: 'rgba(28, 200, 138, 0.2)',
                        borderColor: 'rgba(28, 200, 138, 1)',
                        borderWidth: 1,
                        pointRadius: 0,
                        type: 'line',
                        fill: true,
                        yAxisID: 'y1',
                    },
                    {
                        label: 'Lượt xem hồ sơ người bán',
                        data: vendorViewCounts,
                        backgroundColor: 'rgba(54, 185, 204, 0.5)',
                        borderColor: 'rgba(54, 185, 204, 1)',
                        borderWidth: 1,
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
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Lượt xem hồ sơ'
                        },
                        beginAtZero: true,
                        grid: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    },
                    y1: {
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Người dùng hoạt động'
                        },
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false,
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
@endpush