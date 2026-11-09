<?php
session_start();

$i = explode("^",$_GET['i']);

include("incs/dbcon.inc");

//$rst = mysql_query("select * from staff where uname='".$i[0]."' and pwd='".$i[1]."'") or die(mysql_error());
$rst = mysql_query("select fname, role from logs where uname='".$i[0]."' and pwd='".md5($i[1])."' and status='1'") or die(mysql_error());

	if($row = mysql_fetch_assoc($rst))
	{
		//$row = mysql_fetch_array($rst);
		$_SESSION['fname'] = trim($row['fname']);
		$_SESSION['role'] = trim($row['role']);
		$_SESSION['u'] = $i[0];
		
		echo "1";
	}
	else
	{
		echo "2";
	}

?>