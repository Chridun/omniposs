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

global $c_total;
global $r_total;
global $w_total;

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
<h2 align="center">CURRENT STOCK VALUATION</h2>

	
	

<fieldset>
<legend>ITEMS</legend>
<table align="center" width="100%">
	<th></th>
    <th bgcolor="#000000"><font color="#FFFFFF">ITEM CODE</font></th>
    <th bgcolor="#000000"><font color="#FFFFFF">ITEM NAME</font></th>
	<th bgcolor="#000000"><font color="#FFFFFF">QTY</font></th>
	<th bgcolor="#000000"><font color="#FFFFFF">COST</font></th>
    <!-- <th bgcolor="#000000"><font color="#FFFFFF">FRANCHISE</font></th>
    <th bgcolor="#000000"><font color="#FFFFFF">SUPER <br />DISTRIBUTOR</font></th>
    <th bgcolor="#000000"><font color="#FFFFFF">DISTRIBUTOR</font></th> -->
  	<th bgcolor="#000000"><font color="#FFFFFF">RETAIL</font></th>
    <th bgcolor="#000000"><font color="#FFFFFF">WHOLE SALE</font></th>
	
    <?php 
	
    $c_total = 0;
    $r_total = 0;
    $w_total = 0;

	$rst = mysql_query("select cat_id, cat_name from categories order by cat_name") or die(mysql_error());
	$cnt = 0;
	
	while($row = mysql_fetch_assoc($rst))
	{
		echo "<tr><td colspan=9><br></td><tr bgcolor='#cccccc'><td colspan=9 align='center'><b><u>".strtoupper(trim($row['cat_name']))."</u></b></td>";
		
		echo getItems($row['cat_id'], $cnt, $row['cat_name']);
	}
	
	function getItems($cid, $cnt, $cat)
	{
		$rst2 = mysql_query("select * from items where cat_id=$cid order by iname") or die(mysql_error());
		$items = "";
		$c = 0;
		//$f = 0;
		//$s = 0;
		//$d = 0;
		$r = 0;
    $w = 0;
                
                global $c_total;
                global $r_total;
                global $w_total;


                while($row2 = mysql_fetch_assoc($rst2))
		{
			$cnt++;
			if($cat == "Services")
                        {
                            $items.= "<tr bgcolor='#cccccc'><td>$cnt.</td><td>".trim($row2['icode'])."</td><td>".trim(stripslashes($row2['iname']))."</td><td align='center'>".number_format($row2['qty'])."</td><td>0</td><td>0</td>";
                        }
                        else
                        {
                            $c += ($row2['cprice'] * $row2['qty']);
                            $r += ($row2['rprice'] * $row2['qty']);
                            $w += ($row2['wprice'] * $row2['qty']);
			
			
                            
                
                            $items.= "<tr bgcolor='#cccccc'><td>$cnt.</td><td>".trim($row2['icode'])."</td><td>".trim(stripslashes($row2['iname']))."</td><td align='center'>".number_format($row2['qty'])."</td><td>(<strike>N</strike>".number_format($row2['cprice']).") ". number_format($row2['cprice'] * $row2['qty'])."</td><td>(<strike>N</strike>".number_format($row2['rprice']).") ".number_format($row2['rprice'] * $row2['qty'])."</td><td>(<strike>N</strike>".number_format($row2['wprice']).") ".number_format($row2['wprice'] * $row2['qty'])."</td>";
                        
                        }
		}
		
		$items.="<tr><td colspan='4' align='center'><b>CATEGORY TOTAL: </b></td><td><b><strike>N</strike>".number_format($c)."</b></td><td><b><strike>N</strike>".number_format($r)."</b></td><td><b><strike>N</strike>".number_format($w)."</b></td><tr><td colspan='9'><hr></td>";
		$c_total += $c;
                $r_total += $r;
                $w_total += $w;
                
                return $items;
	}
	
	//$rst = mysql_query("select qty, cprice, rprice from items") or die(mysql_error());
	
	//while($row = mysql_fetch_assoc($rst))
	//{
	//	$c_total += ($row['cprice'] * $row['qty']);
		//$f_total += ($row['fprice'] * $row['qty']);
		//$s_total += ($row['sprice'] * $row['qty']);
		//$d_total += ($row['dprice'] * $row['qty']);
                //echo $row['rprice']." : ".$row['qty'];
                //echo "<br>";
	//	$r_total += ($row['rprice'] * $row['qty']);
                //echo "<br>";
	//}
	
	
		echo "<tr><td colspan='4' align='center'><h3>STOCK VALUATION: </h3></td><td><h3><strike>N</strike>".number_format($c_total)."</h3></td><td><h3><strike>N</strike>".number_format($r_total)."</h3></td><td><h3><strike>N</strike>".number_format($w_total)."</h3></td>";
	
	
	
	 ?>
</table>
</fieldset>


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
