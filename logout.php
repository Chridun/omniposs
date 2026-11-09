<?php
session_start();
$_SESSION['uname'] = "";
$_SESSION['fname'] = "";
$_SESSION['role'] = "";
session_destroy();

header("Location: index.php");
?>