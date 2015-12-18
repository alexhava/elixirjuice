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

$('button[name="add_allergy"]').live('click', function(event){
	var url = '/users/allergies/add_allergy';
	var postData = { allergy: $('.add_allergy').val() };
	var process = processBegin();
	$.post(url, postData, function(data){
		$('body').append(data);
		processEnd(process);
	})
	return false;
});
$('button[name="edit_allergy"]').live('click', function(event){
	var tr = $(this).closest('tr');
	var id = tr.find('a.edit_allergy').attr('id');
	var url = '/users/allergies/edit_allergy';
	var allery = '/users/allergies/edit_allergy';
	var postData = { allergy: $('#edit_text'+id+' input').val(), allergy_id:  id};
	processBegin();
	$.post(url, postData, function(data){
		$('body').append(data);
		$('#edit_text'+id).val(postData.allergy).hide();
		$('#text'+id).html(postData.allergy).show();
		$('#edit_button'+id).hide();
		$('#edit'+id).show();	
		processEnd();	
	})
	return false;
});

$('.edit_allergy').live('click', function(event){
	var tr = $(this).closest('tr');
	var id = $(this).attr('id');
	$('#edit_text'+id).show();
	$('#text'+id).hide();
	$('#edit_button'+id).show();
	$('#edit'+id).hide();
	tr.find('.edit_text').show();
	return false;
});