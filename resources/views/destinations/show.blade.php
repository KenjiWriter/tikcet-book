<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $destination['name'] }} - GwiezdnePodróże</title>
    <meta name="description" content="{{ $destination['description'] }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
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
            overflow-x: hidden;
            position: relative;
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

        /* Main content */
        .main-content {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            padding: 120px 20px 50px;
        }

        .destination-header {
            text-align: center;
            margin-bottom: 80px;
        }

        .destination-icon {
            font-size: 80px;
            margin-bottom: 20px;
            display: block;
        }

        .destination-title {
            font-size: 4rem;
            font-weight: 900;
            color: #ff6b35;
            margin-bottom: 20px;
            text-shadow: 0 0 40px rgba(255, 107, 53, 0.7);
        }

        .destination-subtitle {
            font-size: 1.5rem;
            color: white;
            opacity: 0.9;
            margin-bottom: 40px;
        }

        .destination-stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
            color: white;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #ff6b35;
            display: block;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.8;
        }

        /* 3D Ticket - Above city description */
        .ticket-3d-container {
            position: relative;
            width: 600px;
            height: 480px;
            z-index: 100;
            cursor: grab;
            user-select: none;
            background: transparent;
            border: none;
            margin: 0 auto 60px;
        }

        .ticket-3d-container:active {
            cursor: grabbing;
        }

        #ticket-canvas {
            width: 100%;
            height: 100%;
            border-radius: 0;
            box-shadow: none;
            background: transparent;
        }

        .ticket-description {
            position: absolute;
            top: 50%;
            right: -300px;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 107, 53, 0.4);
            border-radius: 20px;
            padding: 30px;
            width: 280px;
            color: white;
            font-size: 16px;
            line-height: 1.6;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        .ticket-description h3 {
            color: #ff6b35;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .ticket-description p {
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .ticket-description .highlight {
            color: #ff6b35;
            font-weight: 600;
        }

        .rotation-hint {
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            text-align: center;
            background: rgba(0, 0, 0, 0.5);
            padding: 8px 15px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        /* Content sections */
        .content-sections {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section {
            background: rgba(0, 0, 0, 0.6);
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 25px;
            padding: 40px;
            backdrop-filter: blur(20px);
        }

        .section h2 {
            color: #ff6b35;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }

        .section p {
            color: white;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .attractions-list {
            list-style: none;
            padding: 0;
        }

        .attractions-list li {
            color: white;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 107, 53, 0.2);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .attractions-list li:last-child {
            border-bottom: none;
        }

        .attraction-icon {
            font-size: 24px;
            color: #ff6b35;
        }

        .attraction-name {
            font-weight: 600;
            color: #ff6b35;
        }

        .attraction-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .price-card {
            background: rgba(255, 107, 53, 0.1);
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .price-card:hover {
            transform: translateY(-5px);
            border-color: #ff6b35;
            box-shadow: 0 15px 30px rgba(255, 107, 53, 0.3);
        }

        .price-type {
            color: #ff6b35;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .price-value {
            color: white;
            font-size: 32px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .price-details {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        .book-now-btn {
            background: linear-gradient(45deg, #ff6b35, #ff8e53);
            border: none;
            border-radius: 15px;
            color: white;
            font-size: 18px;
            font-weight: 700;
            padding: 15px 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 20px;
            width: 100%;
        }

        .book-now-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.5);
        }

        @keyframes logoRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 1200px) {
            .content-sections {
                grid-template-columns: 1fr;
            }
            
            .ticket-3d-container {
                width: 500px;
                height: 400px;
            }
            
            .ticket-description {
                right: -250px;
                width: 240px;
            }
        }

        @media (max-width: 900px) {
            .ticket-3d-container {
                width: 400px;
                height: 320px;
            }
            
            .ticket-description {
                position: static;
                right: auto;
                transform: none;
                margin-top: 20px;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .destination-title {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated stars background -->
    <div class="stars" id="stars"></div>

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
        <div class="destination-header">
            <div class="destination-icon">{{ $destination['icon'] }}</div>
            <h1 class="destination-title">{{ $destination['name'] }}</h1>
            <p class="destination-subtitle">{{ $destination['description'] }}</p>
            
            <div class="destination-stats">
                <div class="stat-item">
                    <span class="stat-value">{{ $destination['rating'] }}</span>
                    <span class="stat-label">Ocena</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $destination['distance'] }}</span>
                    <span class="stat-label">Odległość</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $destination['population'] }}</span>
                    <span class="stat-label">Ludność</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $destination['temperature'] }}</span>
                    <span class="stat-label">Temperatura</span>
                </div>
            </div>
        </div>

        <!-- 3D Ticket -->
        <div class="ticket-3d-container" id="ticketContainer">
            <canvas id="ticket-canvas"></canvas>
            <div class="ticket-description">
                <h3>🎫 {{ $destination['name'] }}</h3>
                <p>Odkryj <span class="highlight">{{ $destination['name'] }}</span>!</p>
                <p>Ocena: <span class="highlight">{{ $destination['rating'] }}/5</span></p>
                <p>Odległość: <span class="highlight">{{ $destination['distance'] }}</span></p>
                <p>Obracaj bilet aby zobaczyć szczegóły!</p>
            </div>
            <div class="rotation-hint">
                🖱️ Przytrzymaj lewy przycisk i przeciągnij aby obracać
            </div>
        </div>

        <div class="content-sections">
            <div class="section">
                <h2>🏛️ O Mieście</h2>
                <p>{{ $destination['about'] }}</p>
                <p>{{ $destination['history'] }}</p>
            </div>

            <div class="section">
                <h2>🎯 Atrakcje</h2>
                <ul class="attractions-list">
                    @foreach($destination['attractions'] as $attraction)
                    <li>
                        <div class="attraction-icon">{{ $attraction['icon'] }}</div>
                        <div>
                            <div class="attraction-name">{{ $attraction['name'] }}</div>
                            <div class="attraction-description">{{ $attraction['description'] }}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="section">
                <h2>🍽️ Kuchnia</h2>
                <p>{{ $destination['cuisine'] }}</p>
                <p><strong>Specjalności:</strong> {{ $destination['specialties'] }}</p>
            </div>

            <div class="section">
                <h2>💰 Ceny Biletów</h2>
                <div class="pricing-grid">
                    @foreach($destination['pricing'] as $price)
                    <div class="price-card">
                        <div class="price-type">{{ $price['type'] }}</div>
                        <div class="price-value">{{ $price['price'] }}</div>
                        <div class="price-details">{{ $price['details'] }}</div>
                    </div>
                    @endforeach
                </div>
                <button class="book-now-btn" onclick="bookTicket()">
                    🎫 Zarezerwuj Bilet
                </button>
            </div>
        </div>
    </main>

    <script>
        // Three.js 3D Label
        let scene, camera, renderer, label, backLabel;
        let isRotating = false;
        let lastMouseX = 0, lastMouseY = 0;
        let rotationX = 0, rotationY = 0;
        
        function init3DLabel() {
            const canvas = document.getElementById('ticket-canvas');
            
            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(75, 600/480, 0.1, 1000);
            renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true });
            renderer.setSize(600, 480);
            renderer.setClearColor(0x000000, 0);
            
            // Create front label
            const labelGeometry = new THREE.PlaneGeometry(10, 4);
            const canvas2d = document.createElement('canvas');
            canvas2d.width = 640;
            canvas2d.height = 256;
            const ctx = canvas2d.getContext('2d');
            
            // Background gradient
            const gradient = ctx.createLinearGradient(0, 0, 640, 256);
            gradient.addColorStop(0, '#ff6b35');
            gradient.addColorStop(0.5, '#ff8e53');
            gradient.addColorStop(1, '#ff6b35');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, 640, 256);
            
            // Add border
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 6;
            ctx.strokeRect(3, 3, 634, 250);
            
            // Add logo
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 64px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('🚀', 320, 100);
            
            // Add company name
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 40px Arial';
            ctx.fillText('GwiezdnePodróże', 320, 150);
            
            // Add tagline
            ctx.fillStyle = '#ffffff';
            ctx.font = '20px Arial';
            ctx.fillText('Biuro do nieziemskich podróży', 320, 180);
            
            const texture = new THREE.CanvasTexture(canvas2d);
            const labelMaterial = new THREE.MeshPhongMaterial({ 
                map: texture,
                transparent: true,
                shininess: 100
            });
            
            label = new THREE.Mesh(labelGeometry, labelMaterial);
            scene.add(label);
            
            // Create back label with destination data
            const backLabelGeometry = new THREE.PlaneGeometry(10, 4);
            const backCanvas2d = document.createElement('canvas');
            backCanvas2d.width = 640;
            backCanvas2d.height = 256;
            const backCtx = backCanvas2d.getContext('2d');
            
            // Background
            const backGradient = backCtx.createLinearGradient(0, 0, 640, 256);
            backGradient.addColorStop(0, '#1a1a1a');
            backGradient.addColorStop(0.5, '#2a2a2a');
            backGradient.addColorStop(1, '#1a1a1a');
            backCtx.fillStyle = backGradient;
            backCtx.fillRect(0, 0, 640, 256);
            
            // Border
            backCtx.strokeStyle = '#ff6b35';
            backCtx.lineWidth = 4;
            backCtx.strokeRect(2, 2, 636, 252);
            
            // Title
            backCtx.fillStyle = '#ff6b35';
            backCtx.font = 'bold 28px Arial';
            backCtx.textAlign = 'center';
            backCtx.fillText('BILET PODRÓŻY', 320, 35);
            
            // Destination
            backCtx.fillStyle = '#ffffff';
            backCtx.font = 'bold 36px Arial';
            backCtx.fillText('{{ $destination["name"] }}', 320, 75);
            
            // Rating
            backCtx.fillStyle = '#ff8e53';
            backCtx.font = 'bold 18px Arial';
            backCtx.fillText('Ocena: {{ $destination["rating"] }}/5', 320, 105);
            
            // Details
            backCtx.fillStyle = '#ffffff';
            backCtx.font = 'bold 16px Arial';
            backCtx.textAlign = 'left';
            
            const details = [
                '🏛️ {{ $destination["name"] }}',
                '⭐ Ocena: {{ $destination["rating"] }}/5',
                '📍 Odległość: {{ $destination["distance"] }}',
                '🌡️ Temperatura: {{ $destination["temperature"] }}'
            ];
            
            let y = 140;
            details.forEach(detail => {
                backCtx.fillText(detail, 50, y);
                y += 25;
            });
            
            // QR Code
            backCtx.fillStyle = '#333333';
            backCtx.fillRect(520, 130, 90, 90);
            backCtx.strokeStyle = '#ff6b35';
            backCtx.lineWidth = 2;
            backCtx.strokeRect(520, 130, 90, 90);
            
            backCtx.fillStyle = '#ffffff';
            backCtx.font = 'bold 12px Arial';
            backCtx.textAlign = 'center';
            backCtx.fillText('QR CODE', 565, 180);
            
            const backTexture = new THREE.CanvasTexture(backCanvas2d);
            const backLabelMaterial = new THREE.MeshPhongMaterial({ 
                map: backTexture,
                transparent: true
            });
            
            backLabel = new THREE.Mesh(backLabelGeometry, backLabelMaterial);
            backLabel.rotation.y = Math.PI;
            scene.add(backLabel);
            
            // Add lighting
            const ambientLight = new THREE.AmbientLight(0x404040, 0.8);
            scene.add(ambientLight);
            
            const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
            directionalLight.position.set(5, 5, 5);
            scene.add(directionalLight);
            
            const pointLight = new THREE.PointLight(0xff6b35, 0.5, 100);
            pointLight.position.set(0, 0, 10);
            scene.add(pointLight);
            
            camera.position.z = 8;
            
            // Mouse rotation controls
            canvas.addEventListener('mousedown', startRotation);
            document.addEventListener('mousemove', rotate);
            document.addEventListener('mouseup', endRotation);
            
            animate();
        }
        
        function startRotation(e) {
            isRotating = true;
            lastMouseX = e.clientX;
            lastMouseY = e.clientY;
        }
        
        function rotate(e) {
            if (!isRotating) return;
            
            const deltaX = e.clientX - lastMouseX;
            const deltaY = e.clientY - lastMouseY;
            
            rotationY += deltaX * 0.01;
            rotationX += deltaY * 0.01;
            
            rotationX = Math.max(-Math.PI/2, Math.min(Math.PI/2, rotationX));
            
            label.rotation.set(rotationX, rotationY, 0);
            backLabel.rotation.set(rotationX, rotationY + Math.PI, 0);
            
            lastMouseX = e.clientX;
            lastMouseY = e.clientY;
        }
        
        function endRotation() {
            isRotating = false;
        }
        
        function animate() {
            requestAnimationFrame(animate);
            renderer.render(scene, camera);
        }

        // Create animated stars
        function createStars() {
            const starsContainer = document.getElementById('stars');
            const numStars = 200;
            
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

        function bookTicket() {
            alert('Rezerwacja biletu do {{ $destination["name"] }} - Przekierowanie do płatności...');
        }

        // Initialize everything
        document.addEventListener('DOMContentLoaded', function() {
            createStars();
            init3DLabel();
        });
    </script>
</body>
</html>
