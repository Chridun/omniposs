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

if(isset($_REQUEST['d']))
{
	mysql_query("delete from vendors where vcode='".base64_decode($_REQUEST['d'])."'") or die(mysql_error());
	
	header("Location: vendors.php");
}

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
<style type="text/css">
body{font-family:"trebuchet MS"; font-size:12px}
.style1 {color: #FFFFFF}
#a{color:#FFFFFF}

a{text-decoration:none;}
a:hover{text-decoration:underline}

</style>
<script type="text/javascript" language="javascript">
function ask()
{
	if(confirm("Are you sure you want to delete this transaction?"))
	{
		return true;	
	}
	else
	{
		return false;	
	}
}
</script>
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
//include('incs/head.inc'); 

$qry=""; 
$qry2 = "";

//$tdte = date_create(date("Y-m-d")." 00:00:00");

//$frdte = date_sub($tdte, date_interval_create_from_date_string('14 day'));
$fro = "";
$to = "";
$ttle = "";
$stotal = 0;
$rtotal = 0;

if(isset($_POST['fro']) && isset($_POST['to']))
{
	$fro = stripslashes(trim($_POST['fro']))." 00:00:00";
	$to = stripslashes(trim($_POST['to']))." 23:59:00";
	
	
	$ttle = base64_encode("( From ".date_format(date_create($fro), 'D, j M Y ')." to ".date_format(date_create($to), 'D, j M Y ')." )");
	
	$qry = "and a.dte between '".$fro."' and '".$to."'";
	$qry2 = "and dte between '".$fro."' and '".$to."'";
}



?>

<h2 align="center"><?php 


 ?>CUSTOMER TRANSACTIONS <!--<a href='rpt_xls.php?typ=tr&q=<?php //echo base64_encode($qry); ?>&q2=<?php //echo base64_encode($qry2); ?>&t=<?php //echo $ttle; ?>' target='blank'><img src='images/excel.png' border=0 /></a> --></h2>

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


<table align="center" width="90%">
<th bgcolor="#000000"><font color="#FFFFFF">SNo.</font></th><th bgcolor="#000000"><font color="#FFFFFF">ITEM QUANTITY</font></th><th bgcolor="#000000"><font color="#FFFFFF">TOTAL AMOUNT (<strike>N</strike>)</font></th><th bgcolor="#000000"><font color="#FFFFFF">STATUS</font></th><th bgcolor="#000000"><font color="#FFFFFF">TRANSACTION DATE</font></th><th></th>
	
<?php

$rst = mysql_query("select a.iqty, a.amt, a.tstatus, a.tran_id, date_format( a.dte , '%W %D %M, %Y - %h:%i %p') as 'tdte' from trans a, cust_trans b where b.cust_id='".trim(stripslashes(base64_decode($_REQUEST['c'])))."' and b.tran_id=a.tran_id ".$qry." order by a.dte desc") or die(mysql_error());
	


$cnt=0;

while($row=mysql_fetch_array($rst))
{
	$cnt++;
	
	switch(trim($row['tstatus']))
	{
		case "S":
		$stotal = $stotal + $row['amt'];
		break;
		
		case "R":
		$rtotal = $rtotal + $row['amt'];
		break;
            
                case "B":
                    $stotal = $stotal + $row['amt'];
                    break;
	}
	
	echo "<tr><td align='center'>$cnt.</td><td align='center'>".trim($row['iqty'])."</td><td>".number_format(trim($row['amt']),2,'.',',')."</td><td>".getTyp(trim($row['tstatus']))."</td><td align='center'>".trim($row['tdte'])."</td><td><a href='vw_trans.php?i=".trim($row['tran_id'])."&s=".trim($row['tstatus'])."'><img src='images/view.png' border=0 title='View Transaction Breakdown' /></a> &nbsp;";
	
	if($_SESSION['role'] == "sadmin")
	{
		echo " <a href='cust_trans.php?i=".base64_encode($row['tran_id'])."' onclick='return ask()'><img src='images/del.png' alt='Delete Transaction' border=0 /></a>";
	}
	
	echo "</td>";
	echo "<tr><td colspan='6'><hr /></td>";
}

/*$rst = mysql_query("select sum(amt) as 'amt' from trans where tstatus = 'S' ".$qry2) or die(mysql_error());
if($row = mysql_fetch_assoc($rst))
{
	$stotal = number_format($row['amt']);
}

$rst = mysql_query("select sum(amt) as 'amt' from trans where tstatus = 'R' ".$qry2) or die(mysql_error());
if($row = mysql_fetch_assoc($rst))
{
	$rtotal = number_format($row['amt']);
} */

echo "<tr><td colspan='6' align='right'><font size='+2'>SALES TOTAL: <b><strike>N</strike>".number_format($stotal,2,'.',',')."</b></font></td>";
echo "<tr><td colspan='6' align='right'><font size='+2'>RETURN TOTAL: <b><strike>N</strike>".number_format($rtotal,2,'.',',')."</b></font></td>";

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
		
		default:
		return "";	
	}
}

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
