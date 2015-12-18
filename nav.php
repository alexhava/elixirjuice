<link href="/css/cart.css" rel="stylesheet" type="text/css" />
<?php if( ! defined('BASEPATH')) : ?>
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>

<script type="text/javascript" src="/js/plugins.js"></script>
<script src="/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="/js/global.js"></script>
<script src="/js/cart.js"></script>
<?php endif; ?>

<div id="cart_content" style="position:relative;">
<div  style="position:absolute;top:10px;right:0px;padding:0px;margin:0px;height:0px;">
	<div style="float:left;">
		<div class="users_home"><a href="/users" >My Juice Supply</a></div>
	</div>				
	<div style="float:left;margin-right:10px;">	
		<div class="cartInfo"></div>
	</div><!--End #cartPopover-->
		<div style="float:left;margin-top:10px;">
	</div>
</div>
</div>

<script type="text/javascript">
	$("#cart_content").prependTo('.auto_cmn');
	$(document).ready(function(){
		$('a').each(function(){
			if($(this).attr('href') == 'menu_stories.php'){
				$(this).attr('href', '/menus-stories')
			}
		});
	});
</script>