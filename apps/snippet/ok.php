<?php
  ob_start(); // to use redirection in the middle of the page
  session_start(); // to enable session usage 
  include("connect_db_1.php"); // Database connection
  // Check if the serssion is set 
  if( isset( $_SESSION['allowed']) ) 
  {
    header("Location: backend_page.php");
    exit();
  }
  $name=$error =""; // initialize some variables
// check if the form is submitted 
  if(isset($_POST['submit']))
  {
      // validate the user input 
      $name =  mysqli_real_escape_string( $conn , htmlentities( trim( sha1(sha1($_POST['name'])) ) ) ) ;
      ###  TODO  ### - encrypt the password
      $pwd =   mysqli_real_escape_string( $conn , htmlentities( trim(sha1( sha1($_POST['pwd']) ) ) ) ) ;
      // max allowed length is 100 and the minimum is 1
      ( isset($name) && (strlen($name) < 100) && strlen($name)  > 1 )? : $error = 1; 
      ( isset($pwd) && (strlen($pwd) < 100) && strlen($pwd) > 1 )?  :$error = 1; 
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Login</title>
      <meta charset="utf-8">
  </head>
  <body>

  <div class="container">
    <h2>Login Please: </h2>
  <?php
    if(isset($_POST['submit'])){
        if($error != ""){
          echo "<div style='border:1px solid red; padding 5px; width:200px; text-align:center; color:red;'> 
                            Form error please try again! </div>";
        }else{
          // check the user with database 
            $query = "SELECT * FROM admin_table " ;
            $query .= " WHERE username_1 = '" . $name . "' && password_1 = '" . $pwd."'" ;
            $results = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($results);
            if( !is_null($row['username_1']) && strlen($row['password_1']) > 0 && $row['password_1'] != "" ){
              // put the credientials in the session
              
              $_SESSION['name'] =  $row['username_1'];
              $_SESSION['pwd'] =  $row['password_1'];
              $_SESSION['allowed'] = 1 ; 
              header("Location: index.php");
              exit();
            }else{
              echo "<h3> User not found, please try again </h3>";
            }
        }
      }
  ?>
    <form action=""  role="form" method="post">
      <div class="form-group">
        <label  for="name">Name:</label>
        <div>
          <input type="Name" class="form-control" name="name" placeholder="Enter name"
                 value="<?php echo $name; ?>" >
        </div>
      </div>
      <div class="form-group">
        <label  for="pwd">Password:</label>
        <div >          
          <input type="password" class="form-control" name="pwd" placeholder="Enter password">
        </div>
      </div>
      <div class="form-group">        
        <div>
          <button type="submit" name="submit" value="Submit" class="btn btn-default">Submit</button>
        </div>
      </div>
    </form>
  </div>

  </body>
</html>

<?php
ob_end_flush();
?>