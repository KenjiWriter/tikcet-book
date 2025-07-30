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

    // Add scroll animations to elements
    document.querySelectorAll('.destination-card, .travel-type-card, .stat-item').forEach((el, index) => {
        el.classList.add('fade-in-up');
        el.style.transitionDelay = `${index * 0.1}s`;
        observer.observe(el);
    });

    // Counter animation for statistics
    function animateCounters() {
        const counters = document.querySelectorAll('[data-count]');

        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count'));
            const increment = target / 60;
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

            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCounter();
                        counterObserver.unobserve(entry.target);
                    }
                });
            });

            counterObserver.observe(counter);
        });
    }

    animateCounters();

    // Destination card interactions - przekierowanie do szczegółów
    document.querySelectorAll('.destination-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });

        card.addEventListener('click', function() {
            const destinationId = this.getAttribute('data-destination');
            window.location.href = `/destinations/${destinationId}`;
        });
    });

    // Functional search form handling
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const query = this.querySelector('input[type="text"]').value;
            const date = this.querySelector('input[type="date"]').value;
            const travelers = this.querySelector('select').value;

            // Przekieruj do strony wyszukiwania z parametrami
            const params = new URLSearchParams();
            if (query) params.append('query', query);
            if (date) params.append('date', date);
            if (travelers) params.append('travelers', travelers);

            window.location.href = `/search?${params.toString()}`;
        });
    }

    // Newsletter form handling
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

        notification.textContent = message;
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

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Travel type card interactions - przekierowanie do doświadczeń
    document.querySelectorAll('.travel-type-card').forEach(card => {
        card.addEventListener('click', function() {
            window.location.href = '/attractions';
        });
    });

    // CTA Buttons functionality
    document.querySelectorAll('.btn-primary').forEach(button => {
        if (button.textContent.includes('Zaplanuj wycieczkę')) {
            button.addEventListener('click', function() {
                window.location.href = '/destinations';
            });
        }

        if (button.textContent.includes('Zarezerwuj teraz')) {
            button.addEventListener('click', function() {
                window.location.href = '/destinations';
            });
        }
    });

    // Zobacz oferty button
    document.querySelectorAll('.btn-secondary, .btn-outline').forEach(button => {
        if (button.textContent.includes('Zobacz oferty') || button.textContent.includes('Zobacz wszystkie')) {
            button.addEventListener('click', function() {
                window.location.href = '/destinations';
            });
        }
    });

    // Parallax effect for hero section
    const hero = document.getElementById('hero');
    if (hero) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroHeight = hero.offsetHeight;

            if (scrolled < heroHeight) {
                hero.style.transform = `translateY(${scrolled * 0.3}px)`;
            }
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
    `;
    document.head.appendChild(style);

    // Keyboard accessibility
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
        }
    });

    // Performance monitoring
    window.addEventListener('load', function() {
        const loadTime = performance.now();
        console.log(`PolskaTour loaded in ${loadTime.toFixed(2)}ms`);
    });
});
