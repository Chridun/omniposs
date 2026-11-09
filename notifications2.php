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
            
            
        <h2 align="center">URGENT NOTIFICATIONS <!-- <a href='rpt_xls.php?typ=eod' target='blank'><img src='images/excel.png' border=0 /></a> --></h2>

<table align="center" width="90%">
    <th bgcolor="#716657" colspan="4"><font color="#FFFFFF">ITEMS TO BE RE-ORDERED</font></th>
    <tr><td colspan="4"><hr></td>
        
        <tr bgcolor="#716657"><td><font color="#FFFFFF">SNo.</font></td><td><font color="#FFFFFF">ITEM</font></td><td><font color="#FFFFFF">DESCRIPTION</font></td><td><font color="#FFFFFF">QTY</font></td>

<?php
include("incs/dbcon.inc");

//1. Check for items to be reordered.
$rst = mysql_query("select * from items where rpoint > qty") or die(mysql_error());

$cnt = 0;

while($row = mysql_fetch_assoc($rst))
{
    $cnt++;
    
    //if($cnt == 1)
    //{
      //  echo "<tr bgcolor='#716657'><td colspan='3'><font color='#FFFFFF'><u>Items to be re-ordered</u></font></td>";
    //}
    
    echo "<tr><td>".$cnt.".</td><td>".trim($row['iname'])."</td><td>".trim($row['idesc'])."</td><td>".$row['qty']."</td>";
    echo "<tr><td colspan='4'><hr></td>";
}
?>

</table>
            <br><hr><br>
            <table align="center" width="90%">
    <th bgcolor="#716657" colspan="4"><font color="#FFFFFF">ITEMS ABOUT TO EXPIRE</font></th>
    <tr><td colspan="4"><hr></td>
        
        <tr bgcolor="#716657"><td><font color="#FFFFFF">SNo.</font></td><td><font color="#FFFFFF">ITEM</font></td><td><font color="#FFFFFF">DESCRIPTION</font></td><td><font color="#FFFFFF">EXPIRY DATE</font></td>

<?php
include("incs/dbcon.inc");

//1. Check for items to be reordered.
//$rst = mysql_query("select * from items where expdte > qty") or die(mysql_error());
$rs = mysql_query("select iname, idesc, date_format( expdte , '%W %D %M, %Y - %h:%i %p') as 'expdte', datediff(expdte, now()) as 'dif' from items where expdte != '0000-00-00'") or die(mysql_error());

$cnt = 0;

while($row = mysql_fetch_assoc($rs))
{
   if($row['dif'] < 1)
   {
        $cnt++;
    
        echo "<tr style='color:red'><td>".$cnt.".</td><td>".trim($row['iname'])."</td><td>".trim($row['idesc'])."</td><td>".$row['expdte']."</td>";
        echo "<tr><td colspan='4'><hr></td>";
   }
   else if($row['dif'] < 91)
   {
        $cnt++;
    
        echo "<tr><td>".$cnt.".</td><td>".trim($row['iname'])."</td><td>".trim($row['idesc'])."</td><td>".$row['expdte']."</td>";
        echo "<tr><td colspan='4'><hr></td>";
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
