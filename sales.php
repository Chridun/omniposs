<?php
session_start();

include("chkdte.php");

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

<link rel="stylesheet" href="css/jquery-ui.css" />
<script type="text/javascript" src="jquery.js"></script>

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
        
        <h1 align="center">M A K E &nbsp;&nbsp;&nbsp; A &nbsp;&nbsp;&nbsp; S A L E </h1>


    <div class="ui-widget">
        <input name="itemcode" id="itemcode" class="form-control" placeholder="Item Code" onchange="document.getElementById('qty').focus()" />
        <input name="qty" id="qty" placeholder="Qty" size="4" /> 
        <select name="salestype" id="salestype">
            <option value="rprice">Retail</option>
            <option value="wprice">Wholesale</option>
        </select>
        <button id="add">Get Item</button>
        <br><br>
                <div class="col-sm-3">
                <fieldset>
                    <legend>Search Items</legend>
                    <input name="itemname" id="itemname" placeholder='Item Name' size="50%">
                    <br><br> 
                            <input name='itemdescription' id="itemdescription" placeholder='Item Description' size="50%" /> &nbsp; <button id="srcItem">Search</button>
        
                                                                  </fieldset></div>  <!-- <input id="tags" type="text" class="form-control"> -->
                                </div>
  <br /><br />
<form method="post" name="f1" id="f1" action="doSales.php">
<input type="hidden" name="cnt" id="cnt" value="0" />
<table width="90%" align="left" id="items">
<th bgcolor="#716657"><font color="#FFFFFF">ITEM CODE</font></th><th bgcolor="#716657"><font color="#FFFFFF">QTY</font></th><th bgcolor="#716657"><font color="#FFFFFF">ITEM NAME</font></th><th bgcolor="#716657"><font color="#FFFFFF">RATE (<strike>N</strike>)</font></th><th bgcolor="#716657"><font color="#FFFFFF">TOTAL (<strike>N</strike>)</font></th><th></th>


</table>

<table width="90%">
<tr>
    <td width="90%" align="right"><!-- <b>Discount:</b> --> </td><td align="right"><input type="hidden" name="discount" id="discount" size="6" value="0" onblur="doDiscount(this.value);" /></td>
<tr>
	<td align="right"><b>Total:</b> </td>
    <td align="right">
    	<table id="gifttable">
        </table>
    	<input type="hidden" name="gtotal" id="gtotal" value="0" />
        <label id="lb_total" style="font-size:24px; font-weight:bold">0</label>
        
    </td>
</table>
<table width="90%" align="center">
<tr>
	<td>
    	<fieldset>
        	<legend><b>Customer Information:</b></legend>
            	<table>
                	<tr>
                    	<td>Customer Name: </td>
                        <td>
                            <select onchange="doCustomer(this.value);" name="customer" id="customer">
                            	<option value="">Select Customer Name
                                <option value="new">New Customer
                                <?php
									$rst = mysql_query("select cust_id, fname, lname from customers where st='1' order by fname") or die(mysql_error());
									while($row = mysql_fetch_array($rst))
									{
										echo "<option value='".trim($row['cust_id'])."'>".trim(stripslashes($row['fname']))." ".trim(stripslashes($row['lname']));
									}
								?>
                                
                            </select>
                        </td></table>
                        <table id="customertable" style="display:none">
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
                            
                    	</table>
                        <img src='images/wait.gif' id="wait_img" style="display:none" />
                        <span id="customerdetails"></span>
                   
        </fieldset>
    </td>
	<td align="right">
    	<fieldset><legend align="center"><b>Payment Method</b></legend>

        	CREDIT <input type="checkbox" name="credit" id="credit" value="CREDIT" onclick="ptype(this.id, 'credit'); doTotalPaid(0, 0)" />
                <!-- <input name="creditt" id="creditt" readonly value="0" style="display:none" /> -->
                <br>
                    CASH <input type="checkbox" name="cash" id="cash" value="CASH" onclick="ptype(this.id, 'casht');" />
                <input name="casht" id="casht" placeholder="Cash Amount" value="0" style="display:none" onblur="doTotalPaid(this.value, document.getElementById('cashtrft').value)" />
            <br />
			
			
                    CASH TRANSFER <input type="checkbox" name="cashtrf" id="cashtrf" value="CASHTRF" onclick="ptype(this.id, 'cashtrft');" />
                <input name="cashtrft" id="cashtrft" placeholder="Cash Transfer Amount" value="0" style="display:none" onblur="doTotalPaid(this.value, document.getElementById('cardt').value)" />
            <br />
			
        	DEBIT CARD <input type="checkbox" name="card" id="card" value="CARD" onclick="ptype(this.id, 'cardt');" />
            <input name="cardt" id="cardt" maxlength="20" placeholder="Debit/Credit Card #" style="display:none" onblur="doTotalPaid(this.value, document.getElementById('casht').value)" />
            <br />
        	GIFT CARD <input type="checkbox" name="gcard" id="gcard" value="GCARD" onclick="ptype(this.id, 'gcardt');" />
            <input name="gcardt" id="gcardt" maxlength="12" placeholder="Gift Card #" style="display:none" /> <a href="javascript:doCheck(1)" id="gcardt2" style="display:none"><img src="images/0.gif" border="0" title="Verify Gift Card" /></a>
            <br />
        	COUPON <input type="checkbox" name="gcert" id="gcert" value="GCERT" onclick="ptype(this.id, 'gcertt');" />
            <input name="gcertt" id="gcertt" maxlength="12" placeholder="Coupon #" style="display:none" /> <a href="javascript:doCheck(2)" id="gcertt2" style="display:none"><img src="images/0.gif" border="0" title="Verify Coupon" /></a>
            <br>
                <hr>
                    TOTAL PAID: <label style="font-size:24px; font-weight:bold"><strike>N</strike><span id="lb_totalpaid">0.00</span></label><input type="hidden" name="totalpaid" id="totalpaid" />
                    <br><br>
                            BALANCE DUE:  <label style="font-size:24px; font-weight:bold"><strike>N</strike><span id="lb_balancedue">0.00</span></label><input type="hidden" name="balancedue" id="balancedue" />

        </fieldset>
    </td>

	<td align="right" valign="middle" colspan="2"><br /><br /><a href="javascript:doPay();"><img src="images/pay_but.jpg" title="Accept Payment" border="0" /></a></td>
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
    
    function doTotalPaid(c, cc)
    {
        //alert(c);
        //alert(cc);
        if(isNaN(parseInt(c))){ c=0; }
        if(isNaN(parseInt(cc))){ cc=0; }
        
        document.getElementById('totalpaid').value = parseInt(c) + parseInt(cc);
        document.getElementById('balancedue').value = parseInt(document.getElementById('gtotal').value) - parseInt(document.getElementById('totalpaid').value);
        document.getElementById('lb_totalpaid').innerHTML = format1(parseInt(document.getElementById('totalpaid').value));
        document.getElementById('lb_balancedue').innerHTML = format1(parseInt(document.getElementById('balancedue').value));
    }

function doDiscount(d)
{
	
	document.getElementById('gtotal').value = document.getElementById('gtotal').value - ((d/100) * document.getElementById('gtotal').value);
	document.getElementById('lb_total').innerHTML = format1(parseInt(document.getElementById('gtotal').value));
	
	//alert(document.getElementById('gtotal').value);
}

function doCustomer(a)
{
	if(a == "new")
	{
		document.getElementById('wait_img').style.display = 'none';
		document.getElementById('customerdetails').innerHTML = "";
		document.getElementById('customertable').style.display = "block";		
		document.getElementById('customerfname').focus();
	}
	else if(a == "")
	{
		document.getElementById('customertable').style.display = "none";
		document.getElementById('customerfname').value=""
		document.getElementById('customerlname').value=""
		document.getElementById('customerphone').value="";
		document.getElementById('emailaddress').value="";
		document.getElementById('town').value="";
                //document.getElementById('cbalance').value="";
		
		document.getElementById('wait_img').style.display = 'none';
		document.getElementById('customerdetails').innerHTML = "";
	}
	else
	{
		document.getElementById('customertable').style.display = "none";
		
		document.getElementById('customerfname').value=""
		document.getElementById('customerlname').value=""
		document.getElementById('customerphone').value="";
		document.getElementById('emailaddress').value="";
		document.getElementById('town').value="";
                //document.getElementById('cbalance').value="";
		
		//document.getElementById('wait_img').style.display = 'block';
		document.getElementById('customerdetails').innerHTML = "";
		getCustomer(a);
		//document.getElementById('wait_img').style.display = 'block';
	}
}

function getCustomer(a)
{
	$.get(
                 'getCustomer.php',
                 { c: a },
                 function(data)
                 {
				   document.getElementById('customerdetails').innerHTML = data;
                 });
}

function doCheck(c)
{
	if(c == 1){}
	else if(c == 2){}
}

function ptype(a, b)
{
	//alert(document.getElementById(a).checked);
        if(a == 'credit')
        {
            //do nothing!
        }
	else if(document.getElementById(a).checked)
	{
		document.getElementById(b).style.display = 'block'; 
		document.getElementById(b).focus();
                
                if(document.getElementById('credit').checked)
                {
                    document.getElementById('credit').checked = false;
                }
                
		doImage(b, 'block');
	}
	else
	{
		document.getElementById(b).style.display = 'none';
		document.getElementById(b).value = '';
		doImage(b, 'none');
	}
	
}

function doImage(b, t)
{
        if(b == 'gcardt')
        {
                document.getElementById('gcardt2').style.display = t;
        }
        else if(b == 'gcertt')
        {
                document.getElementById('gcertt2').style.display = t;
        }
}

function doPay()
{
	if(parseInt(document.getElementById('gtotal').value) < 1)
	{
		alert("Nothing to pay for");
		document.getElementById('itemcode').focus();
	}
        else if(document.getElementById('balancedue').value > 0 && document.getElementById('customer').value == "")
        {
            alert("Please select a customer");
            document.getElementById('customer').focus();
        }
	else if(document.getElementById('credit').checked || document.getElementById('cash').checked || document.getElementById('cashtrf').checked || document.getElementById('card').checked || document.getElementById('gcard').checked || document.getElementById('gcert').checked)
	{
            document.f1.submit();
	}
	else
	{
		alert("Please select a Payment method!");
	}
}

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
        //document.getElementById('total2_'+i).value = "";
	
	document.getElementById('lb_itemcode'+i).innerHTML = "";
	document.getElementById('lb_qty'+i).innerHTML = "";
	document.getElementById('lb_item'+i).innerHTML = "";
	document.getElementById('lb_rate'+i).innerHTML = "";
	document.getElementById('lb_total'+i).innerHTML = "";
	document.getElementById('del_but'+i).innerHTML = "";
        
        document.getElementById('tr'+i).innerHTML = "<td colspan='7' bgcolor='#ffffff'><td>";
        document.getElementById('cash').checked = false;
		document.getElementById('cashtrf').checked = false;
        document.getElementById('card').checked = false;
        document.getElementById('gcard').checked = false;
        document.getElementById('gcert').checked = false;
	
}

function doEdit(i)
{
    var newtotal = prompt("New Price","");
    
    //alert(newtotal);
    
    if(!(isNaN(parseInt(newtotal))))
    {
        document.getElementById('gtotal').value = parseInt(document.getElementById('gtotal').value) - parseInt(document.getElementById('total_'+i).value);
        
        document.getElementById('total_'+i).value = parseInt(newtotal);
        document.getElementById('lb_total'+i).innerHTML = format1(parseInt(newtotal));
        //alert(document.getElementById('total_'+i).value);
        
        document.getElementById('gtotal').value = parseInt(document.getElementById('gtotal').value) + parseInt(newtotal);
	  
	document.getElementById('lb_total').innerHTML = format1(parseInt(document.getElementById('gtotal').value));
	
    }
    
}

var cnt=0;
//var ccnt=1;


     $(document).ready(function()
     {
       
		   $('#gcardt2').click(function()
		   {
				var rst = false;
				
				if(document.getElementById('gcardt').value.length < 10)
				{
					alert("Invalid Gift Card #");
					document.getElementById('gcardt').focus();
				}
				else
				{
					rst = true;
				}

		  if(rst)
		  {
		  	$.get(
                 'chk_card.php',
                 { c: document.getElementById('gcardt').value },
                 function(data)
                 {
				   if(data == "0")
				   {
				   		alert("Invalid Gift Card");
						document.getElementById('gcardt').focus();
						document.getElementById('gcardt').select();
				   }
				   else if(isNaN(parseInt(data)))
				   {
				   		alert(data);
				   }
				   else
				   {
						$('#gifttable').append("<tr><td>Gift Card: </td><td>"+data+"</td>");
						
						document.getElementById('gtotal').value = parseInt(document.getElementById('gtotal').value) - parseInt(data);
	  
					  document.getElementById('lb_total').innerHTML = format1(parseInt(document.getElementById('gtotal').value));
					  
					  document.getElementById('gcardt2').innerHTML = "";
					  document.getElementById('gcardt').readOnly = true;
					  
					   
					}
                 });
	  
	  }
	  
    });
	
	//============================ Start Gift Certificate Verification ==================
	
	$('#gcertt2').click(function()
		   {
				var rst = false;
				
				if(document.getElementById('gcertt').value.length < 10)
				{
					alert("Invalid Coupon #");
					document.getElementById('gcertt').focus();
				}
				else
				{
					rst = true;
				}

		  if(rst)
		  {
		  	$.get(
                 'chk_card.php',
                 { c: document.getElementById('gcertt').value },
                 function(data)
                 {
				   if(data == "0")
				   {
				   		alert("Invalid Coupon");
						document.getElementById('gcertt').focus();
						document.getElementById('gcertt').select();
				   }
				   else if(isNaN(parseInt(data)))
				   {
				   		alert(data);
				   }
				   else
				   {
						$('#gifttable').append("<tr><td>Coupon: </td><td>"+data+"</td>");
						
						document.getElementById('gtotal').value = parseInt(document.getElementById('gtotal').value) - parseInt(data);
	  
					  document.getElementById('lb_total').innerHTML = format1(parseInt(document.getElementById('gtotal').value));
					  
					  document.getElementById('gcertt2').innerHTML = "";
					  document.getElementById('gcertt').readOnly = true;
					  
					   
					}
                 });
	  
	  }
	  
    });
	
		//============================ Add Item ==================
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
                 { i: document.getElementById('itemcode').value+"^"+document.getElementById('qty').value+"^"+cnt+"^S^"+document.getElementById('salestype').value },
                 function(data)
                 {
                   //$('#result').html(data);
				   //alert(data);
				   if(data == "1")
				   {
				   		alert("Invalid Item Code");
						document.getElementById('itemcode').focus();
						document.getElementById('itemcode').select();
				   }
				   else if(data == "2")
				   {
				   		alert("Insufficient items in stock");
						document.getElementById('qty').focus();
						document.getElementById('qty').select();
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
    
    /////////////////////////Search Items/////////////////////////////
    
    $('#srcItem').click(function()
       {
          //alert("i dey inside sales o");
		  var rst = getItem2(document.getElementById('itemname').value, document.getElementById('itemdescription').value);

		  if(rst)
		  {
		//	cnt++;
		 	//document.getElementById('cnt').value = 1 + parseInt(document.getElementById('cnt').value);
		  
	$.get(
                 'srcItem.php',
                 { i: document.getElementById('itemname').value+"^"+document.getElementById('itemdescription').value },
                 function(data)
                 {
                   //$('#result').html(data);
				   //alert(data);
				   if(data == "1")
				   {
				   		alert("Invalid Item Name or Description");
						document.getElementById('itemname').focus();
						document.getElementById('itemname').select();
				   }
				   else
				   {
				   	//	$('#items').append(data);
						
					//	document.getElementById('gtotal').value = parseInt(document.getElementById('gtotal').value) + parseInt(document.getElementById('total_'+cnt).value);
	  
					  //document.getElementById('lb_total').innerHTML = format1(parseInt(document.getElementById('gtotal').value));
					  alert(data);
                                          document.getElementById('itemname').value = "";
                                          document.getElementById('itemdescription').value = "";
                                          
					  document.getElementById('itemcode').value = data;
					  //document.getElementById('qty').value = "";
					  document.getElementById('qty').focus(); 
					}
                 });
		  
		  
		 
		//alert("wahala dey o");
	  //alert(document.getElementById('total_1').id);
	  
		 
	  //finito(cnt);
	  
	  
	  }
	  
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

function getItem2(n, d)
{
    if(n.length < 1 && d.length < 1)
    {
        alert("Please specify an item name or item description");
        document.getElementById('itemname').focus();
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
        
        $(function() {
            var availableTags = [

                
                
                <?php
                
                include("incs/dbcon.inc");
                
                $rs = mysql_query("select idesc from items") or die(mysql_error());
                while($r = mysql_fetch_array($rs))
                {
                    echo '"'.trim($r['idesc']).'",';
                    
                }
                echo '"."';
                ?>

                
            ];
            $("#itemdescription").autocomplete({
                source: availableTags
            });

        });
</script>

</body>
</html>
