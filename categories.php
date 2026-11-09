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
	$cname = strip_tags(addslashes($_POST['cname']));
	$descr = strip_tags(addslashes($_POST['descr']));
	
	$qry = "insert into categories(cat_name, cat_desc) values('$cname','$descr')";
	
	mysql_query($qry) or die(mysql_error());
	
	header("Location: categories.php");
}
else if(isset($_REQUEST['d']))
{
	//mysql_query("delete from item where category=".$_REQUEST['del']) or die(mysql_error());
	mysql_query("delete from categories where cat_id=".base64_decode($_REQUEST['d'])) or die(mysql_error());
	
	header("Location: categories.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OmniPOSS ::</title>

<script language="javascript">
function ask(cname)
{
	if(!(confirm("Are you sure you want to delete "+cname+"? \nDoing this would delete all items in this category.")))
	{
		return false
	}
}

function chk()
{
	if(document.f1.cname.value.length < 3)
	{
		alert("Category Name required.");
		document.f1.cname.focus();
		return false;
	}
	else if(document.f1.descr.value.length < 3)
	{
		alert("Category description required.");
		document.f1.descr.focus();
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
	<legend>New  Category </legend>
    <form method="post" onsubmit="return chk()" name="f1">
<table align="center">
<tr>
	<td>Category: </td>
	<td><input name="cname" id="cname" maxlength="100"/></td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Description: </td>
	<td><textarea name="descr" id="descr"></textarea></td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td colspan="2" align="center"><input type="submit" name="create" value="Add Category" />
</table>
</form>
</fieldset>
<br />
<br />
<fieldset>
<legend>Categories</legend>
<table align="center" width="60%"><th bgcolor="#716657"><font color="#FFFFFF">SNo.</font></th><th bgcolor="#716657"><font color="#FFFFFF">CATEGORY</font></th><th bgcolor="#716657"><font color="#FFFFFF">DESCRIPTION</font></th>
    <?php 
	
	$qry = "select * from categories order by cat_name";
$rst = mysql_query($qry) or die(mysql_error());

$cnt=0;

while($row = mysql_fetch_assoc($rst))
{
	$cnt++;
	echo "<tr bgcolor='#cccccc'><td align='center'>$cnt.</td><td>".trim(stripslashes($row['cat_name']))."</td><td> ".trim(stripslashes(nl2br($row['cat_desc'])))."</td><td><a href='categories.php?d=".base64_encode(trim($row['cat_id']))."' onclick='return ask(\"".trim(stripslashes($row['cat_name']))."\")'><img src='images/del.png' border=0 title='Delete Category'/></a> <a href='ecategory.php?c=".base64_encode($row['cat_id'])."'><img src='images/edit.png' border=0 title='Edit Category'/></a></td>";
	echo "<tr><td colspan='4'><hr></td>";
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
