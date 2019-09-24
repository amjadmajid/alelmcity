<?php
ob_start();
header("Content-type: text/html; charset=utf-8"); 
session_start();
require("../../connect_db_1.php");
require('functions.php');
require('validation_functions.php');
require('db/db_functions.php');
require_once('Parsedown.php');
$parsedown = new Parsedown();
$error = [];
?>