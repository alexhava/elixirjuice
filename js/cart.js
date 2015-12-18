$(function(){
	jQuery.fn.cartTotal = function () {
		var $this = this;
		var url = '//'+window.location.host+'/cart/cart_total';
		$.get(url,function(data){
			$this.html(data);
		})

		return this;
	}

	$(".cartInfo").toggle(function(){
		$("#cartPopover").show();
		$("header .cartInfo").addClass('open');
	}, function(){
		$("#cartPopover").hide();
		$(".cartInfo").removeClass('open');
	});

	$(".update-cart").click(function(){
		$(this).loading();
		var url = '//'+window.location.host+'/cart/update_cart';
		$.post(url,$('input').serialize(), function(data){
			updateTopCart();
			$('.cart-total').cartTotal();
			$('.loading-image').remove();
			document.location.reload();
		})
		return false;
	});

	$(".item_add").click(function(){
		var id = $(this).closest('li').find('[name="product_id"]').val();
		 	id = typeof id == 'undefined' ? $(this).closest('#content').find('[name="product_id"]').val() : id;
		var opt = $(this).closest('li').find('[name="product_option"]').val();
		var qty = typeof $('[name="product_qty"]').val() != 'undefined' ? $('[name="product_qty"]').val() : 1;
		var rel = $(this).closest('li').find('.option-check:checked').map(function(){return $(this).val()}).get().join(',');
		
		rel = typeof rel == 'undefined' ? '' : rel;
		opt = typeof opt == 'undefined' ? '' : opt;
		var url = '//'+window.location.host+'/cart/add_to_cart?id='+id+'&qty='+qty+'&rel='+rel+'&opt='+opt;

		$.get(url,function(data){
			updateTopCart();
		})
		notice.show($(this).parent().parent().find('.title-content').html() + ' was added to your cart');
	});

	$(".delete-cart-item").click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		var url = '//'+window.location.host+'/cart/remove_cart_item?id='+id;

		$this = $(this);
		$.get(url,function(data){
			updateTopCart();
			$('.cart-total').cartTotal();
			$this.closest('tr').fadeOut(1000);
			$('.cart_total_price_number').html(data);
		})
		return false;
	});

	$(".cleanses_calendar_day_active").live('click',function(){
		var day = $(this).find('#cell_wrapper').html();
		day = day.length == 1 ? '0'+day : day;
		var month = $('[name="month"]').val();
		var year = $('[name="year"]').val();
		var date = month + '/' + day + '/' + year;
		$('.delivery-date').val(date);
		loadTime();
	});
});

function updateTopCart()
{
	var url = '//'+window.location.host+'/cart/get_total_items';
	$.get(url,function(data){
		$('.cart-quantity').html(data);
	})
}

function updateOptionsPrice($this)
{
	var sli = $this;
	var p = parseFloat(sli.attr('data-price'));
	
	var pc = sli.closest('.number_ofdate').closest('li');
	pc.find('.option-check').each(function(){
		if($(this).attr('checked'))
		{
			p += (parseFloat($(this).attr('data-option-price')) * parseInt(sli.attr('data-num-days')));
		}
	});
	pc.find('.price_number_holder').html(p.toFixed(2));
}

$(document).ready(function(){
	
	$('.cartInfo a').click(function(){
		document.location.href=$(this).attr('href');
		return true;
	});	
	
	$('li.cart').click(function(){
		document.location.href=$(this).find('a').attr('href');
		return true;
	});
	
	updateTopCart();
	//	simpleCart.bind( 'beforeSave' , function(){
	//		simpleCart.each(function( item , x ){
	//			var n = item.get('name');
	//			var q = item.get('quantity');
	//			var url = window.location.protocol + "//" + window.location.host+'/cart/change_cleanse_qty?name='+n+'&qty='+q+'&rand='+escape(Math.random());
	//			$.get(url,function(data){
	//				$('#cleanses_date_wrapper').html(data);
	//			})
	//		});
	//	});
	//	simpleCart.bind( 'beforeRemove' , function( item ){
	//		var n = item.get('name');
	//		var url = '/cart/change_cleanse_qty?name='+n+'&qty='+0;
	//
	//		$.get(url,function(data){
	//			$('#cleanses_date_wrapper').html(data);
	//		})
	//	});
	
	// price switch
	$('.number_ofdate li').click(function(){
		var pc = $(this).closest('.number_ofdate').closest('li');
		$(this).closest('ul').find('li').removeClass('selected');
		$(this).addClass('selected');
		pc.find('[name="product_option"]').val($(this).attr('data-selected-id'));
		updateOptionsPrice($(this));
	})
	
	$('.option-check').click(function(){
		var pc = $(this).closest('li');
		updateOptionsPrice(pc.find('.number_ofdate li.selected'));
	})	
});





















