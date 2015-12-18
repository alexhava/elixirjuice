<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $base_url?>/css/admin.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $base_url?>/css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css"/>
<link type="text/css" href="<?php echo $base_url?>/css/menu/admin_menu.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $base_url?>/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo $base_url?>/js/main.js"></script>

<script src="/js/jquery-ui.min.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css"
    href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>
    
    <script type="text/javascript" src="<?php echo $base_url?>/js/htmlbox/htmlbox.colors.js"></script>
	<script type="text/javascript" src="<?php echo $base_url?>/js/htmlbox/htmlbox.styles.js"></script>
	<script type="text/javascript" src="<?php echo $base_url?>/js/htmlbox/htmlbox.syntax.js"></script>
	<script type="text/javascript" src="<?php echo $base_url?>/js/htmlbox/htmlbox.undoredomanager.js"></script>
	<script type="text/javascript" src="<?php echo $base_url?>/js/htmlbox/htmlbox.min.js"></script>
	<?php echo ci()->get_js_pack_string() ?>
<title><?php echo @$page_title ?></title>
	 	<?php echo @$script_foot;?>
</head>

<body style="background:#ffffff;">
<div id="main_container">

<div id="top">
<div align='left' style="height:auto;float:left;padding:0px;padding-left:20px;margin:0px"><?=lang('welcome').$this->session_data['username']?> </div>
<div align='right' style="height:auto;float:right;padding:0px;padding-right:20px;margin:0px"> <a href="<?php echo $base_url?>/admin/members/logout" style="padding:0px;margin:0px"><?=lang('logout')?> -></a></div>

 </div>
<img src="<?php echo $base_url?>/images/admin/line.jpg" alt="keywords" width="100%" height="5" style="clear:both; display:block;"/>

<table class="skeleton" cellpadding="0" cellspacing="0" border="0">
<tr>
<!-- -->

<td id="center">
<div id="top_header2" >
	<table cellpadding="4" width="100%" cellspacing="0" border="0">
	<tr>
	<td nowrap="nowrap">
		<div id="menu" >
	    	<ul class="menu">
				<?php foreach ($admin_menu as $menu_name => $menu_item):?>
					<li><a href="<?=$menu_item['url'] ? "$base_url/admin/{$menu_item['url']}" : '#'?>" class="<?=$controller != $menu_name ? 'parent' : 'current'?>" title="<?=lang($menu_name)?>"><span><?=lang($menu_name)?></span></a>
					<?php if($menu_item['sub_menu'] ): ?>
						<ul>
							<?php foreach ($menu_item['sub_menu'] as $sub_menu_name => $sub_menu_item):
					if(is_array($sub_menu_item))
					{
						$tmp_arr = current($sub_menu_item);
						$sub_menu_item = key($sub_menu_item);
					}							
							?>
								<li><a href="<?php echo rtrim($base_url, '/')?>/admin/<?=ltrim($sub_menu_item, '/')?>" title="<?=lang($sub_menu_name)?>"><?=lang($sub_menu_name)?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					</li>
				<?php endforeach; ?>			
		     </ul>
		     
		</div>
	</td>
	<td align="right"><h3>New order(s): <b><?=$new_orders_count?></b></h3></td>
	</tr>
	</table>	
</div>	
<div id="page_cont">
	<table cellpadding="4" width="100%" cellspacing="0" border="0" id="resizable">
	<tbody>
	<tr>
	<?php foreach ($admin_menu as $menu_name => $menu_item):?>
		<?php if($controller == $menu_name and $menu_item['sub_menu'] OR (isset($menu_item['group']) AND is_array($menu_item['group']) AND in_array($controller, $menu_item['group']))):?>
			<td valign="top" style="width:15%;background:#333333;" >
			<div class="resize_wrap">
				<div class="sub_menu_header"><b><?=lang($menu_name)?></b></div>
				<ul class="left_sub_menu_items">
				<?php foreach ($menu_item['sub_menu'] as $sub_menu_name => $sub_menu_item):
					$subsub_menu = '';
					if(is_array($sub_menu_item))
					{
						$tmp_arr = current($sub_menu_item);
						$sub_menu_item = key($sub_menu_item);
						foreach ($tmp_arr as $subsub_key => $subsub_val) 
						{
							$subsub_menu .= "<a href='/admin/$sub_menu_item/$subsub_key'> - $subsub_val</a>";
						}
					}
				?>
					<li >
						<a	class="<?=($method == $sub_menu_name OR ($sub_menu_item == $controller AND isset($menu_item['group']) AND is_array($menu_item['group']) AND in_array($controller, $menu_item['group']))) ? 'active_sub_menu' : ''?>"  href="/admin/<?=$sub_menu_item?>" title="" style="display:inline;clear:both;"><?=lang($sub_menu_name)?></a><?=$subsub_menu?></li>
				<?php endforeach; ?>
				</ul>	
				</div>
			</td>
		<?php endif;?>
	<?php endforeach; ?>	
	<td valign="top">
	<?php if(@$sub_title): ?><h5 style="border-bottom:2px solid black;"><?php echo @$sub_title ?></h5><br/><?php endif;?>
		<?php echo @$content ?>
    </td>	
    </tr>
    </tbody>
	</table>
</div>
</td>	
</tr>	
</table>
	<script  type='text/javascript'>
	$(function() {
		$( "#resizable td:eq(0)" ).width($.cookie("left_panel_width"));
		$( "#resizable td:eq(0) div.resize_wrap" ).resizable({
		   resize: function(event, ui) {
		   		$(this).attr('tagName');
				$( "#resizable td:eq(0)" ).width(ui.size.width+'px');
				$( "#resizable td:eq(0)" ).height(ui.size.height+'px');
		   		//		   		alert(ui.size.width)
		   },
		   stop: function(event, ui) {
		   		$.cookie("left_panel_width", ui.size.width+'px', { path: '/admin' });
		   }
		});
	});
	
	<?php if(($notice=$this->session->userdata('flash:new:notice') or $notice=$this->session->userdata('flash:old:notice'))):?>
		notice.show('<?=addslashes($notice) ?>');
	<?php elseif (($notice=$this->session->userdata('flash:new:error') or $notice=$this->session->userdata('flash:old:error'))):?>
		notice.show('<?=addslashes($notice) ?>', 'error');
	<?php endif;?>
	</script>
</div>	
</body>
</html>
