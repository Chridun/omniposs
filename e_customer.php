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

if(isset($_POST['customer']))
{
    $customerid = trim(strip_tags(stripslashes($_POST['customerid'])));
    $customerfirstname = trim(strip_tags(stripslashes($_POST['customerfirstname'])));
    $customerlastname = trim(strip_tags(stripslashes($_POST['customerlastname'])));
    $customerfone = trim(strip_tags(stripslashes($_POST['customerfone'])));
    $customeremail = trim(strip_tags(stripslashes($_POST['customeremail'])));
    $customertown = trim(strip_tags(stripslashes($_POST['customertown'])));
    $customerbalance = trim(strip_tags(stripslashes($_POST['customerbalance'])));
    
    mysql_query("update customers set fname='".$customerfirstname."', lname='".$customerlastname."', fone='".$customerfone."', email='".$customeremail."', town='".$customertown."', bal=".$customerbalance." where cust_id='".$customerid."'") or die(mysql_error());
    
    header("Location: customers.php");
}
else if(isset($_REQUEST['c']))
{
	$rst = mysql_query("select * from customers where cust_id='".trim(stripslashes(strip_tags(base64_decode($_REQUEST['c']))))."'") or die(mysql_error());
        
        while($row = mysql_fetch_array($rst))
        {
            $customerid = trim($row['cust_id']);
            $customerfname = trim($row['fname']);
            $customerlname = trim($row['lname']);
            $customerfone = trim($row['fone']);
            $customeremail = trim($row['email']);
            $customertown = trim($row['town']);
            $customerbalance = trim($row['bal']);
                    
        }
	
	//header("Location: vendors.php");
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
            
            <marquee onmouseover='this.stop();' onmouseout='this.start();'direction='left' scrollamount='1' scrolldelay='30' style="color:red">
                <?php include_once("notifications.php"); ?>
            </marquee>
        
        <h2 align="center">EDIT CUSTOMER (<?php echo $customerfname." ".$customerlname ?>) DETAILS</h2>

        <form method="post">
<table width="40%" align="center">
    <tr>
        <td>Customer Code:</td><td><?php echo $customerid;?> <input type="hidden" name="customerid" value="<?php echo $customerid;?>" /></td>
    </tr>
    
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>
    
    <tr>
        <td>Firstname:</td><td><input name="customerfirstname" value="<?php echo $customerfname;?>" /></td>
    </tr>
    
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>
    
    <tr>
        <td>Lastname:</td><td><input name="customerlastname" value="<?php echo $customerlname;?>" /></td>
    </tr>
    
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>
    
    <tr>
        <td>Telephone: </td><td><input name="customerfone" value="<?php echo $customerfone;?>" /></td>
    </tr>
    
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>
    
    <tr>
        <td>Email Address: </td><td><input name="customeremail" value="<?php echo $customeremail;?>" /></td>
    </tr>
    
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>
    
    <tr>
        <td>Town: </td><td><input name="customertown" value="<?php echo $customertown;?>" /></td>
    </tr>
    
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>
    
    <tr>
        <td>Balance: </td><td><input name="customerbalance" value="<?php echo $customerbalance;?>" <?php if($_SESSION['role'] != "sadmin"){echo "readonly";} ?> /></td>
    </tr>
    
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>
    
    <tr>
        <td colspan="2" align="center"><input type="submit" value="Save Changes" name="customer" /></td>
    </tr>
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
