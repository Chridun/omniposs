<?php
session_start();

if(isset($_SESSION['role']))
{
	if(strlen($_SESSION['role']) < 1)
	{
		header("Location: index.php");
		exit;
	}
}
else
{
	header("Location: index.php");
	exit;
}

include("incs/dbcon.inc");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OmniPOSS ::</title>

<style type="text/css">@import url(calendar-win2k-1.css);</style>
<script type="text/javascript" src="calendar.js"></script>
<script type="text/javascript" src="calendar-en.js"></script>
<script type="text/javascript" src="calendar-setup.js"></script>


</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
<table width="100%" height="99" border="0" >
  <!--DWLayoutTable-->
  <tr>
    <td height="101" colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/banner_r2_c2.png">
      <!--DWLayoutTable-->
      <tr>
        <td width="108" rowspan="2" valign="top"><table width="108" border="0" cellpadding="0" cellspacing="0" background="images/transactions_r1_c2.png">
          <!--DWLayoutTable-->
          <tr>
            <td width="108" height="99">&nbsp;</td>
              </tr>
        </table></td>
        <td width="6" height="74">&nbsp;</td>
        <td width="101" rowspan="2" valign="middle"><img src="images/transactions_r2_c4.png" width="102" height="32" /></td>
        <td width="8">&nbsp;</td>
        <td width="109" rowspan="2" valign="middle"><img src="images/transactions_r2_c7.png" width="109" height="32" /></td>
        <td width="410">&nbsp;</td>
        <td width="107" rowspan="2" valign="top"><a href="settings.php"><img src="images/transactions_r1_c19.png" title="Settings" width="107" height="99" border="0" /></a></td>
        <td width="15">&nbsp;</td>
        <td width="108" rowspan="2" valign="top"><a href="logout.php"><img src="images/transactions_r1_c22.png" title="Logout" width="108" height="99" border="0" /></a></td>
      </tr>
      <tr>
        <td height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center" valign="middle" style="color:#FFFFFF; font-family:Arial, Helvetica, sans-serif; font-size:12px">Welcome<?php include('incs/head.inc'); ?></td>
        <td>&nbsp;</td>
      </tr>
      
    </table>    </td>
  </tr>
  <tr>
    <td width="108" height="900" valign="top"><?php include('incs/cpanel.inc'); ?>    </td>
    <td width="864" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td width="864" height="898" valign="top">

        <?php 

$qry=""; 
$qry2 = "";

//$tdte = date_create(date("Y-m-d")." 00:00:00");

//$frdte = date_sub($tdte, date_interval_create_from_date_string('14 day'));
$fro = "";
$to = "";
$ttle = "";

if(isset($_POST['fro']) && isset($_POST['to']))
{
  $fro = stripslashes(trim($_POST['fro']))." 00:00:00";
  $to = stripslashes(trim($_POST['to']))." 23:59:00";
  
  
  $ttle = base64_encode("( From ".date_format(date_create($fro), 'D, j M Y ')." to ".date_format(date_create($to), 'D, j M Y ')." )");
  
  $qry = "where dte between '".$fro."' and '".$to."'";
  $qry2 = "and dte between '".$fro."' and '".$to."'";
}



?>
        
<h2 align="center"> LEDGER FOR <?php 

echo trim(stripslashes(strip_tags(base64_decode($_REQUEST['n']))));

?> </h2>

<?php

if(isset($_POST['fro']) && isset($_POST['to']))
{
  echo "<h2 align='center'>( From ".date_format(date_create($fro), 'D, j M Y ')." to ".date_format(date_create($to), 'D, j M Y ')." )</h2>";
  
}



?>


<fieldset>
<form method="post">
  <p align="center">Date From: 
    
    
    <input name="fro" id="fro" size="10" readonly/> <img src="images/Calendar.gif" title="Show Calendar" id="trigger" onClick="javascript:Calendar.setup();"/>
    
    <script type="text/javascript">
      Calendar.setup(
      {
        inputField : "fro", // ID of the input field
      ifFormat : "%Y-%m-%d", // the date format
        button : "trigger" // ID of the button
    }
    );
    </script>  Date To: <input name="to" id="to" size="10" readonly/> <img src="images/Calendar.gif" title="Show Calendar" id="trigger2" onClick="javascript:Calendar.setup();"/>
    
    <script type="text/javascript">
      Calendar.setup(
      {
        inputField : "to", // ID of the input field
      ifFormat : "%Y-%m-%d", // the date format
        button : "trigger2" // ID of the button
    }
    );
    </script>
    
    <input type="submit" value="Retrieve Report" name="btn" />
    
     </p>
</form>
</fieldset>

<table align="center" width="60%">
<th bgcolor="#000000"><font color="#FFFFFF">SNo.</font></th><th bgcolor="#000000"><font color="#FFFFFF">QUANTITY</font></th><th bgcolor="#000000"><font color="#FFFFFF"> AMOUNT (<strike>N</strike>)</font></th><th bgcolor="#000000"><font color="#FFFFFF">TRANSACTION DATE</font></th>

<?php


$ttl = 0;

$rst = mysql_query("select *, date_format( dte , '%W %D %M, %Y - %h:%i %p') as 'tdte' from trans_b where icode='".trim(stripslashes(strip_tags($_REQUEST['i'])))."' ".$qry2." order by dte desc") or die(mysql_error());

$cnt=0;
$qty=0;
$qty2 = trim(stripslashes(strip_tags($_REQUEST['q'])));

while($row=mysql_fetch_array($rst))
{
	$cnt++;
	echo "<tr><td align='center'>$cnt.</td><td align='center'>".trim($row['iqty'])."</td><td align='right'>".number_format(trim($row['amt']),2,'.',',')."</td><td align='center'>".trim($row['tdte'])."</td>";
	echo "<tr><td colspan='5'><hr /></td>";
	$ttl = $ttl + $row['amt'];
  $qty = $qty + $row['iqty'];
}

echo "<tr><td></td><td></td><td align='right'><font size='+2'> TOTAL AMOUNT: </td></td><td align='right'><font size='+2'> <b><strike>N</strike>".number_format($ttl,2,'.',',')."</b></font></td><td></td>";
echo "<tr><td></td><td></td><td align='right'><font size='+2'> TOTAL SOLD: </td></td><td align='right'><font size='+2'> <b>".number_format($qty,0,'.',',')."</b></font></td><td></td>";
echo "<tr><td></td><td></td><td align='right'><font size='+2'> TOTAL IN STOCK: </td></td><td align='right'><font size='+2'> <b>".number_format($qty2,0,'.',',')."</b></font></td><td></td>";

?>

</table>
        
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
