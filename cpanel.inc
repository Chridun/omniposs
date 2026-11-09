<?php
switch($_SESSION['role'])
{
	case "sadmin":
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td width="108" height="67" valign="top"><a href="staff.php"><img src="images/transactions_r5_c2.png" title="Manage Staff" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="categories.php"><img src="images/transactions_r10_c2.png" title="Categories" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="items.php"><img src="images/transactions_r6_c2.png" title="Manage Items" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="customers.php"><img src="images/transactions_r16_c2.png" title="Customers" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="sales.php"><img src="images/transactions_r15_c2.png" title="Make a Sale" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="return.php"><img src="images/transactions_r19_c2.png" title="Return Item" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="coupons.php"><img src="images/transactions_r17_c2.png" title="Manage Coupons" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="giftcards.php"><img src="images/transactions_r18_c2.png" title="Manage Gift Cards" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="reports.php"><img src="images/rpts_img.png" title="Reports" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="295">&nbsp;</td>
      </tr>
    </table>';
	break;
	
	case "admin":
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td height="67" valign="top"><a href="categories.php"><img src="images/transactions_r10_c2.png" title="Categories" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="items.php"><img src="images/transactions_r6_c2.png" title="Manage Items" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="customers.php"><img src="images/transactions_r16_c2.png" title="Customers" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="sales.php"><img src="images/transactions_r15_c2.png" title="Make a Sale" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="return.php"><img src="images/transactions_r19_c2.png" title="Return Item" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="coupons.php"><img src="images/transactions_r17_c2.png" title="Manage Coupons" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="giftcards.php"><img src="images/transactions_r18_c2.png" title="Manage Gift Cards" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="reports.php"><img src="images/rpts_img.png" title="Reports" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="295">&nbsp;</td>
      </tr>
    </table>';
	break;
	
	case "accountant":
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      
      <tr>
        <td height="67" valign="top"><a href="items.php"><img src="images/transactions_r6_c2.png" title="Manage Items" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="customers.php"><img src="images/transactions_r16_c2.png" title="Customers" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="sales.php"><img src="images/transactions_r15_c2.png" title="Make a Sale" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="return.php"><img src="images/transactions_r19_c2.png" title="Return Item" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="coupons.php"><img src="images/transactions_r17_c2.png" title="Manage Coupons" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="giftcards.php"><img src="images/transactions_r18_c2.png" title="Manage Gift Cards" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="reports.php"><img src="images/rpts_img.png" title="Reports" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="295">&nbsp;</td>
      </tr>
    </table>';

	break;
	
	case "user":
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      
      <tr>
        <td height="67" valign="top"><a href="items.php"><img src="images/transactions_r6_c2.png" title="Manage Items" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="customers.php"><img src="images/transactions_r16_c2.png" title="Customers" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="sales.php"><img src="images/transactions_r15_c2.png" title="Make a Sale" width="108" height="66" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="return.php"><img src="images/transactions_r19_c2.png" title="Return Item" width="108" height="67" border="0" /></a></td>
      </tr>
      <tr>
        <td height="67" valign="top"><a href="reports.php"><img src="images/rpts_img.png" title="Reports" width="108" height="67" border="0" /></a></td>
      </tr>
      
      <tr>
        <td height="295">&nbsp;</td>
      </tr>
    </table>';
	break;
}

?>