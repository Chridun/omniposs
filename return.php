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
<script type="text/javascript" src="jquery.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />

</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px" onload="document.getElementById('itemcode').focus();">
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
        
        <h1 align="center">R E T U R N &nbsp;&nbsp;&nbsp; I T E M S </h1>

<fieldset>
<div class="ui-widget">
        <input name="itemcode" id="itemcode" class="form-control" placeholder="Item Code" onchange="document.getElementById('qty').focus()" />
        <input name="qty" id="qty" placeholder="Qty" size="4" />
        <select name="salestype" id="salestype">
            <option value="rprice">Retail</option>
            <option value="wprice">Wholesale</option>
        </select>
        <button id="add">Get Item</button>
                                    <!-- <input id="tags" type="text" class="form-control"> -->
                                </div> <br /><br />
<form method="post" name="f1" id="f1" action="doReturn.php">
<input type="hidden" name="cnt" id="cnt" value="0" />
<table width="90%" align="left" id="items">
<th bgcolor="#716657"><font color="#FFFFFF">SNo.</font></th><th bgcolor="#716657"><font color="#FFFFFF">ITEM CODE</font></th><th bgcolor="#716657"><font color="#FFFFFF">QTY</font></th><th bgcolor="#716657"><font color="#FFFFFF">ITEM NAME</font></th><th bgcolor="#716657"><font color="#FFFFFF">RATE (<strike>N</strike>)</font></th><th bgcolor="#716657"><font color="#FFFFFF">TOTAL (<strike>N</strike>)</font></th><th></th>


</table>
</fieldset>
<table width="90%">
<!-- <tr>
	<td width="90%" align="right"><b>Discount:</b> </td><td align="right"><input name="discount" id="discount" size="6" /></td> -->
<tr>
	<td align="right"><b>Total:</b> </td><td align="right"><input type="hidden" name="gtotal" id="gtotal" value="0" /><label id="lb_total" style="font-size:24px; font-weight:bold">0</label></td>
<tr>
	<td align="right" colspan="2"><br /><br /><a href="javascript:document.f1.submit();"><img src="images/return_pay_but.jpg" title="Return Item" border="0" /></a></td>
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

function format1(n) {
    return n.toFixed(2).replace(/./g, function(c, i, a) {
        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
    });
}




function doRemove(i)
{
	//alert(i);
	document.getElementById('gtotal').value = parseInt(document.getElementById('gtotal').value) - parseInt(document.getElementById('total_'+i).value);
	  
	document.getElementById('lb_total').innerHTML = format1(parseInt(document.getElementById('gtotal').value));
	  
	  
	document.getElementById('itemcode'+i).value = "";
	document.getElementById('qty'+i).value = "";
	document.getElementById('item'+i).value = "";
	document.getElementById('rate'+i).value = "";
	document.getElementById('total_'+i).value = "";
	
	document.getElementById('lb_itemcode'+i).innerHTML = "";
	document.getElementById('lb_qty'+i).innerHTML = "";
	document.getElementById('lb_item'+i).innerHTML = "";
	document.getElementById('lb_rate'+i).innerHTML = "";
	document.getElementById('lb_total'+i).innerHTML = "";
        document.getElementById('del_but'+i).innerHTML = "";
        
        document.getElementById('tr'+i).innerHTML = "<td colspan='7' bgcolor='#ffffff'><td>";
	
}

var cnt=0;
//var ccnt=1;


     $(document).ready(function()
     {
       
	   $('#add').click(function()
       {
          //alert("i dey inside sales o");
		  var rst = getItem(document.getElementById('itemcode').value, document.getElementById('qty').value);

		  if(rst)
		  {
			cnt++;
		 	document.getElementById('cnt').value = 1 + parseInt(document.getElementById('cnt').value);
		  
		  	$.get(
                 'getItem.php',
                 { i: document.getElementById('itemcode').value+"^"+document.getElementById('qty').value+"^"+cnt+"^R^"+document.getElementById('salestype').value },
                 function(data)
                 {
                   //$('#result').html(data);
				   //alert(data);
				   if(data == "1")
				   {
				   		alert("Invalid Item Code");
				   }
				   else if(data == "2")
				   {
				   		alert("Insufficient items in stock");
				   }
				   else
				   {
				   		$('#items').append(data);
						
						document.getElementById('gtotal').value = parseInt(document.getElementById('gtotal').value) + parseInt(document.getElementById('total_'+cnt).value);
	  
					  document.getElementById('lb_total').innerHTML = format1(parseInt(document.getElementById('gtotal').value));
					  
					  document.getElementById('itemcode').value = "";
					  document.getElementById('qty').value = "";
					  document.getElementById('itemcode').focus(); 
					}
                 });
		  
		  
		 
		//alert("wahala dey o");
	  //alert(document.getElementById('total_1').id);
	  
		 
	  //finito(cnt);
	  
	  
	  }
	  
    });
	
	$('.remove').live('click', function()
    {
      $(this).parent('tr').remove();
	  //alert('remove');
    });

});

function finito(c)
{
	//alert("wahala dey o");
	  //alert(document.getElementById('total_1').id);
	  document.getElementById('gtotal').value = parseInt(document.getElementById('gtotal').value) + parseInt(document.getElementById('total_'+c).value);
	  
	  document.getElementById('lb_total').innerHTML = document.getElementById('gtotal').value;
	  
	  document.getElementById('itemcode').value = "";
	  document.getElementById('qty').value = "";
	  document.getElementById('itemcode').focus();
}

function getItem(i, q)
{
	if(i.length < 1)
	{
		alert("Invalid Item code");
		document.getElementById('itemcode').focus();
		return false;
	}
	else if(isNaN(parseInt(q)))
	{
		alert("Invalid Item quantity");
		document.getElementById('qty').focus();
		return false;
	}
	else if(parseInt(q) < 1)
	{
		alert("Invalid Item quantity");
		document.getElementById('qty').focus();
		return false;
	}
	else
	{
		return true;
	}
}

$(function() {
            var availableTags = [

                
                
                <?php
                
                include("incs/dbcon.inc");
                
                $rs = mysql_query("select icode from items") or die(mysql_error());
                while($r = mysql_fetch_array($rs))
                {
                    echo '"'.trim($r['icode']).'",';
                    
                }
                echo '"."';
                ?>

                
            ];
            $("#itemcode").autocomplete({
                source: availableTags
            });

        });
</script>


</body>
</html>
