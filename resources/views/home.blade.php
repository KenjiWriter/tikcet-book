<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PolskaTour - Odkryj najpiękniejsze miejsca w Polsce</title>
    <meta name="description" content="Odkryj najpiękniejsze miejsca w Polsce. Bilety na wycieczki, atrakcje i przygody po całym kraju. Od Tatr po Bałtyk!">

    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/app.js', 'resources/js/home.js'])
</head>
<body class="antialiased overflow-x-hidden bg-black text-white">
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
                    <a href="/about" class="nav-link">O nas</a>
                    <a href="/contact" class="nav-link">Kontakt</a>
                    <a href="/booking/create" class="btn-primary">
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

    <!-- Hero Section -->
    <section class="hero-section" id="hero">
        <div class="hero-background"></div>
        <div class="hero-particles" id="particles"></div>

        <div class="hero-content">
            <div class="container mx-auto px-6 text-center">
                <h1 class="hero-title">
                    Odkryj <span class="gradient-text">Polskę</span>
                    <br>jak nigdy wcześniej
                </h1>
                <p class="hero-subtitle">
                    Niezapomniane przygody czekają na Ciebie. Od Tatr po Bałtyk,
                    od zamków po puszcze - poznaj najpiękniejsze zakątki naszego kraju.
                </p>

                <!-- Search Bar -->
                <div class="search-container">
                    <form class="search-form">
                        <div class="search-grid">
                            <div class="search-field">
                                <label>Gdzie?</label>
                                <input type="text" placeholder="Wybierz destynację" class="search-input">
                            </div>
                            <div class="search-field">
                                <label>Kiedy?</label>
                                <input type="date" class="search-input">
                            </div>
                            <div class="search-field">
                                <label>Ile osób?</label>
                                <select class="search-input">
                                    <option>1 osoba</option>
                                    <option>2 osoby</option>
                                    <option>3-4 osoby</option>
                                    <option>5+ osób</option>
                                </select>
                            </div>
                            <button type="submit" class="search-btn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Szukaj
                            </button>
                        </div>
                    </form>
                </div>

                <div class="hero-cta">
                    <button class="btn-primary btn-large">
                        Zaplanuj wycieczkę
                    </button>
                    <button class="btn-secondary btn-large">
                        Zobacz oferty
                    </button>
                </div>

                <!-- Trust badges -->
                <div class="trust-badges">
                    <div class="trust-badge">
                        <span class="trust-number">15k+</span>
                        <span class="trust-label">Zadowolonych klientów</span>
                    </div>
                    <div class="trust-badge">
                        <span class="trust-number">250+</span>
                        <span class="trust-label">Destynacji</span>
                    </div>
                    <div class="trust-badge">
                        <span class="trust-number">4.9</span>
                        <span class="trust-label">Średnia ocena</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- Featured Destinations -->
    <section class="destinations-section" id="destinations">
        <div class="container mx-auto px-6">
            <div class="section-header">
                <h2 class="section-title">Popularne destynacje</h2>
                <p class="section-subtitle">
                    Odkryj najpiękniejsze miejsca w Polsce, które zachwycą Cię swoim urokiem i historią
                </p>
            </div>

            <div class="destinations-grid">
                <!-- DEBUG: Sprawdzanie czy dane przychodzą -->
                @if(empty($featuredDestinations))
                    <div style="color: white; text-align: center; grid-column: 1/-1; padding: 2rem;">
                        <h3>Brak destynacji do wyświetlenia</h3>
                        <p>Destynacje: {{ count($featuredDestinations ?? []) }}</p>
                    </div>
                @endif

                @foreach($featuredDestinations as $destination)
                <div class="destination-card" data-destination="{{ $destination['id'] }}">
                    <div class="destination-image">
                        <img src="{{ $destination['image'] }}"
                             alt="{{ $destination['name'] }}"
                             class="w-full h-full object-cover rounded-lg"
                             style="min-height: 200px; background-color: #374151;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="destination-image-placeholder" style="display: none;">
                            <span class="placeholder-icon">🏞️</span>
                        </div>

                        <div class="destination-badges">
                            <span class="price-badge">
                                <span class="current-price">{{ $destination['price'] }} zł</span>
                                @if(isset($destination['original_price']))
                                <span class="original-price">{{ $destination['original_price'] }} zł</span>
                                @endif
                            </span>
                            <span class="type-badge">{{ $destination['type'] }}</span>
                        </div>

                        <div class="destination-overlay">
                            <a href="/destinations/{{ $destination['id'] }}" class="overlay-btn">Zobacz szczegóły</a>
                        </div>
                    </div>

                    <div class="destination-content">
                        <div class="destination-header">
                            <h3 class="destination-name">{{ $destination['name'] }}</h3>
                            <div class="destination-rating">
                                <span class="rating-stars">⭐</span>
                                <span class="rating-value">{{ $destination['rating'] }}</span>
                            </div>
                        </div>

                        <p class="destination-description">{{ $destination['description'] }}</p>
                        <p class="destination-duration">{{ $destination['duration'] }}</p>

                        <div class="destination-activities">
                            @foreach(array_slice($destination['activities'], 0, 3) as $activity)
                            <span class="activity-tag">{{ $activity }}</span>
                            @endforeach
                            @if(count($destination['activities']) > 3)
                            <span class="activity-more">+{{ count($destination['activities']) - 3 }}</span>
                            @endif
                        </div>

                        <div class="destination-highlights">
                            <span class="highlights-label">Najważniejsze atrakcje:</span>
                            <span class="highlights-text">{{ implode(' • ', $destination['highlights']) }}</span>
                        </div>

                        <a href="/destinations/{{ $destination['id'] }}" class="destination-btn">
                            Zarezerwuj teraz
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="section-cta">
                <a href="/destinations" class="btn-outline">Zobacz wszystkie destynacje</a>
            </div>
        </div>
    </section>

    <!-- Travel Types -->
    <section class="travel-types-section" id="attractions">
        <div class="travel-types-background"></div>

        <div class="container mx-auto px-6">
            <div class="section-header">
                <h2 class="section-title">Rodzaje podróży</h2>
                <p class="section-subtitle">
                    Znajdź idealny typ przygody dopasowany do Twoich potrzeb i zainteresowań
                </p>
            </div>

            <div class="travel-types-grid">
                <!-- Debug: Sprawdźmy zmienne -->
                @if(isset($travelTypes))
                    <!-- OK: mamy travelTypes ({{ count($travelTypes) }} elementów) -->
                @else
                    <!-- BŁĄD: brak travelTypes -->
                @endif

                @foreach($travelTypes as $type)
                <div class="travel-type-card {{ $type['popular'] ? 'popular' : '' }}">
                    @if($type['popular'])
                    <div class="popular-badge">Popularne</div>
                    @endif

                    <div class="travel-type-icon">{{ $type['icon'] }}</div>
                    <h3 class="travel-type-name">{{ $type['name'] }}</h3>
                    <p class="travel-type-description">{{ $type['description'] }}</p>
                    <div class="travel-type-duration">{{ $type['duration'] }}</div>
                    <div class="travel-type-price">od {{ $type['price_from'] }} zł</div>

                    <a href="/attractions" class="travel-type-btn">Sprawdź oferty</a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="stats-section">
        <div class="container mx-auto px-6">
            <div class="stats-grid">
                @foreach($stats as $stat)
                <div class="stat-item">
                    <div class="stat-icon">{{ $stat['icon'] }}</div>
                    <div class="stat-number" data-count="{{ $stat['value'] }}">0</div>
                    <div class="stat-label">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter-section">
        <div class="container mx-auto px-6">
            <div class="newsletter-content">
                <h2 class="newsletter-title">Nie przegap najlepszych ofert!</h2>
                <p class="newsletter-subtitle">
                    Otrzymuj ekskluzywne promocje i inspiracje podróżnicze prosto na swoją skrzynkę
                </p>

                <form class="newsletter-form">
                    <input type="email" placeholder="Twój adres email" class="newsletter-input" required>
                    <button type="submit" class="newsletter-btn">Zapisz się</button>
                </form>

                <p class="newsletter-privacy">
                    Respektujemy Twoją prywatność. Możesz się wypisać w każdej chwili.
                </p>
            </div>
        </div>
    </section>

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
            <a href="#destinations">Destynacje</a>
            <a href="#attractions">Atrakcje</a>
            <a href="#about">O nas</a>
            <a href="#contact">Kontakt</a>
            <button class="btn-primary w-full mt-4">Zarezerwuj teraz</button>
        </div>
    </div>
</body>
</html>
