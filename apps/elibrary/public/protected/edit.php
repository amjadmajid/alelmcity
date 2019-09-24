<?php require('../../private/initialize.php'); ?>
<?php  
if(!isset($_SESSION['allowed']) || $_SESSION['allowed'] != 1 )
{
  header("location: reg_access/login.php");
  exit();
}
  /*
  ToDo

  1- Can you enforce name uniquness for shelfs of the same library, the books of the same shelf, or chapter for the same book
    # a possible solution is to query the database with `select` and test the response for the existness of the record. 
  2- The library id represents the user and must be obtained from the session
  ------------------------------------------------------------------------------------------------*/

?>

<?php

  if(is_get_request()){
   $shelfid   = isset($_GET['sid']) ? $_GET['sid'] : "";
   $bookid    = isset($_GET['bid']) ? $_GET['bid'] : "";
   $chapterid = isset($_GET['cid']) ? $_GET['cid'] : "";

   $shelf   = isset($_GET['s']) ? $_GET['s'] : "";
   $book    = isset($_GET['b']) ? $_GET['b'] : "";
   $chapter = isset($_GET['c']) ? $_GET['c'] : "";

}


?>

<?php
if(is_post_request()){
   $shelf   = $_POST['shelf'];
   $book    = $_POST['book'];
   $chapter = $_POST['chapter'];
   $content = $_POST['content'];

   $shelfid   = $_POST['shelfid'];
   $bookid    = $_POST['bookid'];
   $chapterid = $_POST['chapterid'];


   if( !is_blank($shelfid) && !is_blank($bookid) && !is_blank($chapterid) ) {

    update_chapter($chapter,$content, $chapterid);
    header("location: ../index.php?sid=".$shelfid.
      "&s=".$shelf."&bid=".$bookid."&cid=".$chapterid."&c=".$chapter );
    exit();

  }
  else if( !is_blank($shelfid) && !is_blank($bookid) )
  {

    // move the book to a new shelf if the shelf name has changed  
    // and the new shelf name exist in the db

    // get shelf id by shelf name 
    if(!is_blank($shelf)){
      $db_shelfid = find_shelfid_by_shelfname($shelf);
      echo "db shelf id : $db_shelfid";

      // if the shelfid does not match the old one then update the shelfid for this book
      if($db_shelfid && ($db_shelfid != $shelfid))
      {
        // move the book to the new shelf
        move_book_to_new_shelf($bookid, $db_shelfid);
      }
    }

    update_book($book, $bookid);
    header("location: ../index.php?sid=".$shelfid.
      "&s=".$shelf."&bid=".$bookid);
    exit();

  }
  else if(!is_blank($shelfid))
  {

    update_shelf($shelf, $shelfid);
    header("location: ../index.php");
    exit();

  }
}
?>


<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/form.css">
  <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>

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

<!-- TODO Decide what to show based on the fields need to be edited (shelf/book/chapter)-->
  <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
    Shelf name:
    <input type="text" name="shelf"       value="<?php echo h($shelf); ?>">
    <?php if( !is_blank($shelfid) ){
      echo '<input type="hidden" name="shelfid"  value="'.trim(h($shelfid)).'" >';
    }?>
    <br>
    Book name:
    <input type="text" name="book"        value="<?php echo h($book); ?>">
    <?php if( !is_blank($bookid) ){
      echo '<input type="hidden" name="bookid"    value="'.trim(h($bookid)).'">';
    }?>
    <br>
    Chapter name:
    <input type="text" name="chapter"     value="<?php echo h($chapter); ?>">
    <?php if( !is_blank($chapterid) ){
      echo '<input type="hidden" name="chapterid" value="'.trim(h($chapterid)).'">';
    }?>
    <br>
    Content:<br>
    <textarea id="content" name="content"></textarea>
    <pre style="display: hidden" id="editText"><?php echo find_content_by_chapterid($chapterid);?> </pre>
    <br>
    <input type="submit" value="Submit" >
  </form>

</body>
</html>

<script src="../js/form.js"></script>

<?php
ob_end_flush();
?>