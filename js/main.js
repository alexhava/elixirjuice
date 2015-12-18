      mouseX = 0;
      mouseY = 0;
jQuery.fn.center = function () {
	this.css("position","absolute");
	this.css("top", $(window).scrollTop() + "px");	
	this.css("left", Math.max(0, (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft()) + "px");
	return this;
}

notice = new Object();
notice.inShow = 0;
notice.drag = new Array();

notice.show = function(m, type){
//	if(notice.inShow)
//	{
//		$('.notice').remove();
//	}

	var id = Math.floor((Math.random()*10000)+1);
	var cn = ".notice"+id;
	$('#main_container').append("<div class='notice notice"+id+" "+type+"'>"+m+"</div>");
	$(cn).fadeIn(800);
	$(cn).append("<div id=notice"+id+" class='close_notice'><a href='#'>Close</a> | <a href='#' class='close_all'><b>Close ALL</b></a></div>");
	notice.setPosition(cn, notice.inShow);
	$(cn).draggable({
		drag: function( event, ui ) {
			notice.drag["notice"+id] = true;
		}
	});
	notice.inShow++;
}

notice.close = function(id){
	notice.inshow--;
	if(id)
	{
	$('.'+id).fadeOut(200, function(){
		$('.'+id).remove();
	});
	} else {
		$('.notice').fadeOut(500, function(){
			$('.notice').remove();
		});		
	}
}

notice.setPosition = function(s, i){
	$(s).position({
		my: "center+"+(parseInt(i))*3+" top",
		at: "center top+"+(parseInt(i))*3,
		of: '#main_container',
	});
	$this = $(s);
	$(s).find('.close_notice').position({
		at: "right-25 bottom-10",
		of: '.'+$this.find('.close_notice').attr('id'),
	});
}

notice.rePosition = function(){

	if( ! notice.inShow) return;
	var c = 0;
	$('.notice').each(function(){
		var id = $(this).find('.close_notice').attr('id')
		if(notice.drag[id] == undefined)
		notice.setPosition(this, c++);	
	})
}

function processBegin() {
	$('body').prepend('<div class="loader transparent"><img class="follow"  src="/images/loading.gif"></div>');
	$('.loader').css("left", mouseX).css("top", mouseY-10);
};

function processEnd() {
		$('.loader').remove();
};

$(document).ready(function(){
	//
	$('.close_notice a').live('click', function(){
		notice.close($(this).closest('div').attr("id"));
		return false;
	});
	$('.close_notice a.close_all').live('click', function(){
		notice.close();
		return false;
	});
	
	$(window).resize(function() {
		notice.rePosition();
	});	
	$(window).scroll(function() {
		notice.rePosition();
	});
	
   $(document).mousemove(function(e){
      mouseX = e.pageX;
      mouseY = e.pageY;
   });	
   

	
	
   
})