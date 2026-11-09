<?php
session_start();

if(isset($_SESSION['role']))
{
	if(strlen($_SESSION['role']) < 1)
	{
		header("Location: index.php?m=".base64_encode("Session expired, please login."));
		exit;
	}
}
else
{
	header("Location: index.php?m=".base64_encode("Session expired, please login."));
	exit;
}

$cnt = trim(stripslashes(strip_tags($_POST['cnt'])));


include("incs/dbcon.inc");


for($i=0; $i <= $cnt; ++$i)
{
	if(isset($_POST['itemcode'.$i]) && strlen($_POST['itemcode'.$i]) > 1)
	{
		
                $newstock = $_POST['qty'.$i];//trim(stripslashes(strip_tags($_POST['newstock'])));
                $itemcode = $_POST['itemcode'.$i]; //trim(stripslashes(strip_tags($_POST['itemcode'])));
                $itemname = $_POST['item'.$i];//trim(stripslashes(strip_tags($_POST['itemname'])));

                mysql_query("update items set qty=qty+".$newstock." where icode='".$itemcode."'") or die(mysql_error());

                $extra = $itemname." (".$itemcode.") has been updated with ".$newstock." item(s)";
                mysql_query("insert into xtras(typ, desr, dte) values('Stock Update', '".$extra."', now())") or die(mysql_error());

	}
}
//exit;

header("Location: items.php");
?>