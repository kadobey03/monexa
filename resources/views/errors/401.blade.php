@extends('errors::minimal')

@section('title', __('Yetkisiz'))
@section('code', '401')
@section('message', __('Bu eylemi gerçekleştirmek için yetkiniz yok'))
