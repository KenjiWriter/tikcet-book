<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>O nas - PolskaTour</title>
    <meta name="description" content="Poznaj historię PolskaTour - pasję do odkrywania Polski i tworzenia niezapomnianych wspomnień.">

    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/app.js'])
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
                    <a href="/attractions" class="nav-link">Atrakcje</a>
                    <a href="/about" class="nav-link text-blue-400">O nas</a>
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
        <div class="absolute inset-0 bg-gradient-to-br from-green-900/80 to-blue-900/80"></div>
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-white">
                ❤️ O nas
            </h1>
            <p class="text-xl text-gray-200">Nasza pasja to odkrywanie piękna Polski</p>
        </div>
    </section>

    <!-- Our Story -->
    <section class="py-20 bg-gradient-to-b from-gray-900 to-black">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl font-bold text-center mb-12 text-white">Nasza historia</h2>

                <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                    <div>
                        <h3 class="text-2xl font-bold mb-6 text-white">Jak to się zaczęło</h3>
                        <p class="text-gray-300 mb-4 leading-relaxed">
                            PolskaTour powstał z miłości do naszego pięknego kraju. W 2020 roku grupa przyjaciół - pasjonatów podróży - postanowiła pokazać światu, jak wiele cudów kryje Polska.
                        </p>
                        <p class="text-gray-300 mb-4 leading-relaxed">
                            Zaczęliśmy od małych wycieczek weekendowych dla znajomych. Dziś organizujemy niezapomniane przygody dla turystów z całego świata, zawsze z sercem i pasją.
                        </p>
                        <p class="text-gray-300 leading-relaxed">
                            Naszą misją jest pokazanie, że Polska to nie tylko Kraków i Warszawa - to góry, morze, dzikie puszcze, urokliwe miasteczka i bogata kultura.
                        </p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-600/30 to-purple-600/30 aspect-square rounded-lg flex items-center justify-center">
                        <span class="text-8xl opacity-50">🇵🇱</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="py-20 bg-black">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12 text-white">Nasz zespół</h2>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="text-center">
                    <div class="bg-gradient-to-br from-blue-600/30 to-purple-600/30 w-32 h-32 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <span class="text-4xl">👨‍💼</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Marcin Kowalski</h3>
                    <p class="text-blue-400 mb-3">Założyciel & CEO</p>
                    <p class="text-gray-300 text-sm">
                        Pasjonat gór i historii Polski. Zdobył wszystkie szczyty Tatr i zna każdy zakamarek Krakowa.
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-gradient-to-br from-green-600/30 to-blue-600/30 w-32 h-32 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <span class="text-4xl">👩‍🦰</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Anna Nowak</h3>
                    <p class="text-green-400 mb-3">Kierownik ds. Doświadczeń</p>
                    <p class="text-gray-300 text-sm">
                        Ekspertka od kultury i tradycji polskich. Tworzy unikalne programy poznawcze.
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-gradient-to-br from-purple-600/30 to-pink-600/30 w-32 h-32 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <span class="text-4xl">👨‍🌾</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Piotr Wiśniewski</h3>
                    <p class="text-purple-400 mb-3">Przewodnik Główny</p>
                    <p class="text-gray-300 text-sm">
                        Licencjonowany przewodnik po Polsce. Potrafi opowiadać fascynujące historie o każdym miejscu.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="py-20 bg-gradient-to-b from-black to-gray-900">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12 text-white">Nasze wartości</h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-blue-600 w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-2xl">🎯</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Pasja</h3>
                    <p class="text-gray-300 text-sm">
                        Robimy to co kochamy - pokazujemy piękno Polski z prawdziwym zaangażowaniem.
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-green-600 w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-2xl">🤝</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Zaufanie</h3>
                    <p class="text-gray-300 text-sm">
                        Budujemy długotrwałe relacje oparte na szczerości i profesjonalizmie.
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-purple-600 w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Jakość</h3>
                    <p class="text-gray-300 text-sm">
                        Każdy detal ma znaczenie - od transportu po nocleg, dbamy o najwyższą jakość.
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-orange-600 w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-2xl">🌱</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Ekologia</h3>
                    <p class="text-gray-300 text-sm">
                        Szanujemy naturę i promujemy odpowiedzialny turyzm.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="py-20 bg-gradient-to-r from-blue-900 to-purple-900">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12 text-white">W liczbach</h2>

            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-5xl font-bold text-white mb-2" data-count="15000">0</div>
                    <div class="text-blue-200">Zadowolonych turystów</div>
                </div>
                <div>
                    <div class="text-5xl font-bold text-white mb-2" data-count="250">0</div>
                    <div class="text-blue-200">Odwiedzonych miejsc</div>
                </div>
                <div>
                    <div class="text-5xl font-bold text-white mb-2" data-count="50">0</div>
                    <div class="text-blue-200">Doświadczonych przewodników</div>
                </div>
                <div>
                    <div class="text-5xl font-bold text-white mb-2" data-count="5">0</div>
                    <div class="text-blue-200">Lat doświadczenia</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-black">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Gotowy na przygodę?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Dołącz do tysięcy zadowolonych turystów i odkryj Polskę razem z nami!
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/destinations" class="btn-primary btn-large">
                    Zobacz nasze wycieczki
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
        // Counter animation
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('[data-count]');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = parseInt(counter.getAttribute('data-count'));
                        const increment = target / 50;
                        let current = 0;

                        const updateCounter = () => {
                            if (current < target) {
                                current += increment;
                                counter.textContent = Math.floor(current).toLocaleString();
                                requestAnimationFrame(updateCounter);
                            } else {
                                counter.textContent = target.toLocaleString();
                            }
                        };

                        updateCounter();
                        observer.unobserve(counter);
                    }
                });
            });

            counters.forEach(counter => observer.observe(counter));
        });
    </script>
</body>
</html>
