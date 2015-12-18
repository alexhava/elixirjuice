<?php
if(@$allergies)
{
	foreach ($allergies as $allergy)
	{
		$table_arr[] = form_checkbox('allergies[]', $allergy, true, 'class="alergy_checkbox"') . nbs() . $allergy;
		$allergy_arr[] = $allergy;
	}

	$allergies_table = $this->table->generate($this->table->make_columns($table_arr, 6));
	$allergies_str = implode(', ', $allergy_arr);
}
?>
deliveryAmount = shippingAmount = 0;

function checkLogin(that){
	if($('[name="login"]').val())
	{
		that.loading();
		$.post('//'+window.location.host+'/users/login/ajaxlogin', $('.submit_order').serialize(), function(data){
			$('body').append('<div class="load-data">'+data+'</div>');
			that.loadingEnd();
		})
	} else {
		showStep(that.closest('.step-container').next('.step-container').find('.step-title'));
	}
}

function registerUser(that){
	that.loading();
	$.post('//'+window.location.host+'/users/login/registrationajax', $('.submit_order').serialize(), function(data){
		$('.reg-data').remove();
		that.after("<div class='reg-data'>"+data+"</div>");
		that.loadingEnd();
	})
}

function checkPaymentDetails(that){
	that.loading();
	$.post('https://'+window.location.host+'/cart/test_payment', $('.submit_order').serialize(), function(data){
		$('.payment-load').html(data);
		that.loadingEnd();
	})
}

function completeOrder(that){
	that.loading();
	$.post('https://'+window.location.host+'/cart/do_payment', $('.submit_order').serialize(), function(data){
		$('.reg-data').remove();
		that.before("<div class='reg-data'>"+data+"</div>");
		that.loadingEnd();
	})
}

function checkProgress(id){
	$('.'+id+'_progress').find('table').show().addClass('progress-mark');
}

function updateConfirmSection(){
	var r = {'first_name':'billing_first_name_confirm', 'last_name':'billing_last_name_confirm', 'x_email':'billing_email_confirm', 'x_address':'billing_address_confirm', 'x_city':'billing_city_confirm', 'x_zip':'billing_zip_confirm', 'x_phone':'billing_phone_confirm', 'region':'billing_region_confirm'};

	for(var prop in r){
		//		alert("#"+r[prop] + " - "+"[name='"+prop+"']")

		if($("[name='"+prop+"']").prop("tagName") == 'SELECT')
		$("#"+r[prop]).html($("[name='"+prop+"'] option:selected").text())

		else
		$("#"+r[prop]).html($("[name='"+prop+"']").val())
	}


	var r1 = {'delivery_first_name':'delivery_first_name_confirm', 'delivery_last_name':'delivery_last_name_confirm', 'delivery_email':'delivery_email_confirm', 'delivery_address':'delivery_address_confirm', 'delivery_city':'delivery_city_confirm', 'delivery_zip':'delivery_zip_confirm', 'delivery_phone':'delivery_phone_confirm', 'delivery_region':'delivery_region_confirm'};

	
	var rot = $('[name="shipping_same_as_billing"]:checked').val() == 'y' ? r : r1;
	for(var prop in rot){
		var prop1 = $('[name="shipping_same_as_billing"]:checked').val() == 'y' ? rot[prop].replace('billing', 'delivery') : rot[prop];
		$("#"+prop1).html($("[name='"+prop+"']").val())
	}

	$("#allergies_confirm").html($("[name='allergies_content']").val())
	$("#notes_confirm").html($("#notes").val())
	$("#delivery_delivery_method_confirm").html($("[name='delivery_type']:checked").val())
	$("#delivery_store_confirm").html($("[name='store'] option:selected").text())
	$("#delivery_pickup_date_confirm").html($("[name='date']").val())
	$("#delivery_pickup_time_confirm").html($("#ready_time").val())
}

function getCalendar(){
	$('#cleanses_calendar_wrapper').hide().loading();
	var dt = $("[name='delivery_type']:checked").val();
	$.get('//'+window.location.host+'/calendar?store_id='+$('#store').val()+'&delivery_type='+dt+'&zip='+getZip(), function(data){
		$('#cleanses_calendar_wrapper').html(data).fadeIn();
		$('#cleanses_calendar_wrapper').loadingEnd();
		loadTime();
	})
}

function showStep(that){
	updateConfirmSection();
	var obj = that ? that.closest('.step-container') : $('.steps').not('.steps-hide').closest('.step-container').next('.step-container');
	if(obj.hasClass('skip'))
	{
		checkProgress(obj.find('.next-step').attr('id'));
		showStep(obj.next('.step-container').find('.step-title'));
		return;
	}
	var so = obj.find('.steps');
	$('.steps-first').removeClass('steps-first');
	if(so.hasClass('steps-hide')) {

		if(so.attr('id') == 'order_confirm_step') updateConfirmSection();

		$('.steps').each(function(){
			$(this).slideUp(1000);
			$(this).addClass('steps-hide');
			$(this).closest('.step-container').find('img').attr('src', '/images/arrow-expand.png');
		})
		$("html, body").animate({ scrollTop: obj.scrollTop() }, "slow");

		so.slideDown(1000, function(){
			if(so.attr('id') == 'delivery_method_step') 	getCalendar();
		});
		so.removeClass('steps-hide');

		obj.find('img').attr('src', '/images/arrow-collapse.png');

	} else {
		so.slideUp(1000);
		so.addClass('steps-hide');
		obj.find('img').attr('src', '/images/arrow-expand.png');
	}
}

function showDeliveryTable(obj){
	if(obj.val() == 'n')
	$('.delivery-address').removeClass('skip');
	else
	{
		$('.delivery-address').addClass('skip');
		$('select[name="store_region"]').val($('[name="region"]').val());
		loadStores();
		calcShipping();
		checkCoupon();
	}
}

$(document).ready(function() {

	updateConfirmSection();
	calcDeliveryOptions();

	$('.step-title').click(function(){
		showStep($(this));
	});

	$('[name="region"]').change(function(){
		if($('[name="shipping_same_as_billing"]:checked').val() == 'n') return;
		$('select[name="store_region"]').val($(this).val());
		loadStores();
		calcShipping();
		checkCoupon();
	});

	$('[name="store"]').live("change", function(){
		getCalendar();
	});

	showDeliveryTable($('[name="shipping_same_as_billing"]:checked'));

	$('[name="shipping_same_as_billing"]').click(function(){
		showDeliveryTable($(this))
	});

	$('[name="login_type"]').click(function(){
		$('.online-registration-password').hide();
		$('.online-registration-password').find('input').attr('disabled', 'disabled');
		if( $('[name="login_type"]:checked').val() == 'register') {
			$('.online-registration-password').show();
			$('.online-registration-password').find('input').removeAttr('disabled');
		}
	});

	$('.next-step').click(function(){
		if($(this).hasClass('validate'))
		{
			if( ! validateData($(this).attr('id'))) return;
		}

		checkProgress($(this).attr('id'));

		if($(this).attr('id') == 'checkout_options_step')
		{
			checkLogin($(this));
			return;
		}

		if($(this).attr('id') == 'payment_details')
		{
			checkPaymentDetails($(this));
			return;
		}

		if($(this).attr('id') == 'complete_order')
		{
			completeOrder($(this));
			return;
		}

		if($(this).attr('id') == 'billing_address' && $('[name="login_type"]:checked').val() == 'register')
		{
			registerUser($(this));
			return;
		}

		showStep($(this).closest('.step-container').next('.step-container').find('.step-title'));
	});
	$('select[name="store_region"]').change(function(){
		loadStores();
		calcShipping();
		checkCoupon();
	});

	$('#apply_coupon').click(function(){
		checkCoupon();
		return false;
	});

	$('#x_zip, #delivery_zip').change(function(){
		calcDeliveryOptions();
		calcDelivery();
		checkCoupon();
	});

	$('input[value="shipping"],input[value="pickup"],input[value="deliver"], select[name="store_region"]').live('change', function(){
		checkDelType();
		calcDelivery();
		checkCoupon();
		getCalendar();
		console.log('click');
//		if($(this).val() == 'shipping')
	});


	loadStores();

	// alergies
	checkAllergies('<?= @$allergies_str and @$alergy != 'no'?>'?'yes':'no');
	$('input[type="radio"][name="alergy"]').live('click', function(){
		checkAllergies($('input[type="radio"][name="alergy"]:checked').val());
	});

	$('.alergy_checkbox').live('click', function(){
		var arr = new Array();
		$('.alergy_checkbox:checked').each(function(){
			arr.push($(this).val());
		});
		$('#allergies_content textarea').val(arr.join(','))
	});
});



function loadStores(){
	var url = '//'+window.location.host+'/cart/getstores?state='+$('select[name="store_region"] option:selected').val();
	$('#stores').html('Loading...')
	$.get(url,function(data){
		$('#stores').html(data)
		calcDeliveryOptions();
	})
}


function loadTime(){
	var dt = $("[name='delivery_type']:checked").val();
	if( ! $('select[name="store"] option:selected').val()) return;
	var url = '//'+window.location.host+'/cart/get_order_time?store_id='+$('select[name="store"] option:selected').val() + '&date='+$('[name="date"]').val()+'&delivery_type='+dt+'&zip='+getZip();
	$('#time_section').html('Loading...')
	$.get(url,function(data){
		$('#time_section').html(data)
	})
}

function checkDelType(){
	if($('input[value="pickup"]:checked').length == 0)
	{
		$('select[name="store"]').attr('disabled', 'disabled');
	}
	else
	{
		$('select[name="store"]').removeAttr('disabled');
	}
}

function calcDeliveryOptions(){
	
	var zip = $('[name="shipping_same_as_billing"]:checked').val() == 'y' ? $('#x_zip').val() : $('#delivery_zip').val();
	var state = $('[name="shipping_same_as_billing"]:checked').val() == 'y' ? $('select[name="region"] option:selected').val() : $('select[name="store_region"] option:selected').val();
	var url = '//'+window.location.host+'/cart/calc_deliver_options?state='+state+'&zip='+zip;
	var td = $(this).find('td:eq(1)');
	$('.delivery-options').loading();
	$.get(url,function(data){
		$('.delivery-options').html(data);
		checkDelType();
		calcDelivery();
		calcShipping();
		loadTime();
		$('.delivery-options').loadingEnd();
	})
}

function calcShipping()
{
	var state = $('select[name="store_region"] option:selected').val();
	var delivery = $("[name='delivery_type']:checked").val();
	var url = '//'+window.location.host+'/cart/getshipping?state='+state+'&delivery_type='+delivery;
	
	$.get(url,function(data){
		$('.simpleCart_shipping').html(data);
		updateGrandTotal();
	})
}

function getZip()
{
	return $('[name="shipping_same_as_billing"]:checked').val() == 'y' ? $('#x_zip').val() : $('#delivery_zip').val();	
}

function calcDelivery()
{
	var zip = $('[name="shipping_same_as_billing"]:checked').val() == 'y' ? $('#x_zip').val() : $('#delivery_zip').val();
	var delivery = $("[name='delivery_type']:checked").val();
	var url = '//'+window.location.host+'/cart/getdelivery?zip='+zip+'&delivery_type='+delivery;
	$.get(url,function(data){
		$('.simpleCart_tax').html(data);
		updateGrandTotal();
	})
}

function checkCoupon()
{
	var coupon = $('[name="coupon_code"]').val();
	var url = '//'+window.location.host+'/cart/apply_coupon?coupon_code='+coupon;
	$('#apply_coupon').loading();
	$.get(url,function(data){
		$('#coupon_res').html(data);
		calcShipping();
		updateGrandTotal();
		$('#apply_coupon').loadingEnd();
	})
}

function applyCoupon(amount){
}

function unapplyCoupon(){
}

function checkAllergies(val){
	if(val=='yes')
	{
		$('#allergies_content').show();
		$('#allergies_content textarea').removeAttr('disabled');
		$('.alergy_checkbox').removeAttr('disabled');
		$('input[type="radio"][name="alergy"][value="yes"]').attr('checked', 'checked');
	}
	else
	{
		$('#allergies_content').hide();
		$('#allergies_content textarea').attr('disabled', 'disabled');
		$('.alergy_checkbox').attr('disabled', 'disabled');
	}
}

function updateGrandTotal() {
	var url = '//'+window.location.host+'/cart/get_grand_total';
	$('.simpleCart_grandTotal').loading();
	$.post(url, $('.submit_order').serialize(), function(data){
		$('.simpleCart_grandTotal').html(data);
		$('.simpleCart_grandTotal').loadingEnd();
	})
}


//itms scroll
var cartTableHeight = $('#cart_table').css('height');
var cartTableoffset = $('#cart_table').offset();
var cartTableTop = 0;
$(window).scroll(function() {
	//	$('#remove').html($('#remove').html()+', cartTableTop='+cartTableTop)
	//	$('#cart_table').animate({
	//	    top: cartTableTop+$(window).scrollTop(),
	//	  }, 40);
	//	if(cartTableTop <= $(window).scrollTop())
	//	$('#cart_table').css("top", ($(window).scrollTop()-cartTableTop) + "px");
});

$( "#start_date" ).datepicker();
