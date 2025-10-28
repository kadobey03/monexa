<div>
    <!-- Table -->
    <div class="table-responsive">
        <table id="notificationsTable" class="table align-middle">
            <thead class="thead-light">
                <tr>
                    <th class="text-uppercase py-4 align-middle min-w-300px min-w-md-auto">Tür</th>
                    <th class="text-center text-uppercase py-4">
                                            Evet
                                        </th>
                    <th class="text-center text-uppercase py-4">
                                            Hayır
                                        </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <h3 class="h4 mb-0">Para çekme sırasında e-posta bildirimi etkinleştir</h3>
                        <p class="small text-muted mb-0">Fonlarımı çekerken e-postama onay OTP gönder.</p>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnWithdrawal' type="radio"
                                value="Yes">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnWithdrawal' type="radio"
                                value="No">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3 class="h4 mb-0">Kar bildirimleri için e-posta etkinleştir</h3>
                        <p class="small text-muted mb-0">Kar aldığımda bana e-posta gönder</p>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnRoi' type="radio" value="Yes">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnRoi' type="radio" value="No">
                        </div>
                    </td>

                </tr>
                <tr>
                    <td>
                        <h3 class="h4 mb-0">Süre sonu bildirimleri için e-posta etkinleştir</h3>
                        <p class="small text-muted mb-0">Yatırım planım süresi dolduğunda bana e-posta gönder</p>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnExpiration' type="radio"
                                value="Yes">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnExpiration' type="radio"
                                value="No">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> <!-- / .table-responsive -->
    <div class="d-flex justify-content-end mt-5">
        <!-- Button -->
        <button type="button" wire:click='saveEmails' class="btn btn-primary">Değişiklikleri kaydet</button>
    </div>
</div>
