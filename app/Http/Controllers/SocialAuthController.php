<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        $config = config('social_auth.google');
        $params = http_build_query([
            'client_id' => $config['client_id'],
            'redirect_uri' => $config['redirect_uri'],
            'response_type' => 'code',
            'scope' => $config['scope'],
            'state' => 'google',
        ]);

        return redirect($config['auth_url'] . '?' . $params);
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(Request $request)
    {
        $code = $request->get('code');
        $state = $request->get('state');

        if ($state !== 'google') {
            return redirect('/login')->with('error', 'Invalid state parameter');
        }

        // Exchange code for access token
        $config = config('social_auth.google');
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => $config['client_id'],
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $config['redirect_uri'],
        ]);

        if ($response->successful()) {
            $tokenData = $response->json();
            $accessToken = $tokenData['access_token'];

            // Get user info
            $userResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v2/userinfo');
            
            if ($userResponse->successful()) {
                $userData = $userResponse->json();
                $user = $this->findOrCreateUser($userData, 'google');
                Auth::login($user);
                return redirect('/');
            }
        }

        return redirect('/login')->with('error', 'Failed to authenticate with Google');
    }

    /**
     * Redirect to Apple OAuth
     */
    public function redirectToApple()
    {
        $config = config('social_auth.apple');
        $params = http_build_query([
            'client_id' => $config['client_id'],
            'redirect_uri' => $config['redirect_uri'],
            'response_type' => 'code',
            'scope' => $config['scope'],
            'state' => 'apple',
        ]);

        return redirect($config['auth_url'] . '?' . $params);
    }

    /**
     * Handle Apple OAuth callback
     */
    public function handleAppleCallback(Request $request)
    {
        // Apple OAuth implementation would go here
        return redirect('/login')->with('error', 'Apple OAuth not implemented yet');
    }

    /**
     * Redirect to Facebook OAuth
     */
    public function redirectToFacebook()
    {
        $config = config('social_auth.facebook');
        $params = http_build_query([
            'client_id' => $config['app_id'],
            'redirect_uri' => $config['redirect_uri'],
            'response_type' => 'code',
            'scope' => $config['scope'],
            'state' => 'facebook',
        ]);

        return redirect($config['auth_url'] . '?' . $params);
    }

    /**
     * Handle Facebook OAuth callback
     */
    public function handleFacebookCallback(Request $request)
    {
        // Facebook OAuth implementation would go here
        return redirect('/login')->with('error', 'Facebook OAuth not implemented yet');
    }

    /**
     * Redirect to Twitter OAuth
     */
    public function redirectToTwitter()
    {
        $config = config('social_auth.twitter');
        $params = http_build_query([
            'client_id' => $config['client_id'],
            'redirect_uri' => $config['redirect_uri'],
            'response_type' => 'code',
            'scope' => $config['scope'],
            'state' => 'twitter',
        ]);

        return redirect($config['auth_url'] . '?' . $params);
    }

    /**
     * Handle Twitter OAuth callback
     */
    public function handleTwitterCallback(Request $request)
    {
        // Twitter OAuth implementation would go here
        return redirect('/login')->with('error', 'Twitter OAuth not implemented yet');
    }

    /**
     * Redirect to GitHub OAuth
     */
    public function redirectToGitHub()
    {
        $config = config('social_auth.github');
        $params = http_build_query([
            'client_id' => $config['client_id'],
            'redirect_uri' => $config['redirect_uri'],
            'scope' => $config['scope'],
            'state' => 'github',
        ]);

        return redirect($config['auth_url'] . '?' . $params);
    }

    /**
     * Handle GitHub OAuth callback
     */
    public function handleGitHubCallback(Request $request)
    {
        $code = $request->get('code');
        $state = $request->get('state');

        if ($state !== 'github') {
            return redirect('/login')->with('error', 'Invalid state parameter');
        }

        // Exchange code for access token
        $config = config('social_auth.github');
        $response = Http::post('https://github.com/login/oauth/access_token', [
            'client_id' => $config['client_id'],
            'client_secret' => env('GITHUB_CLIENT_SECRET'),
            'code' => $code,
        ]);

        if ($response->successful()) {
            $tokenData = $response->json();
            $accessToken = $tokenData['access_token'];

            // Get user info
            $userResponse = Http::withToken($accessToken)->get('https://api.github.com/user');
            
            if ($userResponse->successful()) {
                $userData = $userResponse->json();
                $user = $this->findOrCreateUser($userData, 'github');
                Auth::login($user);
                return redirect('/');
            }
        }

        return redirect('/login')->with('error', 'Failed to authenticate with GitHub');
    }

    /**
     * Find or create user from social data
     */
    private function findOrCreateUser($userData, $provider)
    {
        $email = $userData['email'] ?? null;
        
        if (!$email) {
            throw new \Exception('No email provided by ' . $provider);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $userData['name'] ?? $userData['login'] ?? 'User',
                'email' => $email,
                'password' => bcrypt(str_random(16)), // Random password
                'email_verified_at' => now(),
            ]);
        }

        return $user;
    }
}
