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

if(isset($_POST['chng']))
{
	$oldpwd = stripslashes(strip_tags(trim($_POST['oldpwd'])));
	$newpwd = stripslashes(strip_tags(trim($_POST['newpwd'])));
	
	include("incs/dbcon.inc");
	
	$rst = mysql_query("select uname from logs where uname='".$_SESSION['u']."' and pwd='".md5($oldpwd)."'") or die(mysql_error());
	if(mysql_num_rows($rst) > 0)
	{
		mysql_query("update logs set pwd='".md5($newpwd)."' where uname='".$_SESSION['u']."'") or die(mysql_error());
		header("Location: changepwd.php?m=".base64_encode("Password has been changed!"));
		exit;
	}
	else
	{
		header("Location: changepwd.php?m=".base64_encode("Invalid Old Password"));
		exit;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OmniPOSS ::</title>

<script language="javascript" type="text/javascript">
//alert("asasd");
function chkF()
{
	if(document.getElementById('oldpwd').value.length < 2)
	{
		alert("Invalid Old Password");
		document.getElementById('oldpwd').focus();
		return false;
	}
	else if(document.getElementById('newpwd').value.length < 2)
	{
		alert("Invalid New Password");
		document.getElementById('newpwd').focus();
		return false;
	}
	else if(document.getElementById('newpwd2').value.length < 2)
	{
		alert("Retype New Password");
		document.getElementById('newpwd2').focus();
		return false;
	}
	else if(document.getElementById('newpwd').value != document.getElementById('newpwd2').value)
	{
		alert("Passwords do not match, please retype");
		document.getElementById('newpwd2').select();
		return false;
	}
	else
	{
		return true;
	}
}
</script>


</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px" onload="document.getElementById('oldpwd').focus()">
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
        
        <h2 align="center">CHANGE PASSWORD</h2>

<form method="post" onsubmit="return chkF()">
<table align="center">
	<tr>
    	<th colspan="2"><i><?php if(isset($_REQUEST['m'])){ echo base64_decode(trim($_REQUEST['m'])); } ?></i></th>
	<tr>
    	<td>Old Password: </td><td><input type="password" name="oldpwd" id="oldpwd" required maxlength="20" /></td>
    <tr>
    	<td>New Password: </td><td><input type="password" name="newpwd" id="newpwd" required maxlength="20" /></td>
    <tr>
    	<td>Retype New Password: </td><td><input type="password" name="newpwd2" id="newpwd2" required maxlength="20" /></td>
    <tr>
    	<td colspan="2" align="center"><input type="submit" name="chng" value="Save Changes" /></td>
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
