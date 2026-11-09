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

if(isset($_POST['exp']))
{
    
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



    for($i=1; $i <= trim(strip_tags(stripslashes($_POST['exp_count']))); ++$i)
    {
        if(strlen(trim(strip_tags(stripslashes($_POST['des_'.$i])))) > 0)
        {
            //enter into the dbase...
            mysql_query("insert into expenses(eid, desr, amt, staff, dte) values('".$transactionid."','".trim(strip_tags(stripslashes($_POST['des_'.$i])))."',".trim(strip_tags(stripslashes($_POST['amount_'.$i]))).",'".$_SESSION['fname']."',now())") or die(mysql_error());
        }
    }
    
    header("Location: expenses.php");
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

<script type="text/javascript" src="jquery.js"></script>

</head>

    <body onload="document.getElementById('des_1').focus()" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
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
        
        

<h2 align="center">EXPENSES <!-- <a href='rpt_xls.php?typ=tr&q=<?php echo base64_encode($qry); ?>&q2=<?php echo base64_encode($qry2); ?>&t=<?php echo $ttle; ?>' target='blank'><img src='images/excel.png' border=0 /></a> --></h2>




            <form method="post">
                <table align="center" width="30%" id="items">
                    <th></th><th>EXPENSE DESCRIPTION</th><th>EXPENSE AMOUNT</th>
                    <tr><td colspan="3"><hr><input type="hidden" name="exp_count" id="exp_count" value="1"></td></tr>
                    <tr>
                        <td>1.</td><td><textarea id="des_1" name="des_1"></textarea></td><td><input name="amount_1" size='5'></td>
                        <tr><td colspan='3'><hr></td>
</table>
                <p align="center"><a href="#" id="add" title='Add Expense'><img src='images/add.gif' border='0'></a>
                    <br><br>
                            <input type='submit' value="Save Expenses" name="exp">
                </p>
            </form>
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
    <script src="js/jquery-ui.min.js"></script>
    <script type="text/javascript">
        var cnt=1;
        //alert("This");
    $(document).ready(function()
    {    
        $('#add').click(function()
        {
          cnt++;
          //alert(cnt);
          
          //var data = "<tr id='"+cnt+"'><td>This is ".cnt."</td><td>"+cnt+" again</td>";
            $('#items').append("<tr><td>"+cnt+".</td><td><textarea id='des_"+cnt+"' name='des_"+cnt+"'></textarea></td><td><input name='amount_"+cnt+"' size='5'></td>");
            $('#items').append("<tr><td colspan='3'><hr></td>");
            document.getElementById('des_'+cnt).focus();
            document.getElementById('exp_count').value = cnt;
            
            
      //document.getElementById('itemcode').focus(); 

                 });
                 
                 });
		  
		
        </script>
</body>
</html>
