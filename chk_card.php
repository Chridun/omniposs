<?php
$c = stripslashes(strip_tags($_GET['c']));

include("incs/dbcon.inc");

$rst = mysql_query("select gvalue, status from giftc where gcode='$c'") or die(mysql_error());

if(mysql_num_rows($rst) > 0)
{
	$row = mysql_fetch_array($rst);
	if($row['status'] == "0")
	{
		echo $row['gvalue'];
	}
	else
	{
		echo "Card has been used.";
	}
}
else
{
	echo "0";
}


?>