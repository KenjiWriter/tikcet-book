<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #0a0a0a 0%, #1a0b2e 25%, #2d1b69 50%, #4a2c7a 75%, #6a4c93 100%);
                min-height: 100vh;
                position: relative;
                overflow-x: hidden;
            }

            /* Animated stars background */
            .stars {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 1;
            }

            .star {
                position: absolute;
                background: white;
                border-radius: 50%;
                animation: twinkle 3s infinite;
                box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            }

            @keyframes twinkle {
                0%, 100% { opacity: 0.3; transform: scale(1); }
                50% { opacity: 1; transform: scale(1.2); }
            }

            /* 3D City silhouette */
            .city-silhouette {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 300px;
                background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 100%);
                z-index: 3;
                perspective: 1000px;
            }

            .city-building {
                position: absolute;
                bottom: 0;
                background: linear-gradient(to top, #000 0%, #333 100%);
                border-radius: 5px 5px 0 0;
                box-shadow: 0 0 20px rgba(255, 107, 53, 0.2);
            }

            .city-building:nth-child(1) {
                left: 0%;
                width: 80px;
                height: 200px;
                animation: buildingGlow 4s ease-in-out infinite;
            }

            .city-building:nth-child(2) {
                left: 10%;
                width: 60px;
                height: 150px;
                animation: buildingGlow 4s ease-in-out infinite 1s;
            }

            .city-building:nth-child(3) {
                left: 20%;
                width: 100px;
                height: 250px;
                animation: buildingGlow 4s ease-in-out infinite 2s;
            }

            .city-building:nth-child(4) {
                left: 35%;
                width: 70px;
                height: 180px;
                animation: buildingGlow 4s ease-in-out infinite 0.5s;
            }

            .city-building:nth-child(5) {
                left: 50%;
                width: 90px;
                height: 220px;
                animation: buildingGlow 4s ease-in-out infinite 1.5s;
            }

            .city-building:nth-child(6) {
                left: 65%;
                width: 110px;
                height: 280px;
                animation: buildingGlow 4s ease-in-out infinite 2.5s;
            }

            .city-building:nth-child(7) {
                left: 80%;
                width: 85px;
                height: 190px;
                animation: buildingGlow 4s ease-in-out infinite 3s;
            }

            @keyframes buildingGlow {
                0%, 100% { box-shadow: 0 0 20px rgba(255, 107, 53, 0.2); }
                50% { box-shadow: 0 0 40px rgba(255, 107, 53, 0.6); }
            }

            /* Navigation */
            .navbar {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.95);
                backdrop-filter: blur(20px);
                padding: 15px 0;
                z-index: 1000;
                border-bottom: 2px solid rgba(255, 107, 53, 0.5);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            }

            .nav-container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .logo-section {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .logo {
                width: 60px;
                height: 60px;
                background: linear-gradient(45deg, #ff6b35, #ff8e53);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 28px;
                color: white;
                box-shadow: 0 0 30px rgba(255, 107, 53, 0.7);
                animation: logoRotate 4s linear infinite;
                cursor: pointer;
            }

            .brand-text {
                color: #ff6b35;
                font-size: 28px;
                font-weight: 900;
                text-shadow: 0 0 20px rgba(255, 107, 53, 0.5);
                letter-spacing: 1px;
            }

            .back-btn {
                color: white;
                text-decoration: none;
                font-size: 18px;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .back-btn:hover {
                color: #ff6b35;
                transform: translateX(-5px);
            }

            @keyframes logoRotate {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Main content */
            .main-content {
                position: relative;
                z-index: 10;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 40px 20px 300px;
            }

            /* Side by side layout */
            .auth-container {
                display: flex;
                gap: 60px;
                max-width: 1200px;
                width: 100%;
                align-items: center;
                justify-content: center;
            }

            .auth-form-section {
                flex: 1;
                background: transparent;
                padding: 50px 40px;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                max-width: 500px;
            }

            .social-login-section {
                flex: 1;
                background: transparent;
                padding: 50px 40px;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                max-width: 500px;
            }

            .social-login-title {
                color: #ff6b35;
                font-size: 28px;
                font-weight: 800;
                text-align: center;
                margin-bottom: 20px;
                text-shadow: 0 0 20px rgba(255, 107, 53, 0.6);
                letter-spacing: 1px;
            }

            .social-login-subtitle {
                color: rgba(255, 255, 255, 0.9);
                font-size: 18px;
                text-align: center;
                margin-bottom: 40px;
                line-height: 1.6;
                font-weight: 300;
            }

            /* Override Flux styles */
            .bg-background {
                background: transparent !important;
            }

            .min-h-svh {
                min-height: 100vh !important;
            }

            .flex {
                display: flex !important;
            }

            .flex-col {
                flex-direction: column !important;
            }

            .items-center {
                align-items: center !important;
            }

            .justify-center {
                justify-content: center !important;
            }

            .gap-6 {
                gap: 1.5rem !important;
            }

            .p-6 {
                padding: 1.5rem !important;
            }

            .md\:p-10 {
                padding: 2.5rem !important;
            }

            .w-full {
                width: 100% !important;
            }

            .max-w-sm {
                max-width: 28rem !important;
            }

            .gap-2 {
                gap: 0.5rem !important;
            }

            .font-medium {
                font-weight: 500 !important;
            }

            .h-9 {
                height: 2.25rem !important;
            }

            .w-9 {
                width: 2.25rem !important;
            }

            .mb-1 {
                margin-bottom: 0.25rem !important;
            }

            .rounded-md {
                border-radius: 0.375rem !important;
            }

            .size-9 {
                width: 2.25rem !important;
                height: 2.25rem !important;
            }

            .fill-current {
                fill: currentColor !important;
            }

            .text-black {
                color: #000 !important;
            }

            .dark\:text-white {
                color: #fff !important;
            }

            .sr-only {
                position: absolute !important;
                width: 1px !important;
                height: 1px !important;
                padding: 0 !important;
                margin: -1px !important;
                overflow: hidden !important;
                clip: rect(0, 0, 0, 0) !important;
                white-space: nowrap !important;
                border: 0 !important;
            }

            /* Social Login Buttons */
            .social-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                padding: 15px 25px;
                border: none;
                border-radius: 15px;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(20px);
                color: white;
                font-weight: 600;
                font-size: 15px;
                transition: all 0.3s ease;
                cursor: pointer;
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
                position: relative;
                overflow: hidden;
            }

            .social-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s;
            }

            .social-btn:hover::before {
                left: 100%;
            }

            .social-btn:hover {
                background: rgba(255, 255, 255, 0.2);
                transform: translateY(-3px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            }

            .google-btn:hover {
                background: rgba(66, 133, 244, 0.2);
                box-shadow: 0 15px 35px rgba(66, 133, 244, 0.4);
            }

            .apple-btn:hover {
                background: rgba(0, 0, 0, 0.3);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            }

            .facebook-btn:hover {
                background: rgba(24, 119, 242, 0.2);
                box-shadow: 0 15px 35px rgba(24, 119, 242, 0.4);
            }

            .twitter-btn:hover {
                background: rgba(29, 161, 242, 0.2);
                box-shadow: 0 15px 35px rgba(29, 161, 242, 0.4);
            }

            .github-btn:hover {
                background: rgba(51, 51, 51, 0.3);
                box-shadow: 0 15px 35px rgba(51, 51, 51, 0.4);
            }

            .social-btn svg {
                width: 20px;
                height: 20px;
            }

            /* Divider */
            .relative {
                position: relative;
            }

            .absolute {
                position: absolute;
            }

            .inset-0 {
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
            }

            .flex {
                display: flex;
            }

            .items-center {
                align-items: center;
            }

            .w-full {
                width: 100%;
            }

            .border-t {
                border-top-width: 1px;
            }

            .border-gray-300 {
                border-color: #d1d5db;
            }

            .dark\:border-gray-600 {
                border-color: #4b5563;
            }

            .justify-center {
                justify-content: center;
            }

            .text-sm {
                font-size: 0.875rem;
                line-height: 1.25rem;
            }

            .px-2 {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            .bg-transparent {
                background-color: transparent;
            }

            .text-gray-500 {
                color: #6b7280;
            }

            .dark\:text-gray-400 {
                color: #9ca3af;
            }

            /* Small Logo */
            .logo-small {
                width: 50px;
                height: 50px;
                background: linear-gradient(45deg, #ff6b35, #ff8e53);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                color: white;
                box-shadow: 0 0 25px rgba(255, 107, 53, 0.7);
                animation: logoRotate 4s linear infinite;
                cursor: pointer;
                margin-bottom: 10px;
            }

            .brand-text-small {
                color: #ff6b35;
                font-size: 20px;
                font-weight: 900;
                text-shadow: 0 0 15px rgba(255, 107, 53, 0.5);
                letter-spacing: 1px;
                text-align: center;
            }

            /* Enhanced Input Styles */
            .flux-input {
                background: rgba(255, 255, 255, 0.1) !important;
                border: 1px solid rgba(255, 255, 255, 0.2) !important;
                border-radius: 15px !important;
                color: white !important;
                backdrop-filter: blur(20px) !important;
                transition: all 0.3s ease !important;
                padding: 15px 20px !important;
                width: 100% !important;
                max-width: 400px !important;
                margin: 0 auto !important;
            }

            .flux-input:focus {
                border-color: rgba(255, 107, 53, 0.8) !important;
                box-shadow: 0 0 25px rgba(255, 107, 53, 0.4) !important;
                background: rgba(255, 255, 255, 0.15) !important;
                transform: translateY(-2px) !important;
            }

            .flux-input::placeholder {
                color: rgba(255, 255, 255, 0.6) !important;
            }

            .flux-label {
                color: #ff6b35 !important;
                font-weight: 600 !important;
                margin-bottom: 8px !important;
                text-shadow: 0 0 10px rgba(255, 107, 53, 0.3) !important;
                text-align: center !important;
                display: block !important;
                width: 100% !important;
            }

            /* Enhanced Button Styles */
            .flux-button {
                background: linear-gradient(45deg, #ff6b35, #ff8e53) !important;
                border: none !important;
                border-radius: 15px !important;
                color: white !important;
                font-weight: 700 !important;
                padding: 15px 30px !important;
                transition: all 0.3s ease !important;
                box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4) !important;
                position: relative !important;
                overflow: hidden !important;
                width: 100% !important;
                max-width: 400px !important;
                margin: 0 auto !important;
            }

            .flux-button::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.5s;
            }

            .flux-button:hover::before {
                left: 100%;
            }

            .flux-button:hover {
                transform: translateY(-3px) !important;
                box-shadow: 0 15px 35px rgba(255, 107, 53, 0.6) !important;
                background: linear-gradient(45deg, #ff8e53, #ff6b35) !important;
            }

            /* Enhanced Link Styles */
            .flux-link {
                color: #ff6b35 !important;
                text-decoration: none !important;
                font-weight: 600 !important;
                transition: all 0.3s ease !important;
                text-align: center !important;
                display: block !important;
                margin: 10px auto !important;
            }

            .flux-link:hover {
                color: #ff8e53 !important;
                text-shadow: 0 0 10px rgba(255, 107, 53, 0.5) !important;
            }

            /* Enhanced Checkbox Styles */
            .flux-checkbox {
                accent-color: #ff6b35 !important;
            }

            .flux-checkbox:checked {
                background-color: #ff6b35 !important;
                border-color: #ff6b35 !important;
            }

            /* Back Button */
            .back-button-container {
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1000;
            }

            .back-button {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 12px 20px;
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(20px);
                border: 2px solid rgba(255, 107, 53, 0.3);
                border-radius: 15px;
                color: white;
                text-decoration: none;
                font-weight: 600;
                font-size: 16px;
                transition: all 0.3s ease;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            }

            .back-button:hover {
                background: rgba(255, 107, 53, 0.2);
                border-color: rgba(255, 107, 53, 0.8);
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
                color: #ff6b35;
            }

            .back-icon {
                width: 20px;
                height: 20px;
                transition: transform 0.3s ease;
            }

            .back-button:hover .back-icon {
                transform: translateX(-3px);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .auth-container {
                    flex-direction: column;
                    gap: 40px;
                    padding: 0 20px;
                    align-items: center;
                }

                .auth-form-section,
                .social-login-section {
                    padding: 30px 20px;
                    max-width: 100%;
                    width: 100%;
                }

                .social-login-title {
                    font-size: 24px;
                }

                .social-login-subtitle {
                    font-size: 16px;
                }

                .main-content {
                    padding: 20px 10px 300px;
                }

                .flux-input,
                .social-btn,
                .flux-button {
                    max-width: 100% !important;
                }
            }

            @media (max-width: 480px) {
                .auth-form-section,
                .social-login-section {
                    padding: 20px 15px;
                }

                .logo-small {
                    width: 40px;
                    height: 40px;
                    font-size: 20px;
                }

                .brand-text-small {
                    font-size: 18px;
                }

                .back-button {
                    padding: 10px 15px;
                    font-size: 14px;
                }

                .back-icon {
                    width: 18px;
                    height: 18px;
                }
            }
        </style>
    </head>
    <body>
        <!-- Animated stars background -->
        <div class="stars" id="stars"></div>
        
        <!-- 3D City silhouette -->
        <div class="city-silhouette">
            <div class="city-building"></div>
            <div class="city-building"></div>
            <div class="city-building"></div>
            <div class="city-building"></div>
            <div class="city-building"></div>
            <div class="city-building"></div>
            <div class="city-building"></div>
        </div>


        <!-- Back Button -->
        <div class="back-button-container">
            <a href="{{ route('home') }}" class="back-button">
                <svg class="back-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                </svg>
                Powrót do strony głównej
            </a>
        </div>

        <!-- Main content -->
        <main class="main-content">
            <div class="auth-container">
                <!-- Form Section -->
                <div class="auth-form-section">
                    <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                        <div class="logo-small">🚀</div>
                        <div class="brand-text-small">GwiezdnePodróże</div>
                    </a>
                    <div class="flex flex-col gap-6">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Social Login Section -->
                <div class="social-login-section">
                    <h2 class="social-login-title">Szybkie logowanie</h2>
                    <p class="social-login-subtitle">Zaloguj się jednym kliknięciem</p>
                    
                    <div class="flex flex-col gap-3">
                        <button type="button" class="social-btn google-btn">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Google
                        </button>
                        
                        <button type="button" class="social-btn apple-btn">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                            </svg>
                            Apple ID
                        </button>

                        <button type="button" class="social-btn facebook-btn">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </button>

                        <button type="button" class="social-btn twitter-btn">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Twitter
                        </button>

                        <button type="button" class="social-btn github-btn">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                            GitHub
                        </button>
                    </div>
                </div>
            </div>
        </main>

        @fluxScripts

        <script>
            // Create animated stars
            function createStars() {
                const starsContainer = document.getElementById('stars');
                const numStars = 100;

                for (let i = 0; i < numStars; i++) {
                    const star = document.createElement('div');
                    star.className = 'star';
                    
                    // Random position
                    star.style.left = Math.random() * 100 + '%';
                    star.style.top = Math.random() * 100 + '%';
                    
                    // Random size
                    const size = Math.random() * 3 + 1;
                    star.style.width = size + 'px';
                    star.style.height = size + 'px';
                    
                    // Random animation delay
                    star.style.animationDelay = Math.random() * 3 + 's';
                    star.style.animationDuration = (Math.random() * 3 + 2) + 's';
                    
                    starsContainer.appendChild(star);
                }
            }

            // Social login functions
            function loginWithGoogle() {
                window.location.href = '{{ route("auth.google") }}';
            }

            function loginWithApple() {
                window.location.href = '{{ route("auth.apple") }}';
            }

            function loginWithFacebook() {
                window.location.href = '{{ route("auth.facebook") }}';
            }

            function loginWithTwitter() {
                window.location.href = '{{ route("auth.twitter") }}';
            }

            function loginWithGitHub() {
                window.location.href = '{{ route("auth.github") }}';
            }

            // Add click event listeners
            function addSocialLoginListeners() {
                const googleBtn = document.querySelector('.google-btn');
                const appleBtn = document.querySelector('.apple-btn');
                const facebookBtn = document.querySelector('.facebook-btn');
                const twitterBtn = document.querySelector('.twitter-btn');
                const githubBtn = document.querySelector('.github-btn');

                if (googleBtn) googleBtn.addEventListener('click', loginWithGoogle);
                if (appleBtn) appleBtn.addEventListener('click', loginWithApple);
                if (facebookBtn) facebookBtn.addEventListener('click', loginWithFacebook);
                if (twitterBtn) twitterBtn.addEventListener('click', loginWithTwitter);
                if (githubBtn) githubBtn.addEventListener('click', loginWithGitHub);
            }

            // Initialize stars and social login when page loads
            document.addEventListener('DOMContentLoaded', function() {
                createStars();
                addSocialLoginListeners();
            });
        </script>
    </body>
</html>
