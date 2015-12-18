<?php
 $message = '
<html>
<head>
</head>
<body>
<div style="background:#f5f5f5; padding:30px; font-family:calibri; font-size:12px; color:#666666; padding-top:60px">
<div style="width:600px; margin:0 auto; background:white; border:solid 1px #dcdcdc; padding:20px; position:relative; border-radius:10px;">
<div style="position:absolute; left: 270px; top: -45px;"><a href="http://adoxsolutions.in/projects/elixir/"><img src="http://adoxsolutions.in/projects/elixir/images/logo.png" width="87" height="88" border="0"/></a>

</div>
<div style="padding-top:40px; padding-bottom:20px">
<div style="padding-bottom:15px; border-top:dashed 1px #e5e5e5; padding-top:20px;">
<div style="float:left; width:160px">Name</div>
<div style="float:left; width:400px; color:#b60050">'.$name.'</div>
<br clear="all">
</div>
<div style="padding-bottom:15px;">
<div style="float:left; width:160px">Email</div>
<div style="float:left; width:400px; color:#b60050">'.$email.'</div>
<br clear="all">
</div>

<div style="padding-bottom:15px;">
<div style="float:left; width:160px">Contact Number</div>
<div style="float:left; width:400px; color:#b60050">'.$number.'</div>
<br clear="all">
</div>

<div style="padding-bottom:15px;">
<div style="float:left; width:160px">Subject</div>
<div style="float:left; width:400px; color:#b60050">'.$subject.'</div>
<br clear="all">
</div>

<div style="padding-bottom:15px;">
<div style="float:left; width:160px">State Visited</div>
<div style="float:left; width:400px; color:#b60050">'.$state.'</div>
<br clear="all">
</div>

<div style="padding-bottom:15px;">
<div style="float:left; width:160px">City Visited</div>
<div style="float:left; width:400px; color:#b60050">'.$city.'</div>
<br clear="all">
</div>

<div style="padding-bottom:15px;">
<div style="float:left; width:160px">Date</div>
<div style="float:left; width:400px; color:#b60050">'.$day.'-'.$month.'-'.$year.'</div>
<br clear="all">
</div>
<div style="padding-bottom:15px;">
<div style="float:left; width:160px">Time of Visite</div>
<div style="float:left; width:400px; color:#b60050">'.$time.'</div>
<br clear="all">
</div>

<div style="padding-bottom:15px; background:#f5f5f5; padding:8px; border-radius:6px;">
<div style=" width:160px; color:black; font-weight:bold; font-size:14px;">Comments</div>
<div style=" width:550px; color:#666; padding-top:10px">'.$comments.'</div>
<br clear="all">
</div>
</div>
</div>
</div>
</body>
</html>';


          $headers = 'MIME-Version: 1.0' . "\r\n";
          $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

          
          $headers .= 'To: Fasil <muksith@adoxsolutions.com>' . "\r\n";
          $headers .= 'From: '.$name.' <'.$email.'>' . "\r\n";
		  $to = 'muksith@adoxsolutions.com';
		  $subject = 'Enquiry from Elixir';
         
          mail($to, $subject, $message, $headers);
          
         
		 
?>
