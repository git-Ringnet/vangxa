@extends('layouts.main')

@section('title', 'Bảng xếp hạng')

@section('content')
<div class="leaderboard-container" style="padding-top: 100px;">
    <div class="leaderboard-header">
        <h1>Bảng xếp hạng</h1>
        <div class="leaderboard-filters">
            <div class="filter-group">
                <label>Thời gian:</label>
                <select id="timeFilter" class="filter-select">
                <option value="all selected">Tất cả</option>
                    <option value="week">Tuần này</option>
                    <option value="month">Tháng này</option>
                    <option value="year">Năm nay</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Loại:</label>
                <select id="typeFilter" class="filter-select">
                    <option value="all" selected>Tất cả</option>
                    <option value="post">Bài viết</option>
                    <option value="trustlist">Trustlist</option>
                    <option value="share">Chia sẻ</option>
                </select>
            </div>
        </div>
    </div>

    @auth
        <div class="user-stats-card">
            <div class="user-info">
                <img src="/image/anh.png" alt="Avatar" class="user-avatar">
                <div class="user-details">
                    <h3>{{ auth()->user()->name }}</h3>
                    <div class="user-rank">
                        <span class="rank">#{{ $userRank ?? 'Chưa có' }}</span>
                        <span class="tier {{ strtolower($userTier) }}">{{ $userTier }}</span>
                    </div>
                </div>
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label">Điểm số</span>
                    <span class="stat-value">{{ number_format($userPoints) }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Bài viết</span>
                    <span class="stat-value">{{ $userStats['posts'] ?? 0 }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Trustlist</span>
                    <span class="stat-value">{{ $userStats['trustlist'] ?? 0 }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Chia sẻ</span>
                    <span class="stat-value">{{ $userStats['share'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    @endauth

    <div class="leaderboard-list">
        @foreach($leaderboard as $index => $entry)
            <div class="leaderboard-item {{ $index < 3 ? 'top-three rank-' . ($index + 1) : '' }}">
                <div class="rank">
                    @if($index < 3)
                        <i class="fas fa-crown"></i>
                    @else
                        {{ $index + 1 }}
                    @endif
                </div>
                <img src="{{ $entry->user->avatar ?? asset('image/anh.jpg') }}" alt="User" class="user-avatar">
                <div class="user-info">
                    <h4>{{ $entry->user->name }}</h4>
                    <div class="user-stats">
                        <div class="stat">
                            <i class="fas fa-comment"></i>
                            <span>{{ $entry->posts_count }} bài viết</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-bookmark"></i>
                            <span>{{ $entry->trustlist_count }} trustlist</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-share"></i>
                            <span>{{ $entry->share_count }} chia sẻ</span>
                        </div>
                    </div>
                </div>
                <div class="score-section">
                    <div class="total-score">{{ number_format($entry->total_points) }} điểm</div>
                    <div class="tier {{ strtolower($entry->tier) }}">{{ $entry->tier }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $leaderboard->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeFilter = document.getElementById('timeFilter');
    const typeFilter = document.getElementById('typeFilter');
    const leaderboardList = document.querySelector('.leaderboard-list');
    const userStatsCard = document.querySelector('.user-stats-card');

    function updateLeaderboardUI(data) {
        // Cập nhật danh sách leaderboard
        let leaderboardHtml = '';
        data.leaderboard.forEach((entry, index) => {
            leaderboardHtml += `
                <div class="leaderboard-item ${index < 3 ? 'top-three rank-' + (index + 1) : ''}">
                    <div class="rank">
                        ${index < 3 ? '<i class="fas fa-crown"></i>' : (index + 1)}
                    </div>
                    <img src="${entry.user.avatar || '/image/anh.jpg'}" alt="User" class="user-avatar">
                    <div class="user-info">
                        <h4>${entry.user.name}</h4>
                        <div class="user-stats">
                            <div class="stat">
                                <i class="fas fa-comment"></i>
                                <span>${entry.posts_count} bài viết</span>
                            </div>
                            <div class="stat">
                                <i class="fas fa-bookmark"></i>
                                <span>${entry.trustlist_count} trustlist</span>
                            </div>
                            <div class="stat">
                                <i class="fas fa-share"></i>
                                <span>${entry.share_count} chia sẻ</span>
                            </div>
                        </div>
                    </div>
                    <div class="score-section">
                        <div class="total-score">${entry.total_points.toLocaleString()} điểm</div>
                        <div class="tier ${entry.tier.toLowerCase()}">${entry.tier}</div>
                    </div>
                </div>
            `;
        });
        leaderboardList.innerHTML = leaderboardHtml;

        // Cập nhật thông tin người dùng nếu có
        if (data.userStats) {
            userStatsCard.innerHTML = `
                <div class="user-info">
                    <img src="${data.userStats.avatar || '/images/default-avatar.png'}" alt="Avatar" class="user-avatar">
                    <div class="user-details">
                        <h3>${data.userStats.name}</h3>
                        <div class="user-rank">
                            <span class="rank">#${data.userStats.rank || 'Chưa có'}</span>
                            <span class="tier ${data.userStats.tier.toLowerCase()}">${data.userStats.tier}</span>
                        </div>
                    </div>
                </div>
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-label">Điểm số</span>
                        <span class="stat-value">${data.userStats.points.toLocaleString()}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Bài viết</span>
                        <span class="stat-value">${data.userStats.posts || 0}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Trustlist</span>
                        <span class="stat-value">${data.userStats.trustlist || 0}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Chia sẻ</span>
                        <span class="stat-value">${data.userStats.share || 0}</span>
                    </div>
                </div>
            `;
        }
    }

    function updateLeaderboard() {
        const time = timeFilter.value;
        const type = typeFilter.value;
        
        fetch(`/leaderboard/filter?time=${time}&type=${type}`)
            .then(response => {
                if (!response.ok) {
                    console.error('Status:', response.status);
                    return response.text().then(text => {
                        throw new Error(`Network response was not ok: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data); // Ghi log dữ liệu nhận được
                
                // Kiểm tra cấu trúc dữ liệu và điều chỉnh
                const leaderboardData = {
                    leaderboard: data.data || [], // Sử dụng data.data thay vì data.leaderboard
                    userStats: data.userStats || null
                };
                
                updateLeaderboardUI(leaderboardData);
            })
            .catch(error => {
                console.error('Error details:', error);
                alert('Có lỗi xảy ra khi cập nhật bảng xếp hạng: ' + error.message);
            });
    }

    timeFilter.addEventListener('change', updateLeaderboard);
    typeFilter.addEventListener('change', updateLeaderboard);
});
</script>
@endsection