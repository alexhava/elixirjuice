<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">google.load("jquery", "1.5.1");</script>
<script type="text/javascript" src="js/jquery.watermark.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#state").change(function(){
		var state = $(this).val();
		$.post('ajax/?do=getdata',{state:state},function(data){
			$("#city").html(data);
		});
	});
});
</script>
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
.cmn{width:615px; margin:0px auto;}.cntct_fld{width:260px; height:37px; background:url(images/contact_fld_hvr.jpg) no-repeat; border:0px; padding:3px 0px 0px 10px; font:normal 13px calibri; color:#707070;}.cntct_fld:hover{width:260px; height:37px; background:url(images/contact_fld_bg.jpg) no-repeat; border:0px; padding:3px 0px 0px 10px; font:normal 13px calibri; color:#707070;}.lst_fld{width:270px; height:40px; background:url(images/contact_fld_hvr.jpg) no-repeat; background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.lst_fld:hover{width:270px; height:40px; background:url(images/contact_fld_bg.jpg) no-repeat; background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.mnth_fld{width:90px; height:40px; background:url(images/month_hvr.png) no-repeat; background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.mnth_fld:hover{width:90px; height:40px; background:url(images/month.png) no-repeat; background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.day_fld{width:80px; height:40px; background:url(images/month_hvr.png) no-repeat;  background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.day_fld:hover{width:80px; height:40px; background:url(images/month.png) no-repeat;  background-position:top;border:0px; padding:10px 5px 5px 10px;  font:normal 13px calibri; color:#707070;}.cmnts_fld{width:550px; height:100px; background:url(images/comments.png) no-repeat; border:0px; padding:10px 0px 0px 10px; font:normal 13px calibri; color:#707070;}.feed_btn{width:202px; float:left; height:40px; background:url(images/feedback_btn.png) no-repeat; background-position:top; border:0px; cursor:pointer; display:block;}.feed_btn:hover{background-position:bottom;}
</style>
</head>

<body>
<div class="cmn">

<form action="feedback_result.php" method="post">
  <table width="615" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="278">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="327">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="text" name="name" id="name" class="cntct_fld" /></td>
      <td>&nbsp;</td>
      <td><input type="text" name="email" id="email" class="cntct_fld" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="text" name="phone" id="phone" class="cntct_fld" /></td>
      <td>&nbsp;</td>
      <td><input type="text" name="subject" id="sub" class="cntct_fld" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><select name="state" id="state" class="lst_fld">
        <option>State Visited</option>
        <option value="NY">NY</option>
        <option value="CT">CT</option>
        <option value="TX">TX</option>
                  </select></td>
      <td>&nbsp;</td>
      <td>
            <select name="city" id="city" class="lst_fld">
        <option>City Visited</option>
            </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><table width="278" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="95"><select name="month" id="select6" class="mnth_fld">
            <option value="-1" selected="selected">- Month -</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
          </select>          </td>
          <td width="88"><select name="day" id="select7" class="day_fld">
            <option value="-1" selected="selected">- Date -</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
              
                    </select></td>
          <td width="95"><select name="year" id="select8" class="mnth_fld">
            <option value="-1"  selected="selected">- Year -</option>
                <option value="1940">1940</option>
                <option value="1941">1941</option>
                <option value="1942">1942</option>
                <option value="1943">1943</option>
                <option value="1944">1944</option>
                <option value="1945">1945</option>
                <option value="1946">1946</option>
                <option value="1947">1947</option>
                <option value="1948">1948</option>
                <option value="1949">1949</option>
                <option value="1950">1950</option>
                <option value="1951">1951</option>
                <option value="1952">1952</option>
                <option value="1953">1953</option>
                <option value="1954">1954</option>
                <option value="1955">1955</option>
                <option value="1956">1956</option>
                <option value="1957">1957</option>
                <option value="1958">1958</option>
                <option value="1959">1959</option>
                <option value="1960">1960</option>
                <option value="1961">1961</option>
                <option value="1962">1962</option>
                <option value="1963">1963</option>
                <option value="1964">1964</option>
                <option value="1965">1965</option>
                <option value="1966">1966</option>
                <option value="1967">1967</option>
                <option value="1968">1968</option>
                <option value="1969">1969</option>
                <option value="1970">1970</option>
                <option value="1971">1971</option>
                <option value="1972">1972</option>
                <option value="1973">1973</option>
                <option value="1974">1974</option>
                <option value="1975">1975</option>
                <option value="1976">1976</option>
                <option value="1977">1977</option>
                <option value="1978">1978</option>
                <option value="1979">1979</option>
                <option value="1980">1980</option>
                <option value="1981">1981</option>
                <option value="1982">1982</option>
                <option value="1983">1983</option>
                <option value="1984">1984</option>
                <option value="1985">1985</option>
                <option value="1986">1986</option>
                <option value="1987">1987</option>
                <option value="1988">1988</option>
                <option value="1989">1989</option>
                <option value="1990">1990</option>
                <option value="1991">1991</option>
                <option value="1992">1992</option>
                <option value="1993">1993</option>
                    </select></td>
        </tr>
      </table></td>
      <td>&nbsp;</td>
      <td><select name="time" id="select3" class="lst_fld">
        <option selected="selected" value="">Time of Visit</option>
									<option value="Open - 11:00am">Open - 11:00am</option>
									<option value="11:00am - 2:00pm">11:00am - 2:00pm</option>
									<option value="2:00pm - 5:00pm">2:00pm - 5:00pm</option>
									<option value="5:00pm - Close">5:00pm - Close</option>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="3"><input name="comments" type="text" class="cmnts_fld" id="comments" value="" /></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input name="image2" type="submit" value="" src="images/submit.jpg" alt="Submit" class="feed_btn"/></td>
      <td>&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  </form>
</div>
</body>
</html>
