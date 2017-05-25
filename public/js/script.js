var Converter = (function(){

	var private_currencyIn;
	var private_currencyOut;
	var private_amount = 1;

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
		var amount = $(selector).val();
		// We only allow numbers for our amount
		if(!isNaN(amount)) {
			private_amount = amount;
		}
	}

	function private_getAmount()
	{
		return private_amount;
	}

	function private_convert(){
		var amount = private_amount;
		var currencyIn = private_currencyIn;
		var currencyOut = private_currencyOut;

		if(!isNaN(amount)) {
			$.ajax({
				url: "convert/index",
				method: "post",
				dataType: "json",
				data: {"amount": amount, "in": currencyIn, "out": currencyOut},
				success: function(resp){
					console.log(resp);
				}
			})
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
	}

})()

$("#currency_in, #currency_out").change(function(){
	Converter.public_setCurrencies("#currency_in", "#currency_out");
})

$("#switch_currency").click(function(){
	Converter.public_SwitchCurrencies("#currency_in", "#currency_out");
})

$("#convert_value")
	.change(function(){
		Converter.public_setAmount(this);
	})
	.keyup(function(){
		Converter.public_setAmount(this);
	})

$("#convert").click(function(){
	Converter.public_setCurrencies("#currency_in", "#currency_out");
	Converter.public_convert();
})