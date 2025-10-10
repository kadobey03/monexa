@php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
@endphp
@extends('layouts.app')
@section('content')
@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .page-icon-wrapper {
        position: relative;
    }
    .page-icon {
        width: 70px;
        height: 70px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .form-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .form-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .category-icon, .user-icon, .greeting-icon, .subject-icon, .message-icon {
        flex-shrink: 0;
    }
    .bg-light-warning {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    }
    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
    }
    .btn-lg {
        font-size: 1.1rem;
    }
    .select2-container--default .select2-selection--multiple {
        border: 2px solid #e9ecef;
        border-radius: 0.375rem;
    }
</style>
@endsection
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel ">
        <div class="content">
            <div class="page-inner">
                <div class="mt-2 mb-5 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="page-icon-wrapper me-3">
                            <div class="page-icon bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-envelope fa-2x"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="title1 text-{{ $text }} mb-1">E-posta Servisleri</h1>
                            <p class="text-muted mb-0">Kullanıcılara toplu e-posta gönderin</p>
                        </div>
                    </div>
                    <div>
                        <a class='btn btn-info btn-lg px-4 py-2' href='https://t.me/+VRumJJSKKGdjM2I0'>
                            <i class="fab fa-telegram me-2"></i>Yardım
                        </a>
                    </div>
                </div>
                <x-danger-alert />
                <x-success-alert />

                <div class="mb-5 row">
                    <div class="col-md-12">
                        <div class="card shadow-lg border-0 overflow-hidden">
                            <div class="card-header bg-gradient-primary text-white py-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-paper-plane fa-lg me-2"></i>
                                    <h4 class="mb-0 text-white">E-posta Oluşturma Formu</h4>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <form method="post" action="{{ route('sendmailtoall') }}">
                                    @csrf

                                    <!-- Category Selection -->
                                    <div class="form-group mb-4">
                                        <div class="form-card bg-light p-3 rounded-lg">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="category-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-primary mb-0">Alıcı Kategorisi</h6>
                                                    <small class="text-muted">E-posta gönderilecek kullanıcı grubunu seçin</small>
                                                </div>
                                            </div>
                                            <select class="form-control form-control-lg" id="category" name="category">
                                                <option value="All">🌐 Tüm Kullanıcılar</option>
                                                <option value="No active plans">📊 Aktif yatırım planı olmayan kullanıcılar</option>
                                                <option value="No deposit">💰 Herhangi bir yatırımı olmayan kullanıcılar</option>
                                                <option value="Select Users">👤 Kullanıcıları Manuel Seç</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- User Selection (Hidden by default) -->
                                    <div class="form-group d-none mb-4" id="select-user-view">
                                        <div class="form-card bg-light-warning p-3 rounded-lg">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="user-icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user-check"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-warning mb-0">Kullanıcı Seçimi</h6>
                                                    <small class="text-muted">Gönderilecek kullanıcıları seçin (<span class="text-primary font-weight-bold" id="numofusers">0</span> kişi seçildi)</small>
                                                </div>
                                            </div>
                                            <select onChange="SelectPage(this)" name="users[]" multiple class="form-control form-control-lg select2" style="width: 100%" id="showusers"></select>
                                        </div>
                                    </div>

                                    <!-- Greeting Fields -->
                                    <div class="form-group mb-4">
                                        <div class="form-card bg-light p-3 rounded-lg">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="greeting-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-hand-paper"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-success mb-0">Selamlama ve Başlık</h6>
                                                    <small class="text-muted">E-postanın başlangıç selamlaması</small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" value="Merhaba" name="greet" class="form-control form-control-lg" placeholder="Selamlama (örn: Merhaba)">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" value="Yatırımcı" name="title" class="form-control form-control-lg" placeholder="Başlık (örn: Değerli Yatırımcı)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Subject Field -->
                                    <div class="form-group mb-4">
                                        <div class="form-card bg-light p-3 rounded-lg">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="subject-icon bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-heading"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-info mb-0">E-posta Konusu</h6>
                                                    <small class="text-muted">Alıcıların göreceği konu başlığı</small>
                                                </div>
                                            </div>
                                            <input type="text" name="subject" class="form-control form-control-lg" placeholder="E-posta konusu..." required>
                                        </div>
                                    </div>

                                    <!-- Message Field -->
                                    <div class="form-group mb-4">
                                        <div class="form-card bg-light p-3 rounded-lg">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="message-icon bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-align-left"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-danger mb-0">E-posta Mesajı</h6>
                                                    <small class="text-muted">Gönderilecek e-posta içeriği</small>
                                                </div>
                                            </div>
                                            <textarea placeholder="E-posta mesajınızı buraya yazın..." class="form-control form-control-lg ckeditor" name="message" rows="8" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                            <i class="fas fa-paper-plane me-2"></i>E-postayı Gönder
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var category = document.querySelector("#category")
        if (category.value == "Select Users") {
            document.querySelector("#select-user-view").classList.remove("d-none")
        } else {
            document.querySelector("#select-user-view").classList.add("d-none")
        }

        $('.select2').select2();

        function SelectPage(elem) {
            var options = elem.options
            var count = 0
            for (var i = 0; i < options.length; i++) {
                if (options[i].selected) count++;
            }
            document.querySelector("#numofusers").textContent = count;
        }


        category.addEventListener('change', function() {
            if (category.value == "Select Users") {
                document.querySelector("#select-user-view").classList.remove("d-none")

                var users = document.querySelector('#showusers')
                fetch("{{ route('fetchusers') }}")
                    .then(response => response.json())
                    .then(data => {
                        data.data.forEach(element => {
                            var usersopt = document.createElement('option');
                            usersopt.value = element.id;
                            usersopt.innerHTML = element.name;
                            users.appendChild(usersopt);
                        });
                    });

            } else {
                document.querySelector("#select-user-view").classList.add("d-none")
            }
        })
    </script>
@endsection
@section('scripts')
    @parent
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
@endsection
