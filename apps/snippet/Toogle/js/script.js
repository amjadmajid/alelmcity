
function starter(){
	var JTest = document.getElementById("search_form");

// This function is used to change colors of TOoGle 
	document.getElementById('t').onmouseover = function(){
		document.getElementById('t').style.color = "red";
	}
	document.getElementById('t').onmouseout = function(){
		document.getElementById('t').style.color = "black";
	}
	document.getElementById('o1').onmouseover = function(){
		document.getElementById('o1').style.color = "green";
	}
	document.getElementById('o1').onmouseout = function(){
		document.getElementById('o1').style.color = "black";
	}


	

// This function is meant to check if the search filed is not empty
	JTest.onsubmit =  function(){
		var search = document.getElementById("search");
		if(search.value ==""){
			document.getElementById("Error").innerHTML = "Please insert a word";
			return false;
		}else{
			document.getElementById("Error").innerHTML = "";		
			return true;
		}
	}

//This function is used to add hints to the input fields
	var form_insert = document.getElementById('obj_name');
	form_insert.onfocus = function(){
		if(form_insert.value == "name a thing"){
			form_insert.value="";
		}
	}
	form_insert.onblur = function(){
		if(form_insert.value ==""){
			form_insert.value="name a thing";
		}
	}
}

window.onload = function(){
	starter();
}


