# MonexaFinans - Robots.txt
# Production güvenlik ve SEO yapılandırması
# {{ $environment }} ortamı için

# User-agent tanımlamaları
User-agent: *
@if($environment === 'production')
    # Production ortamı - güvenlik odaklı yapılandırma
    
    # Finansal ve admin alanlarını tamamen engelle
    Disallow: /admin/
    Disallow: /admin
    Disallow: /api/
    Disallow: /api
    Disallow: /dashboard/
    Disallow: /dashboard
    Disallow: /settings/
    Disallow: /settings
    Disallow: /profile/
    Disallow: /profile
    Disallow: /account/
    Disallow: /account
    Disallow: /security/
    Disallow: /security
    Disallow: /kyc/
    Disallow: /kyc
    Disallow: /deposits/
    Disallow: /deposits
    Disallow: /withdrawals/
    Disallow: /withdrawals
    Disallow: /investments/
    Disallow: /investments
    Disallow: /trading/
    Disallow: /trading
    Disallow: /wallet/
    Disallow: /wallet
    Disallow: /notifications/
    Disallow: /notifications
    Disallow: /leads/
    Disallow: /leads
    Disallow: /reports/
    Disallow: /reports
    Disallow: /analytics/
    Disallow: /analytics
    
    # Sistem dosyaları ve güvenlik kritik alanlar
    Disallow: /.env
    Disallow: /composer.json
    Disallow: /composer.lock
    Disallow: /package.json
    Disallow: /package-lock.json
    Disallow: /webpack.mix.js
    Disallow: /.git/
    Disallow: /node_modules/
    Disallow: /storage/
    Disallow: /bootstrap/cache/
    Disallow: /vendor/
    Disallow: /config/
    Disallow: /database/
    Disallow: /tests/
    Disallow: /.idea/
    Disallow: /.vscode/
    
    # CRON ve güvenlik endpoint'leri
    Disallow: /cron
    Disallow: /run-crypto-update
    Disallow: /run-market-update
    Disallow: /fetchMarket
    Disallow: /copytrade
    
    # Özel dosyalar
    Disallow: /phpinfo.php
    Disallow: /test.php
    Disallow: /info.php
    Disallow: /.php
    
    # Sitemap konumu
    Sitemap: {{ config('app.url') }}/sitemap.xml
    
    # Crawl delay - sunucu yükünü azalt
    Crawl-delay: 10
    
    # Güvenlik botlarını允许 et
    User-agent: Googlebot
    Allow: /
    Crawl-delay: 5
    
    User-agent: Bingbot
    Allow: /
    Crawl-delay: 5
    
    # Şüpheli botları engelle
    User-agent: SemrushBot
    Disallow: /
    
    User-agent: AhrefsBot
    Disallow: /
    
    User-agent: MJ12bot
    Disallow: /
    
    User-agent: DotBot
    Disallow: /
    
    User-agent: BLEXBot
    Disallow: /
    
    User-agent: MegaIndex
    Disallow: /
    
    User-agent: spbot
    Disallow: /
    
    User-agent: TurnitinBot
    Disallow: /
    
    User-agent: PaperLiBot
    Disallow: /
    
    User-agent: SiteAuditBot
    Disallow: /
    
    # Social media botları
    User-agent: facebookexternalhit
    Allow: /
    
    User-agent: Twitterbot
    Allow: /
    
    User-agent: LinkedInBot
    Allow: /
    
    User-agent: WhatsApp
    Allow: /
    
@else
    # Development ortamı - tüm botları engelle
    User-agent: *
    Disallow: /
    
    # Sadece localhost erişimi
    Allow: /$
    Allow: /index
    Allow: /about
    Allow: /terms
    Allow: /privacy
    Allow: /contact
    
@endif

# Son güncelleme tarihi
# Bu dosya otomatik olarak güncellenmektedir
# Generated on: {{ date('Y-m-d H:i:s') }}