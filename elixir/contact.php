<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Elixir Juice Bar</title>
<link href="css/jeseem.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">google.load("jquery", "1.5.1");</script>
<script type="text/javascript" src="js/jquery.watermark.min.js"></script>
<script type="text/javascript">
	$(function () {
		$("#name").watermark("Enter your name...");
		$("#email").watermark("Enter your email...");
		$("#phone").watermark("Enter your phone...");
		$("#sub").watermark("Enter your subject..");
		$("#comments").watermark("Enter your comments..");
	});
		</script>
<!--[if IE ]>
        <link rel="stylesheet" type="text/css" href="ie.css" />
<![endif]-->
</head>
<body>
<div class="hndrd">
	<div class="auto_cmn">
		<div class="logo">
			<a href="index.php"><img src="images/logo.png" border="0"/></a>
		</div>
		<div class="cntnr_main">
			<div class="main_brdr">
				<?php include'nav.php';?>
				<div class="bnr_cntnr">
					<div class="tp_lnk_cntnr">
					</div>
				</div>
				<!------------ Menu Left -------------->
				<div class="abt_main">
					<div class="abt_brdr">
						<div class="lctn_cntnr">
							<div class="clns_cmn_hd">
								<img src="images/contact.png" width="610" height="130"/>
							</div>
							<div class="clns_cmn_hd">
								Contact
							</div>
							<div class="prss_sub">
								<div class="cntct_sb_hd">
									Corporate Address
								</div>
								<div class="prss_mtr" style="float:left; padding-left:10px;">
									<br/> Elixir Juice Bar<br/> 60th and broadway<br/> columbus circle @ equinox club<br/> 212.315.1538<br/> Email:comments@elixirjuice.com<br/><br/>
								</div>
								<div class="cntct_sb_hd">
									Question, Concern, or Compliment - We'd like to hear about it.
								</div>
								<div class="contct_cntnr" style="padding-top:10px; float:left; width:615px;">
									<iframe allowtransparency="true" src="feedback.php" marginwidth="0" marginheight="0" border="0" style="border: medium none;" align="middle" width="615" frameborder="0" height="450" scrolling="No">
									</iframe>
								</div>
								<div class="clr">
								</div>
							</div>
						</div>
						<div class="clens_rgt">
							<div class="clns_tag_cntnr">
								<div class="tags" style="padding-bottom:10px;">
									<img src="images/elixir_location.png" width="230" height="189"/>
								</div>
								<div class="tags" style="padding-bottom:10px;">
									<img src="images/talkto_us.png" width="230" height="189"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="ftr_cntnr">
				<?php include'footer.php';?>
			</div>
		</div>
		<div class="clr">
		</div>
	</div>
</div>
</body>
</html>