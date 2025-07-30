<!DOCTYPE html>
<html lang="pl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $destination['description'] }} - Zarezerwuj wyjątkową wycieczkę do {{ $destination['name'] }} z PolskaTour.">
    <title>{{ $destination['name'] }} - PolskaTour | Odkryj Polskę jak nigdy wcześniej</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/app.js', 'resources/js/destinations.js'])
</head>
<body class="bg-black text-white antialiased">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300" id="navbar">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg blur opacity-75 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative bg-gradient-to-r from-blue-600 to-purple-600 p-2 rounded-lg">
                            <span class="text-white font-bold text-xl">🎫</span>
                        </div>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">PolskaTour</span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="/destinations" class="nav-link">Destynacje</a>
                    <a href="/attractions" class="nav-link">Atrakcje</a>
                    <a href="#about" class="nav-link">O nas</a>
                    <a href="#contact" class="nav-link">Kontakt</a>
                    <a href="/booking/{{ $destination['id'] }}" class="btn-primary">
                        Zarezerwuj teraz
                    </a>
                </div>

                <button class="md:hidden text-white" id="mobile-menu-btn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Background Image -->
    <section class="relative h-96 flex items-center justify-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ $destination['image'] }}"
                 alt="{{ $destination['name'] }}"
                 class="w-full h-full object-cover">
        </div>

        <!-- Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/30 to-purple-600/30"></div>
        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-white drop-shadow-lg">{{ $destination['name'] }}</h1>
            <p class="text-xl text-gray-200 mb-6 drop-shadow-md">{{ $destination['description'] }}</p>
            <div class="flex items-center justify-center space-x-6">
                <div class="flex items-center text-yellow-400 bg-black/30 rounded-lg px-3 py-1">
                    <span class="text-2xl">⭐</span>
                    <span class="ml-2 text-lg font-semibold">{{ $destination['rating'] }}</span>
                </div>
                <div class="text-blue-400 font-semibold bg-black/30 rounded-lg px-3 py-1">{{ $destination['duration'] }}</div>
                                <div class="text-green-400 font-bold text-2xl bg-black/40 backdrop-blur-sm rounded-xl px-6 py-3 border border-white/20">
                    <span class="text-3xl mr-2">💰</span><span id="hero-price">{{ $destination['price'] }} zł</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Breadcrumb -->
    <section class="py-4 bg-gray-900">
        <div class="container mx-auto px-6">
            <nav class="text-sm text-gray-400">
                <a href="/" class="hover:text-white">Strona główna</a>
                <span class="mx-2">/</span>
                <a href="/destinations" class="hover:text-white">Destynacje</a>
                <span class="mx-2">/</span>
                <span class="text-white">{{ $destination['name'] }}</span>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-900">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Left Column - Main Info -->
                <div class="lg:col-span-2">
                    <!-- Description -->
                    <div class="bg-gray-800 rounded-2xl p-8 mb-8">
                        <h2 class="text-3xl font-bold mb-6">O destynacji</h2>
                        <p class="text-gray-300 text-lg leading-relaxed mb-6">
                            {{ $destination['long_description'] ?? $destination['description'] }}
                        </p>

                        <!-- Features -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-xl font-semibold mb-4 text-blue-400">🎯 Główne atrakcje</h3>
                                <ul class="space-y-2">
                                    @if(isset($destination['highlights']) && is_array($destination['highlights']))
                                        @foreach($destination['highlights'] as $highlight)
                                        <li class="flex items-center text-gray-300">
                                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-3"></span>
                                            {{ $highlight }}
                                        </li>
                                        @endforeach
                                    @else
                                        <li class="text-gray-500">Brak dostępnych informacji</li>
                                    @endif
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-4 text-green-400">🎪 Aktywności</h3>
                                <ul class="space-y-2">
                                    @if(isset($destination['activities']) && is_array($destination['activities']))
                                        @foreach($destination['activities'] as $activity)
                                        <li class="flex items-center text-gray-300">
                                            <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                                            {{ $activity }}
                                        </li>
                                        @endforeach
                                    @else
                                        <li class="text-gray-500">Brak dostępnych informacji</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Image Gallery -->
                    <div class="bg-gray-800 rounded-2xl p-8 mb-8" id="gallery-section">
                        <h2 class="text-3xl font-bold mb-6">📸 Galeria zdjęć</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @php
                                $destinationSlug = strtolower(str_replace(['ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'],
                                                                           ['a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'],
                                                                           $destination['name']));
                                $destinationSlug = preg_replace('/[^a-z0-9\-]/', '', $destinationSlug);
                            @endphp

                            @for($i = 1; $i <= 4; $i++)
                                @php
                                    $imagePath = "/images/destinations/{$destinationSlug}-{$i}.jpg";
                                @endphp
                                @if(file_exists(public_path($imagePath)))
                                    <div class="group relative overflow-hidden rounded-lg cursor-pointer transform transition-all duration-300 hover:scale-105"
                                         onclick="openLightbox('{{ $imagePath }}', '{{ $destination['name'] }} - Zdjęcie {{ $i }}')">
                                        <img src="{{ $imagePath }}"
                                             alt="{{ $destination['name'] }} - Zdjęcie {{ $i }}"
                                             class="w-full h-32 object-cover rounded-lg transition-transform duration-300 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                            <span class="text-white text-2xl">🔍</span>
                                        </div>
                                    </div>
                                @endif
                            @endfor
                        </div>

                        <!-- Lightbox -->
                        <div id="lightbox" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4">
                            <div class="relative max-w-4xl max-h-full">
                                <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300 z-10">×</button>
                                <img id="lightbox-image" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
                                <p id="lightbox-caption" class="text-white text-center mt-4 text-lg"></p>
                            </div>
                        </div>
                    </div>

                    <!-- What's Included -->
                    <div class="bg-gray-800 rounded-2xl p-8 mb-8">
                        <h2 class="text-3xl font-bold mb-6">Co zawiera pakiet</h2>
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <h3 class="text-xl font-semibold mb-4 text-green-400 flex items-center">
                                    <span class="mr-2">✅</span> W cenie
                                </h3>
                                <ul class="space-y-2">
                                    @if(isset($destination['included']) && is_array($destination['included']))
                                        @foreach($destination['included'] as $item)
                                        <li class="text-gray-300">{{ $item }}</li>
                                        @endforeach
                                    @else
                                        <li class="text-gray-500">Informacje niedostępne</li>
                                    @endif
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-4 text-red-400 flex items-center">
                                    <span class="mr-2">❌</span> Nie zawiera
                                </h3>
                                <ul class="space-y-2">
                                    @if(isset($destination['not_included']) && is_array($destination['not_included']))
                                        @foreach($destination['not_included'] as $item)
                                        <li class="text-gray-300">{{ $item }}</li>
                                        @endforeach
                                    @else
                                        <li class="text-gray-500">Informacje niedostępne</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Booking -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-800 rounded-2xl p-8 sticky top-24">
                        <!-- Price -->
                        <div class="text-center mb-6">
                            <div class="text-lg text-gray-400 mb-2">Cena za osobę</div>
                            <div class="text-2xl font-bold text-gray-300 mb-2">{{ $destination['price'] }} zł</div>

                            <div class="border-t border-gray-600 pt-4 mt-4">
                                <div class="text-lg text-blue-400 mb-1">Całkowity koszt</div>
                                <div id="total-price" class="text-4xl font-bold text-white">{{ $destination['price'] }} zł</div>
                                <div id="price-breakdown" class="text-sm text-gray-400 mt-1">1 osoba × {{ $destination['price'] }} zł</div>
                            </div>

                            @if(isset($destination['original_price']))
                            <div class="text-gray-400 line-through mt-2">Poprzednia cena: {{ $destination['original_price'] }} zł/os</div>
                            @endif
                        </div>

                        <!-- Details -->
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                                <span class="text-gray-300">Czas trwania:</span>
                                <span class="font-semibold">{{ $destination['duration'] }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                                <span class="text-gray-300">Typ:</span>
                                <span class="font-semibold capitalize">{{ $destination['type'] }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                                <span class="text-gray-300">Poziom trudności:</span>
                                <span class="font-semibold capitalize">
                                    @switch($destination['difficulty'] ?? 'easy')
                                        @case('easy')
                                            Łatwy 🟢
                                            @break
                                        @case('medium')
                                            Średni 🟡
                                            @break
                                        @case('hard')
                                            Trudny 🔴
                                            @break
                                        @default
                                            Łatwy 🟢
                                    @endswitch
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-300">Sezon:</span>
                                <span class="font-semibold capitalize">
                                    @switch($destination['season'] ?? 'all')
                                        @case('all')
                                            Cały rok ❄️☀️
                                            @break
                                        @case('spring-autumn')
                                            Wiosna-Jesień 🌸🍂
                                            @break
                                        @case('summer')
                                            Lato ☀️
                                            @break
                                        @case('winter')
                                            Zima ❄️
                                            @break
                                        @default
                                            Cały rok ❄️☀️
                                    @endswitch
                                </span>
                            </div>
                        </div>

                        <!-- Booking Form -->
                        <form action="/booking/{{ $destination['id'] }}" method="GET" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Data wyjazdu</label>
                                <input type="date" name="date" class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-400 focus:outline-none" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Liczba osób</label>
                                <select id="travelers-select" name="travelers" onchange="updatePrice()" class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-400 focus:outline-none">
                                    <option value="1">1 osoba</option>
                                    <option value="2">2 osoby</option>
                                    <option value="3">3 osoby</option>
                                    <option value="4">4 osoby</option>
                                    <option value="5">5 osób</option>
                                    <option value="6">6 osób</option>
                                    <option value="7">7 osób</option>
                                    <option value="8">8 osób</option>
                                    <option value="9">9 osób</option>
                                    <option value="10">10+ osób</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-lg font-semibold text-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                Zarezerwuj teraz
                            </button>
                        </form>

                        <!-- Contact -->
                        <div class="mt-6 text-center">
                            <p class="text-gray-400 text-sm mb-2">Masz pytania?</p>
                            <a href="tel:+48123456789" class="text-blue-400 hover:text-blue-300 font-medium">+48 123 456 789</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Similar Destinations -->
    @if(count($similarDestinations) > 0)
    <section class="py-16 bg-black">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12">Podobne destynacje</h2>
            <div class="destinations-grid">
                @foreach($similarDestinations as $similar)
                <div class="destination-card">
                    <div class="destination-image">
                        @php
                            $similarSlug = strtolower(str_replace(['ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'],
                                                                   ['a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'],
                                                                   $similar['name']));
                            $similarSlug = preg_replace('/[^a-z0-9\-]/', '', $similarSlug);
                            $similarImagePath = "/images/destinations/{$similarSlug}-main.jpg";
                        @endphp

                        @if(file_exists(public_path($similarImagePath)))
                            <img src="{{ $similarImagePath }}"
                                 alt="{{ $similar['name'] }}"
                                 class="w-full h-full object-cover object-center">
                        @else
                            <div class="destination-image-placeholder">
                                <span class="placeholder-icon">📍</span>
                            </div>
                        @endif

                        <div class="destination-badges">
                            <span class="price-badge">
                                <span class="current-price">{{ $similar['price'] }} zł</span>
                            </span>
                            <span class="type-badge">{{ $similar['type'] }}</span>
                        </div>

                        <div class="destination-overlay">
                            <a href="/destinations/{{ $similar['id'] }}" class="overlay-btn">Zobacz szczegóły</a>
                        </div>
                    </div>

                    <div class="destination-content">
                        <div class="destination-header">
                            <h3 class="destination-name">{{ $similar['name'] }}</h3>
                            <div class="destination-rating">
                                <span class="rating-stars">⭐</span>
                                <span class="rating-value">{{ $similar['rating'] }}</span>
                            </div>
                        </div>

                        <p class="destination-description">{{ $similar['description'] }}</p>
                        <p class="destination-duration">{{ $similar['duration'] }}</p>

                        <a href="/destinations/{{ $similar['id'] }}" class="destination-btn">
                            Zobacz szczegóły
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Footer -->
    <footer class="footer">
        <div class="container mx-auto px-6">
            <div class="footer-content">
                <div class="footer-brand">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-2 rounded-lg">
                            <span class="text-white font-bold text-xl">🎫</span>
                        </div>
                        <span class="text-2xl font-bold">PolskaTour</span>
                    </div>
                    <p class="footer-description">
                        Odkrywaj Polskę z nami. Tworzymy niezapomniane przygody i wspomnienia na całe życie.
                    </p>
                </div>

                <div class="footer-links">
                    <div class="footer-column">
                        <h4>Destynacje</h4>
                        <a href="#">Góry</a>
                        <a href="#">Morze</a>
                        <a href="#">Miasta</a>
                        <a href="#">Przyroda</a>
                    </div>
                    <div class="footer-column">
                        <h4>Informacje</h4>
                        <a href="#">O nas</a>
                        <a href="#">Kontakt</a>
                        <a href="#">FAQ</a>
                        <a href="#">Blog</a>
                    </div>
                    <div class="footer-column">
                        <h4>Pomoc</h4>
                        <a href="#">Regulamin</a>
                        <a href="#">Polityka prywatności</a>
                        <a href="#">Płatności</a>
                        <a href="#">Anulowanie</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 PolskaTour. Wszystkie prawa zastrzeżone.</p>
                <div class="footer-social">
                    <a href="#" class="social-link">Facebook</a>
                    <a href="#" class="social-link">Instagram</a>
                    <a href="#" class="social-link">YouTube</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu -->
    <div class="mobile-menu hidden" id="mobile-menu">
        <div class="mobile-menu-content">
            <a href="/destinations">Destynacje</a>
            <a href="/attractions">Atrakcje</a>
            <a href="#about">O nas</a>
            <a href="#contact">Kontakt</a>
            <a href="/booking/{{ $destination['id'] }}" class="btn-primary w-full mt-4">Zarezerwuj teraz</a>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Lightbox functions
        function openLightbox(imageSrc, caption) {
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightbox-image');
            const lightboxCaption = document.getElementById('lightbox-caption');

            lightboxImage.src = imageSrc;
            lightboxCaption.textContent = caption;
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Close lightbox on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });

        // Close lightbox on background click
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Price calculator
        const basePrice = {{ $destination['price'] }};

        function updatePrice() {
            const travelersSelect = document.getElementById('travelers-select');
            const travelers = parseInt(travelersSelect.value);
            const totalPrice = basePrice * travelers;

            document.getElementById('total-price').textContent = totalPrice.toLocaleString('pl-PL') + ' zł';
            document.getElementById('hero-price').textContent = totalPrice.toLocaleString('pl-PL') + ' zł';

            let breakdown = '';
            if (travelers === 1) {
                breakdown = '1 osoba × ' + basePrice.toLocaleString('pl-PL') + ' zł';
            } else if (travelers <= 4) {
                breakdown = travelers + ' osoby × ' + basePrice.toLocaleString('pl-PL') + ' zł';
            } else {
                breakdown = travelers + ' osób × ' + basePrice.toLocaleString('pl-PL') + ' zł';
            }

            document.getElementById('price-breakdown').textContent = breakdown;
        }

        // Initialize price on page load
        updatePrice();

        // Add CSS for navbar scroll effect and destination cards
        const style = document.createElement('style');
        style.textContent = `
            #navbar.scrolled {
                background: rgba(0, 0, 0, 0.8);
                backdrop-filter: blur(20px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .destinations-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 24px;
                max-width: 1200px;
                margin: 0 auto;
            }

            .destination-card {
                background: linear-gradient(145deg, #2d3748, #1a202c);
                border-radius: 16px;
                overflow: hidden;
                transition: all 0.3s ease;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .destination-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
                border-color: rgba(59, 130, 246, 0.5);
            }

            .destination-image {
                position: relative;
                height: 340px;
                width: 100%;
                overflow: hidden;
                border-radius: 12px 12px 0 0;
            }

            .destination-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
                transition: transform 0.3s ease;
            }

            .destination-card:hover .destination-image img {
                transform: scale(1.1);
            }

            .destination-badges {
                position: absolute;
                top: 12px;
                left: 12px;
                z-index: 10;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .price-badge {
                background: rgba(0, 0, 0, 0.8);
                backdrop-filter: blur(10px);
                padding: 6px 12px;
                border-radius: 8px;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .current-price {
                color: #10b981;
                font-weight: bold;
                font-size: 14px;
            }

            .type-badge {
                background: rgba(59, 130, 246, 0.9);
                color: white;
                padding: 4px 8px;
                border-radius: 6px;
                font-size: 12px;
                font-weight: 500;
            }

            .destination-overlay {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, 0.6);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .destination-card:hover .destination-overlay {
                opacity: 1;
            }

            .overlay-btn {
                background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                color: white;
                padding: 12px 24px;
                border-radius: 8px;
                text-decoration: none;
                font-weight: 600;
                transform: translateY(20px);
                transition: all 0.3s ease;
            }

            .destination-card:hover .overlay-btn {
                transform: translateY(0);
            }

            .destination-content {
                padding: 20px;
            }

            .destination-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
            }

            .destination-name {
                font-size: 1.25rem;
                font-weight: bold;
                color: white;
            }

            .destination-rating {
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .rating-value {
                color: #fbbf24;
                font-weight: 600;
            }

            .destination-description {
                color: #d1d5db;
                margin-bottom: 8px;
                line-height: 1.5;
            }

            .destination-duration {
                color: #60a5fa;
                font-weight: 500;
                margin-bottom: 16px;
            }

            .destination-btn {
                display: inline-flex;
                align-items: center;
                background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                color: white;
                padding: 10px 16px;
                border-radius: 8px;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .destination-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
            }

            .destination-image-placeholder {
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, #374151, #111827);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .placeholder-icon {
                font-size: 3rem;
                opacity: 0.5;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
