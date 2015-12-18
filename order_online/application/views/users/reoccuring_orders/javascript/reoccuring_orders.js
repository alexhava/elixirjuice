deliveryAmount = shippingAmount = 0;
selectedTime = '<?=@$ready_time?>';
selectedStore = '<?=@$store?>';

$('select[name="store_region"]').change(function(){
	loadStores();
	calcShipping();
});

$('select[name="period"]').change(function(){
	checkWeekDay($(this));
});

$('select[name="store"]').live('change', function(){
	loadTime();
});

function checkWeekDay(obj)
{
	
	if(obj.val() == 'w')
	{
		$('select[name="week_day"]').closest('tr').show();
	}	
	else
	{
		$('select[name="week_day"]').closest('tr').hide();
	}
}
checkWeekDay($('select[name="period"]'));

$('[name="address_id"],[name*="products"]').live('change', function(){
	calcDeliveryOptions();
	calcDelivery();
});
$('[name*="qty"]').live('keyup', function(){
	calcDeliveryOptions();
	calcDelivery();
});

$('input[value="pickup"],input[value="deliver"]').live('change', function(){
	checkDelType();
	calcDelivery();
});

$('.new_product').live('click', function(){
	if(productCount > 2)
	return false;
	
	var d = $(this).closest('div');
	d.clone().insertAfter(d).find('input').val(1);
	productCount++;
	return false;
});

function updateTotal(){
	var address_id = $('[name="address_id"]').val();
	var deliveryItems = $('input[value="deliver"]:checked').length;
	var url = '/users/reoccuring_orders/get_total?items='+serializeProducts();
	
	$.get(url,function(data){
		a = parseFloat(data);
		da = parseFloat($('#delivery_amount').html());
		da = isNaN(da) ? 0 : da;
		sa = parseFloat($('#shippingAmount').html());
		$('#grandTotal').html(a+da+sa)
	})	
}

function loadStores(){
	var url = '/cart/getstores?state='+$('select[name="store_region"] option:selected').val()+'&selected='+selectedStore;
	$('#stores').html('Loading...')
	$.get(url,function(data){
		$('#stores').html(data)
		calcDeliveryOptions();
		loadTime();
	})
}


function loadTime(){
	var url = '/cart/get_order_time?store_id='+$('select[name="store"] option:selected').val()+'&week_day='+$('select[name="week_day"] option:selected').val()+'&selected='+selectedTime;

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
	$('[name*="products"]').each(function(){
		if($(this).val()){
			// get postcode
			var addrPieces = $('[name="address_id"]  option:selected').text().split(',');
			var postcode = addrPieces[3]
			//
			var url = '/cart/calc_deliver_options?state='+$('select[name="store_region"] option:selected').val()+'&id='+$(this).val()+'&zip='+postcode;

			var t = $(this).closest('div').find('.delivery_box');
			t.html('Loading...');
			var val = $(this).val();
			$.get(url,function(data){
				t.html(data);
				checkDelType();
				calcDelivery();
				calcShipping();
				if(deliveryTypes[val] != undefined)
				{
					$('.id'+val+'[value="'+deliveryTypes[val]+'"]').attr('checked','checked');
				}
			})
		}
	});
}

function serializeProducts(){
	var a = new Array();
	var qty = new Array();
	var c=0;
	$('[name*="products"] option:selected').each(function(){
		if($(this).val()){
			a[c] = $(this).val();
			qty[c++] = $(this).closest('div').find('input').val();
		}
		
	});	
	return a.join()+'&qty='+qty.join();
}

function calcShipping()
{
	var state = $('select[name="store_region"] option:selected').val();
	var url = '/cart/getshipping?state='+state+'&items='+serializeProducts();
	$.get(url,function(data){
		shippingAmount = parseFloat(data);
		$('#shippingAmount').html(shippingAmount);
		updateTotal();
	})
}

function calcDelivery()
{
	var address_id = $('[name="address_id"]').val();
	var deliveryItems = $('input[value="deliver"]:checked').length;
	var url = '/users/reoccuring_orders/getdelivery?address_id='+address_id+'&delivery_items='+deliveryItems+'&items='+serializeProducts();
	$.get(url,function(data){
		deliveryAmount = parseFloat(data);
		deliveryAmount = isNaN(deliveryAmount) ? 0 : deliveryAmount;
		$('#delivery_amount').html(deliveryAmount) ;
		updateTotal();
	})
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

loadStores();

// alergies 
checkAllergies('<?=@$allergies_str and @$allergies ?>'?'yes':'no');
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

$( "#start_date" ).datepicker();


$('.delete').live('click', function(event){
	processBegin();
	event.preventDefault();
	if( ! confirm($(this).text()+' this?')){ processEnd(); return false}
	var $this = $(this);
	$.get($(this).attr('href'), function(data){
		$('body').append(data);
		$this.closest('tr').fadeOut(800);
		processEnd();
	})
	return false;
});


