<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atrakcje w Polsce - PolskaTour</title>
    <meta name="description" content="Odkryj najlepsze atrakcje turystyczne w Polsce. Zamki, muzea, parki rozrywki i wiele więcej!">

    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/app.js', 'resources/js/destinations.js'])
</head>
<body class="antialiased bg-black text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 bg-black/80 backdrop-blur-md" id="navbar">
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
                    <a href="/attractions" class="nav-link text-blue-400">Atrakcje</a>
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
    <section class="relative h-96 flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/80 to-blue-900/80"></div>
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-white">
                🎢 Atrakcje w Polsce
            </h1>
            <p class="text-xl text-gray-200 mb-6">Odkryj najciekawsze miejsca i zabytki naszego kraju</p>

            <!-- Filter buttons -->
            <div class="flex flex-wrap justify-center gap-4 mt-8">
                <button class="filter-btn active" data-filter="all">Wszystkie</button>
                <button class="filter-btn" data-filter="zabytki">🏰 Zabytki</button>
                <button class="filter-btn" data-filter="natura">🌲 Natura</button>
                <button class="filter-btn" data-filter="rozrywka">🎠 Rozrywka</button>
                <button class="filter-btn" data-filter="relaks">🏖️ Relaks</button>
            </div>
        </div>
    </section>

    <!-- Attractions Grid -->
    <section class="py-20 bg-gradient-to-b from-gray-900 to-black">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="attractions-grid">
                @foreach($attractions as $attraction)
                <div class="attraction-card" data-type="{{ $attraction['type'] }}">
                    <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700 hover:border-blue-500 transition-all duration-500 transform hover:scale-105 hover:shadow-2xl">
                        <div class="aspect-video relative overflow-hidden">
                            <div class="w-full h-full bg-gradient-to-br from-blue-600/30 to-purple-600/30 flex items-center justify-center">
                                <span class="text-4xl opacity-50">🏛️</span>
                            </div>

                            <div class="absolute top-4 left-4 right-4 flex justify-between items-start">
                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $attraction['price'] }} zł
                                </span>
                                <span class="bg-black/50 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs">
                                    {{ $attraction['city'] }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold text-white">{{ $attraction['name'] }}</h3>
                                <div class="flex items-center space-x-1 text-sm">
                                    <span class="text-yellow-400">⭐</span>
                                    <span class="text-gray-300 font-medium">{{ $attraction['rating'] }}</span>
                                </div>
                            </div>

                            <p class="text-gray-300 mb-4 text-sm">{{ $attraction['description'] }}</p>

                            <div class="flex justify-between items-center">
                                <span class="bg-gray-700 text-gray-300 px-2 py-1 rounded-lg text-xs">
                                    {{ $attraction['type'] }}
                                </span>
                                <a href="/attractions/{{ $attraction['id'] }}" class="text-blue-400 hover:text-blue-300 font-medium">
                                    Zobacz szczegóły →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-900 to-purple-900">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Nie znalazłeś tego czego szukasz?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Sprawdź nasze kompleksowe wycieczki, które łączą najpiękniejsze atrakcje w jednym pakiecie!
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/destinations" class="btn-primary btn-large">
                    Zobacz wycieczki
                </a>
                <a href="/contact" class="btn-secondary btn-large">
                    Skontaktuj się z nami
                </a>
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
                        <a href="/destinations">Wszystkie wycieczki</a>
                        <a href="/attractions">Atrakcje</a>
                        <a href="/attractions">Atrakcje</a>
                    </div>
                    <div class="footer-column">
                        <h4>Informacje</h4>
                        <a href="/about">O nas</a>
                        <a href="/contact">Kontakt</a>
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

    <script>
        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const attractionCards = document.querySelectorAll('.attraction-card');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterBtns.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');

                    const filter = this.getAttribute('data-filter');

                    attractionCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-type') === filter) {
                            card.style.display = 'block';
                            card.style.animation = 'fadeInUp 0.5s ease-out';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>

    <style>
        .filter-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-btn:hover, .filter-btn.active {
            background: linear-gradient(to right, #2563eb, #7c3aed);
            border-color: transparent;
            transform: scale(1.05);
        }

        .attraction-card {
            transition: all 0.3s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>
</html>
