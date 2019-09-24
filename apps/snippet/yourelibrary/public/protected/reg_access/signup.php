<?php require('../../../private/initialize.php'); ?>
<?php  
if(!isset($_SESSION['allowed']) || $_SESSION['allowed'] != 1 )
{
  header("location: ../../../login_1.php");
  exit();
}?>

<?php
// TODO
/*
1- password matching check
2- password encryption
3- error displaying
4- email confirmation
5- redirect to login
6- allow access without authentication to this page
7- if the user is already logged in then redirect him to index.php
8- check if uniquenss of the library name
------------------------------------------------------------------*/
?>

<?php

if(is_post_request()){

 $lib     = $_POST['libraryname'];
 $name    = $_POST['name'];
 $paswd   = $_POST['password'];
 $con_paswd   = $_POST['confirm_password'];
 $email   = $_POST['email'];

 // validate the info 
 // 1- required fields
 if(is_blank($lib)) { $error[] = "Library name filed cannot be empty" ;}
 if(is_blank($name)) { $error[] = "User name filed cannot be empty" ;}
 if(is_blank($paswd)) { $error[] = "Password filed cannot be empty" ;}
 if(is_blank($con_paswd)) { $error[] = "Confirm password filed cannot be empty" ;}
 if(is_blank($email)) { $error[] = "Email filed cannot be empty" ;}
 // 2- match passwords
  if( ($paswd != $con_paswd) && !is_blank($paswd) && !is_blank($con_paswd) ) { $error[] = "Passwords do not match" ;}
 //3- encrypt password (password_hash requires php +5.5 )
  // $encrypt_paswd = password_hash($paswd, PASSWORD_BCRYPT);
  $encrypt_paswd = crypt($paswd);

 //4- validate email
  if(!has_valid_email_format($email)){$error[] = "You must enter a validate email" ;}

//TODO you need to decide on which name (library or user) must be unique

if(empty($error))
{
  $stmt = $conn->prepare("INSERT INTO libraries (libraryname, username, password, email)  VALUES (?,?,?,?)");
  $stmt->bind_param("ssss",$lib, $name, $encrypt_paswd, $email );
  $stmt->execute() ; 
  $stmt->close();
}

}

?>


<!DOCTYPE html>
<html>
<head>

  <link rel="stylesheet" type="text/css" href="../../css/form.css">
  <link rel="stylesheet" type="text/css" href="../../css/main.css">
  <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
  <title>
    Signup
  </title>
</head>
<body>

      <?php
      if(!empty($error) )
      {
        echo "<div class='error'>";
        for($i=0; $i < count($error); $i++)
        {
          echo $error[$i];
          echo"<br>";
        }
        echo "</div>";
      }
    ?>

  <form action="signup.php" method="POST">
    User name:
    <input type="text" name="name">
    <br>
    Password:
    <input type="password" name="password">
    <br>
    Confirm password:
    <input type="password" name="confirm_password">
    <br>
    Email:
    <input type="text" name="email">
    <br>
    Library name:<br>
    <input type="text" name="libraryname">
    <br>
    <input type="submit" value="Submit" >
  </form>

</body>
</html>



<?php
ob_end_flush();
?>