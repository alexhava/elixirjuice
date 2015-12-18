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