
function myList (idList, numCols){

	this.rowsMarked = new Array();
	
	this.idList 	= idList;
	
	this.loadCss 	= loadCss;
	
	this.onRow 		= onRow;

	this.outRow 	= outRow;
	
	this.markRow 	= markRow;
	
	this.numCols 	= numCols;
	
	this.clearRowsMarked = clearRowsMarked; 
	
	this.defaRowClass   = 'td_default';
	
	this.middleRowClass = 'td_middle'; 
	
	this.markRowClass   = 'td_mark';
	
	this.overRowClass	= 'td_over';
	
	this.colSelected    = 'cell_content_selected';
}


function clearRowsMarked (){
	
	
	alert(this.rowsMarked.length);
	/*
	for (i=0;i<this.rowsMarked.length;i++){
		this.rowsMarked[i] = 0;
		
	}
	*/
}

/*
 * Carga la hoja de estilos de la lista
 * @return
 */
function loadCss (){
	
	myListLoadCSS (this.idList);
	
}

/**
 * Cambia la clase de una fila al pasar
 * el puntero dobre el.
 * @param o Id de la fila
 * @return
 */
function onRow (o){
	
	 if (this.rowsMarked[o.id] != 1){
		for (i=0;i<this.numCols;i++){
			o.cells[i].className = this.overRowClass;
		}
	 }
	
}

/**
 * Cambia la clase al quitar el puntero
 * @param o Id de la fila
 * @param cname	Clase original
 * @return
 */
function outRow (o, cName, cCols){
	
	 if (this.rowsMarked[o.id] != 1){
		arrCCols = cCols.split(',');
	 	for (i=0;i<this.numCols;i++){
	 		switch (arrCCols[i]){
 				case '1':
 					o.cells[i].className = cName;
 					break;
 				case '2':
 					o.cells[i].className = this.colSelected;
 					break;
	 		}
	 	}
	 }
	 
}

/**
 * Marca una fila de la lista
 * @param o	Id de la fila
 * @param cname Clase original
 * @return
 */
function markRow (o, cName, cCols){
	
	if (this.rowsMarked[o.id]==undefined)
		this.rowsMarked[o.id] = 0;
	
    if (this.rowsMarked[o.id] == 0){
    	
    	for (i=0;i<this.numCols;i++){
      	   o.cells[i].className = this.markRowClass;
         }
    	
    	this.rowsMarked[o.id] = 1;    	
        
    }else{
    
    	arrCCols = cCols.split(',');
    	
    	for (i=0;i<this.numCols;i++){
    		switch (arrCCols[i]){
    			case '1':
    				o.cells[i].className = cName;
    			break;
    			case '2':
    				o.cells[i].className = this.colSelected;
    			break;
    		}
    	}

        this.rowsMarked[o.id] = 0;

     }

}