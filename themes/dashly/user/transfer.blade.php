@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <div>
        <!-- Title -->
        <h1 class="h2 m-0">
            Fon transferi
        </h1>
        <p class="m-0">{{ $settings->site_name }} üzerinde kayıtlı olan arkadaşlarınıza ve sevdiklerinize para gönderebilirsiniz.</p>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3 py-5">
                            <form method="post" action="javascript:void(0)" id="transferform">
                                @csrf
                                <div class="mb-3">
                                    <label>Alıcı E-posta veya kullanıcı adı</label>
                                    <input type="text" name="email" class="form-control mt-2" required>
                                </div>
                                <div class="mb-3">
                                    <label>Miktar({{ $settings->currency }})</label>
                                    <input type="number" min="{{ $moresettings->min_transfer }}" name="amount"
                                        placeholder="Alıcıya transfer etmek istediğiniz miktarı girin"
                                        class="form-control mt-2" required>
                                </div>
                                <div class="mb-3">
                                    <h6>
                                        Transfer Ücretleri:
                                        <strong class=" text-danger">{{ $moresettings->transfer_charges }}%</strong>
                                    </h6>
                                </div>
                                <input type="hidden" name="password" id="acntpass">
                                <div>
                                    <button type="reset" class="btn btn-dark">Temizle</button>
                                    <input type="submit" id="subbtn" class="py-2 btn btn-primary" value="Devam Et">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#transferform').on('submit', function() {
            (async () => {
                const {
                    value: password
                } = await Swal.fire({
                    title: 'Şifrenizi girin',
                    input: 'password',
                    inputLabel: 'Transferi tamamlamak için hesap şifrenizi girin',
                    inputPlaceholder: 'Hesap şifrenizi girin'
                })

                if (password) {

                    document.getElementById('acntpass').value = password;
                    $("#subbtn").attr("disabled", "disabled").val('Lütfen bekleyin....');
                    $.ajax({
                        url: "{{ route('transfertouser') }}",
                        type: 'POST',
                        data: $('#transferform').serialize(),
                        success: function(response) {
                            if (response.status === 200) {
                                Swal.fire({
                                    title: 'Başarılı!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'Harika'
                                });
                                $("#subbtn").removeAttr("disabled").val('Proceed');
                                setTimeout(() => {
                                    let url = "{{ url('/dashboard/transfer-funds') }}";
                                    window.location.href = url;
                                }, 3000);
                            } else {
                                $("#subbtn").removeAttr("disabled").val('Proceed');
                                Swal.fire({
                                    title: 'Hata!',
                                    text: response.message,
                                    icon: 'error',
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        },

                    });
                } else {
                    Swal.fire({
                        title: 'Hata!',
                        text: 'Şifre gerekli',
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    })
                }

            })()

        });
    </script>
@endpush
