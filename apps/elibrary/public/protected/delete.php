<?php require('../../private/initialize.php'); ?>
<?php  
if(!isset($_SESSION['allowed']) || $_SESSION['allowed'] != 1 )
{
  header("location: reg_access/login.php");
  exit();
}

if(is_get_request()){
   $shelfid   = isset($_GET['sid']) ? $_GET['sid'] : "";
   $bookid    = isset($_GET['bid']) ? $_GET['bid'] : "";
   $chapterid = isset($_GET['cid']) ? $_GET['cid'] : "";

   $shelf   = isset($_GET['s']) ? $_GET['s'] : "";
   $book    = isset($_GET['b']) ? $_GET['b'] : "";
   $chapter = isset($_GET['c']) ? $_GET['c'] : "";


   if(!is_blank($shelfid) && !is_blank($bookid) && !is_blank($chapterid))
   {
   	// delete a chapter and its content only
   	delete_chapter_by_chapterid($chapterid);

   }else if(!is_blank($shelfid) && !is_blank($bookid))
   {
   	// delete a book and all the associated chapters and chapter content
	   	// 2- delete all the chapters
		delete_chapters_by_bookid($bookid);
		// 3- delete the book 
		delete_book_by_id($bookid);

   }else if(!is_blank($shelfid))
   {
   	// delete a shelf with all associated books and their chapters and chapters' contents

   		// 1- select all the books ids
   	   	$booksids = find_booksIds_by_shelf_id($shelfid);
   	   	// print_r($booksids);
   	   	for ($i=0; $i < count($booksids) ; $i++) 
   	   	{ 
   	   		// 2- delete all the chapters
   	   		delete_chapters_by_bookid($booksids[$i]);
   	   		// 3- delete the book 
   	   		delete_book_by_id($booksids[$i]);
   	   	}

   	   	// 4- delete the shelf
   	   	/* This is outside the loop in order to enable deleting the shelf name 
   	   	   even if it does not have books (empty) */
   	   	delete_shelf_by_id($shelfid);

   }
 }
    // redirect to index.php
   header("location: ../index.php");




   