$('.delete').live('click', function(event){
	processBegin();
	event.preventDefault();
	if( ! confirm($(this).text()+' this?')){ processEnd(); return false}
	$this = $(this);
	$.get($(this).attr('href'), function(data){
		$('body').append(data);
		$this.closest('tr').fadeOut(1000);
		processEnd();
	})
	return false;
});

$('input[name="select_all_permissions"]').live('click', function(){
	var checked = $('input[name="select_all_permissions"]').attr('checked') == undefined ? false : true;
	$('input[name="permissions\[\]"]').attr('checked',checked);
});

$('.apply-hours').live('click', function(){
	var o = $(this).closest('tr');
	
	$('.delivery-hours').each(function(){
		var i = $(this).closest('td').index();
//		console.log($(this).closest('td').index())
		var c = o.find('td').eq(i).find('.delivery-hours').attr('checked');
		if(c != undefined)		
			$(this).attr('checked', c);
		else
			$(this).removeAttr('checked');	
	})
	
	return false;
})

$('.all-days').live('click', function(){
	if($(this).attr('checked') != undefined)
	$('.delivery-days').attr('checked', 'checked');
	else
	$('.delivery-days').removeAttr('checked');
})

$('.all-hours').live('click', function(){
	if($(this).attr('checked') != undefined)
	$(this).closest('tr').find('.delivery-hours').attr('checked', 'checked');
	else
	$(this).closest('tr').find('.delivery-hours').removeAttr('checked');
})