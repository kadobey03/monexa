@extends('layouts.admin', ['title' => 'Agent Müşterileri - ' . $agent->name])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Agent Müşterileri</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                <span class="font-medium text-blue-600 dark:text-blue-400">{{ $agent->name }}</span> agent'inin müşteri listesi
            </p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
                <i data-lucide="users" class="h-5 w-5 text-gray-500 dark:text-gray-400"></i>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ count($ag_r) }} Müşteri</span>
            </div>
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-admin-700 dark:border-admin-600 dark:text-gray-300 dark:hover:bg-admin-600">
                <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
                Geri
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (Session::has('message'))
        <div class="rounded-md bg-blue-50 dark:bg-blue-900/50 p-4 border border-blue-200 dark:border-blue-700">
            <div class="flex">
                <i data-lucide="info" class="h-5 w-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3"></i>
                <div class="text-sm text-blue-700 dark:text-blue-300">{{ Session::get('message') }}</div>
            </div>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="rounded-md bg-red-50 dark:bg-red-900/50 p-4 border border-red-200 dark:border-red-700">
            <div class="flex">
                <i data-lucide="alert-triangle" class="h-5 w-5 text-red-600 dark:text-red-400 mt-0.5 mr-3"></i>
                <div class="text-sm text-red-700 dark:text-red-300">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Agent Info Card -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-lg p-6 border border-blue-200 dark:border-blue-700">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                    <i data-lucide="user-check" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">{{ $agent->name }}</h3>
                <p class="text-blue-700 dark:text-blue-300">Agent • {{ count($ag_r) }} Aktif Müşteri</p>
            </div>
            <div class="ml-auto">
                <div class="text-right">
                    <div class="text-2xl font-bold text-blue-900 dark:text-blue-100">
                        ${{ number_format($ag_r->sum('account_bal'), 2) }}
                    </div>
                    <div class="text-sm text-blue-600 dark:text-blue-400">Toplam Kazanç</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients Table -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i data-lucide="users" class="h-5 w-5 mr-2"></i>
                Müşteri Listesi
            </h2>
        </div>

        <div class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300 dark:divide-admin-600">
                    <thead class="bg-gray-50 dark:bg-admin-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Müşteri Adı
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Yatırım Planı
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Durum
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Kazançlar
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                        @forelse ($ag_r as $client)
                            <tr class="hover:bg-gray-50 dark:hover:bg-admin-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-100 dark:bg-admin-700 flex items-center justify-center">
                                                <i data-lucide="user" class="h-5 w-5 text-gray-600 dark:text-gray-400"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if (isset($client->dplan->name))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i>
                                            {{ $client->dplan->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                                            <i data-lucide="minus" class="w-3 h-3 mr-1"></i>
                                            Plan Atanmamış
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($client->status == 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                                            Aktif
                                        </span>
                                    @elseif($client->status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                            Beklemede
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                                            {{ $client->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center">
                                        <i data-lucide="dollar-sign" class="h-4 w-4 text-green-600 dark:text-green-400 mr-1"></i>
                                        <span class="font-semibold text-green-600 dark:text-green-400">
                                            ${{ number_format($client->account_bal, 2) }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i data-lucide="users" class="h-12 w-12 text-gray-400 mb-4"></i>
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Henüz müşteri yok</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Bu agent'in henüz atanmış müşterisi bulunmamaktadır.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary -->
        @if($ag_r->count() > 0)
            <div class="px-6 py-4 border-t border-gray-200 dark:border-admin-700">
                <div class="flex items-center justify-between text-sm">
                    <div class="text-gray-500 dark:text-gray-400">
                        Toplam {{ count($ag_r) }} müşteri gösteriliyor
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-gray-500 dark:text-gray-400">
                            Ortalama bakiye: <span class="font-semibold text-gray-900 dark:text-white">${{ number_format($ag_r->avg('account_bal'), 2) }}</span>
                        </div>
                        <div class="text-gray-500 dark:text-gray-400">
                            Toplam: <span class="font-semibold text-green-600 dark:text-green-400">${{ number_format($ag_r->sum('account_bal'), 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
