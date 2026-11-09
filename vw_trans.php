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
        
        <h2 align="center">TRANSACTION BREAKDOWN</h2>
<h2 align="center"> DETAILS FOR <?php 

switch(trim(stripslashes(strip_tags($_REQUEST['s']))))
{
	case "S":
	echo "SALES ";
	break;
	
	case "R":
	echo "RETURN";
	break;
    
        case "C":
            echo "ITEM RECALL";
            break;
        
        case "B":
            echo "BALANCE PAYMENT";
            break;
}



?> TRANSACTION <?php echo trim(stripslashes(strip_tags($_REQUEST['i']))) ?></h2>

<table align="center" width="90%">
<th bgcolor="#000000"><font color="#FFFFFF">SNo.</font></th><th bgcolor="#000000"><font color="#FFFFFF">ITEM QUANTITY</font></th><th bgcolor="#000000"><font color="#FFFFFF">ITEM DESCRIPTION</font></th><th bgcolor="#000000"><font color="#FFFFFF"> AMOUNT (<strike>N</strike>)</font></th><th bgcolor="#000000"><font color="#FFFFFF">TRANSACTION DATE</font></th>

<?php


$ttl = 0;

$rst = mysql_query("select *, date_format( dte , '%W %D %M, %Y - %h:%i %p') as 'tdte' from trans_b where tran_id='".trim(stripslashes(strip_tags($_REQUEST['i'])))."' order by dte desc") or die(mysql_error());

$cnt=0;

while($row=mysql_fetch_array($rst))
{
	$cnt++;
	echo "<tr><td align='center'>$cnt.</td><td align='center'>".trim($row['iqty'])."</td><td>".trim($row['idesc'])."</td><td align='right'>".number_format(trim($row['amt']),2,'.',',')."</td><td align='center'>".trim($row['tdte'])."</td>";
	echo "<tr><td colspan='5'><hr /></td>";
	$ttl = $ttl + $row['amt'];
}


echo "<tr><td></td><td></td><td align='right'><font size='+2'> TOTAL: </td></td><td align='right'><font size='+2'> <b><strike>N</strike>".number_format($ttl,2,'.',',')."</b></font></td><td></td>";

function getTyp($t)
{
	switch($t)
	{
		case "S":
		return "Sold";
		break;
		
		case "R":
		return "Returned";
		break;
            
                case "C":
                    return "Recall";
                    break;
                
                case "B":
                    return "Balance";
                    break;
		
		default:
		return "";	
	}
}

?>

</table>
        
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
