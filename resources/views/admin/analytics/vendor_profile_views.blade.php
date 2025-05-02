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
                                                <a href="{{ $vendor->url }}" target="_blank" class="text-decoration-none">
                                                    {{ $vendor->name }}
                                                </a>
                                            </td>
                                            <td>{{ $vendor->view_count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
                            callback: function (value) {
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
                            label: function (context) {
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
                        label: 'DAU',
                        data: dauCounts,
                        backgroundColor: 'rgba(78, 115, 223, 0.8)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Lượt xem hồ sơ người bán',
                        data: vendorViewCounts,
                        backgroundColor: 'rgba(28, 200, 138, 0.8)',
                        borderColor: 'rgba(28, 200, 138, 1)',
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
                    }
                }
            }
        });
    </script>
@endpush