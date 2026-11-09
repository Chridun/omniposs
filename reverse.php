<?php

/* 
 * This file was created by Maiyegun A. Jimoh, Esq.
 * Send me an email if you have any problems (jimohesq@yahoo.com)
 * 
 */

$transactionid = base64_decode(trim(stripcslashes(strip_tags($_REQUEST['i']))));

include("incs/dbcon.inc");
//get transaction type

$rst = mysql_query("select tstatus from trans where tran_id='".$transactionid."'") or die(mysql_error());
$row = mysql_fetch_assoc($rst);
$transactiontype = $row['tstatus'];

if($transactiontype == 'S')
{
    //if sales
    //get transaction fragments
        //update each item with items that were bought (add items back)
            //delete all traces of this transaction from trans, trans_b, cust_trans, ptype
    
    $rst = mysql_query("select icode, iqty from trans_b where tran_id='".$transactionid."'") or die(mysql_error());
    
    while($row = mysql_fetch_array($rst))
    {
        doUpdate($row['icode'], $row['iqty'], 'S');
    }
    
    mysql_query("delete from cust_trans where tran_id='".$transactionid."'") or die(mysql_error());
    mysql_query("delete from ptype where tran_id='".$transactionid."'") or die(mysql_error());
    mysql_query("delete from iou where tran_id='".$transactionid."'") or die(mysql_error());
    mysql_query("delete from trans where tran_id='".$transactionid."'") or die(mysql_error());
    mysql_query("delete from trans_b where tran_id='".$transactionid."'") or die(mysql_error());
    
    header("Location: reports.php");
    
}
else if($transactiontype == 'R')
{
    //if return
    //get transaction fragments
        //update each item with items that were returned (subtract items)
            //delete all traces of this transaction trans, trans_b
    
    $rst = mysql_query("select icode, iqty from trans_b where tran_id='".$transactionid."'") or die(mysql_error());
    
    while($row = mysql_fetch_array($rst))
    {
        doUpdate($row['icode'], $row['iqty'], 'R');
    }
    
    //mysql_query("delete from cust_trans where tran_id='".$transactionid."'") or die(mysql_error());
    //mysql_query("delete from ptype where tran_id='".$transactionid."'") or die(mysql_error());
    mysql_query("delete from trans where tran_id='".$transactionid."'") or die(mysql_error());
    mysql_query("delete from trans_b where tran_id='".$transactionid."'") or die(mysql_error());
    
    header("Location: reports.php");
    
    
}
else if($transactiontype == 'B')
{
    //if balance
    //get transaction fragments
        //add amount back to customer's balance
            //delete all traces of this transaction trans, trans_b
    
    
    $rst = mysql_query("select icode, amt from trans_b where tran_id='".$transactionid."'") or die(mysql_error());
    
    while($row = mysql_fetch_array($rst))
    {
        doUpdate($row['icode'], $row['amt'], 'B');
    }
    
    mysql_query("delete from cust_trans where tran_id='".$transactionid."'") or die(mysql_error());
    mysql_query("delete from ptype where tran_id='".$transactionid."'") or die(mysql_error());
    mysql_query("delete from trans where tran_id='".$transactionid."'") or die(mysql_error());
    mysql_query("delete from trans_b where tran_id='".$transactionid."'") or die(mysql_error());
    
    header("Location: reports.php");
    
}
else if($transactiontype == 'C')
{
    //if sales
    //get transaction fragments
        //update each item with items that were bought (add items back)
            //delete all traces of this transaction from trans, trans_b, cust_trans, ptype
    
    $rst = mysql_query("select icode, iqty from trans_b where tran_id='".$transactionid."'") or die(mysql_error());
    
    while($row = mysql_fetch_array($rst))
    {
        doUpdate($row['icode'], $row['iqty'], 'C');
    }
    
    //mysql_query("delete from cust_trans where tran_id='".$transactionid."'") or die(mysql_error());
    //mysql_query("delete from ptype where tran_id='".$transactionid."'") or die(mysql_error());
    //mysql_query("delete from iou where tran_id='".$transactionid."'") or die(mysql_error());
    mysql_query("delete from trans where tran_id='".$transactionid."'") or die(mysql_error());
    mysql_query("delete from trans_b where tran_id='".$transactionid."'") or die(mysql_error());
    
    header("Location: reports.php");
    
}

function doUpdate($itemcode, $itemqty, $transactiontype)
{
    switch($transactiontype)
    {
        case 'S':
            mysql_query("update items set qty=qty+".$itemqty." where icode='".$itemcode."'") or die(mysql_error());
            break;
        
        case 'R':
            mysql_query("update items set qty=qty-".$itemqty." where icode='".$itemcode."'") or die(mysql_error());
            break;
        
        case 'B':
            mysql_query("update customers set bal=bal+".$itemqty." where cust_id='".$itemcode."'") or die(mysql_error());
            break;
        
        case 'C':
            mysql_query("update items set qty=qty+".$itemqty." where icode='".$itemcode."'") or die(mysql_error());
            break;
    }
    
    
}

