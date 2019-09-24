<?php
	require("../../../connect_db_1.php");

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

?>











