// select all members
$('input[name="select_all_members"]').live('click', function(){
	var checked = $('input[name="select_all_members"]').attr('checked') == undefined ? false : true;
	$('.bulk').attr('checked',checked);
});

$('#form1 select').live('change', function(){
	$('#members_table').dataTable().fnDraw();
});

$('#form1').live('submit', function(){
	$('#members_table').dataTable().fnDraw();
	return false;
});

//
$('input[name=reset_button]').live('click', function(){
	document.getElementById('form1').reset();
	$('#members_table').dataTable().fnDraw();
	return false;
});

// remove selected
$('input[name="remove_selected"]').live('click', function(){
	processBegin();
	if( ! confirm($(this).val()+'?')) { processEnd(); return false}
	$.get('/admin/members/bulk_remove_member', $('#form1').serialize(),function(data){
		$('body').append(data);
		$('#members_table').dataTable().fnDraw();
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
		$('#members_table').dataTable().fnDraw();
		processEnd();
	})
	return false;
});

// ban
$('.ban').live('click', function(event){
	processBegin();
	event.preventDefault();
	$.get($(this).attr('href'), function(data){
		$('body').append(data);
		processEnd();
	})
	return false;
});