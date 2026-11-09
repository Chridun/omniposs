<?php
$i = explode("^",$_GET['i']);

include("incs/dbcon.inc");

$price = $i[4];

$rst = mysql_query("select icode, qty, iname, idesc, ".$price.", img from items where icode='".$i[0]."'") or die(mysql_error());

if(mysql_num_rows($rst) > 0)
{

$row = mysql_fetch_array($rst);

	if($i[3] == "S")
	{
		if($row['qty'] >= $i[1])
		{
			echo '<tr bgcolor="#cccccc" id="tr'.$i[2].'><td align="center">'.$i[2].'</td><td align="center"><input type="hidden" name="itemcode'.$i[2].'" value="'.$i[0].'" id="itemcode'.$i[2].'" value="'.$i[0].'" /><label id="lb_itemcode'.$i[2].'">'.$i[0].'</label> </td><td align="center"><input type="hidden" id="qty'.$i[2].'" name="qty'.$i[2].'" value="'.$i[1].'" /> <label id="lb_qty'.$i[2].'">'.$i[1].'</label> </td><td><input type="hidden" name="item'.$i[2].'" id="item'.$i[2].'" value="'.trim(stripslashes($row['iname'])).'" /><label id="lb_item'.$i[2].'">'.trim(stripslashes($row['iname'])).'</label></td><td><input type="hidden" id="rate'.$i[2].'" name="rate'.$i[2].'" value="'.$row[$price].'" /><label id="lb_rate'.$i[2].'">'.number_format($row[$price],2,'.',',').'</label></td><td align="center"><input type="hidden" id="total_'.$i[2].'" name="total_'.$i[2].'" value="'.($row[$price] * $i[1]).'" /><label id="lb_total'.$i[2].'">'.number_format(($row[$price] * $i[1]),2,'.',',').'</label></td><td align="center"><span id="del_but'.$i[2].'"> <a href="javascript:doEdit('.$i[2].')"><img src="images/edit.png" width="16px" height="16px" title="Give Discount" border="0" class="edit"/></a> <a href="javascript:doRemove('.$i[2].')"><img src="images/1.gif" width="16px" height="16px" title="Remove Item" border="0" class="remove"/></a></span></td>';
		}
		else
		{
			//echo "Only ".$row['qty']." of this item remaining.";
			echo "2";
		}
	}
	else if($i[3] == "R")
	{
		echo '<tr bgcolor="#cccccc" id="tr'.$i[2].'><td align="center">'.$i[2].'</td><td align="center"><input type="hidden" name="itemcode'.$i[2].'" value="'.$i[0].'" id="itemcode'.$i[2].'" value="'.$i[0].'" /><label id="lb_itemcode'.$i[2].'">'.$i[0].'</label> </td><td align="center"><input type="hidden" id="qty'.$i[2].'" name="qty'.$i[2].'" value="'.$i[1].'" /> <label id="lb_qty'.$i[2].'">'.$i[1].'</label> </td><td><input type="hidden" name="item'.$i[2].'" id="item'.$i[2].'" value="'.trim(stripslashes($row['iname'])).'" /><label id="lb_item'.$i[2].'">'.trim(stripslashes($row['iname'])).'</label></td><td><input type="hidden" id="rate'.$i[2].'" name="rate'.$i[2].'" value="'.$row[$price].'" /><label id="lb_rate'.$i[2].'">'.number_format($row[$price],2,'.',',').'</label></td><td align="center"><input type="hidden" id="total_'.$i[2].'" name="total_'.$i[2].'" value="'.($row[$price] * $i[1]).'" /><label id="lb_total'.$i[2].'">'.number_format(($row[$price] * $i[1]),2,'.',',').'</label></td><td align="center"><span id="del_but'.$i[2].'"><a href="'.trim($row['img']).'" target="blank"><img src="images/view.png" border=0 /></a> <a href="javascript:doRemove('.$i[2].')"><img src="images/1.gif" width="16px" height="16px" title="Remove Item" border="0" class="remove"/></a></span></td>';
	}
        else if($i[3] == "B")
	{
		if($row['qty'] >= $i[1])
		{
			echo '<tr bgcolor="#cccccc" id="tr'.$i[2].'><td align="center">'.$i[2].'</td><td align="center"><input type="hidden" name="itemcode'.$i[2].'" value="'.$i[0].'" id="itemcode'.$i[2].'" value="'.$i[0].'" /><label id="lb_itemcode'.$i[2].'">'.$i[0].'</label> </td><td align="center"><input type="hidden" id="qty'.$i[2].'" name="qty'.$i[2].'" value="'.$i[1].'" /> <label id="lb_qty'.$i[2].'">'.$i[1].'</label> </td><td><input type="hidden" name="item'.$i[2].'" id="item'.$i[2].'" value="'.trim(stripslashes($row['iname'])).'" /><label id="lb_item'.$i[2].'">'.trim(stripslashes($row['iname'])).'</label></td><td><input type="hidden" id="rate'.$i[2].'" name="rate'.$i[2].'" value="'.$row[$price].'" /><label id="lb_rate'.$i[2].'">'.number_format($row[$price],2,'.',',').'</label></td><td align="center"><input type="hidden" id="total_'.$i[2].'" name="total_'.$i[2].'" value="'.($row[$price] * $i[1]).'" /><label id="lb_total'.$i[2].'">'.number_format(($row[$price] * $i[1]),2,'.',',').'</label></td><td align="center"><span id="del_but'.$i[2].'"> <a href="javascript:doEdit('.$i[2].')"><img src="images/edit.png" width="16px" height="16px" title="Give Discount" border="0" class="edit"/></a> <a href="javascript:doRemove('.$i[2].')"><img src="images/1.gif" width="16px" height="16px" title="Remove Item" border="0" class="remove"/></a></span></td>';
		}
		else
		{
			//echo "Only ".$row['qty']." of this item remaining.";
			echo "2";
		}
	}
}
else
{
	echo "1";
}
?>