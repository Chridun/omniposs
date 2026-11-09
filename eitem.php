<?php
session_start();

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

if(isset($_POST['ai']))
{
	$itemcode = trim(stripslashes(strip_tags($_POST['itemcode'])));
	$itemname = trim(stripslashes(strip_tags($_POST['itemname'])));
	$itemdescription = trim(addslashes(strip_tags($_POST['itemdescription'])));
	$itemcategory = trim(stripslashes(strip_tags($_POST['itemcategory'])));
	$itemquantity = trim(stripslashes(strip_tags($_POST['itemquantity'])));
	$itemcostprice = trim(stripslashes(strip_tags($_POST['itemcostprice'])));
        $itemprice = trim(stripslashes(strip_tags($_POST['itemprice'])));
        $itemwprice = trim(stripslashes(strip_tags($_POST['itemwprice'])));
	//$itemcolor = trim(stripslashes(strip_tags($_POST['itemcolor'])));
	//$itemsize = trim(stripslashes(strip_tags($_POST['itemsize'])));
	//$itemweight = trim(stripslashes(strip_tags($_POST['itemweight'])));
	//$vendor = trim(stripslashes(strip_tags($_POST['vendor'])));
	$reorderpoint = trim(stripslashes(strip_tags($_POST['reorderpoint'])));
        $expirydate = trim(stripslashes(strip_tags($_POST['expirydate'])));
	//$taxrate = trim(stripslashes(strip_tags($_POST['taxrate'])));
	//$commissionrate = trim(stripslashes(strip_tags($_POST['commissionrate'])));
	
	$fileName = strip_tags(basename($_FILES['file']['name']));	
	
	
	if(strlen($fileName) > 4)
	{
		$ext = substr($fileName, strrpos($fileName, '.') + 1);
		
		if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
		{
			
			$fileName = $itemcode.".".$ext;
			$target_path="items";
			$target_path = $target_path."/". $fileName; //Join the Upload Folder with the File Name to make a full url
			//$rpt = $target_path; //variable(url) to be stored in the database
			
			if(move_uploaded_file($_FILES['file']['tmp_name'],$target_path)) //upload file to the specified location on the webserver
			{
				mysql_query("update items set iname='$itemname', idesc='$itemdescription', cat_id=$itemcategory, qty=$itemquantity, cprice=$itemcostprice, rprice=$itemprice, wprice=$itemwprice, rpoint='$reorderpoint', img='$target_path', expdte='$expirydate' where icode='$itemcode'") or die(mysql_error());
			}
			else
			{
				echo "Only images below 250 megabytes are accepted. <a href='javascript:history.back()'>< < Back</a>";
				exit;
			}
		}
		else
		{
			echo "Only '.jpg', '.jpeg' or '.png' image formats are accepted here. <a href='javascript:history.back()'>< < Back</a>";
			exit;
		}
	}
	else
	{
		mysql_query("update items set iname='$itemname', idesc='$itemdescription', cat_id=$itemcategory, qty=$itemquantity, cprice=$itemcostprice, rprice=$itemprice, wprice=$itemwprice, rpoint='$reorderpoint', expdte='$expirydate' where icode='$itemcode'") or die(mysql_error());
	}
	
	
	
	header("Location: items.php");
}
if(isset($_REQUEST['c']))
{
	$rst = mysql_query("select * from items where icode='".trim(base64_decode($_REQUEST['c']))."'") or die(mysql_error());
	
	$row = mysql_fetch_array($rst);
	
	$itemcode = trim(stripslashes(strip_tags($row['icode'])));
	$itemname = trim(stripslashes(strip_tags($row['iname'])));
	$itemdescription = trim(stripslashes(strip_tags($row['idesc'])));
	$itemcategory = trim(stripslashes(strip_tags($row['cat_id'])));
	$itemquantity = trim(stripslashes(strip_tags($row['qty'])));
	$itemcostprice = trim(stripslashes(strip_tags($row['cprice'])));
        $itemprice = trim(stripslashes(strip_tags($row['rprice'])));
        $itemwprice = trim(stripslashes(strip_tags($row['wprice'])));
	//$itemcolor = trim(stripslashes(strip_tags($row['iclr'])));
	//$itemsize = trim(stripslashes(strip_tags($row['isize'])));
	//$itemweight = trim(stripslashes(strip_tags($row['iweight'])));
	//$vendor = trim(stripslashes(strip_tags($row['vcode'])));
	$reorderpoint = trim(stripslashes(strip_tags($row['rpoint'])));
        $expirydate = trim(stripslashes(strip_tags($row['expdte'])));
	//$taxrate = trim(stripslashes(strip_tags($row['trate'])));
	//$commissionrate = trim(stripslashes(strip_tags($row['crate'])));
	$itemimage = trim(stripslashes(strip_tags($row['img'])));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OmniPOSS ::</title>

<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	
	<script src="js/prototype.js" type="text/javascript"></script>
	<script src="js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
	<script src="js/lightbox.js" type="text/javascript"></script>
    
    <script language="javascript" type="text/javascript">
	
	function putDem()
	{
		var tr = "<?php echo $itemcategory; ?>";
		for( var i=0, limit=document.getElementById('itemcategory').options.length; i < limit; ++i )
		{
			if( document.getElementById('itemcategory').options[i].value==tr )
				document.getElementById('itemcategory').options[i].selected=true;
		}
	}
	
	</script>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px" onload="putDem()">
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
        
        <h2 align="center">EDIT ITEM</h2>
<form method="post" enctype="multipart/form-data" name="f1">
<table align="center">
	<tr>
    	<td>Item Code: </td><td><input name="itemcode" id="itemcode" value="<?php echo $itemcode; ?>" readonly maxlength="25" /></td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td>Item Name: </td><td><input name="itemname" maxlength="250" value="<?php echo $itemname; ?>" required /></td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td>Item Description: </td><td><textarea name="itemdescription" required ><?php echo $itemdescription; ?></textarea></td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td>Item Category: </td>
        <td>
        	<select name="itemcategory" id="itemcategory">
            	<option value="">Select Category
            	<?php
					$rst = mysql_query("select cat_id, cat_name from categories order by cat_name") or die(mysql_error());
					
					while($row = mysql_fetch_array($rst))
					{
						echo "<option value='".$row['cat_id']."'>".trim(stripslashes($row['cat_name']));
					}
				?>
            </select>
        </td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td>Item Cost Price: </td><td><input name="itemcostprice" size="5" required value="<?php echo $itemcostprice; ?>"  /></td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td>Item Price: </td><td><input name="itemprice" size="5" required value="<?php echo $itemprice; ?>"  /></td>
    <tr>
    	<td>Item Wholesale Price: </td><td><input name="itemwprice" size="5" required value="<?php echo $itemwprice; ?>"  /></td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td>Item Quantity: </td><td><input name="itemquantity" size="5" value="<?php echo $itemquantity; ?>" required  /></td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td>Re-order point: </td><td><input name="reorderpoint" value="<?php echo $reorderpoint; ?>" maxlength="6" /></td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
        <td>Expiry Date: </td><td><input name="expirydate" value="<?php echo $expirydate ?>" maxlength="10"></td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td>Item Image: </td>
        <td>
        	<input type="hidden" name="MAX_FILE_SIZE" value="262144000"/>
        <input type="file" name="file" />
            <a href='<?php echo $itemimage; ?>' title='<?php echo $itemdescription; ?>' rel='lightbox[baby2]'><img src='images/view.png' border=0 title='View Item Image' /></a>
        </td>
    <tr>
    	<td colspan="2"><hr /></td>
    <tr>
    	<td colspan="2" align="center"><input type="submit" value="Save Changes" name="ai" /></td>
    
</table>
</form>
        
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
