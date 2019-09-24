<?php
		// require_once("../initialize.php");

function find_content_by_chapter_id($id) {
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

  echo $content;
}

find_content_by_chapter_id($_GET['id']) ;

?>