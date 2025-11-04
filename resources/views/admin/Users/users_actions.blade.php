 <!-- Top Up Modal -->
 <div id="topupModal" x-data="{ open: false }" x-show="open" @open-topup-modal.window="open = true"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="open = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
             <div class="bg-blue-600 dark:bg-blue-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="wallet" class="h-5 w-5 mr-2" />{{ $user->name }} Hesabına Kredi/Debit Uygula
                 </h4>
                 <button @click="open = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('topup') }}">
                     @csrf
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="currency-dollar" class="h-4 w-4 inline mr-2 text-blue-600" />Tutar
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" placeholder="Tutar girin" type="number" name="amount" min="0.01" step="0.01" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="arrow-path" class="h-4 w-4 inline mr-2 text-blue-600" />Hesap Türü
                             </label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" name="type" required>
                                 <option value="" selected disabled>Hesap Türünü Seçin</option>
                                 <option value="Bonus">💰 Prim</option>
                                 <option value="Profit">📈 Kâr</option>
                                 <option value="Ref_Bonus">👥 Referans Primi</option>
                                 <option value="balance">💳 Hesap Bakiyesi</option>
                                 <option value="Deposit">🏦 Yatırılan Tutar</option>
                             </select>
                         </div>
                     </div>
                     <div class="mt-6">
                         <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                             <x-heroicon name="plus-circle" class="h-4 w-4 inline mr-2 text-blue-600" />İşlem Türü
                         </label>
                         <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" name="t_type" required>
                             <option value="" selected disabled>İşlem Türünü Seçin</option>
                             <option value="Credit">➕ Bakiye Ekle</option>
                             <option value="Debit">➖ Bakiye Azalt</option>
                         </select>
                         <div class="mt-2 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-md">
                             <p class="text-sm text-yellow-800 dark:text-yellow-300"><x-heroicon name="exclamation-triangle" class="h-4 w-4 inline mr-1" /> <strong>Not:</strong> Depozitoları borçlandıramazsınız</p>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                             <x-heroicon name="check" class="h-4 w-4 mr-2" />İşlemi Gerçekleştir
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Edit User Modal -->
 <div id="editModal" x-data="{ open: false }" x-show="open" @open-edit-modal.window="open = true" 
      x-transition:enter="transition ease-out duration-300" 
      x-transition:enter-start="opacity-0" 
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200" 
      x-transition:leave-start="opacity-100" 
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="open = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
             <div class="bg-green-600 dark:bg-green-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="user-pen" class="h-5 w-5 mr-2" />{{ $user->name }} Kullanıcısını Düzenle
                 </h4>
                 <button @click="open = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('edituser') }}">
                     @csrf
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="user" class="h-4 w-4 inline mr-2 text-green-600" />Kullanıcı Adı
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->username }}" type="text" name="username" pattern="[a-zA-Z0-9_]{3,50}" maxlength="50" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="user-circle" class="h-4 w-4 inline mr-2 text-green-600" />Ad Soyad
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->name }}" type="text" name="name" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="envelope" class="h-4 w-4 inline mr-2 text-green-600" />E-posta Adresi
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->email }}" type="email" name="email" maxlength="100" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="phone" class="h-4 w-4 inline mr-2 text-green-600" />Telefon Numarası
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->phone }}" type="tel" name="phone" pattern="[+]?[0-9\s\-\(\)]{10,20}" maxlength="20" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="flag" class="h-4 w-4 inline mr-2 text-green-600" />Ülke
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->country }}" type="text" name="country">
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="coins" class="h-4 w-4 inline mr-2 text-green-600" />Para Birimi
                             </label>
                             <input name="s_currency" value="{{$user->currency}}" type="hidden">
                             <select name="currency" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white">
                                 <option value="{{$user->currency}}">{{ $user->currency }}</option>
                                 @foreach ($currencies as $key => $currency)
                                     <option value="<?php echo html_entity_decode($currency); ?>">
                                         {{ $key . ' (' . html_entity_decode($currency) . ')' }}</option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                     <div class="mt-6">
                         <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                             <x-heroicon name="link" class="h-4 w-4 inline mr-2 text-green-600" />Referans Linki
                         </label>
                         <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->ref_link }}" type="url" name="ref_link" required>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                             <x-heroicon name="save" class="h-4 w-4 mr-2" />Kullanıcı Bilgilerini Güncelle
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Trading Modal -->
 <div id="tradingModal" x-data="{ open: false }" x-show="open" @open-trading-modal.window="open = true" 
      x-transition:enter="transition ease-out duration-300" 
      x-transition:enter-start="opacity-0" 
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200" 
      x-transition:leave-start="opacity-100" 
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="open = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
             <div class="bg-purple-600 dark:bg-purple-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="arrow-trending-up" class="h-5 w-5 mr-2" />{{ $user->name }} için Manuel İşlem
                 </h4>
                 <button @click="open = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('addhistory') }}">
                     @csrf
                     <div class="space-y-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">İşlem Tutarı</label>
                             <input type="number" name="amount" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" placeholder="İşlem tutarını giriniz {{ $user->currency }}" min="0.01" step="0.01" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Varlık Seçin</label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" name="plan" required>
                                 <option value="" selected disabled>Varlık Seçin</option>
                                 <optgroup label="Para Birimleri">
                                     <option value="EURUSD">EURUSD</option>
                                     <option value="EURJPY">EURJPY</option>
                                     <option value="USDJPY">USDJPY</option>
                                     <option value="USDCAD">USDCAD</option>
                                     <option value="AUDUSD">AUDUSD</option>
                                     <option value="AUDJPY">AUDJPY</option>
                                     <option value="NZDUSD">NZDUSD</option>
                                     <option value="GBPUSD">GBPUSD</option>
                                     <option value="GBPJPY">GBPJPY</option>
                                     <option value="USDCHF">USDCHF</option>
                                 </optgroup>
                                 <optgroup label="Kripto Para">
                                     <option value="BTCUSD">BTCUSD</option>
                                     <option value="ETHUSD">ETHUSD</option>
                                     <option value="BCHUSD">BCHUSD</option>
                                     <option value="XRPUSD">XRPUSD</option>
                                     <option value="LTCUSD">LTCUSD</option>
                                     <option value="ETHBTC">ETHBTC</option>
                                 </optgroup>
                                 <optgroup label="Hisse Senetleri">
                                     <option value="AAPL">AAPL</option>
                                     <option value="GOOGL">GOOGL</option>
                                     <option value="MSFT">MSFT</option>
                                     <option value="TSLA">TSLA</option>
                                 </optgroup>
                             </select>
                         </div>
                         <div class="grid grid-cols-2 gap-4">
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kaldıraç</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" name="leverage" required>
                                     <option selected disabled value="">Kaldıraç Seçin</option>
                                     <option value="10">1:10</option>
                                     <option value="20">1:20</option>
                                     <option value="50">1:50</option>
                                     <option value="100">1:100</option>
                                 </select>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Süre</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" name="expire" required>
                                     <option selected disabled value="">Süre Seçin</option>
                                     <option value="1 Minutes">1 Dakika</option>
                                     <option value="5 Minutes">5 Dakika</option>
                                     <option value="15 Minutes">15 Dakika</option>
                                     <option value="30 Minutes">30 Dakika</option>
                                     <option value="60 Minutes">1 Saat</option>
                                 </select>
                             </div>
                         </div>
                         <div class="grid grid-cols-2 gap-4">
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Sonuç</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" name="type" required>
                                     <option value="" selected disabled>Sonuç seçin</option>
                                     <option value="WIN">Kâr</option>
                                     <option value="LOSE">Zarar</option>
                                 </select>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">İşlem Türü</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" name="tradetype" required>
                                     <option value="" selected disabled>İşlem türü seçin</option>
                                     <option value="Buy">Al</option>
                                     <option value="Sell">Sat</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                             <x-heroicon name="arrow-trending-up" class="h-4 w-4 mr-2" />İşlem Yap
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Email Modal -->
 <div id="emailModal" x-data="{ open: false }" x-show="open" @open-email-modal.window="open = true" 
      x-transition:enter="transition ease-out duration-300" 
      x-transition:enter-start="opacity-0" 
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200" 
      x-transition:leave-start="opacity-100" 
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="open = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
             <div class="bg-indigo-600 dark:bg-indigo-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="envelope" class="h-5 w-5 mr-2" />{{ $user->name }} kullanıcısına E-posta Gönder
                 </h4>
                 <button @click="open = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <div class="mb-4 p-3 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-700 rounded-md">
                     <p class="text-sm text-indigo-800 dark:text-indigo-300"><x-heroicon name="information-circle" class="h-4 w-4 inline mr-1" />Bu mesaj <strong>{{ $user->name }}</strong> kullanıcısına gönderilecek</p>
                 </div>
                 <form method="post" action="{{ route('sendmailtooneuser') }}">
                     @csrf
                     <div class="space-y-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="type" class="h-4 w-4 inline mr-2 text-indigo-600" />E-posta Konusu
                             </label>
                             <input type="text" name="subject" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-admin-700 dark:text-white" placeholder="E-posta konusu" maxlength="100" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="message-square" class="h-4 w-4 inline mr-2 text-indigo-600" />Mesaj İçeriği
                             </label>
                             <textarea placeholder="Mesajınızı buraya yazın..." class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-admin-700 dark:text-white" name="message" rows="8" maxlength="1000" required style="resize: vertical;"></textarea>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                             <x-heroicon name="send" class="h-4 w-4 mr-2" />E-postayı Gönder
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Delete Modal -->
 <div id="deleteModal" x-data="{ open: false }" x-show="open" @open-delete-modal.window="open = true" 
      x-transition:enter="transition ease-out duration-300" 
      x-transition:enter-start="opacity-0" 
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200" 
      x-transition:leave-start="opacity-100" 
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="open = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-red-600 dark:bg-red-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="exclamation-triangle" class="h-5 w-5 mr-2" />Kullanıcı Hesabını Sil
                 </h4>
                 <button @click="open = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6 text-center">
                 <div class="mb-4">
                     <x-heroicon name="user-minus" class="mx-auto h-12 w-12 text-red-600 mb-4" />
                     <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ $user->name }}'in Hesabını Sil?</h5>
                     <p class="text-gray-600 dark:text-gray-400">
                         Bu işlem geri alınamaz. Bu hesapla ilişkili tüm veriler kalıcı olarak silinecektir.
                     </p>
                 </div>
                 <div class="flex space-x-3">
                     <button @click="resetPasswordOpen = false" class="flex-1 py-2 px-4 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                         <x-heroicon name="x-mark" class="h-4 w-4 mr-2 inline" />İptal
                     </button>
                     <a href="{{ url('admin/dashboard/delsystemuser') }}/{{ $user->id }}" onclick="return confirm('Bu işlem geri alınamaz. {{ $user->name }} kullanıcısını gerçekten silmek istiyor musunuz?')" class="flex-1 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                         <x-heroicon name="trash-2" class="h-4 w-4 mr-2" />Evet, Hesabı Sil
                     </a>
                 </div>
             </div>
         </div>

 <!-- Reset Password Modal -->
 <div id="resetPasswordModal" x-data="{ resetPasswordOpen: false }"
      x-show="resetPasswordOpen"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="resetPasswordOpen = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-yellow-500 dark:bg-yellow-600 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="key" class="h-5 w-5 mr-2" />Kullanıcı Şifresini Sıfırla
                 </h4>
                 <button @click="resetPasswordOpen = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6 text-center">
                 <div class="mb-4">
                     <x-heroicon name="lock-closed" class="mx-auto h-12 w-12 text-yellow-500 mb-4" />
                     <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ $user->name }} için Şifreyi Sıfırla?</h5>
                     <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-md">
                         <p class="text-sm text-yellow-800 dark:text-yellow-300 mb-2">Şifre şuna sıfırlanacak: <strong>user01236</strong></p>
                         <p class="text-xs text-yellow-700 dark:text-yellow-400">Kullanıcıya bu değişikliği bildirmeyi unutmayın.</p>
                     </div>
                 </div>
                 <div class="flex space-x-3">
                     <button @click="open = false" class="flex-1 py-2 px-4 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                         <x-heroicon name="x-mark" class="h-4 w-4 mr-2 inline" />İptal
                     </button>
                     <a href="{{ url('admin/dashboard/resetpswd') }}/{{ $user->id }}" onclick="return confirm('{{ $user->name }} kullanıcısının şifresini gerçekten sıfırlamak istiyor musunuz? Yeni şifre: user01236')" class="flex-1 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                         <x-heroicon name="key" class="h-4 w-4 mr-2" />Şifreyi Sıfırla
                     </a>
                 </div>
             </div>
         </div>
     </div>

 <!-- Tax Modal -->
 <div id="taxModal" x-data="{ taxOpen: false }" x-show="taxOpen" @open-tax-modal.window="taxOpen = true"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="taxOpen = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-yellow-500 dark:bg-yellow-600 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="calculator" class="h-5 w-5 mr-2" />{{ $user->name }} için Kullanıcı Vergisi
                 </h4>
                 <button @click="taxOpen = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('usertax') }}">
                     @csrf
                     <div class="grid grid-cols-2 gap-4">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Durum</label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 dark:bg-admin-700 dark:text-white" name="taxtype" required>
                                 <option value="" selected disabled>Durumu seçin</option>
                                 <option value="on">🟢 Açık</option>
                                 <option value="off">🔴 Kapalı</option>
                             </select>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Vergi Oranı (%)</label>
                             <input type="number" name="taxamount" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 dark:bg-admin-700 dark:text-white" min="0" max="100" step="0.01" placeholder="0.00">
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                             <x-heroicon name="calculator" class="h-4 w-4 mr-2" />Kullanıcı Vergisi Belirle
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Withdrawal Code Modal -->
 <div id="withdrawalCodeModal" x-data="{ withdrawalCodeOpen: false }"
      x-show="withdrawalCodeOpen"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="withdrawalCodeOpen = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-green-600 dark:bg-green-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="key" class="h-5 w-5 mr-2" />{{ $user->name }} için Para Çekme Kodu
                 </h4>
                 <button @click="withdrawalCodeOpen = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('withdrawalcode') }}">
                     @csrf
                     <div class="grid grid-cols-2 gap-4">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Para Çekme Kodu Durumu</label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" name="withdrawal_code" required>
                                 <option value="" selected disabled>Durumu seçin</option>
                                 <option value="on">🟢 Açık</option>
                                 <option value="off">🔴 Kapalı</option>
                             </select>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Para Çekme Kodu</label>
                             <input type="text" name="user_withdrawalcode" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->user_withdrawalcode }}" maxlength="50" required>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                             <x-heroicon name="key" class="h-4 w-4 mr-2" />Para Çekme Kodunu Belirle
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Notify User Modal -->
 <div id="notifyModal" x-data="{ notifyOpen: false }" x-show="notifyOpen" @open-notify-modal.window="notifyOpen = true"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="notifyOpen = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-blue-600 dark:bg-blue-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="bell" class="h-5 w-5 mr-2" />{{ $user->username }} Dashboard Bildirimi
                 </h4>
                 <button @click="notifyOpen = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <p class="text-gray-600 dark:text-gray-400 mb-4">Bu bildirim {{ $user->name }} kullanıcısının dashboard'unda görünecektir</p>
                 <form method="post" action="{{ route('notifyuser') }}">
                     @csrf
                     <div class="space-y-4">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Dashboard Bildirim Durumu: {{$user->notify}}</label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" name="notifystatus">
                                 <option value="on">Açık</option>
                                 <option value="off">Kapalı</option>
                             </select>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Bildirim Mesajı</label>
                             <textarea placeholder="Bildirim mesajınızı yazınız" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" name="notify" rows="6" maxlength="500" required></textarea>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                             <x-heroicon name="send" class="h-4 w-4 mr-2" />Bildirimi Gönder
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Number of Trades Modal -->
 <div id="tradesModal" x-data="{ tradesOpen: false }" x-show="tradesOpen" @open-trades-modal.window="tradesOpen = true"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="tradesOpen = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-cyan-600 dark:bg-cyan-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="hash" class="h-5 w-5 mr-2" />{{ $user->name }} için İşlem Sayısı Belirleme
                 </h4>
                 <button @click="tradesOpen = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('numberoftrades') }}">
                     @csrf
                     <div>
                         <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                             <x-heroicon name="arrow-path" class="h-4 w-4 inline mr-2 text-cyan-600" />Para çekme öncesi işlem sayısı
                         </label>
                         <input type="number" name="numberoftrades" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 dark:bg-admin-700 dark:text-white" placeholder="{{ $user->numberoftrades }}" min="0" required>
                         <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                             Kullanıcının para çekebilmesi için tamamlaması gereken minimum işlem sayısı
                         </p>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                             <x-heroicon name="hash" class="h-4 w-4 mr-2" />Para Çekme İçin İşlem Sayısı Belirle
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Signal Modal -->
 <div id="signalModal" x-data="{ signalOpen: false }" x-show="signalOpen" @open-signal-modal.window="signalOpen = true"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="signalOpen = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
             <div class="bg-pink-600 dark:bg-pink-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="radio" class="h-5 w-5 mr-2" />{{ $user->name }} için Sinyal Oluştur
                 </h4>
                 <button @click="signalOpen = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('addsignalhistory') }}">
                     @csrf
                     <div class="space-y-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Varlık Seçin</label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 dark:bg-admin-700 dark:text-white" name="asset" required>
                                 <option value="" selected disabled>Varlık Seçin</option>
                                 <optgroup label="Para Birimleri">
                                     <option value="EURUSD">EURUSD</option>
                                     <option value="EURJPY">EURJPY</option>
                                     <option value="USDJPY">USDJPY</option>
                                     <option value="USDCAD">USDCAD</option>
                                     <option value="AUDUSD">AUDUSD</option>
                                     <option value="AUDJPY">AUDJPY</option>
                                     <option value="NZDUSD">NZDUSD</option>
                                     <option value="GBPUSD">GBPUSD</option>
                                     <option value="GBPJPY">GBPJPY</option>
                                     <option value="USDCHF">USDCHF</option>
                                 </optgroup>
                                 <optgroup label="Kripto Para">
                                     <option value="BTCUSD">BTCUSD</option>
                                     <option value="ETHUSD">ETHUSD</option>
                                     <option value="BCHUSD">BCHUSD</option>
                                     <option value="XRPUSD">XRPUSD</option>
                                     <option value="LTCUSD">LTCUSD</option>
                                     <option value="ETHBTC">ETHBTC</option>
                                 </optgroup>
                             </select>
                         </div>
                         <div class="grid grid-cols-2 gap-4">
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kaldıraç</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 dark:bg-admin-700 dark:text-white" name="leverage" required>
                                     <option selected disabled value="">Kaldıraç Seçin</option>
                                     <option value="10">1:10</option>
                                     <option value="20">1:20</option>
                                     <option value="50">1:50</option>
                                     <option value="100">1:100</option>
                                 </select>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tutar</label>
                                 <input type="number" name="amount" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 dark:bg-admin-700 dark:text-white" placeholder="Sinyal tutarını giriniz {{ $user->currency }}" min="0.01" step="0.01" required>
                             </div>
                         </div>
                         <div class="grid grid-cols-2 gap-4">
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Süre</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 dark:bg-admin-700 dark:text-white" name="expire" required>
                                     <option selected disabled value="">Süre Seçin</option>
                                     <option value="1 Minutes">1 Dakika</option>
                                     <option value="5 Minutes">5 Dakika</option>
                                     <option value="15 Minutes">15 Dakika</option>
                                     <option value="30 Minutes">30 Dakika</option>
                                     <option value="60 Minutes">1 Saat</option>
                                     <option value="4 Hours">4 Saat</option>
                                     <option value="1 Days">1 Gün</option>
                                 </select>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Emir Türü</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 dark:bg-admin-700 dark:text-white" name="order_type" required>
                                     <option value="" selected disabled>Emir türü seçin</option>
                                     <option value="Buy">Al</option>
                                     <option value="Sell">Sat</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                             <x-heroicon name="radio" class="h-4 w-4 mr-2" />Sinyal Oluştur
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 </div>

 <!-- Switch User Modal -->
 <div id="switchUserModal" x-data="{ open: false }" x-show="open" @open-switch-user-modal.window="open = true" 
      x-transition:enter="transition ease-out duration-300" 
      x-transition:enter-start="opacity-0" 
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200" 
      x-transition:leave-start="opacity-100" 
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" @click="open = false">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-teal-600 dark:bg-teal-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="user-switch" class="h-5 w-5 mr-2" />{{ $user->name }} olarak giriş yap
                 </h4>
                 <button @click="open = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6 text-center">
                 <div class="mb-4">
                     <x-heroicon name="user-circle" class="mx-auto h-12 w-12 text-teal-600 mb-4" />
                     <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ $user->name }}'in Hesabına Geç?</h5>
                     <p class="text-gray-600 dark:text-gray-400">
                         Bu kullanıcı olarak giriş yapacaksınız. İstediğiniz zaman admin paneline dönebilirsiniz.
                     </p>
                 </div>
                 <div class="flex space-x-3">
                     <button @click="open = false" class="flex-1 py-2 px-4 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                         <x-heroicon name="x-mark" class="h-4 w-4 mr-2 inline" />İptal
                     </button>
                     <a href="{{ url('admin/dashboard/switchuser') }}/{{ $user->id }}" onclick="return confirm('{{ $user->name }} kullanıcısı olarak giriş yapmak istediğinizden emin misiniz? Yönetici paneline istediğiniz zaman dönebilirsiniz.')" class="flex-1 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                         <x-heroicon name="arrow-right-on-rectangle" class="h-4 w-4 mr-2" />Kullanıcı Hesabına Geç
                     </a>
                 </div>
             </div>
         </div>
     </div>
 </div>