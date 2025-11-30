//Get P/L
function GetPL() {
    $.ajax("{{url('/dashboard/getpl').'/'.Auth::user()->id}}", {
        type: "GET",
        success: function(response) {
            var pl = document.getElementById("p_l");

            if (response < 0) {
                $("#p_l").css("color", "red");
            }
            if (response > 0) {
                $("#p_l").css("color", "green");
            }

            pl.innerHTML = "{{$settings->currency}}" + response;
        },
    });
}

var badWords = [
    "<!--Start of Tawk.to Script-->",
    '<script type="text/javascript">',
    "<!--End of Tawk.to Script-->",
];
$(":input").on("blur", function() {
    var value = $(this).val();
    $.each(badWords, function(idx, word) {
        value = value.replace(word, "");
    });
    $(this).val(value);
});

$(document).ready(function() {
    $("#ShipTable").DataTable({
        order: [
            [0, "desc"]
        ],
        dom: "Bfrtip",
        buttons: ["copy", "csv", "print", "excel", "pdf"],
    });
});

$("#usernameinput").on("keypress", function(e) {
    return e.which !== 32;
});

$(document).ready(function() {
    $(".UserTable").DataTable({
        order: [
            [0, "desc"]
        ],
    });
});

// DOM elementlerini null kontrolü ile al
let trademode = document.getElementById("trademode");
let msgbox = document.getElementById("msgbox");
let optionTitle = document.getElementById("optionTitle");
let optionInput = document.getElementById("optionInput");
let optionSelected = document.getElementById("optionSelected");

// Null kontrolleri ve event listener - daha kapsamlı kontrol
if (trademode && msgbox && optionTitle && optionInput && optionSelected) {
    const logMessage = typeof window.__ === 'function' ? window.__('success.dom_elements_found') : 'Tüm gerekli DOM elementleri bulundu';
    console.log('🔧 ' + logMessage);
    trademode.addEventListener("change", tradeSizeMsgs);
    optionSelected.style.display = "none";
} else {
    const warnMessage = typeof window.__ === 'function' ? window.__('errors.dom_elements_missing') : 'Bazı DOM elementleri bulunamadı:';
    console.warn('⚠️ ' + warnMessage, {
        trademode: !!trademode,
        msgbox: !!msgbox,
        optionTitle: !!optionTitle,
        optionInput: !!optionInput,
        optionSelected: !!optionSelected
    });
}

function tradeSizeMsgs() {
    // Tüm gerekli elementlerin var olduğunu kontrol et
    if (!trademode || !msgbox || !optionTitle || !optionInput || !optionSelected) {
        const warnMsg = typeof window.__ === 'function' ? window.__('errors.trade_size_dom_missing') : 'tradeSizeMsgs: Bazı gerekli DOM elementleri bulunamadı';
        console.warn('⚠️ ' + warnMsg);
        return;
    }

    if (trademode.value == "none") {
        optionSelected.style.display = "none";

        msgbox.value = typeof window.__ === 'function' ?
            window.__('trading.trademode_none_desc') :
            "If value is none, then trade size will be preserved irregardless of the subscriber balance.";
    } else if (trademode.value == "balance") {
        optionSelected.style.display = "none";
        msgbox.value = typeof window.__ === 'function' ?
            window.__('trading.trademode_balance_desc') :
            "If set to balance, the trade size on strategy subscriber will be scaled according to balance to preserve risk.";
    } else if (trademode.value == "equity") {
        optionSelected.style.display = "none";
        msgbox.value = typeof window.__ === 'function' ?
            window.__('trading.trademode_equity_desc') :
            "If set to equity, the trade size on strategy subscriber will be scaled according to subscriber equity.";
    } else if (trademode.value == "contractSize") {
        optionSelected.style.display = "none";
        msgbox.value = typeof window.__ === 'function' ?
            window.__('trading.trademode_contractsize_desc') :
            "If value is contractSize, then trade size will be scaled according to contract size.";
    } else if (trademode.value == "fixedVolume") {
        optionSelected.style.display = "block";
        // optionInput.name = "fixedVolume";
        optionTitle.innerText = typeof window.__ === 'function' ?
            window.__('trading.enter_fixed_volume') :
            "Enter Fixed trade volume";
        msgbox.value = typeof window.__ === 'function' ?
            window.__('trading.trademode_fixedvolume_desc') :
            "If fixedVolume is set, then trade will be copied with a fixed volume of tradeVolume setting.";
    } else if (trademode.value == "fixedRisk") {
        optionSelected.style.display = "block";
        // optionInput.name = "fixedRisk";
        optionTitle.innerText = typeof window.__ === 'function' ?
            window.__('trading.enter_fixed_risk') :
            "Enter Fixed risk fraction";
        msgbox.value = typeof window.__ === 'function' ?
            window.__('trading.trademode_fixedrisk_desc') :
            "Note, that in fixedRisk mode trades without a SL are not copied.";
    } else if (trademode.value == "expression") {
        optionSelected.style.display = "block";
        //optionInput.name = "expression";
        optionTitle.innerText = typeof window.__ === 'function' ?
            window.__('trading.enter_math_expression') :
            "Enter math.js expression";
        msgbox.value = typeof window.__ === 'function' ?
            window.__('trading.trademode_expression_desc') :
            "If expression is set, then trade volume will be calculated using a user-defined expression. Note, that expression trade size scaling mode is intended for advanced users and we DO NOT RECOMMEND using it unless you understand what are you doing, as mistakes in expression can result in loss. Math.js expression will be used to calculate trade volume (see https://mathjs.org/docs/expressions/syntax.html). Following variables are available in expression scope: providerVolume - provider signal trade size; providerTradeAmount - provider signal trade value in trade copier base curency; multiplier - subscription multiplier value; providerBalance - provider balance value in trade copier base currency; balance - subscriber balance value in trade copier base currency; quoteOrOpenPrice - current asset price (for market orders) or open price (for pending orders) on subscriber side; tickValue - current asset tick value on subscriber side expressed in trade copier base currency; tickSize - tick size on subscriber side; providerScaledVolume - provider trade volume multiplied by provider contract size; contractSize - subscriber contract size; providerStopLoss - provider signal stop loss price; providerTakeProfit - provider signal take profit price; accountCurrencyExchangeRate - subscriber exchange rate of account currency to trade copier base currency";
    }
}
tradeSizeMsgs();