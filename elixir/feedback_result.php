<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="Refresh" CONTENT="3; URL=feedback.php">
<title>Untitled Document</title>
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
<style>
body{margin:0px;}
.cmn{width:615px; margin:0px auto;}.cntct_fld{width:260px; height:37px; background:url(images/contact_fld_hvr.jpg) no-repeat; border:0px; padding:3px 0px 0px 10px; font:normal 13px calibri; color:#707070;}.cntct_fld:hover{width:260px; height:37px; background:url(images/contact_fld_bg.jpg) no-repeat; border:0px; padding:3px 0px 0px 10px; font:normal 13px calibri; color:#707070;}.lst_fld{width:270px; height:40px; background:url(images/contact_fld_hvr.jpg) no-repeat; background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.lst_fld:hover{width:270px; height:40px; background:url(images/contact_fld_bg.jpg) no-repeat; background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.mnth_fld{width:90px; height:40px; background:url(images/month_hvr.png) no-repeat; background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.mnth_fld:hover{width:90px; height:40px; background:url(images/month.png) no-repeat; background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.day_fld{width:80px; height:40px; background:url(images/month_hvr.png) no-repeat;  background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.day_fld:hover{width:80px; height:40px; background:url(images/month.png) no-repeat;  background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.cmnts_fld{width:550px; height:100px; background:url(images/comments.png) no-repeat; border:0px; padding:10px 0px 0px 10px; font:normal 13px calibri; color:#707070;}.feed_btn{width:202px; float:left; height:40px; background:url(images/feedback_btn.png) no-repeat; background-position:top; display:block;}.feed_btn:hover{background-position:bottom;}
</style>
</head>

<body>
<div class="cmn">

<div class="fdback">
  <?php

/******** START OF CONFIG SECTION *******/
  $sendto  = "jeseem@adoxsolutions.com";
  $subject = "ENQUIRY FROM `WEBSITE";
  $channelmailid="jeseem@adoxsolutions.com";
// Select if you want to check form for standard spam text
  $SpamCheck = "Y"; // Y or N
  $SpamReplaceText = "*content removed*";
// Error message prited if spam form attack found
$SpamErrorMessage = "<p align=\"center\"><font color=\"red\">Malicious code content detected.
</font><br><b>Your IP Number of <b>".getenv("REMOTE_ADDR")."</b> has been logged.</b></p>";


/******** END OF CONFIG SECTION *******/

  $name = $HTTP_POST_VARS['name']; 
  $email = $HTTP_POST_VARS['email']; 
  $phone = $HTTP_POST_VARS['phone'];
  $subject = $HTTP_POST_VARS['subject'];
  $state = $HTTP_POST_VARS['state']; 
  $city = $HTTP_POST_VARS['city'];  
  $month = $HTTP_POST_VARS['month'];
  $day = $HTTP_POST_VARS['day'];
  $year = $HTTP_POST_VARS['year']; 
    $time = $HTTP_POST_VARS['time']; 
  $comments = $HTTP_POST_VARS['comments']; 


  
  $consumerheaders = "From: $channelmailid\n";
  $consumerheaders . "MIME-Version: 1.0\n"
		   . "Content-Transfer-Encoding: 7bit\n"
		   . "Content-type: text/html;  charset = \"iso-8859-1\";\n\n";

  $headers = "From: $email\n";
  $headers . "MIME-Version: 1.0\n"
		   . "Content-Transfer-Encoding: 7bit\n"
		   . "Content-type: text/html;  charset = \"iso-8859-1\";\n\n";
if ($SpamCheck == "Y") {	

	   
// Check for Website URL's in the form input boxes as if we block website URLs from the form,
// then this will stop the spammers wastignt ime sending emails


if (preg_match("/http/i", "$name")) {echo "$SpamErrorMessage"; exit();} 
if (preg_match("/http/i", "$email")) {echo "$SpamErrorMessage"; exit();} 
if (preg_match("/http/i", "$phone")) {echo "$SpamErrorMessage"; exit();}
if (preg_match("/http/i", "$subject")) {echo "$SpamErrorMessage"; exit();} 
if (preg_match("/http/i", "$state")) {echo "$SpamErrorMessage"; exit();} 
if (preg_match("/http/i", "$city")) {echo "$SpamErrorMessage"; exit();} 
if (preg_match("/http/i", "$month")) {echo "$SpamErrorMessage"; exit();} 
if (preg_match("/http/i", "$day")) {echo "$SpamErrorMessage"; exit();} 
if (preg_match("/http/i", "$year")) {echo "$SpamErrorMessage"; exit();} 
if (preg_match("/http/i", "$time")) {echo "$SpamErrorMessage"; exit();} 
if (preg_match("/http/i", "$comments")) {echo "$SpamErrorMessage"; exit();} 

 

// Patterm match search to strip out the invalid charcaters, this prevents the mail injection spammer 
  $pattern = '/(;|\||`|>|<|&|^|"|'."\n|\r|'".'|{|}|[|]|\)|\()/i'; // build the pattern match string 
                            
  $name = preg_replace($pattern, "", $name);
  $email = preg_replace($pattern, "", $email);
  $phone = preg_replace($pattern, "", $phone);  
  $subject = preg_replace($pattern, "", $subject); 
  $state = preg_replace($pattern, "", $state);
  $city = preg_replace($pattern, "", $city);
  $month = preg_replace($pattern, "", $month);
  $day = preg_replace($pattern, "", $day);
  $year = preg_replace($pattern, "", $year);
    $time = preg_replace($pattern, "", $time);
  $comments = preg_replace($pattern, "", $comments);

  
// Check for the injected headers from the spammer attempt 
// This will replace the injection attempt text with the string you have set in the above config section
  $find = array("/bcc\:/i","/Content\-Type\:/i","/cc\:/i","/to\:/i"); 
  $name = preg_replace($find, "$SpamReplaceText", $name); 
  $email = preg_replace($find, "$SpamReplaceText", $email);
  $phone = preg_replace($find, "$SpamReplaceText", $phone); 
  $subject = preg_replace($find, "$SpamReplaceText", $subject);
  $state = preg_replace($find, "$SpamReplaceText", $state);
  $city = preg_replace($find, "$SpamReplaceText", $city);
  $month = preg_replace($find, "$SpamReplaceText", $month);
  $day = preg_replace($find, "$SpamReplaceText", $day);
  $year = preg_replace($find, "$SpamReplaceText", $year);
    $time = preg_replace($find, "$SpamReplaceText", $time);
	 $comments = preg_replace($find, "$SpamReplaceText", $comments);

    
// Check to see if the fields contain any content we want to ban
 if(stristr($name, $SpamReplaceText) !== FALSE) {echo "$SpamErrorMessage"; exit();} 
 if(stristr($mobile, $SpamReplaceText) !== FALSE) {echo "$SpamErrorMessage"; exit();} 
 
 // Do a check on the send email and subject text
 if(stristr($sendto, $SpamReplaceText) !== FALSE) {echo "$SpamErrorMessage"; exit();} 
 if(stristr($subject, $SpamReplaceText) !== FALSE) {echo "$SpamErrorMessage"; exit();} 
}
// Build the email body text
  $emailcontent = " 
----------------------------------------------------------------------------- 
   WEBSITE ENQUIRY 
----------------------------------------------------------------------------- 

Name: $name

Email: $email

Phone: $phone

Subject: $subject

State: $state

City: $city

Date of Birth: $month-$day-$year

Time of Visit: $time

Comments: $comments


_______________________________________ 
End of Email 
"; 


// Check the email address enmtered matches the standard email address format
if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$", $email)) { 
  echo "<p>It appears you entered an invalid email address</p><p><a href='javascript: history.go(-1)'>Click here to go back</a>.</p>"; 
} 

 elseif (!trim($name)) { 
  echo "<p>Please go back and enter a Name</p><p><a href='javascript: history.go(-1)'>Click here to go back</a>.</p>"; 
} 
 

 elseif (!trim($email)) { 
  echo "<p>Please go back and enter an Email</p><p><a href='javascript: history.go(-1)'>Click here to go back</a>.</p>"; 
} 

// Sends out the email or will output the error message 
 elseif (mail($sendto, $subject, $emailcontent, $headers) ) { 
  echo "<p><b>Thank You $name</b></p><p>We will be in touch as soon as possible.</p>";
  echo "<script language='javascript'> showpage();</script>";
  
  

} 




?>
  </div>
</div>
</body>
</html>
