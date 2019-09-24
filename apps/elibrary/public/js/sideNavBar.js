var sideBarWidth=300;
var sideNavCntr = document.getElementById("sidenavCntr");
var mainCanvus = document.getElementById("main");

sideNavCntr.addEventListener("click", sideNavBarCntr, false);


var shelves = document.getElementsByClassName('shelf');
for (var i = shelves.length - 1; i >= 0; i--) {
	shelves[i].addEventListener('click', sideNavBarCntr, false);
}

function sideNavBarCntr(){

var sNav= document.getElementById("mySidenav");

if(sNav.style.width){	
	sNav.style.width = null;
	mainCanvus.style.marginLeft = null;
	sideNavCntr.innerHTML = "&#9776;";
	sideNavCntr.style.color = "#000";
	// remove the value added by javascript
	// the HTML element will use the background color specified in the style.css
	mainCanvus.style.backgroundColor ="";
	}else{
	sNav.style.width = sideBarWidth +"px";
	mainCanvus.style.marginLeft = sideBarWidth+ "px";
	sideNavCntr.innerHTML = "&#x2715;";
	sideNavCntr.style.color = "#fff";
	// overwrite the CSS value
	mainCanvus.style.backgroundColor = "#CFD3D3"
	}

}