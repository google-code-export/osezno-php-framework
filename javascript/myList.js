
var rowsMarked = new Array();

var markRowClass   = 'td_mark';
	
var overRowClass   = 'td_over';
	
var colSelected    = 'cell_content_selected';

/**
 * Habilita Case Sensitive sobre una regla en el filtro
 * 
 * @param data
 * @param idCS
 * @param idRule
 */
function MYLIST_caseSensitiveCheckBox (data, idCS, idRule){
	
	var arRules = new Array('like','in','equal','different','notin','notlike');
	
	var have = false;
	
	for(a=0;a<arRules.length; a++){
		
		if (arRules[a] == data[idRule]){
			have = true;
			break;
		}
		
	}
	
	if (!have){
		
		document.getElementById(idCS).disabled = true;
		
	}else{
		
		document.getElementById(idCS).disabled = false;
	}
	
}

/**
 * Hace un simple check sobre el objeto seleccionado
 * 
 * @param data
 * @param id
 * @return
 */
function check_onlist(data, id){
	
	if (!document.getElementById(id).checked)
		document.getElementById(id).checked = true;
	else
		document.getElementById(id).checked = false;
}

/**
 * Executa un evento global definido por el usuario en la lista dinamica
 * 
 * @param eventToCall
 * @param idlist
 * @return
 */
function execGlobalEventOnList (eventToCall, idlist, idselect){
	
	if (eventToCall){
		
		document.getElementById(idselect).value = '';
		
		setTimeout (eventToCall+"(returnRowsSelectedOnList('"+idlist+"'))");
	}
}

/**
 * Retorna los id de la lista seleccionados para validar que registros fueron chequeados
 * @param idlist
 * @return
 */
function returnRowsSelectedOnList (idlist){
	
	var ids = new Array();
	
	var ins=document.getElementsByTagName('input');
	
	for (var j=i=0;i<ins.length;i++){
		
		if (ins[i].type == 'checkbox')
			
		if (ins[i].id.substr(0,idlist.length)==idlist)
				
		if (ins[i].id.substr(idlist.length)!='_over_all')
				
		if (document.getElementById(ins[i].id).checked == true){

			ids[j] = ins[i].id.substr(ins[i].id.lastIndexOf('_')+1);
					
			j++;
		}
				
	}

	return ids;
}

/**
 * Marca o desmarca los checkboxes de una lista dinamica
 * 
 * @param value
 * @param idlist
 * @param idmaster
 * @return
 */
function checkAllBoxesOnList (value, idlist, idmaster, numCols, cCols){
	
	var ins=document.getElementsByTagName('input');
	
	var valmain = document.getElementById(idmaster).checked;
	
	var idtr = '';
	
	for (var i=id=0;i<ins.length;i++){
		
		if (ins[i].type == 'checkbox'){
			
			if (ins[i].id.substr(0,idlist.length)==idlist){

				if (ins[i].id.indexOf('over_all')==-1){
				
				if (id%2)
					cName = 'td_default';
				else
					cName = 'td_middle';
					
				idtr = 'tr_'+idlist+'_'+id;
				
				 if (valmain == true){
					 
					 ins[i].checked=true;
					 
					 rowsMarked[idtr] = 1;
					 
					 for (j=0;j<numCols;j++){
						 
				     	 document.getElementById(idtr).cells[j].className = markRowClass;
				     }
					 
				 }else{
					 
					 ins[i].checked=false;
					 
					 arrCCols = new Array();
					 
					 arrCCols = cCols.split(',');
					 
					 for (var j=0;j<numCols;j++){
						 
				    	switch (arrCCols[j]){
				    		case '1':
				    			document.getElementById(idtr).cells[j].className = cName;
				    		break;
				    		case '2':
				    			document.getElementById(idtr).cells[j].className = colSelected;
				    		break;
				    		}
				     }
					 
					 rowsMarked[idtr] = 0;
				 }
				 
				 id++;
				 
				}
				 
			}
		}
		
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

 /**
  * Quita las marcas los registros seleccionados de una lista
  * @return
  */
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
function markRow (o, cName, cCols, numCols, field){
	
	 if (field.length){
		 
		 var valField = document.getElementById(field).checked;
		 
		 if (valField == true)
			 document.getElementById(field).checked = false;
		 else
			 document.getElementById(field).checked = true;
	 }
	 
	if (rowsMarked[o.id]==undefined)
		rowsMarked[o.id] = 0;
	
    if (rowsMarked[o.id] == 0){
    	
    	for (i=0;i<numCols;i++){
      	   o.cells[i].className = markRowClass;
         }
    	
    	rowsMarked[o.id] = 1;    	
        
    }else{
    
    	arrCCols = new Array();
    	
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
 