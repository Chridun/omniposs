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
$amt = 0;
        
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

$actualcnt = 0;


for($i=0; $i <= $cnt; ++$i)
{
	if(isset($_POST['itemcode'.$i]) && strlen($_POST['itemcode'.$i]) > 1)
	{
		$actualcnt++;
		
		//enter d trans_b dbase
                //echo "insert into trans_b(tran_id, icode, idesc, iqty, amt, dte) values('".$transactionid."','".$_POST['itemcode'.$i]."','".$_POST['item'.$i]."',".$_POST['qty'.$i].",".$_POST['total_'.$i].",now())";
                //echo "<br>";
                
		mysql_query("insert into trans_b(tran_id, icode, idesc, iqty, amt, dte) values('".$transactionid."','".$_POST['itemcode'.$i]."','".$_POST['reason'.$i]."',".$_POST['qty'.$i].",0,now())") or die(mysql_error());
		
		//deduct from stock
		mysql_query("update items set qty=qty-".$_POST['qty'.$i]." where icode='".$_POST['itemcode'.$i]."'") or die(mysql_error());
		
		
	}
}
//exit;

mysql_query("insert into trans values('".$transactionid."',".$actualcnt.",0,now(),'','C','".$_SESSION['fname']."')") or die(mysql_error());

header("Location: recall.php");
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
<body onLoad="doDte(); print(); location.replace('recall.php');" style="font-family:Arial, Helvetica, sans-serif">
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