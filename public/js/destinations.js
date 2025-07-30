document.addEventListener('DOMContentLoaded', function() {
    // Navigation scroll effect
    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;

        if (scrolled > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking on links
        mobileMenu.addEventListener('click', (e) => {
            if (e.target.tagName === 'A') {
                mobileMenu.classList.add('hidden');
            }
        });
    }

    // Particles animation
    function createParticles() {
        const particlesContainer = document.getElementById('particles');
        if (!particlesContainer) return;

        setInterval(() => {
            if (window.innerWidth > 768) {
                const particle = document.createElement('div');
                particle.className = 'particle';

                const size = Math.random() * 3 + 1;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.background = `rgba(${59 + Math.random() * 100}, ${130 + Math.random() * 100}, 246, ${Math.random() * 0.5 + 0.3})`;
                particle.style.position = 'absolute';
                particle.style.borderRadius = '50%';
                particle.style.pointerEvents = 'none';
                particle.style.animation = `particleFloat ${Math.random() * 4 + 4}s linear infinite`;

                particlesContainer.appendChild(particle);

                setTimeout(() => {
                    if (particle.parentNode) {
                        particle.parentNode.removeChild(particle);
                    }
                }, 8000);
            }
        }, 200);
    }

    createParticles();

    // Filters functionality
    const filtersForm = document.getElementById('destination-filters');
    const destinationsGrid = document.getElementById('destinations-grid');
    const destinationCards = document.querySelectorAll('.destination-card');
    const resultsCount = document.getElementById('results-count');
    const sortSelect = document.getElementById('sort-destinations');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const priceSliders = document.querySelectorAll('.price-slider');
    const priceMinDisplay = document.getElementById('price-min-display');
    const priceMaxDisplay = document.getElementById('price-max-display');

    // Price range sliders
    priceSliders.forEach(slider => {
        slider.addEventListener('input', updatePriceDisplay);
    });

    function updatePriceDisplay() {
        const minSlider = document.querySelector('input[name="price_min"]');
        const maxSlider = document.querySelector('input[name="price_max"]');

        if (minSlider && maxSlider && priceMinDisplay && priceMaxDisplay) {
            let minVal = parseInt(minSlider.value);
            let maxVal = parseInt(maxSlider.value);

            // Ensure min doesn't exceed max
            if (minVal >= maxVal) {
                minVal = maxVal - 100;
                minSlider.value = minVal;
            }

            priceMinDisplay.textContent = minVal;
            priceMaxDisplay.textContent = maxVal;
        }
    }

    // Initialize price display
    updatePriceDisplay();

    // Filter destinations
    function filterDestinations() {
        const formData = new FormData(filtersForm);
        const filters = {
            region: formData.get('region'),
            type: formData.get('type'),
            duration: formData.get('duration'),
            rating: formData.get('rating'),
            priceMin: parseInt(formData.get('price_min')) || 0,
            priceMax: parseInt(formData.get('price_max')) || 5000
        };

        let visibleCount = 0;

        destinationCards.forEach(card => {
            const cardData = {
                region: card.getAttribute('data-region'),
                type: card.getAttribute('data-type'),
                duration: card.getAttribute('data-duration'),
                rating: parseFloat(card.getAttribute('data-rating')),
                price: parseInt(card.getAttribute('data-price'))
            };

            let shouldShow = true;

            // Apply filters
            if (filters.region && cardData.region !== filters.region) {
                shouldShow = false;
            }

            if (filters.type && cardData.type !== filters.type) {
                shouldShow = false;
            }

            if (filters.duration) {
                const cardDuration = cardData.duration;
                switch (filters.duration) {
                    case '1':
                        if (!cardDuration.includes('1 dzień')) shouldShow = false;
                        break;
                    case '2-3':
                        if (!cardDuration.includes('2') && !cardDuration.includes('3')) shouldShow = false;
                        break;
                    case '4-7':
                        if (!cardDuration.match(/[4-7]/)) shouldShow = false;
                        break;
                    case '7+':
                        if (!cardDuration.includes('tydzień') && !cardDuration.match(/[8-9]|[1-9][0-9]/)) shouldShow = false;
                        break;
                }
            }

            if (filters.rating && cardData.rating < filters.rating) {
                shouldShow = false;
            }

            if (cardData.price < filters.priceMin || cardData.price > filters.priceMax) {
                shouldShow = false;
            }

            // Show/hide card with animation
            if (shouldShow) {
                card.style.display = 'block';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
                visibleCount++;
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });

        // Update results count
        if (resultsCount) {
            resultsCount.textContent = visibleCount;
        }

        // Show/hide no results message
        showNoResultsMessage(visibleCount === 0);
    }

    // Show no results message
    function showNoResultsMessage(show) {
        let noResultsMsg = document.getElementById('no-results-message');

        if (show && !noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.id = 'no-results-message';
            noResultsMsg.className = 'no-results-message';
            noResultsMsg.innerHTML = `
                <div class="no-results-content">
                    <svg class="no-results-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <h3>Nie znaleziono destynacji</h3>
                    <p>Spróbuj zmienić filtry lub przeglądnij wszystkie dostępne oferty</p>
                    <button class="btn-primary" onclick="clearAllFilters()">Wyczyść filtry</button>
                </div>
            `;
            destinationsGrid.appendChild(noResultsMsg);
        } else if (!show && noResultsMsg) {
            noResultsMsg.remove();
        }
    }

    // Sort destinations
    function sortDestinations() {
        const sortBy = sortSelect.value;
        const cardsArray = Array.from(destinationCards);

        cardsArray.sort((a, b) => {
            switch (sortBy) {
                case 'price_low':
                    return parseInt(a.getAttribute('data-price')) - parseInt(b.getAttribute('data-price'));
                case 'price_high':
                    return parseInt(b.getAttribute('data-price')) - parseInt(a.getAttribute('data-price'));
                case 'rating':
                    return parseFloat(b.getAttribute('data-rating')) - parseFloat(a.getAttribute('data-rating'));
                case 'name':
                    return a.querySelector('.destination-name').textContent.localeCompare(
                        b.querySelector('.destination-name').textContent
                    );
                case 'duration':
                    // Simple duration sorting (could be improved)
                    return a.getAttribute('data-duration').localeCompare(b.getAttribute('data-duration'));
                default: // popular
                    return 0; // Keep original order for popularity
            }
        });

        // Reorder cards in DOM
        cardsArray.forEach(card => {
            destinationsGrid.appendChild(card);
        });

        // Animate reordering
        cardsArray.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('fade-in-up');
        });
    }

    // Clear all filters
    function clearAllFilters() {
        filtersForm.reset();
        updatePriceDisplay();
        destinationCards.forEach(card => {
            card.style.display = 'block';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        });

        if (resultsCount) {
            resultsCount.textContent = destinationCards.length;
        }

        showNoResultsMessage(false);
        showNotification('Filtry zostały wyczyszczone', 'success');
    }

    // Make clearAllFilters global for the no-results button
    window.clearAllFilters = clearAllFilters;

    // Event listeners
    if (filtersForm) {
        filtersForm.addEventListener('submit', (e) => {
            e.preventDefault();
            filterDestinations();
            showNotification('Filtry zostały zastosowane', 'success');
        });

        // Real-time filtering for some inputs
        filtersForm.addEventListener('change', (e) => {
            if (e.target.type === 'range' || e.target.type === 'radio') {
                filterDestinations();
            }
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', sortDestinations);
    }

    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', clearAllFilters);
    }

    // Favorite functionality
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();

            this.classList.toggle('active');
            const destinationId = this.getAttribute('data-destination');

            if (this.classList.contains('active')) {
                showNotification('Dodano do ulubionych', 'success');
                // Save to localStorage or send to server
                saveFavorite(destinationId);
            } else {
                showNotification('Usunięto z ulubionych', 'info');
                removeFavorite(destinationId);
            }
        });
    });

    // Load more functionality
    const loadMoreBtn = document.getElementById('load-more');
    let currentPage = 1;
    const itemsPerPage = 6;

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            this.innerHTML = 'Ładowanie... <div class="loading-spinner"></div>';

            // Simulate loading more destinations
            setTimeout(() => {
                // In a real app, this would fetch more data from the server
                showNotification('Ładowanie kolejnych destynacji...', 'info');
                currentPage++;

                // Reset button text
                this.innerHTML = `
                    Załaduj więcej destynacji
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                `;

                // Hide button if no more items (simulation)
                if (currentPage >= 3) {
                    this.style.display = 'none';
                    showNotification('Wszystkie destynacje zostały załadowane', 'info');
                }
            }, 1500);
        });
    }

    // Newsletter form
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;

            if (email && email.includes('@')) {
                showNotification('Dziękujemy za zapisanie się do newslettera!', 'success');
                this.reset();
            } else {
                showNotification('Proszę podać prawidłowy adres email.', 'error');
            }
        });
    }

    // Destination card interactions
    document.querySelectorAll('.destination-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Add scroll animations to destination cards
    destinationCards.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
        observer.observe(el);
    });

    // Utility functions
    function saveFavorite(destinationId) {
        let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        if (!favorites.includes(destinationId)) {
            favorites.push(destinationId);
            localStorage.setItem('favorites', JSON.stringify(favorites));
        }
    }

    function removeFavorite(destinationId) {
        let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        favorites = favorites.filter(id => id !== destinationId);
        localStorage.setItem('favorites', JSON.stringify(favorites));
    }

    function loadFavorites() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        favorites.forEach(destinationId => {
            const btn = document.querySelector(`[data-destination="${destinationId}"].favorite-btn`);
            if (btn) {
                btn.classList.add('active');
            }
        });
    }

    // Notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg text-white transition-all duration-300 transform translate-x-full max-w-sm`;

        switch(type) {
            case 'success':
                notification.classList.add('bg-green-600');
                break;
            case 'error':
                notification.classList.add('bg-red-600');
                break;
            default:
                notification.classList.add('bg-blue-600');
        }

        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="flex-1">${message}</div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Animate out and remove
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }

    // Initialize favorites
    loadFavorites();

    // Search functionality for mobile filters toggle
    const filtersToggle = document.getElementById('filters-toggle');
    if (filtersToggle) {
        filtersToggle.addEventListener('click', function() {
            const filtersForm = document.querySelector('.filters-form');
            filtersForm.style.display = filtersForm.style.display === 'none' ? 'grid' : 'none';
        });
    }

    // Add particle float animation via CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) scale(1);
                opacity: 0;
            }
        }

        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .no-results-message {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(30, 41, 59, 0.5);
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .no-results-content {
            max-width: 400px;
            margin: 0 auto;
        }

        .no-results-icon {
            width: 4rem;
            height: 4rem;
            color: #6b7280;
            margin: 0 auto 1rem;
        }

        .no-results-content h3 {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .no-results-content p {
            color: #9ca3af;
            margin-bottom: 2rem;
        }
    `;
    document.head.appendChild(style);

    // Keyboard accessibility
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (!mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
            }
        }
    });

    // Performance monitoring
    window.addEventListener('load', function() {
        const loadTime = performance.now();
        console.log(`Destinations page loaded in ${loadTime.toFixed(2)}ms`);
    });
});
