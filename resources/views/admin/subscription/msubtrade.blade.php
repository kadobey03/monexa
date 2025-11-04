@extends('layouts.admin', ['title' => 'Trading Accounts'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Trading Accounts</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Kullanıcılar tarafından gönderilen trading hesaplarını yönetin ve ana trading hesabınıza bağlayın
            </p>
        </div>
        <div class="flex items-center space-x-2">
            <x-heroicon name="activity" class="h-5 w-5 text-gray-500 dark:text-gray-400" />
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ count($subscriptions) }} Hesap</span>
        </div>
    </div>

    <!-- Alert Messages -->
    <x-danger-alert />
    <x-success-alert />

    <!-- Navigation Tabs -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="border-b border-gray-200 dark:border-admin-700">
            <nav class="flex space-x-8 px-6 py-4" aria-label="Tabs">
                <a href="{{ route('msubtrade') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400">
                    <x-heroicon name="inbox" class="h-4 w-4 mr-2" />
                    Gönderilen Hesaplar
                </a>
                <a href="{{ route('tacnts') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600">
                    <x-heroicon name="link" class="h-4 w-4 mr-2" />
                    Bağlı Hesaplar
                </a>
            </nav>
        </div>

        <!-- Table Container -->
        <div class="p-6">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-admin-600">
                        <thead class="bg-gray-50 dark:bg-admin-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Kullanıcı
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Hesap ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Şifre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Hesap Tipi
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Hesap Adı
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Para Birimi
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Leverage
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Server
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Süre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Gönderilme
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Başlangıç
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Bitiş
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Durum
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    İşlemler
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                            @foreach ($subscriptions as $sub)
                                <tr class="hover:bg-gray-50 dark:hover:bg-admin-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $sub->tuser->name }} {{ $sub->tuser->l_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <code class="bg-gray-100 dark:bg-admin-900 px-2 py-1 rounded text-xs">{{ $sub->mt4_id }}</code>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <code class="bg-gray-100 dark:bg-admin-900 px-2 py-1 rounded text-xs">{{ $sub->mt4_password }}</code>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $sub->account_type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $sub->account_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $sub->currency }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        1:{{ $sub->leverage }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $sub->server }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $sub->duration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $sub->created_at->toDayDateTimeString() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        @if (!empty($sub->start_date))
                                            {{ $sub->start_date->toDayDateTimeString() }}
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">Henüz başlamadı</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        @if (!empty($sub->end_date))
                                            {{ $sub->end_date->toDayDateTimeString() }}
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">Henüz başlamadı</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($sub->status == 'Pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                <x-heroicon name="clock" class="w-3 h-3 mr-1" />
                                                Beklemede
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                <x-heroicon name="check-circle" class="w-3 h-3 mr-1" />
                                                {{ $sub->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        @if ($sub->status == 'Pending')
                                            <form action="{{ route('create.sub') }}" method="post" class="inline">
                                                @csrf
                                                <input type="hidden" name="login" value="{{ $sub->mt4_id }}">
                                                <input type="hidden" name="password" value="{{ $sub->mt4_password }}">
                                                <input type="hidden" name="serverName" value="{{ $sub->server }}">
                                                <input type="hidden" name="acntype" value="{{ $sub->account_type }}">
                                                <input type="hidden" name="leverage" value="{{ $sub->leverage }}">
                                                <input type="hidden" name="currency" value="{{ $sub->currency }}">
                                                <input type="hidden" name="name" value="{{ $sub->account_name }}">
                                                <input type="hidden" name="mt4id" value="{{ $sub->id }}">
                                                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                                                    <x-heroicon name="play" class="w-3 h-3 mr-1" />
                                                    İşle
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ url('admin/dashboard/delsub') }}/{{ $sub->id }}"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-admin-800"
                                           onclick="return confirm('Bu hesabı silmek istediğinizden emin misiniz?')">
                                            <x-heroicon name="trash-2" class="w-3 h-3 mr-1" />
                                            Sil
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($subscriptions->hasPages())
                <div class="mt-6">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Empty State -->
    @if($subscriptions->isEmpty())
        <div class="text-center py-12">
            <x-heroicon name="inbox" class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Henüz hesap yok</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kullanıcılar trading hesaplarını gönderdiğinde burada görünecek.</p>
        </div>
    @endif
</div>
@endsection
