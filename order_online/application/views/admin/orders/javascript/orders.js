// select all orders
$('input[name="select_all_orders"]').live('click', function(){
	var checked = $('input[name="select_all_orders"]').attr('checked') == undefined ? false : true;
	$('.bulk').attr('checked',checked);
});

$('#form1 select').live('change', function(){
	$('#orders_table').dataTable().fnDraw();
});

$('#form1').live('submit', function(){
	$('#orders_table').dataTable().fnDraw();
	return false;
});

//
$('input[name=reset_button]').live('click', function(){
	document.getElementById('form1').reset();
	$('#orders_table').dataTable().fnDraw();
	return false;
});

// remove selected
$('input[name="remove_selected"]').live('click', function(){
	processBegin();
	if( ! confirm($(this).val()+'?')) { processEnd(); return false}
	$.get('/admin/orders/bulk_remove_order', $('#form1').serialize(),function(data){
		$('body').append(data);
		$('#orders_table').dataTable().fnDraw();
		processEnd();
	})
	return false;
});

$('.delete').live('click', function(event){
	processBegin();
	event.preventDefault();
	if( ! confirm($(this).text()+' this?')){ processEnd(); return false}
	$.get($(this).attr('href'), function(data){
		$('body').append(data);
		$('#orders_table').dataTable().fnDraw();
		processEnd();
	})
	return false;
});


