<?php

/* 
 * This file was created by Maiyegun A. Jimoh, Esq.
 * Send me an email if you have any problems (jimohesq@yahoo.com)
 * 
 */

//chk_lisence();

function chk_lisence(){

include("incs/dbcon.inc");

$rst = mysql_query("select datediff('2017-01-24', now()) as 'dte'") or die(mysql_error());

$row =  mysql_fetch_array($rst);

//echo $row['dte'];

if($row['dte'] < 0)
{
    echo "Your trial period has expired, hope you enjoyed it while it lasted.";
    echo "<br><br>Please contact 08089054664 to switch to pro version. <br><br>Thanks a lot";
    exit;
}
}