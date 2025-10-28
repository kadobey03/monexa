@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <div class="d-flex justify-content-between">
        <h1 class="h2">
            Kurs detayları
        </h1>
        <div>
            <a href="{{ route('user.courses') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-left"></i>
                Geri
            </a>
        </div>
    </div>

    @if (in_array(auth()->user()->id, $whoPurchased))
        <div class="alert alert-success" role="alert">
            Bu kursu zaten satın aldınız.
        </div>
    @endif

    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-8 order-2">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h4>{{ $course->course_title }}</h4>
                    </div>
                    <div class="p-2 d-lg-flex justify-content-lg-between align-items-center mt-3">
                        <div class="mt-2 mt-lg-0">
                            <p class="m-0 text-primary font-weight-bold">TARAFINDAN OLUŞTURULDU</p>
                            <P class="m-0">{{ $settings->site_name }}</P>
                        </div>
                        <div class="mt-2 mt-lg-0">
                            <p class="m-0 text-primary font-weight-bold">KATEGORİ</p>
                            <P class="m-0">{{ $course->category }}</P>
                        </div>
                        <div class="mt-2 mt-lg-0">
                            <p class="m-0 text-primary font-weight-bold">SON GÜNCELLENDİ</p>
                            <P class="m-0">{{ \Carbon\Carbon::parse($course->updated_at)->toDayDateTimeString() }}</P>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4>Kurs Hakkında</h4>
                        <p class="mt-2">
                            {{ $course->description }}
                        </p>
                    </div>
                    <div class="mt-5">
                        <h4>Kurs Dersleri</h4>
                        @forelse ($lessons as $lesson)
                            <div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <i class="bi bi-play-circle-fill text-danger fs-2"></i>
                                        &nbsp; &nbsp;
                                        <div>
                                            <h6 class="h6 m-0">{{ $lesson->title }}</h6>
                                            <small class="text-muted d-block">{{ $lesson->description }}</small>
                                            <small class="text-muted">
                                                <i class="bi bi-clock-history"></i>
                                                {{ $lesson->length }}
                                            </small>
                                        </div>
                                    </div>
                                    <div>
                                        @if ($lesson->locked == 'true')
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#preview{{ $lesson->id }}"
                                                class="btn btn-primary btn-sm">Önizleme</a>
                                            <i class="bi bi-unlock"></i>
                                        @else
                                            <i class="bi bi-lock"></i>
                                        @endif
                                    </div>
                                </div>
                                <div style="border-top: 1px dashed black;" class="my-3"></div>
                            </div>

                            @if ($loop->iteration == 5)
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <div>
                                                <h6 class="h6 m-0">{{ $loop->remaining }} Daha Fazla
                                                    Ders{{ $loop->remaining > 1 ? 'ler' : '' }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @break($loop->iteration == 5)
                            <!-- Modal -->
                            <div class="modal fade" tabindex="-1" id="preview{{ $lesson->id }}"
                                aria-h6ledby="exampleModalh6" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe width="100%" height="400" class="embed-responsive-item"
                                                src="{{ $lesson->video_link }}" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End modal --}}
                        @empty
                            <div class="text-center py-3">
                                <p>Veri Mevcut Değil</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="{{ str_starts_with($course->course_image, 'http') ? $course->course_image : asset('storage/' . $course->course_image) }}"
                    class="card-img-top" alt="course image">
                <div class="card-body">
                    @if (in_array(auth()->user()->id, $whoPurchased))
                        <a href="{{ route('user.mycoursedetails', $course->id) }}"
                            class="btn btn-primary btn-lg py-3 btn-block rounded-none rounded-0">Dersi
                            İzle</a>
                    @else
                        <h2 class="font-weight-bolder text-black">
                            {{ !$course->amount ? 'Ücretsiz' : $settings->currency . number_format($course->amount) }}
                        </h2>
                        <button class="btn btn-danger btn-lg py-3 btn-block rounded-none rounded-0" data-bs-toggle="modal"
                            data-bs-target="#buyModal">Şimdi Satın Al</button>
                    @endif
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <p class="mb-3">
                                {{ !$course->amount ? $settings->currency . '0' : $settings->currency . number_format($course->amount) }}
                                hesap bakiyenizden düşülecektir.
                            </p>
                            <form action="{{ route('user.buycourse') }}" method="post">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $course->amount }}">
                                <input type="hidden" name="course" value="{{ $course->id }}">
                                <button type="submit" class="btn btn-primary btn-block">Şimdi satın al</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
