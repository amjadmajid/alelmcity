<?php
	// require("../initialize.php");

	function find_shelfid_by_shelfname($shelf)
	{
	  global $conn;
	  // prepare statement
	  $stmt = $conn->stmt_init();
	  $stmt->prepare("SELECT shelfid FROM shelves WHERE shelfname=?");
	  $stmt->bind_param("s", $shelf);
	  $stmt->execute();
	  // https://stackoverflow.com/questions/8321096/call-to-undefined-method-mysqli-stmtget-result
	  // $result = $stmt->get_result();

	  // to check if you get any records from the database
	  $stmt->store_result();
	  if($stmt->num_rows() > 0 ){
		$stmt->bind_result($shelfid);
		$stmt->fetch();
		$stmt->close();
		return $shelfid;
		}
		return false;
	}

	function find_shelves_by_lib_id($libid) {
	  global $conn;
	  // prepare statement
	  $stmt = $conn->stmt_init();
	  $stmt->prepare("SELECT shelfid, shelfname FROM shelves WHERE libraryid=?");
	  $stmt->bind_param("i", $libid);
	  $stmt->execute();
	  // https://stackoverflow.com/questions/8321096/call-to-undefined-method-mysqli-stmtget-result
	  // $result = $stmt->get_result();

	  // to check if you get any records from the database
	  $stmt->store_result();
	  // if($stmt->num_rows() < 1 ){}
	  $stmt->bind_result($shelfid, $shelf);
	  $results =[];

		while($stmt->fetch()){

			$results['shelfid'][] = $shelfid;
			$results['shelf'][] = 	$shelf;
			$results['libraryid'][] = $libid;
		}
		$stmt->close();

	  return $results;
	}

	function find_books_by_shelf_id($id) {
	  global $conn;
	  // prepare statement
	  $stmt = $conn->stmt_init();
	  $stmt->prepare("SELECT bookid, bookname FROM books WHERE shelfid=?");
	  $stmt->bind_param("i", $id);
	  $stmt->execute();
	  // https://stackoverflow.com/questions/8321096/call-to-undefined-method-mysqli-stmtget-result
	  // $result = $stmt->get_result();

	  // to check if you get any records from the database
	  $stmt->store_result();
	  // if($stmt->num_rows() < 1 ){}
	  $stmt->bind_result($bookid, $book);
	  $results =[];

		while($stmt->fetch()){

			$results['bookid'][] = 	$bookid;
			$results['book'][] = 	$book;
			$results['shelfid'][] = $id;
		}
		$stmt->close();

	  return $results;
	}


	function find_booksIds_by_shelf_id($id) {
	  global $conn;
	  // prepare statement
	  $stmt = $conn->stmt_init();
	  $stmt->prepare("SELECT bookid FROM books WHERE shelfid=?");
	  $stmt->bind_param("i", $id);
	  $stmt->execute();
	  // https://stackoverflow.com/questions/8321096/call-to-undefined-method-mysqli-stmtget-result
	  // $result = $stmt->get_result();

	  // to check if you get any records from the database
	  $stmt->store_result();
	  // if($stmt->num_rows() < 1 ){}
	  $stmt->bind_result($bookid);
	  $results =[];

		while($stmt->fetch()){

			$results['bookid'][] = 	$bookid;
		}
		$stmt->close();

	  return $results;
	}

	function find_chapters_by_book_id($id) {
	  global $conn;
	  // prepare statement
	  $stmt = $conn->stmt_init();
	  $stmt->prepare("SELECT chapterid, chaptername FROM chapters WHERE bookid=?");
	  $stmt->bind_param("i", $id);
	  $stmt->execute();
	  // https://stackoverflow.com/questions/8321096/call-to-undefined-method-mysqli-stmtget-result
	  // $result = $stmt->get_result();

	  // to check if you get any records from the database
	  $stmt->store_result();
	  // if($stmt->num_rows() < 1 ){}
	  $stmt->bind_result($chapterid, $chapter);
	  $results =[];

		while($stmt->fetch()){

			$results['chapterid'][] = $chapterid;
			$results['chapter'][] =  $chapter;
			$results['bookid'][] = $id;
		}
		$stmt->close();

	  return $results;
	}

	function find_content_by_chapterid($id) {
	  global $conn;
	  // prepare statement
	  $stmt = $conn->stmt_init();
	  $stmt->prepare("SELECT chaptercontent FROM chapters WHERE chapterid=?");
	  $stmt->bind_param("i", $id);
	  $stmt->execute();
	  // https://stackoverflow.com/questions/8321096/call-to-undefined-method-mysqli-stmtget-result
	  // $result = $stmt->get_result();

	  // to check if you get any records from the database
	  $stmt->store_result();
	  if($stmt->num_rows() > 0 ){
	  		$stmt->bind_result($content);
		}else{
			$content=false;
		}
	  $stmt->fetch();
	  $stmt->close();

	  return $content;
	}

	/*
		user authentication related functions
	-------------------------------------------*/

	function find_user_by_username($name){
	  global $conn;
	  // prepare statement
	  $stmt = $conn->stmt_init();
	  $stmt->prepare("SELECT libraryname, username, password, libraryid FROM libraries WHERE username=?");
	  $stmt->bind_param("s", $name);
	  $stmt->execute();
	  $stmt->store_result();
	  if($stmt->num_rows() > 0 ){
	  		$stmt->bind_result($libraryname, $username, $password, $libraryid);
		}else{
			$stmt->close();
			return false;
		}
	  $stmt->fetch();
	  $stmt->close();

	  return ['libraryname' => $libraryname, 'username' => $username, 'password' => $password, 'libraryid' => $libraryid];

	}

/* ----> DELETE
---------------------*/

function delete_chapter_by_chapterid($id){
	global $conn;
	$stmt = $conn->prepare("DELETE FROM chapters WHERE chapterid=? LIMIT 1");
	if(!$stmt) 
	{
		echo "Can't delete the chapter"; 
		return; 
	}
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
      echo 'the chapter has been delete';
    }
    $stmt->close();
}

function delete_chapters_by_bookid($id){
	global $conn;
	$stmt = $conn->prepare("DELETE FROM chapters WHERE bookid=?");
	if(!$stmt) 
	{
		echo "Can't delete the chapter"; 
		return; 
	}
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
      echo 'the chapter has been delete<br>';
    }
    $stmt->close();
}

function delete_book_by_id($id){
	global $conn;
	$stmt = $conn->prepare("DELETE FROM books WHERE bookid=? LIMIT 1");
	if(!$stmt) 
	{
		echo "Can't delete the book"; 
		return; 
	}
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
      echo 'the book has been delete<br>';
    }
    $stmt->close();

	   	}

function delete_shelf_by_id($id){
	global $conn;
	$stmt = $conn->prepare("DELETE FROM shelves WHERE shelfid=? LIMIT 1");
	if(!$stmt) 
	{
		echo "Can't delete the shelf"; 
		return; 
	}
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
      echo 'the shelf has been delete';
    }
    $stmt->close();

}


/*	------> UPDATE
-----------------------------*/

function update_chapter($chapter,$content, $chapterid){
	global $conn;
    $stmt = $conn->prepare("UPDATE chapters SET chaptername=?,chaptercontent=? WHERE chapterid=?");
    	if(!$stmt) 
	{
		echo "Can't updated the chapter"; 
		return; 
	}
    $stmt->bind_param("ssi", $chapter,$content, $chapterid);
    if($stmt->execute()){
      echo 'the chapter has been updated';
    }
    $stmt->close();
}


function update_book($book, $bookid){
	global $conn;
    $stmt = $conn->prepare("UPDATE books SET bookname=? WHERE bookid=?");
    	if(!$stmt) 
	{
		echo "Can't updated the book"; 
		return; 
	}
    $stmt->bind_param("si", $book,$bookid);
    if($stmt->execute()){
      echo 'the book name has been updated';
    }
    $stmt->close();
}

function move_book_to_new_shelf($bookid, $db_shelfid) {

	global $conn;
    $stmt = $conn->prepare("UPDATE books SET shelfid=? WHERE bookid=?");
    	if(!$stmt) 
	{
		echo "Can't move the book"; 
		return; 
	}
    $stmt->bind_param("ii", $db_shelfid,$bookid);
    if($stmt->execute()){
      echo 'the book has been move to the new shelf';
    }
    $stmt->close();

}

function update_shelf($shelf, $shelfid){
	global $conn;
    $stmt = $conn->prepare("UPDATE shelves SET shelfname=? WHERE shelfid=?");
    	if(!$stmt) 
	{
		echo "Can't updated the shelf"; 
		return; 
	}
    $stmt->bind_param("si", $shelf,$shelfid);
    if($stmt->execute()){
      echo 'the shlef name has been updated';
    }
    $stmt->close();
}


?>











