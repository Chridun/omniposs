<?php
$c = $_GET['c'];

include("incs/dbcon.inc");

$rst = mysql_query("select cust_id, fone, email, town, bal from customers where cust_id='$c'") or die(mysql_error());

$row = mysql_fetch_array($rst);
$bal = $row['bal'];
$b = "";

if($bal > 0)
{
    $b = "<a href='pay_bal.php?b=".  base64_encode(trim($row['cust_id']))."'><img src='images/0.gif' border=0 title='Pay Balance' /></a>";
}
echo "<table><tr><td>Customer ID: </td><td><b>".trim($row['cust_id'])."</b></td><tr><td>Customer Telephone: </td><td><b>".trim($row['fone'])."</b></td><tr><td>Customer Email Address: </td><td><b>".trim($row['email'])."</b></td><tr><td>Customer Town/District: </td><td><b>".trim($row['town'])."</b></td><tr><td>Balance: </td><td><b><strike>N</strike>".number_format(trim($row['bal']),2,'.',',')."</b> ".$b."</td></table>";
?>