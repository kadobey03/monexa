@props([
    'lead',
    'leadStatuses',
    'scoreData'
])

<div class="lead-detail-header bg-white shadow-sm border-b px-6 py-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            {{-- Lead Avatar --}}
            <div class="lead-avatar">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xl">
                    {{ strtoupper(substr($lead->name, 0, 1)) . strtoupper(substr(explode(' ', $lead->name)[1] ?? '', 0, 1)) }}
                </div>
            </div>

            {{-- Lead Basic Info --}}
            <div class="lead-basic-info">
                <h1 class="text-2xl font-bold text-gray-900">{{ $lead->name }}</h1>
                <p class="text-gray-600">{{ $lead->email }} • {{ $lead->phone }}</p>
                <div class="flex items-center space-x-2 mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        ID: #{{ $lead->id }}
                    </span>
                    <span class="text-gray-400">•</span>
                    <span class="text-sm text-gray-500">{{ $lead->country }}</span>
                    @if($lead->created_at)
                        <span class="text-gray-400">•</span>
                        <span class="text-sm text-gray-500">{{ $lead->created_at->format('d.m.Y') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            {{-- Lead Score --}}
            <div class="text-center">
                <div class="text-2xl font-bold {{ $scoreData['color_class'] ?? 'text-gray-600' }}">{{ $scoreData['score'] ?? $lead->lead_score ?? 0 }}</div>
                <div class="text-xs text-gray-500 uppercase tracking-wide">Lead Score</div>
            </div>

            {{-- Status Dropdown --}}
            <div class="status-dropdown-container">
                <select class="status-dropdown px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        data-lead-id="{{ $lead->id }}"
                        data-current-status="{{ $lead->lead_status_id }}">
                    @foreach($leadStatuses as $status)
                        <option value="{{ $status->id }}"
                                {{ $lead->lead_status_id == $status->id ? 'selected' : '' }}
                                data-color="{{ $status->color }}">
                            {{ $status->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Quick Actions --}}
            <div class="quick-actions-buttons flex space-x-2">
                @can('call_lead')
                <button class="btn-quick-call inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        title="Hızlı Arama"
                        data-phone="{{ $lead->phone }}">
                    <i class="fas fa-phone"></i>
                </button>
                @endcan

                @can('email_lead')
                <button class="btn-quick-email inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        title="E-posta Gönder"
                        data-email="{{ $lead->email }}">
                    <i class="fas fa-envelope"></i>
                </button>
                @endcan

                @can('message_lead')
                <button class="btn-quick-whatsapp inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        title="WhatsApp"
                        data-whatsapp="{{ $lead->phone }}">
                    <i class="fab fa-whatsapp"></i>
                </button>
                @endcan
            </div>
        </div>
    </div>
</div>