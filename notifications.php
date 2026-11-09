<?php

/* 
 * This file was created by Maiyegun A. Jimoh, Esq.
 * Send me an email if you have any problems (jimohesq@yahoo.com)
 * 
 */

include("incs/dbcon.inc");

//1. Check for items to be reordered.
$rst = mysql_query("select * from items where rpoint > qty") or die(mysql_error());

$cnt = 0;
echo "<a href='notifications2.php'>";

while($row = mysql_fetch_assoc($rst))
{
    $cnt++;
    
    if($cnt == 1)
    {
        echo "Items to be re-ordered: ";
    }
    
    echo $row['iname']." (".$row['qty']."), ";
}

echo "<br>";

$rs = mysql_query("select iname, idesc, date_format( expdte , '%W %D %M, %Y - %h:%i %p') as 'expdte', datediff(expdte, now()) as 'dif' from items where expdte != '0000-00-00'") or die(mysql_error());

$cnt = 0;

while($row = mysql_fetch_assoc($rs))
{
    $cnt++;
    
    if($cnt == 1)
    {
        echo "Items about to expire/expired: ";
    }
    
   if($row['dif'] < 91)
   {
        //$cnt++;
    
        echo "<span style='color:red'>".trim($row['iname'])." (".$row['expdte']."), ";
        
   }
   
}

echo "</a>";