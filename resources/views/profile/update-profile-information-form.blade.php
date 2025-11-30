<div class="profile-form-wrapper">
    <form method="POST" action="javascript:void(0)" id="updateprofileform" class="space-y-6">
        @csrf

        <!-- Profile Information Section -->
        <div class="space-y-6">
            <!-- Full Name -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                <div class="md:col-span-1">
                    <label for="fullName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('user.profile.form.full_name') }}
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('user.profile.form.display_name') }}</p>
                </div>
                <div class="md:col-span-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon name="user" class="h-5 w-5 text-gray-400" />
                        </div>
                        <input type="text"
                               id="fullName"
                               name="name"
                               value="{{ Auth::user()->name }}"
                               required
                               class="pl-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm py-4"
                        >
                    </div>
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400 hidden">{{ __('user.profile.form.full_name_error') }}</p>
                </div>
            </div>

            <!-- Phone -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                <div class="md:col-span-1">
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('user.profile.form.phone_number') }}
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('user.profile.form.phone_description') }}</p>
                </div>
                <div class="md:col-span-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon name="phone" class="h-5 w-5 text-gray-400" />
                        </div>
                        <input type="text"
                               id="phone"
                               name="phone"
                               value="{{ Auth::user()->phone }}"
                               required
                               class="pl-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm py-4"
                        >
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                <div class="md:col-span-1">
                    <label for="emailAddress" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('user.profile.form.email_address') }}
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('user.profile.form.email_description') }}</p>
                </div>
                <div class="md:col-span-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon name="envelope" class="h-5 w-5 text-gray-400" />
                        </div>
                        <input type="text"
                               id="emailAddress"
                               name="email"
                               value="{{ Auth::user()->email }}"
                               readonly
                               class="pl-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:text-gray-300 sm:text-sm py-4 cursor-not-allowed"
                        >
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center">
                            <x-heroicon name="information-circle" class="h-3.5 w-3.5 mr-1 text-gray-400" />
                            {{ __('user.profile.form.email_readonly') }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Country -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">
                <div class="md:col-span-1">
                    <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('user.profile.form.country') }}
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('user.profile.form.country_description') }}</p>
                </div>
                <div class="md:col-span-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon name="globe" class="h-5 w-5 text-gray-400" />
                        </div>
                        <select
                            name="country"
                            id="country"
                            required
                            class="pl-10 pr-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm py-4 appearance-none"
                        >
                            <option value="{{ Auth::user()->country }}" selected disabled>{{ Auth::user()->country }}</option>
                            <option value="Afganistan">Afganistan</option>
                            <option value="Albania">Arnavutluk</option>
                            <option value="Algeria">Cezayir</option>
                            <option value="American Samoa">Amerikan Samoası</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antigua & Barbuda">Antigua ve Barbuda</option>
                            <option value="Argentina">Arjantin</option>
                            <option value="Armenia">Ermenistan</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Avustralya</option>
                            <option value="Austria">Avusturya</option>
                            <option value="Azerbaijan">Azerbaycan</option>
                            <option value="Bahamas">Bahamalar</option>
                            <option value="Bahrain">Bahreyn</option>
                            <option value="Bangladesh">Bangladeş</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belçika</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Butan</option>
                            <option value="Bolivia">Bolivya</option>
                            <option value="Bonaire">Bonaire</option>
                            <option value="Bosnia & Herzegovina">Bosna Hersek</option>
                            <option value="Botswana">Botsvana</option>
                            <option value="Brazil">Brezilya</option>
                            <option value="British Indian Ocean Ter">Britanya Hint Okyanusu Toprakları</option>
                            <option value="Brunei">Brunei</option>
                            <option value="Bulgaria">Bulgaristan</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Kamboçya</option>
                            <option value="Cameroon">Kamerun</option>
                            <option value="Canada">Kanada</option>
                            <option value="Canary Islands">Kanarya Adaları</option>
                            <option value="Cape Verde">Yeşil Burun Adaları</option>
                            <option value="Cayman Islands">Kayman Adaları</option>
                            <option value="Central African Republic">Orta Afrika Cumhuriyeti</option>
                            <option value="Chad">Çad</option>
                            <option value="Channel Islands">Kanal Adaları</option>
                            <option value="Chile">Şili</option>
                            <option value="China">Çin</option>
                            <option value="Christmas Island">Christmas Adası</option>
                            <option value="Cocos Island">Cocos Adası</option>
                            <option value="Colombia">Kolombiya</option>
                            <option value="Comoros">Komorlar</option>
                            <option value="Congo">Kongo</option>
                            <option value="Cook Islands">Cook Adaları</option>
                            <option value="Costa Rica">Kosta Rika</option>
                            <option value="Cote DIvoire">Fildişi Sahili</option>
                            <option value="Croatia">Hırvatistan</option>
                            <option value="Cuba">Küba</option>
                            <option value="Curaco">Curaçao</option>
                            <option value="Cyprus">Kıbrıs</option>
                            <option value="Czech Republic">Çek Cumhuriyeti</option>
                            <option value="Denmark">Danimarka</option>
                            <option value="Djibouti">Cibuti</option>
                            <option value="Dominica">Dominika</option>
                            <option value="Dominican Republic">Dominik Cumhuriyeti</option>
                            <option value="East Timor">Doğu Timor</option>
                            <option value="Ecuador">Ekvador</option>
                            <option value="Egypt">Mısır</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Ekvator Ginesi</option>
                            <option value="Eritrea">Eritre</option>
                            <option value="Estonia">Estonya</option>
                            <option value="Ethiopia">Etiyopya</option>
                            <option value="Falkland Islands">Falkland Adaları</option>
                            <option value="Faroe Islands">Faroe Adaları</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finlandiya</option>
                            <option value="France">Fransa</option>
                            <option value="French Guiana">Fransız Guyanası</option>
                            <option value="French Polynesia">Fransız Polinezyası</option>
                            <option value="French Southern Ter">Fransız Güney Toprakları</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambiya</option>
                            <option value="Georgia">Gürcistan</option>
                            <option value="Germany">Almanya</option>
                            <option value="Ghana">Gana</option>
                            <option value="Gibraltar">Cebelitarık</option>
                            <option value="Great Britain">Büyük Britanya</option>
                            <option value="Greece">Yunanistan</option>
                            <option value="Greenland">Grönland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guinea">Gine</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Hawaii">Hawaii</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Macaristan</option>
                            <option value="Iceland">İzlanda</option>
                            <option value="India">Hindistan</option>
                            <option value="Indonesia">Endonezya</option>
                            <option value="Iran">İran</option>
                            <option value="Iraq">Irak</option>
                            <option value="Ireland">İrlanda</option>
                            <option value="Isle of Man">Man Adası</option>
                            <option value="Israel">İsrail</option>
                            <option value="Italy">İtalya</option>
                            <option value="Jamaica">Jamaika</option>
                            <option value="Japan">Japonya</option>
                            <option value="Jordan">Ürdün</option>
                            <option value="Kazakhstan">Kazakistan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea North">Kuzey Kore</option>
                            <option value="Korea Sout">Güney Kore</option>
                            <option value="Kuwait">Kuveyt</option>
                            <option value="Kyrgyzstan">Kırgızistan</option>
                            <option value="Laos">Laos</option>
                            <option value="Latvia">Letonya</option>
                            <option value="Lebanon">Lübnan</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberya</option>
                            <option value="Libya">Libya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Litvanya</option>
                            <option value="Luxembourg">Lüksemburg</option>
                            <option value="Macau">Makao</option>
                            <option value="Macedonia">Makedonya</option>
                            <option value="Madagascar">Madagaskar</option>
                            <option value="Malaysia">Malezya</option>
                            <option value="Malawi">Malavi</option>
                            <option value="Maldives">Maldivler</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Adaları</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Moritanya</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Meksika</option>
                            <option value="Midway Islands">Midway Adaları</option>
                            <option value="Moldova">Moldova</option>
                            <option value="Monaco">Monako</option>
                            <option value="Mongolia">Moğolistan</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Fas</option>
                            <option value="Mozambique">Mozambik</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Nambia">Namibya</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherland Antilles">Hollanda Antilleri</option>
                            <option value="Netherlands">Hollanda (Avrupa)</option>
                            <option value="Nevis">Nevis</option>
                            <option value="New Caledonia">Yeni Kaledonya</option>
                            <option value="New Zealand">Yeni Zelanda</option>
                            <option value="Nicaragua">Nikaragua</option>
                            <option value="Niger">Nijer</option>
                            <option value="Nigeria">Nijerya</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Adası</option>
                            <option value="Norway">Norveç</option>
                            <option value="Oman">Umman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau Island">Palau Adası</option>
                            <option value="Palestine">Filistin</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua Yeni Gine</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Phillipines">Filipinler</option>
                            <option value="Pitcairn Island">Pitcairn Adası</option>
                            <option value="Poland">Polonya</option>
                            <option value="Portugal">Portekiz</option>
                            <option value="Puerto Rico">Porto Riko</option>
                            <option value="Qatar">Katar</option>
                            <option value="Republic of Montenegro">Karadağ Cumhuriyeti</option>
                            <option value="Republic of Serbia">Sırbistan Cumhuriyeti</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romanya</option>
                            <option value="Russia">Rusya</option>
                            <option value="Rwanda">Ruanda</option>
                            <option value="St Barthelemy">Saint Barthélemy</option>
                            <option value="St Eustatius">Saint Eustatius</option>
                            <option value="St Helena">Saint Helena</option>
                            <option value="St Kitts-Nevis">Saint Kitts ve Nevis</option>
                            <option value="St Lucia">Saint Lucia</option>
                            <option value="St Maarten">Saint Maarten</option>
                            <option value="St Pierre & Miquelon">Saint Pierre ve Miquelon</option>
                            <option value="St Vincent & Grenadines">Saint Vincent ve Grenadinler</option>
                            <option value="Saipan">Saipan</option>
                            <option value="Samoa">Samoa</option>
                            <option value="Samoa American">Amerikan Samoası</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome & Principe">São Tomé ve Príncipe</option>
                            <option value="Saudi Arabia">Suudi Arabistan</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Serbia">Sırbistan</option>
                            <option value="Seychelles">Seyşeller</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapur</option>
                            <option value="Slovakia">Slovakya</option>
                            <option value="Slovenia">Slovenya</option>
                            <option value="Solomon Islands">Solomon Adaları</option>
                            <option value="Somalia">Somali</option>
                            <option value="South Africa">Güney Afrika</option>
                            <option value="Spain">İspanya</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Surinam</option>
                            <option value="Swaziland">Svaziland</option>
                            <option value="Sweden">İsveç</option>
                            <option value="Switzerland">İsviçre</option>
                            <option value="Syria">Suriye</option>
                            <option value="Tahiti">Tahiti</option>
                            <option value="Taiwan">Tayvan</option>
                            <option value="Tajikistan">Tacikistan</option>
                            <option value="Tanzania">Tanzanya</option>
                            <option value="Thailand">Tayland</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad & Tobago">Trinidad ve Tobago</option>
                            <option value="Tunisia">Tunus</option>
                            <option value="Turkey">Türkiye</option>
                            <option value="Turkmenistan">Türkmenistan</option>
                            <option value="Turks & Caicos Is">Turks ve Caicos Adaları</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="Ukraine">Ukrayna</option>
                            <option value="United Arab Erimates">Birleşik Arap Emirlikleri</option>
                            <option value="United Kingdom">Birleşik Krallık</option>
                            <option value="United States of America">Amerika Birleşik Devletleri</option>
                            <option value="Uraguay">Uruguay</option>
                            <option value="Uzbekistan">Özbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Vatican City State">Vatikan Şehir Devleti</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Vietnam">Vietnam</option>
                            <option value="Virgin Islands (Brit)">Britanya Virgin Adaları</option>
                            <option value="Virgin Islands (USA)">ABD Virgin Adaları</option>
                            <option value="Wake Island">Wake Adası</option>
                            <option value="Wallis & Futana Is">Wallis ve Futuna Adaları</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zaire">Zaire</option>
                            <option value="Zambia">Zambiya</option>
                            <option value="Zimbabwe">Zimbabve</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <x-heroicon name="chevron-down" class="h-5 w-5 text-gray-400" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Username -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                <div class="md:col-span-1">
                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('user.profile.form.username') }}
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('user.profile.form.username_description') }}</p>
                </div>
                <div class="md:col-span-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon name="at-sign" class="h-5 w-5 text-gray-400" />
                        </div>
                        <input type="text"
                               id="username"
                               name="username"
                               value="{{ Auth::user()->username }}"
                               readonly
                               class="pl-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:text-gray-300 sm:text-sm py-4 cursor-not-allowed"
                        >
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center">
                            <x-heroicon name="lock-closed" class="h-3.5 w-3.5 mr-1 text-gray-400" />
                            {{ __('user.profile.form.username_readonly') }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-5 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end">
                    <button
                        type="submit"
                        id="save-profile-btn"
                        class="inline-flex items-center px-6 py-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                    >
                        <span class="btn-text">
                            <x-heroicon name="save" class="mr-2 h-5 w-5" />
                            {{ __('user.profile.form.save_changes') }}
                        </span>
                        <span class="btn-loading" style="display: none;">
                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('user.profile.form.processing') }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
function showLoadingState() {
    const btn = document.getElementById('save-profile-btn');
    const btnText = btn.querySelector('.btn-text');
    const btnLoading = btn.querySelector('.btn-loading');
    
    btnText.style.display = 'none';
    btnLoading.style.display = 'flex';
    btn.disabled = true;
}

function hideLoadingState() {
    const btn = document.getElementById('save-profile-btn');
    const btnText = btn.querySelector('.btn-text');
    const btnLoading = btn.querySelector('.btn-loading');
    
    btnText.style.display = 'flex';
    btnLoading.style.display = 'none';
    btn.disabled = false;
}

document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('updateprofileform').addEventListener('submit', function(e) {
        e.preventDefault();
        showLoadingState();

        $.ajax({
            url: "{{ route('profile.update') }}",
            type: 'POST',
            data: $('#updateprofileform').serialize(),
            success: function(response) {
                if (response.status === 200) {
                    // Show success notification with modern styling
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-400 p-4 rounded-lg shadow-lg transform transition-all duration-300 ease-out z-50 flex items-start max-w-sm';
                    toast.innerHTML = `
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">${response.success}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 dark:hover:bg-green-800 focus:outline-none dismiss-toast">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;

                    document.body.appendChild(toast);

                    // Add entrance animation
                    setTimeout(() => {
                        toast.classList.add('translate-y-2');
                    }, 10);

                    // Add click listener to dismiss button
                    toast.querySelector('.dismiss-toast').addEventListener('click', function() {
                        toast.classList.remove('translate-y-2');
                        toast.classList.add('-translate-y-2', 'opacity-0');
                        setTimeout(() => {
                            toast.remove();
                        }, 300);
                    });

                    // Remove the notification after 5 seconds
                    setTimeout(() => {
                        if (document.body.contains(toast)) {
                            toast.classList.remove('translate-y-2');
                            toast.classList.add('-translate-y-2', 'opacity-0');
                            setTimeout(() => {
                                toast.remove();
                            }, 300);
                        }
                    }, 5000);
                }

                // Reset the saving state after 1 second
                setTimeout(() => {
                    hideLoadingState();
                }, 1000);
            },
            error: function(data) {
                console.log(data);
                hideLoadingState();

                // Show error notification
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 p-4 rounded-lg shadow-lg transform transition-all duration-300 ease-out z-50 flex items-start max-w-sm';
                toast.innerHTML = `
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ __('user.profile.form.update_error') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-100 dark:hover:bg-red-800 focus:outline-none dismiss-toast">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                `;

                document.body.appendChild(toast);

                // Add entrance animation
                setTimeout(() => {
                    toast.classList.add('translate-y-2');
                }, 10);

                // Add click listener to dismiss button
                toast.querySelector('.dismiss-toast').addEventListener('click', function() {
                    toast.classList.remove('translate-y-2');
                    toast.classList.add('-translate-y-2', 'opacity-0');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                });

                // Remove the notification after 5 seconds
                setTimeout(() => {
                    if (document.body.contains(toast)) {
                        toast.classList.remove('translate-y-2');
                        toast.classList.add('-translate-y-2', 'opacity-0');
                        setTimeout(() => {
                            toast.remove();
                        }, 300);
                    }
                }, 5000);
            }
        });
    });
});
</script>