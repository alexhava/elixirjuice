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