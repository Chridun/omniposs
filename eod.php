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

<script>
    function ask()
    {
        if(confirm("Are you sure you want to reverse this transaction?"))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>
<title>OmniPOSS ::</title>
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
            
            <marquee onmouseover='this.stop();' onmouseout='this.start();'direction='left' scrollamount='1' scrolldelay='30' style="color:red">
                <?php include_once("notifications.php"); ?>
            </marquee>
        
        <h2 align="center">END OF DAY TRANSACTIONS <!-- <a href='rpt_xls.php?typ=eod' target='blank'><img src='images/excel.png' border=0 /></a> --></h2>

<table align="center" width="90%">
<th bgcolor="#716657"><font color="#FFFFFF">SNo.</font></th><th bgcolor="#716657"><font color="#FFFFFF">ITEM QUANTITY</font></th><th bgcolor="#716657"><font color="#FFFFFF">TOTAL AMOUNT (<strike>N</strike>)</font></th><th bgcolor="#716657"><font color="#FFFFFF">STATUS</font></th><th bgcolor="#716657"><font color="#FFFFFF">TRANSACTION DATE</font></th><th bgcolor="#716657"><font color="#FFFFFF">STAFF</font></th><th></th>

<?php

$dte = date("Y-m-d");
$dd1 = $dte." 00:00:00";
$dd2 = $dte." 23:59:00";

$rst = mysql_query("select *, date_format( dte , '%W %D %M, %Y - %h:%i %p') as 'tdte' from trans where dte between '$dd1' and '$dd2' order by dte desc") or die(mysql_error());

$cnt=0;

while($row=mysql_fetch_array($rst))
{
    $r = "";
    
    if($_SESSION['role'] == 'sadmin')
    {
        $r = "<a onclick='return ask();' href='reverse.php?i=".base64_encode(trim($row['tran_id']))."'><img src='images/undo.png' title='Reverse Transaction' border=0 /></a>";
    }
    
    $cnt++;
	echo "<tr><td align='center'>$cnt.</td><td align='center'>".trim($row['iqty'])."</td><td>".number_format(trim($row['amt']),2,'.',',')."</td><td>".getTyp(trim($row['tstatus']))."</td><td align='center'>".trim($row['tdte'])."</td><td align='center'>".trim($row['staff'])."</td><td><a href='vw_trans.php?i=".trim($row['tran_id'])."&s=".trim($row['tstatus'])."'><img src='images/view.png' border=0 title='View Transaction Breakdown' /></a> &nbsp; $r</td>";
	echo "<tr><td colspan='7'><hr /></td>";
}

$rst = mysql_query("select sum(amt) as 'amt' from trans where tstatus = 'S' and dte between '$dd1' and '$dd2'") or die(mysql_error());
if($row = mysql_fetch_assoc($rst))
{
	$stotal = $row['amt'];
}

$rst = mysql_query("select sum(amt) as 'amt' from trans where tstatus = 'B' and dte between '$dd1' and '$dd2'") or die(mysql_error());
if($row = mysql_fetch_assoc($rst))
{
	$stotal = $stotal + $row['amt'];
}

$rst = mysql_query("select sum(amt) as 'amt' from trans where tstatus = 'R' and dte between '$dd1' and '$dd2'") or die(mysql_error());
if($row = mysql_fetch_assoc($rst))
{
	$rtotal = number_format($row['amt']);
}

$rst = mysql_query("select sum(cash) as 'cash', sum(cashtrf) as 'cashtrf', sum(card) as 'card' from ptype where id > 0 and dte between '$dd1' and '$dd2'") or die(mysql_error());
$row = mysql_fetch_array($rst);
$totalcash = number_format($row['cash']);
$totalcashtrf = number_format($row['cashtrf']);
$totalcard = number_format($row['card']);

echo "<tr><td colspan='6' align='right'><font size='+2'>SALES TOTAL: <b><strike>N</strike>".number_format($stotal)."</b></font></td>";
echo "<tr><td colspan='6' align='right'><font size='+2'>RETURN TOTAL: <b><strike>N</strike>".$rtotal."</b></font></td>";
echo "<tr><td colspan='6' align='right'><hr></td>";
echo "<tr><td colspan='6' align='right'><font size='+2'>TOTAL CASH: <b><strike>N</strike>".$totalcash."</b></font></td>";
echo "<tr><td colspan='6' align='right'><font size='+2'>TOTAL CASH TRANSFER: <b><strike>N</strike>".$totalcashtrf."</b></font></td>";
echo "<tr><td colspan='6' align='right'><font size='+2'>TOTAL DEBIT CARD: <b><strike>N</strike>".$totalcard."</b></font></td>";

function getTyp($t)
{
	switch($t)
	{
		case "S":
		return "Sold";
		break;
		
		case "R":
		return "Returned";
		break;
            
                case "B":
                    return "Balance Payment";
                    break;
                
                case "C":
                    return "Item Recall";
                    break;
		
		default:
		return "";	
	}
}

?>

</table>

<?php

$rst = mysql_query("select * from xtras where typ='Stock Update' and dte between '$dd1' and '$dd2'") or die(mysql_error());

if(mysql_num_rows($rst) > 0)
{
	echo "<table>";
	echo "<th colspan='2'><h2>STOCK UPDATE</h2></th>";
	echo "<tr><td colspan='2'><hr></td>";
	
	$cnt = 0;
	
	while($row = mysql_fetch_array($rst))
	{
		$cnt++;
		echo "<tr><td>$cnt.</td><td>".trim(stripslashes($row['desr']))."</td>";
		echo "<tr><td colspan='2'><hr></td>";
	}
	
	echo "</table>";
}

//==============RETURNED ITEMS================

$rst = mysql_query("select * from xtras where typ='Return Items' and dte between '$dd1' and '$dd2'") or die(mysql_error());

if(mysql_num_rows($rst) > 0)
{
	echo "<table>";
	echo "<th colspan='2'><h2>RETURNED ITEMS</h2></th>";
	echo "<tr><td colspan='2'><hr></td>";
	
	$cnt = 0;
	
	while($row = mysql_fetch_array($rst))
	{
		$cnt++;
		echo "<tr><td>$cnt.</td><td>".trim(stripslashes($row['desr']))."</td>";
		echo "<tr><td colspan='2'><hr></td>";
	}
	
	echo "</table>";
}

?>
        
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
