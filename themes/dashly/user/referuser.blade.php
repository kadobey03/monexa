@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Kullanıcıları {{ $settings->site_name }} topluluğuna yönlendirin
    </h1>
    <livewire:user.referral-system />
@endsection
