$('.delete').live('click', function(event){
	event.preventDefault();
	if( ! confirm($(this).text()+' this?')){ processEnd(); return false}
	$this = $(this);
	$.get($(this).attr('href'), function(data){
		$('body').append(data);
		$this.closest('tr').fadeOut(1000);
	})
	return false;
});