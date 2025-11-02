<div class="w-full">
    <form method="post" action="{{ route('updatewebinfo') }}" id="appinfoform" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <!-- Website Basic Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Website Name</label>
                <input type="text" name="site_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" value="{{ $settings->site_name }}" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Website Title</label>
                <input type="text" name="site_title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" value="{{ $settings->site_title }}" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Website Keywords</label>
                <input type="text" name="keywords" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" value="{{ $settings->keywords }}" required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Website URL (https://yoursite.com)</label>
                <input type="text" placeholder="https://yoursite.com" name="site_address" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" value="{{ $settings->site_address }}" required>
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Website Description</label>
            <textarea name="description" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" rows="4">{{ $settings->description }}</textarea>
        </div>

        <!-- Announcement and Messages -->
        <div class="grid grid-cols-1 gap-6 mb-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Announcement</label>
                <textarea name="update" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" rows="2">{{ $settings->newupdate }}</textarea>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Welcome messages for new registered users</label>
                <textarea name="welcome_message" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" rows="2">{{ $settings->welcome_message }}</textarea>
                <small class="text-gray-500">This message will be displayed to users whose registration date is less than or equal to 3 days</small>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                <input name="whatsapp" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" type="text" value="{{ $settings->whatsapp }}">
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Tido Livechat ID</label>
                <input name="tido" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" type="text" value="{{ $settings->tido }}">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Year Started</label>
                <input name="twak" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" type="text" value="{{ $settings->twak }}" placeholder='Year site started'>
            </div>
        </div>

        <!-- Trading Configuration -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Trading Win Rate %</label>
                <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" name="trading_winrate" placeholder="eg 75%" value="{{ $settings->trading_winrate }}">
                <small class="text-gray-500">If you want to set a default trading winrate for users, please enter the percentage here. (Trading win rate determines the win rate of your client when the trade. The higher the winrate, the more profitable the trade will be for your client and lower winrate gives more loss.) It ranges between 1-100</small>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Timezone</label>
                <select name="timezone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 select2">
                    <option>{{ $settings->timezone }}</option>
                    @foreach ($timezones as $list)
                        <option value="{{ $list }}">{{ $list }}</option>
                    @endforeach
                </select>
                <div class="mt-4 space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Installation Type</label>
                    <select name="install_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option>{{ $settings->install_type }}</option>
                        <option>Main-Domain</option>
                        <option>Sub-Domain</option>
                        <option>Sub-Folder</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Logo and Favicon Upload -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Logo (Recommended size; max width, 200px and max height 100px.)</label>
                <input name="logo" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" type="file">
                <div class="text-center border border-gray-200 p-4 mt-2 rounded-lg bg-gray-50">
                    @if($settings->logo)
                        <img src="{{ asset('storage/'.$settings->logo) }}" alt="Logo" class="max-w-48 mx-auto" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkxvZ28gTm90IEZvdW5kPC90ZXh0Pjwvc3ZnPg=='">
                    @else
                        <div class="p-4 text-center text-gray-500">No logo uploaded</div>
                    @endif
                </div>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Favicon (Recommended size: max width, 32px and max height 32px.)</label>
                <input name="favicon" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" type="file">
                <div class="text-center border border-gray-200 p-4 mt-2 rounded-lg bg-gray-50">
                    @if($settings->favicon)
                        <img src="{{ asset('storage/'.$settings->favicon) }}" alt="Favicon" class="max-w-8 mx-auto" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2RkZCIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiIGZvbnQtc2l6ZT0iMTAiIGZpbGw9IiM5OTkiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5GYXZpY29uPC90ZXh0Pjwvc3ZnPg=='">
                    @else
                        <div class="p-4 text-center text-gray-500">No favicon uploaded</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6">
            <input type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200" value="Update">
        </div>

    </form>
</div>
