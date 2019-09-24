<?php
  
  require_once('db_credentials.php');

// connect to the database 
  function db_connect() {
    $mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      exit;
      }
      // else{
      //   echo "Connected";
      // }

      return $mysqli;
  }


?>
