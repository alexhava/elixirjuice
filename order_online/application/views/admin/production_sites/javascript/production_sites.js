$('.delete').live('click', function(event){
	event.preventDefault();
	if( ! confirm($(this).text()+' this?')){ processEnd(); return false}
	var $this = $(this);
	var process = processBegin();
	$.get($(this).attr('href'), function(data){
		$('body').append(data);
		$this.closest('tr').fadeOut(800);
		processEnd(process);
	})
	return false;
});

$('.bulk_delete').live('click', function(event){
	event.preventDefault();

	if( ! confirm($(this).val()+' this?')){ processEnd(); return false}
	var $this = $(this);
	var process = processBegin();
	var params = $('[name*="bulk"]').serialize()
	$.post($(this).attr('href'), params, function(data){
		$('body').append(data);
		$(':checked[name*="bulk"]').each(function(){
			$(this).closest('tr').fadeOut(800);
		})
		processEnd(process);
	})
	return false;
});