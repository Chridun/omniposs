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

if(isset($_POST['us']))
{
	$returnqty = trim(stripslashes(strip_tags($_POST['returnqty'])));
	$itemcode = trim(stripslashes(strip_tags($_POST['itemcode'])));
	$itemname = trim(stripslashes(strip_tags($_POST['itemname'])));
	
	mysql_query("update items set qty=qty-".$returnqty." where icode='".$itemcode."'") or die(mysql_error());
	
	$extra = $returnqty." ".$itemname." (".$itemcode.") have been returned to the vendor";
	mysql_query("insert into xtras(typ, desr, dte) values('Return Items', '".$extra."', now())") or die(mysql_error());
	
	header("Location: items.php");
}
else if(isset($_REQUEST['i']))
{
	$itemcode = trim(stripslashes(strip_tags(base64_decode($_REQUEST['i']))));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OmniPOSS ::</title>

<script language="javascript" type="text/javascript">

function chkQty()
{
	//alert(document.getElementById('currentstock').value);

	if(isNaN(parseInt(document.getElementById('returnqty').value)) || parseInt(document.getElementById('returnqty').value) < 1 || parseInt(document.getElementById('returnqty').value) > parseInt(document.getElementById('currentstock').value))
	{
		alert("Invalid Return Quantity");
		document.getElementById('returnqty').select();
		return false;
	}
	else
	{
		return true;
	}
}

</script>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px" onload="document.getElementById('returnqty').focus()">
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
        
        <h2 align="center">RETURN ITEM</h2>

<form method="post" onsubmit="return chkQty()">
<table align="center" width="20%">


<?php


$rst = mysql_query("select iname, qty from items where icode='".$itemcode."'") or die(mysql_error());

$row = mysql_fetch_array($rst);

$itemname = trim($row['iname']);
$quantity = trim($row['qty']);
echo "<input type='hidden' name='itemcode' value='".$itemcode."' />";
echo "<tr><td>Item Name: </td><td>".$itemname."<input type='hidden' name='itemname' value='".$itemname."' /></td>";
echo "<tr><td colspan='2'><hr></td>";
echo "<tr><td>Current Stock: </td><td align='center'>".$quantity."<input type='hidden' name='currentstock' id='currentstock' value='".$quantity."' /></td>";
echo "<tr><td colspan='2'><hr></td>";
echo "<tr><td>Return Qty: </td><td align='center'><input name='returnqty' id='returnqty' size='5' required /></td>";
echo "<tr><td colspan='2'><hr></td>";
echo "<tr><td colspan='2' align='center'><input type='submit' value='Return Items' name='us' /></td>";

?>

</table>
</form>
        
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
