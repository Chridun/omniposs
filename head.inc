<?php 

echo ", ".$_SESSION['fname']; 

switch($_SESSION['role'])
{
	case "sadmin":
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SUPER ADMINISTRATOR";
	break;
	
	case "admin":
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ADMINISTRATOR";
	break;
	
	case "accountant":
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ACCOUNTANT";
	break;
	
	case "user":
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; POSS USER";
	break;
}

?>

