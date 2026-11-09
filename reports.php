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
            
            <marquee onmouseover='this.stop();' onmouseout='this.start();'direction='left' scrollamount='1' scrolldelay='30' style="color:red">
                <?php include_once("notifications.php"); ?>
            </marquee>
        
        <br /><Br />
<h2 align="center">R E P O R T S</h2>
<table width="30%" align="center">
    
    <?php 
    switch($_SESSION['role'])
    {
        case "sadmin":
        echo '
        <tr>
                <td><a href="eod.php">END OF DAY</a></td><td align="right"><a href="items_rpt.php">ITEMS</a></td>	
        <tr>
                <td colspan="2"><br /><br /><br /></td>
        <tr>
         <td><a href="transactions.php">TRANSACTIONS</a></td><td  align="right"><a href="analysis.php">COST ANALYSIS</a></td>
        <tr>
                <td colspan="2"><br /><br /><br /></td>
        <tr>
            <td><a href="notifications2.php">NOTIFICATIONS</a></td><td  align="right"><a href="stock_in.php">STOCK IN</a></td>
            <tr>
                <td colspan="2"><br /><br /><br /></td>
                <tr>
                <td><a href="d_list.php">DEBTOR LIST</a></td><td align="right"><a href="expenses.php">EXPENSES</a></td>
            <tr>
                <td colspan="2"><br /><br /><br /></td>
                <tr>
                <td><a href="stock.php">STOCK VALUATION</a></td><td align="right"><a href="recall.php">RECALL ITEM</a></td>';
            
            
break;
        
        case "admin";
            echo '
        <tr>
                <td><a href="eod.php">END OF DAY</a></td><td align="right"><a href="items_rpt.php">ITEMS</a></td>	
        <tr>
                <td colspan="2"><br /><br /><br /></td>
        <tr>
         <td><a href="transactions.php">TRANSACTIONS</a></td><td  align="right"><a href="analysis.php">COST ANALYSIS</a></td>
        <tr>
                <td colspan="2"><br /><br /><br /></td>
        <tr>
            <td><a href="notifications2.php">NOTIFICATIONS</a></td><td  align="right"><a href="stockin.php">STOCK IN</a></td>
            <tr>
                <td colspan="2"><br /><br /><br /></td>
                <tr>
                <td><a href="d_list.php">DEBTOR LIST</a></td><td><a href="expenses.php">EXPENSES</a></td>
                
<tr>
                <td colspan="2"><br /><br /><br /></td>
                <tr>
                <td><a href="stock.php">STOCK VALUATION</a></td><td align="right"></td>';
        
            break;
        
        case "accountant":
            echo '
        <tr>
                <td><a href="eod.php">END OF DAY</a></td><td align="right"><a href="items_rpt.php">ITEMS</a></td>	
        <tr>
                <td colspan="2"><br /><br /><br /></td>
        <tr>
         <td><a href="transactions.php">TRANSACTIONS</a></td><td  align="right"><a href="analysis.php">COST ANALYSIS</a></td>
        <tr>
                <td colspan="2"><br /><br /><br /></td>
                
<tr>
                <td><a href="d_list.php">DEBTOR LIST</a></td><td><a href="expenses.php">EXPENSES</a></td>
<tr>
                <td colspan="2"><br /><br /><br /></td>
                <tr>
                <td><a href="stock.php">STOCK VALUATION</a></td><td align="right"></td>        ';
        
            break;
        
        case "user":
            echo '
        <tr>
                <td><a href="eod.php">END OF DAY</a></td><td align="right"><a href="d_list.php">DEBTOR LIST</a></td>	
        <tr>
                <td colspan="2"><br /><br /><br /></td>
        <tr>
         <td><a href="expenses.php">EXPENSES</a></td><td  align="right"></td>
        <tr>
                <td colspan="2"><br /><br /><br /></td>
        <tr>
            <td></td><td  align="right"></td>';
        
            break;
    }
?>
</table>

<!--
<table width="70%" align="center">
<tr>
	<td><a href="eod.php"><img src="images/eod_but.jpg" border="0" /></a></td><td align="center"><a href="vreport.php"><img src="images/vendors_but.jpg" border="0" /></a></td><td align="right"><a href="items_rpt.php"><img src="images/items_but.jpg" border="0" /></a></td>	
<tr>
	<td><a href="shelf_rpt.php"><img src="images/shelfspaces.jpg" border="0" /></a></td><td align="center"><a href="inventory.php"><img src="images/inventory_but.jpg" border="0" /></a></td><td align="right"><a href="giftcert_rpt.php"><img src="images/giftcerts_but.jpg" border="0" /></a></td>

<tr>
	<td><a href="comm_rpt.php"><img src="images/commissions_but.jpg" border="0" /></a></td><td align="center"><a href="transactions.php"><img src="images/trans_but.jpg" border="0" /></a></td><td align="right"></td>
</table>
-->
        
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
