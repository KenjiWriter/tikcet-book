# Social Authentication Setup

## Konfiguracja OAuth dla GwiezdnePodróże

### 1. Google OAuth

1. Idź do [Google Cloud Console](https://console.cloud.google.com/)
2. Utwórz nowy projekt lub wybierz istniejący
3. Włącz Google+ API
4. Utwórz OAuth 2.0 credentials
5. Dodaj do `.env`:
```
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 2. Apple ID OAuth

1. Idź do [Apple Developer Console](https://developer.apple.com/)
2. Utwórz App ID z Sign In with Apple
3. Utwórz Service ID
4. Dodaj do `.env`:
```
APPLE_CLIENT_ID=your_apple_client_id_here
APPLE_CLIENT_SECRET=your_apple_client_secret_here
APPLE_REDIRECT_URI=http://localhost:8000/auth/apple/callback
```

### 3. Facebook OAuth

1. Idź do [Facebook Developers](https://developers.facebook.com/)
2. Utwórz nową aplikację
3. Dodaj Facebook Login
4. Dodaj do `.env`:
```
FACEBOOK_APP_ID=your_facebook_app_id_here
FACEBOOK_APP_SECRET=your_facebook_app_secret_here
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback
```

### 4. Twitter OAuth

1. Idź do [Twitter Developer Portal](https://developer.twitter.com/)
2. Utwórz nową aplikację
3. Włącz OAuth 2.0
4. Dodaj do `.env`:
```
TWITTER_CLIENT_ID=your_twitter_client_id_here
TWITTER_CLIENT_SECRET=your_twitter_client_secret_here
TWITTER_REDIRECT_URI=http://localhost:8000/auth/twitter/callback
```

### 5. GitHub OAuth

1. Idź do [GitHub Developer Settings](https://github.com/settings/developers)
2. Utwórz nową OAuth App
3. Dodaj do `.env`:
```
GITHUB_CLIENT_ID=your_github_client_id_here
GITHUB_CLIENT_SECRET=your_github_client_secret_here
GITHUB_REDIRECT_URI=http://localhost:8000/auth/github/callback
```

### Instalacja

1. Skopiuj konfiguracje do pliku `.env`
2. Zastąp placeholder wartości rzeczywistymi credentials
3. Uruchom `php artisan config:cache`
4. Przetestuj logowanie przez każdy provider

### Funkcjonalność

- **Google**: Pełna implementacja OAuth 2.0
- **GitHub**: Pełna implementacja OAuth 2.0
- **Apple**: Struktura gotowa, wymaga implementacji
- **Facebook**: Struktura gotowa, wymaga implementacji
- **Twitter**: Struktura gotowa, wymaga implementacji

### Routes

- `/auth/google` - Przekierowanie do Google
- `/auth/apple` - Przekierowanie do Apple
- `/auth/facebook` - Przekierowanie do Facebook
- `/auth/twitter` - Przekierowanie do Twitter
- `/auth/github` - Przekierowanie do GitHub

Wszystkie callbacki są obsługiwane automatycznie.
