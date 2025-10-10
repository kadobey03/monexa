 <!-- Top Up Modal -->
 <div id="topupModal" class="modal fade" role="dialog">
     <div class="modal-dialog modal-lg modal-dialog-centered">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header bg-primary text-white">
                 <h4 class="modal-title">
                     <i class="fas fa-wallet me-2"></i>{{ $user->name }} Hesabına Kredi/Debit Uygula
                 </h4>
                 <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body p-4">
                 <form method="post" action="{{ route('topup') }}">
                     @csrf
                     <div class="row g-4">
                         <div class="col-md-6">
                             <label class="form-label fw-semibold">
                                 <i class="fas fa-dollar-sign me-2 text-primary"></i>Tutar
                             </label>
                             <input class="form-control form-control-lg" placeholder="Enter amount" type="number" name="amount" min="0.01" step="0.01" required>
                             <div class="invalid-feedback">
                                 Lütfen geçerli bir tutar giriniz (minimum 0.01).
                             </div>
                         </div>
                         <div class="col-md-6">
                             <label class="form-label fw-semibold">
                                 <i class="fas fa-exchange-alt me-2 text-primary"></i>Hesap Türü
                             </label>
                             <select class="form-select form-select-lg" name="type" required>
                                 <option value="" selected disabled>Select Account Type</option>
                                 <option value="Bonus">💰 Bonus</option>
                                 <option value="Profit">📈 Profit</option>
                                 <option value="Ref_Bonus">👥 Referral Bonus</option>
                                 <option value="balance">💳 Account Balance</option>
                                 <option value="Deposit">🏦 Deposit</option>
                             </select>
                         </div>
                     </div>
                     <div class="row g-4 mt-3">
                         <div class="col-12">
                             <label class="form-label fw-semibold">
                                 <i class="fas fa-plus-circle me-2 text-primary"></i>İşlem Türü
                             </label>
                             <select class="form-select form-select-lg" name="t_type" required>
                                 <option value="" selected disabled>Select Transaction Type</option>
                                 <option value="Credit">➕ Credit (Add Funds)</option>
                                 <option value="Debit">➖ Debit (Subtract Funds)</option>
                             </select>
                             <div class="alert alert-warning mt-2 py-2">
                                 <small><i class="fas fa-exclamation-triangle me-1"></i> <strong>Not:</strong> Depozitoları borçlandıramazsınız</small>
                             </div>
                         </div>
                     </div>
                     <div class="row g-3 mt-4">
                         <div class="col-12">
                             <input type="hidden" name="user_id" value="{{ $user->id }}">
                             <button type="submit" class="btn btn-primary btn-lg w-100" data-bs-toggle="tooltip" title="Bu işlem kullanıcı hesabına kredi veya debit uygular">
                                 <i class="fas fa-check me-2"></i>İşlemi Gerçekleştir
                             </button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /Top Up Modal -->



<!-- send a single user email Modal-->
<div id="Nostrades" class="modal fade" role="dialog">
    <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                 <h4 class="modal-title ">{{ $user->name }} {{ $user->l_name }} için para çekme öncesi işlem sayısı belirle </h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <form role="form" method="post" action="{{ route('numberoftrades') }}">
                     @csrf
                     {{-- <div class="form-group">
                         <h5 class=" ">On/Off</h5>
                         <select class="form-control" name="taxtype">
                             <option value="" selected disabled></option>

                                 <option value="on">On</option>
                                 <option value="off">Off</option>

                         </select>
                     </div> --}}
                     <div class="form-group">
                         <h5 class=" ">Para çekme öncesi işlem sayısı</h5>
                         <input type="number" name="numberoftrades" class="form-control" placeholder="{{ $user->numberoftrades }}" min="0" required>
                         <div class="invalid-feedback">
                             Lütfen geçerli bir işlem sayısı giriniz.
                         </div>
                     </div>

                     <div class="form-group">
                         <input type="submit" class="btn btn-info" value="Para Çekme İçin İşlem Sayısı Belirle" data-bs-toggle="tooltip" title="Kullanıcının para çekebilmesi için tamamlaması gereken minimum işlem sayısını belirler">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>




<!-- send a single user email Modal-->
 <div id="userTax" class="modal fade" role="dialog">
    <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                 <h4 class="modal-title ">{{ $user->name }} {{ $user->l_name }} için kullanıcı vergisini aç/kapat </h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <form role="form" method="post" action="{{ route('usertax') }}">
                     @csrf
                     <div class="form-group">
                         <h5 class=" ">Açık/Kapalı</h5>
                         <select class="form-control" name="taxtype">
                             <option value="" selected disabled></option>

                                 <option value="on">On</option>
                                 <option value="off">Off</option>

                         </select>
                     </div>
                     <div class="form-group">
                         <h5 class=" ">Amount</h5>
                         <input type="number" name="taxamount" class="form-control" min="0" max="100" step="0.01" placeholder="0.00">
                         <div class="invalid-feedback">
                             Lütfen 0-100 arasında geçerli bir vergi oranı giriniz.
                         </div>
                     </div>

                     <div class="form-group">
                         <input type="submit" class="btn btn-warning" value="Kullanıcı Vergisi Ekle" data-bs-toggle="tooltip" title="Kullanıcı için özel vergi oranı belirler">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>



<!-- Clear account Modal -->
<div id="clearacctModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title ">Hesabı Temizle</strong></h4>
                <button type="button" class="close " data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body ">
                <p class="">{{ $user->name }} kullanıcısının hesabını {{ $user->currency }}0.00 olarak temizliyorsunuz
                </p>
                <a class="btn " href="{{ url('admin/dashboard/clearacct') }}/{{ $user->id }}">Devam Et</a>
            </div>
        </div>
    </div>
</div>


<div id="withdrawalcode" class="modal fade" role="dialog">
    <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                 <h4 class="modal-title ">{{ $user->name }} {{ $user->l_name }} için para çekme kodunu girin </h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <form role="form" method="post" action="{{ route('withdrawalcode') }}">
                     @csrf
                      <div class="form-group">
                         <h5 class=" ">Para Çekme Kodu Durumunu Seçin</h5>
                         <select class="form-control  " name="withdrawal_code">


                                 <option value="on">On</option>
                                  <option value="off">Off</option>

                         </select>
                     </div>

                     <div class="form-group">
                         <h5 class=" ">Para Çekme Kodu</h5>
                         <input type="text" name="user_withdrawalcode" class="form-control" value="{{ $user->user_withdrawalcode }}" maxlength="50" required>
                         <div class="invalid-feedback">
                             Lütfen geçerli bir para çekme kodu giriniz.
                         </div>
                     </div>

                     <div class="form-group">
                         <input type="submit" class="btn btn-success" value="Kullanıcı Para Çekme Kodunu Belirle" data-bs-toggle="tooltip" title="Kullanıcı için özel para çekme kodu ve durumunu belirler">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /Clear account Modal -->
 <!-- send a single user email Modal-->
 <div id="sendmailtooneuserModal" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                 <h4 class="modal-title ">E-posta Gönder</h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <p class="">Bu mesaj {{ $user->name }} kullanıcısına gönderilecek</p>
                 <form style="padding:3px;" role="form" method="post" action="{{ route('sendmailtooneuser') }}">
                     @csrf
                     <div class=" form-group">
                         <input type="text" name="subject" class="form-control" placeholder="E-posta konusu" maxlength="100" required>
                         <div class="invalid-feedback">
                             Lütfen e-posta konusu giriniz (maksimum 100 karakter).
                         </div>
                     </div>
                     <div class=" form-group">
                         <textarea placeholder="Mesajınızı buraya yazın" class="form-control" name="message" rows="8"
                             maxlength="1000" required></textarea>
                         <div class="invalid-feedback">
                             Lütfen bir mesaj giriniz (maksimum 1000 karakter).
                         </div>
                     </div>
                     <div class=" form-group">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <input type="submit" class="btn btn-primary" value="Gönder" data-bs-toggle="tooltip" title="E-posta mesajını kullanıcıya gönderir">
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /Trading History Modal -->

 <div id="TradingModal" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                 <h4 class="modal-title ">Trade for {{ $user->name }} {{ $user->l_name }} </h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <form role="form" method="post" action="{{ route('addhistory') }}">
                     @csrf
                     <div class="form-group">
                        <h5 class=" ">Amount</h5>
                        <input type="number" name="amount" class="form-control" placeholder="İşlem tutarını giriniz {{ $user->currency }}" min="0.01" step="0.01" required>
                        <div class="invalid-feedback">
                            Lütfen geçerli bir işlem tutarı giriniz (minimum 0.01 {{ $user->currency }}).
                        </div>
                    </div>
                     <div class="form-group">
                         <h5 class=" ">Select Asset</h5>

                         <select class="form-control  " name="plan" required>
                             <option value="" selected disabled>Select Asset</option>
                             <optgroup label="Currency">
                                <option selected>EURUSD</option>
                                <option>EURJPY</option>
                                <option>USDJPY</option>
                                <option>USDCAD</option>
                                <option>AUDUSD</option>
                                <option>AUDJPY</option>
                                <option>NZDUSD</option>
                                <option>GBPUSD</option>
                                <option>GBPJPY</option>
                                <option>USDCHF</option>
                            </optgroup>
                            <optgroup label="Crypto-Currency">
                                <option>BTCUSD</option>
                                <option>ETHUSD</option>
                                <option>BCHUSD</option>
                                <option>XRPUSD</option>
                                <option>LTCUSD</option>
                                <option>ETHBTC</option>
                            </optgroup>
                            <optgroup label="Stocks">
                                <option>CITI</option>
                                <option>SNAP</option>
                                <option>EA</option>
                                <option>MSFT</option>
                                <option>CSCO</option>
                                <option>GOOG</option>
                                <option>FB</option>
                                <option>SBUX</option>
                                <option>INTC</option>
                            </optgroup>
                            <optgroup label="Indices">
                                <option>SPX500USD</option>
                                <option>MXX</option>
                                <option>XAX</option>
                                <option>INDEX:STI</option>
                            </optgroup>
                            <optgroup label="Commodities">
                                <option>GOLD</option>
                                <option>RB1!</option>
                                <option>USOIL</option>
                                <option>SILVER</option>
                            </optgroup>
                         </select>
                     </div>


                     <div class="form-group">
                        <select class="form-control" name="leverage" id="leverage" required>
                            <option selected disable value="">Leverage</option><option value="10">1:10</option><option value="20">1:20</option><option value="30">1:30</option><option value="40">1:40</option><option value="50">1:50</option><option value="60">1:60</option><option value="70">1:70</option><option value="80">1:80</option><option value="90">1:90</option><option value="100">1:100</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="expire" id="expire" required>
                            <option selected disable value="">Expiration</option>
                            <option value="1 Minutes">1 Minute</option>
                            <option value="5 Minutes">5 Minutes</option>
                            <option value="15 Minutes">15 Minutes</option>
                            <option value="30 Minutes">30 Minutes</option>
                            <option value="60 Minutes">1 Hour</option>
                            <option value="4 Hours">4 Hours</option>
                            <option value="1 Days">1 Day</option>
                            <option value="2 Days">2 Days</option>
                            <option value="7 Days">7 Days</option>
                        </select>
                    </div>
                     <div class="form-group">
                         <h5 class=" ">Profit/Loss</h5>
                         <select class="form-control  " name="type" required>
                             <option value="" selected disabled>Select type  profit/loss</option>
                             <option value="WIN">Profit</option>
                             <option value="LOSE">Loss</option>
                         </select>
                     </div>

                     <div class="form-group">
                        <h5 class=" ">Trade Type</h5>
                        <select class="form-control  " name="tradetype" required>
                            <option value="" selected disabled>Select type  Buy/Sell</option>
                            <option value="Buy">Buy</option>
                            <option value="Sell">Sell</option>
                        </select>
                    </div>
                     <div class="form-group">
                         <input type="submit" class="btn btn-primary" value="İşlem Yap" data-bs-toggle="tooltip" title="Kullanıcı için manuel işlem oluşturur">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /send a single user email Modal -->



 {{-- Create signal --}}

 <div id="Signal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title ">Create Signal for {{ $user->name }} {{ $user->l_name }} </h4>
                <button type="button" class="close " data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body ">
                <form role="form" method="post" action="{{ route('addsignalhistory') }}">
                    @csrf

                    <div class="form-group">
                        <h5 class=" ">Select Asset</h5>

                        <select class="form-control  " name="asset" required>
                            <option value="" selected disabled>Select Asset</option>
                            <optgroup label="Currency">
                               <option selected>EURUSD</option>
                               <option>EURJPY</option>
                               <option>USDJPY</option>
                               <option>USDCAD</option>
                               <option>AUDUSD</option>
                               <option>AUDJPY</option>
                               <option>NZDUSD</option>
                               <option>GBPUSD</option>
                               <option>GBPJPY</option>
                               <option>USDCHF</option>
                           </optgroup>
                           <optgroup label="Crypto-Currency">
                               <option>BTCUSD</option>
                               <option>ETHUSD</option>
                               <option>BCHUSD</option>
                               <option>XRPUSD</option>
                               <option>LTCUSD</option>
                               <option>ETHBTC</option>
                           </optgroup>
                           <optgroup label="Stocks">
                               <option>CITI</option>
                               <option>SNAP</option>
                               <option>EA</option>
                               <option>MSFT</option>
                               <option>CSCO</option>
                               <option>GOOG</option>
                               <option>FB</option>
                               <option>SBUX</option>
                               <option>INTC</option>
                           </optgroup>
                           <optgroup label="Indices">
                               <option>SPX500USD</option>
                               <option>MXX</option>
                               <option>XAX</option>
                               <option>INDEX:STI</option>
                           </optgroup>
                           <optgroup label="Commodities">
                               <option>GOLD</option>
                               <option>RB1!</option>
                               <option>USOIL</option>
                               <option>SILVER</option>
                           </optgroup>
                        </select>
                    </div>


                    <div class="form-group">
                       <select class="form-control" name="leverage" id="leverage" required>
                           <option selected disable value="">Leverage</option><option value="10">1:10</option><option value="20">1:20</option><option value="30">1:30</option><option value="40">1:40</option><option value="50">1:50</option><option value="60">1:60</option><option value="70">1:70</option><option value="80">1:80</option><option value="90">1:90</option><option value="100">1:100</option>
                       </select>
                   </div>

                   <div class="form-group">
                    <h5 class=" ">Tutar</h5>
                    <input type="number" name="amount" class="form-control" placeholder="Sinyal tutarını giriniz {{ $user->currency }}" min="0.01" step="0.01" required>
                    <div class="invalid-feedback">
                        Lütfen geçerli bir sinyal tutarı giriniz (minimum 0.01 {{ $user->currency }}).
                    </div>
                </div>
                   <div class="form-group">
                       <select class="form-control" name="expire"  required>
                           <option selected disable value="">Expiration</option>
                           <option value="1 Minutes">1 Minute</option>
                           <option value="5 Minutes">5 Minutes</option>
                           <option value="15 Minutes">15 Minutes</option>
                           <option value="30 Minutes">30 Minutes</option>
                           <option value="60 Minutes">1 Hour</option>
                           <option value="4 Hours">4 Hours</option>
                           <option value="1 Days">1 Day</option>
                           <option value="2 Days">2 Days</option>
                           <option value="7 Days">7 Days</option>
                       </select>
                   </div>
                    {{-- <div class="form-group">
                        <h5 class=" ">Profit/Loss</h5>
                        <select class="form-control  " name="type" required>
                            <option value="" selected disabled>Select type  profit/loss</option>
                            <option value="WIN">Profit</option>
                            <option value="LOSE">Loss</option>
                        </select>
                    </div> --}}

                    <div class="form-group">
                       <h5 class=" ">Order Type</h5>
                       <select class="form-control  " name="order_type" required>
                           <option value="" selected disabled>Select type  Buy/Sell</option>
                           <option value="Buy">Buy</option>
                           <option value="Sell">Sell</option>
                       </select>
                   </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Sinyal Oluştur" data-bs-toggle="tooltip" title="Kullanıcı için manuel sinyal oluşturur">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

 {{-- End creating signal --}}

 {{-- Start Add Plan History --}}



<div id="Planhistory" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title ">Add Trading History for {{ $user->name }} {{ $user->l_name }} </h4>
                <button type="button" class="close " data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body ">
                <form role="form" method="post" action="{{ route('addplanhistory') }}">
                    @csrf
                    <div class="form-group">
                        <h5 class=" ">Select Investment Plan</h5>
                        <select class="form-control  " name="plan">
                            <option value="" selected disabled>Select Plan</option>
                            @foreach ($pl as $plns)
                                <option value="{{ $plns->name }}">{{ $plns->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <h5 class=" ">Amount</h5>
                        <input type="number" name="amount" class="form-control" placeholder="Plan tutarını giriniz" min="0.01" step="0.01" required>
                        <div class="invalid-feedback">
                            Lütfen geçerli bir plan tutarı giriniz (minimum 0.01).
                        </div>
                    </div>
                    <div class="form-group">
                        <h5 class=" ">Type</h5>
                        <select class="form-control  " name="type">
                            <option value="" selected disabled>Select type</option>
                            <option value="Bonus">Bonus</option>
                            <option value="ROI">ROI</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-secondary" value="Geçmiş Ekle" data-bs-toggle="tooltip" title="Kullanıcı için plan geçmiş kaydı ekler">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End plan  History --}}
 <!-- Edit user Modal -->
 <div id="edituser" class="modal fade" role="dialog">
     <div class="modal-dialog modal-lg modal-dialog-centered">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header bg-success text-white">
                 <h4 class="modal-title">
                     <i class="fas fa-user-edit me-2"></i>Edit {{ $user->name }} Details
                 </h4>
                 <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body p-4">
                 <form role="form" method="post" action="{{ route('edituser') }}">
                     @csrf
                     <div class="row g-4">
                         <div class="col-md-6">
                             <label class="form-label fw-semibold">
                                 <i class="fas fa-user me-2 text-success"></i>Username
                             </label>
                             <input class="form-control form-control-lg" id="input1" value="{{ $user->username }}" type="text" name="username" pattern="[a-zA-Z0-9_]{3,50}" maxlength="50" required>
                             <div class="invalid-feedback">
                                 Kullanıcı adı 3-50 karakter arası olmalı ve sadece harf, rakam ve alt çizgi içerebilir.
                             </div>
                             <small class="text-muted mt-1 d-block">
                                 <i class="fas fa-info-circle me-1"></i>Note: Same username should be used in the referral link.
                             </small>
                         </div>
                         <div class="col-md-6">
                             <label class="form-label fw-semibold">
                                 <i class="fas fa-signature me-2 text-success"></i>Full Name
                             </label>
                             <input class="form-control form-control-lg" value="{{ $user->name }}" type="text" name="name" required>
                         </div>
                     </div>
                     <div class="row g-4 mt-3">
                         <div class="col-md-6">
                             <label class="form-label fw-semibold">
                                 <i class="fas fa-envelope me-2 text-success"></i>Email Address
                             </label>
                             <input class="form-control form-control-lg" value="{{ $user->email }}" type="email" name="email" maxlength="100" required>
                             <div class="invalid-feedback">
                                 Lütfen geçerli bir e-posta adresi giriniz.
                             </div>
                         </div>
                         <div class="col-md-6">
                             <label class="form-label fw-semibold">
                                 <i class="fas fa-phone me-2 text-success"></i>Phone Number
                             </label>
                             <input class="form-control form-control-lg" value="{{ $user->phone }}" type="tel" name="phone" pattern="[+]?[0-9\s\-\(\)]{10,20}" maxlength="20" required>
                             <div class="invalid-feedback">
                                 Lütfen geçerli bir telefon numarası giriniz.
                             </div>
                         </div>
                     </div>
                     <div class="row g-4 mt-3">
                         <div class="col-md-6">
                             <label class="form-label fw-semibold">
                                 <i class="fas fa-flag me-2 text-success"></i>Country
                             </label>
                             <input class="form-control form-control-lg" value="{{ $user->country }}" type="text" name="country">
                         </div>
                         <div class="col-md-6">
                             <label class="form-label fw-semibold">
                                 <i class="fas fa-money-bill me-2 text-success"></i>Currency
                             </label>
                             <input name="s_currency" value="{{$user->currency}}" id="s_c" type="hidden">
                             <select name="currency" id="select_c" class="form-select form-select-lg select2" onchange="changecurr()" style="width: 100%">
                                 <option value="{{$user->currency}}">{{ $user->currency }}</option>
                                 @foreach ($currencies as $key => $currency)
                                     <option id="{{ $key }}" value="<?php echo html_entity_decode($currency); ?>">
                                         {{ $key . ' (' . html_entity_decode($currency) . ')' }}</option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                     <div class="row g-4 mt-3">
                         <div class="col-12">
                             <label class="form-label fw-semibold">
                                 <i class="fas fa-link me-2 text-success"></i>Referral Link
                             </label>
                             <input class="form-control form-control-lg" value="{{ $user->ref_link }}" type="url" name="ref_link" required>
                         </div>
                     </div>
                     <div class="row g-3 mt-4">
                         <div class="col-12">
                             <input type="hidden" name="user_id" value="{{ $user->id }}">
                             <button type="submit" class="btn btn-success btn-lg w-100" data-bs-toggle="tooltip" title="Kullanıcı bilgilerini günceller">
                                 <i class="fas fa-save me-2"></i>Kullanıcı Bilgilerini Güncelle
                             </button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /Edit user Modal -->

 <!-- Reset user password Modal -->
 <div id="resetpswdModal" class="modal fade" role="dialog">
     <div class="modal-dialog modal-dialog-centered">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header bg-warning text-dark">
                 <h4 class="modal-title">
                     <i class="fas fa-key me-2"></i>Reset User Password
                 </h4>
                 <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body p-4 text-center">
                 <div class="mb-4">
                     <i class="fas fa-lock fa-4x text-warning mb-3"></i>
                     <h5 class="mb-3">Reset Password for {{ $user->name }}?</h5>
                     <div class="alert alert-warning py-3">
                         <p class="mb-2">The password will be reset to: <strong>user01236</strong></p>
                         <small class="text-muted">Make sure to inform the user about this change.</small>
                     </div>
                 </div>
                 <div class="row g-3">
                     <div class="col-6">
                         <button type="button" class="btn btn-secondary btn-lg w-100" data-dismiss="modal">
                             <i class="fas fa-times me-2"></i>Cancel
                         </button>
                     </div>
                     <div class="col-6">
                         <a class="btn btn-warning btn-lg w-100" href="{{ url('admin/dashboard/resetpswd') }}/{{ $user->id }}" onclick="return confirm('{{ $user->name }} kullanıcısının şifresini gerçekten sıfırlamak istiyor musunuz? Yeni şifre: user01236')">
                             <i class="fas fa-key me-2"></i>Şifreyi Sıfırla
                         </a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- /Reset user password Modal -->


  <!-- Trading Progress Modal -->
  <div id="tradingProgressModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-{{$bg}}">
                <h4 class="modal-title text-{{$text}}">Set Trading Signal</strong></h4>

            </div>
            <div class="modal-body bg-{{$bg}}">
                <form role="form" method="post" action="{{route('tradingprogress')}}">
                    <div class="form-group">
                        <h5 class=" text-{{$text}}">Trading Signal %</h5>
                        <input class="form-control bg-{{$bg}} text-{{$text}}" value="{{$user->progress}}" type="number" name="progress" min="0" max="100" step="0.1" required>
                        <div class="invalid-feedback">
                            Lütfen 0-100 arasında geçerli bir yüzde değeri giriniz.
                        </div>
                         <small>Signal strength in %. For signal strength to show on user dashoard increase its value </small>
                    </div>


                    <div class="form-group">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <input type="submit" class="btn btn-{{$text}}" value="Sinyal Gücünü Güncelle" data-bs-toggle="tooltip" title="Kullanıcı için sinyal gücünü belirler">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Trading Progress Modal password Modal -->

 <!-- Switch useraccount Modal -->
 <div id="switchuserModal" class="modal fade" role="dialog">
     <div class="modal-dialog modal-dialog-centered">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header bg-info text-white">
                 <h4 class="modal-title">
                     <i class="fas fa-exchange-alt me-2"></i>Login as {{ $user->name }}
                 </h4>
                 <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body p-4 text-center">
                 <div class="mb-4">
                     <i class="fas fa-user-circle fa-4x text-info mb-3"></i>
                     <h5 class="mb-3">Switch to {{ $user->name }}'s Account?</h5>
                     <p class="text-muted mb-0">
                         You will be logged in as this user. You can return to admin panel anytime.
                     </p>
                 </div>
                 <div class="row g-3">
                     <div class="col-6">
                         <button type="button" class="btn btn-secondary btn-lg w-100" data-dismiss="modal">
                             <i class="fas fa-times me-2"></i>Cancel
                         </button>
                     </div>
                     <div class="col-6">
                         <a class="btn btn-info btn-lg w-100" href="{{ url('admin/dashboard/switchuser') }}/{{ $user->id }}" onclick="return confirm('{{ $user->name }} kullanıcısı olarak giriş yapmak istediğinizden emin misiniz? Yönetici paneline istediğiniz zaman dönebilirsiniz.')">
                             <i class="fas fa-sign-in-alt me-2"></i>Kullanıcı Hesabına Geç
                         </a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- /Switch user account Modal -->

 <div id="notifyuser" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title ">Notify {{$user->username}} Dashboard</h4>
                <button type="button" class="close " data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body ">
                <p class="">This show notice on  {{ $user->name }} Dashboard</p>
                <form style="padding:3px;" role="form" method="post" action="{{ route('notifyuser') }}">
                    @csrf
                    <div class=" form-group">
                        <label>Turn on/off  Dashboard Notification : {{$user->notify}}</label>
                        <select class="form-control  " name="notifystatus">

                            <option value="on">On</option>
                                <option value="off">Off</option>

                        </select>
                    </div>
                    <div class=" form-group">
                        <textarea placeholder="Bildirim mesajınızı yazınız" class="form-control" name="notify" rows="8"
                            maxlength="500" required></textarea>
                        <div class="invalid-feedback">
                            Lütfen bir bildirim mesajı giriniz (maksimum 500 karakter).
                        </div>
                    </div>
                    <div class=" form-group">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="submit" class="btn btn-info" value="Gönder" data-bs-toggle="tooltip" title="Bildirim mesajını kullanıcı paneline gönderir">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- upgrade User plan status  --}}
<div id="ugpradePlanStatus" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title ">Turn on/off {{$user->username}} Plan Upgrade status </h4>
                <button type="button" class="close " data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body ">
                <p class="">This will show Upgrade Plan notice on  {{ $user->name }} Dashboard</p>
                <form style="padding:3px;" role="form" method="post" action="{{ route('upgradeplanstatus') }}">
                    @csrf
                    <div class=" form-group">
                        <label>Turn on/off Plan Upgrade Status : {{$user->plan_status}}</label>
                        <select class="form-control  " name="planstatus">

                            <option value="on">On</option>
                                <option value="off">Off</option>

                        </select>
                    </div>
                    <div class=" form-group">
                        <select class="form-control  " name="user_plan">
                          @foreach($plans as $plan)
                            <option value="{{ $plan->name }}">{{ $plan->name }}</option>
                            @endforeach


                        </select>
                    </div>
                    <div class=" form-group">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="submit" class="btn btn-warning" value="Planı Yükselt" data-bs-toggle="tooltip" title="Kullanıcı için plan yükseltme durumunu ayarlar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



{{-- upgrade User Signal status  --}}
<div id="ugpradeSignalStatus" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title ">Turn on/off {{$user->username}} Signal Upgrade status </h4>
                <button type="button" class="close " data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body ">
                <p class="">This will show Upgrade Signal notice on  {{ $user->name }} Dashboard</p>
                <form style="padding:3px;" role="form" method="post" action="{{ route('upgradesignalstatus') }}">
                    @csrf
                    <div class=" form-group">
                        <label>Turn on/off Signal Upgrade Status : {{$user->signal_status}}</label>
                        <select class="form-control  " name="signal_status">

                            <option value="on">On</option>
                                <option value="off">Off</option>

                        </select>
                    </div>
                    <div class=" form-group">
                        <select class="form-control  " name="user_signal">
                          @foreach($signals as $signal)
                            <option value="{{ $signal->name }}">{{ $signal->name }}</option>
                            @endforeach


                        </select>
                    </div>
                    <div class=" form-group">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="submit" class="btn btn-info" value="Sinyali Yükselt" data-bs-toggle="tooltip" title="Kullanıcı için sinyal yükseltme durumunu ayarlar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- Delete user Modal -->
 <div id="deleteModal" class="modal fade" role="dialog">
     <div class="modal-dialog modal-dialog-centered">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header bg-danger text-white">
                 <h4 class="modal-title">
                     <i class="fas fa-exclamation-triangle me-2"></i>Delete User Account
                 </h4>
                 <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body p-4 text-center">
                 <div class="mb-4">
                     <i class="fas fa-user-times fa-4x text-danger mb-3"></i>
                     <h5 class="mb-3">Delete {{ $user->name }}'s Account?</h5>
                     <p class="text-muted mb-0">
                         This action is irreversible. All data associated with this account will be permanently lost.
                     </p>
                 </div>
                 <div class="row g-3">
                     <div class="col-6">
                         <button type="button" class="btn btn-secondary btn-lg w-100" data-dismiss="modal">
                             <i class="fas fa-times me-2"></i>Cancel
                         </button>
                     </div>
                     <div class="col-6">
                         <a class="btn btn-danger btn-lg w-100" href="{{ url('admin/dashboard/delsystemuser') }}/{{ $user->id }}" onclick="return confirm('Bu işlem geri alınamaz. {{ $user->name }} kullanıcısını gerçekten silmek istiyor musunuz?')">
                             <i class="fas fa-trash me-2"></i>Evet, Hesabı Sil
                         </a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- /Delete user Modal -->
