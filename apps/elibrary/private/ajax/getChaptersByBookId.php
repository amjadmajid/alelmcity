<?php

// echo "text";
// exit;

// require("../initiatize.php");
include_once("../Parsedown.php");

function getChaptersByBookId($id) {
    $parsedown = new Parsedown;

    global $conn;
    // prepare statement
    $stmt = $conn->stmt_init();
    $stmt->prepare("SELECT chapterid, chaptername, chaptercontent FROM chapters WHERE bookid=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    // https://stackoverflow.com/questions/8321096/call-to-undefined-method-mysqli-stmtget-result
    // $result = $stmt->get_result();

    // to check if you get any records from the database
    $stmt->store_result();
    // if($stmt->num_rows() < 1 ){}
    $stmt->bind_result($chapterid, $chapter, $content);
    $results =[];

    while($stmt->fetch()){

      $results['chaptersids'][] = $chapterid;
      $results['chaptersnames'][] =  $chapter;
      // var_dump(addslashes($parsedown->text($content)));
      $results['chapterscontents'][] =  isset($content) ? $parsedown->text($content) : "" ;
    }
    $stmt->close();

    echo json_encode($results);
  }

getChaptersByBookId($_GET['id']);

?>