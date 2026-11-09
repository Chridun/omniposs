<?php
session_start();

if(isset($_SESSION['role']))
{
	if(strlen($_SESSION['role']) < 1)
	{
		header("Location: index.php?m=".base64_encode("Session expired, please login."));
		exit;
	}
}
else
{
	header("Location: index.php?m=".base64_encode("Session expired, please login."));
	exit;
}

//include('head.php');



include("incs/dbcon.inc");

if(isset($_POST['create']))
{
	$cname = strip_tags(addslashes($_POST['cname']));
	$descr = strip_tags(addslashes($_POST['descr']));
	$categoryid = strip_tags(addslashes($_POST['categoryid']));
	
	mysql_query("update categories set cat_name='".$cname."', cat_desc='".$descr."' where cat_id=".$categoryid) or die(mysql_error());
	
	header("Location: categories.php");
}
else if(isset($_REQUEST['c']))
{
	$rst = mysql_query("select * from categories where cat_id=".base64_decode($_REQUEST['c'])) or die(mysql_error());
	
	$row = mysql_fetch_array($rst);
	
	$cname = strip_tags(stripslashes($row['cat_name']));
	$descr = strip_tags(stripslashes($row['cat_desc']));
	$categoryid = $row['cat_id'];
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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



	<fieldset>
	<h2>EDIT CATEGORY DETAILS</h2>
    <form method="post" onsubmit="return chk()" name="f1">
    <input type="hidden" name="categoryid" value="<?php echo $categoryid; ?>" />
<table align="center">
<tr>
	<td>Category: </td>
	<td><input name="cname" id="cname" maxlength="100" value="<?php echo $cname; ?>"/></td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Description: </td>
	<td><textarea name="descr" id="descr"><?php echo $descr; ?></textarea></td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td colspan="2" align="center"><input type="submit" name="create" value="Save Changes" />
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
