<?php
// Nexa Landing Page - Alternative Design
// Bu dosya mevcut sistem kodlarını değiştirmeden alternatif bir index sayfası sağlar

// Oturum başlatma (Laravel session sistemi kullanılacak)
session_start();

// Sistem ayarlarını al (Laravel Settings modeli kullanılacak)
$settings = null;
if (class_exists('\App\Models\Settings')) {
    $settings = \App\Models\Settings::first();
}

// Sayfa başlığı
$title = $settings ? $settings->site_name : 'Nexa Finans';

// Meta açıklaması
$description = $settings ? $settings->site_desc : 'Modern finans platformu';

// Ana sayfa URL'si
$home_url = url('/');
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
    <meta name="keywords" content="forex, crypto, yatırım, finans, trading">
    <title><?php echo htmlspecialchars($title); ?> - Alternatif Tasarım</title>

    <!-- Favicon -->
    <link rel="icon" href="<?php echo asset('favicon.ico'); ?>" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Hero Section */
        .hero {
            padding: 6rem 0;
            text-align: center;
            color: white;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fff 0%, #e0e7ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 3rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* CTA Buttons */
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 4rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Features */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 4rem 0;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .feature-card i {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: white;
        }

        .feature-card p {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Stats */
        .stats {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 3rem 0;
            margin: 4rem 0;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }

        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            padding: 3rem 0 2rem;
            margin-top: 4rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h4 {
            color: white;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .footer-section a,
        .footer-section p {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: #667eea;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="#" class="logo">
                    <i class="fas fa-gem"></i> <?php echo htmlspecialchars($title); ?>
                </a>
                <ul class="nav-links">
                    <li><a href="#features">Özellikler</a></li>
                    <li><a href="#about">Hakkımızda</a></li>
                    <li><a href="#contact">İletişim</a></li>
                    <li><a href="<?php echo $home_url; ?>" class="btn btn-secondary">Ana Site</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Geleceğin Finans Platformu</h1>
            <p>Modern teknoloji ile güçlendirilmiş, kullanıcı dostu arayüzü ile forex ve crypto trading deneyimini yeniden tanımlıyoruz.</p>

            <div class="cta-buttons">
                <a href="<?php echo route('login'); ?>" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Giriş Yap
                </a>
                <a href="<?php echo route('register'); ?>" class="btn btn-secondary">
                    <i class="fas fa-user-plus"></i> Kayıt Ol
                </a>
                <a href="<?php echo $home_url; ?>" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Ana Sayfa
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="container">
        <div class="features">
            <div class="feature-card">
                <i class="fas fa-chart-line"></i>
                <h3>Gelişmiş Trading</h3>
                <p>Profesyonel araçlar ile forex, crypto ve diğer finansal enstrümanlarda trading yapın.</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Güvenlik Öncelikli</h3>
                <p>En yüksek güvenlik standartları ile yatırımlarınızı koruyoruz.</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-mobile-alt"></i>
                <h3>Mobil Uyumlu</h3>
                <p>Her yerden erişim için responsive tasarım ve mobil uygulama desteği.</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-headset"></i>
                <h3>7/24 Destek</h3>
                <p>Uzman ekibimiz ile kesintisiz destek hizmetleri sunuyoruz.</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-robot"></i>
                <h3>Otomatik Trading</h3>
                <p>Gelişmiş algoritmalar ile otomatik trading stratejileri oluşturun.</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-graduation-cap"></i>
                <h3>Eğitim Platformu</h3>
                <p>Kapsamlı eğitim materyalleri ile trading bilginizi geliştirin.</p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="container">
        <div class="stats">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>10,000+</h3>
                    <p>Aktif Kullanıcı</p>
                </div>
                <div class="stat-item">
                    <h3>$50M+</h3>
                    <p>İşlem Hacmi</p>
                </div>
                <div class="stat-item">
                    <h3>150+</h3>
                    <p>Ülke Desteği</p>
                </div>
                <div class="stat-item">
                    <h3>99.9%</h3>
                    <p>Çalışma Süresi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4><?php echo htmlspecialchars($title); ?></h4>
                    <p>Modern finans platformu ile geleceğin trading deneyimini yaşayın.</p>
                </div>

                <div class="footer-section">
                    <h4>Hızlı Erişim</h4>
                    <a href="<?php echo route('login'); ?>">Giriş Yap</a>
                    <a href="<?php echo route('register'); ?>">Kayıt Ol</a>
                    <a href="<?php echo route('about'); ?>">Hakkımızda</a>
                    <a href="<?php echo route('contact'); ?>">İletişim</a>
                </div>

                <div class="footer-section">
                    <h4>Hizmetler</h4>
                    <a href="<?php echo route('trade'); ?>">Trading</a>
                    <a href="<?php echo route('automate'); ?>">Otomatik Trading</a>
                    <a href="<?php echo route('copy'); ?>">Copy Trading</a>
                    <a href="#">Eğitim</a>
                </div>

                <div class="footer-section">
                    <h4>İletişim</h4>
                    <p>
                        <i class="fas fa-envelope"></i>
                        <?php echo $settings ? $settings->contact_email : 'info@nexa-finans.com'; ?>
                    </p>
                    <p>
                        <i class="fas fa-phone"></i>
                        <?php echo $settings ? $settings->phone : '+90 555 123 4567'; ?>
                    </p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 <?php echo htmlspecialchars($title); ?>. Tüm hakları saklıdır.</p>
                <p>
                    <a href="<?php echo route('terms'); ?>">Kullanım Şartları</a> |
                    <a href="<?php echo route('privacy'); ?>">Gizlilik Politikası</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Custom Scripts -->
    <script src="assets/js/script.js"></script>

    <!-- Scripts -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to header
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.15)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.1)';
            }
        });
    </script>
</body>
</html>