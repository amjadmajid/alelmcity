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
  $libraryid = $_SESSION['libraryid']; 

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

    /* Inserting new records
    -------------------------*/
    // check for fatal errors first
    if( !fatal_insertion_error($shelf, $book, $chapter)  ){
      echo "NO FATAL ERROR";

      // is shelfid is set that means the user wants to add a book or a chapter or a paper
      // and not to create a new shelf
      if( is_null($shelfid) ){
        echo "in shelf insertion!!<br>";
        $shelf_query = "INSERT INTO shelves  (shelfname  , libraryid)  VALUES (?,?)";
        if( !($shelf_stmt = $conn->prepare($shelf_query))) { $error[] = "shelf preparation statement failed!"; }
        if( !($shelf_stmt->bind_param("si",$shelf, $libraryid ))) {$error[] = "shelf params binding failed!"; }
        if($shelf_stmt->execute()){
          echo 'a new shelf has been added';
        }
        $shelfid = $shelf_stmt->insert_id;

        $shelf_stmt->close();
      }

      // Test
      if(is_numeric($shelfid)){echo 'is_numeric($shelfid) is integer'; }else{echo 'NOT is_numeric($shelfid) is integer<br>'. var_dump($shelfid);}

      // is bookid is set that means the user wants to add a chapter or a paper
      // and not to create a new book
      if( !is_blank($book)  && is_numeric($shelfid) && is_null($bookid) )  {
        echo "in book insertion!!<br>";
        $book_stmt =  $conn->prepare("INSERT INTO books    (bookname   , shelfid)   VALUES (?,?)");
        $book_stmt->bind_param("si", $book, $shelfid);
        if($book_stmt->execute()){
          echo 'a new book has been added';
        }
        $bookid = $book_stmt->insert_id;
        $book_stmt->close();
      }

      // is chapterid is set that means the user wants to update a paper
      // and not to create a new chapter
      if( !is_blank($chapter) && is_numeric($bookid) && is_null($chapterid) ) {
        echo "in chapter insertion!!<br>";
        $chapter_stmt = $conn->prepare("INSERT INTO chapters (chaptername,chaptercontent, bookid)  VALUES (?,?,?)");
        $chapter_stmt->bind_param("ssi", $chapter,$content, $bookid);
        if($chapter_stmt->execute()){
          echo 'a new chapter has been added';
        }
        $chapter_stmt->close();
      }
    }
    // Check for errors
    if( is_blank($shelf) ){
        $error[] = "Shelf name can not be blank!";
      }
    if( is_blank($book) && !is_blank($chapter) ){
        $error[] = "Book name can not be blank and you want to add/update a chapter";
      }
    
    if(empty($error) )
      {
        header("location: ../index.php");
        exit();
      }

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
    
    <form action="new.php" method="POST">
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
      <textarea id="content" name="content"></textarea>
      <br>
      <input type="submit" value="Submit" >
    </form>

  </body>
  </html>



  <?php
  ob_end_flush();
  ?>