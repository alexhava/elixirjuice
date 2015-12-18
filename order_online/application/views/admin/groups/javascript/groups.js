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