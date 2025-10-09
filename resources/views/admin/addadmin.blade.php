@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel ">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 ">Yeni Yönetici Ekle</h1>
                </div>
                <x-danger-alert />
                <x-success-alert />
                <div class="mb-5 row">
                    <div class="col-lg-8 offset-lg-2 card p-3  shadow">
                        <form method="POST" action="{{ url('admin/dashboard/saveadmin') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <h4 class="">Ad</h4>
                                <div>
                                    <input id="name" type="text" class="form-control  " name="fname"
                                        value="{{ old('fname') }}" required>
                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('fname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('l_name') ? ' has-error' : '' }}">
                                <h4 class="">Soyad</h4>
                                <div>
                                    <input id="name" type="text" class="form-control  " name="l_name"
                                        value="{{ old('l_name') }}" required>
                                    @if ($errors->has('l_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('l_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <h4 class="">E-Posta Adresi</h4>

                                <div>
                                    <input id="email" type="email" class="form-control  " name="email"
                                        value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <h4 class="">Telefon Numarası</h4>
                                <div>
                                    <input id="phone" type="number" class="form-control  " name="phone"
                                        value="{{ old('phone') }}" required>

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <h4 class="">Tür</h4>
                                <select class="form-control  " name="type">
                                    <option>Süper Yönetici</option>
                                    <option>Yönetici</option>
                                    <option>Dönüştürme Temsilcisi</option>
                                </select><br>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                <h4 class="">Şifre</h4>
                                <div>
                                    <input id="password" type="password" class="form-control  " name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <h4 class="">Şifreyi Onayla</h4>
                                <div>
                                    <input id="password-confirm" type="password" class="form-control  "
                                        name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="px-3 btn btn-primary btn-lg">
                                        <i class="fa fa-plus"></i> Kullanıcıyı Kaydet
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
