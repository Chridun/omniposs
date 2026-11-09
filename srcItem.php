<?php
$i = explode("^",$_GET['i']);

include("incs/dbcon.inc");

if(strlen($i[0]) > 0)
{
    $rst = mysql_query("select icode from items where iname='".$i[0]."'") or die(mysql_error());
}
else if(strlen($i[1]) > 0)
{
    $rst = mysql_query("select icode from items where idesc='".$i[1]."'") or die(mysql_error());
}



if(mysql_num_rows($rst) > 0)
{

$row = mysql_fetch_array($rst);

	echo trim($row['icode']);
}
else
{
	echo "1";
}
?>