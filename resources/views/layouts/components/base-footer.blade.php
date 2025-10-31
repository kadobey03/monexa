<footer class="bg-gray-900 text-gray-300 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Company Info -->
            <div>
                <div class="flex items-center mb-6">
                    @isset($settings)
                        <img class="h-8 w-auto" src="{{ asset('storage/'.$settings->logo) }}" alt="{{ $settings->site_name }}">
                        <span class="ml-3 text-white font-semibold">{{ $settings->site_name }}</span>
                    @else
                        <span class="text-white font-semibold">Monexa</span>
                    @endisset
                </div>
                <p class="text-sm text-gray-400">
                    Profesyonel CFD trading platform. Hızlı execution ve rekabetçi spreadlerle işlem yapın.
                </p>
            </div>

            <!-- Trading -->
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Ticaret</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('cryptocurrencies') }}" class="text-sm text-gray-400 hover:text-white transition">Kripto Paralar</a></li>
                    <li><a href="{{ route('forex') }}" class="text-sm text-gray-400 hover:text-white transition">Döviz</a></li>
                    <li><a href="{{ route('shares') }}" class="text-sm text-gray-400 hover:text-white transition">Hisseler</a></li>
                    <li><a href="{{ route('indices') }}" class="text-sm text-gray-400 hover:text-white transition">Endeksler</a></li>
                </ul>
            </div>

            <!-- Company -->
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Şirket</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('about') }}" class="text-sm text-gray-400 hover:text-white transition">Hakkımızda</a></li>
                    <li><a href="{{ route('why-us') }}" class="text-sm text-gray-400 hover:text-white transition">Neden Biz</a></li>
                    <li><a href="{{ route('faq') }}" class="text-sm text-gray-400 hover:text-white transition">SSS</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm text-gray-400 hover:text-white transition">İletişim</a></li>
                </ul>
            </div>

            <!-- Account -->
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Hesap</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white transition">Giriş Yap</a></li>
                    <li><a href="{{ route('register') }}" class="text-sm text-gray-400 hover:text-white transition">Kayıt Ol</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition">Demo Hesap</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 mt-8 pt-8">
            <div class="text-xs text-gray-400">
                <p class="mb-4">
                    <span class="font-semibold text-gray-300">RİSK UYARISI:</span> 
                    CFD işlemleri yüksek risk içerir ve tüm yatırımcılar için uygun olmayabilir.
                </p>
                <div class="flex flex-wrap gap-4 mb-4">
                    <a href="{{ route('terms') }}" class="text-blue-400 hover:text-blue-300 transition">Şartlar ve Koşullar</a>
                    <a href="{{ route('privacy') }}" class="text-blue-400 hover:text-blue-300 transition">Gizlilik Politikası</a>
                </div>
                <p>© {{ date('Y') }} {{ isset($settings) ? $settings->site_name : 'Monexa' }}. Tüm Hakları Saklıdır.</p>
            </div>
        </div>
    </div>
</footer>