<?php
ob_start();
session_start();

$del 	= isset($_GET['del'])	?		$_GET['del']		: '' ;
$id 	= isset($_GET['id'])   	? (int)	$_GET['id'] 		: null;
$lang 	= isset($_GET['lang']) 	? 		$_GET['lang'] 		: '' ;

if($del =='Yes' && isset( $_SESSION['allowed']))
{
	require_once("../connect_db_1.php");

	if( is_numeric($id) )
	{
		$query = "DELETE FROM snippet_table WHERE id='".$id."' LIMIT 1";
		mysqli_query($conn, $query);
	    header("location: ../index.php?lang=".$lang);
	    exit();
	}
	elseif( is_null($id) )
	{
		// delete the entire subject

		$query = "DELETE FROM snippet_table WHERE lang='".$lang."'" ;
	    mysqli_query($conn, $query);
	}	
 }

 header("location: ../index.php");

ob_end_flush();
?>