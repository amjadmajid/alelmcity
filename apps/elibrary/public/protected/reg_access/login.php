<?php require('../../../private/initialize.php'); ?>
<?php  
if(isset($_SESSION['allowed']) )
{
  header("location: ../../index.php");
  exit();
}?>


<?php

if(is_post_request())
{

  $username = isset($_POST['name'])		? $_POST['name'] 		: '';
  $password = isset($_POST['password']) ? $_POST['password'] 	: '';

  // Validations
  if(is_blank($username)) {
    $error[] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $error[] = "Password cannot be blank.";
  }

  if(empty($error))
  {
  	// Using one variable ensures that msg is the same
    $login_failure_msg = "Log in was unsuccessful.";

    $user = find_user_by_username( strtolower($username));

    // print_r($user);
    // exit;

    if($user)
    {
    	// echo crypt($password, $user['password']);
    	// echo '<br>';
    	// echo  $user['password'];

	    if( password_verify($password, $user['password'] ))
	    {
	    	session_regenerate_id();
	    	$_SESSION['allowed'] = 1;
	    	$_SESSION['libraryid'] = $user['libraryid'];
	    	$_SESSION['libraryname'] = $user['libraryname'];
	    	// redirect
	    	header("location: ../../index.php");
	    }else{
	    	$error[] = $login_failure_msg ;
	    }
    }else{
    	$error[] = $login_failure_msg ;
    }

  }


}
?>

<!DOCTYPE html>
<html>
<head>

  <link rel="stylesheet" type="text/css" href="../../css/form.css">
  <link rel="stylesheet" type="text/css" href="../../css/main.css">
  <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

  <form action="login.php" method="POST">
    User name:
    <input type="text" name="name">
    <br>
    Password:
    <input type="password" name="password">
    <br>

    <input type="submit" value="Submit" >
  </form>
  <p> Or <a href="signup.php">Singup</a></p>

</body>
</html>

