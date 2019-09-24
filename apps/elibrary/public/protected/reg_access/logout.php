<?php
require_once('../../../private/initialize.php'); 

unset($_SESSION['allowed']);
unset($_SESSION['libraryid']);
unset($_SESSION['libraryname']);

header("location: login.php");
?>