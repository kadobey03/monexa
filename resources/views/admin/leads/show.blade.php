@extends('layouts.admin')

@section('title', __('admin.leads.lead_detail') . ' - ' . $lead->name)

@section('breadcrumb')
<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">{{ __('admin.dashboard.dashboard') }}</a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-1"></i>
                <a href="{{ route('admin.leads.index') }}" class="text-gray-700 hover:text-blue-600">{{ __('admin.leads.leads') }}</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-1"></i>
                <span class="text-gray-500">{{ $lead->name }}</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="lead-detail-container" data-lead-id="{{ $lead->id }}" data-admin-id="{{ auth()->id() }}">

    {{-- Lead Header --}}
    <x-admin.leads.detail.lead-header
        :lead="$lead"
        :lead-statuses="$leadStatuses"
        :score-data="$scoreData" />

    <div class="lead-content-wrapper flex">
        {{-- Main Dashboard Area --}}
        <div class="flex-1 min-w-0">
            {{-- Main Dashboard Grid --}}
            <x-admin.leads.detail.lead-dashboard-grid
                :lead="$lead"
                :analytics-data="$analyticsData ?? []"
                :performance-metrics="$performanceMetrics ?? []" />

            {{-- Notes System --}}
            <x-admin.leads.detail.notes-system
                :lead="$lead"
                :notes="$notes ?? collect()"
                :categories="$noteCategories ?? []" />

            {{-- Communication Hub --}}
            <x-admin.leads.detail.communication-hub
                :lead="$lead"
                :communications="$communications ?? collect()"
                :communication-stats="$communicationStats ?? []" />

            {{-- Analytics Section --}}
            <x-admin.leads.detail.analytics-section
                :lead="$lead"
                :chart-data="$chartData ?? []"
                :trends="$trends ?? []" />
        </div>

        {{-- Sidebar Actions --}}
        <x-admin.leads.detail.sidebar-actions
            :lead="$lead"
            :available-actions="$availableActions ?? []"
            :admin="auth()->user()" />
    </div>

    {{-- Mobile Layout --}}
    <x-admin.leads.detail.mobile-layout
        :lead="$lead"
        :mobile-data="$mobileData ?? []" />
</div>

@push('styles')
<link href="{{ asset('css/admin/lead-detail.css') }}" rel="stylesheet">
@endpush

@push('scripts')

<script>
    // Initialize Lead Detail Manager
    document.addEventListener('DOMContentLoaded', function() {
        window.leadDetailManager = new LeadDetailManager({
            leadId: {{ $lead->id }},
            adminId: {{ auth()->id() }},
            csrfToken: '{{ csrf_token() }}',
            routes: {
                updateStatus: '{{ route("admin.api.leads.status.update", $lead->id) }}',
                addNote: '{{ route("admin.api.leads.notes.store", $lead->id) }}',
                sendCommunication: '{{ route("admin.api.leads.communication.send", $lead->id) }}',
                updateScore: '{{ route("admin.api.leads.score.update", $lead->id) }}'
            },
            permissions: {!! json_encode($userPermissions ?? []) !!}
        });
    });
</script>
@endpush

{{-- Action Modals --}}
<x-admin.leads.detail.modals.quick-action-modal :lead="$lead" />
<x-admin.leads.detail.modals.note-editor-modal :lead="$lead" />
<x-admin.leads.detail.modals.communication-modal :lead="$lead" />

@endsection