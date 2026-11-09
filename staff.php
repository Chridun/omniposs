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

if(isset($_REQUEST['del']))
{
	mysql_query("update logs set status='0' where uname='".base64_decode($_REQUEST['del'])."'") or die(mysql_error());
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OmniPOSS ::</title>
<script language="javascript">
function delUser(uname)
{
	if(confirm("Are you sure you want to delete "+uname+"?"))
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
            <marquee onmouseover='this.stop();' onmouseout='this.start();'direction='left' scrollamount='1' scrolldelay='30' style="color:red">
                <?php include_once("notifications.php"); ?>
            </marquee>
        
        <fieldset>

<p align="center"><a href="nstaff.php"><img src="images/add.gif" border="0" title="Add Staff" /></a></p>
<h2 align="center">S T A F F </h2>
<table align="center" width="500">
<th bgcolor="#716657"><font color="#FFFFFF">SNo.</font></th><th bgcolor="#716657"><font color="#FFFFFF">USERNAME</font></th><th bgcolor="#716657"><font color="#FFFFFF">FULLNAME</font></th><th bgcolor="#716657"><font color="#FFFFFF">ROLE</font></th>
<?php

$qry = "select uname, fname, role from logs where uname != 'Jimohesq' and status='1'";
$rst = mysql_query($qry) or die(mysql_error());
//$details = "";
$cnt = 0;
while($row = mysql_fetch_assoc($rst))
{
	$cnt++;
	echo "<tr bgcolor='#cccccc'><td align='center'>$cnt.</td><td>".trim($row['uname'])."</td><td> ".trim($row['fname'])."</td><td>".trim($row['role'])."</td><td align='center'><a href='estaff.php?i=".base64_encode(trim($row['uname']))."'><img src='images/edit.png' title='Edit User Details' border=0 /></a> &nbsp; <a href='staff.php?del=".base64_encode(trim($row['uname']))."' onclick='return delUser(\"".trim($row['uname'])."\")'><img src='images/del.png' border=0 title='Delete Staff'/></a></td>";
	echo "<tr><td colspan='5'><hr></td>";
}

?>
</table>
</fieldset>
        
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
