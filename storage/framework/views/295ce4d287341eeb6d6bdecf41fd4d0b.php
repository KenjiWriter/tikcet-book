<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>GwiezdnePodróże - Biuro do nieziemskich podróży</title>
    <meta name="description" content="Odkryj magię Polski przez holograficzne podróże. Podróżuj w przyszłość z GwiezdnePodróże.">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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

        .star::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: radial-gradient(circle, rgba(255, 107, 53, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.5); }
        }

        /* 3D City silhouette */
        .city-silhouette {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 300px;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 100%);
            z-index: 1;
            perspective: 1000px;
        }

        .city-building {
            position: absolute;
            bottom: 0;
            background: linear-gradient(to top, #0a0a0a 0%, #1a0b2e 50%, #2d1b69 100%);
            border-radius: 8px 8px 0 0;
            box-shadow: 
                0 0 30px rgba(255, 107, 53, 0.3),
                inset 0 0 20px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.2);
        }

        .city-building::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                /* Multiple window rows */
                linear-gradient(90deg, transparent 15%, rgba(255, 107, 53, 0.6) 18%, transparent 22%),
                linear-gradient(90deg, transparent 35%, rgba(255, 107, 53, 0.4) 38%, transparent 42%),
                linear-gradient(90deg, transparent 55%, rgba(255, 107, 53, 0.7) 58%, transparent 62%),
                linear-gradient(90deg, transparent 75%, rgba(255, 107, 53, 0.3) 78%, transparent 82%),
                /* Vertical window columns */
                linear-gradient(0deg, transparent 10%, rgba(255, 107, 53, 0.5) 15%, transparent 20%),
                linear-gradient(0deg, transparent 30%, rgba(255, 107, 53, 0.4) 35%, transparent 40%),
                linear-gradient(0deg, transparent 50%, rgba(255, 107, 53, 0.6) 55%, transparent 60%),
                linear-gradient(0deg, transparent 70%, rgba(255, 107, 53, 0.3) 75%, transparent 80%),
                linear-gradient(0deg, transparent 90%, rgba(255, 107, 53, 0.5) 95%, transparent 100%);
            background-size: 100% 15px, 100% 15px, 100% 15px, 100% 15px, 20px 100%, 20px 100%, 20px 100%, 20px 100%, 20px 100%;
            border-radius: 8px 8px 0 0;
            animation: windowFlicker 4s ease-in-out infinite;
        }

        .city-building::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #ff6b35, transparent);
            animation: buildingTopGlow 2s ease-in-out infinite;
        }

        /* Additional building details */
        .city-building:nth-child(1)::before {
            background: 
                /* Windows */
                linear-gradient(90deg, transparent 15%, rgba(255, 107, 53, 0.6) 18%, transparent 22%),
                linear-gradient(90deg, transparent 35%, rgba(255, 107, 53, 0.4) 38%, transparent 42%),
                linear-gradient(90deg, transparent 55%, rgba(255, 107, 53, 0.7) 58%, transparent 62%),
                linear-gradient(90deg, transparent 75%, rgba(255, 107, 53, 0.3) 78%, transparent 82%),
                /* Antenna */
                linear-gradient(0deg, transparent 5%, #ff6b35 6%, transparent 7%),
                /* AC units */
                linear-gradient(0deg, transparent 25%, rgba(255, 107, 53, 0.8) 26%, transparent 27%),
                linear-gradient(0deg, transparent 45%, rgba(255, 107, 53, 0.8) 46%, transparent 47%);
            background-size: 100% 12px, 100% 12px, 100% 12px, 100% 12px, 2px 100%, 8px 100%, 8px 100%;
        }

        .city-building:nth-child(3)::before {
            background: 
                /* More complex window pattern */
                linear-gradient(90deg, transparent 10%, rgba(255, 107, 53, 0.5) 15%, transparent 20%),
                linear-gradient(90deg, transparent 30%, rgba(255, 107, 53, 0.6) 35%, transparent 40%),
                linear-gradient(90deg, transparent 50%, rgba(255, 107, 53, 0.4) 55%, transparent 60%),
                linear-gradient(90deg, transparent 70%, rgba(255, 107, 53, 0.7) 75%, transparent 80%),
                linear-gradient(90deg, transparent 90%, rgba(255, 107, 53, 0.3) 95%, transparent 100%),
                /* Balconies */
                linear-gradient(0deg, transparent 20%, rgba(255, 107, 53, 0.9) 21%, transparent 22%),
                linear-gradient(0deg, transparent 40%, rgba(255, 107, 53, 0.9) 41%, transparent 42%),
                linear-gradient(0deg, transparent 60%, rgba(255, 107, 53, 0.9) 61%, transparent 62%),
                linear-gradient(0deg, transparent 80%, rgba(255, 107, 53, 0.9) 81%, transparent 82%);
            background-size: 100% 10px, 100% 10px, 100% 10px, 100% 10px, 100% 10px, 100% 2px, 100% 2px, 100% 2px, 100% 2px;
        }

        .city-building:nth-child(6)::before {
            background: 
                /* Skyscraper windows */
                linear-gradient(90deg, transparent 12%, rgba(255, 107, 53, 0.6) 15%, transparent 18%),
                linear-gradient(90deg, transparent 32%, rgba(255, 107, 53, 0.4) 35%, transparent 38%),
                linear-gradient(90deg, transparent 52%, rgba(255, 107, 53, 0.7) 55%, transparent 58%),
                linear-gradient(90deg, transparent 72%, rgba(255, 107, 53, 0.3) 75%, transparent 78%),
                linear-gradient(90deg, transparent 92%, rgba(255, 107, 53, 0.5) 95%, transparent 98%),
                /* Vertical lines */
                linear-gradient(0deg, transparent 0%, rgba(255, 107, 53, 0.2) 50%, transparent 100%);
            background-size: 100% 8px, 100% 8px, 100% 8px, 100% 8px, 100% 8px, 1px 100%;
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

        .city-building:nth-child(8) {
            left: 90%;
            width: 60px;
            height: 160px;
            animation: buildingGlow 4s ease-in-out infinite 0.8s;
        }

        .city-building:nth-child(9) {
            left: 5%;
            width: 45px;
            height: 120px;
            animation: buildingGlow 4s ease-in-out infinite 1.2s;
        }

        .city-building:nth-child(10) {
            left: 15%;
            width: 70px;
            height: 180px;
            animation: buildingGlow 4s ease-in-out infinite 2.8s;
        }

        .city-building:nth-child(11) {
            left: 85%;
            width: 50px;
            height: 140px;
            animation: buildingGlow 4s ease-in-out infinite 1.8s;
        }

        .city-building:nth-child(12) {
            left: 95%;
            width: 40px;
            height: 100px;
            animation: buildingGlow 4s ease-in-out infinite 2.2s;
        }

        @keyframes buildingGlow {
            0%, 100% { 
                box-shadow: 
                    0 0 30px rgba(255, 107, 53, 0.3),
                    inset 0 0 20px rgba(255, 107, 53, 0.1);
                transform: translateY(0);
            }
            50% { 
                box-shadow: 
                    0 0 50px rgba(255, 107, 53, 0.5),
                    inset 0 0 30px rgba(255, 107, 53, 0.2);
                transform: translateY(-5px);
            }
        }

        @keyframes windowFlicker {
            0%, 100% { opacity: 0.8; }
            25% { opacity: 0.3; }
            50% { opacity: 1; }
            75% { opacity: 0.6; }
        }

        @keyframes buildingTopGlow {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        /* 3D Label - OGROMNA bez obramowania */
        .ticket-3d-container {
            position: fixed;
            bottom: 20%;
            right: 5%;
            width: 500px;
            height: 400px;
            z-index: 100;
            cursor: grab;
            user-select: none;
            background: transparent;
            border: none;
            display: none;
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
            left: -250px;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 107, 53, 0.4);
            border-radius: 20px;
            padding: 30px;
            width: 220px;
            color: white;
            font-size: 14px;
            line-height: 1.6;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        .ticket-description.show-ticket {
            background: rgba(255, 107, 53, 0.1);
            border-color: #ff6b35;
        }

        .ticket-description h3 {
            color: #ff6b35;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
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


        /* Enhanced Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(15px);
            padding: 15px 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 107, 53, 0.3);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
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

        .brand-tagline {
            color: white;
            font-size: 14px;
            opacity: 0.9;
            font-weight: 300;
        }

        .nav-links {
            display: flex;
            gap: 40px;
            align-items: center;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            transition: all 0.4s ease;
            padding: 15px 20px;
            border-radius: 15px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .nav-item:hover {
            background: rgba(255, 107, 53, 0.1);
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
        }

        .nav-icon {
            font-size: 24px;
            transition: all 0.3s ease;
        }

        .nav-item:hover .nav-icon {
            transform: scale(1.2) rotate(10deg);
        }

        .nav-text {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .language-selector {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 107, 53, 0.3);
            color: white;
            padding: 10px 15px;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .language-selector:hover {
            border-color: #ff6b35;
            box-shadow: 0 0 20px rgba(255, 107, 53, 0.3);
        }

        .auth-buttons {
            display: flex;
            gap: 15px;
        }

        .auth-btn {
            padding: 10px 20px;
            border: 2px solid #ff6b35;
            background: transparent;
            color: #ff6b35;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }

        .auth-btn:hover {
            background: #ff6b35;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.4);
        }

        .auth-btn.primary {
            background: #ff6b35;
            color: white;
        }

        .auth-btn.primary:hover {
            background: #ff8e53;
        }

        /* Main content */
        .main-content {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 120px 20px 300px;
        }

        .hero-title {
            font-size: 5rem;
            font-weight: 900;
            color: #ff6b35;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 0 0 40px rgba(255, 107, 53, 0.7);
            letter-spacing: 3px;
            animation: titleGlow 3s ease-in-out infinite;
        }

        .hero-subtitle {
            font-size: 1.4rem;
            color: white;
            text-align: center;
            margin-bottom: 80px;
            opacity: 0.9;
            font-weight: 300;
            letter-spacing: 1px;
        }

        /* Search form */
        .search-container {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(30px);
            border: 2px solid rgba(255, 107, 53, 0.4);
            border-radius: 25px;
            padding: 50px;
            width: 100%;
            max-width: 900px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .search-form {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 25px;
            align-items: end;
        }

        .form-group {
            position: relative;
        }

        .form-label {
            display: block;
            color: #ff6b35;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px;
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

        .date-range-container {
            display: flex;
            align-items: center;
            gap: 15px;
            width: 100%;
        }

        .date-input-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .date-label {
            color: #ff6b35;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
        }

        .date-input {
            text-align: center;
            font-size: 14px;
            padding: 12px 15px;
        }

        .date-separator {
            color: #ff6b35;
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
        }

        .search-button {
            background: linear-gradient(45deg, #ff6b35, #ff8e53);
            border: none;
            border-radius: 15px;
            color: white;
            font-size: 16px;
            font-weight: 700;
            padding: 18px 35px;
            cursor: pointer;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .search-button:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.5);
        }

        /* Search Results */
        .search-results {
            margin-top: 60px;
            width: 100%;
            max-width: 1200px;
            display: none;
        }

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .results-title {
            color: #ff6b35;
            font-size: 28px;
            font-weight: 700;
        }

        .filters {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 20px;
            background: rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.3);
            color: white;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn.active {
            background: #ff6b35;
            border-color: #ff6b35;
        }

        .tickets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
        }

        .ticket-card {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 107, 53, 0.3);
            border-radius: 20px;
            padding: 25px;
            transition: all 0.4s ease;
        }

        .ticket-card:hover {
            transform: translateY(-5px);
            border-color: #ff6b35;
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.3);
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .ticket-route {
            color: white;
            font-size: 20px;
            font-weight: 700;
        }

        .ticket-price {
            color: #ff6b35;
            font-size: 24px;
            font-weight: 700;
        }

        .ticket-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.8);
        }

        .detail-icon {
            color: #ff6b35;
            font-size: 16px;
        }

        .book-ticket-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, #ff6b35, #ff8e53);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .book-ticket-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.4);
        }

        /* Features */
        /* Cities Section */
        .cities-section {
            margin-top: 100px;
            width: 100%;
            max-width: 1200px;
        }

        .cities-title {
            color: #ff6b35;
            font-size: 32px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 50px;
            text-shadow: 0 0 20px rgba(255, 107, 53, 0.5);
        }

        .cities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }

        .city-card {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 20px;
            padding: 25px;
            text-align: left;
            cursor: pointer;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .city-card:hover {
            transform: translateY(-10px) scale(1.05);
            border-color: #ff6b35;
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.3);
        }

        .city-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .city-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 107, 53, 0.2);
            padding: 5px 10px;
            border-radius: 15px;
        }

        .rating-star {
            font-size: 14px;
        }

        .rating-value {
            font-weight: 600;
            color: #ff6b35;
        }

        .city-name {
            font-size: 24px;
            font-weight: 700;
            color: #ff6b35;
            margin: 0;
        }

        .city-description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
        }

        .city-features {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .feature-tag {
            background: rgba(255, 107, 53, 0.1);
            color: #ff6b35;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 500;
        }

        .city-pricing {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 15px;
        }

        .price-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .price-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .price-value {
            font-size: 20px;
            font-weight: 700;
            color: #ff6b35;
        }

        .duration-info {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .duration-icon {
            font-size: 16px;
        }

        .duration-value {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .check-button {
            background: linear-gradient(45deg, #ff6b35, #ff8e53);
            border: none;
            border-radius: 15px;
            padding: 12px 20px;
            color: white;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }

        .check-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
        }

        .check-icon {
            font-size: 16px;
        }

        .city-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .city-card:hover::before {
            left: 100%;
        }

        .city-icon {
            font-size: 40px;
            margin-bottom: 15px;
            display: block;
        }

        .city-name {
            color: white;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .city-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            line-height: 1.4;
        }

        .features {
            margin-top: 100px;
            display: flex;
            justify-content: center;
            gap: 80px;
        }

        .feature-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            color: white;
            transition: all 0.4s ease;
            cursor: pointer;
            padding: 20px;
            border-radius: 20px;
        }

        .feature-item:hover {
            transform: translateY(-10px) scale(1.1);
        }

        .feature-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #ff6b35, #ff8e53);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.4);
        }

        .feature-text {
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Animations */
        @keyframes logoRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes titleGlow {
            0%, 100% { text-shadow: 0 0 40px rgba(255, 107, 53, 0.7); }
            50% { text-shadow: 0 0 60px rgba(255, 107, 53, 1); }
        }

        /* Tickets Section */
        .tickets-section {
            padding: 80px 20px;
            text-align: center;
        }

        .tickets-title {
            font-size: 3rem;
            font-weight: 800;
            color: #ff6b35;
            margin-bottom: 50px;
            text-shadow: 0 0 30px rgba(255, 107, 53, 0.5);
        }

        .tickets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .ticket-type-card {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(20px);
            border: 3px solid;
            border-radius: 20px;
            padding: 30px;
            text-align: left;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .ticket-type-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .ticket-icon {
            font-size: 2.5rem;
        }

        .ticket-price {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .ticket-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
        }

        .ticket-description {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .ticket-features {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 25px;
        }

        .ticket-feature {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .select-ticket-btn {
            width: 100%;
            padding: 15px 25px;
            border: none;
            border-radius: 15px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .select-ticket-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        /* Routes Section */
        .routes-section {
            padding: 80px 20px;
            text-align: center;
        }

        .routes-title {
            font-size: 3rem;
            font-weight: 800;
            color: #ff6b35;
            margin-bottom: 50px;
            text-shadow: 0 0 30px rgba(255, 107, 53, 0.5);
        }

        .routes-calculator {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 20px;
            padding: 40px;
        }

        .route-inputs {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .route-input-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .route-label {
            color: #ff6b35;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .route-input {
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .route-input:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 20px rgba(255, 107, 53, 0.3);
        }

        .route-separator {
            color: #ff6b35;
            font-size: 2rem;
            font-weight: bold;
            margin-top: 20px;
        }

        .calculate-route-btn {
            background: linear-gradient(45deg, #ff6b35, #ff8e53);
            border: none;
            border-radius: 15px;
            padding: 15px 30px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .calculate-route-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
        }

        .route-result {
            margin-top: 30px;
        }

        .route-success {
            background: rgba(0, 255, 0, 0.1);
            border: 2px solid rgba(0, 255, 0, 0.3);
            border-radius: 15px;
            padding: 25px;
            text-align: left;
        }

        .route-success h3 {
            color: #ff6b35;
            margin-bottom: 20px;
            text-align: center;
        }

        .route-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .route-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .detail-icon {
            font-size: 1.5rem;
        }

        .detail-label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .detail-value {
            color: #ff6b35;
            font-weight: 700;
            margin-left: auto;
        }

        .book-route-btn {
            width: 100%;
            background: linear-gradient(45deg, #ff6b35, #ff8e53);
            border: none;
            border-radius: 15px;
            padding: 15px 25px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .book-route-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
        }

        .route-error {
            background: rgba(255, 0, 0, 0.1);
            border: 2px solid rgba(255, 0, 0, 0.3);
            border-radius: 15px;
            padding: 20px;
            color: #ff6b35;
            text-align: center;
            font-weight: 600;
        }

        /* Profile Dropdown */
        .profile-item {
            position: relative;
            display: none; /* Hidden by default, shown when logged in */
        }

        .profile-dropdown {
            position: fixed;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 15px;
            padding: 20px;
            min-width: 280px;
            display: none;
            z-index: 1000;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }

        .profile-dropdown.show {
            display: block;
            animation: profileSlideIn 0.3s ease;
        }

        /* Settings Panel */
        .settings-panel {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 20px;
            padding: 0;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            display: none;
            z-index: 2000;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.7);
            overflow: hidden;
        }

        .settings-panel.show {
            display: block;
            animation: settingsSlideIn 0.3s ease;
        }

        .settings-header {
            background: rgba(255, 107, 53, 0.1);
            padding: 20px;
            border-bottom: 1px solid rgba(255, 107, 53, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .settings-header h3 {
            color: #ff6b35;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .close-settings {
            background: none;
            border: none;
            color: #ff6b35;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .close-settings:hover {
            background: rgba(255, 107, 53, 0.2);
            transform: rotate(90deg);
        }

        .settings-content {
            padding: 30px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .settings-section {
            margin-bottom: 30px;
        }

        .settings-section h4 {
            color: #ff6b35;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(255, 107, 53, 0.2);
            padding-bottom: 5px;
        }

        .setting-item {
            margin-bottom: 20px;
        }

        .setting-item label {
            display: block;
            color: white;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .setting-item input,
        .setting-item select {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.3);
            border-radius: 10px;
            color: white;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .setting-item input:focus,
        .setting-item select:focus {
            outline: none;
            border-color: #ff6b35;
            background: rgba(255, 107, 53, 0.1);
            box-shadow: 0 0 10px rgba(255, 107, 53, 0.3);
        }

        .setting-item input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Avatar Upload Styles */
        .avatar-options {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .avatar-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 107, 53, 0.1);
            border: 2px solid rgba(255, 107, 53, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto;
            overflow: hidden;
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .avatar-upload {
            text-align: center;
        }

        .upload-btn {
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-btn:hover {
            background: linear-gradient(135deg, #ff8c42, #ff6b35);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        }

        .avatar-emoji-options {
            text-align: center;
        }

        .avatar-emoji-options label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        .avatar-emoji-options select {
            width: 100%;
            max-width: 200px;
        }

        .settings-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 107, 53, 0.2);
        }

        .save-settings,
        .cancel-settings {
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .save-settings {
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            color: white;
        }

        .save-settings:hover {
            background: linear-gradient(135deg, #ff8c42, #ff6b35);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        }

        .cancel-settings {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 107, 53, 0.3);
        }

        .cancel-settings:hover {
            background: rgba(255, 107, 53, 0.2);
            border-color: #ff6b35;
        }

        @keyframes settingsSlideIn {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        /* Tickets, History, Help Panels */
        .tickets-panel,
        .history-panel,
        .help-panel {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 20px;
            padding: 0;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            display: none;
            z-index: 2000;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.7);
            overflow: hidden;
        }

        .tickets-panel.show,
        .history-panel.show,
        .help-panel.show {
            display: block;
            animation: settingsSlideIn 0.3s ease;
        }

        .panel-header {
            background: rgba(255, 107, 53, 0.1);
            padding: 20px;
            border-bottom: 1px solid rgba(255, 107, 53, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-header h3 {
            color: #ff6b35;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .close-panel {
            background: none;
            border: none;
            color: #ff6b35;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .close-panel:hover {
            background: rgba(255, 107, 53, 0.2);
            transform: rotate(90deg);
        }

        .panel-content {
            padding: 30px;
            max-height: 60vh;
            overflow-y: auto;
        }

        /* Tickets Filter */
        .tickets-filter {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .filter-btn {
            padding: 8px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.3);
            border-radius: 10px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn.active,
        .filter-btn:hover {
            background: rgba(255, 107, 53, 0.2);
            border-color: #ff6b35;
        }

        /* Ticket Item */
        .ticket-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 107, 53, 0.2);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .ticket-item:hover {
            background: rgba(255, 107, 53, 0.1);
            border-color: #ff6b35;
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .ticket-route {
            font-size: 18px;
            font-weight: 600;
            color: #ff6b35;
        }

        .ticket-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .ticket-status.active {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
        }

        .ticket-status.expired {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .ticket-status.completed {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }

        .no-tickets {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-style: italic;
            padding: 40px 20px;
        }

        .ticket-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .ticket-detail {
            display: flex;
            flex-direction: column;
        }

        .ticket-detail-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 4px;
        }

        .ticket-detail-value {
            font-size: 14px;
            color: white;
            font-weight: 500;
        }

        .ticket-actions {
            display: flex;
            gap: 10px;
        }

        .ticket-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ticket-btn.primary {
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            color: white;
        }

        .ticket-btn.secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 107, 53, 0.3);
        }

        .ticket-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
        }

        /* Help Panel Styles */
        .help-sections {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .help-section h4 {
            color: #ff6b35;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(255, 107, 53, 0.2);
            padding-bottom: 5px;
        }

        .help-section p {
            color: white;
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .faq-item {
            margin-bottom: 15px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .faq-item strong {
            color: #ff6b35;
            display: block;
            margin-bottom: 8px;
        }

        .faq-item p {
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .feature-icon {
            font-size: 20px;
        }

        .feature-item span:last-child {
            color: white;
            font-weight: 500;
        }

        /* Awesome Footer */
        .awesome-footer {
            background: linear-gradient(135deg, rgba(10, 10, 10, 0.8) 0%, rgba(26, 11, 46, 0.8) 50%, rgba(45, 27, 105, 0.8) 100%);
            backdrop-filter: blur(20px);
            border-top: 2px solid rgba(255, 107, 53, 0.3);
            padding: 60px 0 20px;
            position: relative;
            overflow: hidden;
            margin-top: 80px;
            z-index: 10;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1.5fr;
            gap: 40px;
            position: relative;
            z-index: 2;
        }

        .footer-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .footer-title {
            font-size: 28px;
            font-weight: 700;
            color: #ff6b35;
            margin: 0;
            text-shadow: 0 0 10px rgba(255, 107, 53, 0.5);
        }

        .footer-desc {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            margin: 0;
            font-size: 14px;
        }

        .footer-subtitle {
            font-size: 18px;
            font-weight: 600;
            color: #ff6b35;
            margin: 0 0 15px 0;
            border-bottom: 2px solid rgba(255, 107, 53, 0.3);
            padding-bottom: 8px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-links li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            padding: 5px 0;
        }

        .footer-links li a:hover {
            color: #ff6b35;
            transform: translateX(5px);
        }

        .social-links {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .social-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            padding: 8px 12px;
            border: 1px solid rgba(255, 107, 53, 0.3);
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 12px;
        }

        .social-link:hover {
            background: rgba(255, 107, 53, 0.2);
            border-color: #ff6b35;
            color: #ff6b35;
            transform: translateY(-2px);
        }

        .app-downloads {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .download-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.3);
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            background: rgba(255, 107, 53, 0.2);
            border-color: #ff6b35;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
        }

        .download-icon {
            font-size: 24px;
        }

        .download-text {
            display: flex;
            flex-direction: column;
        }

        .download-title {
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            font-weight: 500;
        }

        .download-subtitle {
            color: #ff6b35;
            font-size: 14px;
            font-weight: 600;
        }

        .footer-bottom {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 107, 53, 0.2);
        }

        .footer-bottom-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-copyright {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }

        .footer-tech {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .tech-item {
            color: rgba(255, 107, 53, 0.8);
            font-size: 12px;
            font-weight: 500;
            padding: 4px 8px;
            background: rgba(255, 107, 53, 0.1);
            border-radius: 6px;
        }

        .footer-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .footer-particles::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 20%, rgba(255, 107, 53, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 107, 53, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 60%, rgba(255, 107, 53, 0.08) 0%, transparent 50%);
            animation: footerGlow 6s ease-in-out infinite alternate;
        }

        @keyframes footerGlow {
            0% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
                text-align: center;
            }
            
            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Floating Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: radial-gradient(circle, #ff6b35, transparent);
            border-radius: 50%;
            animation: floatParticle 8s linear infinite;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Live Clock */
        .live-clock {
            position: fixed;
            top: 140px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 15px;
            padding: 15px 20px;
            z-index: 1000;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
            pointer-events: auto;
        }

        .live-clock:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.3);
        }

        .clock-time {
            font-size: 24px;
            font-weight: 700;
            color: #ff6b35;
            margin-bottom: 5px;
            text-shadow: 0 0 10px rgba(255, 107, 53, 0.5);
        }

        .clock-date {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        /* Weather Widget */
        .weather-widget {
            position: fixed;
            top: 140px;
            left: 20px;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 107, 53, 0.3);
            border-radius: 15px;
            padding: 15px 20px;
            z-index: 1000;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
            pointer-events: auto;
        }

        .weather-icon {
            font-size: 32px;
            margin-bottom: 5px;
            animation: weatherFloat 3s ease-in-out infinite;
        }

        .weather-temp {
            font-size: 20px;
            font-weight: 700;
            color: #ff6b35;
            margin-bottom: 5px;
        }

        .weather-desc {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .weather-location {
            font-size: 10px;
            color: #999;
            margin-top: 5px;
        }

        .weather-loading {
            font-size: 12px;
            color: #ff6b35;
            animation: pulse 1.5s infinite;
        }

        @keyframes weatherFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }


        /* Search Suggestions */
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.98);
            backdrop-filter: blur(25px);
            border: 2px solid rgba(255, 107, 53, 0.6);
            border-radius: 0 0 15px 15px;
            padding: 15px;
            z-index: 1000;
            display: none;
            box-shadow: 
                0 15px 40px rgba(0, 0, 0, 0.7),
                0 0 20px rgba(255, 107, 53, 0.3);
            max-height: 200px;
            overflow-y: auto;
        }

        .search-form {
            position: relative;
        }

        .search-suggestions.show {
            display: block;
            animation: suggestionsSlideIn 0.3s ease;
        }

        .suggestion-item {
            padding: 12px 18px;
            color: white;
            cursor: pointer;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-bottom: 8px;
            font-size: 16px;
            font-weight: 500;
            border: 1px solid rgba(255, 107, 53, 0.2);
            background: rgba(255, 107, 53, 0.05);
        }

        .suggestion-item:hover {
            background: rgba(255, 107, 53, 0.3);
            transform: translateX(8px);
            border-color: rgba(255, 107, 53, 0.6);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.2);
        }

        .suggestion-item:last-child {
            margin-bottom: 0;
        }

        @keyframes suggestionsSlideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Interactive hover effects */
        .nav-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
        }

        .city-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.4);
        }

        .ticket-type-card:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 30px rgba(255, 107, 53, 0.3);
        }

        /* Smooth transitions for all interactive elements */
        .nav-item,
        .city-card,
        .ticket-type-card,
        .auth-btn,
        .search-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Glowing text effect */
        .hero-title {
            text-shadow: 
                0 0 10px rgba(255, 107, 53, 0.5),
                0 0 20px rgba(255, 107, 53, 0.3),
                0 0 30px rgba(255, 107, 53, 0.1);
            animation: titleGlow 3s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            0% {
                text-shadow: 
                    0 0 10px rgba(255, 107, 53, 0.5),
                    0 0 20px rgba(255, 107, 53, 0.3),
                    0 0 30px rgba(255, 107, 53, 0.1);
            }
            100% {
                text-shadow: 
                    0 0 20px rgba(255, 107, 53, 0.8),
                    0 0 30px rgba(255, 107, 53, 0.5),
                    0 0 40px rgba(255, 107, 53, 0.2);
            }
        }

        @keyframes profileSlideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 107, 53, 0.3);
        }

        .profile-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, #ff6b35, #ff8e53);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .profile-email {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .profile-menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .profile-menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .profile-menu-item:hover {
            background: rgba(255, 107, 53, 0.2);
            color: #ff6b35;
            transform: translateX(5px);
        }

        .profile-menu-item.logout {
            color: #ff6b6b;
        }

        .profile-menu-item.logout:hover {
            background: rgba(255, 107, 107, 0.2);
            color: #ff6b6b;
        }

        .menu-icon {
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
        }

        .profile-divider {
            height: 1px;
            background: rgba(255, 107, 53, 0.3);
            margin: 10px 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 3rem;
            }
            
            .search-form {
                grid-template-columns: 1fr;
            }
            
            .nav-links {
                display: none;
            }
            
            .features {
                gap: 40px;
            }
            
            .ticket-3d-container {
                display: none;
            }
            
            .profile-dropdown {
                right: 10px;
                left: 10px;
                min-width: auto;
                width: calc(100% - 20px);
            }
        }

        /* Widgets Responsive */
        @media (max-width: 768px) {
            .weather-widget {
                top: 130px;
                left: 10px;
                right: 10px;
                width: auto;
            }

            .live-clock {
                top: 200px;
                left: 10px;
                right: 10px;
                width: auto;
            }

            .clock-time {
                font-size: 20px;
            }

            .weather-icon {
                font-size: 28px;
            }

            .weather-temp {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated stars background -->
    <div class="stars" id="stars"></div>
    
    <!-- Floating particles -->
    <div class="particles" id="particles"></div>
    
    <!-- Weather widget -->
    <div class="weather-widget" id="weather-widget">
        <div class="weather-icon">🌤️</div>
        <div class="weather-temp">22°C</div>
        <div class="weather-desc">Słonecznie</div>
        <div class="weather-location" id="weather-location">Pobieranie lokalizacji...</div>
    </div>
    
    <!-- Live clock -->
    <div class="live-clock" id="live-clock">
        <div class="clock-time" id="clock-time">00:00:00</div>
        <div class="clock-date" id="clock-date">Poniedziałek, 1 stycznia 2025</div>
    </div>
    
    
    <!-- 3D City silhouette -->
    <div class="city-silhouette">
        <div class="city-building"></div>
        <div class="city-building"></div>
        <div class="city-building"></div>
        <div class="city-building"></div>
        <div class="city-building"></div>
        <div class="city-building"></div>
        <div class="city-building"></div>
        <div class="city-building"></div>
        <div class="city-building"></div>
        <div class="city-building"></div>
        <div class="city-building"></div>
        <div class="city-building"></div>
    </div>

    <!-- 3D Label - OGROMNA bez obramowania -->
    <div class="ticket-3d-container" id="ticketContainer">
        <canvas id="ticket-canvas"></canvas>
        <div class="ticket-description" id="ticketDescription">
            <h3>🎫 Bilety 3D</h3>
            <p>Odkryj <span class="highlight">holograficzne bilety</span> przyszłości!</p>
            <p>• <span class="highlight">Interaktywne</span> - obracaj myszką</p>
            <p>• <span class="highlight">Futurystyczne</span> - technologia 3D</p>
            <p>• <span class="highlight">Bezpieczne</span> - szyfrowane</p>
            <p>• <span class="highlight">Przyszłościowe</span> - hologramy</p>
        </div>
        <div class="rotation-hint">
            🖱️ Przytrzymaj lewy przycisk i przeciągnij aby obracać
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo-section">
                <div class="logo" onclick="showTicket()">🚀</div>
                <div>
                    <div class="brand-text">GwiezdnePodróże</div>
                    <div class="brand-tagline">Biuro do nieziemskich podróży</div>
                        </div>
                    </div>
            
            <div class="nav-links">
                <a href="#" class="nav-item" onclick="showCities()">
                    <div class="nav-icon">🏢</div>
                    <div class="nav-text">Miasta</div>
                </a>
                <a href="#" class="nav-item" onclick="showTickets()">
                    <div class="nav-icon">🎫</div>
                    <div class="nav-text">Bilety</div>
                </a>
                <a href="#" class="nav-item" onclick="showRoutes()">
                    <div class="nav-icon">🗺️</div>
                    <div class="nav-text">Trasy</div>
                </a>
                <div class="nav-item profile-item" onclick="showProfile()">
                    <div class="nav-icon">👤</div>
                    <div class="nav-text">Profil</div>
                </div>
                </div>

            <div class="nav-right">
                <select class="language-selector" onchange="changeLanguage(this.value)">
                    <option value="pl">🇵🇱 Polski</option>
                    <option value="en">🇺🇸 English</option>
                    <option value="de">🇩🇪 Deutsch</option>
                    <option value="fr">🇫🇷 Français</option>
                    <option value="es">🇪🇸 Español</option>
                    <option value="it">🇮🇹 Italiano</option>
                    <option value="ru">🇷🇺 Русский</option>
                    <option value="uk">🇺🇦 Українська</option>
                    <option value="cs">🇨🇿 Čeština</option>
                    <option value="sk">🇸🇰 Slovenčina</option>
                    <option value="hu">🇭🇺 Magyar</option>
                    <option value="ja">🇯🇵 日本語</option>
                    <option value="ko">🇰🇷 한국어</option>
                    <option value="zh">🇨🇳 中文</option>
                    <option value="ar">🇸🇦 العربية</option>
                </select>
                <div class="auth-buttons">
                    <a href="/login" class="auth-btn">Zaloguj</a>
                    <a href="/register" class="auth-btn primary">Zarejestruj</a>
                </div>
            </div>
        </div>
    </nav>

        <!-- Profile Dropdown - Separate container -->
        <div class="profile-dropdown" id="profile-dropdown">
            <div class="profile-header">
                <div class="profile-avatar">👤</div>
                <div class="profile-info">
                    <div class="profile-name">Użytkownik</div>
                    <div class="profile-email">user@example.com</div>
                </div>
            </div>
            <div class="profile-menu">
                <a href="#" class="profile-menu-item" onclick="showSettings()">
                    <span class="menu-icon">⚙️</span>
                    Ustawienia
                </a>
                <a href="#" class="profile-menu-item" onclick="showMyTickets()">
                    <span class="menu-icon">🎫</span>
                    Moje bilety
                </a>
                <a href="#" class="profile-menu-item" onclick="showHistory()">
                    <span class="menu-icon">📜</span>
                    Historia
                </a>
                <a href="#" class="profile-menu-item" onclick="showHelp()">
                    <span class="menu-icon">❓</span>
                    Pomoc
                </a>
                <div class="profile-divider"></div>
                <a href="#" class="profile-menu-item logout" onclick="logout()">
                    <span class="menu-icon">🚪</span>
                    Wyloguj
                </a>
            </div>
        </div>

        <!-- Settings Panel -->
        <div class="settings-panel" id="settings-panel">
            <div class="settings-header">
                <h3>Ustawienia</h3>
                <button class="close-settings" onclick="closeSettings()">✕</button>
                            </div>
            <div class="settings-content">
                <div class="settings-section">
                    <h4>Profil</h4>
                    <div class="setting-item">
                        <label>Imię i nazwisko:</label>
                        <input type="text" id="settings-name" placeholder="Wprowadź imię i nazwisko">
                            </div>
                    <div class="setting-item">
                        <label>Email:</label>
                        <input type="email" id="settings-email" placeholder="Wprowadź email">
                            </div>
                    <div class="setting-item">
                        <label>Avatar:</label>
                        <div class="avatar-options">
                            <div class="avatar-preview" id="avatar-preview">
                                <img id="avatar-image" src="" alt="Avatar" style="display: none;">
                                <span id="avatar-emoji">👤</span>
                            </div>
                            <div class="avatar-upload">
                                <input type="file" id="avatar-upload" accept="image/*" onchange="handleAvatarUpload(event)" style="display: none;">
                                <button type="button" class="upload-btn" onclick="document.getElementById('avatar-upload').click()">
                                    📷 Wgraj zdjęcie
                            </button>
                        </div>
                            <div class="avatar-emoji-options">
                                <label>Lub wybierz emoji:</label>
                                <select id="settings-avatar" onchange="updateAvatarEmoji(this.value)">
                                    <option value="👤">👤 Standardowy</option>
                                    <option value="👨">👨 Mężczyzna</option>
                                    <option value="👩">👩 Kobieta</option>
                                    <option value="🧑">🧑 Osoba</option>
                                    <option value="👨‍💼">👨‍💼 Biznesmen</option>
                                    <option value="👩‍💼">👩‍💼 Bizneswoman</option>
                                    <option value="🧑‍🎓">🧑‍🎓 Student</option>
                                    <option value="🧑‍🚀">🧑‍🚀 Astronauta</option>
                                </select>
                </div>
                </div>
                    </div>
                    </div>
                <div class="settings-section">
                    <h4>Preferencje</h4>
                    <div class="setting-item">
                        <label>Język:</label>
                        <select id="settings-language">
                            <option value="pl">🇵🇱 Polski</option>
                            <option value="en">🇬🇧 English</option>
                            <option value="de">🇩🇪 Deutsch</option>
                            <option value="fr">🇫🇷 Français</option>
                        </select>
                    </div>
                    <div class="setting-item">
                        <label>Motyw:</label>
                        <select id="settings-theme">
                            <option value="dark">🌙 Ciemny</option>
                            <option value="light">☀️ Jasny</option>
                            <option value="auto">🔄 Automatyczny</option>
                        </select>
                </div>
            </div>
                <div class="settings-actions">
                    <button class="save-settings" onclick="saveSettings()">Zapisz zmiany</button>
                    <button class="cancel-settings" onclick="closeSettings()">Anuluj</button>
        </div>
        </div>
                </div>

        <!-- Tickets Panel -->
        <div class="tickets-panel" id="tickets-panel">
            <div class="panel-header">
                <h3>Moje Bilety</h3>
                <button class="close-panel" onclick="closeTickets()">✕</button>
            </div>
            <div class="panel-content">
                <div class="tickets-filter">
                    <button class="filter-btn active" onclick="filterTickets('active')">Aktywne</button>
                    <button class="filter-btn" onclick="filterTickets('expired')">Wygasłe</button>
                </div>
                <div class="tickets-list" id="tickets-list">
                    <!-- Tickets will be loaded here -->
                </div>
            </div>
                </div>

        <!-- History Panel -->
        <div class="history-panel" id="history-panel">
            <div class="panel-header">
                <h3>Historia Podróży</h3>
                <button class="close-panel" onclick="closeHistory()">✕</button>
                    </div>
            <div class="panel-content">
                <div class="history-list" id="history-list">
                    <!-- History will be loaded here -->
                    </div>
                    </div>
                </div>

        <!-- Help Panel -->
        <div class="help-panel" id="help-panel">
            <div class="panel-header">
                <h3>Pomoc i Wsparcie</h3>
                <button class="close-panel" onclick="closeHelp()">✕</button>
            </div>
            <div class="panel-content">
                <div class="help-sections">
                    <div class="help-section">
                        <h4>📞 Kontakt</h4>
                        <p>Email: pomoc@gwiezdnepodroze.pl</p>
                        <p>Telefon: +48 123 456 789</p>
                        <p>Godziny: 8:00 - 20:00 (Pon-Pt)</p>
                    </div>
                    <div class="help-section">
                        <h4>❓ FAQ</h4>
                        <div class="faq-item">
                            <strong>Jak anulować bilet?</strong>
                            <p>Bilety można anulować do 24h przed podróżą w sekcji "Moje bilety".</p>
                        </div>
                        <div class="faq-item">
                            <strong>Jak zmienić datę podróży?</strong>
                            <p>Skontaktuj się z nami przez email lub telefon.</p>
                        </div>
                        <div class="faq-item">
                            <strong>Gdzie znajdę QR kod?</strong>
                            <p>QR kod znajduje się w szczegółach biletu w sekcji "Moje bilety".</p>
                        </div>
                    </div>
                    <div class="help-section">
                        <h4>🚀 Funkcje</h4>
                        <div class="feature-item">
                            <span class="feature-icon">🎫</span>
                            <span>Rezerwacja biletów</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">🗺️</span>
                            <span>Kalkulator tras</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">⭐</span>
                            <span>System ocen</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">🔔</span>
                            <span>Powiadomienia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Main content -->
    <main class="main-content">
        <h1 class="hero-title">PODRÓŻUJ W PRZYSZŁOŚĆ</h1>
        <p class="hero-subtitle">Odkryj magię Polski przez holograficzne podróże</p>
        
        <!-- Search form -->
                <div class="search-container">
            <form class="search-form" onsubmit="searchTrips(event)">
                <div class="form-group">
                    <label class="form-label">Skąd</label>
                    <select class="form-input" id="from-city">
                        <option value="">Wybierz miasto</option>
                    </select>
        </div>

                <div class="form-group">
                    <label class="form-label">Dokąd</label>
                    <select class="form-input" id="to-city">
                        <option value="">Wybierz miasto</option>
                                </select>
            </div>

                <div class="form-group">
                    <label class="form-label">Data</label>
                    <div class="date-range-container">
                        <div class="date-input-group">
                            <label class="date-label">Od:</label>
                            <input type="date" class="form-input date-input" id="travel-date-from">
                        </div>
                        <div class="date-separator">→</div>
                        <div class="date-input-group">
                            <label class="date-label">Do:</label>
                            <input type="date" class="form-input date-input" id="travel-date-to">
                        </div>
                    </div>
                        </div>

                <button type="submit" class="search-button">
                    <span>🚀</span>
                    ROZPOCZNIJ PODRÓŻ
                    </button>
                    
                    <!-- Search suggestions -->
                    <div class="search-suggestions" id="search-suggestions">
                        <div class="suggestion-item" onclick="selectSuggestion('Warszawa')">Warszawa</div>
                        <div class="suggestion-item" onclick="selectSuggestion('Kraków')">Kraków</div>
                        <div class="suggestion-item" onclick="selectSuggestion('Gdańsk')">Gdańsk</div>
                        <div class="suggestion-item" onclick="selectSuggestion('Wrocław')">Wrocław</div>
                    </div>
            </form>
                        </div>

        <!-- Search Results -->
        <div class="search-results" id="searchResults">
            <div class="results-header">
                <h2 class="results-title">Dostępne bilety</h2>
                <div class="filters">
                    <button class="filter-btn active" onclick="filterTickets('all')">Wszystkie</button>
                    <button class="filter-btn" onclick="filterTickets('price-low')">Cena: niska</button>
                    <button class="filter-btn" onclick="filterTickets('price-high')">Cena: wysoka</button>
                    <button class="filter-btn" onclick="filterTickets('rating')">Ocena</button>
                    <button class="filter-btn" onclick="filterTickets('duration')">Czas</button>
                        </div>
                    </div>
            <div class="tickets-grid" id="tickets-grid">
                <!-- Tickets will be populated by JavaScript -->
                            </div>
                        </div>

        <!-- Cities List -->
        <div class="cities-section" id="cities-section">
            <h2 class="cities-title">🏙️ Popularne Miasta</h2>
            <div class="cities-grid" id="citiesGrid">
                <!-- Cities will be populated by JavaScript -->
                        </div>
                    </div>

        <!-- Tickets Section -->
        <div class="tickets-section" id="tickets-section">
            <h2 class="tickets-title">🎫 Rodzaje Biletów</h2>
            <div class="tickets-grid" id="ticketsGrid">
                <!-- Tickets will be populated by JavaScript -->
                            </div>
                        </div>

        <!-- Routes Section -->
        <div class="routes-section" id="routes-section">
            <h2 class="routes-title">🗺️ Kalkulator Tras</h2>
            <div class="routes-calculator">
                <div class="route-inputs">
                    <div class="route-input-group">
                        <label class="route-label">Skąd:</label>
                        <input type="text" class="route-input" id="route-from" placeholder="Wpisz miasto startowe">
                    </div>
                    <div class="route-separator">→</div>
                    <div class="route-input-group">
                        <label class="route-label">Dokąd:</label>
                        <input type="text" class="route-input" id="route-to" placeholder="Wpisz miasto docelowe">
                </div>
                    <button class="calculate-route-btn" onclick="calculateRoute()">
                        <span class="calc-icon">🧮</span>
                        Oblicz trasę
                    </button>
                    </div>
                <div class="route-result" id="route-result">
                    <!-- Route calculation results will appear here -->
                            </div>
                        </div>
            </div>

        <!-- Features -->
        <div class="features">
            <div class="feature-item" onclick="showFeature('travel')">
                <div class="feature-icon">🎫</div>
                <div class="feature-text">Podróże</div>
                        </div>
            <div class="feature-item" onclick="showFeature('bus')">
                <div class="feature-icon">🚌</div>
                <div class="feature-text">Autobusy</div>
        </div>
            <div class="feature-item" onclick="showFeature('plane')">
                <div class="feature-icon">✈️</div>
                <div class="feature-text">Samoloty</div>
                </div>
            </div>
    </main>

    <!-- Awesome Footer -->
    <footer class="awesome-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3 class="footer-title">🚀 GwiezdnePodróże</h3>
                <p class="footer-desc">Przyszłość podróży już dziś. Odkryj Polskę w nowym wymiarze.</p>
                <div class="social-links">
                    <a href="#" class="social-link">📘 Facebook</a>
                    <a href="#" class="social-link">📷 Instagram</a>
                    <a href="#" class="social-link">🐦 Twitter</a>
                    <a href="#" class="social-link">💼 LinkedIn</a>
                </div>
                        </div>

            <div class="footer-section">
                <h4 class="footer-subtitle">🎫 Bilety</h4>
                <ul class="footer-links">
                    <li><a href="#">Kup bilet</a></li>
                    <li><a href="#">Moje bilety</a></li>
                    <li><a href="#">Historia podróży</a></li>
                    <li><a href="#">Anuluj bilet</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4 class="footer-subtitle">🗺️ Destynacje</h4>
                <ul class="footer-links">
                    <li><a href="#">Warszawa</a></li>
                    <li><a href="#">Kraków</a></li>
                    <li><a href="#">Gdańsk</a></li>
                    <li><a href="#">Wrocław</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4 class="footer-subtitle">❓ Pomoc</h4>
                <ul class="footer-links">
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kontakt</a></li>
                    <li><a href="#">Regulamin</a></li>
                    <li><a href="#">Polityka prywatności</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4 class="footer-subtitle">📱 Aplikacja</h4>
                <div class="app-downloads">
                    <a href="#" class="download-btn">
                        <span class="download-icon">📱</span>
                        <div class="download-text">
                            <div class="download-title">Pobierz na</div>
                            <div class="download-subtitle">App Store</div>
                        </div>
                    </a>
                    <a href="#" class="download-btn">
                        <span class="download-icon">🤖</span>
                        <div class="download-text">
                            <div class="download-title">Pobierz na</div>
                            <div class="download-subtitle">Google Play</div>
                    </div>
                    </a>
                </div>
            </div>
            </div>

        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="footer-copyright">
                    © 2025 GwiezdnePodróże. Wszystkie prawa zastrzeżone.
            </div>
                <div class="footer-tech">
                    <span class="tech-item">⚡ Powered by AI</span>
                    <span class="tech-item">🚀 Next-Gen Tech</span>
                    <span class="tech-item">🌍 Eco-Friendly</span>
        </div>
            </div>
        </div>
        
        <div class="footer-particles"></div>
    </footer>

    <script>
        // Cities data with descriptions and prices
        const citiesData = [
            { 
                name: "Warszawa", 
                icon: "🏛️", 
                description: "Stolica Polski - nowoczesna metropolia z bogatą historią",
                price: "45zł",
                duration: "2h 30min",
                rating: "4.8",
                features: ["Zamek Królewski", "Łazienki", "Pałac Kultury"]
            },
            { 
                name: "Kraków", 
                icon: "🐉", 
                description: "Królewskie miasto - perła polskiej architektury",
                price: "35zł",
                duration: "2h 45min",
                rating: "4.9",
                features: ["Wawel", "Rynek Główny", "Sukiennice"]
            },
            { 
                name: "Gdańsk", 
                icon: "⚓", 
                description: "Nadmorska perła - miasto bursztynu i historii",
                price: "55zł",
                duration: "3h 15min",
                rating: "4.7",
                features: ["Żuraw", "Długi Targ", "Stocznia"]
            },
            { 
                name: "Wrocław", 
                icon: "🧚", 
                description: "Miasto krasnali - wrocławska magia",
                price: "50zł",
                duration: "3h 00min",
                rating: "4.6",
                features: ["Rynek", "Krasnale", "Hala Stulecia"]
            },
            { 
                name: "Poznań", 
                icon: "🐐", 
                description: "Koziołki i rogale - stolica Wielkopolski",
                price: "40zł",
                duration: "2h 15min",
                rating: "4.5",
                features: ["Ratusz", "Koziołki", "Stary Rynek"]
            },
            { 
                name: "Łódź", 
                icon: "🎬", 
                description: "Filmowa stolica - miasto kultury i sztuki",
                price: "38zł",
                duration: "1h 45min",
                rating: "4.4",
                features: ["Piotrkowska", "EC1", "Manufaktura"]
            }
        ];

        // Sample tickets data
        const ticketsData = [
            {
                id: 1,
                from: "Warszawa",
                to: "Kraków",
                price: 45,
                duration: "3h 30min",
                departure: "08:30",
                arrival: "12:00",
                type: "Pociąg",
                rating: 4.8,
                company: "PKP Intercity"
            },
            {
                id: 2,
                from: "Warszawa",
                to: "Kraków",
                price: 35,
                duration: "4h 15min",
                departure: "10:00",
                arrival: "14:15",
                type: "Autobus",
                rating: 4.5,
                company: "FlixBus"
            },
            {
                id: 3,
                from: "Warszawa",
                to: "Kraków",
                price: 120,
                duration: "1h 15min",
                departure: "14:30",
                arrival: "15:45",
                type: "Samolot",
                rating: 4.9,
                company: "LOT"
            }
        ];

        // Three.js 3D Label
        let scene, camera, renderer, label, backLabel;
        let isRotating = false;
        let lastMouseX = 0, lastMouseY = 0;
        let rotationX = 0, rotationY = 0;
        let currentTicketData = null;
        
        function init3DLabel() {
            const canvas = document.getElementById('ticket-canvas');
            
            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(75, 500/400, 0.1, 1000);
            renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true });
            renderer.setSize(500, 400);
            renderer.setClearColor(0x000000, 0);
            
            // Create label geometry - flat plane
            const labelGeometry = new THREE.PlaneGeometry(10, 4);
            
            // Create texture with logo and text
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
            
            // Add inner border
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.3)';
            ctx.lineWidth = 2;
            ctx.strokeRect(8, 8, 624, 240);
            
            // Add logo (rocket emoji as text)
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
            
            // Add decorative elements
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.2)';
            ctx.lineWidth = 1;
            for (let i = 0; i < 5; i++) {
                ctx.beginPath();
                ctx.moveTo(50 + i * 20, 20);
                ctx.lineTo(50 + i * 20, 236);
                ctx.stroke();
            }
            
            const texture = new THREE.CanvasTexture(canvas2d);
            const labelMaterial = new THREE.MeshPhongMaterial({ 
                map: texture,
                transparent: true,
                shininess: 100
            });
            
            label = new THREE.Mesh(labelGeometry, labelMaterial);
            scene.add(label);
            
            // Create back label (initially hidden)
            const backLabelGeometry = new THREE.PlaneGeometry(10, 4);
            const backLabelMaterial = new THREE.MeshPhongMaterial({ 
                color: 0x1a1a1a,
                transparent: true,
                opacity: 0
            });
            
            backLabel = new THREE.Mesh(backLabelGeometry, backLabelMaterial);
            backLabel.rotation.y = Math.PI; // Rotate 180 degrees
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
            
            // Limit rotation
            rotationX = Math.max(-Math.PI/2, Math.min(Math.PI/2, rotationX));
            
            label.rotation.set(rotationX, rotationY, 0);
            
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

        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const numParticles = 20;

            for (let i = 0; i < numParticles; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (Math.random() * 4 + 6) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        function initLiveClock() {
            function updateClock() {
                const now = new Date();
                const time = now.toLocaleTimeString('pl-PL');
                const date = now.toLocaleDateString('pl-PL', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                const clockTime = document.getElementById('clock-time');
                const clockDate = document.getElementById('clock-date');

                if (clockTime) clockTime.textContent = time;
                if (clockDate) clockDate.textContent = date;
            }

            updateClock();
            setInterval(updateClock, 1000);
        }

        function initWeatherWidget() {
            const weatherWidget = document.getElementById('weather-widget');
            const weatherLocation = document.getElementById('weather-location');
            
            if (weatherWidget) {
                // Show loading state
                weatherLocation.textContent = 'Pobieranie lokalizacji...';
                
                // Get user's location and weather ONCE
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            console.log('User location:', position.coords.latitude, position.coords.longitude);
                            getWeatherData(position.coords.latitude, position.coords.longitude);
                        },
                        function(error) {
                            console.log('Geolocation error:', error);
                            weatherLocation.textContent = 'Lokalizacja niedostępna - Warszawa';
                            // Fallback to Warsaw weather
                            getWeatherData(52.2297, 21.0122);
                        }
                    );
                } else {
                    console.log('Geolocation not supported');
                    weatherLocation.textContent = 'Lokalizacja niedostępna - Warszawa';
                    // Fallback to Warsaw weather
                    getWeatherData(52.2297, 21.0122);
                }
            }
        }

        async function getWeatherData(lat, lon) {
            try {
                // Using OpenWeatherMap API (free tier)
                const API_KEY = 'demo'; // You can get a free API key from openweathermap.org
                const response = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${API_KEY}&units=metric&lang=pl`);
                
                if (!response.ok) {
                    throw new Error('Weather API error');
                }
                
                const data = await response.json();
                updateWeatherDisplay(data);
            } catch (error) {
                console.log('Weather API error, using fallback:', error);
                // Fallback to static Warsaw weather
                const fallbackWeather = { 
                    icon: '🌤️', 
                    desc: 'Częściowo słonecznie', 
                    temp: '22°C', 
                    city: 'Warszawa' 
                };
                updateWeatherDisplay(fallbackWeather, true);
            }
        }

        function updateWeatherDisplay(data, isFallback = false) {
            const weatherWidget = document.getElementById('weather-widget');
            const weatherLocation = document.getElementById('weather-location');
            
            if (isFallback) {
                // Fallback data
                weatherWidget.querySelector('.weather-icon').textContent = data.icon;
                weatherWidget.querySelector('.weather-temp').textContent = data.temp;
                weatherWidget.querySelector('.weather-desc').textContent = data.desc;
                weatherLocation.textContent = data.city;
            } else {
                // Real API data
                const icon = getWeatherIcon(data.weather[0].main, data.weather[0].description);
                const temp = Math.round(data.main.temp);
                const desc = data.weather[0].description;
                const city = data.name;
                
                weatherWidget.querySelector('.weather-icon').textContent = icon;
                weatherWidget.querySelector('.weather-temp').textContent = `${temp}°C`;
                weatherWidget.querySelector('.weather-desc').textContent = desc;
                weatherLocation.textContent = city;
            }
        }

        function getWeatherIcon(main, description) {
            const iconMap = {
                'Clear': '☀️',
                'Clouds': '⛅',
                'Rain': '🌧️',
                'Drizzle': '🌦️',
                'Thunderstorm': '⛈️',
                'Snow': '❄️',
                'Mist': '🌫️',
                'Fog': '🌫️',
                'Haze': '🌫️'
            };
            
            return iconMap[main] || '🌤️';
        }

        function initSearchSuggestions() {
            const fromInput = document.getElementById('from-city');
            const toInput = document.getElementById('to-city');
            const suggestions = document.getElementById('search-suggestions');
            
            function showSuggestions(input) {
                suggestions.style.display = 'block';
                suggestions.classList.add('show');
            }
            
            function hideSuggestions() {
                suggestions.classList.remove('show');
                setTimeout(() => {
                    suggestions.style.display = 'none';
                }, 300);
            }
            
            if (fromInput) {
                fromInput.addEventListener('focus', () => showSuggestions(fromInput));
                fromInput.addEventListener('blur', () => setTimeout(hideSuggestions, 200));
            }
            
            if (toInput) {
                toInput.addEventListener('focus', () => showSuggestions(toInput));
                toInput.addEventListener('blur', () => setTimeout(hideSuggestions, 200));
            }
        }

        function selectSuggestion(city) {
            const activeInput = document.activeElement;
            if (activeInput && (activeInput.id === 'from-city' || activeInput.id === 'to-city')) {
                activeInput.value = city;
                document.getElementById('search-suggestions').classList.remove('show');
            }
        }

        // Initialize everything
        document.addEventListener('DOMContentLoaded', async function() {
            createStars();
            createParticles();
            initLiveClock();
            initWeatherWidget();
            initSearchSuggestions();
            init3DLabel();
            populateCitySelects();
            populateCitiesGrid();
            populateTicketsGrid();
            
            // Close profile dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const profileDropdown = document.getElementById('profile-dropdown');
                const profileItem = document.querySelector('.profile-item');
                const settingsPanel = document.getElementById('settings-panel');
                
                if (profileDropdown && profileItem && 
                    !profileItem.contains(event.target) && 
                    !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.remove('show');
                }
                
                // Close settings panel when clicking outside
                if (settingsPanel && 
                    !settingsPanel.contains(event.target) && 
                    !event.target.closest('.profile-menu-item[onclick="showSettings()"]')) {
                    settingsPanel.classList.remove('show');
                }
            });
            
            // Update UI based on login status
            await updateLoginUI();
            
            // Set default date to tomorrow
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const travelDateFrom = document.getElementById('travel-date-from');
            const travelDateTo = document.getElementById('travel-date-to');
            if (travelDateFrom) travelDateFrom.value = tomorrow.toISOString().split('T')[0];
            if (travelDateTo) travelDateTo.value = tomorrow.toISOString().split('T')[0];
        });

        function populateCitySelects() {
            const fromSelect = document.getElementById('from-city');
            const toSelect = document.getElementById('to-city');
            
            // Clear existing options
            fromSelect.innerHTML = '<option value="">Wybierz miasto</option>';
            toSelect.innerHTML = '<option value="">Wybierz miasto</option>';
            
            citiesData.forEach(city => {
                const option1 = new Option(city.name, city.name);
                const option2 = new Option(city.name, city.name);
                fromSelect.add(option1);
                toSelect.add(option2);
            });
        }

        function populateCitiesGrid() {
            const citiesGrid = document.getElementById('citiesGrid');
            
            citiesGrid.innerHTML = citiesData.map(city => `
                <div class="city-card" onclick="selectCity('${city.name}')">
                    <div class="city-header">
                        <div class="city-icon">${city.icon}</div>
                        <div class="city-rating">
                            <span class="rating-star">⭐</span>
                            <span class="rating-value">${city.rating}</span>
                </div>
            </div>
                    <div class="city-name">${city.name}</div>
                    <div class="city-description">${city.description}</div>
                    <div class="city-features">
                        ${city.features.map(feature => `<span class="feature-tag">${feature}</span>`).join('')}
        </div>
                    <div class="city-pricing">
                        <div class="price-info">
                            <span class="price-label">Od</span>
                            <span class="price-value">${city.price}</span>
                </div>
                        <div class="duration-info">
                            <span class="duration-icon">⏱️</span>
                            <span class="duration-value">${city.duration}</span>
            </div>
        </div>
                    <button class="check-button" onclick="event.stopPropagation(); checkCity('${city.name}')">
                        <span class="check-icon">🔍</span>
                        Sprawdź
                    </button>
                </div>
            `).join('');
        }

        function selectCity(cityName) {
            // Redirect to destination page
            const citySlug = cityName.toLowerCase()
                .replace('ą', 'a')
                .replace('ć', 'c')
                .replace('ę', 'e')
                .replace('ł', 'l')
                .replace('ń', 'n')
                .replace('ó', 'o')
                .replace('ś', 's')
                .replace('ź', 'z')
                .replace('ż', 'z')
                .replace(' ', '-');
            
            window.location.href = `/destinations/${citySlug}`;
        }

        function checkCity(cityName) {
            // Find city data
            const city = citiesData.find(c => c.name === cityName);
            if (!city) return;

            // Show city details in a modal or expand the card
            alert(`Sprawdzanie ${cityName}:\n\nCena: ${city.price}\nCzas: ${city.duration}\nOcena: ${city.rating}/5\n\nAtrakcje: ${city.features.join(', ')}`);
        }

        function showTicketForCity(cityName) {
            // Show ticket container
            document.getElementById('ticketContainer').style.display = 'block';
            
            // Update description
            const description = document.getElementById('ticketDescription');
            description.innerHTML = `
                <h3>🎫 Wybierz Destynację</h3>
                <p>Wybrano: <span class="highlight">${cityName}</span></p>
                <p>Wybierz miasto docelowe i datę podróży</p>
                <p>Obracaj bilet aby zobaczyć szczegóły!</p>
            `;
            description.classList.add('show-ticket');
        }

        function searchTrips(event) {
            event.preventDefault();
            const fromCity = document.getElementById('from-city').value;
            const toCity = document.getElementById('to-city').value;
            const date = document.getElementById('travel-date').value;
            
            if (fromCity && toCity && date) {
                // Show search results
                document.getElementById('searchResults').style.display = 'block';
                displayTickets(fromCity, toCity, date);
                
                // Show ticket with data
                showTicketWithData(fromCity, toCity, date);
                
                // Scroll to results
                document.getElementById('searchResults').scrollIntoView({ behavior: 'smooth' });
            } else {
                alert('Proszę wypełnić wszystkie pola');
            }
        }

        function displayTickets(fromCity, toCity, date) {
            const grid = document.getElementById('tickets-grid');
            
            // Filter tickets based on route
            const filteredTickets = ticketsData.filter(ticket => 
                ticket.from === fromCity && ticket.to === toCity
            );
            
            if (filteredTickets.length === 0) {
                grid.innerHTML = '<div style="color: white; text-align: center; grid-column: 1/-1; padding: 40px;">Brak dostępnych biletów na wybraną trasę</div>';
                return;
            }
            
            grid.innerHTML = filteredTickets.map(ticket => `
                <div class="ticket-card">
                    <div class="ticket-header">
                        <div class="ticket-route">${ticket.from} → ${ticket.to}</div>
                        <div class="ticket-price">${ticket.price}zł</div>
                </div>
                    <div class="ticket-details">
                        <div class="detail-item">
                            <span class="detail-icon">🚌</span>
                            <span>${ticket.type}</span>
            </div>
                        <div class="detail-item">
                            <span class="detail-icon">⏱️</span>
                            <span>${ticket.duration}</span>
        </div>
                        <div class="detail-item">
                            <span class="detail-icon">🕐</span>
                            <span>${ticket.departure} - ${ticket.arrival}</span>
                    </div>
                        <div class="detail-item">
                            <span class="detail-icon">⭐</span>
                            <span>${ticket.rating}/5</span>
                    </div>
                    </div>
                    <div style="margin: 15px 0; color: rgba(255,255,255,0.7); font-size: 14px;">
                        ${ticket.company}
                </div>
                    <button class="book-ticket-btn" onclick="bookTicket(${ticket.id})">
                        Zarezerwuj bilet
                    </button>
            </div>
            `).join('');
        }

        function filterTickets(filter) {
            // Update active filter
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Apply filter logic here
            console.log('Filtering by:', filter);
        }

        function bookTicket(ticketId) {
            alert(`Rezerwacja biletu #${ticketId} - Przekierowanie do płatności...`);
        }

        function showTicketWithData(fromCity, toCity, date) {
            // Find first available ticket for this route
            const ticket = ticketsData.find(t => t.from === fromCity && t.to === toCity) || ticketsData[0];
            
            // Create back texture with ticket data
            const canvas2d = document.createElement('canvas');
            canvas2d.width = 640;
            canvas2d.height = 256;
            const ctx = canvas2d.getContext('2d');
            
            // Background gradient
            const gradient = ctx.createLinearGradient(0, 0, 640, 256);
            gradient.addColorStop(0, '#1a1a1a');
            gradient.addColorStop(0.5, '#2a2a2a');
            gradient.addColorStop(1, '#1a1a1a');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, 640, 256);
            
            // Border
            ctx.strokeStyle = '#ff6b35';
            ctx.lineWidth = 4;
            ctx.strokeRect(2, 2, 636, 252);
            
            // Inner border
            ctx.strokeStyle = 'rgba(255, 107, 53, 0.3)';
            ctx.lineWidth = 2;
            ctx.strokeRect(8, 8, 624, 240);
            
            // Title
            ctx.fillStyle = '#ff6b35';
            ctx.font = 'bold 28px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('BILET PODRÓŻY', 320, 35);
            
            // Route with arrow
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 36px Arial';
            ctx.fillText(`${fromCity}`, 150, 75);
            
            // Arrow
            ctx.fillStyle = '#ff8e53';
            ctx.font = 'bold 24px Arial';
            ctx.fillText('→', 320, 75);
            
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 36px Arial';
            ctx.fillText(`${toCity}`, 450, 75);
            
            // Date
            ctx.fillStyle = '#ff8e53';
            ctx.font = 'bold 18px Arial';
            ctx.fillText(`Data podróży: ${date}`, 320, 105);
            
            // Ticket details in two columns
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 16px Arial';
            ctx.textAlign = 'left';
            
            // Left column
            const leftDetails = [
                `💰 Cena: ${ticket.price}zł`,
                `⏱️ Czas: ${ticket.duration}`,
                `🚌 Typ: ${ticket.type}`,
                `⭐ Ocena: ${ticket.rating}/5`
            ];
            
            let y = 140;
            leftDetails.forEach(detail => {
                ctx.fillText(detail, 50, y);
                y += 22;
            });
            
            // Right column
            const rightDetails = [
                `🕐 Odjazd: ${ticket.departure}`,
                `🕑 Przyjazd: ${ticket.arrival}`,
                `🏢 Firma: ${ticket.company}`,
                `🎫 ID: #${ticket.id}`
            ];
            
            y = 140;
            rightDetails.forEach(detail => {
                ctx.fillText(detail, 350, y);
                y += 22;
            });
            
            // QR Code with border
            ctx.fillStyle = '#333333';
            ctx.fillRect(520, 130, 90, 90);
            ctx.strokeStyle = '#ff6b35';
            ctx.lineWidth = 2;
            ctx.strokeRect(520, 130, 90, 90);
            
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 12px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('QR CODE', 565, 180);
            
            // Decorative lines
            ctx.strokeStyle = 'rgba(255, 107, 53, 0.3)';
            ctx.lineWidth = 1;
            for (let i = 0; i < 3; i++) {
                ctx.beginPath();
                ctx.moveTo(50, 120 + i * 2);
                ctx.lineTo(590, 120 + i * 2);
                ctx.stroke();
            }
            
            // Update back label texture
            const texture = new THREE.CanvasTexture(canvas2d);
            backLabel.material.map = texture;
            backLabel.material.opacity = 1;
            backLabel.material.needsUpdate = true;
            
            // Show ticket container
            document.getElementById('ticketContainer').style.display = 'block';
            
            // Update description
            const description = document.getElementById('ticketDescription');
            description.innerHTML = `
                <h3>🎫 Twój Bilet</h3>
                <p><span class="highlight">${fromCity} → ${toCity}</span></p>
                <p>Data: <span class="highlight">${date}</span></p>
                <p>Cena: <span class="highlight">${ticket.price}zł</span></p>
                <p>Czas: <span class="highlight">${ticket.duration}</span></p>
                <p>Obracaj bilet aby zobaczyć szczegóły!</p>
            `;
            description.classList.add('show-ticket');
            
            currentTicketData = { fromCity, toCity, date, ticket };
        }

        function showTicket() {
            alert('3D Etykieta GwiezdnePodróże - Przytrzymaj lewy przycisk i przeciągnij aby obracać!');
        }

        function showCities() {
            document.getElementById('cities-section').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }

        function showTickets() {
            document.getElementById('tickets-section').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }

        function showRoutes() {
            document.getElementById('routes-section').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }

        async function showProfile() {
            // Check if user is logged in
            const isLoggedIn = await checkLoginStatus();
            if (isLoggedIn) {
                showUserProfile();
            } else {
                // Redirect to login page
                window.location.href = '/login';
            }
        }

        function showFeature(feature) {
            alert(`Funkcja ${feature} - W trakcie rozwoju!`);
        }

        // Ticket types data
        const ticketTypesData = [
            {
                name: "Bilet Standardowy",
                icon: "🎫",
                description: "Podstawowy bilet na podróż",
                price: "od 35zł",
                features: ["Miejsce siedzące", "Bagaż podręczny", "WiFi"],
                color: "#ff6b35"
            },
            {
                name: "Bilet Premium",
                icon: "⭐",
                description: "Wygodny bilet z dodatkowymi udogodnieniami",
                price: "od 65zł",
                features: ["Więcej miejsca", "Posiłek", "Priorytetowa obsługa"],
                color: "#ff8e53"
            },
            {
                name: "Bilet Biznes",
                icon: "💼",
                description: "Najwyższy komfort podróży",
                price: "od 120zł",
                features: ["Szerokie fotele", "Gourmet menu", "Dedicated service"],
                color: "#ffa500"
            },
            {
                name: "Bilet Grupowy",
                icon: "👥",
                description: "Oszczędny wybór dla grup",
                price: "od 25zł/os",
                features: ["Zniżka grupowa", "Rezerwacja miejsc", "Elastyczność"],
                color: "#32cd32"
            },
            {
                name: "Bilet Młodzieżowy",
                icon: "🎓",
                description: "Specjalna oferta dla studentów",
                price: "od 20zł",
                features: ["50% zniżki", "Ważna legitymacja", "Elastyczne daty"],
                color: "#4169e1"
            },
            {
                name: "Bilet Senior",
                icon: "👴",
                description: "Przyjazny seniorom",
                price: "od 18zł",
                features: ["30% zniżki", "Pomoc w podróży", "Dodatkowe udogodnienia"],
                color: "#9370db"
            }
        ];

        // Helper functions
        async function checkLoginStatus() {
            try {
                const response = await fetch('/auth/status');
                const data = await response.json();
                return data.authenticated;
            } catch (error) {
                console.error('Error checking auth status:', error);
                return false;
            }
        }

        function showUserProfile() {
            // Show user profile dropdown
            const profileDropdown = document.getElementById('profile-dropdown');
            const profileItem = document.querySelector('.profile-item');
            
            if (profileDropdown && profileItem) {
                // Position dropdown relative to profile button
                const rect = profileItem.getBoundingClientRect();
                profileDropdown.style.top = (rect.bottom + 10) + 'px';
                profileDropdown.style.left = (rect.left - 200) + 'px'; // Position left edge under profile button
                
                profileDropdown.classList.toggle('show');
            }
        }

        async function logout() {
            try {
                // Call logout endpoint
                await fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                });
                
                // Hide profile dropdown
                const profileDropdown = document.getElementById('profile-dropdown');
                if (profileDropdown) {
                    profileDropdown.classList.remove('show');
                }
                
                // Update UI to show login/register buttons
                await updateLoginUI();
                
                // Redirect to home
                window.location.href = '/';
            } catch (error) {
                console.error('Logout error:', error);
                // Fallback - redirect to home
                window.location.href = '/';
            }
        }

        function calculateRoute() {
            const from = document.getElementById('route-from').value;
            const to = document.getElementById('route-to').value;
            const result = document.getElementById('route-result');
            
            if (!from || !to) {
                result.innerHTML = '<div class="route-error">Proszę wypełnić oba pola!</div>';
                return;
            }
            
            // Simulate route calculation
            const distance = Math.floor(Math.random() * 500) + 100;
            const duration = Math.floor(Math.random() * 4) + 1;
            const price = Math.floor(Math.random() * 100) + 50;
            
            result.innerHTML = `
                <div class="route-success">
                    <h3>🗺️ Trasa: ${from} → ${to}</h3>
                    <div class="route-details">
                        <div class="route-detail">
                            <span class="detail-icon">📏</span>
                            <span class="detail-label">Dystans:</span>
                            <span class="detail-value">${distance} km</span>
            </div>
                        <div class="route-detail">
                            <span class="detail-icon">⏱️</span>
                            <span class="detail-label">Czas:</span>
                            <span class="detail-value">${duration}h ${Math.floor(Math.random() * 60)}min</span>
        </div>
                        <div class="route-detail">
                            <span class="detail-icon">💰</span>
                            <span class="detail-label">Cena:</span>
                            <span class="detail-value">od ${price}zł</span>
        </div>
                    </div>
                    <button class="book-route-btn" onclick="bookRoute('${from}', '${to}')">
                        🎫 Zarezerwuj trasę
                    </button>
                </div>
            `;
        }

        function bookRoute(from, to) {
            alert(`Rezerwacja trasy ${from} → ${to} - Funkcja w trakcie rozwoju!`);
        }

        function populateTicketsGrid() {
            const ticketsGrid = document.getElementById('ticketsGrid');
            
            ticketsGrid.innerHTML = ticketTypesData.map(ticket => `
                <div class="ticket-type-card" style="border-color: ${ticket.color}">
                    <div class="ticket-header">
                        <div class="ticket-icon" style="color: ${ticket.color}">${ticket.icon}</div>
                        <div class="ticket-price" style="color: ${ticket.color}">${ticket.price}</div>
                        </div>
                    <div class="ticket-name">${ticket.name}</div>
                    <div class="ticket-description">${ticket.description}</div>
                    <div class="ticket-features">
                        ${ticket.features.map(feature => `<span class="ticket-feature">${feature}</span>`).join('')}
                    </div>
                    <button class="select-ticket-btn" style="background: ${ticket.color}" onclick="selectTicket('${ticket.name}')">
                        Wybierz
                    </button>
                </div>
            `).join('');
        }

        function selectTicket(ticketName) {
            alert(`Wybrano ${ticketName} - Funkcja w trakcie rozwoju!`);
        }

        async function updateLoginUI() {
            try {
                const response = await fetch('/auth/status');
                const data = await response.json();
                const authButtons = document.querySelector('.auth-buttons');
                const profileItem = document.querySelector('.profile-item');
                
                if (data.authenticated && data.user) {
                    // Hide login/register buttons
                    if (authButtons) {
                        authButtons.style.display = 'none';
                    }
                    // Show profile item
                    if (profileItem) {
                        profileItem.style.display = 'flex';
                    }
                    // Update user data in dropdown
                    updateUserData(data.user);
                } else {
                    // Show login/register buttons
                    if (authButtons) {
                        authButtons.style.display = 'flex';
                    }
                    // Hide profile item
                    if (profileItem) {
                        profileItem.style.display = 'none';
                    }
                }
            } catch (error) {
                console.error('Error updating login UI:', error);
            }
        }

        function updateUserData(user) {
            // Update profile name and email
            const profileName = document.querySelector('.profile-name');
            const profileEmail = document.querySelector('.profile-email');
            const profileAvatar = document.querySelector('.profile-avatar');
            
            if (profileName) profileName.textContent = user.name || 'Użytkownik';
            if (profileEmail) profileEmail.textContent = user.email || 'user@example.com';
            if (profileAvatar) profileAvatar.textContent = user.avatar || '👤';
        }

        // Profile menu functions
        function showSettings() {
            const settingsPanel = document.getElementById('settings-panel');
            const profileDropdown = document.getElementById('profile-dropdown');
            
            if (settingsPanel) {
                // Close profile dropdown
                if (profileDropdown) {
                    profileDropdown.classList.remove('show');
                }
                // Show settings panel
                settingsPanel.classList.add('show');
                // Load current user data
                loadUserSettings();
            }
        }

        function closeSettings() {
            const settingsPanel = document.getElementById('settings-panel');
            if (settingsPanel) {
                settingsPanel.classList.remove('show');
            }
        }

        function showMyTickets() {
            const ticketsPanel = document.getElementById('tickets-panel');
            const profileDropdown = document.getElementById('profile-dropdown');
            
            if (ticketsPanel) {
                // Close profile dropdown
                if (profileDropdown) {
                    profileDropdown.classList.remove('show');
                }
                // Show tickets panel
                ticketsPanel.classList.add('show');
                // Load tickets
                loadTickets('active');
            }
        }

        function closeTickets() {
            const ticketsPanel = document.getElementById('tickets-panel');
            if (ticketsPanel) {
                ticketsPanel.classList.remove('show');
            }
        }

        function showHistory() {
            const historyPanel = document.getElementById('history-panel');
            const profileDropdown = document.getElementById('profile-dropdown');
            
            if (historyPanel) {
                // Close profile dropdown
                if (profileDropdown) {
                    profileDropdown.classList.remove('show');
                }
                // Show history panel
                historyPanel.classList.add('show');
                // Load history
                loadHistory();
            }
        }

        function closeHistory() {
            const historyPanel = document.getElementById('history-panel');
            if (historyPanel) {
                historyPanel.classList.remove('show');
            }
        }

        function showHelp() {
            const helpPanel = document.getElementById('help-panel');
            const profileDropdown = document.getElementById('profile-dropdown');
            
            if (helpPanel) {
                // Close profile dropdown
                if (profileDropdown) {
                    profileDropdown.classList.remove('show');
                }
                // Show help panel
                helpPanel.classList.add('show');
            }
        }

        function closeHelp() {
            const helpPanel = document.getElementById('help-panel');
            if (helpPanel) {
                helpPanel.classList.remove('show');
            }
        }

        function loadUserSettings() {
            // Load current user data into settings form
            fetch('/auth/status')
                .then(response => response.json())
                .then(data => {
                    if (data.authenticated && data.user) {
                        const nameInput = document.getElementById('settings-name');
                        const emailInput = document.getElementById('settings-email');
                        const avatarSelect = document.getElementById('settings-avatar');
                        
                        if (nameInput) nameInput.value = data.user.name || '';
                        if (emailInput) emailInput.value = data.user.email || '';
                        if (avatarSelect) avatarSelect.value = data.user.avatar || '👤';
                    }
                })
                .catch(error => console.error('Error loading user settings:', error));
        }

        function saveSettings() {
            const name = document.getElementById('settings-name').value;
            const email = document.getElementById('settings-email').value;
            const avatar = document.getElementById('settings-avatar').value;
            
            // Here you would normally save to server
            // For now, just update the UI
            const profileName = document.querySelector('.profile-name');
            const profileEmail = document.querySelector('.profile-email');
            const profileAvatar = document.querySelector('.profile-avatar');
            
            if (profileName) profileName.textContent = name;
            if (profileEmail) profileEmail.textContent = email;
            if (profileAvatar) profileAvatar.textContent = avatar;
            
            alert('Ustawienia zostały zapisane!');
            closeSettings();
        }

        // Avatar upload functions
        function handleAvatarUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const avatarImage = document.getElementById('avatar-image');
                    const avatarEmoji = document.getElementById('avatar-emoji');
                    
                    avatarImage.src = e.target.result;
                    avatarImage.style.display = 'block';
                    avatarEmoji.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        }

        function updateAvatarEmoji(emoji) {
            const avatarImage = document.getElementById('avatar-image');
            const avatarEmoji = document.getElementById('avatar-emoji');
            
            avatarImage.style.display = 'none';
            avatarEmoji.style.display = 'block';
            avatarEmoji.textContent = emoji;
        }

        // Tickets system
        function loadTickets(filter = 'active') {
            const ticketsList = document.getElementById('tickets-list');
            if (!ticketsList) return;

            // Sample tickets data
            const sampleTickets = [
                {
                    id: 1,
                    route: 'Warszawa → Kraków',
                    date: '2025-10-19',
                    time: '08:30',
                    price: '45zł',
                    type: 'Standard',
                    status: 'active',
                    qrCode: 'QR123456'
                },
                {
                    id: 2,
                    route: 'Kraków → Gdańsk',
                    date: '2025-10-25',
                    time: '14:15',
                    price: '55zł',
                    type: 'Premium',
                    status: 'active',
                    qrCode: 'QR789012'
                },
                {
                    id: 3,
                    route: 'Gdańsk → Wrocław',
                    date: '2025-09-15',
                    time: '10:00',
                    price: '50zł',
                    type: 'Standard',
                    status: 'expired',
                    qrCode: 'QR345678'
                }
            ];

            const filteredTickets = sampleTickets.filter(ticket => ticket.status === filter);
            
            if (filteredTickets.length === 0) {
                ticketsList.innerHTML = '<div class="no-tickets">Brak biletów do wyświetlenia</div>';
                return;
            }

            ticketsList.innerHTML = filteredTickets.map(ticket => `
                <div class="ticket-item">
                    <div class="ticket-header">
                        <div class="ticket-route">${ticket.route}</div>
                        <div class="ticket-status ${ticket.status}">${ticket.status === 'active' ? 'Aktywny' : 'Wygasły'}</div>
                    </div>
                    <div class="ticket-details">
                        <div class="ticket-detail">
                            <div class="ticket-detail-label">Data</div>
                            <div class="ticket-detail-value">${ticket.date}</div>
                    </div>
                        <div class="ticket-detail">
                            <div class="ticket-detail-label">Godzina</div>
                            <div class="ticket-detail-value">${ticket.time}</div>
                    </div>
                        <div class="ticket-detail">
                            <div class="ticket-detail-label">Cena</div>
                            <div class="ticket-detail-value">${ticket.price}</div>
                </div>
                        <div class="ticket-detail">
                            <div class="ticket-detail-label">Typ</div>
                            <div class="ticket-detail-value">${ticket.type}</div>
            </div>
                </div>
                    <div class="ticket-actions">
                        <button class="ticket-btn primary" onclick="showQRCode('${ticket.qrCode}')">Pokaż QR</button>
                        ${ticket.status === 'active' ? '<button class="ticket-btn secondary" onclick="cancelTicket(' + ticket.id + ')">Anuluj</button>' : ''}
            </div>
        </div>
            `).join('');
        }

        function filterTickets(filter) {
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Load filtered tickets
            loadTickets(filter);
        }

        function loadHistory() {
            const historyList = document.getElementById('history-list');
            if (!historyList) return;

            // Sample history data
            const sampleHistory = [
                {
                    id: 1,
                    route: 'Warszawa → Kraków',
                    date: '2025-09-10',
                    time: '08:30',
                    price: '45zł',
                    type: 'Standard',
                    status: 'completed'
                },
                {
                    id: 2,
                    route: 'Kraków → Gdańsk',
                    date: '2025-08-25',
                    time: '14:15',
                    price: '55zł',
                    type: 'Premium',
                    status: 'completed'
                },
                {
                    id: 3,
                    route: 'Gdańsk → Wrocław',
                    date: '2025-07-15',
                    time: '10:00',
                    price: '50zł',
                    type: 'Standard',
                    status: 'completed'
                }
            ];

            historyList.innerHTML = sampleHistory.map(ticket => `
                <div class="ticket-item">
                    <div class="ticket-header">
                        <div class="ticket-route">${ticket.route}</div>
                        <div class="ticket-status completed">Zakończona</div>
        </div>
                    <div class="ticket-details">
                        <div class="ticket-detail">
                            <div class="ticket-detail-label">Data</div>
                            <div class="ticket-detail-value">${ticket.date}</div>
    </div>
                        <div class="ticket-detail">
                            <div class="ticket-detail-label">Godzina</div>
                            <div class="ticket-detail-value">${ticket.time}</div>
                        </div>
                        <div class="ticket-detail">
                            <div class="ticket-detail-label">Cena</div>
                            <div class="ticket-detail-value">${ticket.price}</div>
                        </div>
                        <div class="ticket-detail">
                            <div class="ticket-detail-label">Typ</div>
                            <div class="ticket-detail-value">${ticket.type}</div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function showQRCode(qrCode) {
            alert(`QR Kod: ${qrCode}\n\nPokaż ten kod przy wejściu do pociągu.`);
        }

        function cancelTicket(ticketId) {
            if (confirm('Czy na pewno chcesz anulować ten bilet?')) {
                alert('Bilet został anulowany!');
                loadTickets('active'); // Reload tickets
            }
        }

        function changeLanguage(lang) {
            const translations = {
                pl: {
                    title: "PODRÓŻUJ W PRZYSZŁOŚĆ",
                    subtitle: "Odkryj magię Polski przez holograficzne podróże"
                },
                en: {
                    title: "TRAVEL TO THE FUTURE",
                    subtitle: "Discover Poland's magic through holographic journeys"
                },
                de: {
                    title: "REISE IN DIE ZUKUNFT",
                    subtitle: "Entdecken Sie Polens Magie durch holographische Reisen"
                }
            };
            
            document.querySelector('.hero-title').textContent = translations[lang].title;
            document.querySelector('.hero-subtitle').textContent = translations[lang].subtitle;
        }

        // Complete translation function
        function changeLanguageComplete(lang) {
            const translations = {
                'pl': {
                    home: 'Strona główna', cities: 'Miasta', tickets: 'Bilety', routes: 'Trasy', profile: 'Profil',
                    login: 'Zaloguj', register: 'Zarejestruj', title: 'PODRÓŻUJ W PRZYSZŁOŚĆ',
                    subtitle: 'Odkryj magię Polski przez holograficzne podróże', from: 'Skąd', to: 'Dokąd',
                    date: 'Data', fromDate: 'Od:', toDate: 'Do:', searchButton: 'ROZPOCZNIJ PODRÓŻ',
                    chooseCity: 'Wybierz miasto', popularCities: 'Popularne Miasta', ticketTypes: 'Rodzaje Biletów',
                    routeCalculator: 'Kalkulator Tras', standard: 'Standard', standardDesc: 'Komfortowa podróż w podstawowej klasie.',
                    standardPrice: 'od 30zł', choose: 'Wybierz', premium: 'Premium', premiumDesc: 'Dodatkowe udogodnienia i więcej miejsca.',
                    premiumPrice: 'od 60zł', vip: 'VIP', vipDesc: 'Luksusowa podróż z pełnym pakietem usług.',
                    vipPrice: 'od 120zł', calculateRoute: 'Oblicz trasę', selectCities: 'Wybierz miasta, aby obliczyć szacowany czas i koszt podróży.',
                    footerTitle: '🚀 GwiezdnePodróże', footerDesc: 'Przyszłość podróży już dziś. Odkryj Polskę w nowym wymiarze.',
                    tickets: 'Bilety', buyTicket: 'Kup bilet', myTickets: 'Moje bilety', travelHistory: 'Historia podróży',
                    cancelTicket: 'Anuluj bilet', destinations: 'Destynacje', help: 'Pomoc', faq: 'FAQ', contact: 'Kontakt',
                    terms: 'Regulamin', privacy: 'Polityka prywatności', app: 'Aplikacja', downloadOn: 'Pobierz na',
                    appStore: 'App Store', googlePlay: 'Google Play', copyright: '© 2025 GwiezdnePodróże. Wszystkie prawa zastrzeżone.',
                    poweredBy: '⚡ Powered by AI', nextGen: '🚀 Next-Gen Tech', ecoFriendly: '🌍 Eco-Friendly',
                    // Weather and time
                    weather: 'Pogoda', temperature: 'Temperatura', location: 'Lokalizacja', time: 'Czas', date: 'Data',
                    // Cities descriptions
                    warsawDesc: 'Stolica Polski - nowoczesna metropolia z bogatą historią',
                    krakowDesc: 'Królewskie miasto - perła polskiej architektury',
                    gdanskDesc: 'Nadmorska perła - miasto bursztynu i historii',
                    wroclawDesc: 'Miasto krasnali - wrocławska magia',
                    poznanDesc: 'Miasto targów i koziołków',
                    szczecinDesc: 'Portowe miasto z pięknymi bulwarami',
                    lublinDesc: 'Kulturalna stolica wschodniej Polski',
                    katowiceDesc: 'Miasto muzyki i przemysłu'
                },
                'en': {
                    home: 'Home', cities: 'Cities', tickets: 'Tickets', routes: 'Routes', profile: 'Profile',
                    login: 'Login', register: 'Register', title: 'TRAVEL TO THE FUTURE',
                    subtitle: 'Discover the magic of Poland through holographic journeys', from: 'From', to: 'To',
                    date: 'Date', fromDate: 'From:', toDate: 'To:', searchButton: 'START JOURNEY',
                    chooseCity: 'Choose city', popularCities: 'Popular Cities', ticketTypes: 'Ticket Types',
                    routeCalculator: 'Route Calculator', standard: 'Standard', standardDesc: 'Comfortable journey in basic class.',
                    standardPrice: 'from 30zł', choose: 'Choose', premium: 'Premium', premiumDesc: 'Additional amenities and more space.',
                    premiumPrice: 'from 60zł', vip: 'VIP', vipDesc: 'Luxury journey with full service package.',
                    vipPrice: 'from 120zł', calculateRoute: 'Calculate route', selectCities: 'Select cities to calculate estimated time and travel cost.',
                    footerTitle: '🚀 StarTravel', footerDesc: 'The future of travel today. Discover Poland in a new dimension.',
                    tickets: 'Tickets', buyTicket: 'Buy ticket', myTickets: 'My tickets', travelHistory: 'Travel history',
                    cancelTicket: 'Cancel ticket', destinations: 'Destinations', help: 'Help', faq: 'FAQ', contact: 'Contact',
                    terms: 'Terms', privacy: 'Privacy policy', app: 'App', downloadOn: 'Download on',
                    appStore: 'App Store', googlePlay: 'Google Play', copyright: '© 2025 StarTravel. All rights reserved.',
                    poweredBy: '⚡ Powered by AI', nextGen: '🚀 Next-Gen Tech', ecoFriendly: '🌍 Eco-Friendly',
                    // Weather and time
                    weather: 'Weather', temperature: 'Temperature', location: 'Location', time: 'Time', date: 'Date',
                    // Cities descriptions
                    warsawDesc: 'Capital of Poland - modern metropolis with rich history',
                    krakowDesc: 'Royal city - pearl of Polish architecture',
                    gdanskDesc: 'Seaside pearl - city of amber and history',
                    wroclawDesc: 'City of gnomes - Wrocław magic',
                    poznanDesc: 'City of fairs and goats',
                    szczecinDesc: 'Port city with beautiful boulevards',
                    lublinDesc: 'Cultural capital of eastern Poland',
                    katowiceDesc: 'City of music and industry'
                },
                'de': {
                    home: 'Startseite', cities: 'Städte', tickets: 'Tickets', routes: 'Routen', profile: 'Profil',
                    login: 'Anmelden', register: 'Registrieren', title: 'REISE IN DIE ZUKUNFT',
                    subtitle: 'Entdecke die Magie Polens durch holographische Reisen', from: 'Von', to: 'Nach',
                    date: 'Datum', fromDate: 'Von:', toDate: 'Bis:', searchButton: 'REISE STARTEN',
                    chooseCity: 'Stadt wählen', popularCities: 'Beliebte Städte', ticketTypes: 'Ticketarten',
                    routeCalculator: 'Routenrechner', standard: 'Standard', standardDesc: 'Komfortable Reise in der Grundklasse.',
                    standardPrice: 'ab 30zł', choose: 'Wählen', premium: 'Premium', premiumDesc: 'Zusätzliche Annehmlichkeiten und mehr Platz.',
                    premiumPrice: 'ab 60zł', vip: 'VIP', vipDesc: 'Luxusreise mit vollem Servicepaket.',
                    vipPrice: 'ab 120zł', calculateRoute: 'Route berechnen', selectCities: 'Wählen Sie Städte aus, um geschätzte Zeit und Reisekosten zu berechnen.',
                    footerTitle: '🚀 SternenReisen', footerDesc: 'Die Zukunft des Reisens heute. Entdecken Sie Polen in einer neuen Dimension.',
                    tickets: 'Tickets', buyTicket: 'Ticket kaufen', myTickets: 'Meine Tickets', travelHistory: 'Reiseverlauf',
                    cancelTicket: 'Ticket stornieren', destinations: 'Reiseziele', help: 'Hilfe', faq: 'FAQ', contact: 'Kontakt',
                    terms: 'AGB', privacy: 'Datenschutz', app: 'App', downloadOn: 'Herunterladen auf',
                    appStore: 'App Store', googlePlay: 'Google Play', copyright: '© 2025 SternenReisen. Alle Rechte vorbehalten.',
                    poweredBy: '⚡ Powered by AI', nextGen: '🚀 Next-Gen Tech', ecoFriendly: '🌍 Eco-Friendly',
                    // Weather and time
                    weather: 'Wetter', temperature: 'Temperatur', location: 'Standort', time: 'Zeit', date: 'Datum',
                    // Cities descriptions
                    warsawDesc: 'Hauptstadt Polens - moderne Metropole mit reicher Geschichte',
                    krakowDesc: 'Königliche Stadt - Perle der polnischen Architektur',
                    gdanskDesc: 'Seaside Perle - Stadt des Bernsteins und der Geschichte',
                    wroclawDesc: 'Stadt der Zwerge - Wrocław Magie',
                    poznanDesc: 'Stadt der Messen und Ziegen',
                    szczecinDesc: 'Hafenstadt mit schönen Boulevards',
                    lublinDesc: 'Kulturhauptstadt Ostpolens',
                    katowiceDesc: 'Stadt der Musik und Industrie'
                },
                'fr': {
                    home: 'Accueil', cities: 'Villes', tickets: 'Billets', routes: 'Itinéraires', profile: 'Profil',
                    login: 'Connexion', register: 'S\'inscrire', title: 'VOYAGEZ VERS LE FUTUR',
                    subtitle: 'Découvrez la magie de la Pologne à travers des voyages holographiques', from: 'De', to: 'Vers',
                    date: 'Date', fromDate: 'Du:', toDate: 'Au:', searchButton: 'COMMENCER LE VOYAGE',
                    chooseCity: 'Choisir une ville', popularCities: 'Villes Populaires', ticketTypes: 'Types de Billets',
                    routeCalculator: 'Calculateur d\'Itinéraires', standard: 'Standard', standardDesc: 'Voyage confortable en classe de base.',
                    standardPrice: 'à partir de 30zł', choose: 'Choisir', premium: 'Premium', premiumDesc: 'Aménagements supplémentaires et plus d\'espace.',
                    premiumPrice: 'à partir de 60zł', vip: 'VIP', vipDesc: 'Voyage de luxe avec package de service complet.',
                    vipPrice: 'à partir de 120zł', calculateRoute: 'Calculer l\'itinéraire', selectCities: 'Sélectionnez les villes pour calculer le temps estimé et le coût du voyage.',
                    footerTitle: '🚀 VoyagesStellaires', footerDesc: 'L\'avenir du voyage aujourd\'hui. Découvrez la Pologne dans une nouvelle dimension.',
                    tickets: 'Billets', buyTicket: 'Acheter un billet', myTickets: 'Mes billets', travelHistory: 'Historique des voyages',
                    cancelTicket: 'Annuler le billet', destinations: 'Destinations', help: 'Aide', faq: 'FAQ', contact: 'Contact',
                    terms: 'Conditions', privacy: 'Politique de confidentialité', app: 'App', downloadOn: 'Télécharger sur',
                    appStore: 'App Store', googlePlay: 'Google Play', copyright: '© 2025 VoyagesStellaires. Tous droits réservés.',
                    poweredBy: '⚡ Powered by AI', nextGen: '🚀 Next-Gen Tech', ecoFriendly: '🌍 Eco-Friendly',
                    // Weather and time
                    weather: 'Météo', temperature: 'Température', location: 'Localisation', time: 'Heure', date: 'Date',
                    // Cities descriptions
                    warsawDesc: 'Capitale de la Pologne - métropole moderne avec une riche histoire',
                    krakowDesc: 'Ville royale - perle de l\'architecture polonaise',
                    gdanskDesc: 'Perle de la mer - ville de l\'ambre et de l\'histoire',
                    wroclawDesc: 'Ville des nains - magie de Wrocław',
                    poznanDesc: 'Ville des foires et des chèvres',
                    szczecinDesc: 'Ville portuaire avec de beaux boulevards',
                    lublinDesc: 'Capitale culturelle de l\'est de la Pologne',
                    katowiceDesc: 'Ville de la musique et de l\'industrie'
                },
                'es': {
                    home: 'Inicio', cities: 'Ciudades', tickets: 'Billetes', routes: 'Rutas', profile: 'Perfil',
                    login: 'Iniciar sesión', register: 'Registrarse', title: 'VIAJA AL FUTURO',
                    subtitle: 'Descubre la magia de Polonia a través de viajes holográficos', from: 'Desde', to: 'Hasta',
                    date: 'Fecha', fromDate: 'Desde:', toDate: 'Hasta:', searchButton: 'INICIAR VIAJE',
                    chooseCity: 'Elegir ciudad', popularCities: 'Ciudades Populares', ticketTypes: 'Tipos de Billetes',
                    routeCalculator: 'Calculadora de Rutas', standard: 'Estándar', standardDesc: 'Viaje cómodo en clase básica.',
                    standardPrice: 'desde 30zł', choose: 'Elegir', premium: 'Premium', premiumDesc: 'Comodidades adicionales y más espacio.',
                    premiumPrice: 'desde 60zł', vip: 'VIP', vipDesc: 'Viaje de lujo con paquete de servicio completo.',
                    vipPrice: 'desde 120zł', calculateRoute: 'Calcular ruta', selectCities: 'Selecciona ciudades para calcular el tiempo estimado y el costo del viaje.',
                    footerTitle: '🚀 ViajesEstelares', footerDesc: 'El futuro de los viajes hoy. Descubre Polonia en una nueva dimensión.',
                    tickets: 'Billetes', buyTicket: 'Comprar billete', myTickets: 'Mis billetes', travelHistory: 'Historial de viajes',
                    cancelTicket: 'Cancelar billete', destinations: 'Destinos', help: 'Ayuda', faq: 'FAQ', contact: 'Contacto',
                    terms: 'Términos', privacy: 'Política de privacidad', app: 'App', downloadOn: 'Descargar en',
                    appStore: 'App Store', googlePlay: 'Google Play', copyright: '© 2025 ViajesEstelares. Todos los derechos reservados.',
                    poweredBy: '⚡ Powered by AI', nextGen: '🚀 Next-Gen Tech', ecoFriendly: '🌍 Eco-Friendly',
                    // Weather and time
                    weather: 'Tiempo', temperature: 'Temperatura', location: 'Ubicación', time: 'Hora', date: 'Fecha',
                    // Cities descriptions
                    warsawDesc: 'Capital de Polonia - metrópoli moderna con rica historia',
                    krakowDesc: 'Ciudad real - perla de la arquitectura polaca',
                    gdanskDesc: 'Perla del mar - ciudad del ámbar y la historia',
                    wroclawDesc: 'Ciudad de los enanos - magia de Wrocław',
                    poznanDesc: 'Ciudad de ferias y cabras',
                    szczecinDesc: 'Ciudad portuaria con hermosos bulevares',
                    lublinDesc: 'Capital cultural del este de Polonia',
                    katowiceDesc: 'Ciudad de la música y la industria'
                },
                'it': {
                    home: 'Home', cities: 'Città', tickets: 'Biglietti', routes: 'Percorsi', profile: 'Profilo',
                    login: 'Accedi', register: 'Registrati', title: 'VIAGGIA NEL FUTURO',
                    subtitle: 'Scopri la magia della Polonia attraverso viaggi olografici', from: 'Da', to: 'A',
                    date: 'Data', fromDate: 'Dal:', toDate: 'Al:', searchButton: 'INIZIA VIAGGIO',
                    chooseCity: 'Scegli città', popularCities: 'Città Popolari', ticketTypes: 'Tipi di Biglietti',
                    routeCalculator: 'Calcolatore di Percorsi', standard: 'Standard', standardDesc: 'Viaggio confortevole in classe base.',
                    standardPrice: 'da 30zł', choose: 'Scegli', premium: 'Premium', premiumDesc: 'Comfort aggiuntivi e più spazio.',
                    premiumPrice: 'da 60zł', vip: 'VIP', vipDesc: 'Viaggio di lusso con pacchetto servizi completo.',
                    vipPrice: 'da 120zł', calculateRoute: 'Calcola percorso', selectCities: 'Seleziona città per calcolare tempo stimato e costo del viaggio.',
                    footerTitle: '🚀 ViaggiStellari', footerDesc: 'Il futuro dei viaggi oggi. Scopri la Polonia in una nuova dimensione.',
                    tickets: 'Biglietti', buyTicket: 'Compra biglietto', myTickets: 'I miei biglietti', travelHistory: 'Cronologia viaggi',
                    cancelTicket: 'Annulla biglietto', destinations: 'Destinazioni', help: 'Aiuto', faq: 'FAQ', contact: 'Contatto',
                    terms: 'Termini', privacy: 'Privacy', app: 'App', downloadOn: 'Scarica su',
                    appStore: 'App Store', googlePlay: 'Google Play', copyright: '© 2025 ViaggiStellari. Tutti i diritti riservati.',
                    poweredBy: '⚡ Powered by AI', nextGen: '🚀 Next-Gen Tech', ecoFriendly: '🌍 Eco-Friendly',
                    // Weather and time
                    weather: 'Tempo', temperature: 'Temperatura', location: 'Posizione', time: 'Ora', date: 'Data',
                    // Cities descriptions
                    warsawDesc: 'Capitale della Polonia - metropoli moderna con ricca storia',
                    krakowDesc: 'Città reale - perla dell\'architettura polacca',
                    gdanskDesc: 'Perla del mare - città dell\'ambra e della storia',
                    wroclawDesc: 'Città dei nani - magia di Wrocław',
                    poznanDesc: 'Città delle fiere e delle capre',
                    szczecinDesc: 'Città portuale con bei boulevard',
                    lublinDesc: 'Capitale culturale della Polonia orientale',
                    katowiceDesc: 'Città della musica e dell\'industria'
                }
            };

            const t = translations[lang] || translations['pl'];
            
            // Update all elements
            try {
                // Navigation
                const navItems = document.querySelectorAll('.nav-text');
                if (navItems[0]) navItems[0].textContent = t.home;
                if (navItems[1]) navItems[1].textContent = t.cities;
                if (navItems[2]) navItems[2].textContent = t.tickets;
                if (navItems[3]) navItems[3].textContent = t.routes;
                if (navItems[4]) navItems[4].textContent = t.profile;
                
                // Update navbar title
                const brandText = document.querySelector('.brand-text');
                if (brandText) brandText.textContent = t.footerTitle;
                
                // Update weather widget
                const weatherDesc = document.querySelector('.weather-desc');
                if (weatherDesc) weatherDesc.textContent = t.weather;
                
                // Update cities descriptions
                const cityCards = document.querySelectorAll('.city-card');
                cityCards.forEach((card, index) => {
                    const desc = card.querySelector('.city-description');
                    if (desc) {
                        const cityNames = ['warsaw', 'krakow', 'gdansk', 'wroclaw', 'poznan', 'szczecin', 'lublin', 'katowice'];
                        const cityKey = cityNames[index] + 'Desc';
                        if (t[cityKey]) {
                            desc.textContent = t[cityKey];
                        }
                    }
                });
                
                const authButtons = document.querySelectorAll('.auth-btn');
                if (authButtons[0]) authButtons[0].textContent = t.login;
                if (authButtons[1]) authButtons[1].textContent = t.register;
                
                // Main content
                const heroTitle = document.querySelector('.hero-title');
                if (heroTitle) heroTitle.textContent = t.title;
                const heroSubtitle = document.querySelector('.hero-subtitle');
                if (heroSubtitle) heroSubtitle.textContent = t.subtitle;
                
                // Form labels
                const formLabels = document.querySelectorAll('.form-label');
                if (formLabels[0]) formLabels[0].textContent = t.from;
                if (formLabels[1]) formLabels[1].textContent = t.to;
                if (formLabels[2]) formLabels[2].textContent = t.date;
                
                // Date labels
                const dateLabels = document.querySelectorAll('.date-label');
                if (dateLabels[0]) dateLabels[0].textContent = t.fromDate;
                if (dateLabels[1]) dateLabels[1].textContent = t.toDate;
                
                // Search button
                const searchButton = document.querySelector('.search-button');
                if (searchButton) searchButton.innerHTML = `<span>🚀</span> ${t.searchButton}`;
                
                // Select options
                const selects = document.querySelectorAll('.form-input');
                selects.forEach(select => {
                    if (select.tagName === 'SELECT') {
                        const firstOption = select.querySelector('option[value=""]');
                        if (firstOption) firstOption.textContent = t.chooseCity;
                    }
                });
                
                // Section titles
                const sectionTitles = document.querySelectorAll('.section-title');
                if (sectionTitles[0]) sectionTitles[0].textContent = t.popularCities;
                if (sectionTitles[1]) sectionTitles[1].textContent = t.ticketTypes;
                if (sectionTitles[2]) sectionTitles[2].textContent = t.routeCalculator;
                
                // Ticket types
                const ticketCards = document.querySelectorAll('.ticket-type-card');
                if (ticketCards[0]) {
                    const title = ticketCards[0].querySelector('.type-title');
                    const desc = ticketCards[0].querySelector('.type-description');
                    const price = ticketCards[0].querySelector('.type-price');
                    const button = ticketCards[0].querySelector('.type-button');
                    if (title) title.textContent = t.standard;
                    if (desc) desc.textContent = t.standardDesc;
                    if (price) price.textContent = t.standardPrice;
                    if (button) button.textContent = t.choose;
                }
                if (ticketCards[1]) {
                    const title = ticketCards[1].querySelector('.type-title');
                    const desc = ticketCards[1].querySelector('.type-description');
                    const price = ticketCards[1].querySelector('.type-price');
                    const button = ticketCards[1].querySelector('.type-button');
                    if (title) title.textContent = t.premium;
                    if (desc) desc.textContent = t.premiumDesc;
                    if (price) price.textContent = t.premiumPrice;
                    if (button) button.textContent = t.choose;
                }
                if (ticketCards[2]) {
                    const title = ticketCards[2].querySelector('.type-title');
                    const desc = ticketCards[2].querySelector('.type-description');
                    const price = ticketCards[2].querySelector('.type-price');
                    const button = ticketCards[2].querySelector('.type-button');
                    if (title) title.textContent = t.vip;
                    if (desc) desc.textContent = t.vipDesc;
                    if (price) price.textContent = t.vipPrice;
                    if (button) button.textContent = t.choose;
                }
                
                // Calculator
                const calcButton = document.querySelector('.calculator-form .search-button');
                if (calcButton) calcButton.textContent = t.calculateRoute;
                
                const calcText = document.querySelector('.calculator-results p');
                if (calcText) calcText.textContent = t.selectCities;
                
                // Footer
                const footerTitle = document.querySelector('.footer-title');
                if (footerTitle) footerTitle.textContent = t.footerTitle;
                
                const footerDesc = document.querySelector('.footer-desc');
                if (footerDesc) footerDesc.textContent = t.footerDesc;
                
                // Footer sections
                const footerSubtitles = document.querySelectorAll('.footer-subtitle');
                if (footerSubtitles[0]) footerSubtitles[0].textContent = t.tickets;
                if (footerSubtitles[1]) footerSubtitles[1].textContent = t.destinations;
                if (footerSubtitles[2]) footerSubtitles[2].textContent = t.help;
                if (footerSubtitles[3]) footerSubtitles[3].textContent = t.app;
                
                // Footer links
                const footerLinks = document.querySelectorAll('.footer-links a');
                if (footerLinks[0]) footerLinks[0].textContent = t.buyTicket;
                if (footerLinks[1]) footerLinks[1].textContent = t.myTickets;
                if (footerLinks[2]) footerLinks[2].textContent = t.travelHistory;
                if (footerLinks[3]) footerLinks[3].textContent = t.cancelTicket;
                if (footerLinks[4]) footerLinks[4].textContent = t.faq;
                if (footerLinks[5]) footerLinks[5].textContent = t.contact;
                if (footerLinks[6]) footerLinks[6].textContent = t.terms;
                if (footerLinks[7]) footerLinks[7].textContent = t.privacy;
                
                // Download buttons
                const downloadTitles = document.querySelectorAll('.download-title');
                if (downloadTitles[0]) downloadTitles[0].textContent = t.downloadOn;
                if (downloadTitles[1]) downloadTitles[1].textContent = t.downloadOn;
                
                const downloadSubtitles = document.querySelectorAll('.download-subtitle');
                if (downloadSubtitles[0]) downloadSubtitles[0].textContent = t.appStore;
                if (downloadSubtitles[1]) downloadSubtitles[1].textContent = t.googlePlay;
                
                // Copyright and tech info
                const copyright = document.querySelector('.footer-copyright');
                if (copyright) copyright.textContent = t.copyright;
                
                const techItems = document.querySelectorAll('.tech-item');
                if (techItems[0]) techItems[0].textContent = t.poweredBy;
                if (techItems[1]) techItems[1].textContent = t.nextGen;
                if (techItems[2]) techItems[2].textContent = t.ecoFriendly;
                
            } catch (error) {
                console.log('Translation error:', error);
            }
        }

        // Override the original function
        function changeLanguage(lang) {
            changeLanguageComplete(lang);
        }
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\ticket-book\resources\views/home.blade.php ENDPATH**/ ?>