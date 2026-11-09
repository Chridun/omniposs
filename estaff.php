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
	$firstname = trim(strip_tags(stripslashes($_POST['firstname'])));
	$lastname = trim(strip_tags(stripslashes($_POST['lastname'])));
	$username = trim(strip_tags(stripslashes($_POST['username'])));
	$s = stripslashes($_POST['s']);
	//$password = md5(stripslashes(strip_tags($_POST['password'])));
	$role = $_POST['role'];
	$dateofbirth = addslashes(strip_tags(trim($_POST['yy'])))."-".addslashes(strip_tags(trim($_POST['mm'])))."-".addslashes(strip_tags(trim($_POST['dd'])));
	$phonenumber = addslashes(strip_tags(trim($_POST['phonenumber'])));
	$residentialaddress = addslashes(strip_tags(trim($_POST['residentialaddress'])));
	$emailaddress = addslashes(strip_tags(trim($_POST['emailaddress'])));
	$stateoforigin = addslashes(strip_tags(trim($_POST['stateoforigin'])));
	$qualification = addslashes(strip_tags(trim($_POST['qualification'])));
	$guarantordetails = addslashes(strip_tags(trim($_POST['guarantordetails'])));

	mysql_query("update logs set fname='".$firstname." ".$lastname."', role='".$role."' where uname='".$username."'") or die(mysql_error());
	
	mysql_query("update users set fname='$firstname', lname='$lastname', sex='$s', dob='$dateofbirth', quali='$qualification', fone='$phonenumber', state='$stateoforigin', addy='$residentialaddress', email='$emailaddress', guarantor='$guarantordetails' where uname='$username'") or die(mysql_error());

	header("Location: staff.php");
}
else if(isset($_REQUEST['i']))
{
	$i = trim(stripslashes(strip_tags(base64_decode($_REQUEST['i']))));
	
	$rst = mysql_query("select * from users where uname='$i'") or die(mysql_error());
	
	$row = mysql_fetch_array($rst);
	
	$firstname = trim(strip_tags(stripslashes($row['fname'])));
	$lastname = trim(strip_tags(stripslashes($row['lname'])));
	$s = stripslashes($row['sex']);
	$username = trim(strip_tags(stripslashes($row['uname'])));
	$dateofbirth = trim(stripslashes(strip_tags($row['dob'])));
	$yy = substr($dateofbirth,0,4);
	$mm = substr($dateofbirth,5,2);
	$dd = substr($dateofbirth,8,2);
	$phonenumber = addslashes(strip_tags(trim($row['fone'])));
	$residentialaddress = addslashes(strip_tags(trim($row['addy'])));
	$emailaddress = addslashes(strip_tags(trim($row['email'])));
	$stateoforigin = addslashes(strip_tags(trim($row['state'])));
	$qualification = addslashes(strip_tags(trim($row['quali'])));
	$guarantordetails = addslashes(strip_tags(trim($row['guarantor'])));
	
	$rst = mysql_query("select role from logs where uname='$i'") or die(mysql_error());
	$row = mysql_fetch_array($rst);
	$role = $row['role'];
	
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OmniPOSS ::</title>

<script language="javascript">

function chk()
{
	if(document.f1.fname.value.length < 3)
	{
		alert("Fullname required.");
		document.f1.fname.focus();
		return false;
	}
	else if(document.f1.uname.value.length < 3)
	{
		alert("Username required.");
		document.f1.uname.focus();
		return false;
	}
	else if(document.f1.pwd.value.length < 2)
	{
		alert("Password required.");
		document.f1.pwd.focus();
		return false;
	}
	else if(document.f1.pwd.value != document.f1.pwd2.value)
	{
		alert("Passwords dont match, please retype.");
		document.f1.pwd2.focus();
		return false;
	}
}

function putDem()
	{
		tr = "<?php echo $role; ?>";
		for( var i=0, limit=document.getElementById('role').options.length; i < limit; ++i )
		{
			if( document.getElementById('role').options[i].value==tr )
				document.getElementById('role').options[i].selected=true;
		}
		
		tr = "<?php echo $yy; ?>";
		for( var i=0, limit=document.getElementById('yy').options.length; i < limit; ++i )
		{
			if( document.getElementById('yy').options[i].value==tr )
				document.getElementById('yy').options[i].selected=true;
		}
		
		tr = "<?php echo $mm; ?>";
		for( var i=0, limit=document.getElementById('mm').options.length; i < limit; ++i )
		{
			if( document.getElementById('mm').options[i].value==tr )
				document.getElementById('mm').options[i].selected=true;
		}
		
		tr = "<?php echo $dd; ?>";
		for( var i=0, limit=document.getElementById('dd').options.length; i < limit; ++i )
		{
			if( document.getElementById('dd').options[i].value==tr )
				document.getElementById('dd').options[i].selected=true;
		}
		
		document.getElementById('<?php echo $s; ?>').checked=true;
	}

</script>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px" onload="putDem()">
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
	<legend>New Staff</legend>
    <form method="post" onsubmit="return chk()" name="f1">
<table align="center"><caption><font color="red"><?php //echo $msg; ?></font></caption>
<tr>
	<td>Firstname: </td>
	<td><input name="firstname" id="firstname" maxlength="30" required value="<?php echo $firstname; ?>" /></td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Lastname: </td>
	<td><input name="lastname" id="lastname" maxlength="30" required value="<?php echo $lastname; ?>" /></td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Sex: </td><td><input type="radio" name="s" value="M" checked="checked" id="M" />Male <input type="radio" name="s" value="F" id="F" />Female</td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Date of Birth:</td>
    <td>
    	<select name="dd" id="dd">
    <option value="00">Day</option>
    	<?php
			for($i=1; $i <= 31; $i++)
			{
				if($i < 10)
				{
					echo "<option value=0".$i.">0".$i;
				}
				else
				{
					echo "<option value=".$i.">".$i;
				}
			}
		?>
    </select>
    
    <select name="mm" id="mm">
    <option value="">Month</option>
    <option value="01">January
    <option value="02">February
    <option value="03">March
    <option value="04">April
    <option value="05">May
    <option value="06">June
    <option value="07">July
    <option value="08">August
    <option value="09">September
    <option value="10">October
    <option value="11">November
    <option value="12">December
    </select>
    
    <select name="yy" id="yy">
    <option value="">Year</option>
    <?php
		for($i=(date("Y")-80); $i <= (date("Y")-10); $i++)
		{
			echo "<option value=".$i.">".$i;
		}
	?>
    </select>
    </td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Phone Number(s): </td><td><input name="phonenumber" maxlength="50" value="<?php echo $phonenumber; ?>" /></td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Residential Address: </td><td><textarea name="residentialaddress"><?php echo $residentialaddress; ?></textarea></td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Email Address: </td><td><input name="emailaddress" maxlength="100" value="<?php echo $emailaddress; ?>" /></td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>State of Origin: </td>
    <td>
    	<input name="stateoforigin" maxlength="20" required value="<?php echo $stateoforigin; ?>" />
    </td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Qualification: </td><td><textarea name="qualification"><?php echo $qualification; ?></textarea></td>
<!--<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Valid ID Card: </td><td></td>-->
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Guarantor Details: </td><td><textarea name="guarantordetails"><?php echo $guarantordetails; ?></textarea><td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td align="center" colspan="2"><b>** ADMINISTRATION **</b></td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Username: </td>
	<td><input name="username" id="username" maxlength="15" required readonly value="<?php echo $username; ?>" /></td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td>Role: </td><td><select name="role" id="role">
	    <option value="sadmin">Super Administrator 
	    <option value="admin">Administrator
    <option value="accountant">Accountant 
    <option value="user">User
    </select>
    </td>
<tr>
	<td colspan="2"><hr /></td>
<tr>
	<td colspan="2" align="center"><input type="submit" name="create" value="Save Changes" /></td>
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
