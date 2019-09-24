<?php
	require('initialize.php');
// 
	echo 'Test if a is_blank function<br>';
	if(is_blank("")) 		{echo "1-\"\" is a blank string <br>";}
	if(!is_blank("0")) 		{echo "2-'0' is a NOT blank string<br>";}
	if(is_blank(" ")) 		{echo "3-' ' is a blank string<br>";}
	if(is_blank(false)) 	{echo "4- `false` is a blank string<br>";}
	if(!is_blank(array())) 	{echo "5-`array()` is a NOT blank string<br>";}
	if(!is_blank("This is a sentence")) 	{echo "6-`This is a sentence` is a NOT blank string<br>";}
?>