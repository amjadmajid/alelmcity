<?php require('../private/initialize.php'); ?>
<?php  
if(!isset($_SESSION['libraryid']) || $_SESSION['allowed'] != 1 )
{
  header("location: protected/reg_access/login.php");
  exit();
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Amaranth|Roboto" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/sideNavBar.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>E-library</title>

</head>
<body>

	<div id="mySidenav" class="sidenav">
		<a href="protected/new.php">Add shelf</a>
		<?php 
		$shelfs = find_shelves_by_lib_id($_SESSION['libraryid']);
		// $shelfs = find_shelves_by_lib_id(1);

		$s 		= $shelfs['shelf'];
		$sid 	= $shelfs['shelfid'];
		for($i=0 ; $i < count($s) ; $i++ ){
			?>
			<div class="shelf_cont">
				<a class="shelf" href="index.php?sid=<?php echo u(h($sid[$i])).'&s='.u(h($s[$i])); ?>"> <?php echo h($s[$i]); ?></a>
				<a class="edit" href="protected/edit.php?sid=<?php echo u(h($sid[$i])).'&s='.u(h($s[$i])); ?>">&#9998;</a>
				<a class="del" href="index.php?sid=<?php echo u(h($sid[$i])).'&s='.u(h($s[$i])); ?>&del=1">&#10008;</a>
			</div>
			<?php  } // End the for loop ?> 

	</div>

	<div id="main">
		<?php
			if( isset($_GET['del']) )
			{ 
				$shelf = $_GET['s'];
				$shelfid = $_GET['sid'];
			?>
				<div class="deleteMessageCont">
					<p class="deleteMessage"> Do you realy want to delete <b><?php echo h($shelf) ?></b> <a href="protected/delete.php?sid=<?php echo u(h($shelfid)); ?>">Yes</a> | <a href="index.php">No</a></p>
				</div>
			<?php 
			}
		?>
		<span id="sidenavCntr" style="font-size:30px;cursor:pointer" >&#9776;</span>

		<div class="welcomeString"> Welcome to <?php echo $_SESSION['libraryname']; ?> Library </div>

	</div>

	<script src="js/sideNavBar.js"></script>
	<script src="https://cdn.rawgit.com/showdownjs/showdown/1.0.0/dist/showdown.min.js"></script>
	<script src="js/ajax/getBooksByShelfId.js"></script>
	<script src="js/ajax/getChaptersByBookId.js"></script>
</body>
</html>
