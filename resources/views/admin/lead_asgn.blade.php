@extends('layouts.admin', ['title' => 'Atanan Üyeler'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Atanan Üyeler</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Bana atanan yeni üyeleri yönet ve takip et</p>
        </div>
        <div class="flex items-center space-x-2">
            <i data-lucide="users" class="h-5 w-5 text-gray-500 dark:text-gray-400"></i>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ count($usersAssigned) }} Atanmış Üye</span>
        </div>
    </div>

    <!-- Alert Messages -->
    <x-danger-alert />
    <x-success-alert />

    <!-- Members Table -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i data-lucide="user-check" class="h-5 w-5 mr-2"></i>
                Yeni Üyeler
            </h2>
        </div>

        <div class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300 dark:divide-admin-600">
                    <thead class="bg-gray-50 dark:bg-admin-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bakiye</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ad</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Soyad</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Telefon</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Yatırım Planı</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Durum</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kayıt Tarihi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Atanan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                        @forelse ($usersAssigned as $list)
                            <tr class="hover:bg-gray-50 dark:hover:bg-admin-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    #{{ $list->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-semibold text-green-600 dark:text-green-400">${{ number_format($list->account_bal, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $list->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $list->l_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <a href="mailto:{{ $list->email }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $list->email }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <a href="tel:{{ $list->phone_number }}" class="flex items-center">
                                        <i data-lucide="phone" class="h-4 w-4 mr-1"></i>
                                        {{ $list->phone_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if (isset($list->dplan->name))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            {{ $list->dplan->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                                            Plan Yok
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        {{ $list->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <i data-lucide="calendar" class="h-4 w-4 mr-1"></i>
                                        {{ \Carbon\Carbon::parse($list->created_at)->toDayDateTimeString() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $list->tuser->firstName }} {{ $list->tuser->lastName }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    @if ($list->cstatus == 'Customer')
                                        <span class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600">
                                            <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                                            Dönüştürüldü
                                        </span>
                                    @else
                                        <a href="{{ url('admin/dashboard/convert') }}/{{ $list->id }}"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            <i data-lucide="user-plus" class="w-3 h-3 mr-1"></i>
                                            Dönüştür
                                        </a>
                                    @endif
                                    <button onclick="openEditModal({{ $list->id }})"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        <i data-lucide="edit" class="w-3 h-3 mr-1"></i>
                                        Durum Düzenle
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Status Modal -->
                            <div id="editModal{{ $list->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" onclick="closeEditModal({{ $list->id }})">
                                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white dark:bg-admin-800" onclick="event.stopPropagation()">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Kullanıcı Durumu Düzenle</h3>
                                        <button onclick="closeEditModal({{ $list->id }})" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                            <i data-lucide="x" class="h-6 w-6"></i>
                                        </button>
                                    </div>
                                    
                                    <form method="post" action="{{ route('updateuser') }}" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Kullanıcı Durumu
                                            </label>
                                            <textarea name="userupdate" rows="5"
                                                      placeholder="Durum açıklamasını buraya girin..."
                                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white"
                                                      required>{{ $list->userupdate }}</textarea>
                                        </div>
                                        
                                        <input type="hidden" name="id" value="{{ $list->id }}">
                                        <div class="flex justify-end space-x-3 pt-4">
                                            <button type="button" onclick="closeEditModal({{ $list->id }})"
                                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-admin-600 dark:text-gray-300 dark:hover:bg-admin-700">
                                                İptal
                                            </button>
                                            <button type="submit"
                                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Kaydet
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="11" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i data-lucide="users" class="h-12 w-12 text-gray-400 mb-4"></i>
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Henüz atanmış üye yok</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Size atanan yeni üyeler burada görünecek.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function openEditModal(userId) {
    document.getElementById('editModal' + userId).classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeEditModal(userId) {
    document.getElementById('editModal' + userId).classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}
</script>
@endsection
