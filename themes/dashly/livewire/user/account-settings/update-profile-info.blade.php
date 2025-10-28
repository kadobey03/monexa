<div>
    <form action="" wire:submit.prevent='updateProfileInfo'>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-lg-3">
                    <label for="fullName" class="col-form-label">Tam Ad</label>
                </div>

                <div class="col-lg">
                    <input type="text" class="form-control" id="fullName" wire:model.defer='name' required>
                    <div class="invalid-feedback">Lütfen tam adınızı ekleyin</div>
                </div>
            </div> <!-- / .row -->

            <div class="row mb-4">
                <div class="col-lg-3">
                    <label for="phone" class="col-form-label">Telefon</label>
                </div>

                <div class="col-lg">
                    <input type="text" class="form-control" id="phone" wire:model.defer='phone' required>
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div> <!-- / .row -->

            <div class="row mb-4">
                <div class="col-lg-3">
                    <label for="emailAddress" class="col-form-label">E-posta adresi</label>
                </div>

                <div class="col-lg">
                    <input type="text" class="form-control" id="emailAddress" wire:model='email' readonly>
                    <div class="invalid-feedback">Lütfen e-posta adresinizi ekleyin</div>
                </div>
            </div> <!-- / .row -->

            <div class="row mb-4">
                <div class="col-lg-3">
                    <label for="country" class="col-form-label">Ülke</label>
                </div>

                <div class="col-lg">
                    <div class="mb-4">
                        <select class="form-select" required wire:model.defer='country'>
                            @include('auth.countries')
                        </select>
                        <div class="invalid-feedback">Lütfen bir ülke seçin</div>
                    </div>
                </div>
            </div> <!-- / .row -->
            <div class="row mb-4">
                <div class="col-lg-3">
                    <label class="col-form-label">Kullanıcı Adı</label>
                </div>
                <div class="col-lg">
                    <input type="text" class="form-control" wire:model='username' readonly>
                </div>
            </div> <!-- / .row -->
            <div class="d-flex justify-content-end mt-5">
                <button type="submit" class="btn btn-primary">
                    <div class="spinner-border spinner-border-sm" role="status" wire:loading>
                        <span class="visually-hidden">Yükleniyor...</span>
                    </div>
                    Değişiklikleri kaydet
                </button>
            </div>
        </div>
    </form>

</div>
