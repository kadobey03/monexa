@extends('layouts.app')
@section('title', __('admin.notifications.notification_details'))

@php
    // Helper function to safely get user name
    function safeGetUserName($user) {
        if (!$user) {
            return 'N/A';
        }

        if(is_object($user)) {
            return $user->name;
        } elseif(is_numeric($user)) {
            $userObj = \App\Models\User::find($user);
            return $userObj ? $userObj->name : 'User #' . $user;
        }

        return 'N/A';
    }
@endphp

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('admin.notifications.notification_details') }}</h1>
    </div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $notification->title }}</h5>
                <span class="badge badge-{{ $notification->type === 'warning' ? 'warning' : ($notification->type === 'success' ? 'success' : ($notification->type === 'danger' ? 'danger' : 'info')) }}">
                    {{ ucfirst($notification->type) }}
                </span>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>{{ __('admin.notifications.user') }}:</strong>
                                @php
                                    $userId = null;
                                    $userName = 'N/A';

                                    if($notification->user) {
                                        if(is_object($notification->user)) {
                                            $userId = $notification->user->id;
                                            $userName = $notification->user->name;
                                        } elseif(is_numeric($notification->user)) {
                                            $userId = $notification->user;
                                            $userObj = \App\Models\User::find($userId);
                                            $userName = $userObj ? $userObj->name : 'User #' . $userId;
                                        }
                                    }
                                @endphp

                                @if($userId)
                                    <a href="{{ route('admin.users.show', $userId) }}">{{ $userName }}</a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>{{ __('admin.notifications.message') }}:</strong></p>
                            <div class="p-3 bg-light rounded">
                                {{ $notification->message }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>{{ __('admin.notifications.date') }}:</strong> {{ $notification->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <p><strong>{{ __('admin.notifications.status') }}:</strong> {{ $notification->is_read ? __('admin.notifications.read') : __('admin.notifications.unread') }}</p>
                    </div>
                </div>

                @if($notification->source_id && $notification->source_type)
                    <hr>
                    <div class="mt-3">
                        <h6>{{ __('admin.notifications.related_information') }}</h6>
                        @php
                            $sourceModel = null;
                            try {
                                if (class_exists($notification->source_type)) {
                                    $sourceModel = $notification->source_type::find($notification->source_id);
                                }
                            } catch (\Exception $e) {
                                // Model not found or error
                            }
                        @endphp

                        @if($sourceModel)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        @if($notification->source_type == 'App\\Models\\Deposit')
                                            <tr>
                                                <th>{{ __('admin.notifications.user') }}</th>
                                                <td>{{ safeGetUserName($sourceModel->user) }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.amount') }}</th>
                                                <td>{{ $sourceModel->amount }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.status') }}</th>
                                                <td>{{ $sourceModel->status }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.payment_mode') }}</th>
                                                <td>{{ $sourceModel->payment_mode }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.action') }}</th>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-primary">{{ __('admin.notifications.view_deposit') }}</a>
                                                </td>
                                            </tr>
                                        @elseif($notification->source_type == 'App\\Models\\Withdrawal')
                                            <tr>
                                                <th>{{ __('admin.notifications.user') }}</th>
                                                <td>{{ safeGetUserName($sourceModel->user) }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.amount') }}</th>
                                                <td>{{ $sourceModel->amount }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.status') }}</th>
                                                <td>{{ $sourceModel->status }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.payment_mode') }}</th>
                                                <td>{{ $sourceModel->payment_mode }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.action') }}</th>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">{{ __('admin.notifications.view_withdrawal') }}</a>
                                                </td>
                                            </tr>
                                        @elseif($notification->source_type == 'App\\Models\\User_plans')
                                            <tr>
                                                <th>{{ __('admin.notifications.user') }}</th>
                                                <td>{{ safeGetUserName($sourceModel->user) }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.amount') }}</th>
                                                <td>{{ $sourceModel->amount }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.status') }}</th>
                                                <td>{{ $sourceModel->active ? __('admin.notifications.active') : __('admin.notifications.inactive') }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.asset') }}</th>
                                                <td>{{ $sourceModel->assets }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.action') }}</th>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">{{ __('admin.notifications.view_plan') }}</a>
                                                </td>
                                            </tr>
                                        @elseif($notification->source_type == 'App\\Models\\UserBotInvestment')
                                            <tr>
                                                <th>{{ __('admin.notifications.user') }}</th>
                                                <td>{{ safeGetUserName($sourceModel->user) }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.amount') }}</th>
                                                <td>{{ $sourceModel->investment_amount }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.status') }}</th>
                                                <td>{{ $sourceModel->status }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.current_balance') }}</th>
                                                <td>{{ $sourceModel->current_balance }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin.notifications.action') }}</th>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">{{ __('admin.notifications.view_bot_investment') }}</a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="2">{{ __('admin.notifications.no_detailed_information') }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>{{ __('admin.notifications.no_related_information') }}</p>
                        @endif
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('admin.notifications') }}" class="btn btn-secondary">{{ __('admin.notifications.back_to_notifications') }}</a>

                    <form action="{{ route('admin.notifications.delete') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('admin.notifications.confirm_delete_notification') }}')">{{ __('admin.notifications.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
