var Converter = (function(){

    var private_currencyIn;
    var private_currencyOut;
    var private_amount;

    var private_history = [];

    /**
    *
    * Method used to switch currency you want to convert with desired currency
    *
    * @param String inSelector Valid jQuery selector for curent currency
    * @param String outSelector Valid jQuery selector for desired currency
    *
    * @return Void
    *
    */
    function private_SwitchCurrency(inSelector, outSelector)
    {
        // We create temporary variables for both currencies
        var tempCurrencyIn = private_currencyIn;
        var tempCurrencyOut = private_currencyOut;

        // Here we actually switch currencies
        private_currencyIn = tempCurrencyOut;
        private_currencyOut = tempCurrencyIn;

        // This is to visually update currencies
        $(inSelector).val(tempCurrencyOut);
        $(outSelector).val(tempCurrencyIn);
    }

    /**
    *
    * Method used to set current and desired currency
    *
    * @param String inSelector Valid jQuery selector for curent currency
    * @param String outSelector Valid jQuery selector for desired currency
    *
    * @return Void
    *
    */
    function private_setCurrencies(inSelector, outSelector)
    {
        private_currencyIn = $(inSelector).val();
        private_currencyOut = $(outSelector).val();
    }

    /**
    *
    * Method used to update amount of currency you want to convert
    *
    * @param String selector Valid jQuery selector for <input> element of amount
    *
    * @return Void
    *
    */
    function private_setAmount(selector)
    {
        private_amount = parseFloat($(selector).val());
    }

    function private_getAmount()
    {
        return private_amount;
    }

    function private_updateHistory(result)
    {
        var newRow = "<span class='history-row'>" + private_currencyIn + " " + private_amount + " = " + result + " " + private_currencyOut + "</span>";

        if(private_history.length >= 5) {
            private_history.shift();
        }
        private_history.push(newRow);

        // We first remove old history
        $("#history").empty();
        // Here we render rows into view
        $.each(private_history, function(key, value) {
            $("#history").append(value);
        });
    }

    function private_showError(error)
    {
        var alert = "<div class='alert alert-danger alert-dismissible fade in' role='alert'>";
            alert += "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
            alert += "<span aria-hidden='true'>&times;</span></button><span id='error'>" + error + "</span></div>";
        $("#controls").append(alert);
    }

    function private_convert(){
        var amount = private_amount;
        var currencyIn = private_currencyIn;
        var currencyOut = private_currencyOut;

        if(!isNaN(amount)) {
            if($.inArray(currencyIn, allowed_currencies) > -1) {
                if($.inArray(currencyOut, allowed_currencies) > -1) {
                    $.ajax({
                        url: "/convert/index",
                        method: "post",
                        dataType: "json",
                        data: {"amount": amount, "in": currencyIn, "out": currencyOut},
                        success: function(resp){
                            if(resp.hasOwnProperty("error")) {
                                private_showError(resp.error);
                            }
                            else {
                                if(resp.hasOwnProperty("result")) {
                                    private_updateHistory(resp.result);
                                }
                            }
                        }
                    });
                }
                else {
                    private_showError(currencyOut + " is not allowed currency.");
                }
            }
            else {
                private_showError(currencyIn + " is not allowed currency.");
            }
        }
        else{
            private_showError("Amount must be number.");
        }
    }

    return {
        public_SwitchCurrencies: function(inSelector, outSelector)
        {
            private_SwitchCurrency(inSelector, outSelector);
        },
        public_setCurrencies: function(inSelector, outSelector)
        {
            private_setCurrencies(inSelector, outSelector);
        },
        public_setAmount: function(amount)
        {
            private_setAmount(amount);
        },
        public_getAmount: function()
        {
            var amount = private_getAmount();
            return amount;
        },
        public_convert: function()
        {
            private_convert();
        }
    };

})();

$(function(){

    Converter.public_setCurrencies("#currency_in", "#currency_out");
    Converter.public_setAmount("#convert_value");

    $("#currency_in, #currency_out").change(function(){
        Converter.public_setCurrencies("#currency_in", "#currency_out");
    });

    $("#switch_currency").click(function(){
        Converter.public_SwitchCurrencies("#currency_in", "#currency_out");
    });

    $("#convert_value")
        .change(function(){
            Converter.public_setAmount(this);
        })
        .keyup(function(){
            Converter.public_setAmount(this);
        });

    $("#convert_form").submit(function(event){
        event.preventDefault();
        Converter.public_setCurrencies("#currency_in", "#currency_out");
        Converter.public_convert();
    });
});

