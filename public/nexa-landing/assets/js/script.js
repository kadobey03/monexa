// Nexa Landing - Custom JavaScript
// Bu dosya özel etkileşimler için kullanılır

document.addEventListener('DOMContentLoaded', function() {
    // Sayfa yüklendiğinde çalışacak kodlar

    // Smooth scroll için gelişmiş fonksiyon
    function smoothScroll(target, duration = 800) {
        const targetElement = document.querySelector(target);
        if (!targetElement) return;

        const targetPosition = targetElement.offsetTop;
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        let startTime = null;

        function animation(currentTime) {
            if (startTime === null) startTime = currentTime;
            const timeElapsed = currentTime - startTime;
            const run = ease(timeElapsed, startPosition, distance, duration);
            window.scrollTo(0, run);
            if (timeElapsed < duration) requestAnimationFrame(animation);
        }

        function ease(t, b, c, d) {
            t /= d / 2;
            if (t < 1) return c / 2 * t * t + b;
            t--;
            return -c / 2 * (t * (t - 2) - 1) + b;
        }

        requestAnimationFrame(animation);
    }

    // Tüm anchor linkler için smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = this.getAttribute('href');
            smoothScroll(target);
        });
    });

    // Header scroll efekti - gelişmiş versiyon
    let lastScrollTop = 0;
    const header = document.querySelector('.header');

    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > 100) {
            header.style.background = 'rgba(255, 255, 255, 0.15)';
            header.style.backdropFilter = 'blur(15px)';
        } else {
            header.style.background = 'rgba(255, 255, 255, 0.1)';
            header.style.backdropFilter = 'blur(10px)';
        }

        // Scroll yönüne göre header görünürlük
        if (scrollTop > lastScrollTop && scrollTop > 200) {
            // Aşağı scroll
            header.style.transform = 'translateY(-100%)';
        } else {
            // Yukarı scroll
            header.style.transform = 'translateY(0)';
        }

        lastScrollTop = scrollTop;
    });

    // Header için CSS transition ekleme
    header.style.transition = 'all 0.3s ease-in-out';

    // Counter animasyonu
    function animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString();
        }, 16);
    }

    // İstatistik sayıları için counter animasyonu
    const statNumbers = document.querySelectorAll('.stat-item h3');
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const text = target.textContent;
                const number = parseInt(text.replace(/[^0-9]/g, ''));

                if (number > 0) {
                    animateCounter(target, number);
                    observer.unobserve(target);
                }
            }
        });
    }, observerOptions);

    statNumbers.forEach(stat => {
        observer.observe(stat);
    });

    // Loading buton efekti
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.href && !this.href.includes('#')) {
                this.classList.add('loading');
                // Gerçek navigasyon olursa loading kalkar
                setTimeout(() => {
                    this.classList.remove('loading');
                }, 1000);
            }
        });
    });

    // Feature card'lar için parallax efekti
    const featureCards = document.querySelectorAll('.feature-card');

    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;

        featureCards.forEach((card, index) => {
            const cardOffset = index * 50;
            card.style.transform = `translateY(${rate + cardOffset}px)`;
        });
    });

    // Tema değiştirme fonksiyonu (gelecekte kullanılabilir)
    function toggleTheme(theme = 'auto') {
        const body = document.body;

        if (theme === 'auto') {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            theme = prefersDark ? 'dark' : 'light';
        }

        body.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
    }

    // Tema değişikliğini dinle
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.addListener(() => {
        if (document.body.getAttribute('data-theme') === 'auto') {
            toggleTheme('auto');
        }
    });

    // Sayfa yüklendiğinde kaydedilmiş temayı uygula
    const savedTheme = localStorage.getItem('theme') || 'auto';
    toggleTheme(savedTheme);

    // Performans optimizasyonu - throttle scroll eventi
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }

    // Throttled scroll event
    const throttledScroll = throttle(function() {
        // Scroll bazlı işlemler burada
    }, 16);

    window.addEventListener('scroll', throttledScroll);

    // Sayfa görünürlük değiştiğinde performans optimizasyonu
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            // Sayfa gizlendiğinde animasyonları durdur
            document.body.classList.add('paused');
        } else {
            // Sayfa göründüğünde animasyonları devam ettir
            document.body.classList.remove('paused');
        }
    });

    // Hata yakalama ve raporlama
    window.addEventListener('error', function(e) {
        console.error('Nexa Landing Error:', e.error);
        // İsteğe bağlı olarak hata raporlama servisi çağrılabilir
    });

    // Console mesajı
    console.log('%c🚀 Nexa Landing Page Yüklendi!', 'color: #667eea; font-size: 16px; font-weight: bold;');
    console.log('%cModern ve şık tasarım ile finans platformunuz hazır.', 'color: #764ba2; font-size: 12px;');
});