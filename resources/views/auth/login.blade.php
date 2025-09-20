<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie - GwiezdnePodróże</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        /* Main content */
        .main-content {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 120px 20px 300px;
        }

        .login-container {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(30px);
            border: 2px solid rgba(255, 107, 53, 0.4);
            border-radius: 25px;
            padding: 60px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 10;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #ff6b35, #ff8e53);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: white;
            margin: 0 auto 20px;
            box-shadow: 0 0 30px rgba(255, 107, 53, 0.7);
            animation: logoRotate 4s linear infinite;
        }

        .login-title {
            color: #ff6b35;
            font-size: 32px;
            font-weight: 900;
            margin-bottom: 10px;
            text-shadow: 0 0 20px rgba(255, 107, 53, 0.5);
        }

        .login-subtitle {
            color: white;
            font-size: 16px;
            opacity: 0.8;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: #ff6b35;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-input {
            width: 100%;
            padding: 18px 25px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            color: white;
            font-size: 16px;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
        }

        .form-input:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 30px rgba(255, 107, 53, 0.4);
            transform: translateY(-2px);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .social-login {
            margin: 30px 0;
        }

        .social-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .social-btn {
            padding: 15px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
        }

        .social-btn.google {
            border-color: #db4437;
        }

        .social-btn.apple {
            border-color: #000;
        }

        .divider {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            margin: 20px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
        }

        .divider span {
            background: rgba(0, 0, 0, 0.8);
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .submit-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(45deg, #ff6b35, #ff8e53);
            border: none;
            border-radius: 15px;
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.5);
        }

        .forgot-password {
            text-align: center;
            margin-bottom: 30px;
        }

        .forgot-password a {
            color: #ff6b35;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            text-shadow: 0 0 10px rgba(255, 107, 53, 0.5);
        }

        .register-link {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .register-link a {
            color: #ff6b35;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            text-shadow: 0 0 10px rgba(255, 107, 53, 0.5);
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

        @media (max-width: 768px) {
            .login-container {
                margin: 20px;
                padding: 40px 30px;
            }
            
            .social-buttons {
                grid-template-columns: 1fr;
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

    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo-section">
                <div class="logo" onclick="window.location.href='/'">🚀</div>
                <div class="brand-text">GwiezdnePodróże</div>
            </div>
            <a href="/" class="back-btn">
                ← Powrót do strony głównej
            </a>
        </div>
    </nav>

    <!-- Main content -->
    <main class="main-content">
        <div class="login-container">
        <div class="login-header">
            <div class="logo">🚀</div>
            <h1 class="login-title">Zaloguj się</h1>
            <p class="login-subtitle">Witaj z powrotem w GwiezdnePodróże</p>
        </div>

        <form onsubmit="login(event)">
            <div class="social-login">
                <div class="social-buttons">
                    <button type="button" class="social-btn google" onclick="loginWithGoogle()">
                        <span>🔍</span>
                        Google
                    </button>
                    <button type="button" class="social-btn apple" onclick="loginWithApple()">
                        <span>🍎</span>
                        Apple ID
                    </button>
                </div>
                
                <div class="divider">
                    <span>lub</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-input" id="email" placeholder="twoj@email.com" required>
            </div>

            <div class="form-group">
                <label class="form-label">Hasło</label>
                <input type="password" class="form-input" id="password" placeholder="Twoje hasło" required>
            </div>

            <div class="forgot-password">
                <a href="/forgot-password">Zapomniałeś hasła?</a>
            </div>

            <button type="submit" class="submit-btn">
                Zaloguj się
            </button>

            <div class="register-link">
                Nie masz konta? <a href="/register">Zarejestruj się</a>
            </div>
        </form>
        </div>
    </main>

    <script>
        // Create animated stars
        function createStars() {
            const starsContainer = document.getElementById('stars');
            const numStars = 150;
            
            for (let i = 0; i < numStars; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 100 + '%';
                star.style.width = Math.random() * 3 + 1 + 'px';
                star.style.height = star.style.width;
                star.style.animationDelay = Math.random() * 3 + 's';
                star.style.animationDuration = (Math.random() * 3 + 2) + 's';
                starsContainer.appendChild(star);
            }
        }

        function login(event) {
            event.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Simulate login
            alert(`Logowanie: ${email}`);
            // Redirect to home
            window.location.href = '/';
        }

        function loginWithGoogle() {
            alert('Logowanie przez Google - Funkcja w trakcie rozwoju!');
        }

        function loginWithApple() {
            alert('Logowanie przez Apple ID - Funkcja w trakcie rozwoju!');
        }

        // Initialize stars
        document.addEventListener('DOMContentLoaded', createStars);
    </script>
</body>
</html>
