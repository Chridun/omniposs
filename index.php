<?php
session_start();

include("chkdte.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0014)about:internet -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>OmniPOSS ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">td img {display: block;}</style>
<!--Fireworks CS5 Dreamweaver CS5 target.  Created Fri Mar 27 11:48:58 GMT+0100 2015-->
<script type="text/javascript" src="jquery.js"></script>

<script language="javascript" type="text/javascript">

</script>
</head>
<body bgcolor="#ffffff" onload="document.getElementById('uname').focus()">
<table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="1280">
<!-- fwtable fwsrc="MyQLifestyle_PoSS(1).png" fwpage="Landing Page" fwbase="login.png" fwstyle="Dreamweaver" fwdocid = "1524505273" fwnested="0" -->
  <tr>
   <td><img src="images/spacer.gif" width="843" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="129" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="106" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="202" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
   <td colspan="4"><img name="login_r1_c1" src="images/login_r1_c1.png" width="1280" height="326" border="0" id="login_r1_c1" alt="" /></td>
   <td><img src="images/spacer.gif" width="1" height="326" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="6"><img name="login_r2_c1" src="images/login_r2_c1.png" width="843" height="372" border="0" id="login_r2_c1" alt="" /></td>
   <td colspan="2"><input name="uname" id="uname" style="width:200px; height:40px; border:none" /></td>
   <td rowspan="6"><img name="login_r2_c4" src="images/login_r2_c4.png" width="202" height="372" border="0" id="login_r2_c4" alt="" /></td>
   <td><img src="images/spacer.gif" width="1" height="55" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="2"><img name="login_r3_c2" src="images/login_r3_c2.png" width="235" height="18" border="0" id="login_r3_c2" alt="" /></td>
   <td><img src="images/spacer.gif" width="1" height="18" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="2"><input type="password" name="pwd" id="pwd" style="width:200px; height:40px; border:none" /></td>
   <td><img src="images/spacer.gif" width="1" height="55" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="2"><img name="login_r5_c2" src="images/login_r5_c2.png" width="235" height="18" border="0" id="login_r5_c2" alt="" /></td>
   <td><img src="images/spacer.gif" width="1" height="18" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="2"><img name="login_r6_c2" src="images/login_r6_c2.png" width="129" height="226" border="0" id="login_r6_c2" alt="" /></td>
   <td><input type="image" src="images/login_r6_c3.png" width="106" height="46" border="0" id="login" name="login" alt="Login" onclick="getIt()" /></td>
   <td><img src="images/spacer.gif" width="1" height="46" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img name="login_r7_c3" src="images/login_r7_c3.png" width="106" height="180" border="0" id="login_r7_c3" alt="" /></td>
   <td><img src="images/spacer.gif" width="1" height="180" border="0" alt="" /></td>
  </tr>
</table>

<script type="text/javascript" language="javascript">

$('#login').click(function()
       {
          if(document.getElementById('uname').value.length < 1)
			{
				alert('Username expected!');	
				document.getElementById('uname').focus();
			}
			else if(document.getElementById('pwd').value.length < 1)
			{
				alert('Password expected!');
				document.getElementById('pwd').focus();
			}
		  	else
			{
		  		$.get(
                 'login.php',
                 { i: document.getElementById('uname').value+"^"+document.getElementById('pwd').value },
                 function(data)
                 {
                   //$('#result').html(data);
				   //alert(data);
				   if(data == "2")
				   {
				   		alert("Login details incorrect!");
						document.getElementById('uname').focus();
						document.getElementById('uname').select();
				   }
				   else if(data == "1")
				   {
				   		location.replace('sales.php');
				   }
				   
                 });
			}
		  
		 
		//alert("wahala dey o");
	  //alert(document.getElementById('total_1').id);
	  
		 
	  //finito(cnt);
	  
	  
	  //}
	  
    });
	
//});

</script>
</body>
</html>
