<?php
header("Content-type: text/html; charset=utf-8"); 
ob_start();
session_start();

  // Check if the serssion is set 
if( !isset( $_SESSION['allowed']) ) 
{
  header("Location: login_1.php");
  exit();
}

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
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

<link href="https://fonts.googleapis.com/css?family=Mada|Reem+Kufi|Cairo|Open+Sans" rel="stylesheet">
<!-- <link rel="stylesheet" type="text/css" href="style_css/style.css"> -->
<link rel="stylesheet" type="text/css" href="style_css/style_1.css">
<link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">



</head>

<body>
  <div id="cont">
    <div class="left">
      <a  href="backend_page.php"> 
        <button class="button" > Add a new book </button> 
      </a>

      <?php   
      $sql = "SELECT DISTINCT lang FROM snippet_table ORDER BY lang ASC ";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) { ?>
       <div class="subject">
          <a  class="adminButton" href="?del=check&lang=<?php echo $row['lang'] ?> ">
            <button class="del_button"> &#10005; </button>
          </a>
          <a class='languages' onclick='sizeChange()' href="index.php?lang=<?php  echo $row['lang']; ?>" > 
            <?php echo $row["lang"]; ?> 
          </a> 
        </div>
      <?php
        }
      }
      ?>

  </div>

  <div id="main">
        <!-- Start of  the website header-->
    <div class="header">
      <div dir='rtl' class="headerbody" >
        <span class = "orangeText" style="float:right; margin-right:10px;"> كتابك </span>
        <span style='float:left;padding-top: 10px; margin-bottom: -10px; margin-left: 10px;'> 
          <a href="https://www.facebook.com/mdalelm/?ref=aymt_homepage_panel" target="_blank" >
            <img style="height:40px" src="../../images/facebook.svg", alt="facebook"> 
          </a>
        </span>
        <span style='float:left;padding-top: 10px; margin-bottom: -10px; margin-left: 10px;'> 
          <a href="https://www.youtube.com/channel/UCc8xM-ZYSwRU7_URNj8LqBA" target="_blank" >
            <img style="height:40px" src="../../images/youtube.svg", alt="youtube"> 
          </a>
        </span>
        <span style=' font-size:13px; color:#fff; float:left;padding-top: 10px; margin-bottom: -10px; margin-left: 10px;'> 
          <span class="lightBlueText sansFont"> اشترك ليصلك كل جديد </span>
        </span>
      </div>
    </div>

<!-- Delete the article comfirmation -->
<?php
  if(isset($_GET['del']) && ( $_GET['del'] == 'check') &&
    isset($_GET['id']) && isset( $_SESSION['allowed']) )
  {
      $id = $_GET['id'] ;
      $lang =  $_GET['lang']; 
      echo '<p style="text-align:center;">Do you want to remove the field?'; 
      echo'<a href="admins-area/delete.php?del=Yes&id='.$id.'&lang='.$lang.'">';
      echo 'Yes </a> | <a href="?del=No&id='.$id.'&lang='.$lang.'"> No </a></p>';
  }
  elseif ( !isset($_GET['id']) &&( $_GET['del'] == 'check') && isset( $_SESSION['allowed']) )
  {
      $lang =  $_GET['lang']; 
      echo '<p style="text-align:center;"> Do you want to remove this subject?'; 
      echo'<a href="admins-area/delete.php?del=Yes&lang='.$lang.'">';
      echo 'Yes </a> | <a href="?del=No&lang='.$lang.'"> No </a></p>';
  }
?>


<?php
  if( isset($_GET['lang']) ){        
    $lang =  $_GET['lang']; // we need check and protection here
    $sql1 = "SELECT * FROM snippet_table WHERE lang='".$lang."'";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows > 0) {
     while($row1 = $result1->fetch_assoc()) {
      $id = $row1['id'];
      echo "<div> 
      <p class='titleHeader' onclick='showCode(this)' > + ".$row1["snippet_title"];
      if( $_SESSION['allowed'] == 1)
      {
        echo' <a class="adminButton" href="admins-area/edit.php?id='. $id .'&lang='.$lang.'">
                  <button class="edit_button" > &#9998; </button>
              </a> 
              &nbsp;
              <a  class="adminButton" href="?del=check&id='. $id .'&lang='.$lang.'">
                <button class="del_button"> &#10005; </button>
              </a> ';
      } 
      echo " </p>";
      echo"  <p class='discrp' >".$row1["snippet_desc"]."</p>
      <div style='display:none'> 
      <pre  class='snippetStyle'>". stripslashes($row1["snippet"])."</pre> 
      </div>
      </div>";

    }

    echo '<a  href="backend_page.php?lang='.$lang.'"> <button class="button"> Add new field </button> </a>';
  } else {
    echo "0 results";
  }
}
?>

</div>

  </div><!-- End of the #cont div -->
</body>
<script src="javaScript_1/js_1.js"></script>
<script src="javaScript_1/jquery.js"></script>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?skin=desert"></script>

</html>

<?php
ob_end_flush();
?>