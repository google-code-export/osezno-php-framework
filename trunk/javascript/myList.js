
function myList (idList){
	
	this.pagAct = 1;
	
	this.idList = idList;
	this.moveNext = moveNext;
	this.moveBack = moveBack;
}


function moveNext (){
	
	this.pagAct += 1;
	
}


function moveBack (){
	
	if (this.pagAct>1)
		this.pagAct -= 1;
	
}


