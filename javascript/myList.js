
var rowsMarked = new Array();

var markRowClass   = 'td_mark';
	
var overRowClass   = 'td_over';
	
var colSelected    = 'cell_content_selected';

function checkAllBoxesOnList (value, idlist){
	
	for (i=0;i<document.ids.length;i++){
		alert(document.ids[i].type);
	}
	
}

/**
 * Bloquea el primer select-one de un formulario de filtro de una lista dinamica
 * @param nomForm
 * @return
 */
function blockFirstElementForm (nomForm){
	
	var i;
	var id;
	var option;
	
	for (i=0; i<document.forms[nomForm].elements.length; i++){
		option = document.forms[nomForm].elements[i].type;
		
		if (option == 'select-one'){
			id = document.forms[nomForm].elements[i].id;
			document.getElementById(id).disabled = true;
			document.getElementById(id).style.display = "none";
			break;
		}
   }	
}

function clearRowsMarked (){
	
	rowsMarked = new Array();
}


/**
 * Cambia la clase de una fila al pasar
 * el puntero dobre el.
 * @param o Id de la fila
 * @return
 */
function onRow (o, numCols){
	 
	 if (rowsMarked[o.id] != 1){
		for (var i=0;i<numCols;i++){
			o.cells[i].className = overRowClass;
		}
	 }
	
}

/**
 * Cambia la clase al quitar el puntero
 * @param o Id de la fila
 * @param cname	Clase original
 * @return
 */
function outRow (o, cName, cCols, numCols){
	
	 if (rowsMarked[o.id] != 1){
		arrCCols = cCols.split(',');
	 	for (var i=0;i<numCols;i++){
	 		switch (arrCCols[i]){
 				case '1':
 					o.cells[i].className = cName;
 					break;
 				case '2':
 					o.cells[i].className = colSelected;
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
function markRow (o, cName, cCols, numCols){
	
	if (rowsMarked[o.id]==undefined)
		rowsMarked[o.id] = 0;
	
    if (rowsMarked[o.id] == 0){
    	
    	for (i=0;i<numCols;i++){
      	   o.cells[i].className = markRowClass;
         }
    	
    	rowsMarked[o.id] = 1;    	
        
    }else{
    
    	arrCCols = cCols.split(',');
    	
    	for (var i=0;i<numCols;i++){
    		switch (arrCCols[i]){
    			case '1':
    				o.cells[i].className = cName;
    			break;
    			case '2':
    				o.cells[i].className = colSelected;
    			break;
    		}
    	}

        rowsMarked[o.id] = 0;

     }

}
 