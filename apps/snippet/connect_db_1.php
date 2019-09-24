<?php
$servername = "snippetdb1.db.9262905.67f.hostedresource.net";
$username = "snippetdb1";
$password = "NoorAli@1";
$dbname = "snippetdb1";

// Create connection
$conn = new mysqli($servername, $username, $password , $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

?>