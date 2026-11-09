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

if(isset($_REQUEST['c']))
{
	include("incs/dbcon.inc");
	mysql_query("update items set dstatus='0' where icode='".trim(stripslashes(strip_tags(base64_decode($_REQUEST['c']))))."'") or die(mysql_error());
}


include("incs/dbcon.inc");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OmniPOSS ::</title>


        
        
        <link rel="stylesheet" href="css/jquery-ui.css" />
<script type="text/javascript" src="jquery.js"></script>
        
        <script language="javascript" type="text/javascript">
            function ask(cname)
            {
                    if(!(confirm("Are you sure you want to delete "+cname+"?")))
                    {
                            return false
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
        
            <p align="center"><a href="nitem.php"><img src="images/add.gif" border="0" title="Add Item" /></a> &nbsp;&nbsp;&nbsp;&nbsp; <a href="uitems2.php"><img src="images/update_items.png" width="24px" height="24px" border="0" title="Update Inventory" /></a></p>

<h2 align="center">ITEMS</h2>

<form method="post">
    <fieldset>
        <legend>Search Items</legend>
        <div class="ui-widget">
            <input name="itemname" id="itemname" placeholder='Item Name' size="50%"> <button name="srch" type="submit">Search</button>
        </div>
    </fieldset>

<table align="center" width="100%">

    <?php
    if($_SESSION['role'] == "sadmin" || $_SESSION['role'] == "admin")
    {
        echo '<th bgcolor="#716657"><font color="#FFFFFF">SNo.</font></th><th bgcolor="#716657"><font color="#FFFFFF">ITEM CODE</font></th><th bgcolor="#716657"><font color="#FFFFFF">ITEM NAME</font></th><th bgcolor="#716657"><font color="#FFFFFF">EXPIRY DATE</font></th><th bgcolor="#716657"><font color="#FFFFFF">QUANTITY</font></th><th bgcolor="#716657"><font color="#FFFFFF">COST PRICE</font></th><th bgcolor="#716657"><font color="#FFFFFF">RETAIL PRICE</font></th><th bgcolor="#716657"><font color="#FFFFFF">WHOLESALE<br>PRICE</font></th><th></th>';
    }
    else
    {
        echo '<th bgcolor="#716657"><font color="#FFFFFF">SNo.</font></th><th bgcolor="#716657"><font color="#FFFFFF">ITEM CODE</font></th><th bgcolor="#716657"><font color="#FFFFFF">ITEM NAME</font></th><th bgcolor="#716657"><font color="#FFFFFF">ITEM DESCRIPTION</font></th><th bgcolor="#716657"><font color="#FFFFFF">EXPIRY DATE</font></th><th bgcolor="#716657"><font color="#FFFFFF">QUANTITY</font></th><th bgcolor="#716657"><font color="#FFFFFF">RETAIL PRICE</font></th><th bgcolor="#716657"><font color="#FFFFFF">WHOLESALE <BR> PRICE</font></th><th></th>';
    }
    
    $qry = "select *, date_format( expdte , '%d-%m-%Y') as 'expdte' from items where dstatus='1' order by cat_id";

if(isset($_POST['srch']))
{
    if(strlen(stripslashes(strip_tags(trim($_POST['itemname'])))) > 0)
    {
        //bring out only searched item
        $qry = "select *, date_format( expdte , '%d-%m-%Y') as 'expdte' from items where dstatus='1' and iname='".stripslashes(strip_tags(trim($_POST['itemname'])))."' order by cat_id";
    }
    //else
    //{
        //bring out all items
        //$qry = "select *, date_format( expdte , '%d-%m-%Y') as 'expdte' from items where dstatus='1' order by cat_id";
    //}
}

$rst = mysql_query($qry) or die(mysql_error());

$cnt=0;

while($row=mysql_fetch_array($rst))
{
	$cnt++;
	
        if($_SESSION['role'] == "sadmin" || $_SESSION['role'] == "admin")
        {
            echo "<tr><td align='center'>$cnt.</td><td>".trim($row['icode'])."</td><td>".trim($row['iname'])."</td><td>".trim($row['expdte'])."</td><td align='center'>".number_format(trim($row['qty']),0,'.',',')."</td><td align='center'>".number_format(trim($row['cprice']),2,'.',',')."</td><td align='center'>".number_format(trim($row['rprice']),2,'.',',')."</td><td align='center'>".number_format(trim($row['wprice']),2,'.',',')."</td><td><a href='".trim($row['img'])."' rel='lightbox[baby2]' title='".trim($row['idesc'])."'><img src='images/view.png' border=0 title='View Item Image' /></a> &nbsp; <a href='uitems.php?i=".trim($row['icode'])."'><img src='images/update.png' border=0 title='Update Item Stock' /></a> &nbsp; <a href='eitem.php?c=".base64_encode(trim($row['icode']))."'><img src='images/edit.png' title='Edit Item' border=0 /></a> &nbsp; <a href='items.php?c=".base64_encode(trim($row['icode']))."' onclick='return ask(\"".trim(stripslashes($row['iname']))."\")'><img src='images/del.png' alt='Delete Item' border=0 /></a></td><td>";
            echo "<tr><td colspan='11'><hr /></td>";
        }
        else
        {
            echo "<tr><td align='center'>$cnt.</td><td>".trim($row['icode'])."</td><td>".trim($row['iname'])."</td><td>".nl2br(trim($row['idesc']))."</td><td>".trim($row['expdte'])."</td><td align='center'>".number_format(trim($row['qty']),0,'.',',')."</td><td align='center'>".number_format(trim($row['rprice']),2,'.',',')."</td><td align='center'>".number_format(trim($row['wprice']),2,'.',',')."</td><td><a href='".trim($row['img'])."' rel='lightbox[baby2]' title='".trim($row['idesc'])."'><img src='images/view.png' border=0 title='View Item Image' /></a> &nbsp; <a href='uitems.php?i=".trim($row['icode'])."'><img src='images/update.png' border=0 title='Update Item Stock' /></a></td><td>";
            echo "<tr><td colspan='10'><hr /></td>";
        }
        
}

function getCat($c)
{
	$rs = mysql_query("select cat_name from categories where cat_id='$c'") or die(mysql_error());
	
	$rw = mysql_fetch_array($rs);
	return trim($rw['cat_name']);
}
?>

</table>
</form>
        
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
    
    <script src="js/jquery-ui.min.js"></script>
    <script type="text/javascript">
    $(function() {
            var availableTags = [

                
                
                <?php
                
                include("incs/dbcon.inc");
                
                $rs = mysql_query("select iname from items") or die(mysql_error());
                while($r = mysql_fetch_array($rs))
                {
                    echo '"'.trim($r['iname']).'",';
                    
                }
                echo '"."';
                ?>

                
            ];
            $("#itemname").autocomplete({
                source: availableTags
            });

        });
    </script>
</body>
</html>
