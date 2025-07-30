<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontakt - PolskaTour</title>
    <meta name="description" content="Skontaktuj się z PolskaTour. Jesteśmy tu, aby pomóc Ci zaplanować idealną wycieczkę po Polsce.">

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
                    <a href="/about" class="nav-link">O nas</a>
                    <a href="/contact" class="nav-link text-blue-400">Kontakt</a>
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
        <div class="absolute inset-0 bg-gradient-to-br from-teal-900/80 to-blue-900/80"></div>
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-white">
                📞 Kontakt
            </h1>
            <p class="text-xl text-gray-200">Jesteśmy tu, aby pomóc Ci zaplanować idealną wycieczkę</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-20 bg-gradient-to-b from-gray-900 to-black">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16">
                <!-- Contact Form -->
                <div>
                    <h2 class="text-3xl font-bold mb-8 text-white">Napisz do nas</h2>

                    @if(session('success'))
                    <div class="bg-green-600 text-white p-4 rounded-lg mb-6">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">✅</span>
                            {{ session('success') }}
                        </div>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="bg-red-600 text-white p-4 rounded-lg mb-6">
                        <div class="flex items-center mb-2">
                            <span class="text-2xl mr-3">❌</span>
                            <span class="font-semibold">Wystąpiły błędy:</span>
                        </div>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="/contact" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-300 text-sm font-medium mb-2">Imię i nazwisko *</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                       class="w-full bg-gray-800 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label for="email" class="block text-gray-300 text-sm font-medium mb-2">Email *</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                       class="w-full bg-gray-800 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-gray-300 text-sm font-medium mb-2">Telefon</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                       class="w-full bg-gray-800 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label for="subject" class="block text-gray-300 text-sm font-medium mb-2">Temat *</label>
                                <select id="subject" name="subject" required
                                        class="w-full bg-gray-800 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors">
                                    <option value="">Wybierz temat</option>
                                    <option value="Rezerwacja" {{ old('subject') == 'Rezerwacja' ? 'selected' : '' }}>Rezerwacja</option>
                                    <option value="Informacje o wycieczce" {{ old('subject') == 'Informacje o wycieczce' ? 'selected' : '' }}>Informacje o wycieczce</option>
                                    <option value="Współpraca" {{ old('subject') == 'Współpraca' ? 'selected' : '' }}>Współpraca</option>
                                    <option value="Reklamacja" {{ old('subject') == 'Reklamacja' ? 'selected' : '' }}>Reklamacja</option>
                                    <option value="Inne" {{ old('subject') == 'Inne' ? 'selected' : '' }}>Inne</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-gray-300 text-sm font-medium mb-2">Wiadomość *</label>
                            <textarea id="message" name="message" rows="6" required
                                      class="w-full bg-gray-800 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors resize-vertical"
                                      placeholder="Opisz swoją sprawę...">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-lg font-bold text-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            📧 Wyślij wiadomość
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div>
                    <h2 class="text-3xl font-bold mb-8 text-white">Skontaktuj się z nami</h2>

                    <div class="space-y-8">
                        <!-- Office -->
                        <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                            <div class="flex items-start space-x-4">
                                <div class="bg-blue-600 w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-xl">🏢</span>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold mb-2">Biuro główne</h3>
                                    <p class="text-gray-300 mb-1">ul. Floriańska 12</p>
                                    <p class="text-gray-300 mb-1">31-021 Kraków</p>
                                    <p class="text-gray-300">Polska</p>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                            <div class="flex items-start space-x-4">
                                <div class="bg-green-600 w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-xl">📞</span>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold mb-2">Telefon</h3>
                                    <p class="text-gray-300 mb-1">
                                        <a href="tel:+48123456789" class="hover:text-white transition-colors">+48 123 456 789</a>
                                    </p>
                                    <p class="text-gray-300 text-sm">Pon-Pt: 9:00-18:00</p>
                                    <p class="text-gray-300 text-sm">Sob: 10:00-15:00</p>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                            <div class="flex items-start space-x-4">
                                <div class="bg-purple-600 w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-xl">📧</span>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold mb-2">Email</h3>
                                    <p class="text-gray-300 mb-1">
                                        <a href="mailto:info@polskatour.pl" class="hover:text-white transition-colors">info@polskatour.pl</a>
                                    </p>
                                    <p class="text-gray-300 mb-1">
                                        <a href="mailto:rezerwacje@polskatour.pl" class="hover:text-white transition-colors">rezerwacje@polskatour.pl</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                            <div class="flex items-start space-x-4">
                                <div class="bg-pink-600 w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-xl">📱</span>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold mb-2">Social Media</h3>
                                    <div class="space-y-2">
                                        <p class="text-gray-300">
                                            <a href="#" class="hover:text-white transition-colors">Facebook: /PolskaTourOfficial</a>
                                        </p>
                                        <p class="text-gray-300">
                                            <a href="#" class="hover:text-white transition-colors">Instagram: @polskatour</a>
                                        </p>
                                        <p class="text-gray-300">
                                            <a href="#" class="hover:text-white transition-colors">YouTube: PolskaTour</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Link -->
                    <div class="mt-8 p-6 bg-gradient-to-r from-blue-900/50 to-purple-900/50 rounded-lg border border-blue-500/30">
                        <h3 class="text-white font-semibold mb-2">Często zadawane pytania</h3>
                        <p class="text-blue-200 text-sm mb-4">
                            Sprawdź nasze FAQ - możesz znaleźć odpowiedź na swoje pytanie!
                        </p>
                        <a href="#" class="text-blue-400 hover:text-blue-300 font-medium">
                            Zobacz FAQ →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-16 bg-black">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-8 text-white">Znajdź nas</h2>
            <div class="bg-gray-800 h-96 rounded-lg flex items-center justify-center border border-gray-700">
                <div class="text-center">
                    <span class="text-6xl mb-4 block">🗺️</span>
                    <p class="text-gray-300">Mapa Google będzie tutaj</p>
                    <p class="text-gray-400 text-sm mt-2">ul. Floriańska 12, Kraków</p>
                </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        this.classList.add('border-red-500');
                        this.classList.remove('border-gray-600');
                    } else {
                        this.classList.remove('border-red-500');
                        this.classList.add('border-gray-600');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('border-red-500');
                        this.classList.add('border-green-500');
                    }
                });
            });

            // Email validation
            const emailInput = document.getElementById('email');
            emailInput.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    this.classList.add('border-red-500');
                    this.classList.remove('border-gray-600', 'border-green-500');
                }
            });
        });
    </script>
</body>
</html>
