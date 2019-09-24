<?php
include_once('connect_db_1.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Snippet</title>
<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script>window.setTimeout( function() {
    $("textarea").height( $("textarea")[2].scrollHeight );
}, 1);</script>
-->
<link rel="stylesheet" type="text/css" href="style_css/style_1.css">
</head>

<body>
    <div id="cont">
        <div id="left">
            <?php   
                $sql = "SELECT DISTINCT lang FROM snippet_table";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                 while($row = $result->fetch_assoc()) {
                        echo "<a class='fSize' onclick='sizeChange()' href='index.php?lang=". $row["lang"] ."'>". $row["lang"]."</a> <br>";
                    }
                } else {
                    echo "0 results";
                }
            ?>
        </div>
        <div id="main">
                <?php
                    if( isset($_GET['lang']) ){        
                        $lang =  $_GET['lang']; // we need check and protection here
                        $sql1 = "SELECT * FROM snippet_table WHERE lang='".$lang."'";
                        $result1 = $conn->query($sql1);
                        if ($result1->num_rows > 0) {
                         while($row1 = $result1->fetch_assoc()) {
                                echo "<b>".$row1["snippet_title"] . "</b><br>".$row1["snippet_desc"]."<br>"."<pre><textarea class='code'>". $row1["snippet"]."</textarea></pre>";
                            }
                        } else {
                            echo "0 results";
                        }
                    }
                ?>
        </div>
        <div id="right">
                <?php
                    if( isset($_GET['lang']) ){        
                        $lang =  $_GET['lang']; // we need check and protection here
                        $sql1 = "SELECT * FROM snippet_table WHERE lang='".$lang."'";
                        $result1 = $conn->query($sql1);
                        if ($result1->num_rows > 0) {
                         while($row1 = $result1->fetch_assoc()) {
                                echo "<b>".$row1["snippet_title"] . "</b><br>";
                            }
                        } else {
                            echo "0 results";
                        }
                    }
                ?>
        </div>
    </div>
</body>
<script src="javaScript_1/js_1.js"></script>
</html>