<?php
ob_start();
// header("Content-type: text/html; charset=utf-8"); 
session_start();
require_once('db/database.php');
$conn = db_connect();
$conn->set_charset("utf8");

// require("../../connect_db_1.php");
require_once('functions.php');
require_once('validation_functions.php');
require_once('db/db_functions.php');
require_once('Parsedown.php');

$parsedown = new Parsedown();
$error = [];
?>