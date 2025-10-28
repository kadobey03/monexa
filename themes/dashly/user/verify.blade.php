@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <div class="d-flex align-items-baseline justify-content-between">
        <!-- Title -->
        <h1 class="h2">
            KYC Doğrulama
        </h1>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <x-error-alert />
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9 col-xxl-7">
            <div>
                <ul class="nav nav-pills steps mb-7 mt-n3 w-75 w-xxl-50 mx-auto" id="wizard-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="wizardTabOne" data-bs-toggle="pill"
                            data-bs-target="#wizardStepOne" type="button" role="tab" aria-controls="wizardStepOne"
                            aria-selected="true">
                            1
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        @if (Auth::user()->account_verify == 'Verified' or Auth::user()->account_verify == 'Under review')
                            <button class="nav-link" id="wizardTabTwo" data-bs-toggle="pill" data-bs-target="#wizardStepTwo"
                                type="button" role="tab" aria-controls="wizardStepTwo" aria-selected="false" disabled>
                                2
                            </button>
                        @else
                            <button class="nav-link" id="wizardTabTwo" data-bs-toggle="pill" data-bs-target="#wizardStepTwo"
                                type="button" role="tab" aria-controls="wizardStepTwo" aria-selected="false">
                                2
                            </button>
                        @endif
                    </li>
                </ul>
                <div class="tab-content" id="wizard-tabContent">

                    <div class="tab-pane fade show active" id="wizardStepOne" role="tabpanel"
                        aria-labelledby="wizardTabOne">
                        <!-- Card -->
                        <div class="card border-0 py-6 px-md-6">
                            <div class="card-body">
                                @if (Auth::user()->account_verify == 'Verified' or Auth::user()->account_verify == 'Under review')
                                    <div class="alert alert-info">
                                        KYC doğrulamınız {{ Auth::user()->account_verify }}.
                                    </div>
                                @endif
                                <h2 class="text-center mb-0">KYC Doğrulama</h2>
                                <p class="text-secondary text-center">Düzenlemeye uymak için, her katılımcı
                                    dolandırıcılık nedenlerini önlemek için kimlik
                                    doğrulamasından (KYC/AML) geçmek zorunda kalacaktır.</p>

                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <div></div>
                                    <!-- Button -->
                                    @if (Auth::user()->account_verify == 'Verified' or Auth::user()->account_verify == 'Under review')
                                        <a class="btn btn-primary" data-toggle="wizard" href="#wizardStepTwo"
                                            disabled>Sonraki</a>
                                    @else
                                        <a class="btn btn-primary" data-toggle="wizard" href="#wizardStepTwo">Sonraki</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body d-lg-flex justify-content-lg-between">
                                <div>
                                    <h4 class="m-0">Size yardımcı olmak için buradayız!</h4>
                                    <p class="m-0">
                                        Bir soru sorun, istekleri yönetin, bir sorun bildirin. Destek ekibimiz
                                        size e-posta ile geri dönecektir.
                                    </p>
                                </div>
                                <div>
                                    <a href="{{ route('support') }}"
                                        class="px-3 btn btn-outline-primary btn-sm">Yardım/Destek</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="wizardStepTwo" role="tabpanel" aria-labelledby="wizardTabTwo">
                        <!-- Card -->
                        <div class="card border-0 py-6 px-md-6">
                            <div class="card-body">
                                <div class="row">
                                    <form action="{{ route('kycsubmit') }}" method="POST" enctype="multipart/form-data"
                                        class="needs-validation">
                                        @csrf
                                        <div class="col-12 border-bottom">
                                            <h5>Kişisel Detaylar</h5>
                                            <p>Kimlik için gereken basit kişisel bilgileriniz</p>
                                        </div>
                                        <div class="col-12">
                                            <small>
                                                Lütfen dikkatlice yazın ve formu kişisel bilgilerinizle doldurun.
                                                Formu gönderdikten sonra bu detayları düzenleyemezsiniz.
                                            </small>
                                        </div>
                                        <div class="mt-4 col-12">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstname">İlk ad <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="first_name" class="form-control" required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="lastname">Soyad <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="last_name" class="form-control" required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="email">E-posta <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control" required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="phone_number">Telefon Numarası <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="phone_number" class="form-control" required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="dob">Doğum tarihi <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" name="dob" class="form-control"
                                                        data-toggle="date" placeholder="Tarih seçin" required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="social_media">Twitter veya Facebook kullanıcı adı</label>
                                                    <input type="text" name="social_media" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-3 mt-3 col-12 border-bottom border-top">
                                            <h5>Adresiniz</h5>
                                            <p>Kimlik için gereken basit konum bilgileriniz</p>
                                        </div>
                                        <div class="mt-4 col-12">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="address">Adres satırı<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="address" class="form-control" required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="city">Şehir<span class="text-danger">*</span></label>
                                                    <input type="text" name="city" class="form-control" required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="state">Eyalet<span class="text-danger">*</span></label>
                                                    <input type="text" name="state" class="form-control" required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="country">Milliyet <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="country" class="form-control" required>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="pt-3 mt-3 col-12 border-bottom border-top">
                                            <h5>Belge Yükleme</h5>
                                            <p>Kimlik için gereken basit kişisel belgeniz</p>
                                        </div>
                                        <div class="mt-4 col-12">
                                            <div class="row">
                                                <div class="mb-2 col-md-12">
                                                    <div class="flex-wrap btn-group-toggle d-flex justify-content-around"
                                                        data-toggle="buttons">
                                                        <label class="mb-2 shadow-sm btn btn-primary active">

                                                            <input type="radio" name="document_type"
                                                                value="Int'l Passport" autocomplete="off" checked> Uluslararası
                                                            Pasaport
                                                        </label>
                                                        <label class="mb-2 shadow-sm btn btn-primary">

                                                            <input type="radio" name="document_type"
                                                                value="National ID" autocomplete="off"> Ulusal Kimlik
                                                        </label>
                                                        <label class="mb-2 shadow-sm btn btn-primary">

                                                            <input type="radio" name="document_type"
                                                                value="Drivers License" autocomplete="off"> Ehliyet
                                                        </label>
                                                    </div>
                                                    <div class="mt-4">
                                                        <h6 class=" font-weight-bold">Hesap doğrulamasında gecikmeleri önlemek için,
                                                            lütfen belgenizin aşağıdaki kriterleri karşıladığından emin olun:</h6>
                                                        <ul class=" list-group">
                                                            <li>
                                                                <i class="fas fa-check-square text-primary"></i>
                                                                Seçilen kimlik belgesinin süresi dolmamış olmalıdır.
                                                            </li>
                                                            <li>
                                                                <i class="fas fa-check-square text-primary"></i>
                                                                Belge iyi durumda ve açıkça görünür olmalıdır.
                                                            </li>
                                                            <li>
                                                                <i class="fas fa-check-square text-primary"></i>
                                                                Belgede ışık parlaması olmadığından emin olun.
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <p class="mt-3 text-black h6">Ön tarafı yükleyin <span
                                                            class="text-danger">*</span></p>
                                                    <div class="mt-3 align-items-center justify-content-around d-md-flex">
                                                        <div class="p-2 border p-md-5 ">
                                                            <div class="custom-file">
                                                                <input type="file" name="frontimg"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <i class="bi bi-credit-card fs-1"></i>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <p class="mt-3 text-black h6">Arka tarafı yükleyin <span
                                                            class="text-danger">*</span></p>
                                                    <div class="mt-3 align-items-center justify-content-around d-md-flex">
                                                        <div class="p-2 border p-md-5 ">
                                                            <div class="custom-file">
                                                                <input type="file" name="backimg" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <i class="bi bi-credit-card-2-back fs-1"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 col-12">
                                            <div class="mb-2 form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1" required>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Girdiğim Tüm Bilgiler Doğrudur.
                                                </label>
                                            </div>
                                            @if (Auth::user()->account_verify == 'Under review')
                                                <button type="submit" class="px-4 btn btn-primary d-block"
                                                    disabled>Başvuru
                                                    Gönder</button>
                                                <small class="text-success">Önceki başvurunuz inceleniyor,
                                                    lütfen bekleyin</small>
                                            @else
                                                <button type="submit" class="px-4 btn btn-primary">Başvuru
                                                    Gönder</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <!-- Button -->
                                    <a class="btn btn-light" data-toggle="wizard" href="#wizardStepOne">Önceki</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





{{-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-5 row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="p-3 text-center">
                                <h2 class="">KYC Verification</h2>
                                <p>To comply with regulation, each participant will have to go through indentity
                                    verification (KYC/AML) to prevent fraud causes.</p>
                            </div>
                            <div class="p-2 text-center shadow-lg p-md-5">
                                <i class="p-4 mb-3 fas fa-copy fa-4x bg-light rounded-pill"></i>
                                <p>You have not submitted your necessary documents to verify your identity. In order to
                                    enjoy our investment system, please verify your identity.</p>

                                @if (Auth::user()->account_verify == 'Verified' or Auth::user()->account_verify == 'Under review')
                                    <button class="mt-2 btn btn-primary btn-sm" disabled>Click here to complete your
                                        KYC</button> <br>
                                    <small class="text-success">Your previous application is under review, please
                                        wait</small>
                                @else
                                    <a href="{{ route('kycform') }}" class="mt-2 btn btn-primary btn-sm">Click here to
                                        complete your KYC</a>
                                @endif
                            </div>
                            <div class="p-2 mt-5 shadow-lg d-md-flex justify-content-between">
                                <div class="p-2">
                                    <i class="p-4 fas fa-envelope-open-text fa-4x bg-light rounded-pill"></i>
                                </div>
                                <div class="p-2">
                                    <h4>We’re here to help you!</h4>
                                    <p>Ask a question, manage request, report an issue. Our support team will get back to
                                        you by email.</p>
                                </div>
                                <div class="p-md-4">
                                    <a href="{{ route('support') }}" class="px-3 btn btn-outline-primary btn-sm">Get Support
                                        Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
