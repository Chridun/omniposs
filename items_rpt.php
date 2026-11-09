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
            
            <marquee onmouseover='this.stop();' onmouseout='this.start();'direction='left' scrollamount='1' scrolldelay='30' style="color:red">
                <?php include_once("notifications.php"); ?>
            </marquee>
        
        <?php
$fro = "";
$to = "";
$qry = "";
$qry2 = "";
$ttle = "";

if(isset($_POST['fro']) && isset($_POST['to']))
{
	$fro = stripslashes(trim($_POST['fro']))." 00:00:00";
	$to = stripslashes(trim($_POST['to']))." 23:59:00";
	
	
	$ttle = base64_encode("( From ".date_format(date_create($fro), 'D, j M Y ')." to ".date_format(date_create($to), 'D, j M Y ')." )");
	
	$qry = "where dte between '".$fro."' and '".$to."'";
	$qry2 = " and a.dte between '".$fro."' and '".$to."' ";
}
?>

<h2 align="center">ITEMS REPORT <!-- <a href='rpt_xls.php?typ=items&q=<?php echo base64_encode($qry); ?>&q2=<?php echo base64_encode($qry2); ?>&t=<?php echo $ttle; ?>' target='blank'><img src='images/excel.png' border=0 /></a> --></h2>
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

<?php 

//$tdte = date_create(date("Y-m-d")." 00:00:00");

//$frdte = date_sub($tdte, date_interval_create_from_date_string('14 day'));
//$fro = "";
//$to = "";

if(isset($_POST['fro']) && isset($_POST['to']))
{
	//$fro = stripslashes(trim($_POST['fro']))." 00:00:00";
	//$to = stripslashes(trim($_POST['to']))." 23:59:00";
	
	
	echo "<h2 align='center'>( From ".date_format(date_create($fro), 'D, j M Y ')." to ".date_format(date_create($to), 'D, j M Y ')." )</h2>";
	
	//$qry = "where dte between '".$fro."' and '".$to."'";
	//$qry2 = " and dte between '".$fro."' and '".$to."' ";
}


//20 Best Selling Items

$total = 0;
$tqty = 0;

echo "<table width='50%' align='center'><th colspan=5><h2><u>TOP 20 BEST SELLING ITEMS</u></h2></th>";
echo "<tr><td align='center'>SNo.</td><td align='center'>ITEM CODE</td><td align='center'><b>ITEM NAME</b></td><td align='center'><b>QTY SOLD</b></td><td align='center'><b>VALUE (<strike>N</strike>)</b></td><tr><td colspan=5><hr></td>";
$cnt=0;

$rst = mysql_query("select icode, sum(amt) as 'amt', sum(iqty) as 'iqty' from trans_b ".$qry." group by icode order by iqty desc limit 20") or die(mysql_error());

while($row = mysql_fetch_array($rst))
{
	$cnt++;
	$total = $total + $row['amt'];
	$tqty = $tqty + $row['iqty'];
	echo "<tr><td align='center'>$cnt.</td><td>".$row['icode']."</td><td>".getIName(trim($row['icode']))."</td><td align='center'>".number_format($row['iqty'],0,'.',',')."</td><td align='right'>".number_format($row['amt'],2,'.',',')."</td>";
	echo "<tr><td colspan=5><hr></td>";
}
echo "<tr><td colspan=3></td><td align='center'><b>".number_format($tqty,0,'.',',')."</b></td><td align='right'><b>".number_format($total,2,'.',',')."</b></td>";
echo "<tr><td colspan=5><hr></td>";

echo "</table>";
echo "<br><br>";
//top 20 worst selling items
echo "<table width='50%' align='center'><th colspan=5><h2><u>TOP 20 WORST SELLING ITEMS</u></h2></th>";
echo "<tr><td align='center'>SNo.</td><td align='center'>ITEM CODE</td><td align='center'><b>ITEM NAME</b></td><td align='center'><b>QTY SOLD</b></td><td align='center'><b>VALUE (<strike>N</strike>)</b></td><tr><td colspan=5><hr></td>";
$cnt=0;
$total = 0;
$tqty = 0;

$rst = mysql_query("select icode, sum(amt) as 'amt', sum(iqty) as 'iqty' from trans_b ".$qry." group by icode order by iqty limit 20") or die(mysql_error());

while($row = mysql_fetch_array($rst))
{
	$cnt++;
	$total = $total + $row['amt'];
	$tqty = $tqty + $row['iqty'];
	echo "<tr><td align='center'>$cnt.</td><td>".$row['icode']."</td><td>".getIName(trim($row['icode']))."</td><td align='center'>".number_format($row['iqty'],0,'.',',')."</td><td align='right'>".number_format($row['amt'],2,'.',',')."</td>";
	echo "<tr><td colspan=5><hr></td>";
}
echo "<tr><td colspan=3></td><td align='center'><b>".number_format($tqty,0,'.',',')."</b></td><td align='right'><b>".number_format($total,2,'.',',')."</b></td>";
echo "<tr><td colspan=5><hr></td>";

echo "</table><br><br><br>";

//total list of items sold
echo "<table width='50%' align='center'><th colspan=5><h2><u>LIST OF ITEMS SOLD</u></h2></th>";
echo "<tr><td align='center'>SNo.</td><td align='center'>ITEM CODE</td><td align='center'><b>ITEM NAME</b></td><td align='center'><b>QTY SOLD</b></td><td align='center'><b>VALUE (<strike>N</strike>)</b></td><tr><td colspan=5><hr></td>";
$cnt=0;
$total = 0;
$tqty = 0;

$rst = mysql_query("select icode, sum(amt) as 'amt', sum(iqty) as 'iqty' from trans_b ".$qry." group by icode order by iqty desc") or die(mysql_error());

while($row = mysql_fetch_array($rst))
{
	//if($row['tstatus'] == "S")
	//{
		$cnt++;
		$total = $total + $row['amt'];
		$tqty = $tqty + $row['iqty'];
		echo "<tr><td align='center'>$cnt.</td><td>".$row['icode']."</td><td>".getIName(trim($row['icode']))."</td><td align='center'>".number_format($row['iqty'],0,'.',',')."</td><td align='right'>".number_format($row['amt'],2,'.',',')."</td>";
		echo "<tr><td colspan=5><hr></td>";
	//}
	//else if($row['tstatus'] == "R")
	//{
	//	$total = $total - $row['amt'];
	//	$tqty = $tqty - $row['iqty'];
	//}
}
echo "<tr><td colspan=3></td><td align='center'><b>".number_format($tqty,0,'.',',')."</b></td><td align='right'><b>".number_format($total,2,'.',',')."</b></td>";
echo "<tr><td colspan=5><hr></td>";

echo "</table>";

function getIName($i)
{
	$rs = mysql_query("select iname, idesc from items where icode='$i'") or die(mysql_error());
	
	$rw = mysql_fetch_array($rs);
	
	return trim(stripslashes($rw['iname']))." (".trim(stripslashes($rw['idesc'])).") ";
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
