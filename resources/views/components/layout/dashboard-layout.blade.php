<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Design System Styles -->
    <link rel="stylesheet" href="{{ mix('resources/css/design-system/index.scss') }}">
</head>
<body class="font-body antialiased bg-background text-text-primary h-full">
    <div class="min-h-screen bg-background">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 z-50 flex w-72 flex-col">
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-surface px-6 pb-4 border-r border-border">
                <div class="flex h-16 shrink-0 items-center">
                    <x-jet-application-logo class="block h-9 w-auto" />
                </div>

                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <x-layout.nav-section title="Dashboard">
                                <x-layout.nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                    <x-ui.icon name="home" class="w-5 h-5" />
                                    Dashboard
                                </x-layout.nav-link>
                            </x-layout.nav-section>
                        </li>

                        <!-- Dynamic sidebar content -->
                        {{ $sidebar ?? '' }}
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Main content -->
        <div class="lg:pl-72">
            <!-- Header -->
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-border bg-surface px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-text-secondary lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <x-ui.icon name="bars-3" class="h-6 w-6" aria-hidden="true" />
                </button>

                <!-- Separator -->
                <div class="h-6 w-px bg-border lg:hidden" aria-hidden="true"></div>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <!-- Header content -->
                    {{ $header ?? '' }}

                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <!-- Profile dropdown -->
                        <x-layout.profile-dropdown />
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>