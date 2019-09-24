<?php  require("../private/initialize.php"); ?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/page.css">
	<link rel="stylesheet" type="text/css" href="css/sideNavBar.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>E-library</title>

</head>
<body>

	<div id="mySidenav" class="sidenav">
		<a href="protected/new.php">Add new shelf</a>
		<?php 
		// $shelfs = find_shelves_by_lib_id($_SESSION['libraryid']);
		$shelfs = find_shelves_by_lib_id(1);

		$s 		= $shelfs['shelf'];
		$sid 	= $shelfs['shelfid'];
		for($i=0 ; $i < count($s) ; $i++ ){
			?>
			<a class="shelf" href="index.php?sid=<?php echo h($sid[$i]).'&s='.h($s[$i]); ?>"> <?php echo h($s[$i]); ?></a>
			<?php  } // End the for loop ?> 

	</div>

	<div id="main">
		<span id="sidenavCntr" style="font-size:30px;cursor:pointer" >&#9776;</span>

		<div class="welcomeString"> Welcome to <?php echo $_SESSION['libraryname']; ?> Library </div>

	</div>

	<script src="js/sideNavBar.js"></script>
	<script src="https://cdn.rawgit.com/showdownjs/showdown/1.0.0/dist/showdown.min.js"></script>
	<script src="js/ajax/getChaptersByBookId.js"></script>
	<script src="js/ajax/getBooksByShelfId.js"></script>
</body>
</html>
