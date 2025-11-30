 <!-- Top Up Modal -->
 <div id="topupModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('topupModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
             <div class="bg-blue-600 dark:bg-blue-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="wallet" class="h-5 w-5 mr-2" />{{ __('admin.users.topup_modal_title', ['name' => $user->name]) }}
                 </h4>
                 <button onclick="closeModal('topupModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('topup') }}">
                     @csrf
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="currency-dollar" class="h-4 w-4 inline mr-2 text-blue-600" />{{ __('admin.forms.amount') }}
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" placeholder="{{ __('admin.forms.enter_amount') }}" type="number" name="amount" min="0.01" step="0.01" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="arrow-path" class="h-4 w-4 inline mr-2 text-blue-600" />{{ __('admin.accounts.account_type') }}
                             </label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" name="type" required>
                                 <option value="" selected disabled>{{ __('admin.forms.select_account_type') }}</option>
                                 <option value="Bonus">💰 {{ __('admin.accounts.bonus') }}</option>
                                 <option value="Profit">📈 {{ __('admin.accounts.profit') }}</option>
                                 <option value="Ref_Bonus">👥 {{ __('admin.referrals.bonus') }}</option>
                                 <option value="balance">💳 {{ __('admin.accounts.balance') }}</option>
                                 <option value="Deposit">🏦 {{ __('admin.accounts.deposit_amount') }}</option>
                             </select>
                         </div>
                     </div>
                     <div class="mt-6">
                         <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                             <x-heroicon name="plus-circle" class="h-4 w-4 inline mr-2 text-blue-600" />{{ __('admin.forms.transaction_type') }}
                         </label>
                         <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" name="t_type" required>
                             <option value="" selected disabled>{{ __('admin.forms.select_transaction_type') }}</option>
                             <option value="Credit">➕ {{ __('admin.actions.add_balance') }}</option>
                             <option value="Debit">➖ {{ __('admin.actions.subtract_balance') }}</option>
                         </select>
                         <div class="mt-2 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-md">
                             <p class="text-sm text-yellow-800 dark:text-yellow-300"><x-heroicon name="exclamation-triangle" class="h-4 w-4 inline mr-1" /> <strong>{{ __('admin.forms.note') }}:</strong> {{ __('admin.notifications.cannot_debit_deposits') }}</p>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                             <x-heroicon name="check" class="h-4 w-4 mr-2" />{{ __('admin.actions.execute_transaction') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Edit User Modal -->
 <div id="editModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('editModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
             <div class="bg-green-600 dark:bg-green-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="user-pen" class="h-5 w-5 mr-2" />{{ __('admin.users.edit_user_modal_title', ['name' => $user->name]) }}
                 </h4>
                 <button onclick="closeModal('editModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('edituser') }}">
                     @csrf
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="user" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.forms.username') }}
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->username }}" type="text" name="username" pattern="[a-zA-Z0-9_]{3,50}" maxlength="50" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="user-circle" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.forms.full_name') }}
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->name }}" type="text" name="name" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="envelope" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.forms.email') }}
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->email }}" type="email" name="email" maxlength="100" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="phone" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.forms.phone') }}
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->phone }}" type="tel" name="phone" pattern="[+]?[0-9\s\-\(\)]{10,20}" maxlength="20" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="flag" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.forms.country') }}
                             </label>
                             <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->country }}" type="text" name="country">
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="coins" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.forms.currency') }}
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
                             <x-heroicon name="link" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.referrals.link') }}
                         </label>
                         <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->ref_link }}" type="url" name="ref_link" required>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                             <x-heroicon name="save" class="h-4 w-4 mr-2" />{{ __('admin.actions.update_user_info') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Trading Modal -->
 <div id="tradingModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('tradingModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
             <div class="bg-purple-600 dark:bg-purple-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="arrow-trending-up" class="h-5 w-5 mr-2" />{{ __('admin.users.trading_modal_title', ['name' => $user->name]) }}
                 </h4>
                 <button onclick="closeModal('tradingModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('addhistory') }}">
                     @csrf
                     <div class="space-y-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.forms.transaction_amount') }}</label>
                             <input type="number" name="amount" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" placeholder="{{ __('admin.forms.enter_transaction_amount', ['currency' => $user->currency]) }}" min="0.01" step="0.01" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.forms.select_asset') }}</label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" name="plan" required>
                                 <option value="" selected disabled>{{ __('admin.forms.select_asset') }}</option>
                                 <optgroup label="{{ __('admin.investments.currencies') }}">
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
                                 <optgroup label="{{ __('admin.investments.cryptocurrency') }}">
                                     <option value="BTCUSD">BTCUSD</option>
                                     <option value="ETHUSD">ETHUSD</option>
                                     <option value="BCHUSD">BCHUSD</option>
                                     <option value="XRPUSD">XRPUSD</option>
                                     <option value="LTCUSD">LTCUSD</option>
                                     <option value="ETHBTC">ETHBTC</option>
                                 </optgroup>
                                 <optgroup label="{{ __('admin.investments.stocks') }}">
                                     <option value="AAPL">AAPL</option>
                                     <option value="GOOGL">GOOGL</option>
                                     <option value="MSFT">MSFT</option>
                                     <option value="TSLA">TSLA</option>
                                 </optgroup>
                             </select>
                         </div>
                         <div class="grid grid-cols-2 gap-4">
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.investments.leverage') }}</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" name="leverage" required>
                                     <option selected disabled value="">{{ __('admin.forms.select_leverage') }}</option>
                                     <option value="10">1:10</option>
                                     <option value="20">1:20</option>
                                     <option value="50">1:50</option>
                                     <option value="100">1:100</option>
                                 </select>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.investments.duration') }}</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" name="expire" required>
                                     <option selected disabled value="">{{ __('admin.forms.select_duration') }}</option>
                                     <option value="1 Minutes">{{ __('admin.investments.time.1_minute') }}</option>
                                     <option value="5 Minutes">{{ __('admin.investments.time.5_minutes') }}</option>
                                     <option value="15 Minutes">{{ __('admin.investments.time.15_minutes') }}</option>
                                     <option value="30 Minutes">{{ __('admin.investments.time.30_minutes') }}</option>
                                     <option value="60 Minutes">{{ __('admin.investments.time.1_hour') }}</option>
                                 </select>
                             </div>
                         </div>
                         <div class="grid grid-cols-2 gap-4">
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.investments.result') }}</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" name="type" required>
                                     <option value="" selected disabled>{{ __('admin.forms.select_result') }}</option>
                                     <option value="WIN">{{ __('admin.investments.profit') }}</option>
                                     <option value="LOSE">{{ __('admin.investments.loss') }}</option>
                                 </select>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.investments.trade_type') }}</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-admin-700 dark:text-white" name="tradetype" required>
                                     <option value="" selected disabled>{{ __('admin.forms.select_trade_type') }}</option>
                                     <option value="Buy">{{ __('admin.investments.buy') }}</option>
                                     <option value="Sell">{{ __('admin.investments.sell') }}</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                             <x-heroicon name="arrow-trending-up" class="h-4 w-4 mr-2" />{{ __('admin.actions.execute_trade') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Email Modal -->
 <div id="emailModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('emailModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
             <div class="bg-indigo-600 dark:bg-indigo-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="envelope" class="h-5 w-5 mr-2" />{{ __('admin.users.email_modal_title', ['name' => $user->name]) }}
                 </h4>
                 <button onclick="closeModal('emailModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <div class="mb-4 p-3 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-700 rounded-md">
                     <p class="text-sm text-indigo-800 dark:text-indigo-300"><x-heroicon name="information-circle" class="h-4 w-4 inline mr-1" />{{ __('admin.notifications.email_will_be_sent_to', ['name' => $user->name]) }}</p>
                 </div>
                 <form method="post" action="{{ route('sendmailtooneuser') }}">
                     @csrf
                     <div class="space-y-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="type" class="h-4 w-4 inline mr-2 text-indigo-600" />{{ __('admin.forms.email_subject') }}
                             </label>
                             <input type="text" name="subject" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-admin-700 dark:text-white" placeholder="{{ __('admin.forms.email_subject_placeholder') }}" maxlength="100" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="message-square" class="h-4 w-4 inline mr-2 text-indigo-600" />{{ __('admin.forms.message_content') }}
                             </label>
                             <textarea placeholder="{{ __('admin.forms.message_placeholder') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-admin-700 dark:text-white" name="message" rows="8" maxlength="1000" required style="resize: vertical;"></textarea>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                             <x-heroicon name="send" class="h-4 w-4 mr-2" />{{ __('admin.actions.send_email') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Delete Modal -->
 <div id="deleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('deleteModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-red-600 dark:bg-red-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="exclamation-triangle" class="h-5 w-5 mr-2" />{{ __('admin.users.delete_user_account') }}
                 </h4>
                 <button onclick="closeModal('deleteModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6 text-center">
                 <div class="mb-4">
                     <x-heroicon name="user-minus" class="mx-auto h-12 w-12 text-red-600 mb-4" />
                     <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ __('admin.modals.confirm_delete_user', ['name' => $user->name]) }}</h5>
                     <p class="text-gray-600 dark:text-gray-400">
                         {{ __('admin.modals.delete_warning_text') }}
                     </p>
                 </div>
                 <div class="flex space-x-3">
                     <button onclick="closeModal('deleteModal')" class="flex-1 py-2 px-4 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                         <x-heroicon name="x-mark" class="h-4 w-4 mr-2 inline" />{{ __('admin.actions.cancel') }}
                     </button>
                     <a href="{{ url('admin/dashboard/delsystemuser') }}/{{ $user->id }}" onclick="return confirm('{{ __('admin.modals.confirm_delete_final', ['name' => $user->name]) }}')" class="flex-1 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                         <x-heroicon name="trash-2" class="h-4 w-4 mr-2" />{{ __('admin.actions.yes_delete_account') }}
                     </a>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <!-- Reset Password Modal -->
 <div id="resetPasswordModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('resetPasswordModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-yellow-500 dark:bg-yellow-600 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="key" class="h-5 w-5 mr-2" />{{ __('admin.users.reset_user_password') }}
                 </h4>
                 <button onclick="closeModal('resetPasswordModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6 text-center">
                 <div class="mb-4">
                     <x-heroicon name="lock-closed" class="mx-auto h-12 w-12 text-yellow-500 mb-4" />
                     <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ __('admin.modals.confirm_reset_password', ['name' => $user->name]) }}</h5>
                     <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-md">
                         <p class="text-sm text-yellow-800 dark:text-yellow-300 mb-2">{{ __('admin.security.password_will_be_reset_to') }}: <strong>user01236</strong></p>
                         <p class="text-xs text-yellow-700 dark:text-yellow-400">{{ __('admin.notifications.remember_to_inform_user') }}</p>
                     </div>
                 </div>
                 <div class="flex space-x-3">
                     <button onclick="closeModal('resetPasswordModal')" class="flex-1 py-2 px-4 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                         <x-heroicon name="x-mark" class="h-4 w-4 mr-2 inline" />{{ __('admin.actions.cancel') }}
                     </button>
                     <a href="{{ url('admin/dashboard/resetpswd') }}/{{ $user->id }}" onclick="return confirm('{{ __('admin.modals.confirm_password_reset_final', ['name' => $user->name]) }}')" class="flex-1 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                         <x-heroicon name="key" class="h-4 w-4 mr-2" />{{ __('admin.actions.reset_password') }}
                     </a>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <!-- Tax Modal -->
 <div id="taxModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('taxModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-yellow-500 dark:bg-yellow-600 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="calculator" class="h-5 w-5 mr-2" />{{ __('admin.users.user_tax_modal_title', ['name' => $user->name]) }}
                 </h4>
                 <button onclick="closeModal('taxModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('usertax') }}">
                     @csrf
                     <div class="grid grid-cols-2 gap-4">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.status.status') }}</label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 dark:bg-admin-700 dark:text-white" name="taxtype" required>
                                 <option value="" selected disabled>{{ __('admin.forms.select_status') }}</option>
                                 <option value="on">🟢 {{ __('admin.status.active') }}</option>
                                 <option value="off">🔴 {{ __('admin.status.inactive') }}</option>
                             </select>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.forms.tax_rate') }}</label>
                             <input type="number" name="taxamount" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 dark:bg-admin-700 dark:text-white" min="0" max="100" step="0.01" placeholder="0.00">
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                             <x-heroicon name="calculator" class="h-4 w-4 mr-2" />{{ __('admin.actions.set_user_tax') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Withdrawal Code Modal -->
 <div id="withdrawalCodeModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('withdrawalCodeModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-green-600 dark:bg-green-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="key" class="h-5 w-5 mr-2" />{{ __('admin.users.withdrawal_code_modal_title', ['name' => $user->name]) }}
                 </h4>
                 <button onclick="closeModal('withdrawalCodeModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('withdrawalcode') }}">
                     @csrf
                     <div class="grid grid-cols-2 gap-4">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.forms.withdrawal_code_status') }}</label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" name="withdrawal_code" required>
                                 <option value="" selected disabled>{{ __('admin.forms.select_status') }}</option>
                                 <option value="on">🟢 {{ __('admin.status.active') }}</option>
                                 <option value="off">🔴 {{ __('admin.status.inactive') }}</option>
                             </select>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.forms.withdrawal_code') }}</label>
                             <input type="text" name="user_withdrawalcode" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" value="{{ $user->user_withdrawalcode }}" maxlength="50" required>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                             <x-heroicon name="key" class="h-4 w-4 mr-2" />{{ __('admin.actions.set_withdrawal_code') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Notify User Modal -->
 <div id="notifyModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('notifyModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-blue-600 dark:bg-blue-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="bell" class="h-5 w-5 mr-2" />{{ __('admin.users.dashboard_notification_title', ['username' => $user->username]) }}
                 </h4>
                 <button onclick="closeModal('notifyModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('admin.notifications.notification_will_appear_in_dashboard', ['name' => $user->name]) }}</p>
                 <form method="post" action="{{ route('notifyuser') }}">
                     @csrf
                     <div class="space-y-4">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.notifications.dashboard_notification_status') }}: {{ $user->getAttributes()['notify'] ?? 'off' }}</label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" name="notifystatus">
                                 <option value="on">{{ __('admin.status.active') }}</option>
                                 <option value="off">{{ __('admin.status.inactive') }}</option>
                             </select>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.forms.notification_message') }}</label>
                             <textarea placeholder="{{ __('admin.forms.notification_message_placeholder') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" name="notify" rows="6" maxlength="500" required></textarea>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                             <x-heroicon name="send" class="h-4 w-4 mr-2" />{{ __('admin.actions.send_notification') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Number of Trades Modal -->
 <div id="tradesModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('tradesModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-cyan-600 dark:bg-cyan-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="hash" class="h-5 w-5 mr-2" />{{ __('admin.users.trades_modal_title', ['name' => $user->name]) }}
                 </h4>
                 <button onclick="closeModal('tradesModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('numberoftrades') }}">
                     @csrf
                     <div>
                         <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                             <x-heroicon name="arrow-path" class="h-4 w-4 inline mr-2 text-cyan-600" />{{ __('admin.forms.trades_before_withdrawal') }}
                         </label>
                         <input type="number" name="numberoftrades" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 dark:bg-admin-700 dark:text-white" placeholder="{{ $user->numberoftrades }}" min="0" required>
                         <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                             {{ __('admin.forms.min_trades_description') }}
                         </p>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                             <x-heroicon name="hash" class="h-4 w-4 mr-2" />{{ __('admin.actions.set_trades_for_withdrawal') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Signal Modal -->
 <div id="signalModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('signalModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
             <div class="bg-pink-600 dark:bg-pink-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="radio" class="h-5 w-5 mr-2" />{{ __('admin.users.signal_modal_title', ['name' => $user->name]) }}
                 </h4>
                 <button onclick="closeModal('signalModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form method="post" action="{{ route('addsignalhistory') }}">
                     @csrf
                     <div class="space-y-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.forms.select_asset') }}</label>
                             <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 dark:bg-admin-700 dark:text-white" name="asset" required>
                                 <option value="" selected disabled>{{ __('admin.forms.select_asset') }}</option>
                                 <optgroup label="{{ __('admin.investments.currencies') }}">
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
                                 <optgroup label="{{ __('admin.investments.cryptocurrency') }}">
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
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.investments.leverage') }}</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 dark:bg-admin-700 dark:text-white" name="leverage" required>
                                     <option selected disabled value="">{{ __('admin.forms.select_leverage') }}</option>
                                     <option value="10">1:10</option>
                                     <option value="20">1:20</option>
                                     <option value="50">1:50</option>
                                     <option value="100">1:100</option>
                                 </select>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.forms.amount') }}</label>
                                 <input type="number" name="amount" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 dark:bg-admin-700 dark:text-white" placeholder="{{ __('admin.forms.enter_signal_amount', ['currency' => $user->currency]) }}" min="0.01" step="0.01" required>
                             </div>
                         </div>
                         <div class="grid grid-cols-2 gap-4">
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.investments.duration') }}</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 dark:bg-admin-700 dark:text-white" name="expire" required>
                                     <option selected disabled value="">{{ __('admin.forms.select_duration') }}</option>
                                     <option value="1 Minutes">{{ __('admin.investments.time.1_minute') }}</option>
                                     <option value="5 Minutes">{{ __('admin.investments.time.5_minutes') }}</option>
                                     <option value="15 Minutes">{{ __('admin.investments.time.15_minutes') }}</option>
                                     <option value="30 Minutes">{{ __('admin.investments.time.30_minutes') }}</option>
                                     <option value="60 Minutes">{{ __('admin.investments.time.1_hour') }}</option>
                                     <option value="4 Hours">{{ __('admin.investments.time.4_hours') }}</option>
                                     <option value="1 Days">{{ __('admin.investments.time.1_day') }}</option>
                                 </select>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.investments.order_type') }}</label>
                                 <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 dark:bg-admin-700 dark:text-white" name="order_type" required>
                                     <option value="" selected disabled>{{ __('admin.forms.select_order_type') }}</option>
                                     <option value="Buy">{{ __('admin.investments.buy') }}</option>
                                     <option value="Sell">{{ __('admin.investments.sell') }}</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                             <x-heroicon name="radio" class="h-4 w-4 mr-2" />{{ __('admin.actions.create_signal') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Switch User Modal -->
 <div id="switchUserModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('switchUserModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
             <div class="bg-teal-600 dark:bg-teal-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="user-switch" class="h-5 w-5 mr-2" />{{ __('admin.users.switch_user_modal_title', ['name' => $user->name]) }}
                 </h4>
                 <button onclick="closeModal('switchUserModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6 text-center">
                 <div class="mb-4">
                     <x-heroicon name="user-circle" class="mx-auto h-12 w-12 text-teal-600 mb-4" />
                     <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ __('admin.modals.confirm_switch_user', ['name' => $user->name]) }}</h5>
                     <p class="text-gray-600 dark:text-gray-400">
                         {{ __('admin.modals.switch_user_description') }}
                     </p>
                 </div>
                 <div class="flex space-x-3">
                     <button onclick="closeModal('switchUserModal')" class="flex-1 py-2 px-4 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                         <x-heroicon name="x-mark" class="h-4 w-4 mr-2 inline" />{{ __('admin.actions.cancel') }}
                     </button>
                     <a href="{{ url('admin/dashboard/switchuser') }}/{{ $user->id }}" onclick="return confirm('{{ __('admin.modals.confirm_switch_user_final', ['name' => $user->name]) }}')" class="flex-1 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                         <x-heroicon name="arrow-right-on-rectangle" class="h-4 w-4 mr-2" />{{ __('admin.actions.switch_to_user_account') }}
                     </a>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <!-- Add Note Modal -->
 <div id="addNoteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('addNoteModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
             <div class="bg-blue-600 dark:bg-blue-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="document-plus" class="h-5 w-5 mr-2" />{{ __('admin.users.add_note_modal_title', ['name' => $user->name]) }}
                 </h4>
                 <button onclick="closeModal('addNoteModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form id="addNoteForm" onsubmit="event.preventDefault(); submitAddNote();">
                     @csrf
                     <div class="space-y-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="type" class="h-4 w-4 inline mr-2 text-blue-600" />{{ __('admin.forms.note_title') }}
                             </label>
                             <input type="text" name="note_title" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" placeholder="{{ __('admin.forms.note_title_placeholder') }}" maxlength="100" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="document-text" class="h-4 w-4 inline mr-2 text-blue-600" />{{ __('admin.forms.note_content') }}
                             </label>
                             <textarea name="note_content" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white" rows="6" placeholder="{{ __('admin.forms.note_content_placeholder') }}" maxlength="1000" required style="resize: vertical;"></textarea>
                         </div>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                     <x-heroicon name="tag" class="h-4 w-4 inline mr-2 text-blue-600" />{{ __('admin.forms.category') }}
                                 </label>
                                 <select name="note_category" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                                     <option value="">{{ __('admin.forms.select_category') }}</option>
                                     <option value="Görüşme">📞 {{ __('admin.forms.categories.call') }}</option>
                                     <option value="E-posta">📧 {{ __('admin.forms.categories.email') }}</option>
                                     <option value="Yatırım">💰 {{ __('admin.forms.categories.investment') }}</option>
                                     <option value="Şikayet">⚠️ {{ __('admin.forms.categories.complaint') }}</option>
                                     <option value="Takip">👥 {{ __('admin.forms.categories.follow_up') }}</option>
                                     <option value="Diğer">📝 {{ __('admin.forms.categories.other') }}</option>
                                 </select>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                     <x-heroicon name="paint-brush" class="h-4 w-4 inline mr-2 text-blue-600" />{{ __('admin.forms.color') }}
                                 </label>
                                 <select name="note_color" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                                     <option value="blue" selected>🔵 {{ __('admin.forms.colors.blue') }}</option>
                                     <option value="green">🟢 {{ __('admin.forms.colors.green') }}</option>
                                     <option value="yellow">🟡 {{ __('admin.forms.colors.yellow') }}</option>
                                     <option value="red">🔴 {{ __('admin.forms.colors.red') }}</option>
                                     <option value="purple">🟣 {{ __('admin.forms.colors.purple') }}</option>
                                     <option value="gray">⚫ {{ __('admin.forms.colors.gray') }}</option>
                                 </select>
                             </div>
                         </div>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                             <div>
                                 <label class="flex items-center">
                                     <input type="checkbox" name="is_pinned" value="1" class="rounded border-gray-300 dark:border-admin-600 text-blue-600 focus:ring-blue-500 focus:ring-2 dark:bg-admin-700">
                                     <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                         <x-heroicon name="paper-clip" class="h-4 w-4 inline mr-1 text-blue-600" />{{ __('admin.forms.important_note_pinned') }}
                                     </span>
                                 </label>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                     <x-heroicon name="bell" class="h-4 w-4 inline mr-2 text-blue-600" />{{ __('admin.forms.reminder_date') }}
                                 </label>
                                 <input type="datetime-local" name="reminder_date" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                             </div>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                             <x-heroicon name="plus" class="h-4 w-4 mr-2" />{{ __('admin.actions.save_note') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Edit Note Modal -->
 <div id="editNoteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 transition-opacity duration-300">
     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
         <div class="fixed inset-0 transition-opacity" onclick="closeModal('editNoteModal')">
             <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
         </div>
         <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
             <div class="bg-green-600 dark:bg-green-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                 <h4 class="text-lg font-semibold text-white flex items-center">
                     <x-heroicon name="document-pen" class="h-5 w-5 mr-2" />{{ __('admin.users.edit_note_modal_title', ['name' => $user->name]) }}
                 </h4>
                 <button onclick="closeModal('editNoteModal')" class="absolute top-4 right-4 text-white hover:text-gray-200">
                     <x-heroicon name="x-mark" class="h-5 w-5" />
                 </button>
             </div>
             <div class="p-6">
                 <form id="editNoteForm" onsubmit="event.preventDefault(); submitEditNote();">
                     @csrf
                     <div class="space-y-6">
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="type" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.forms.note_title') }}
                             </label>
                             <input type="text" id="edit_note_title" name="note_title" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" placeholder="{{ __('admin.forms.note_title_placeholder') }}" maxlength="100" required>
                         </div>
                         <div>
                             <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                 <x-heroicon name="document-text" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.forms.note_content') }}
                             </label>
                             <textarea id="edit_note_content" name="note_content" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white" rows="6" placeholder="{{ __('admin.forms.note_content_placeholder') }}" maxlength="1000" required style="resize: vertical;"></textarea>
                         </div>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                     <x-heroicon name="tag" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.forms.category') }}
                                 </label>
                                 <select id="edit_note_category" name="note_category" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white">
                                     <option value="">{{ __('admin.forms.select_category') }}</option>
                                     <option value="Görüşme">📞 {{ __('admin.forms.categories.call') }}</option>
                                     <option value="E-posta">📧 {{ __('admin.forms.categories.email') }}</option>
                                     <option value="Yatırım">💰 {{ __('admin.forms.categories.investment') }}</option>
                                     <option value="Şikayet">⚠️ {{ __('admin.forms.categories.complaint') }}</option>
                                     <option value="Takip">👥 {{ __('admin.forms.categories.follow_up') }}</option>
                                     <option value="Diğer">📝 {{ __('admin.forms.categories.other') }}</option>
                                 </select>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                     <x-heroicon name="paint-brush" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.forms.color') }}
                                 </label>
                                 <select id="edit_note_color" name="note_color" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white">
                                     <option value="blue">🔵 {{ __('admin.forms.colors.blue') }}</option>
                                     <option value="green">🟢 {{ __('admin.forms.colors.green') }}</option>
                                     <option value="yellow">🟡 {{ __('admin.forms.colors.yellow') }}</option>
                                     <option value="red">🔴 {{ __('admin.forms.colors.red') }}</option>
                                     <option value="purple">🟣 {{ __('admin.forms.colors.purple') }}</option>
                                     <option value="gray">⚫ {{ __('admin.forms.colors.gray') }}</option>
                                 </select>
                             </div>
                         </div>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                             <div>
                                 <label class="flex items-center">
                                     <input type="checkbox" id="edit_is_pinned" name="is_pinned" value="1" class="rounded border-gray-300 dark:border-admin-600 text-green-600 focus:ring-green-500 focus:ring-2 dark:bg-admin-700">
                                     <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                         <x-heroicon name="paper-clip" class="h-4 w-4 inline mr-1 text-green-600" />{{ __('admin.forms.important_note_pinned') }}
                                     </span>
                                 </label>
                             </div>
                             <div>
                                 <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                     <x-heroicon name="bell" class="h-4 w-4 inline mr-2 text-green-600" />{{ __('admin.forms.reminder_date') }}
                                 </label>
                                 <input type="datetime-local" id="edit_reminder_date" name="reminder_date" class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-admin-700 dark:text-white">
                             </div>
                         </div>
                     </div>
                     <div class="mt-6">
                         <input type="hidden" id="edit_note_id" name="note_id" value="">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <input type="hidden" name="_method" value="PUT">
                         <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                             <x-heroicon name="save" class="h-4 w-4 mr-2" />{{ __('admin.actions.save_changes') }}
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>