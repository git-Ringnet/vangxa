<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Trustlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DiningController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('type', 2)->with('images');
        
        // Apply any filters from URL parameters
        $query = $this->applyFilters($request, $query);
        
        // Get total count with these filters
        $totalFilteredCount = $query->count();
        
        // Get posts with pagination
        $posts = $query->limit(30)->get();
        
        $userTrustlist = [];
        if (Auth::check()) {
            $userTrustlist = Trustlist::where('user_id', Auth::id())
                ->pluck('post_id')
                ->toArray();
        }

        foreach ($posts as $post) {
            $post->isSaved = in_array($post->id, $userTrustlist);
        }
        
        // Check if there are more posts to load
        $hasMore = $totalFilteredCount > 30;

        return view('pages.dining.dining', compact('posts', 'hasMore'));
    }

    public function search(Request $request)
    {
        $query = Post::where('type', 2)->with('images');
        
        // Apply filters
        $query = $this->applyFilters($request, $query);
        
        // Get total count with these filters
        $totalFilteredCount = $query->count();
        
        // Get first 30 posts
        $posts = $query->limit(30)->get();
        
        // Check for saved posts if user is logged in
        if (Auth::check()) {
            $userTrustlist = Trustlist::where('user_id', Auth::id())
                ->pluck('post_id')
                ->toArray();

            foreach ($posts as $post) {
                $post->isSaved = in_array($post->id, $userTrustlist);
            }
        } else {
            foreach ($posts as $post) {
                $post->isSaved = false;
            }
        }
        
        $html = '';
        if ($posts->count() > 0) {
            $html = view('pages.dining.posts', compact('posts'))->render();
        }
        
        // Determine if there are more posts
        $hasMore = $totalFilteredCount > 30;

        return response()->json([
            'html' => $html,
            'count' => $totalFilteredCount,
            'hasMore' => $hasMore
        ]);
    }
    
    /**
     * Apply filters to the query
     */
    private function applyFilters(Request $request, $query)
    {
        // Search by name/title
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by price range
        if ($request->has('price')) {
            $price = $request->input('price');
            if ($price == '50') {
                $query->where('min_price', '<', 50000);
            } elseif ($price == '100') {
                $query->whereBetween('min_price', [50000, 100000]);
            } elseif ($price == '101') {
                $query->where('min_price', '>', 100000);
            }
        }
        
        // Filter by style
        if ($request->has('style') && is_array($request->input('style'))) {
            $styles = $request->input('style');
            if (!empty($styles)) {
                $query->where(function($q) use ($styles) {
                    foreach ($styles as $style) {
                        // Search in JSON array
                        $q->orWhereRaw('JSON_CONTAINS(styles, ?)', ['"' . $style . '"']);
                    }
                });
            }
        }
        
        // Quick filter
        if ($request->has('quickFilter') && $request->input('quickFilter') != 'all') {
            $filter = $request->input('quickFilter');
            
            switch($filter) {
                case 'nearby':
                    // Implement location-based filtering logic
                    // This would require geolocation data
                    break;
                case 'cheap':
                    $query->where('min_price', '<', 50000);
                    break;
                case 'snack':
                    $query->whereRaw('JSON_CONTAINS(styles, ?)', ['"snack"']);
                    break;
                case 'stylish':
                    $query->whereRaw('JSON_CONTAINS(styles, ?)', ['"stylish"']);
                    break;
                case 'cool':
                    $query->whereRaw('JSON_CONTAINS(styles, ?)', ['"cool"']);
                    break;
            }
        }
        
        // Sort results
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch($sort) {
                case 'price_asc':
                    $query->orderBy('min_price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('min_price', 'desc');
                    break;
                case 'rating_desc':
                    $query->orderBy('rating', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }
        
        return $query;
    }

    public function detail($id)
    {
        try {
            if (!is_numeric($id) || $id <= 0) {
                throw new \Exception('ID bài đăng không hợp lệ');
            }
            $post = Post::with(['images', 'reviews.user'])
                ->where('type', 2) // Type 2 for dining
                ->findOrFail($id);

            Log::info('Dining detail loaded', ['post_id' => $id, 'post' => $post]);

            // Kiểm tra xem người dùng đã đăng nhập chưa và đã yêu thích bài viết chưa
            $isFavorited = false;
            if (Auth::check()) {
                $isFavorited = Trustlist::where('user_id', Auth::id())
                    ->where('post_id', $post->id)
                    ->exists();
            }

            return view('pages.dining.detail-dining', compact('post', 'isFavorited'));
        } catch (\Exception $e) {
            Log::error('Error loading dining detail', [
                'post_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('dining')->with('error', 'Không tìm thấy bài viết');
        }
    }

    public function loadMore(Request $request)
    {
        $offset = $request->input('offset', 30);
        
        // Get base query with type = 2 (dining)
        $query = Post::where('type', 2);
        
        // Apply all filters from request
        $query = $this->applyFilters($request, $query);
        
        // Get total count with these filters
        $totalFilteredCount = $query->count();
        
        Log::info('Load more request - Dining (filtered)', [
            'offset' => $offset,
            'totalFilteredCount' => $totalFilteredCount,
            'filters' => $request->except(['offset'])
        ]);
        
        // Calculate remaining posts with applied filters
        $remainingPosts = $totalFilteredCount - $offset;
        // Take up to 30 more posts
        $takeCount = min(30, max(0, $remainingPosts));
        
        // Get posts with applied filters, skipping offset
        $posts = $query->with('images')
            ->skip($offset)
            ->take($takeCount)
            ->get();
            
        // Check for saved posts
        if (Auth::check()) {
            $userTrustlist = Trustlist::where('user_id', Auth::id())
                ->pluck('post_id')
                ->toArray();
                
            foreach ($posts as $post) {
                $post->isSaved = in_array($post->id, $userTrustlist);
            }
        } else {
            foreach ($posts as $post) {
                $post->isSaved = false;
            }
        }

        // Determine if there are more posts with these filters
        $hasMore = ($offset + $takeCount) < $totalFilteredCount;
        
        $html = '';
        if ($posts->count() > 0) {
            $html = view('pages.dining.posts', compact('posts'))->render();
        }
        
        Log::info('Load more response - Dining (filtered)', [
            'postsCount' => count($posts),
            'hasMore' => $hasMore,
            'nextOffset' => $offset + $takeCount
        ]);

        return response()->json([
            'html' => $html,
            'hasMore' => $hasMore,
            'total' => $totalFilteredCount,
            'nextOffset' => $offset + $takeCount
        ]);
    }
}
