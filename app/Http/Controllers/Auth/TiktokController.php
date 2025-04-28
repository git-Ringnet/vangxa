<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TiktokController extends Controller
{
    /**
     * Redirect the user to TikTok authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToTiktok()
    {
        $state = Str::random(40);
        session(['tiktok_state' => $state]);

        // Debug: Kiểm tra các thông tin xác thực
        $client_key = config('services.tiktok.client_id');
        $redirect_uri = config('services.tiktok.redirect');
        
        \Log::info('TikTok OAuth Debug Info', [
            'client_key' => $client_key,
            'redirect_uri' => $redirect_uri,
            'app_url' => config('app.url'),
            'request_scheme' => request()->getScheme()
        ]);

        if (empty($client_key)) {
            \Log::error('TikTok client_key is empty. Check your .env file.');
            return redirect('/')->with('error', 'TikTok configuration is missing. Please contact administrator.');
        }

        $queryParams = http_build_query([
            'client_key' => $client_key,
            'redirect_uri' => $redirect_uri,
            'scope' => 'user.info.basic',
            'response_type' => 'code',
            'state' => $state,
        ]);

        $authUrl = 'https://www.tiktok.com/auth/authorize?' . $queryParams;
        \Log::info('TikTok Auth URL', ['url' => $authUrl]);

        return redirect($authUrl);
    }

    /**
     * Handle TikTok callback after authentication.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleTiktokCallback(Request $request)
    {
        try {
            // Debug: Log the callback parameters
            Log::info('TikTok callback received', $request->all());

            // Verify state to prevent CSRF attacks
            if ($request->state !== session('tiktok_state')) {
                Log::error('TikTok state mismatch', [
                    'session_state' => session('tiktok_state'),
                    'request_state' => $request->state
                ]);
                return redirect('/')->with('error', 'Invalid state parameter. Authentication failed.');
            }

            if ($request->has('error')) {
                Log::error('TikTok auth error', ['error' => $request->error, 'description' => $request->error_description]);
                return redirect('/')->with('error', 'TikTok authentication failed: ' . $request->error_description);
            }

            if (!$request->has('code')) {
                Log::error('TikTok code missing');
                return redirect('/')->with('error', 'Authorization code missing');
            }

            // Exchange code for access token
            $response = Http::post('https://open.tiktokapis.com/v2/oauth/token/', [
                'client_key' => config('services.tiktok.client_id'),
                'client_secret' => config('services.tiktok.client_secret'),
                'code' => $request->code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => config('services.tiktok.redirect'),
            ]);

            // Debug: Log the token response
            Log::info('TikTok token response', ['response' => $response->json()]);

            if (!$response->successful()) {
                Log::error('TikTok token error', ['response' => $response->json()]);
                return redirect('/')->with('error', 'Failed to get access token from TikTok');
            }

            $tokenData = $response->json();
            $accessToken = $tokenData['access_token'] ?? null;
            $openId = $tokenData['open_id'] ?? null;

            if (empty($accessToken) or empty($openId)) {
                Log::error('TikTok token data incomplete', ['token_data' => $tokenData]);
                return redirect('/')->with('error', 'Incomplete token data from TikTok');
            }

            // Get user info using the access token
            $userResponse = Http::withToken($accessToken)
                ->get('https://open.tiktokapis.com/v2/user/info/', [
                    'fields' => 'open_id,avatar_url,display_name,profile_deep_link'
                ]);

            // Debug: Log the user info response
            Log::info('TikTok user info response', ['response' => $userResponse->json()]);

            if (!$userResponse->successful()) {
                Log::error('TikTok user info error', ['response' => $userResponse->json()]);
                return redirect('/')->with('error', 'Failed to get user information from TikTok');
            }

            $userData = $userResponse->json()['data']['user'];
            
            // Find or create user
            $user = User::where('tiktok_id', $openId)->first();

            if (!$user) {
                // If user doesn't exist with TikTok ID, check if there's a logged-in user to connect
                if (Auth::check()) {
                    $user = Auth::user();
                    $user->tiktok_id = $openId;
                    $user->tiktok_token = $accessToken;
                    $user->save();

                    Log::info('Connected TikTok to existing user', ['user_id' => $user->id, 'tiktok_id' => $openId]);
                    return redirect('/')->with('success', 'Your TikTok account has been connected!');
                } else {
                    // Create new user from TikTok data
                    $user = User::create([
                        'name' => $userData['display_name'] ?? 'TikTok User',
                        'email' => $openId . '@tiktok.user', // Placeholder email
                        'password' => bcrypt(Str::random(24)),
                        'tiktok_id' => $openId,
                        'tiktok_token' => $accessToken,
                        'provider' => 'tiktok',
                        'avatar' => $userData['avatar_url'] ?? null,
                    ]);

                    Log::info('Created new user from TikTok', ['user_id' => $user->id, 'tiktok_id' => $openId]);
                }
            } else {
                // Update existing user's token
                $user->tiktok_token = $accessToken;
                $user->save();

                Log::info('Updated existing TikTok user', ['user_id' => $user->id, 'tiktok_id' => $openId]);
            }

            // Log the user in
            Auth::login($user, true);
            
            return redirect('/')->with('success', 'You have successfully logged in with TikTok!');
        } catch (Exception $e) {
            Log::error('TikTok auth exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect('/')->with('error', 'An error occurred during TikTok authentication: ' . $e->getMessage());
        }
    }
}
