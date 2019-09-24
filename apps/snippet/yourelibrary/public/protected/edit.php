<?php require('../../private/initialize.php'); ?>
<?php  
if(!isset($_SESSION['allowed']) || $_SESSION['allowed'] != 1 )
{
  header("location: ../../../login_1.php");
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
  $libraryid = 1; 

  if(is_get_request()){
   $shelfid   = $_GET['sid'];
   $bookid    = $_GET['bid'];
   $chapterid = $_GET['cid'];

   $shelf   = $_GET['s'];
   $book    = $_GET['b'];
   $chapter = $_GET['c'];
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


      if(  !is_null($chapterid) ) {
        echo "in chapter insertion!!<br>";
        $chapter_stmt = $conn->prepare("UPDATE chapters SET chaptername=?,chaptercontent=? WHERE chapterid=?");
        $chapter_stmt->bind_param("ssi", $chapter,$content, $chapterid);
        if($chapter_stmt->execute()){
          echo 'the chapter has been updated';
        }
        $chapter_stmt->close();
      }

      //     if(empty($error) )
      // {
        header("location: ../index.php");
        exit();
      // }
    }
?>

   <?php

   // echo "shelf: $shelf <br>";
   // echo "book: $book <br>";
   // echo "chapter: $chapter <br>";
   // echo "content: $content <br>";

   // echo "shelfid: $shelfid <br>";
   // echo "bookid: $bookid <br>";
   // echo "chapterid: $chapterid <br>";

  ?>


  <!DOCTYPE html>
  <html>
  <head>
      <link rel="stylesheet" type="text/css" href="../css/form.css">
      <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
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
    
    <form action="edit.php" method="POST">
      Shelf name:
      <input type="text" name="shelf"       value="<?php echo h($shelf); ?>">
      <?php if( !is_null($shelfid) ){
        echo '<input type="hidden" name="shelfid"  value="'.trim(h($shelfid)).'" >';
      }?>
      <br>
      Book name:
      <input type="text" name="book"        value="<?php echo h($book); ?>">
      <?php if( !is_null($bookid) ){
        echo '<input type="hidden" name="bookid"    value="'.trim(h($bookid)).'">';
      }?>
      <br>
      Chapter name:
      <input type="text" name="chapter"     value="<?php echo h($chapter); ?>">
      <?php if( !is_null($chapterid) ){
        echo '<input type="hidden" name="chapterid" value="'.trim(h($chapterid)).'">';
      }?>
      <br>
      Content:<br>

      <textarea id="content" name="content"><?php echo find_content_by_chapterid($chapterid);?></textarea>
      <br>
      <input type="submit" value="Submit" >
    </form>

  </body>
  </html>



  <?php
  ob_end_flush();
  ?>