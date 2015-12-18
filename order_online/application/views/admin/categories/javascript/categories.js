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

$('.change_visible').live('click', function(event){
	processBegin();
	var url = '/admin/categories/change_visible?cat_id='+$(this).attr('id')+'&state='+($(this).attr('checked') == undefined ? 'n' : 'y');
	$.get(url, function(data){
		$('body').append(data);
		processEnd();
	})
});

$('input[name="cat_name"]').live('keyup change', function(){
	var val = $(this).val();
	val = val.replace(/\s/g, '-');
	val = val.replace(/[^a-zA-Z_0-9-]/g, '');
	val = val.replace(/--/g, '-');

	$('input[name="cat_url_title"]').val(val.toLowerCase());
});

var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};

function appendIdToTr() {
	$( ".sort tbody tr" ).each(function(){
		var id = $(this).find('td:eq(0)').attr('id');
		var level = $(this).find('td:eq(0)').attr('level')
		var parent = $(this).find('td:eq(0)').attr('parent')
		$(this).attr('id', 'ss'+id)
		$(this).attr('level', level)
		$(this).attr('parent', parent)
	});
};

function makeMainTableSortable() {
	$( ".sort tbody" ).sortable({
		helper: fixHelper,
		stop: function(event, ui) {
			this_parent = ui.item.attr('parent');
			this_level = ui.item.attr('level')
			next_parent = ui.item.next().attr('parent')
			prev_parent = ui.item.prev().attr('parent')
			if(this_parent != next_parent && this_parent != prev_parent && this_parent != undefined && prev_parent != undefined)
			{
				$( ".sort tbody" ).sortable('cancel');
				$( ".sort tbody tr[parent!="+this_parent+"]" ).removeClass('ui-state-disabled');
				return false;
			}
			else
			{
				var url = '/admin/categories/change_order';
				$.post(url, $( ".sort tbody" ).sortable('serialize'), function(data){
					$('body').prepend('<div id="loadedContent"></div>');
					$('#loadedContent').html(data).remove();
					makeMainTableSortable();
					appendIdToTr();
					addCollapse();
					processEnd();
				})
			}
		},
		start: function(event, ui) {
			this_level = ui.item.attr('level');
			this_parent = ui.item.attr('parent');
			$( ".sort tbody tr[parent!="+this_parent+"]" ).addClass('ui-state-disabled').removeAttr('id');
		}
	});
};

function addCollapse(){
	
	$( ".sort tbody tr" ).each(function(){
		var level =  $(this).find('td:eq(0)').attr('level')
		var id =  $(this).attr('id')
		var next_level =  parseInt($(this).next().attr('level'));
		if(level != next_level && level < next_level && ! isNaN(next_level))
		{
			$(this).find('td:eq(2) img.collapsor').remove();
			$(this).find('td:eq(2) img.expand').remove();
			$(this).find('td:eq(2)').prepend('<img class="minus collapsor" src="/images/admin/minus.png" style="padding-right:3px"/>');
			if($.cookie('collapse_type'+id) == 'm' )
			{
				var imgSelector = $(this).find('td:eq(2) img.collapsor');
				collapse(imgSelector);
			}
		}
		else
		{
			$(this).find('td:eq(2) span.padding').remove();
			$(this).find('td:eq(2)').prepend('<span class="padding" style="padding-right:18px"/>');
		}
	});
}

function collapse($this)
{
	var tr = $this.closest('tr');
	var tr2 = tr;
	var parent = parseInt(tr.attr('level'));
	var parentId = tr.attr('id');
	
	for(;;)
	{
		var nextTr = tr2.next();
		var nextParent = parseInt(nextTr.attr('level'));
		if(nextParent == parent || parent > nextParent || isNaN(nextParent))
		{
			$this.remove()
			if($this.attr('class') == 'minus collapsor')
			{
				tr.find('td:eq(2)').prepend('<img class="expand collapsor" src="/images/admin/expand.png" style="padding-right:3px"/>');
				$.cookie("collapse_type"+parentId, 'm', { path: '/admin' });
			}
			else
			{
				tr.find('td:eq(2)').prepend('<img class="minus collapsor" src="/images/admin/minus.png" style="padding-right:3px"/>');
				$.cookie("collapse_type"+parentId, '', { path: '/admin' });
			}
			return;
		}
		else
		{
			if($this.attr('class') == 'minus collapsor')
			nextTr.hide();
			else
			nextTr.show();
		}
		tr2 = nextTr;
	}
}

$(document).ready(function(){
	//sortable stuff
	makeMainTableSortable();
	appendIdToTr();
	
	//
	addCollapse();
	$('.minus, .expand, .collapsor').live('click', function(){
		collapse($(this));
		addCollapse();
	});
})

