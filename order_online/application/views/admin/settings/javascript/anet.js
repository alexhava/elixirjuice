$('.api-default').live('change', function(event){
	if($(this).val())
		$('[name="api_default_id"]').val($('[name="uniq"]').val());
});

$('[name="reset"]').live('click', function(event){
	document.location.reload()
});

$('.edit-api').live('click', function(event){
	event.preventDefault();
	var idp = $(this).attr('id');
	idp = idp.split('_');
	$('[name="uniq"]').val(idp[1])

	$(this).closest('form').find('#h'+idp[1]+' input').each(function(){
		var ob = $(this).closest('form').find('.add-inputs').eq($(this).index());
		ob.attr('name', $(this).attr('name'))
		ob.attr('value', $(this).attr('value'))
	})
	return false;
});

$('.rm-api').live('click', function(event){
	event.preventDefault();
	if(!confirm('Do you want to remove this API data?')) return false;
	var idp = $(this).attr('id');
	idp = idp.split('_');

	$('#h'+idp[1]).remove();
	
	var dis = true;
	$('input.add-inputs').each(function(){
		if($(this).val()) dis = false;
	})
	if(dis)
		$('.add-inputs').attr('disabled', 'disabled');	
	document.getElementById('form1').submit();
	return false;
});

$('#form1').submit(function(event){
	var dis = true;
	$('input.add-inputs').each(function(){
		if($(this).val()) dis = false;
	})
	if(dis)
		$('.add-inputs').attr('disabled', 'disabled');
		
	return true;
});