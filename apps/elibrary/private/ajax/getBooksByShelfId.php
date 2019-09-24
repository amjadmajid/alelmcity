<?php

// echo "text";
// exit;

		// require_once("../initialize.php");

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

      $results['bookid'][] =  $bookid;
      $results['book'][] =  $book;
      $results['shelfid'][] = $id;
    }
    $stmt->close();

    echo json_encode($results);
  }

find_books_by_shelf_id($_GET['id']);

?>