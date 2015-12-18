function validateData(what) {
	var emptyMes = " cannot be empty";
	var emailErr = " Invalid email format";
	var noerror = true;
	$('.submit-error').remove();

	if(what == 'delivery_method'){
		if( ! $('[name="delivery_type"]:checked').val()) {
			alert("There is no way to delivery this product in your state. Change your delivery address");
			noerror = false;
		}
	}
	
	if(what == 'checkout_options_step'){
		if( ! $('[name="login_type"]:checked').val() && ! $('[name="login"]').val() && ! $('[name="login"]').val()) {
			alert('Please choose checkout method registration');
			noerror = false;
		}
	}
	
	if(what == 'billing_address'){
		var r = new Array('first_name', 'last_name', 'x_email', 'x_address', 'x_city', 'x_zip', 'x_phone');
		for (i=0; i<r.length; i++){
			if( ! $('[name="'+r[i]+'"]').val()){
				var l = $('input[name="'+r[i]+'"]').closest('td').find('label').html().replace('*', '');
				$('input[name="'+r[i]+'"]').closest('td').find('label').after('<p class="submit-error">'+l+emptyMes+'</p>');
				noerror = false;
			}
		}
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if( $('[name="x_email"]').val() && ! re.test($('[name="x_email"]').val()))
		{
				$('input[name="x_email"]').closest('td').find('label').after('<p class="submit-error">'+emailErr+'</p>');
				noerror = false;			
		}
	}
	
	if(what == 'delivery_address'){
		var r = new Array('delivery_first_name', 'delivery_last_name', 'delivery_email', 'delivery_address', 'delivery_city', 'delivery_zip', 'delivery_phone');
		for (i=0; i<r.length; i++){
			if( ! $('[name="'+r[i]+'"]').val()){
				var l = $('input[name="'+r[i]+'"]').closest('td').find('label').html().replace('*', '');
				$('input[name="'+r[i]+'"]').closest('td').find('label').after('<p class="submit-error">'+l+emptyMes+'</p>');
				noerror = false;
			}
		}
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if( $('[name="delivery_email"]').val() && ! re.test($('[name="delivery_email"]').val()))
		{
				$('input[name="delivery_email"]').closest('td').find('label').after('<p class="submit-error">'+emailErr+'</p>');
				noerror = false;			
		}
	}

	return noerror;
}