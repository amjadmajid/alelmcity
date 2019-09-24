<?php
ob_start();
header("Content-type: text/html; charset=utf-8"); 
session_start();
if(!isset($_SESSION['allowed']) || $_SESSION['allowed'] != 1 )
   {
  header("location: login_1.php");
  exit();
   }
?>

<?php
include_once('connect_db_1.php');
  if( mysqli_real_escape_string($conn ,$_POST['send']) =='sendMe'){
     $lang = mysqli_real_escape_string($conn ,$_POST['language']);
     $snip_t = mysqli_real_escape_string($conn ,$_POST['snippet_title']);
     $snip = mysqli_real_escape_string($conn ,$_POST['snippet']);
     $snipCode = mysqli_real_escape_string($conn ,$_POST['snippetCode']);
     if (!empty($snipCode) ){
      $snip = $snipCode;
     }
     $snip_desc = $_POST['snippet_desc'];
  $sql = "INSERT INTO snippet_table (lang, snippet_title, snippet_desc , snippet)
  VALUES ('$lang', '$snip_t', '$snip_desc' , '$snip')";

  if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";

      header("location: index.php?lang=$lang" );

  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}
mysqli_close($conn);

?>


<!DOCTYPE html>
<html>
<head>
  <script src="javaScript_1/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
  tinymce.init({
    selector: '#snippetId'
  });
  </script>

  <title></title>
</head>
<body>



<form action="backend_page.php" method="POST">
  Language name:<br>
  <input cols="70"  type="text" name="language" value="<?php  if( isset( $_GET['lang'] ) ) { echo htmlspecialchars($_GET['lang']); }?>">
  <br>
  snippet title:<br>
  <input  style="width:200px;" type="text" name="snippet_title">
  <br>
  snippet description:<br>

  <textarea cols="90" rows="5" name="snippet_desc"></textarea>
  snippet Code:<br>
  <textarea cols="90" rows="20" id="snippet" name="snippetCode"></textarea>
  <br>
  <!-- <br>
  snippet:<br>
  <textarea cols="70" rows="20" id="snippetId" name="snippet"></textarea>
  <br> -->
  <input id="submit" type="submit" value="sendMe" name="send">
  </form>

</body>
</html>

<script src="javaScript_1/textarea.js"></script>

<?php
ob_end_flush();
?>