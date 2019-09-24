<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Snippet</title>
</head>

<body>

<?php
  include_once('../connect_db_1.php'); 
    if( isset($_GET['lang'])  && isset( $_GET['id'] ) ){ 
        
        $id = mysqli_real_escape_string($conn ,$_GET['id']);
        $lang = mysqli_real_escape_string($conn ,$_GET['lang']);   
        
        echo $id;
        echo $lang ;

        $sql1 = "SELECT * FROM snippet_table WHERE lang='".$lang."' AND id=".$id;

        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
        $row1 = $result1->fetch_assoc()
?>

  <form action="edit.php" method="POST">
      Language name:
    <br>
    <input type="text" name="language" value="<?php  echo $row1['lang']; ?>" > 
    <br>
      snippet title:
    <br>
    <input type="text" name="snippet_title" value="<?php  echo htmlspecialchars($row1['snippet_title']); ?>" >
    <br>
      snippet description:
    <br>
    <textarea cols="70" rows="5" name="snippet_desc"><?php  echo htmlspecialchars($row1['snippet_desc']); ?></textarea>
    <br>
      snippet:
    <br>
    <textarea cols="70" rows="35" name="snippet"><?php  echo stripslashes($row1['snippet']); ?> </textarea>
    <br>
    <input type="submit" value="sendMe" name="send">
    <input type="hidden" value=" <?php  echo $id; ?>" name="id">
  </form>


<?php

        } 
    }
?>


<?php
if( mysqli_real_escape_string($conn ,$_POST['send']) =='sendMe'){
   $lang = mysqli_real_escape_string($conn ,$_POST['language']);
   $snip_t = mysqli_real_escape_string($conn ,$_POST['snippet_title']);
   $snip = mysqli_real_escape_string($conn ,$_POST['snippet']);
   $id = mysqli_real_escape_string($conn ,$_POST['id']);
   $snip_desc =  mysqli_real_escape_string($conn , $_POST['snippet_desc']);

$sql = "UPDATE snippet_table  SET lang='".$lang."', snippet_title='".$snip_t."', snippet_desc='".$snip_desc ."', snippet='".$snip."' WHERE id=".$id;

if (mysqli_query($conn, $sql)) {
      echo "The record has been updated successfully";

      header("location: ../index.php?lang=$lang");
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}
mysqli_close($conn);


ob_end_flush();
?>


</body>
</html>