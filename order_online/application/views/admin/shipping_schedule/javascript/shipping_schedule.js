$('.delete').live('click', function(event){
	processBegin();
	event.preventDefault();
	if( ! confirm($(this).text()+' this?')){ processEnd(); return false}
	$this = $(this);
	$.get($(this).attr('href'), function(data){
		$this.closest('tr').fadeOut(1000);
		$('body').append(data);
		processEnd();
	})
	return false;
});

$('input[name="select_all_permissions"]').live('click', function(){
	var checked = $('input[name="select_all_permissions"]').attr('checked') == undefined ? false : true;
	$('input[name="permissions\[\]"]').attr('checked',checked);
});

var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};


function makeMainTableSortable() {
	$( ".shipping-schedule tbody" ).sortable({
		helper: fixHelper,
		stop: function(event, ui) {

			var url = '/admin/shipping_schedule/change_order';
			$.post(url, $( ".form1" ).serialize(), function(data){
				$( ".shipping-schedule tbody tr" ).each(function(){
					$(this).find('td:eq(1)').html($(this).index());
				});
			})
		},
		start: function(event, ui) {
		}
	});
};
makeMainTableSortable();