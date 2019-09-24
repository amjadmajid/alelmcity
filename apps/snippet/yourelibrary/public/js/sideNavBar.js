var sideBarWidth=300;
var sideNavCntr = document.getElementById("sidenavCntr");
var mainCanvus = document.getElementById("main");

sideNavCntr.addEventListener("click", function(){

var sNav= document.getElementById("mySidenav");

if(sNav.style.width){	
	sNav.style.width = null;
	mainCanvus.style.marginLeft = null;
	sideNavCntr.innerHTML = "&#9776;"
	// remove the value added by javascript
	// the HTML element will use the background color specified in the style.css
	mainCanvus.style.backgroundColor =""
	}else{
	sNav.style.width = sideBarWidth +"px";
	mainCanvus.style.marginLeft = sideBarWidth+ "px";
	sideNavCntr.innerHTML = "&#x2715;"
	// overwrite the CSS value
	mainCanvus.style.backgroundColor = "rgba(0,0,0,0.4)"
	}
});


sideNavCntr.click();