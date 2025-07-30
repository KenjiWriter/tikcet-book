<!DOCTYPE html>
<html lang="pl" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Odkryj najpiękniejsze destynacje w Polsce. Zarezerwuj niezapomniane wycieczki i poznaj polskie cuda natury, historii i kultury.">
    <title>Destynacje - PolskaTour | Odkryj Polskę jak nigdy wcześniej</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/css/destinations.css', 'resources/js/app.js', 'resources/js/destinations.js'])
</head>
<body class="bg-gray-900">
    <!-- Navigation -->
    <nav class="navbar fixed top-0 w-full z-50" id="navbar">
        <div class="container mx-auto px-6 py-4">
            <div class="nav-content">
                <div class="nav-brand">
                    <a href="/" class="brand-link">
                        <span class="brand-icon">🇵🇱</span>
                        <span class="brand-text">PolskaTour</span>
                    </a>
                </div>

                <div class="nav-menu hidden md:flex">
                    <a href="/" class="nav-link">Strona główna</a>
                    <a href="/destinations" class="nav-link active">Destynacje</a>
                    <a href="/attractions" class="nav-link">Atrakcje</a>
                    <a href="/search" class="nav-link">Wyszukaj</a>
                    <a href="/about" class="nav-link">O nas</a>
                    <a href="/contact" class="nav-link">Kontakt</a>
                </div>

                <div class="nav-actions hidden md:flex">
                    <button class="btn-secondary">Zaloguj się</button>
                    <button class="btn-primary">Utwórz konto</button>
                </div>

                <button class="mobile-menu-btn md:hidden" id="mobile-menu-btn">
                    <span></span><span></span><span></span>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu hidden" id="mobile-menu">
                <div class="mobile-nav-links">
                    <a href="/" class="mobile-nav-link">Strona główna</a>
                    <a href="/destinations" class="mobile-nav-link active">Destynacje</a>
                    <a href="/attractions" class="mobile-nav-link">Atrakcje</a>
                    <a href="/search" class="mobile-nav-link">Wyszukaj</a>
                    <a href="/about" class="mobile-nav-link">O nas</a>
                    <a href="/contact" class="mobile-nav-link">Kontakt</a>
                </div>
                <div class="mobile-nav-actions">
                    <button class="btn-secondary w-full mb-3">Zaloguj się</button>
                    <button class="btn-primary w-full">Utwórz konto</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="destinations-hero" id="hero">
        <div class="hero-background"></div>
        <div class="particles" id="particles"></div>

        <div class="container mx-auto px-6">
            <div class="hero-content">
                <h1 class="hero-title">
                    Odkryj <span class="title-highlight">Polskie Skarby</span>
                </h1>
                <p class="hero-subtitle">
                    Od majestycznych gór po urokliwe wybrzeże - poznaj najpiękniejsze zakątki Polski z naszymi eksklusiwnymi wycieczkami
                </p>

                <!-- Breadcrumb -->
                <nav class="breadcrumb">
                    <a href="/">Strona główna</a>
                    <span class="breadcrumb-separator">•</span>
                    <span class="breadcrumb-current">Destynacje</span>
                </nav>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="filters-section">
        <div class="container mx-auto px-6">
            <div class="filters-container">
                <div class="filters-header">
                    <h2 class="filters-title">Znajdź idealną destynację</h2>
                    <button class="filters-toggle md:hidden" id="filters-toggle">
                        <span>Filtry</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                    </button>
                </div>

                <form class="filters-form" id="destination-filters">
                    <div class="filter-group">
                        <label class="filter-label">Region</label>
                        <select name="region" class="filter-select">
                            <option value="">Wszystkie regiony</option>
                            <option value="góry">Góry</option>
                            <option value="wybrzeże">Wybrzeże</option>
                            <option value="mazury">Mazury</option>
                            <option value="śląsk">Śląsk</option>
                            <option value="małopolska">Małopolska</option>
                            <option value="podlasie">Podlasie</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Typ podróży</label>
                        <select name="type" class="filter-select">
                            <option value="">Wszystkie typy</option>
                            <option value="adventure">Przygoda</option>
                            <option value="relax">Relaks</option>
                            <option value="culture">Kultura</option>
                            <option value="nature">Natura</option>
                            <option value="family">Rodzinne</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Długość</label>
                        <select name="duration" class="filter-select">
                            <option value="">Dowolna długość</option>
                            <option value="1">1 dzień</option>
                            <option value="2-3">2-3 dni</option>
                            <option value="4-7">4-7 dni</option>
                            <option value="7+">Powyżej 7 dni</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Budżet (od osoby)</label>
                        <div class="price-range">
                            <input type="range" name="price_min" min="100" max="2000" value="100" class="price-slider">
                            <input type="range" name="price_max" min="100" max="2000" value="2000" class="price-slider">
                            <div class="price-display">
                                <span id="price-min-display">100</span> zł - <span id="price-max-display">2000</span> zł
                            </div>
                        </div>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Ocena</label>
                        <div class="rating-filter">
                            @for($i = 5; $i >= 1; $i--)
                            <label class="rating-option">
                                <input type="radio" name="rating" value="{{ $i }}">
                                <div class="rating-stars">
                                    @for($j = 1; $j <= $i; $j++)
                                        <span class="star">★</span>
                                    @endfor
                                    <span class="rating-text">{{ $i }}+ gwiazdek</span>
                                </div>
                            </label>
                            @endfor
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="button" class="btn-outline" id="clear-filters">Wyczyść filtry</button>
                        <button type="submit" class="btn-primary">Zastosuj filtry</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Destinations Grid -->
    <section class="destinations-section">
        <div class="container mx-auto px-6">
            <div class="destinations-header">
                <div class="results-info">
                    <h3 class="results-title">Znalezione destynacje</h3>
                    <p class="results-count">Wyświetlane <span id="results-count">{{ count($destinations) }}</span> z {{ count($destinations) }} dostępnych destynacji</p>
                </div>

                <div class="sort-options">
                    <label class="sort-label">Sortuj według:</label>
                    <select name="sort" class="sort-select" id="sort-destinations">
                        <option value="popular">Popularności</option>
                        <option value="price_low">Ceny: od najniższej</option>
                        <option value="price_high">Ceny: od najwyższej</option>
                        <option value="rating">Oceny</option>
                        <option value="name">Nazwy A-Z</option>
                        <option value="duration">Długości</option>
                    </select>
                </div>
            </div>

            <div class="destinations-grid" id="destinations-grid">
                @foreach($destinations as $destination)
                <div class="destination-card" data-destination="{{ $destination['id'] }}" data-region="{{ $destination['region'] }}" data-type="{{ $destination['type'] }}" data-price="{{ $destination['price'] }}" data-rating="{{ $destination['rating'] }}" data-duration="{{ $destination['duration'] }}">
                    <div class="destination-image">
                        <img src="{{ $destination['image'] }}" alt="{{ $destination['name'] }}" loading="lazy">
                        <div class="destination-badges">
                            @if($destination['featured'])
                            <span class="featured-badge">Polecane</span>
                            @endif
                            @if($destination['discount'])
                            <span class="discount-badge">-{{ $destination['discount'] }}%</span>
                            @endif
                        </div>
                        <div class="destination-overlay">
                            <a href="/destinations/{{ $destination['id'] }}" class="overlay-btn">Zobacz szczegóły</a>
                            <button class="favorite-btn" data-destination="{{ $destination['id'] }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="destination-content">
                        <div class="destination-header">
                            <h3 class="destination-name">{{ $destination['name'] }}</h3>
                            <div class="destination-rating">
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $destination['rating'] ? 'filled' : '' }}">★</span>
                                    @endfor
                                </div>
                                <span class="rating-text">{{ $destination['rating'] }}/5 ({{ $destination['reviews'] }} opinii)</span>
                            </div>
                        </div>

                        <div class="destination-location">
                            <svg class="location-icon" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $destination['region'] }}</span>
                        </div>

                        <p class="destination-description">{{ $destination['description'] }}</p>
                        <p class="destination-duration">{{ $destination['duration'] }}</p>

                        <div class="destination-highlights">
                            @foreach($destination['highlights'] as $highlight)
                                <span class="highlight-badge">{{ $highlight }}</span>
                            @endforeach
                        </div>

                        <div class="destination-features">
                            @foreach($destination['features'] as $feature)
                                <span class="feature-tag">{{ $feature }}</span>
                            @endforeach
                        </div>

                        <div class="destination-footer">
                            <div class="destination-price">
                                @if($destination['discount'])
                                <span class="original-price">{{ $destination['original_price'] }} zł</span>
                                @endif
                                <span class="current-price">{{ $destination['price'] }} zł</span>
                                <span class="price-period">od osoby</span>
                            </div>
                            <a href="/destinations/{{ $destination['id'] }}" class="btn btn-primary">Zarezerwuj teraz</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Load More Button -->
            <div class="load-more-section">
                <button class="btn-outline load-more-btn" id="load-more">
                    Załaduj więcej destynacji
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container mx-auto px-6">
            <div class="newsletter-content">
                <div class="newsletter-text">
                    <h3 class="newsletter-title">Nie przegap najlepszych ofert!</h3>
                    <p class="newsletter-subtitle">Zapisz się do naszego newslettera i otrzymuj ekskluzywne zniżki na wycieczki po Polsce</p>
                </div>
                <form class="newsletter-form">
                    <input type="email" placeholder="Twój adres email" class="newsletter-input" required>
                    <button type="submit" class="newsletter-btn">Zapisz się</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container mx-auto px-6">
            <div class="footer-content">
                <div class="footer-section">
                    <h4 class="footer-title">PolskaTour</h4>
                    <p class="footer-description">
                        Odkrywaj najpiękniejsze zakątki Polski z naszymi wyjątkowymi wycieczkami.
                        Tworzymy niezapomniane doświadczenia od 2015 roku.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-link">Facebook</a>
                        <a href="#" class="social-link">Instagram</a>
                        <a href="#" class="social-link">YouTube</a>
                    </div>
                </div>

                <div class="footer-section">
                    <h4 class="footer-title">Destynacje</h4>
                    <ul class="footer-links">
                        <li><a href="/destinations?region=góry">Góry</a></li>
                        <li><a href="/destinations?region=wybrzeże">Wybrzeże</a></li>
                        <li><a href="/destinations?region=mazury">Mazury</a></li>
                        <li><a href="/destinations?region=śląsk">Śląsk</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4 class="footer-title">Pomoc</h4>
                    <ul class="footer-links">
                        <li><a href="/faq">FAQ</a></li>
                        <li><a href="/contact">Kontakt</a></li>
                        <li><a href="/booking-help">Pomoc z rezerwacją</a></li>
                        <li><a href="/cancellation">Anulowanie</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4 class="footer-title">Informacje</h4>
                    <ul class="footer-links">
                        <li><a href="/about">O nas</a></li>
                        <li><a href="/terms">Warunki</a></li>
                        <li><a href="/privacy">Prywatność</a></li>
                        <li><a href="/careers">Kariera</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 PolskaTour. Wszystkie prawa zastrzeżone.</p>
                <div class="footer-bottom-links">
                    <a href="/terms">Warunki korzystania</a>
                    <a href="/privacy">Polityka prywatności</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
