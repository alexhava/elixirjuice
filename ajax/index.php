<?php
if($_GET['do'])
{
$do = $_GET['do'];
if($do == 'getdata')
{
$state = $_POST['state'];
if($state == 'NY')
      {
echo '<option>60th and broadway</option>
      <option>250 e 54th street</option>
      <option>54 murray street</option>
	  <option>225 liberty street</option>
      <option>1429 2nd avenue</option>
      <option>100 10th avenue</option>
	   <option>2203 85th street</option>
      <option>344 amsterdam ave</option>
	  <option>1 park avenue</option>
      <option>421 hudson street</option>
      <option>5550 west 54th street</option>';
      }
elseif($state == 'CT')
      {
echo '<option>79 e. putnam avenue </option>
      <option>16 old track road</option>
      <option>500 summer street</option>';
      }
if($state == 'TX')
      {
echo '<option>8849 n. tarrant pkwy </option>';
      }

}
}

?>