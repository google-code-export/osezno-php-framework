
function myList (idList){
	
	this.idList = idList;
	
	this.loadCss = loadCss;
}

function loadCss (){
	
	myListLoad (this.idList);
	
}