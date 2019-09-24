<?php
session_start();
$_SESSION['allowed'] = null;
header("Location: index.php");	
exit();
?>