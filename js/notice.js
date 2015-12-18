      mouseX = 0;
      mouseY = 0;
jQuery.fn.center = function () {
	this.css("position","absolute");
	this.css("top", $(window).scrollTop() + "px");
	this.css("left", Math.max(0, (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft()) + "px");
	return this;
}

notice = new Object();
notice.inshow = false;
notice.show = function(m, type){
//	if(notice.inShow)
//	{
//		$('.notice').remove();
//	}
	notice.inShow = true;
	var id = Math.floor((Math.random()*10000)+1);
	$('body').append("<div class='notice notice"+id+" "+type+"'>"+m+"</div>");
	$('.notice').center().fadeIn(1000);
	$('.notice').append("<div id=notice'"+id+"' class='close_notice'><a href='#'>close</a></div>");
	$('.close_notice').position({
		at: "right-15 bottom-10",
		of: '.notice',
	});
	setTimeout(function(){notice.close()},3000);
}

notice.close = function(){
	notice.inshow = false;
	$('.notice').fadeOut(1000, function(){
		$('.notice').remove();
	});
}

notice.rePosition = function(){
	if( ! notice.inShow) return;
	$('.notice').center();
	$('.close_notice').position({
		at: "right-15 bottom-10",
		of: '.notice',
	});	
}

function processBegin() {
	var process = Math.floor((Math.random()*100)+1);
	$('body').prepend('<div class="loader process'+process+' transparent"><img class="follow"  src="/images/loading.gif"></div>');
	$('.process'+process).css("left", mouseX).css("top", mouseY-10);
	return '.process'+process;
};

function processEnd(process) {
		var sel = process == undefined ? '.loader' : process;
		$(sel).remove();
};

$(document).ready(function(){
	//
	$('.close_notice a').live('click', function(){
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