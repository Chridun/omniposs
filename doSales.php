<?php
session_start();

if(isset($_SESSION['role']))
{
	if(strlen($_SESSION['role']) < 1)
	{
		header("Location: index.php?m=".base64_encode("Session expired, please login."));
		exit;
	}
}
else
{
	header("Location: index.php?m=".base64_encode("Session expired, please login."));
	exit;
}

$cnt = trim(stripslashes(strip_tags($_POST['cnt'])));
$amt = trim(stripslashes(strip_tags($_POST['gtotal'])));
$balancedue = trim(stripslashes(strip_tags($_POST['balancedue'])));
$amountpaid = trim(stripslashes(strip_tags($_POST['totalpaid'])));
$customerid = "";
        

$receipt = "";
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

include("incs/dbcon.inc");

//check if full amount was paid for the transaction
if($balancedue > 0)
{
    //check if customer is new or existing
    if($_POST['customer'] == "new")
    {
        $customerid = $transactionid;
    }
    else
    {
        $customerid = strip_tags(stripslashes($_POST['customer']));
    }
    
    mysql_query("insert into iou(tran_id, cust_id, amtdue, amtpd, bal, dte) values('".$transactionid."','".$customerid."',".$amt.",".$amountpaid.",".$balancedue.",now())") or die(mysql_error());
    //mysql_query("insert into customers(cust_id) values()") or die(mysql_error());
}

$actualcnt = 0;


for($i=0; $i <= $cnt; ++$i)
{
	if(isset($_POST['itemcode'.$i]) && strlen($_POST['itemcode'.$i]) > 1)
	{
		$actualcnt++;
		
		//enter d trans_b dbase
                //echo "insert into trans_b(tran_id, icode, idesc, iqty, amt, dte) values('".$transactionid."','".$_POST['itemcode'.$i]."','".$_POST['item'.$i]."',".$_POST['qty'.$i].",".$_POST['total_'.$i].",now())";
                //echo "<br>";
                
		mysql_query("insert into trans_b(tran_id, icode, idesc, iqty, amt, dte) values('".$transactionid."','".$_POST['itemcode'.$i]."','".$_POST['item'.$i]."',".$_POST['qty'.$i].",".$_POST['total_'.$i].",now())") or die(mysql_error());
		
		//deduct from stock
		mysql_query("update items set qty=qty-".$_POST['qty'.$i]." where icode='".$_POST['itemcode'.$i]."'") or die(mysql_error());
		
		$receipt.= "<tr><td>".$_POST['item'.$i]."</td><td align='center'>".$_POST['qty'.$i]."</td><td align='right'>".number_format($_POST['rate'.$i],2,'.',',')."</td><td align='right'>".number_format($_POST['total_'.$i],2,'.',',')."</td>";
		$receipt.= "<tr><td colspan='4'><hr></td>";
	}
}
//exit;

$receipt.="<tr><td colspan='4'><br></td>";
$receipt.="<tr><td colspan='3' align='right'><b>RECEIPT TOTAL: </b></td><td align='right'><b><strike>N</strike>".number_format($amt,2,'.',',')."</b></td>";

if($balancedue > 0)
{
    $receipt.="<tr><td colspan='3' align='right'><b>AMOUNT PAID: </b></td><td align='right'><b><strike>N</strike>".number_format($amountpaid,2,'.',',')."</b></td>";
    $receipt.="<tr><td colspan='3' align='right'><b>BALANCE DUE: </b></td><td align='right'><b><strike>N</strike>".number_format($balancedue,2,'.',',')."</b></td>";
    
}

mysql_query("insert into trans values('".$transactionid."',".$actualcnt.",".$amountpaid.",now(),'','S','".$_SESSION['fname']."')") or die(mysql_error());

//update payment type table
$cash = "0"; //cash
$cashtrf = "0"; //cash transfer
$c2 = "NIL"; //card
$gc = "NIL"; //gift card
$gc2 = "NIL"; //gift cert

if(isset($_POST['casht']))
{
	$cash = $_POST['casht'];
}

if(isset($_POST['cashtrft']))
{
	$cashtrf = $_POST['cashtrft'];
}

if(isset($_POST['cardt']))
{
	$c2 = $_POST['cardt'];
}

if(isset($_POST['gcardt']))
{
	$gc = $_POST['gcardt'];
        $receipt .= "<tr><td colspan='4'>Gift Card: ".$gc."</td>";
}

if(isset($_POST['gcertt']))
{
	$gc2 = $_POST['gcertt'];
        $receipt .= "<tr><td colspan='4'>Coupon: ".$gc2."</td>";
}



//echo "insert into ptype(tran_id, cash, cashtrf, card, gcard, gcert, dte) values('".$transactionid."',".$c.",'".$c2."','".$gc."','".$gc2."',now())";
//echo "insert into ptype(tran_id, cash, cashtrf, card, gcard, gcert, dte) values('".$transactionid."',".$c.",'".$c2."','".$gc."','".$gc2."',now())";
//exit;
mysql_query("insert into ptype(tran_id, cash, cashtrf, card, gcard, gcert, dte) values('".$transactionid."','".$cash."','".$cashtrf."','".$c2."','".$gc."','".$gc2."',now())") or die(mysql_error());

//update gift card/certificate table

if(strlen($gc) == 10)
{
	mysql_query("update giftc set status='1', tran_id='".$transactionid."', tdte=now() where gcode='".$gc."'") or die(mysql_error());
}

if(strlen($gc2) == 10)
{
	mysql_query("update giftc set status='1', tran_id='".$transactionid."', tdte=now() where gcode='".$gc2."'") or die(mysql_error());
}


//Register Customer
if($_POST['customer'] == "")
{
	
}
else if($_POST['customer'] == "new")
{
	$customerid = $transactionid;
	$customerfname = "";
	$customerlname = "";
	$customerphone = "";
	$emailaddress = "";
	$cutsomertown = "";
	
	
	if(isset($_POST['customerfname']))
	{
		$customerfname = trim(stripslashes(strip_tags($_POST['customerfname'])));
	}
	
	if(isset($_POST['customerlname']))
	{
		$customerlname = trim(stripslashes(strip_tags($_POST['customerlname'])));
	}
	
	if(isset($_POST['customerphone']))
	{
		$customerphone = trim(stripslashes(strip_tags($_POST['customerphone'])));
	}
	
	if(isset($_POST['emailaddress']))
	{
		$emailaddress = trim(stripslashes(strip_tags($_POST['emailaddress'])));
	}
	
	if(isset($_POST['town']))
	{
		$customertown = trim(stripslashes(strip_tags($_POST['town'])));
	}
	
	$rst = mysql_query("select * from customers where cust_id='".$customerid."'") or die(mysql_error());
	
	if(mysql_num_rows($rst) > 0)
	{
		doCustTrans($transactionid, $customerid);
	}
	else
	{
		//create new customer
		mysql_query("insert into customers values('".$customerid."','".$customerfname."','".$customerlname."','','','".$customerphone."','".$emailaddress."','',now(),'".$customertown."',0,'1')");
		
		doCustTrans($transactionid, $customerid, $balancedue);
	}
	
}
else
{
	doCustTrans($transactionid, strip_tags(stripslashes($_POST['customer'])), $balancedue);
}

function doCustTrans($t, $c, $b)
{
	mysql_query("insert into cust_trans(tran_id, cust_id, dte) values('".$t."','".$c."',now())");
        mysql_query("update customers set bal=bal+".$b." where cust_id='".$c."'") or die(mysql_error());
}
?>
<html>
<head>
<script language="javascript" type="text/javascript">
function doDte()
{
	var dte = "";
	
	var currentTime = new Date();
var month = currentTime.getMonth() + 1;
var day = currentTime.getDate();
var year = currentTime.getFullYear();
dte = day + "/" + month + "/" + year+" ";

var hours = currentTime.getHours();
var minutes = currentTime.getMinutes();
if (minutes < 10){
minutes = "0" + minutes;
}
dte += hours + ":" + minutes + " ";
if(hours > 11){
dte += "PM";
} else {
dte += "AM";
}
//alert(dte);
document.getElementById('dte').innerHTML = dte;
//location.replace('sales.php')
}
</script>
</head>
<body onLoad="doDte(); window.print();" style="font-family:Arial, Helvetica, sans-serif">
<!--  <p align="center"><img src="images/transactions_r1_c2.png" width="99px" height="55px"></p>-->
<table>
<tr align="center">
    <td colspan="4">
    <?php
			$rst = mysql_query("select * from receipt") or die(mysql_error());
			$row = mysql_fetch_array($rst);
			echo trim($row['sname'])."<br><br>";
                        echo trim($row['line1'])."<br>";
			echo trim($row['line2'])."<br>";
			echo trim($row['line3'])."<br>";
			echo trim($row['line4'])."<br>";
			echo trim($row['tel'])."<br>";
			echo trim($row['email'])."<br><br>";
			$ft1 = trim($row['footer1']);
			$ft2 = trim($row['footer2']);
			mysql_close();
		?>
    </td>
    
<tr>
    <td colspan="4"><hr></td>
<tr>
	<td colspan="4">Cashier: <?php echo $_SESSION['fname']."<br><br>"; ?></td>
<tr>
	<td colspan="4">
	<?php //echo date("d-m-Y H:i:s"); ?>
            <span id="dte"></span> <br><br> </td>
<tr>
    <td colspan="4" align="center">
        <b><u>Sales Receipt</u></b><br /><br />
    </td>
<tr>
	<td align="center"><b>Item</b></td>
    <td align="center"><b>Qty</b></td>
    <td align="center"><b>Price</b></td>
    <td align="center"><b>Total</b></td>
<tr>
	<td colspan="4"><hr /></td>
<?php
echo $receipt; 
?>
<tr>
	<td colspan="4" align="center"><b><?php echo $transactionid; ?></b></td>
<tr>
	<td colspan="4" align="center"><br /><?php echo $ft1; ?></td>
<tr>
	<td colspan="4" align="center"><?php echo $ft2; ?></td>
</table>
</body>
</html>