<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Social Authentication URLs
    |--------------------------------------------------------------------------
    |
    | These URLs are used for social login redirects. Replace the placeholder
    | values with your actual OAuth application credentials.
    |
    */

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', 'YOUR_GOOGLE_CLIENT_ID'),
        'redirect_uri' => env('GOOGLE_REDIRECT_URI', url('/auth/google/callback')),
        'scope' => 'email profile',
        'auth_url' => 'https://accounts.google.com/oauth/authorize',
    ],

    'apple' => [
        'client_id' => env('APPLE_CLIENT_ID', 'YOUR_APPLE_CLIENT_ID'),
        'redirect_uri' => env('APPLE_REDIRECT_URI', url('/auth/apple/callback')),
        'scope' => 'name email',
        'auth_url' => 'https://appleid.apple.com/auth/authorize',
    ],

    'facebook' => [
        'app_id' => env('FACEBOOK_APP_ID', 'YOUR_FACEBOOK_APP_ID'),
        'redirect_uri' => env('FACEBOOK_REDIRECT_URI', url('/auth/facebook/callback')),
        'scope' => 'email',
        'auth_url' => 'https://www.facebook.com/v18.0/dialog/oauth',
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID', 'YOUR_TWITTER_CLIENT_ID'),
        'redirect_uri' => env('TWITTER_REDIRECT_URI', url('/auth/twitter/callback')),
        'scope' => 'tweet.read users.read',
        'auth_url' => 'https://twitter.com/i/oauth2/authorize',
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID', 'YOUR_GITHUB_CLIENT_ID'),
        'redirect_uri' => env('GITHUB_REDIRECT_URI', url('/auth/github/callback')),
        'scope' => 'user:email',
        'auth_url' => 'https://github.com/login/oauth/authorize',
    ],
];
