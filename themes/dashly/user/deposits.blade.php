@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Hesabınıza yatırım yapın
    </h1>
    <livewire:user.deposit.index />
@endsection
