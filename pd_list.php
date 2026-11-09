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

//alert(dte);
document.getElementById('dte').innerHTML = dte;
//location.replace('sales.php')
}
</script>
</head>
<body onload="doDte(); print(); location.replace('d_list.php');">
    
    
    <p align='center'>
        <b><u>DEBTOR LIST</u></b><br />
    
        <span id="dte"></span> <br><br>
    
    
<table>
<th>SNo.</th><th>NAME</th><th>BALANCE</th><th>DATE</th>
<tr><td colspan="4"><hr></td>

    <?php 
    include('incs/dbcon.inc');
    
    $rst = mysql_query("select * from customers where bal>0 order by bal desc") or die(mysql_error());

$cnt=0;

while($row = mysql_fetch_array($rst))
{
	$cnt++;
	echo "<tr><td align='center'>$cnt.</td><td>".trim($row['fname'])." ".trim($row['lname'])."</td><td align='right'><strike>N</strike>".number_format(trim($row['bal']),2,'.',',')."</td><td align='center'>".getBalDte(trim($row['cust_id']))."</td>";
	echo "<tr><td colspan='4'><hr></td>";
}

$rst = mysql_query("select sum(bal) as 'bal' from customers") or die(mysql_error());
$row = mysql_fetch_array($rst);
echo "<tr><td colspan='2' align='right'><h2>Total:</h2> </td><td align='right'><h2><strike>N</strike>".number_format(trim($row['bal']),2,'.',',')."</h2></td><td></td>";


function getBalDte($c)
{
    $rst = mysql_query("select date_format( dte , '%d %M, %Y') as 'dte' from iou where cust_id='".$c."' order by dte desc") or die(mysql_error());
    
    $row = mysql_fetch_array($rst);
    return trim($row['dte']);
}
    
?>
</table>
</body>
</html>