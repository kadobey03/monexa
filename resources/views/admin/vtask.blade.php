@extends('layouts.admin', ['title' => __('admin.tasks.my_tasks_title')])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('admin.tasks.my_tasks_title') }}</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('admin.tasks.my_tasks_description') }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <x-heroicon name="clipboard-list" class="h-5 w-5 text-gray-500 dark:text-gray-400" />
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ count($tasks) }} {{ __('admin.tasks.stats.task_count') }}</span>
        </div>
    </div>

    <!-- Alert Messages -->
    <x-danger-alert />
    <x-success-alert />

    <!-- Tasks Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Tasks -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <x-heroicon name="clipboard-list" class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.tasks.stats.total_tasks') }}</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ count($tasks) }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                        <x-heroicon name="clock" class="h-6 w-6 text-yellow-600 dark:text-yellow-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.tasks.stats.pending_tasks') }}</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                        {{ $tasks->where('status', 'Pending')->count() }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <x-heroicon name="check-circle" class="h-6 w-6 text-green-600 dark:text-green-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.tasks.stats.completed_tasks') }}</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                        {{ $tasks->where('status', '!=', 'Pending')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Table -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <x-heroicon name="list-todo" class="h-5 w-5 mr-2" />
                {{ __('admin.tasks.section.task_details') }}
            </h2>
        </div>

        <div class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300 dark:divide-admin-600">
                    <thead class="bg-gray-50 dark:bg-admin-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('admin.tasks.table.task_title') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('admin.tasks.table.assignee') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('admin.tasks.table.note') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('admin.tasks.table.start_date') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('admin.tasks.table.end_date') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('admin.tasks.table.status') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('admin.tasks.table.created_at') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('admin.tasks.table.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                        @forelse ($tasks as $task)
                            <tr class="hover:bg-gray-50 dark:hover:bg-admin-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $task->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-gray-100 dark:bg-admin-700 flex items-center justify-center">
                                                <x-heroicon name="user" class="h-4 w-4 text-gray-600 dark:text-gray-400" />
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $task->tuser->firstName }} {{ $task->tuser->lastName }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate" title="{{ $task->note }}">
                                        {{ $task->note }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <x-heroicon name="calendar-days" class="h-4 w-4 mr-1" />
                                        {{ $task->start_date }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <x-heroicon name="calendar-days" class="h-4 w-4 mr-1" />
                                        {{ $task->end_date }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($task->status == 'Pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            <x-heroicon name="clock" class="w-3 h-3 mr-1" />
                                            {{ __('admin.tasks.status.pending') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            <x-heroicon name="check-circle" class="w-3 h-3 mr-1" />
                                            {{ $task->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $task->created_at->toDayDateTimeString() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if ($task->status == 'Pending')
                                        <a href="{{ url('admin/dashboard/markdone') }}/{{ $task->id }}"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-admin-800"
                                           onclick="return confirm('{{ __('admin.tasks.confirm.mark_completed') }}')">
                                            <x-heroicon name="check" class="w-3 h-3 mr-1" />
                                            {{ __('admin.tasks.button.mark_completed') }}
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-700 bg-green-100 dark:bg-green-900 dark:text-green-300">
                                            <x-heroicon name="check-circle-2" class="w-3 h-3 mr-1" />
                                            {{ __('admin.tasks.status.completed') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <x-heroicon name="clipboard-x" class="h-12 w-12 text-gray-400 mb-4" />
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.tasks.empty.no_tasks') }}</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('admin.tasks.empty.assigned_tasks_description') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary -->
        @if($tasks->count() > 0)
            <div class="px-6 py-4 border-t border-gray-200 dark:border-admin-700">
                <div class="flex items-center justify-between text-sm">
                    <div class="text-gray-500 dark:text-gray-400">
                        {{ str_replace('{count}', count($tasks), __('admin.tasks.stats.showing_total')) }}
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-gray-500 dark:text-gray-400">
                            {{ __('admin.tasks.stats.completion_rate') }}:
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ $tasks->count() > 0 ? round(($tasks->where('status', '!=', 'Pending')->count() / $tasks->count()) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
