var submitButton = document.getElementById("submit");

function sizeChange(){
    document.getElementById("left").style.fontSize="16px";
	var a = document.getElementById("left").getElementsByTagName("a");
	for (var i = 0; i < a.length; i++) {
	    var elem = a[i];
	    elem.style.fontSize="16px";
	}
    return false;
}


function showCode(e){
    var elem = e.nextSibling.nextSibling.nextSibling.nextSibling;
	if(    elem.style.display=="none"){
	        elem.style.display="initial";

	          var codes = elem.getElementsByTagName('code');

				  for(var i = 0; i < codes.length; i++)
				  {
				     codes.item(i).className +=" prettyprint";
				  }

	}else{
	        elem.style.display="none";
	}
}
