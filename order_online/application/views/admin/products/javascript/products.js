// add option
$('input[name="add_option"]').click(function(){
	$('.no-options').remove();
	$('.price-options tbody').append($('.options-template').clone().addClass('price-option').removeClass('options-template'));
	$('.price-option').show();
	$('.price-option input').removeAttr('disabled');
	return false;
});

// remove option
$('.remove-price-option').click(function(){
	$(this).closest('tr').fadeOut();
	return false;
});

// select all products
$('input[name="select_all_products"]').live('click', function(){
	var checked = $('input[name="select_all_products"]').attr('checked') == undefined ? false : true;
	$('.bulk').attr('checked',checked);
});

$('#form1 select').live('change', function(){
	$('#products_table').dataTable().fnDraw();
});

$('#form1').live('submit', function(){
	$('#products_table').dataTable().fnDraw();
	return false;
});

//
$('input[name=reset_button]').live('click', function(){
	document.getElementById('form1').reset();
	$('#products_table').dataTable().fnDraw();
	return false;
});

// remove selected
$('input[name="remove_selected"]').live('click', function(){
	processBegin();
	if( ! confirm($(this).val()+'?')) { processEnd(); return false}
	$.get('/admin/products/bulk_remove_product', $('#form1').serialize(),function(data){
		$('body').append(data);
		$('#products_table').dataTable().fnDraw();
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
		$('#products_table').dataTable().fnDraw();
		processEnd();
	})
	return false;
});

$('.delete-image').live('click', function(event){
	processBegin();
	event.preventDefault();
	if( ! confirm($(this).text()+' this?')){ processEnd(); return false}
	$.get($(this).attr('href'), function(data){
		$('body').append(data);
		processEnd();
	})
	return false;
});


function appendIdToTr() {
	$( ".sort tbody tr" ).each(function(){
		var id = $(this).find('td:eq(0)').attr('id');
		$(this).attr('id', 'ss'+id)
	});
};

var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};

var ordering = new Array();
function makeMainTableSortable() {
	$( "span.ui-icon" ).each(function(){
		var trid = $(this).attr('trid');
		ordering[$(this).closest('tr').index()] = $(this).closest('td').find('input').val();
	});
	
	$( ".sort tbody" ).sortable({
		helper: fixHelper,
		stop: function(event, ui) {
//			alert($('[type="hidden"]').serialize())
			$( "span.ui-icon" ).each(function(){
				var trid = $(this).attr('trid');
				$(this).closest('td').find('input').val(ordering[$(this).closest('tr').index()]);
			});
			var url = '/admin/products/change_order';
			$.post(url, $('[type="hidden"]').serialize(), function(data){
				$('body').prepend('<div id="loadedContent"></div>');
				$('#loadedContent').html(data).remove();
				processEnd();
			})
		},
	});
};