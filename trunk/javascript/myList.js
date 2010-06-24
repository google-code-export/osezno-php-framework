
function myList (idList){

	this.rowsMarked = new Array();
	
	this.idList 	= idList;
	
	this.loadCss 	= loadCss;
	
	this.onRow 		= onRow;

	this.outRow 	= outRow;
	
	this.markRow 	= markRow;
	
	this.defaRowClass   = 'tr_default';
	
	this.middleRowClass = 'tr_middle_row'; 
	
	this.markRowClass   = 'tr_mark_row';
	
	this.overRowClass	= 'tr_over_row';
}

/**
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
	
	if (o.className != this.markRowClass)
		o.className = this.overRowClass;
	
}

/**
 * Cambia la clase al quitar el puntero
 * @param o Id de la fila
 * @param cname	Clase original
 * @return
 */
function outRow (o, cname){
	
	if (o.className != this.markRowClass)
		o.className = cname;
}

/**
 * Marca una fila de la lista
 * @param o	Id de la fila
 * @param cname Clase original
 * @return
 */
function markRow (o, cname){
	
	if (this.rowsMarked[o.id]==undefined)
		this.rowsMarked[o.id] = 1;
	
    if (this.rowsMarked[o.id] == 1){
    	 
       o.className = this.markRowClass;
        
       this.rowsMarked[o.id] = 0;
        
    }else{
    	
    	o.className = cname;
    	 
    	this.rowsMarked[o.id] = 1;
     }
     
}