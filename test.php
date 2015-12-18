<?php
$transport = array('foot', 'bike');
$mode = current($transport); // $mode = 'foot';
$mode = next($transport);    // $mode = 'bike';
$mode = next($transport);    // $mode = 'car';
$mode = next($transport);    // $mode = 'car';
$mode = reset($transport);
$mode = next($transport);    // $mode = 'car';
echo $mode;
$mode = prev($transport);    // $mode = 'bike';
$mode = prev($transport);    // $mode = 'bike';
echo $mode;
$mode = end($transport);     // $mode = 'plane';
exit;

$dates['asdf'] = 'asdf';
$dates['asdfq'] = 'asdf';
var_export ($dates);
reset($dates);
while ($date = current($dates))
{
    echo("<br>current = ".current($dates));
    echo("<br>key = " . key($dates));
    echo("<br>current1 = ".$key);
    echo("<br>key1 = " . $date);
    next($dates);
    if(@$c++ < 2)
    {
    	var_export(prev($dates));
    }
}
?>