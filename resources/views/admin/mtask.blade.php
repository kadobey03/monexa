@extends('layouts.admin', ['title' => 'Görev Yönetimi'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Görev Yönetimi</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Tüm görevleri yönetin ve takip edin</p>
        </div>
        <div class="flex items-center space-x-2">
            <i data-lucide="clipboard-check" class="h-5 w-5 text-gray-500 dark:text-gray-400"></i>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ count($tasks) }} Görev</span>
        </div>
    </div>

    <!-- Alert Messages -->
    <x-danger-alert />
    <x-success-alert />

    <!-- Tasks Table -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i data-lucide="list-todo" class="h-5 w-5 mr-2"></i>
                Görev Listesi
            </h2>
        </div>

        <div class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300 dark:divide-admin-600">
                    <thead class="bg-gray-50 dark:bg-admin-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Görev Başlığı
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Atanan Kişi
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
                                Oluşturulma
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                İşlemler
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
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $task->tuser->firstName }} {{ $task->tuser->lastName }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <i data-lucide="calendar" class="h-4 w-4 mr-1"></i>
                                        {{ $task->start_date }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <i data-lucide="calendar" class="h-4 w-4 mr-1"></i>
                                        {{ $task->end_date }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($task->status == 'Pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                            Beklemede
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                                            {{ $task->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $task->created_at->toDayDateTimeString() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    @if ($task->status == 'Pending')
                                        <button onclick="openEditModal({{ $task->id }})"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                                            <i data-lucide="edit" class="w-3 h-3 mr-1"></i>
                                            Düzenle
                                        </button>
                                    @endif
                                    <a href="{{ url('admin/dashboard/deltask') }}/{{ $task->id }}"
                                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-admin-800"
                                       onclick="return confirm('Bu görevi silmek istediğinizden emin misiniz?')">
                                        <i data-lucide="trash-2" class="w-3 h-3 mr-1"></i>
                                        Sil
                                    </a>
                                </td>
                            </tr>

                            <!-- Edit Task Modal -->
                            <div id="editTaskModal{{ $task->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" onclick="closeEditModal({{ $task->id }})">
                                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-admin-800" onclick="event.stopPropagation()">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Görev Düzenle</h3>
                                        <button onclick="closeEditModal({{ $task->id }})" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                            <i data-lucide="x" class="h-6 w-6"></i>
                                        </button>
                                    </div>
                                    
                                    <form method="post" action="{{ route('updatetask') }}" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Görev Başlığı</label>
                                            <input type="text" name="tasktitle" value="{{ $task->title }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white" required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Not</label>
                                            <textarea name="note" rows="5"
                                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white" required>{{ $task->note }}</textarea>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Görev Ataması</label>
                                            <select name="delegation"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white" required>
                                                <option value="{{ $task->designation }}">{{ $task->tuser->firstName }} {{ $task->tuser->lastName }}</option>
                                                @foreach ($admin as $user)
                                                    <option value="{{ $user->id }}">{{ $user->firstName }} {{ $user->lastName }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Başlangıç Tarihi</label>
                                                <input type="date" name="start_date" value="{{ $task->start_date }}"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white" required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bitiş Tarihi</label>
                                                <input type="date" name="end_date" value="{{ $task->end_date }}"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white" required>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Öncelik</label>
                                            <select name="priority"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white" required>
                                                <option value="{{ $task->priority }}">{{ $task->priority }}</option>
                                                <option>Immediately</option>
                                                <option>High</option>
                                                <option>Medium</option>
                                                <option>Low</option>
                                            </select>
                                        </div>

                                        <input type="hidden" name="id" value="{{ $task->id }}">
                                        <div class="flex justify-end space-x-3 pt-4">
                                            <button type="button" onclick="closeEditModal({{ $task->id }})"
                                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-admin-600 dark:text-gray-300 dark:hover:bg-admin-700">
                                                İptal
                                            </button>
                                            <button type="submit"
                                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Değişiklikleri Kaydet
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i data-lucide="clipboard-x" class="h-12 w-12 text-gray-400 mb-4"></i>
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Henüz görev yok</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Yeni görevler oluşturduğunuzda burada görünecek.</p>
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
function openEditModal(taskId) {
    document.getElementById('editTaskModal' + taskId).classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeEditModal(taskId) {
    document.getElementById('editTaskModal' + taskId).classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}
</script>
@endsection
