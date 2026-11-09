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

if(isset($_POST['ngc']))
{
	$giftcertcode = trim(stripslashes(strip_tags($_POST['giftcertcode'])));
	$giftcertvalue = trim(stripslashes(strip_tags($_POST['giftcertvalue'])));
	
	include("incs/dbcon.inc");
	
	mysql_query("update giftc set gvalue=".$giftcertvalue." where gcode='".$giftcertcode."'") or die(mysql_error());
	
	header("Location: coupons.php");
}
else if(isset($_REQUEST['e']))
{
	include("incs/dbcon.inc");
	
	$rst = mysql_query("select gvalue from giftc where gcode='".trim(stripslashes(strip_tags(base64_decode($_REQUEST['e']))))."'") or die(mysql_error());
	
	$row = mysql_fetch_array($rst);
	
	$giftcertvalue = trim($row['gvalue']);
}

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
        
        <h2 align="center">EDIT COUPON</h2>
<form method="post">
<table align="center" width="40%">
	<tr>
    	<td>Coupon Code: </td><td><input type="hidden" name="giftcertcode" required value="<?php echo trim(stripslashes(strip_tags(base64_decode($_REQUEST['e'])))); ?>" /><?php echo trim(stripslashes(strip_tags(base64_decode($_REQUEST['e'])))); ?></td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td>Coupon Value: </td><td><input name="giftcertvalue" value="<?php echo $giftcertvalue; ?>" required /></td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td colspan="2" align="center"><input type="submit" name="ngc" value="Save Changes" /></td>
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
