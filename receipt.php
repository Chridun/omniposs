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

if(isset($_POST['create']))
{
	$shopname = strip_tags(trim(addslashes($_POST['shopname'])));
        $address1 = strip_tags(trim(addslashes($_POST['addressl1'])));
	$address2 = strip_tags(trim(addslashes($_POST['addressl2'])));
	$address3 = strip_tags(trim(addslashes($_POST['addressl3'])));
	$address4 = strip_tags(trim(addslashes($_POST['addressl4'])));
	//$franchisecode = strip_tags(trim(addslashes($_POST['franchisecode'])));
	$telephone = strip_tags(trim(addslashes($_POST['telephone'])));
	$emailaddress = strip_tags(trim(addslashes($_POST['emailaddress'])));
	$footerline1 = strip_tags(trim(addslashes($_POST['footerline1'])));
	$footerline2 = strip_tags(trim(addslashes($_POST['footerline2'])));
	
	mysql_query("delete from receipt") or die(mysql_error());
	mysql_query("insert into receipt values('".$shopname."','".$address1."','".$address2."','".$address3."','".$address4."','".$telephone."','".$emailaddress."','".$footerline1."','".$footerline2."',now())") or die(mysql_error());
	mysql_close();
	
	header("Location: settings.php");
}

$rst = mysql_query("select * from receipt") or die(mysql_error());
$row = mysql_fetch_array($rst);
$shopname = trim(stripslashes($row['sname']));
$address1 = trim(stripslashes($row['line1']));
$address2 = trim(stripslashes($row['line2']));
$address3 = trim(stripslashes($row['line3']));
$address4 = trim(stripslashes($row['line4']));
//$franchisecode = trim(stripslashes($row['fcode']));
$telephone = trim(stripslashes($row['tel']));
$emailaddress = trim(stripslashes($row['email']));
$footerline1 = trim(stripslashes($row['footer1']));
$footerline2 = trim(stripslashes($row['footer2']));
mysql_close();


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>OmniPOSS System</title>
<style type="text/css">
body{font-family:"trebuchet MS"; font-size:12px}
.style1 {color: #FFFFFF}
#a{color:#FFFFFF}

a{text-decoration:none;}
a:hover{text-decoration:underline}

</style>

<script language="javascript">


</script>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px" onload="document.getElementById('itemcode').focus();">
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
    <td width="864" valign="top">
        <br><br><br>
                    <form method="post">
        <table align="center" width="50%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        
	<td colspan="2" align="center"><b><u>RECEIPT HEADER</u></b></td>
<tr>
	<td>Shop Name: </td>
	<td><input name="shopname" maxlength="255" size="40" value="<?php echo $shopname; ?>"/></td>
<tr>
	<td>Address Line 1: </td>
	<td><input name="addressl1" maxlength="30" size="40" value="<?php echo $address1; ?>"/></td>

<tr>
	<td>Address Line 2: </td>
	<td><input name="addressl2" maxlength="30" size="40" value="<?php echo $address2; ?>"/></td>
<tr>
	<td>Address Line 3: </td>
	<td><input name="addressl3" maxlength="30" size="40" value="<?php echo $address3; ?>"/></td>
<tr>
	<td>Address Line 4: </td>
	<td><input name="addressl4" maxlength="30" size="40" value="<?php echo $address4; ?>"/></td>
<!--<tr>
	<td>Franchise Code: </td>
	<td><input name="franchisecode" maxlength="3" size="3" value="<?php //echo $franchisecode; ?>"/></td>
-->
<tr>
	<td>Telephone Number(s): </td>
	<td><input name="telephone" maxlength="30" size="40" value="<?php echo $telephone; ?>"/></td>
<tr>
	<td>Email Address: </td>
	<td><input name="emailaddress" maxlength="30" size="40" value="<?php echo $emailaddress; ?>"/></td>
<tr>
	<td colspan="2" align="center"><b><u>RECEIPT FOOTER</u></b></td>
<tr>
	<td>Footer Line 1: </td>
	<td><input name="footerline1" maxlength="30" size="40" value="<?php echo $footerline1; ?>"/></td>
<tr>
	<td>Footer Line 2: </td>
	<td><input name="footerline2" maxlength="30" size="40" value="<?php echo $footerline2; ?>"/></td>
<tr>
	<td colspan="2" align="center"><input type="submit" name="create" value="Apply Changes" />
        </form>
</table>
</form>
</fieldset>

	</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<body>
</html>
