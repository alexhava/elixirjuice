<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Elixir Juice Bar</title>
<link href="css/jeseem.css" rel="stylesheet" type="text/css" />

<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script type="text/javascript">
		$(function() {
			$("#tree").treeview({
				collapsed: true,
				animated: "fast",
				control:"#sidetreecontrol",
				prerendered: true,
				persist: "location"
			});
		})
		
</script>
<script language="Javascript" type="text/javascript"> 
<!--
function openAll() {
CollapsiblePanel1.open(),CollapsiblePanel2.open(),CollapsiblePanel3.open(),CollapsiblePanel4.open(),CollapsiblePanel5.open(),CollapsiblePanel6.open(),CollapsiblePanel7.open(),CollapsiblePanel8.open(),CollapsiblePanel9.open(),CollapsiblePanel10.open(),CollapsiblePanel11.open(),CollapsiblePanel12.open(),CollapsiblePanel13.open(),CollapsiblePanel14.open(),CollapsiblePanel15.open(),CollapsiblePanel16.open(),CollapsiblePanel17.open(),CollapsiblePanel18.open(),CollapsiblePanel19.open(),CollapsiblePanel20.open(),CollapsiblePanel21.open(),CollapsiblePanel22.open(),CollapsiblePanel23.open(),CollapsiblePanel24.open(),CollapsiblePanel25.open(),CollapsiblePanel26.open(),CollapsiblePanel27.open(),CollapsiblePanel28.open(),CollapsiblePanel29.open(),CollapsiblePanel30.open(),CollapsiblePanel31.open(),CollapsiblePanel32.open(),CollapsiblePanel33.open(),CollapsiblePanel34.open()
}
function closeAll() {
CollapsiblePanel1.close(),CollapsiblePanel2.close(),CollapsiblePanel3.close(),CollapsiblePanel4.close(),CollapsiblePanel5.close(),CollapsiblePanel6.close(),CollapsiblePanel7.close(),CollapsiblePanel8.close(),CollapsiblePanel9.close(),CollapsiblePanel10.close(),CollapsiblePanel11.close(),CollapsiblePanel12.close(),CollapsiblePanel13.close(),CollapsiblePanel14.close(),CollapsiblePanel15.close(),CollapsiblePanel16.close(),CollapsiblePanel17.close(),CollapsiblePanel18.close(),CollapsiblePanel19.close(),CollapsiblePanel20.close(),CollapsiblePanel21.close(),CollapsiblePanel22.close(),CollapsiblePanel23.close(),CollapsiblePanel24.close(),CollapsiblePanel25.close(),CollapsiblePanel26.close(),CollapsiblePanel27.close(),CollapsiblePanel28.close(),CollapsiblePanel29.close(),CollapsiblePanel30.close(),CollapsiblePanel31.close(),CollapsiblePanel32.close(),CollapsiblePanel33.close(),CollapsiblePanel34.close()
}
 
//-->
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
  <div class="tp_lnk_cntnr"> </div>
</div>
<!------------ Menu Left -------------->
<div class="abt_main">
<div class="abt_brdr">
<div class="lctn_cntnr">
<div class="lctn_sub">
<div class="clns_cmn_hd"><img src="images/faq_pic.png" width="610" height="130" /></div>
<div class="clns_cmn_hd">FAQ</div>
<div id="sidetree">
    <div class="alignbottom"> 
    <div class="lnk_clps" style="float:left; width:600px; padding-bottom:20px;"><a href="#" onclick="openAll(); return false;" class="expand_btn"></a> 
<a href="#" onclick="closeAll(); return false;" class="collaps_btn"></a></div>
 
</div> 
<div class="faq_headr">COMPANY</div>
<div id="CollapsiblePanel1" class="CollapsiblePanel"> 
      		<div class="CollapsiblePanelTab"> What does Edge 1 do? </div> 
      		<div class="CollapsiblePanelContent">Edge 1 is a datacenter and network management firm. In addition to our network management services, consulting services, and network hardware sales, we are a leading provider in service contract management, particularly Cisco SMARTnet.</div> 
      	</div> 
		
<div id="CollapsiblePanel2" class="CollapsiblePanel"> 
      		<div class="CollapsiblePanelTab">When was Edge 1 founded?</div> 
      		<div class="CollapsiblePanelContent">Edge 1 has proudly been providing networking equipment, service contracts, and professional services since 2003.</div> 
      	</div> 
 
<div class="faq_headr">CLIENTS</div>
		
<div id="CollapsiblePanel3" class="CollapsiblePanel"> 
      		<div class="CollapsiblePanelTab"> Who are your clients?</div> 
      		<div class="CollapsiblePanelContent">Our client base consists of US Government agencies, local municipalities, educational entities, and corporations ranging from small businesses to Fortune 500.</div> 
      	</div>
<div id="CollapsiblePanel4" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab"> Do you offer special pricing and solutions for educational entities such as schools and colleges?</div>
  <div class="CollapsiblePanelContent">Yes, we are able to offer special discounting programs for networking equipment, licensing, service contracts, and consulting services for accredited educational entities. Additionally, we are able to pass along any special incentives and programs from any of the vendors we provide solutions from such as Microsoft, Cisco, Raritan, Barracuda Networks and more.</div>
</div>
<div id="CollapsiblePanel5" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab"> Does your staff have US Government security clearances and the ability to work on classified government projects?</div>
  <div class="CollapsiblePanelContent">Yes, we are able to provide consultancy services from our on-staff engineers who hold active DOD Top Secret and DOE Q clearances. Additional details can be requested by submitting an inquiry to gov@edge1.net.</div>
</div>

    </div>
</div>
</div>
<div class="clens_rgt">
  <div class="clns_tag_cntnr">
    <div class="tags" style="padding-bottom:10px;"><img src="images/elixir_location.png" width="230" height="189" /></div>
    <div class="tags" style="padding-bottom:10px;"><img src="images/talkto_us.png" width="230" height="189" /></div>
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
<script type="text/javascript">
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2");
var CollapsiblePanel3 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel3");
var CollapsiblePanel4 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel4");
var CollapsiblePanel5 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel5");
var CollapsiblePanel6 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel5");
</script>


<script type="text/javascript">
var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23680037-1']);
  _gaq.push(['_trackPageview']);
 
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
var CollapsiblePanel6 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel6");
var CollapsiblePanel7 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel7");
var CollapsiblePanel8 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel8");
var CollapsiblePanel9 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel9");
var CollapsiblePanel10 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel10");
var CollapsiblePanel11 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel11");
var CollapsiblePanel12 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel12");
var CollapsiblePanel13 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel13");
var CollapsiblePanel14 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel14");
</script>
</body>
</html>
