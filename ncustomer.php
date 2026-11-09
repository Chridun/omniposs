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

if(isset($_POST['customerfname']))
{
	$customerfname = trim(stripslashes(strip_tags($_POST['customerfname'])));
	$customerlname = trim(stripslashes(strip_tags($_POST['customerlname'])));
	$customerphone = trim(addslashes(strip_tags($_POST['customerphone'])));
	$emailaddress = trim(stripslashes(strip_tags($_POST['emailaddress'])));
	$town = trim(stripslashes(strip_tags($_POST['town'])));
	$balance = trim(stripslashes(strip_tags($_POST['balance'])));
        
        $transactionid = null;

        //generate password...
        $allowed_chars = '12345678901234567890';
        $allowed_count = strlen($allowed_chars);
        //$password = null;
        $password_length = 5;

        while($transactionid === null) {
            $password = '';
            for($i = 0; $i < $password_length; ++$i) {
                $transactionid .= $allowed_chars{mt_rand(0, $allowed_count - 1)};
            }
                $transactionid .= mktime();
        }
        
	
	
	mysql_query("insert into customers values('".$transactionid."','".$customerfname."','".$customerlname."','','','".$customerphone."','".$emailaddress."','',now(),'".$town."',".$balance.",'1')");
	
	
	
	header("Location: customers.php");
}

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
        
        <h2 align="center">NEW CUSTOMER</h2>
<form method="post" enctype="multipart/form-data" name="f1">
<table align="center">
	<tr>
                        	<td>Customer Firstname: </td>
                            <td><input name="customerfname" id="customerfname" maxlength="30" /></td>
                        <tr>
                        	<td>Customer Lastname: </td>
                            <td><input name="customerlname" id="customerlname" maxlength="30" /></td>
                        <tr>
                        	<td>Customer Telephone: </td>
                            <td><input name="customerphone" id="customerphone" maxlength="50" /></td>
                        <tr>
                        	<td>Customer Email Address: </td>
                            <td><input name="emailaddress" id="emailaddress" maxlength="100" /></td>
                        <tr>
                        	<td>Customer Town/District: </td>
                            <td><input name="town" id="town" maxlength="100" /></td>
                            <tr>
                                <td>Balance: </td>
                                <td>
                                    <input name='balance' id='balance' value="0">
                                </td>
                            </tr>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td colspan="2" align="center"><input type="button" value="Add Customer" name="ai" onclick="document.f1.submit()" /></td>
    
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
