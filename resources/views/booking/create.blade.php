<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rezerwacja - PolskaTour</title>
    <meta name="description" content="Zarezerwuj swoją wymarzoną wycieczkę po Polsce. Bezpieczne płatności, profesjonalna obsługa.">

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
                    <a href="/contact" class="nav-link">Kontakt</a>
                    <a href="/booking/create" class="btn-primary text-blue-400">
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
                🎯 Rezerwacja
            </h1>
            <p class="text-xl text-gray-200">Wybierz swoją wymarzoną wycieczkę i zarezerwuj w 3 prostych krokach</p>
        </div>
    </section>

    <!-- Booking Form -->
    <section class="py-20 bg-gradient-to-b from-gray-900 to-black">
        <div class="container mx-auto px-6">
            @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded-lg mb-8 max-w-4xl mx-auto">
                <div class="flex items-center">
                    <span class="text-2xl mr-3">✅</span>
                    {{ session('success') }}
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-600 text-white p-4 rounded-lg mb-8 max-w-4xl mx-auto">
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

            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Booking Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-gray-800 rounded-lg p-8 border border-gray-700">
                            <h2 class="text-2xl font-bold mb-6 text-white">Szczegóły rezerwacji</h2>

                            <form action="/booking" method="POST" id="booking-form">
                                @csrf

                                <!-- Destination Selection -->
                                <div class="mb-8">
                                    <label for="destination_id" class="block text-gray-300 text-sm font-medium mb-3">
                                        Wybierz destynację *
                                    </label>
                                    <div class="grid md:grid-cols-2 gap-4">
                                        @foreach($destinations as $dest)
                                        <div class="relative">
                                            <input type="radio" id="dest_{{ $dest->id }}" name="destination_id" value="{{ $dest->id }}"
                                                   class="peer sr-only" {{ old('destination_id') == $dest->id ? 'checked' : '' }}
                                                   {{ $destination && $destination->id == $dest->id ? 'checked' : '' }}>
                                            <label for="dest_{{ $dest->id }}"
                                                   class="block bg-gray-700 border-2 border-gray-600 rounded-lg p-4 cursor-pointer hover:bg-gray-600 peer-checked:border-blue-500 peer-checked:bg-blue-900/30 transition-all">
                                                <div class="flex items-start space-x-3">
                                                    <img src="{{ $dest->image }}" alt="{{ $dest->name }}"
                                                         class="w-16 h-16 object-cover rounded-lg">
                                                    <div class="flex-1">
                                                        <h3 class="font-semibold text-white">{{ $dest->name }}</h3>
                                                        <p class="text-gray-400 text-sm mb-1">{{ $dest->duration }}</p>
                                                        <p class="text-blue-400 font-bold">{{ $dest->price }} zł/os</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Dates -->
                                <div class="grid md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="start_date" class="block text-gray-300 text-sm font-medium mb-2">
                                            Data rozpoczęcia *
                                        </label>
                                        <input type="date" id="start_date" name="start_date" required
                                               value="{{ old('start_date') }}"
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors">
                                    </div>
                                    <div>
                                        <label for="end_date" class="block text-gray-300 text-sm font-medium mb-2">
                                            Data zakończenia *
                                        </label>
                                        <input type="date" id="end_date" name="end_date" required
                                               value="{{ old('end_date') }}"
                                               min="{{ date('Y-m-d', strtotime('+2 days')) }}"
                                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors">
                                    </div>
                                </div>

                                <!-- Participants -->
                                <div class="mb-6">
                                    <label for="participants" class="block text-gray-300 text-sm font-medium mb-2">
                                        Liczba uczestników *
                                    </label>
                                    <select id="participants" name="participants" required
                                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors">
                                        <option value="">Wybierz liczbę osób</option>
                                        @for($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}" {{ old('participants') == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i == 1 ? 'osoba' : ($i <= 4 ? 'osoby' : 'osób') }}
                                        </option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Customer Details -->
                                <div class="border-t border-gray-600 pt-6 mb-6">
                                    <h3 class="text-lg font-semibold text-white mb-4">Dane kontaktowe</h3>

                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="customer_name" class="block text-gray-300 text-sm font-medium mb-2">
                                                Imię i nazwisko *
                                            </label>
                                            <input type="text" id="customer_name" name="customer_name" required
                                                   value="{{ old('customer_name') }}"
                                                   class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors">
                                        </div>
                                        <div>
                                            <label for="customer_email" class="block text-gray-300 text-sm font-medium mb-2">
                                                Email *
                                            </label>
                                            <input type="email" id="customer_email" name="customer_email" required
                                                   value="{{ old('customer_email') }}"
                                                   class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors">
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <label for="customer_phone" class="block text-gray-300 text-sm font-medium mb-2">
                                            Telefon *
                                        </label>
                                        <input type="tel" id="customer_phone" name="customer_phone" required
                                               value="{{ old('customer_phone') }}"
                                               placeholder="+48 123 456 789"
                                               class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors">
                                    </div>
                                </div>

                                <!-- Special Requests -->
                                <div class="mb-6">
                                    <label for="special_requests" class="block text-gray-300 text-sm font-medium mb-2">
                                        Specjalne życzenia
                                    </label>
                                    <textarea id="special_requests" name="special_requests" rows="4"
                                              class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-500 focus:outline-none transition-colors resize-vertical"
                                              placeholder="Dieta, uczulenia, potrzeby specjalne...">{{ old('special_requests') }}</textarea>
                                </div>

                                <!-- Payment Method -->
                                <div class="mb-8">
                                    <label class="block text-gray-300 text-sm font-medium mb-3">
                                        Metoda płatności *
                                    </label>
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <div>
                                            <input type="radio" id="payment_card" name="payment_method" value="card"
                                                   class="peer sr-only" {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                                            <label for="payment_card"
                                                   class="block bg-gray-700 border-2 border-gray-600 rounded-lg p-4 cursor-pointer hover:bg-gray-600 peer-checked:border-blue-500 peer-checked:bg-blue-900/30 transition-all text-center">
                                                <span class="block text-2xl mb-2">💳</span>
                                                <span class="text-white font-medium">Karta płatnicza</span>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="radio" id="payment_transfer" name="payment_method" value="bank_transfer"
                                                   class="peer sr-only" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                            <label for="payment_transfer"
                                                   class="block bg-gray-700 border-2 border-gray-600 rounded-lg p-4 cursor-pointer hover:bg-gray-600 peer-checked:border-blue-500 peer-checked:bg-blue-900/30 transition-all text-center">
                                                <span class="block text-2xl mb-2">🏦</span>
                                                <span class="text-white font-medium">Przelew bankowy</span>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="radio" id="payment_paypal" name="payment_method" value="paypal"
                                                   class="peer sr-only" {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                                            <label for="payment_paypal"
                                                   class="block bg-gray-700 border-2 border-gray-600 rounded-lg p-4 cursor-pointer hover:bg-gray-600 peer-checked:border-blue-500 peer-checked:bg-blue-900/30 transition-all text-center">
                                                <span class="block text-2xl mb-2">💰</span>
                                                <span class="text-white font-medium">PayPal</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white py-4 rounded-lg font-bold text-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                    🚀 Przejdź do płatności
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Booking Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700 sticky top-24">
                            <h3 class="text-xl font-bold mb-4 text-white">Podsumowanie</h3>

                            <div id="booking-summary" class="space-y-4">
                                <div class="text-gray-400 text-center py-8">
                                    <span class="text-4xl block mb-2">🎯</span>
                                    Wybierz destynację, aby zobaczyć podsumowanie
                                </div>
                            </div>

                            <!-- Security Info -->
                            <div class="mt-6 p-4 bg-green-900/30 rounded-lg border border-green-500/30">
                                <div class="flex items-start space-x-3">
                                    <span class="text-green-400 text-xl">🔒</span>
                                    <div>
                                        <p class="text-green-300 font-medium text-sm">Bezpieczne płatności</p>
                                        <p class="text-green-200 text-xs">SSL 256-bit, 100% bezpieczeństwo</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Support Info -->
                            <div class="mt-4 p-4 bg-blue-900/30 rounded-lg border border-blue-500/30">
                                <div class="flex items-start space-x-3">
                                    <span class="text-blue-400 text-xl">📞</span>
                                    <div>
                                        <p class="text-blue-300 font-medium text-sm">Wsparcie 24/7</p>
                                        <p class="text-blue-200 text-xs">+48 123 456 789</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            const form = document.getElementById('booking-form');
            const destinationInputs = document.querySelectorAll('input[name="destination_id"]');
            const participantsSelect = document.getElementById('participants');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const summaryDiv = document.getElementById('booking-summary');

            // Destination data for calculations
            const destinations = @json($destinations);

            function updateSummary() {
                const selectedDestination = document.querySelector('input[name="destination_id"]:checked');
                const participants = participantsSelect.value;
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                if (!selectedDestination) {
                    summaryDiv.innerHTML = `
                        <div class="text-gray-400 text-center py-8">
                            <span class="text-4xl block mb-2">🎯</span>
                            Wybierz destynację, aby zobaczyć podsumowanie
                        </div>
                    `;
                    return;
                }

                const destination = destinations.find(d => d.id == selectedDestination.value);
                const basePrice = destination.price;
                const totalParticipants = parseInt(participants) || 1;
                const totalPrice = basePrice * totalParticipants;

                let durationText = '';
                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    const diffTime = Math.abs(end - start);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    durationText = `${diffDays} ${diffDays === 1 ? 'dzień' : (diffDays <= 4 ? 'dni' : 'dni')}`;
                }

                summaryDiv.innerHTML = `
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <img src="${destination.image}" alt="${destination.name}" class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <h4 class="font-semibold text-white">${destination.name}</h4>
                                <p class="text-gray-400 text-sm">${destination.duration}</p>
                            </div>
                        </div>

                        <div class="border-t border-gray-600 pt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-300">Cena za osobę:</span>
                                <span class="text-white">${basePrice} zł</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-300">Liczba osób:</span>
                                <span class="text-white">${totalParticipants}</span>
                            </div>
                            ${durationText ? `
                            <div class="flex justify-between">
                                <span class="text-gray-300">Długość:</span>
                                <span class="text-white">${durationText}</span>
                            </div>
                            ` : ''}
                            ${startDate ? `
                            <div class="flex justify-between">
                                <span class="text-gray-300">Data:</span>
                                <span class="text-white">${startDate}</span>
                            </div>
                            ` : ''}
                        </div>

                        <div class="border-t border-gray-600 pt-4">
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-white">Suma:</span>
                                <span class="text-green-400">${totalPrice.toLocaleString()} zł</span>
                            </div>
                        </div>

                        <div class="text-xs text-gray-400">
                            * Cena końcowa zawiera wszystkie opłaty
                        </div>
                    </div>
                `;
            }

            // Event listeners
            destinationInputs.forEach(input => {
                input.addEventListener('change', updateSummary);
            });

            participantsSelect.addEventListener('change', updateSummary);
            startDateInput.addEventListener('change', updateSummary);
            endDateInput.addEventListener('change', updateSummary);

            // Date validation
            startDateInput.addEventListener('change', function() {
                if (this.value) {
                    const startDate = new Date(this.value);
                    const minEndDate = new Date(startDate);
                    minEndDate.setDate(minEndDate.getDate() + 1);
                    endDateInput.min = minEndDate.toISOString().split('T')[0];

                    if (endDateInput.value && new Date(endDateInput.value) <= startDate) {
                        endDateInput.value = '';
                    }
                }
            });

            // Initialize summary if destination is pre-selected
            updateSummary();
        });
    </script>
</body>
</html>
