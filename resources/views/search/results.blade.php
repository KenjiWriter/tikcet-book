<!DOCTYPE html>
<html lang="pl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Wyniki wyszukiwania destynacji w Polsce - PolskaTour">
    <title>Wyszukiwanie: {{ $query }} - PolskaTour</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/app.js', 'resources/js/search.js'])
</head>
<body class="bg-black text-white antialiased">
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
                    <a href="#about" class="nav-link">O nas</a>
                    <a href="#contact" class="nav-link">Kontakt</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Search Header -->
    <section class="pt-24 pb-8 bg-gray-900">
        <div class="container mx-auto px-6">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-400 mb-6">
                <a href="/" class="hover:text-white">Strona główna</a>
                <span class="mx-2">/</span>
                <span class="text-white">Wyszukiwanie</span>
            </nav>

            <!-- Search Form -->
            <div class="bg-gray-800 rounded-2xl p-6 mb-8">
                <form method="GET" action="{{ route('search') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Gdzie?</label>
                        <input type="text" name="query" value="{{ $query }}" placeholder="Wpisz nazwę miejsca..." class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Kiedy?</label>
                        <input type="date" name="date" value="{{ $date }}" class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Ile osób?</label>
                        <select name="travelers" class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-400 focus:outline-none">
                            @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ $travelers == $i ? 'selected' : '' }}>
                                {{ $i }} {{ $i == 1 ? 'osoba' : ($i <= 4 ? 'osoby' : 'osób') }}
                            </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Kategoria</label>
                        <select name="category" class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 border border-gray-600 focus:border-blue-400 focus:outline-none">
                            @foreach($categories as $key => $name)
                            <option value="{{ $key }}" {{ $category == $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            Szukaj
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold mb-2">
                        @if($query)
                            Wyniki dla: "{{ $query }}"
                        @else
                            Wszystkie destynacje
                        @endif
                    </h1>
                    <p class="text-gray-400">Znaleziono {{ count($results) }} {{ count($results) == 1 ? 'wynik' : (count($results) <= 4 ? 'wyniki' : 'wyników') }}</p>
                </div>

                <!-- Filters -->
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <div class="relative">
                        <button id="price-filter-btn" class="bg-gray-700 text-white px-4 py-2 rounded-lg border border-gray-600 hover:border-blue-400">
                            Cena: {{ $priceMin }}-{{ $priceMax }} zł
                            <svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="price-filter-dropdown" class="absolute right-0 mt-2 w-64 bg-gray-800 rounded-lg shadow-xl border border-gray-700 hidden z-10">
                            <div class="p-4">
                                <form method="GET" action="{{ route('search') }}">
                                    <input type="hidden" name="query" value="{{ $query }}">
                                    <input type="hidden" name="date" value="{{ $date }}">
                                    <input type="hidden" name="travelers" value="{{ $travelers }}">
                                    <input type="hidden" name="category" value="{{ $category }}">

                                    <div class="mb-4">
                                        <label class="block text-sm text-gray-300 mb-2">Cena od:</label>
                                        <input type="range" name="price_min" min="0" max="500" value="{{ $priceMin }}" class="w-full">
                                        <div class="flex justify-between text-xs text-gray-400">
                                            <span>0 zł</span>
                                            <span>500 zł</span>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm text-gray-300 mb-2">Cena do:</label>
                                        <input type="range" name="price_max" min="100" max="1000" value="{{ $priceMax }}" class="w-full">
                                        <div class="flex justify-between text-xs text-gray-400">
                                            <span>100 zł</span>
                                            <span>1000 zł</span>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                                        Zastosuj
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <select id="sort-select" onchange="sortResults(this.value)" class="bg-gray-700 text-white px-4 py-2 rounded-lg border border-gray-600 hover:border-blue-400">
                        <option value="relevance">Trafność</option>
                        <option value="price-asc">Cena: rosnąco</option>
                        <option value="price-desc">Cena: malejąco</option>
                        <option value="rating">Ocena</option>
                        <option value="duration">Czas trwania</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Results -->
    <section class="py-8 bg-gray-900 min-h-screen">
        <div class="container mx-auto px-6">
            @if(count($results) > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="results-grid">
                    @foreach($results as $destination)
                    <div class="destination-card" data-price="{{ $destination['price'] }}" data-rating="{{ $destination['rating'] }}" data-duration="{{ $destination['duration'] }}">
                        <div class="destination-image">
                            <div class="destination-image-placeholder">
                                <span class="placeholder-icon">📍</span>
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
                                <button class="overlay-btn" onclick="window.location.href='/destinations/{{ $destination['id'] }}'">
                                    Zobacz szczegóły
                                </button>
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

                            <div class="flex space-x-2">
                                <a href="/destinations/{{ $destination['id'] }}" class="flex-1 border-2 border-gray-600 text-gray-300 hover:border-blue-500 hover:text-white py-3 rounded-lg font-semibold text-center transition-all duration-300">
                                    Szczegóły
                                </a>
                                <a href="/booking/{{ $destination['id'] }}" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-semibold text-center hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                    Rezerwuj
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <div class="flex space-x-2">
                        <button class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-600 disabled:opacity-50" disabled>
                            Poprzednia
                        </button>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">1</button>
                        <button class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-600">2</button>
                        <button class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-600">3</button>
                        <button class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            Następna
                        </button>
                    </div>
                </div>
            @else
                <!-- No Results -->
                <div class="text-center py-20">
                    <div class="text-6xl mb-6">🔍</div>
                    <h2 class="text-3xl font-bold mb-4">Brak wyników</h2>
                    <p class="text-gray-400 mb-8 max-w-md mx-auto">
                        Nie znaleźliśmy destynacji odpowiadających Twoim kryteriom. Spróbuj zmienić parametry wyszukiwania.
                    </p>
                    <div class="space-x-4">
                        <a href="/destinations" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all duration-300">
                            Zobacz wszystkie destynacje
                        </a>
                        <button onclick="clearFilters()" class="border-2 border-gray-600 text-gray-300 hover:border-blue-500 hover:text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                            Wyczyść filtry
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Recommended -->
    @if(count($results) > 0)
    <section class="py-16 bg-black">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Może Cię też zainteresować</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Add some recommended destinations here -->
                <div class="bg-gray-800 rounded-2xl p-6 text-center">
                    <div class="text-4xl mb-4">🏔️</div>
                    <h3 class="text-xl font-bold mb-2">Wycieczki górskie</h3>
                    <p class="text-gray-400 mb-4">Odkryj piękno polskich gór</p>
                    <a href="/search?category=mountains" class="text-blue-400 hover:text-blue-300 font-medium">
                        Zobacz więcej →
                    </a>
                </div>
                <div class="bg-gray-800 rounded-2xl p-6 text-center">
                    <div class="text-4xl mb-4">🏖️</div>
                    <h3 class="text-xl font-bold mb-2">Wybrzeże Bałtyku</h3>
                    <p class="text-gray-400 mb-4">Relaks nad polskim morzem</p>
                    <a href="/search?category=seaside" class="text-blue-400 hover:text-blue-300 font-medium">
                        Zobacz więcej →
                    </a>
                </div>
                <div class="bg-gray-800 rounded-2xl p-6 text-center">
                    <div class="text-4xl mb-4">🏛️</div>
                    <h3 class="text-xl font-bold mb-2">Zabytki i kultura</h3>
                    <p class="text-gray-400 mb-4">Poznaj polskie dziedzictwo</p>
                    <a href="/search?category=cultural" class="text-blue-400 hover:text-blue-300 font-medium">
                        Zobacz więcej →
                    </a>
                </div>
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
                        <a href="/search?category=mountains">Góry</a>
                        <a href="/search?category=seaside">Morze</a>
                        <a href="/search?category=cultural">Miasta</a>
                        <a href="/search?category=nature">Przyroda</a>
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
        </div>
    </footer>

    <script>
        // Price filter dropdown
        document.getElementById('price-filter-btn').addEventListener('click', function() {
            document.getElementById('price-filter-dropdown').classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#price-filter-btn') && !e.target.closest('#price-filter-dropdown')) {
                document.getElementById('price-filter-dropdown').classList.add('hidden');
            }
        });

        // Sort functionality
        function sortResults(sortBy) {
            const grid = document.getElementById('results-grid');
            const cards = Array.from(grid.children);

            cards.sort((a, b) => {
                switch(sortBy) {
                    case 'price-asc':
                        return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                    case 'price-desc':
                        return parseInt(b.dataset.price) - parseInt(a.dataset.price);
                    case 'rating':
                        return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
                    case 'duration':
                        return a.dataset.duration.localeCompare(b.dataset.duration);
                    default:
                        return 0;
                }
            });

            cards.forEach(card => grid.appendChild(card));
        }

        // Clear filters
        function clearFilters() {
            window.location.href = '/search';
        }

        // Update price range display
        document.querySelectorAll('input[type="range"]').forEach(range => {
            range.addEventListener('input', function() {
                const label = this.previousElementSibling;
                if (this.name === 'price_min') {
                    label.textContent = `Cena od: ${this.value} zł`;
                } else {
                    label.textContent = `Cena do: ${this.value} zł`;
                }
            });
        });
    </script>
</body>
</html>
