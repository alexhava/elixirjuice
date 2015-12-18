<?php $__ROOT = $this->config->item('base_url') ?>
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
				<?php echo @$content ?>
			</div>
			<div id="footer"></div>
			</div>
		</div>
	</body>
</html>

