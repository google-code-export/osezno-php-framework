
function myList (idList){
	
	this.idList = idList;
	
	this.loadCss = loadCss;
}

function loadCss (){
	
	myListLoadCSS (this.idList);
	
}