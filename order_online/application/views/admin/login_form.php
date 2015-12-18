<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url?>/css/admin.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo @$page_title ?></title>
</head>
<body style="background:#fff;">
	<div id="top"></div>
	<img src="<?php echo $base_url?>/images/admin/line.jpg" alt="keywords" width="100%" height="5px" style="clear:both; display:block;"/>
	<!-- center -->
	<div style="text-align:left; margin:auto; width:600px; ">
		<!-- center - center -->

		<div id="top_login" style="border-top:1px #D8D8CB solid;"> <h3><?php echo @$page_title ?></h3>
		</div>
		<div id="center_form">
			<div class="short_text">
			<?php if(@count(@$error)):?>				
			<?php foreach ($error as $err_mes):?>
			<div><font color="Red"><?=$err_mes?></font></div>				
			<?php endforeach; ?>			
			<?php endif;?>				
			<form action="<?php echo $base_url?>/admin/login" method="post">
					<input type="hidden" name="adminlogin" value="true">
					<fieldset>
						<legend style="display: none"> Form</legend>
						<div style="float:left;">
							<div class="form" style="padding:0;"><label for="name" style="width:110px;"><?php echo lang('login')?></label><input id="Login" style="width:200px;" name="login" /></div>
						</div>
						<div style="float:left; padding-left:20px;">
							<div class="form" style="padding:0;"><label for="name" style="width:110px;"><?php echo lang('password')?></label><input id="name" style="width:200px;" type="password" name="password" /></div>
						</div>
						<div style="float:left; padding-left:20px;">
							<input type="submit" name="Log" value="<?php echo lang('next')?>" style="margin-top:17px;" class="button" />
						</div>
					</fieldset>
				</form>
			</div>
			<div id="footer"></div>
			</div>
		</div>
	</body>
</html>				