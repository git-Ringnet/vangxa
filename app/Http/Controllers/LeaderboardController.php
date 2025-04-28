<?php

namespace App\Http\Controllers;

use App\Models\UserInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        // Lấy top 5 người dùng cho modal
        $topContributors = UserInteraction::getTopContributors(10);
        
        // Lấy dữ liệu cho trang chính
        $leaderboard = $this->getFilteredLeaderboard($request);
        
        // Lấy thông tin người dùng hiện tại nếu đã đăng nhập
        $userStats = null;
        $userRank = null;
        $userPoints = null;
        $userTier = null;
        
        if (Auth::check()) {
            $userStats = $this->getUserStats(Auth::id());
            $userRank = $this->getUserRank(Auth::id());
            $userPoints = $this->getUserPoints(Auth::id());
            $userTier = UserInteraction::getUserTier($userPoints);
        }

        if ($request->ajax()) {
            return response()->json([
                'leaderboard' => $leaderboard,
                'userStats' => $userStats,
                'userRank' => $userRank,
                'userPoints' => $userPoints,
                'userTier' => $userTier
            ]);
        }

        return view('leaderboard.index', compact(
            'leaderboard',
            'userStats',
            'userRank',
            'userPoints',
            'userTier'
        ));
    }

    public function getFilteredLeaderboard(Request $request)
    {
        try {
            $query = UserInteraction::query()
                ->select('user_id')
                ->selectRaw('SUM(points) as total_points')
                ->selectRaw('SUM(CASE WHEN interaction_type = "post" THEN 1 ELSE 0 END) as posts_count')
                ->selectRaw('SUM(CASE WHEN interaction_type = "trustlist" THEN 1 ELSE 0 END) as trustlist_count')
                ->selectRaw('SUM(CASE WHEN interaction_type = "share" THEN 1 ELSE 0 END) as share_count')
                ->groupBy('user_id');

            // Áp dụng bộ lọc thời gian
            if ($request->has('time')) {
                switch ($request->time) {
                    case 'week':
                        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year);
                        break;
                    case 'year':
                        $query->whereYear('created_at', now()->year);
                        break;
                }
            }

            // Áp dụng bộ lọc loại tương tác
            if ($request->has('type') && $request->type !== 'all') {
                $query->where('interaction_type', $request->type);
            }

            $leaderboard = $query->orderByDesc('total_points')
                ->with('user')
                ->paginate(10);

            // Thêm tier cho mỗi người dùng
            $leaderboard->getCollection()->transform(function ($item) {
                $item->tier = UserInteraction::getUserTier($item->total_points);
                return $item;
            });

            // Lấy thông tin người dùng hiện tại nếu đã đăng nhập
            $userStats = null;
            $userRank = null;
            $userPoints = null;
            $userTier = null;
            $tierUpgrade = null;
            
            if (Auth::check()) {
                $userStats = $this->getUserStats(Auth::id());
                $userRank = $this->getUserRank(Auth::id());
                $userPoints = $this->getUserPoints(Auth::id());
                $userTier = UserInteraction::getUserTier($userPoints);
                $tierUpgrade = UserInteraction::checkTierUpgrade(Auth::id());
            }

            if ($request->ajax()) {
                return response()->json([
                    'leaderboard' => $leaderboard->items(),
                    'userStats' => [
                        'name' => Auth::user()->name ?? null,
                        'avatar' => Auth::user()->avatar ?? null,
                        'rank' => $userRank,
                        'tier' => $userTier,
                        'points' => $userPoints,
                        'posts' => $userStats->posts ?? 0,
                        'trustlist' => $userStats->trustlist ?? 0,
                        'share' => $userStats->share ?? 0,
                        'tier_upgrade' => $tierUpgrade
                    ]
                ]);
            }

            return $leaderboard;
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Có lỗi xảy ra khi lấy dữ liệu'], 500);
            }
            return back()->with('error', 'Có lỗi xảy ra khi lấy dữ liệu');
        }
    }

    public function getUserStats($userId)
    {
        return UserInteraction::where('user_id', $userId)
            ->selectRaw('SUM(CASE WHEN interaction_type = "post" THEN 1 ELSE 0 END) as posts')
            ->selectRaw('SUM(CASE WHEN interaction_type = "trustlist" THEN 1 ELSE 0 END) as trustlist')
            ->selectRaw('SUM(CASE WHEN interaction_type = "share" THEN 1 ELSE 0 END) as share')
            ->first();
    }

    public function getUserRank($userId)
    {
        $rank = UserInteraction::select('user_id')
            ->selectRaw('SUM(points) as total_points')
            ->groupBy('user_id')
            ->orderByDesc('total_points')
            ->get()
            ->search(function ($item) use ($userId) {
                return $item->user_id == $userId;
            });

        return $rank !== false ? $rank + 1 : null;
    }

    public function getUserPoints($userId)
    {
        return UserInteraction::where('user_id', $userId)
            ->sum('points');
    }

    public function recordInteraction(Request $request)
    {
        $request->validate([
            'interaction_type' => 'required|in:post,trustlist,share'
        ]);

        UserInteraction::create([
            'user_id' => Auth::id(),
            'interaction_type' => $request->interaction_type,
            'points' => 1
        ]);

        // Kiểm tra thăng hạng sau mỗi lần tương tác
        $tierUpgrade = UserInteraction::checkTierUpgrade(Auth::id());

        // Nếu có thăng hạng, lưu vào session để hiển thị thông báo
        if ($tierUpgrade['upgraded']) {
            session()->flash('tier_upgrade', $tierUpgrade);
        }

        return response()->json([
            'message' => 'Interaction recorded successfully',
            'tier_upgrade' => $tierUpgrade
        ]);
    }

    public function checkTierUpgrade(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['upgraded' => false]);
        }

        $tierUpgrade = UserInteraction::checkTierUpgrade(Auth::id());

        if ($tierUpgrade['upgraded']) {
            // Lưu thông tin thăng hạng vào session để hiển thị thông báo
            session()->flash('tier_upgrade', $tierUpgrade);
        }

        return response()->json($tierUpgrade);
    }
} 