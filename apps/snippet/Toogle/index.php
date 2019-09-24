<?php
ob_start();
header("Content-type: text/html; charset=utf-8"); 
session_start();
if(!isset($_SESSION['allowed']) )
   {
  header("location: ../login_1.php");
  exit();
   }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Toogle</title>
</head>

<body>
	<h1> 
		<span id ="t">T</span><span id ="o1">O</span><span id ="o2">o</span><span id ="g">G</span><span id ="l">l</span><span id ="e">e</span>
	</h1>
		<form  id="search_form" action="index.php" method="POST">
			<input name="search" size="40" id="search" type="text" /> 
			<input  id="JTest" type="submit" name="getFromDb" value="search" />
		</form>
		<br/>
		<div id="Error"></div>

		<form action="index.php" method="POST">
			<input name="insert" type="text" id="obj_name" size="40" value = "name a thing" /> 
			<input type="submit" name="insertToDb" id="insertToDb" value=" Add "  />
			<br/>
			<textarea name="tags" cols="29"> </textarea>
	</form>

</body>

<?php
	require("../connect_db_1.php");

/// Searching part 
	if(isset($_POST['getFromDb'])){

		$strRaw = $_POST['search'];
		$str = preg_replace("#[^0-9a-z]#i", " ", $strRaw);
		$result = mysqli_query($conn , "SELECT * FROM snippet_table WHERE snippet_title LIKE '%$str%' OR snippet LIKE '%$str%' " );

/// to check the query 
		if (!$result) {
		    printf("Error: %s\n", mysqli_error($conn));
		    exit();
		}else if (mysqli_num_rows($result)< 1 ){
			echo "No results were found !";
		}
/// outputing the data		
		while ($resShow = mysqli_fetch_array($result)) {
			$name = $resShow["snippet_title"];
			$description = $resShow["snippetCode"];
			echo "<span style='color:blue'>". $name ."</span> : " . $description ."<br/>";
		};
	}

/// Insertion part
	if(isset($_POST['insertToDb'])){
		
		$str = $_POST['insert'];
		$tags = $_POST['tags'];
			$sql= "INSERT INTO snippet_table (snippet_title, snippetCode) VALUES ('$str', '$tags')"; //TODO
			if(mysqli_query($conn , $sql)){
				echo"data has been added";
		}
	}

		 ?>
	<script src="js/script.js" ></script>

</html>

