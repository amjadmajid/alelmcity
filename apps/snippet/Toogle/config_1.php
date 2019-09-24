<?php
// Create connection
$con=mysqli_connect("ToogleSearchdb.db.11733015.hostedresource.com","ToogleSearchdb","Nothing@82","ToogleSearchdb");
mysqli_select_db($con,'ToogleSearchdb');

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>