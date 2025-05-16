<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Trustlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LodgingController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('type', 1)->with('images');
        
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

        return view('pages.listings.lodging', compact('posts', 'hasMore'));
    }

    public function search(Request $request)
    {
        $query = Post::where('type', 1)->with('images');
        
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
            $html = view('pages.listings.posts', compact('posts'))->render();
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
        // Search by name/title and description
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        // Filter by price range
        if ($request->has('price')) {
            $price = $request->input('price');
            if ($price == 'budget') {
                $query->where('price', '<', 500000); // Under 500k VND per night
            } elseif ($price == 'mid') {
                $query->whereBetween('price', [500000, 1500000]); // 500k-1.5M VND
            } elseif ($price == 'luxury') {
                $query->where('price', '>', 1500000); // Over 1.5M VND
            }
        }
        
        // Filter by accommodation type/style
        if ($request->has('style') && is_array($request->input('style'))) {
            $styles = $request->input('style');
            if (!empty($styles)) {
                $query->where(function($q) use ($styles) {
                    foreach ($styles as $style) {
                        // Assuming style values are stored in tags or attributes
                        $q->orWhere('tags', 'like', "%{$style}%")
                          ->orWhere('attributes', 'like', "%{$style}%");
                    }
                });
            }
        }
        
        // Filter by amenities/facilities
        if ($request->has('amenities') && is_array($request->input('amenities'))) {
            $amenities = $request->input('amenities');
            if (!empty($amenities)) {
                $query->where(function($q) use ($amenities) {
                    foreach ($amenities as $amenity) {
                        $q->orWhere('amenities', 'like', "%{$amenity}%");
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
                case 'homestay':
                    $query->where('tags', 'like', '%homestay%');
                    break;
                case 'hotel':
                    $query->where('tags', 'like', '%hotel%');
                    break;
                case 'apartment':
                    $query->where('tags', 'like', '%apartment%');
                    break;
                case 'view':
                    $query->where('tags', 'like', '%view%');
                    break;
            }
        }
        
        // Sort results
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch($sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
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
            $post = Post::with('images')
                ->where('type', 1) // Type 1 for accommodations
                ->findOrFail($id);

            // Kiểm tra trạng thái yêu thích
            if (Auth::check()) {
                $post->isSaved = Trustlist::where('user_id', Auth::id())
                    ->where('post_id', $post->id)
                    ->exists();
            } else {
                $post->isSaved = false;
            }

            Log::info('Accommodation detail loaded', ['post_id' => $id, 'post' => $post]);

            return view('pages.listings.detail', compact('post'));
        } catch (\Exception $e) {
            Log::error('Error loading accommodation detail', [
                'post_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('lodging')->with('error', 'Không tìm thấy bài viết');
        }
    }

    public function loadMore(Request $request)
    {
        $offset = $request->input('offset', 30);
        
        // Get base query with type = 1 (lodging)
        $query = Post::where('type', 1);
        
        // Apply all filters from request
        $query = $this->applyFilters($request, $query);
        
        // Get total count with these filters
        $totalFilteredCount = $query->count();
        
        Log::info('Load more request - Lodging (filtered)', [
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
            $html = view('pages.listings.posts', compact('posts'))->render();
        }
        
        Log::info('Load more response - Lodging (filtered)', [
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
