<div>
    <form method="post" wire:submit.prevent='save'>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="">Banka Adı</label>
                <input type="text" wire:model.defer='bankName' class="form-control " placeholder="Banka adını girin">
            </div>
            <div class="mb-3 col-md-6">
                <label class="">Hesap Adı</label>
                <input type="text" wire:model.defer='accountName' class="form-control "
                    placeholder="Hesap adını girin">
            </div>
            <div class="mb-3 col-md-6">
                <label class="">Hesap Numarası</label>
                <input type="text" wire:model.defer='accountNumber' class="form-control "
                    placeholder="Hesap numarasını girin">
            </div>
            <div class="mb-3 col-md-6">
                <label class="">Swift Kodu</label>
                <input type="text" wire:model.defer='swiftCode' class="form-control " placeholder="Swift kodunu girin">
            </div>
            <div class="mb-3 col-md-6">
                <label class="">Bitcoin</label>
                <input type="text" wire:model.defer='btcAddress' class="form-control "
                    placeholder="Bitcoin adresini girin">
                <small class="fs-6">Fonlarınızı çekmek için kullanılacak Bitcoin adresinizi girin</small>
            </div>
            <div class="mb-3 col-md-6">
                <label class="">Ethereum</label>
                <input type="text" wire:model.defer='ethAddress' class="form-control "
                    placeholder="Ethereum adresini girin">
                <small class="fs-6">Fonlarınızı çekmek için kullanılacak Ethereum adresinizi girin</small>
            </div>

            <div class="mb-3 col-md-6">
                <label class="">Litecoin</label>
                <input type="text" wire:model.defer='ltcAddress' class="form-control "
                    placeholder="Litecoin adresini girin">
                <small class="fs-6">Fonlarınızı çekmek için kullanılacak Litecoin adresinizi girin</small>
            </div>

            <div class="mb-3 col-md-6">
                <label>USDT.TRC20</label>
                <input type="text" wire:model.defer='usdtAddress' class="form-control"
                    placeholder="USDT.TRC20 adresini girin">
                <small class="fs-6">Fonlarınızı çekmek için kullanılacak USDT.TRC20 cüzdan adresinizi girin</small>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn btn-primary">
                <div class="spinner-border spinner-border-sm" role="status" wire:loading>
                    <span class="visually-hidden">Yükleniyor...</span>
                </div>
                Değişiklikleri kaydet
            </button>
        </div>
    </form>
</div>
