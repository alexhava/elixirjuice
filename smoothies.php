<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Elixir Juice Bar</title>
<link href="css/jeseem.css" rel="stylesheet" type="text/css" />

<link type="text/css" href="css/jquery-ui-1.8.13.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });

				//Autocomplete
				$("#autocomplete").autocomplete({
					source: ["c++", "java", "php", "coldfusion", "javascript", "asp", "ruby", "python", "c", "scala", "groovy", "haskell", "perl"]
				});

				// Button
				$("#button").button();
				$("#radioset").buttonset();

				// Tabs
				$('#tabs').tabs();
	

				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 140,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		</script>
</head>

<body>

<div class="hndrd">
<div class="auto_cmn">
<div class="logo"><a href="index.php"><img src="images/logo.png" border="0" /></a></div>
<div class="cntnr_main">
<div class="main_brdr">
<?php include'nav.php';?>
<div class="bnr_cntnr">
<div class="tp_lnk_cntnr">
<a href="" class="menu_sub_current">MENU</a>
<a href="juices.php" class="menu_sub">NUTRITION INFORMATION</a>
</div>
</div>
<!------------ Menu Left -------------->
<div class="abt_main">
<div class="abt_brdr">
<div class="lft_mnu_cntnr">
<div class="lftmn_main" style="width:140px;">


<div id="accordion">
			<div>
				<h3><a href="#">Protein Powered</a></h3>
				<div style="width:140px;">
                <a href="" class="lft">Berry Lean</a>
                <a href="" class="lft">Beta Bee</a>
                <a href="" class="lft">Coconut Quencher</a>
                <a href="" class="lft">Creamcicle</a>
                <a href="" class="lft">Energy Elixir</a>                </div>
			</div>
			<div>
				<h3><a href="#">Functional Favorites</a></h3>
				<div style="width:140px;">
                <a href="" class="lft">dddddddd</a>
                <a href="" class="lft">dddddddd</a>
                <a href="" class="lft">dddddddd</a>
                </div>
			</div>
			<div>
				<h3><a href="#">Mix Your Own</a></h3>
				<div style="width:140px;">
                <a href="" class="lft">dddddddd</a>
                <a href="" class="lft">dddddddd</a>
                <a href="" class="lft">dddddddd</a>
                </div>
			</div>
		</div>



</div>

</div>
<div class="rgt_mnu_cntnr">
<div class="ju_cntnr">
<div class="ju_main">
<div class="ju_tp"><img src="images/juice_bg_tp.png" /></div>
<div class="ju_cntr">
<div class="juice_hd">Brain Juice</div>
<div class="juice_pic"><img src="images/juice_pic.jpg" /></div>
<div class="juice_txt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin varius aliquam molestie. Nullam velit velit, porttitor et</div>
</div>
<div class="ju_btm"><img src="images/juice_bg_btm.png" /></div>

<div class="clr"></div>
</div>
<div class="juc_sub_main">
<div class="juc_sub">
<div class="juc_sub_tp"><img src="images/juice_sub_tp.png" /></div>
<div class="juc_sub_cntr">
<div class="juc_sub_pic"><img src="images/pic_ju.png" width="130" height="112" /></div>
<div class="juc_sub_txt"><span style="font:bold 13px calibri; color:#8d0e3a;">Fatigue Fighter</span><br />Lorem ipsum dolor sit amet, consect </div>
</div>
<div class="juc_sub_btm"><img src="images/juice_sub_btm.png" /></div>

<div class="clr"></div>
</div>

<div class="juc_sub_lst">
  <div class="juc_sub_tp"><img src="images/juice_sub_tp.png" /></div>
  <div class="juc_sub_cntr">
    <div class="juc_sub_pic"><img src="images/pic_ju.png" width="130" height="112" /></div>
    <div class="juc_sub_txt"><span style="font:bold 13px calibri; color:#8d0e3a;">Fatigue Fighter</span><br />
      Lorem ipsum dolor sit amet, consect </div>
  </div>
  <div class="juc_sub_btm"><img src="images/juice_sub_btm.png" /></div>
  <div class="clr"></div>
</div>
<div class="clr"></div>
</div>
</div>
<div class="ju_rgt">
<div class="juc_sub_new">
  <div class="juc_sub_tp"><img src="images/juice_sub_tp.png" /></div>
  <div class="juc_sub_cntr">
    <div class="juc_sub_pic"><img src="images/pic_ju.png" width="130" height="112" /></div>
    <div class="juc_sub_txt"><span style="font:bold 13px calibri; color:#8d0e3a;">Fatigue Fighter</span><br />
      Lorem ipsum dolor sit amet, consect </div>
  </div>
  <div class="juc_sub_btm"><img src="images/juice_sub_btm.png" /></div>
  <div class="clr"></div>
</div>
<div class="juc_sub_new">
  <div class="juc_sub_tp"><img src="images/juice_sub_tp.png" /></div>
  <div class="juc_sub_cntr">
    <div class="juc_sub_pic"><img src="images/pic_ju.png" width="130" height="112" /></div>
    <div class="juc_sub_txt"><span style="font:bold 13px calibri; color:#8d0e3a;">Fatigue Fighter</span><br />
      Lorem ipsum dolor sit amet, consect </div>
  </div>
  <div class="juc_sub_btm"><img src="images/juice_sub_btm.png" /></div>
  <div class="clr"></div>
</div>
<div class="juc_sub_new">
  <div class="juc_sub_tp"><img src="images/juice_sub_tp.png" /></div>
  <div class="juc_sub_cntr">
    <div class="juc_sub_pic"><img src="images/pic_ju.png" width="130" height="112" /></div>
    <div class="juc_sub_txt"><span style="font:bold 13px calibri; color:#8d0e3a;">Fatigue Fighter</span><br />
      Lorem ipsum dolor sit amet, consect </div>
  </div>
  <div class="juc_sub_btm"><img src="images/juice_sub_btm.png" /></div>
  <div class="clr"></div>
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
<div class="clr"></div>
</div>
</div>

</body>
</html>
