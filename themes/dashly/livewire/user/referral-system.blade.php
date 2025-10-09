<div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row" x-data="{
                        copied: false,
                        url: '{{ Auth::user()->ref_link }}',
                        username: '{{ Auth::user()->username }}',
                        copyToClipboard(text) {
                            if (!navigator.clipboard) {
                                return alert('Copying to clipboard only works on secure sites viewed through a modern browser.')
                            }
                            navigator.clipboard.writeText(text)
                                .then(() => {
                                    var toastOptions = {
                                        'closeButton': false,
                                        'debug': false,
                                        'newestOnTop': false,
                                        'progressBar': false,
                                        'positionClass': 'toast-top-right',
                                        'preventDuplicates': false,
                                        'onclick': null,
                                        'showDuration': '300',
                                        'hideDuration': '1000',
                                        'timeOut': '5000',
                                        'extendedTimeOut': '1000',
                                        'showEasing': 'swing',
                                        'hideEasing': 'linear',
                                        'showMethod': 'fadeIn',
                                        'hideMethod': 'fadeOut'
                                    };
                                    Command: toastr['success']('Panoya kopyalandı', 'Başarılı')
                                    toastr.options = toastOptions;
                                })
                        },
                    }">
                        <div class="col-md-8 offset-md-2 text-center">
                            <h4>Kullanıcıları referans bağlantınızı paylaşarak yönlendirebilirsiniz:</h4>

                            <div class="d-flex mt-2">
                                <input class="form-control me-3 fs-4" id="reflink" value="{{ Auth::user()->ref_link }}"
                                    readonly>
                                <div>
                                    <span x-show="copied" style="display: none" x-transition.scale.origin.right.opacity
                                        class="pr-2 text-sm">Kopyalandı!</span>
                                    <!-- Button -->
                                    <button class="clipboard btn btn-link px-0" data-clipboard-target="#key-02"
                                        data-bs-toggle="tooltip" data-bs-title="Copy to clipboard"
                                        x-on:click="copyToClipboard(url)">
                                        <i class="bi bi-clipboard fs-3"></i>
                                    </button>

                                </div>
                            </div>

                            <div>
                                <h4 class="mt-3 mb-0">veya Referans Kimliğiniz</h4>
                                <h4 class="text-primary h2 d-inline"> {{ Auth::user()->username }}</h4>
                                {{-- <input type="hidden" x-model="username" value="{{ Auth::user()->username }}"> --}}
                                <!-- Button -->
                                <button class="clipboard btn btn-link px-0" data-clipboard-target="#key-02"
                                    data-bs-toggle="tooltip" data-bs-title="Copy to clipboard"
                                    x-on:click="copyToClipboard(username)">
                                    <i class="bi bi-clipboard fs-3"></i>
                                </button>
                            </div>

                            @if ($parent)
                                <div class="mt-2 text-center">
                                    <i class="bi bi-person-up"></i>
                                    <span>Üst</span>
                                    <h4 class="h3 m-0">{{ $parent->name }}</h4>
                                </div>
                            @endif
                        </div>
                        @if (!$viewRef)
                            <div class="col-12 my-4">
                                <div>
                                    <ul class="nav nav-pills nav-fill">
                                        <li class="nav-item border rounded m-1">
                                            <a @class(['nav-link', 'active' => $level == 'Direct level']) aria-current="page" href="#"
                                                wire:click.prevent="changeLevel('Direct level')">Doğrudan seviye</a>
                                        </li>
                                        <li class="nav-item border rounded m-1">
                                            <a @class(['nav-link', 'active' => $level == 'Level 1']) href="#"
                                                wire:click.prevent="changeLevel('Level 1')">Seviye
                                                1</a>
                                        </li>
                                        <li class="nav-item border rounded m-1">
                                            <a @class(['nav-link', 'active' => $level == 'Level 2']) href="#"
                                                wire:click.prevent="changeLevel('Level 2')">Seviye
                                                2</a>
                                        </li>
                                        <li class="nav-item border rounded m-1">
                                            <a @class(['nav-link', 'active' => $level == 'Level 3']) href="#"
                                                wire:click.prevent="changeLevel('Level 3')">Seviye
                                                3</a>
                                        </li>
                                        <li class="nav-item border rounded m-1">
                                            <a @class(['nav-link', 'active' => $level == 'Level 4']) href="#"
                                                wire:click.prevent="changeLevel('Level 4')">Seviye
                                                4</a>
                                        </li>
                                        <li class="nav-item border rounded m-1">
                                            <a @class(['nav-link', 'active' => $level == 'Level 5']) href="#"
                                                wire:click.prevent="changeLevel('Level 5')">Seviye
                                                5</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-12">
                                <h5>{{ $level }} referansları</h5>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h6 class="m-0 h5">Toplam Yatırım</h6>
                                                <h3 class="m-0">
                                                    {{ $settings->currency }}{{ number_format($totalDeposit, '2', '.') }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h6 class="m-0 h5">Yatırılan Toplam Tutar</h6>
                                                <h3 class="m-0">
                                                    {{ $settings->currency }}{{ number_format($totalAmountInPlans, '2', '.') }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h6 class="m-0 h5">Referanslardan Elde Edilen Kar</h6>
                                                <h3 class="m-0">
                                                    {{ $settings->currency }}{{ number_format($totalProfit, '2', '.') }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h6 class="m-0 h5">Kazandınız</h6>
                                                <h3 class="m-0">
                                                    @php
                                                        if ($settings->referral_proffit_from == 'Deposit') {
                                                            $profitEarned = $totalDeposit * ($commision / 100);
                                                        } else {
                                                            $profitEarned = $totalProfit * ($commision / 100);
                                                        }
                                                    @endphp
                                                    {{ $settings->currency }}{{ number_format($profitEarned, '2', '.') }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($level == 'Direct level')
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Müşteri adı</th>
                                                    <th>Ref. seviyesi</th>
                                                    <th>Toplam Yatırım</th>
                                                    <th>Yatırılan Toplam Tutar</th>
                                                    <th>Elde Edilen Kar</th>
                                                    <th>Üst</th>
                                                    <th>Müşteri durumu</th>
                                                    <th>Kayıt tarihi</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($downlines as $ref)
                                                    <tr>
                                                        <td>{{ $ref['name'] }}</td>
                                                        <td>{{ $level }}</td>
                                                        <td>
                                                            {{ $settings->currency }}{{ number_format($ref['totalDeposit'], '2', '.') }}
                                                        </td>
                                                        <td>
                                                            {{ $settings->currency }}{{ number_format($ref['totalInvestment'], '2', '.') }}
                                                        </td>
                                                        <td>
                                                            {{ $settings->currency }}{{ number_format($ref['totalProfit'], '2', '.') }}
                                                        </td>
                                                        <td>Siz</td>
                                                        <td>
                                                            @if ($ref['status'] == 'active')
                                                                <span class="badge bg-success">Aktif</span>
                                                            @else
                                                                <span class="badge bg-danger">Aktif değil</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $ref['created_at'] }}</td>
                                                        <td>
                                                            <a wire:click.prevent="showDetails({{ $ref['id'] }})"
                                                                href="" class="btn btn-sm btn-info">Görüntüle</a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center py-3">
                                                            <i class="bi bi-database-fill-exclamation"
                                                                style="font-size: 50px"></i>
                                                            <p> Henüz referans yok</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $downlines->links() }}
                                @endif

                                @if ($level != 'Direct level')
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Müşteri adı</th>
                                                    <th>Ref. seviyesi</th>
                                                    <th>Toplam Yatırım</th>
                                                    <th>Yatırılan Toplam Tutar</th>
                                                    <th>Elde Edilen Kar</th>
                                                    <th>Üst</th>
                                                    <th>Müşteri durumu</th>
                                                    <th>Kayıt tarihi</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($children as $ref)
                                                    <tr>
                                                        <td>{{ $ref['name'] }}</td>
                                                        <td>{{ $level }}</td>
                                                        <td>
                                                            {{ $settings->currency }}{{ number_format($ref['totalDeposit'], '2', '.') }}
                                                        </td>
                                                        <td>
                                                            {{ $settings->currency }}{{ number_format($ref['totalInvestment'], '2', '.') }}
                                                        </td>
                                                        <td>
                                                            {{ $settings->currency }}{{ number_format($ref['totalProfit'], '2', '.') }}
                                                        </td>

                                                        <td>{{ $ref['parent']->name }}</td>
                                                        <td>
                                                            @if ($ref['status'] == 'active')
                                                                <span class="badge bg-success">Aktif</span>
                                                            @else
                                                                <span class="badge bg-danger">Aktif değil</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $ref['created_at'] }}</td>
                                                        <td>
                                                            @if ($refLevel !== 'Level 5 referrals')
                                                                <a wire:click.prevent="showDetails({{ $ref['id'] }})"
                                                                    href="" class="btn btn-sm btn-info">Görüntüle</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center py-3">
                                                            <i class="bi bi-database-fill-exclamation"
                                                                style="font-size: 50px"></i>
                                                            <p> Henüz {{ $level }} referansı yok</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endif
                        @if ($viewRef)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h6 class="m-0 h5">Toplam Yatırım</h6>
                                        <h3 class="m-0">
                                            {{ $settings->currency }}{{ number_format($totalDeposit, '2', '.') }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h6 class="m-0 h5">Yatırılan Toplam Tutar</h6>
                                        <h3 class="m-0">
                                            {{ $settings->currency }}{{ number_format($totalAmountInPlans, '2', '.') }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h6 class="m-0 h5">Referanslardan Elde Edilen Kar</h6>
                                        <h3 class="m-0">
                                            {{ $settings->currency }}{{ number_format($totalProfit, '2', '.') }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between mb-2">
                                <h3>{{ $user->name }} tarafından referans edildi</h3>
                                <div>
                                    <a wire:click.prevent="cancelShowDeatials" href=""
                                        class="btn btn-sm btn-danger">İptal</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Müşteri adı</th>
                                                <th>Toplam Yatırım</th>
                                                <th>Yatırılan Toplam Tutar</th>
                                                <th>Elde Edilen Kar</th>
                                                <th>Üst</th>
                                                <th>Müşteri durumu</th>
                                                <th>Kayıt tarihi</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($referrals as $ref)
                                                <tr>
                                                    <td>{{ $ref['name'] }}</td>
                                                    <td>
                                                        {{ $settings->currency }}{{ number_format($ref['totalDeposit'], '2', '.') }}
                                                    </td>
                                                    <td>
                                                        {{ $settings->currency }}{{ number_format($ref['totalInvestment'], '2', '.') }}
                                                    </td>
                                                    <td>
                                                        {{ $settings->currency }}{{ number_format($ref['totalProfit'], '2', '.') }}
                                                    </td>
                                                    <td>{{ $ref['parent']->name }}</td>
                                                    <td>
                                                        @if ($ref['status'] == 'active')
                                                            <span class="badge bg-success">Aktif</span>
                                                        @else
                                                            <span class="badge bg-danger">Aktif değil</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $ref['created_at'] }}</td>
                                                    <td>
                                                        @if ($refLevel !== 'Level 5 referrals')
                                                            <a wire:click.prevent="showDetails({{ $ref['id'] }})"
                                                                href="" class="btn btn-sm btn-info">Görüntüle</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-3">
                                                        <i class="bi bi-database-fill-exclamation"
                                                            style="font-size: 50px"></i>
                                                        <p>
                                                            {{ $user->name }} için henüz referans yok
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
