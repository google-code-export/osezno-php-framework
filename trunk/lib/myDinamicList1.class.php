<?php
/**
 * myList
 *
 * @uses Creacion de listas dinamicas con xajax y myForm
 * @package OSEZNO FRAMEWORK
 * @version 1.9.0
 * @author joselitohaCker
 *
 * La clase myList Permite crear lcistas dinamicas para ser usadas en cualquier parte
 * Esta lista dinamica trabaja con eventos xAjax
 *
 * Por el momento esta clase solo funciona con conexiones mysql y postgreSQL
 * Ultima actualizacion: 14 Agosto 2008
 *
 * Control de Cambios:
 *
 */
class myList {
	/**
	 * Version de la clase
	 *
	 * @var string
	 */
	public $Version = '1.9.0';
	 
	/**
	 * Nombre de referencia para la tabla
	 *
	 * @var string
	 */
	protected $NameRefList = 'dinamicTable';

	# Estilo de fuentes y de tablas

	/**
	 * Etiqueta para la opcion del combo desplegable
	 * Todos en los selects de los filtro por columna
	 *
	 * @var string
	 */
	protected $strValAllOptionInFilter = '[Todos]';
	
	/**
	 * Prefijo que usa xajax para llamar a sus funciones
	 *
	 * @var string
	 */
	public $prefAjax = '';


	/**
	 * Variable que indica si estoy creando un nuevo objeto o modificando uno actual
	 *
	 * @var boolean
	 */
	private $NewList = true;

	/**
	 * Indica en la paginacion, el registro desde el cual se va a comenzar
	 *
	 * @var integer
	 */
	private $PaginationIni = 0;
	 
	 
	/**
	 * Nombre del formulario que buscara
	 * datos en la nueva Lista
	 *
	 * @var string
	 */
	private $strNameFormLookingForParams = 'form_params_mylist';

	 
	/**
	 * String que se muestra cuando la consulta a una tabla es Nula
	 *
	 * @var string
	 */
	protected $sQueryNULL = 'No existe ningun registro asociado a esta consulta';

	 
	/**
	 * Lleva la suma de los anchos configurados por columna
	 *
	 * @var integer
	 */
	private $sumWidthByColumn = 100;
	 
	/**
	 * Setea el ancho ocupado por una columna determinada en un % o un
	 * valor entero que sera tenido en cuenta a la hora de complilar
	 * el formulario.
	 *
	 * @param string  $strAlias
	 * @param integer $intWidth
	 */
	protected function setWidthByColumn ($name, $strAlias, $intWidth){
		if (!isset($_SESSION['prdLst'][$name]['arWdtByCl'][$strAlias]))
		   $_SESSION['prdLst'][$name]['arWdtByCl'][$strAlias] = $intWidth;
	}
	 
	/**
	 * Setea la variable de la clase:
	 * ShowOrderMethod
	 * @param bool $boolValue Valor booleano a configurar
	 */
	public function setShowOrderMethod ($name, $boolValue){
		if (!isset($_SESSION['prdLst'][$name]['shwOrdMet']))
		   $_SESSION['prdLst'][$name]['shwOrdMet'] = $boolValue;
	}
	 
	 
	/**
	 *  Agrega un Link a una columna en particular generada en la consulta
	 *  para ser agregada en la tabla y obtenida en la Funcion GetList
	 *
	 *  @param string $FieldAlias Alias ligado a la consulta.
	 *  @param string $JSFunction Nombre de la function JS que se ejecutara cuando se haga click sobre el evento
	 *  @param string $Label      Etiqueta que puede reemplazar el link creado en la columna para que sea mostrada en lugar del resultado de esa fila obtenido
	 *  @param string $sConfirm   cadena de texto para generar un Confirm de javascript
	 */
	protected function addColum($name, $FieldAlias, $JSFunction, $Label = '', $sConfirm = ''){
		if (!isset($_SESSION['prdLst'][$name]['aradCls'][$FieldAlias]))
		   $_SESSION['prdLst'][$name]['aradCls'][$FieldAlias] = array ("alias" => $FieldAlias, "function" => $JSFunction, "label" => $Label, "confirm" => $sConfirm);
		
		$_SESSION['prdLst'][$name]['arClsAftd'] = array ();
	}

	 
	/**
	 * Configura una columna del resultado de la consulta para que
	 * esta sea asociada con un arreglo pasado como parametro a la
	 * funcion de tal forma que no se muestren los valors ordinarios
	 * de la tabla si no el valor correspondiente definido por la
	 * llave del subindice del arreglo.
	 * Ejemplo: Si en mi lista dinamica voy a tener un resultado que
	 * no va a variar de unos limitados a 'S' o 'N', uno puede definir
	 * un arreglo de la como array('S'=>'Si Aplica','N'=>'No Aplica');
	 * De esa forma no se mostrarian los valores ordinarios 'S' o 'N'
	 * si no los valores correspondientes definidos dentro del arreglo.
	 *
	 * @param string $strFieldAlias Alias de la columna a la cual se va a asociar
	 * @param array  $mixedArray    Arreglo con los indices y los valores a reemplazar en la columna
	 */
	public function mixColumnInArray ($name, $strFieldAlias, $mixedArray){
		if (!isset($_SESSION['prdLst'][$name]['arMxdCls'][$strFieldAlias]))
		   $_SESSION['prdLst'][$name]['arMxdCls'][$strFieldAlias] = $mixedArray;
	}

	/**
	 * Enter description here...
	 *
	 * @param string $strFieldAlias  Alias de la columna a la cual se va a asociar
	 * @param object $objClass       Objecto instanciado de la clase que contiene los metodos de interes
	 * @param string $strNameMethod  Nombre del metodo (funcion) que desea ejecutar
	 */
	public function setFunctionInColumn ($name, $strFieldAlias, $objClass, $strNameMethod){
		if (!isset($_SESSION['prdLst'][$name]['arFncInCl'][$strFieldAlias]))
		   $_SESSION['prdLst'][$name]['arFncInCl'][$strFieldAlias] = array ('objClass'=>$objClass, 'strNameMethod'=>$strNameMethod);
	}


	 
	/**
	 * Decide activar o no la paginacion de la tabla
	 *
	 * @param integer $Rango Numero de registros mostrados por cada pagina
	 */
	protected function setPagination ($name, $Rango = 10){
		$_SESSION['prdLst'][$name]['usPag'] = true;
		$_SESSION['prdLst'][$name]['pagRng'] = $Rango;
		
		if (!isset($_SESSION['prdLst'][$name]['pagIni']))
		   $_SESSION['prdLst'][$name]['pagIni'] = 0;
		   
	}
	
	
	/**
	 * Activar filtro por columna para agrupar resultados
	 *
	 * @param string  $strFieldAlias Alias de la columna a la cual se va a asociar
	 * @param boolean $orderAsc 	 Permite ordenar o no ese agrupamiento de datos para mas adelante permitir seleccionar el valor a filtrar
	 */
	protected function setFilterByColumn ($name, $strFieldAlias, $orderAsc){
		if (!isset($_SESSION['prdLst'][$name]['arClsInFlt'])){
			$_SESSION['prdLst'][$name]['arClsInFlt'] = array();
			$_SESSION['prdLst'][$name]['arUsOrdFlt'] = array();
		}
		
        $_SESSION['prdLst'][$name]['arClsInFlt'][$strFieldAlias] = array();
        $_SESSION['prdLst'][$name]['arUsOrdFlt'][$strFieldAlias] = $orderAsc; 
	}
	
	 
	/**
	 * Agrega un formulario al comienzo de la lista que permita hacer un
	 * filtro para cada una de las listas a las que este vinculado
	 *
	 * @param array $arrayElements Arreglo con los elementos que va a conformar la lista de parametrizacion
	 */
	private function getFormLookingForParams ($arrayElements, $NameRefList){
		$objMyForm = new myForm;

		$buf = '';

		if (is_array($arrayElements)){
			$arrayElements = array_unique ($arrayElements);
			$arrayLlaves = array_keys($arrayElements);
		}

		$strSelect = '<select name="mylist_select" id="mylist_select" size="1" class="'.$objMyForm->styleClass.'">';

		$countArrayElements = count($arrayElements);
		for ($i=0;$i<$countArrayElements;$i++){
			$strSelect .= '<option value="'.$arrayLlaves[$i].'">'.$arrayElements[$arrayLlaves[$i]].'</option>';
		}

		$strSelect .= '</select>';


		$buf .= '<form metod="POST" onsubmit="return false" name="mylist_'.$this->strNameFormLookingForParams.'" id="mylist_'.$this->strNameFormLookingForParams.'">'."\n";

		$buf .= '<table border="0" cellspacing="0" align="center" width="'.$_SESSION['prdLst'][$NameRefList]['wTb'].'">'."\n";
		$buf .= '<tr><td background="'.$_SESSION['prdLst'][$NameRefList]['sImBkTlFrmPrms'].'" bgcolor="'.$_SESSION['prdLst'][$NameRefList]['bgCrCeTlFrm'].'" class="'.$_SESSION['prdLst'][$NameRefList]['stTlFrmFlt'].'">'.$_SESSION['prdLst'][$NameRefList]['sTlFrmFlt'].'</td></tr>'."\n";
		$buf .= '<tr><td bgcolor="#000000">'."\n";

		$buf .= '<table border="0" align="center" bgcolor="#FFFFFF" width="100%">'."\n";
		$buf .= '<tr>'."\n";
		$buf .= '<td class="'.$objMyForm->styleClassTags.'">Filtrar por la columna </td>'."\n";
		$buf .= '<td>'.$strSelect.'</td>'."\n";

		$arrayFilterSelect = array(
		0 => array('1','termine por \'Texto\' '),
		1 => array('2','comienze por  \'Texto\''),
		2 => array('3','contenga a \'Texto\' '),
		3 => array('4','sea igual a \'Texto\''),
		4 => array('5','sea diferente de \'Texto\'')
		);

		$buf .= '<td class="'.$objMyForm->styleClassTags.'">cuando esta </td>'."\n";
		$buf .= '<td>'.$objMyForm->getSelect('mylist_filter_select',$arrayFilterSelect,3).'</td>'."\n";

		$buf .= '<td class="'.$objMyForm->styleClassTags.'">y texto sea </td>'."\n";
		$buf .= '<td><input type="text" size="10" name="mylist_text" id="mylist_text"  class="'.$objMyForm->styleClass.'"></td>'."\n";

		$buf .= '<td align="center" width="25%"><input type="submit" value="Filtrar" onclick="'.$this->prefAjax.'myListReloadQuery(GetDataForm(\'mylist_'.$this->strNameFormLookingForParams.'\',\'mylist_oculto\'), document.mylist_'.$this->strNameFormLookingForParams.'.mylist_select.options[document.mylist_'.$this->strNameFormLookingForParams.'.mylist_select.selectedIndex].text)"  class="'.$objMyForm->styleClassButtons.'"><input type="submit" value="Cancelar" class="'.$objMyForm->styleClassButtons.'" onclick="'.$this->prefAjax.'myListReloadQuery(GetDataForm(\'mylist_'.$this->strNameFormLookingForParams.'\'),\'\',\''.$NameRefList.'\')"></td>'."\n";
		$buf .= '</tr>'."\n";
		$buf .= '</table>'."\n";
		$buf .= '<input type="hidden" name="mylist_oculto" id="mylist_oculto">'."\n";
		$buf .= '<input type="hidden" name="mylist_ndiv" id="mylist_ndiv" value="'.$NameRefList.'">'."\n";

		$buf .= '</td></tr></table>'."\n";
		 
		$buf .= '</form>';

		return $buf;
	}

	/**
	 * Obtener el html correspondiente al formulario de consulta para esa lista dinamica
	 */
	protected function getFormParams($NameRefList){
		return $this->getFormLookingForParams($_SESSION['prdLst'][$NameRefList]['arClsInLst'], $NameRefList);
	}

	/**
	 * Construcctor principal de la clase
	 *
	 * @param string $NameRefList Nombre de referencia unico para la lsita
	 * @param string $sql Cadena de consulta a las bases de datos
	 */
	protected function myList_preparate ($NameRefList = '', $sql = ''){
		if ($NameRefList &&  $sql){
			$this->NameRefList = $NameRefList;
			
			$objActiveRecord = new myActiveRecord;

			//$_SESSION['prdLst'][$NameRefList]['idC'] = $objActiveRecord->openConecction();
			$_SESSION['prdLst'][$NameRefList]['enD'] = $objActiveRecord->getEngine();

			$_SESSION['prdLst'][$NameRefList]['sql']  = $sql;
			$_SESSION['prdLst'][$NameRefList]['sqlt'] = $sql;
		}
		
	}
	 
	/**
	 * Metodo principal de la clase que permite obtener la tabla
	 * en donde se muestra la consulta que obtuvimos, segun el SQL que hayamos
	 * diligeciado
	 *
	 * @param string $NameRefList Nombre de referencia para la lista
	 */
	public function getDinamicList($NameRefList){
		$buf = '';
		$ArrayIndices 		= array (); // -> Contiene todos los indices, son tambien equivalentes a los Alias de los SQLs
		$ArrayLlaves  		= array (); // -> Contiene todas las llaves de los campos afectados en la consulta
		$ArrayNumero 		= array (); // -> Contiene los id con un numero autoincrementable
		$arrayLlavesIndices = array ();	// -> Contiene los indices como llaves y los alias como valore de la consulta
		$ArrayAll     		= array (); // -> Contiene toda la matriz asociativa
		$indice = 0;

		
		if (isset($_SESSION['prdLst'][$NameRefList]['ordBy'])){
			switch ($_SESSION['prdLst'][$NameRefList]['enD']){
				case 'mysql':
					if ($_SESSION['prdLst'][$NameRefList]['ordMtd']){
					   $_SESSION['prdLst'][$NameRefList]['sqlt'] .= ' ORDER BY '.$_SESSION['prdLst'][$NameRefList]['aordBy'].' '.$_SESSION['prdLst'][$NameRefList]['ordMtd'];
					}
					break;
				case 'postgre':
					if ($_SESSION['prdLst'][$NameRefList]['ordMtd']){
					  $_SESSION['prdLst'][$NameRefList]['sqlt'] .= ' ORDER BY '.$_SESSION['prdLst'][$NameRefList]['ordBy'].' '.$_SESSION['prdLst'][$NameRefList]['ordMtd'];
					}
					break;
				default:
					$buf.='No se proporciono nombre de Motor de Bases de Datos.';
					break;
			}
		}

		if ($_SESSION['prdLst'][$NameRefList]['usPag'] == true){
			switch ($_SESSION['prdLst'][$NameRefList]['enD']){
				case 'mysql':
					$_SESSION['prdLst'][$NameRefList]['sqlt'] .= ' LIMIT '.$_SESSION['prdLst'][$NameRefList]['pagIni'].', '.$_SESSION['prdLst'][$NameRefList]['pagRng'];
					break;
				case 'postgre':
					$_SESSION['prdLst'][$NameRefList]['sqlt'] .= ' LIMIT '.$_SESSION['prdLst'][$NameRefList]['pagRng'].' OFFSET '.$_SESSION['prdLst'][$NameRefList]['pagIni'].';';
					break;
				default:
					$buf.='No se proporciono nombre de Motor de Bases de Datos.';
					break;
			}
		}

		
		// Obtener el resultado de la consulta SQL
		$indice = 0;
		
		if ($_SESSION['prdLst'][$NameRefList]['sqlt']){
			
			switch ($_SESSION['prdLst'][$NameRefList]['enD']){
				case 'mysql':
					
					$objActiveRecord = new myActiveRecord;
					
					$mysqli = $objActiveRecord->openConecction();
					
					$res = $mysqli->query($_SESSION['prdLst'][$NameRefList]['sqlt']);
					
					$cuantosAMostrar = $res->num_rows;
					
					if ($cuantosAMostrar){
						
						if (!isset($_SESSION['prdLst'][$NameRefList]['cRws'])){
							
						   $res = $mysqli->query($_SESSION['prdLst'][$NameRefList]['sql']);
							
						   $_SESSION['prdLst'][$NameRefList]['cRws'] = $res->num_rows;
						   
						   $_SESSION['prdLst'][$NameRefList]['tcPag'] = intval($_SESSION['prdLst'][$NameRefList]['cRws']/$_SESSION['prdLst'][$NameRefList]['pagRng']);
						   
						   if ($_SESSION['prdLst'][$NameRefList]['cRws']%$_SESSION['prdLst'][$NameRefList]['pagRng'])
						      $_SESSION['prdLst'][$NameRefList]['tcPag'] ++;
						}
						
						while ($fila = mysqli_fetch_array($res,MYSQLI_NUM)){
							 
							if (!$indice){
								$countFila = count($fila);
								for ($i=0;$i<$countFila;$i++){
									$meta = mysqli_fetch_field($res);

									$ArrayIndices[$i] = $meta->name;
									$ArrayLlaves[$i]  = $meta->orgname;
									$ArrayNumero[$i]  = $i;

									$arrayIndicesLlaves[$ArrayIndices[$i]] = $ArrayIndices[$i];
								}
							}

							$ArrayAll[$indice] = $fila;
							$indice+=1;
						}
						
						$mysqli->close();
						
						//$buf .= '1';
					}else{
						$objActiveRecord = new myActiveRecord;
					
					    $mysqli = $objActiveRecord->openConecction();
						
						$res = $mysqli->query($_SESSION['prdLst'][$NameRefList]['sql']);
						
						$_SESSION['prdLst'][$NameRefList]['cRws'] = $res->num_rows;

						//$buf .= '2'.$res->num_rows;
					}
					
					break;
				case 'postgre':
					if ($_SESSION['prdLst'][$NameRefList]['cTsh'] = pg_num_rows($res = pg_query ($_SESSION['prdLst'][$NameRefList]['idC'],$_SESSION['prdLst'][$NameRefList]['sqlt']))){
						
						if (!isset($_SESSION['prdLst'][$NameRefList]['cRws'])){
						   $_SESSION['prdLst'][$NameRefList]['cRws'] = pg_num_rows (pg_query($_SESSION['prdLst'][$NameRefList]['idC'], $_SESSION['prdLst'][$NameRefList]['sql']));
						   
						   $_SESSION['prdLst'][$NameRefList]['tcPag'] = intval($_SESSION['prdLst'][$NameRefList]['cRws']/$_SESSION['prdLst'][$NameRefList]['pagRng']);
						   if ($_SESSION['prdLst'][$NameRefList]['cRws']%$_SESSION['prdLst'][$NameRefList]['pagRng'])
						      $_SESSION['prdLst'][$NameRefList]['tcPag'] ++;
						}
						
						while ($fila = pg_fetch_array($res, $indice, PGSQL_NUM)){

							// Esto solo se hace una primera vez
							if (!$indice){
								/**
								 * Obetener los Alias del sql forma forzada
								 */
								$select = 'select';
								$from = 'from';
								
								$sql = $_SESSION['prdLst'][$NameRefList]['sqlt'];
								$sql = substr($sql,(strripos($sql,$select)+$lenhtSelect = strlen($select)),(strripos($sql,$from)-$lenhtSelect));
								
								$stringAliasAlternos = str_ireplace(' as ',' AS ',$sql);
								$arrayAliasAlternos = split(',',$stringAliasAlternos);

								$nombresOriginales = array();
								$countArrayAliasAlternos = count($arrayAliasAlternos);
								
								for ($conArrAlt = 0; $conArrAlt < ($countArrayAliasAlternos); $conArrAlt++){

									$arrayTempAs = split('AS',$arrayAliasAlternos[$conArrAlt]);
									$nombresOriginales[$conArrAlt] = trim($arrayTempAs[0]);
								}
								
								/*
								 * fin de Alias forzados
								 */
								$countFila = count($fila);
								for ($i=0;$i<$countFila;$i++){
									$ArrayIndices[$i] = ucfirst(pg_field_name($res, $i));
									$ArrayLlaves[$i]  = $nombresOriginales[$i];
									$ArrayNumero[$i]  = $i;

									$arrayIndicesLlaves[$ArrayIndices[$i]] = $ArrayIndices[$i];
								}
							}
							
							$ArrayAll[$indice] = $fila;
							$indice+=1;
						}
						pg_close($_SESSION['prdLst'][$NameRefList]['idC']);
					}else{
						$_SESSION['prdLst'][$NameRefList]['cRws'] = pg_num_rows ($res = pg_query($_SESSION['prdLst'][$NameRefList]['sql']));
						}
						break;
				default:
					$buf.='No se proporciono nombre de Motor de Bases de Datos.';
					break;
			}
		}else{ // -Fin de la consulta SQL que llena el array
			$buf.='No se proporciono un sql de consulta.';
		}
		
 
		
		
		$buf .= '<!--'."\n";
		$buf .= 'OSEZNO FRAMEWORK'."\n";
		$buf .= 'Generado con la clase para la creacion de Listas Dinamicas myDinamicList.php'."\n";
		$buf .= 'Nombre de referencia de la Lista:'.$NameRefList."\n";
		$buf .= 'Autor: Jose Ignacio Gutierrez Guzman -  joselitohacker@yahoo.es'."\n";
		$buf .= 'Version de la Clase:'.$this->Version."\n";
		$buf .= '-->'."\n";

		if ($this->NewList)
		   $buf .='<div name="'.$NameRefList.'" id="'.$NameRefList.'" align="center">'."\n";
		 
		$buf .=  '<table width="'.$_SESSION['prdLst'][$NameRefList]['wTb'].'"  border="0" cellpadding="0" cellspacing="0">'."\n";
		$buf .=  '  <tr>'."\n";
		$buf .=  '    <td bgcolor="'.$_SESSION['prdLst'][$NameRefList]['brCr'].'">'."\n";

		/**
		 * - Inicio  * PreHead *
		 * Mostrar desde aqui los titulos de los campos por medios de los Alias del SQL
		 */
		$countArrayIndices = count($ArrayIndices);
		$countArrayAddCols = count($_SESSION['prdLst'][$NameRefList]['aradCls']);
		for ($i = 0; $i<$countArrayIndices;$i++){
			// Determinar si se ha seleccionado alguna fila en particular
			if ($ArrayIndices[$i] == $arrayIndicesLlaves[$_SESSION['prdLst'][$NameRefList]['aordBy']]){
			   $ColSelected = $i;
			}

			# Recorremos los Alias de las columnas para saber si se encuentran dentro de las llaves generadas por cada motor.
			# Si se encuentran dentro del motor entonces se guarda el id para saber en donde se va a imprimir lo que genera el metod addColumn
			for ($j=0;$j<$countArrayAddCols;$j++){
				if (in_array($ArrayIndices[$i],$_SESSION['prdLst'][$NameRefList]['aradCls'][$ArrayIndices[$i]])){
					// En este arreglo voy a ir almacenando los numeros de las columnas que han sido afectadas
					// por la  por el methodo addColumn
					$_SESSION['prdLst'][$NameRefList]['arClsAftd'][] = $i;
				}
			}
		}
		/**
		 * - Fin  * PreHead *
		 * Mostrar desde aqui los titulos de los campos por medios de los Alias del SQL
		 */
		
		
		
		/**
		 * - Inicio
		 * Mostrar los registros segun la consulta
		 * 
		 * - $ColSelected
		 * 
		 */
		$bufRows = '';
		$countArrayAll = count($ArrayAll);
		$keysArrayColsInFilter = array_keys($_SESSION['prdLst'][$NameRefList]['arClsInFlt']);
		for ($i=0,$array_keys = array_keys ($ArrayAll);$i<$countArrayAll;$i++){
			
			if($_SESSION['prdLst'][$NameRefList]['usRwStr'] == true){
				if($i%2){
					$bgColor = $_SESSION['prdLst'][$NameRefList]['dfRwBgCr'];
				}
				else{
					$bgColor = $_SESSION['prdLst'][$NameRefList]['bgCrRwStr'];
				}
			}else{
				$bgColor = $_SESSION['prdLst'][$NameRefList]['dfRwBgCr'];
			}
			
			$bufRows .= "\t".'<tr id="tr_'.$NameRefList.'_'.$i.'" 
				onmouseover="onRow(this, \''.$_SESSION['prdLst'][$NameRefList]['dfCrRwHov'].'\', \'td_'.$NameRefList.'_'.$i.'\')" 
				onmouseout="outRow(this, \''.$bgColor.'\', \'td_'.$NameRefList.'_'.$i.'\', \''.$_SESSION['prdLst'][$NameRefList]['dfCrClSel'].'\')" 
				onclick="markRow(this, \''.$_SESSION['prdLst'][$NameRefList]['dfCrRwMrk'].'\', \''.$bgColor.'\', \'td_'.$NameRefList.'_'.$i.'\', \''.$_SESSION['prdLst'][$NameRefList]['dfCrClSel'].'\')" 
			bgcolor="'.$bgColor.'">'."\n";

			$countArrayAllArray_keys =  count($ArrayAll[$array_keys[$i]]);
			for($j=0;$j<$countArrayAllArray_keys;$j++){

				if($ColSelected == $j && $_SESSION['prdLst'][$NameRefList]['ordBy']){
					
					if ($_SESSION['prdLst'][$NameRefList]['usPag'] == true || $_SESSION['prdLst'][$NameRefList]['shwOrdMet'] == true)
					   $bgColor = $_SESSION['prdLst'][$NameRefList]['dfCrClSel'];
					   
					$bufRows.= "\t".' <td id="td_'.$NameRefList.'_'.$i.'" '. 
					'class="'.$_SESSION['prdLst'][$NameRefList]['stCtTb'].'" bgcolor="'.$bgColor.'">';
					   
				}else{
					
					if($_SESSION['prdLst'][$NameRefList]['usRwStr'] == true){
						if($i%2){
							$bgColor = $_SESSION['prdLst'][$NameRefList]['dfRwBgCr'];
						}
						else{
							$bgColor = $_SESSION['prdLst'][$NameRefList]['bgCrRwStr'];
						}
					}
					else{
						$bgColor = $_SESSION['prdLst'][$NameRefList]['dfRwBgCr'];
					}
				   
					$bufRows.= "\t".' <td class="'.$_SESSION['prdLst'][$NameRefList]['stCtTb'].'">';	
				}
				 
				if ($_SESSION['prdLst'][$NameRefList]['usClEn'] && !$j){
					if ($_SESSION['prdLst'][$NameRefList]['usPag'] == true)
					   $indiceReg = $i+1+($_SESSION['prdLst'][$NameRefList]['pagIni']);
					else   
					   $indiceReg = $i+1;
					
				   $bufRows .= '<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr><td width="10%"><div style="text-align:left" class="'.$_SESSION['prdLst'][$NameRefList]['stCtTb'].'">'.($indiceReg).'-</div></td><td class="'.$_SESSION['prdLst'][$NameRefList]['stCtTb'].'"  width="90%">';
				}
				
				// Preguntamos si el registro de la columna que estoy mostrando tiene algun valor o es NULL
				if($ArrayAll[$i][$ArrayNumero[$j]]){

					// Preguntamos si el numero de la columna que estoy mostrando esta dentro
					// de las columnas que estan afectadas por el metodo addColumn
					 
					if (in_array($j,$_SESSION['prdLst'][$NameRefList]['arClsAftd'])){
						
						for ($t=0;$t<$countArrayAddCols;$t++){
							 
							if (in_array($ArrayIndices[$j],$_SESSION['prdLst'][$NameRefList]['aradCls'][$t])){
								 
								break;
							}
						}

						# En el caso que se haya agregado el parametro 'sConfirm' del metodo addColum
						$sConfirm = '';
						if (strlen($_SESSION['prdLst'][$NameRefList]['aradCls'][$ArrayIndices[$j]]["confirm"])){
							$sConfirm = ' onClick="return confirm(\''.$_SESSION['prdLst'][$NameRefList]['aradCls'][$ArrayIndices[$j]]["confirm"].'\')" ';
						}

						$paramLinkFunction = $ArrayAll[$i][$ArrayNumero[$j]];
						
						$arrayKeysFunctionInColumn = array_keys($_SESSION['prdLst'][$NameRefList]['arFncInCl']);
						if (in_array($ArrayIndices[$j],$arrayKeysFunctionInColumn)){
						   $paramLinkFunction = $_SESSION['prdLst'][$NameRefList]['arFncInCl'][$ArrayIndices[$j]]['objClass']->$_SESSION['prdLst'][$NameRefList]['arFncInCl'][$ArrayIndices[$j]]['strNameMethod']($paramLinkFunction);
						}						
						
						if (strpos($paramLinkFunction,',')){
						   $arrayParamLinkFunction = explode (',',$paramLinkFunction);
						   $paramLinkFunction = '';
						   foreach($arrayParamLinkFunction as $paramLinkFunc){
							 $paramLinkFunction.='\''.$paramLinkFunc.'\',';
						   }
						   $paramLinkFunction = substr($paramLinkFunction,0,(strlen($paramLinkFunction)-1));
						}else{
						   $paramLinkFunction = '\''.$paramLinkFunction.'\'';
						}
						
					    $aColumnIni = '<a '.$sConfirm.' href="javascript:void('.$this->prefAjax.$_SESSION['prdLst'][$NameRefList]['aradCls'][$ArrayIndices[$j]]["function"].'('.$paramLinkFunction.'))">';
						
						if ($_SESSION['prdLst'][$NameRefList]['aradCls'][$ArrayIndices[$j]]["label"]){
							$aColumBetween = $_SESSION['prdLst'][$NameRefList]['aradCls'][$ArrayIndices[$j]]["label"];
						}else{
							$aColumBetween = $ArrayAll[$i][$ArrayNumero[$j]];
						}
						 
						$aColumnEnd = "</a>";
						 
					}else{
						$aColumnIni = "";
						$arrayKeysMixedCol = array_keys($_SESSION['prdLst'][$NameRefList]['arMxdCls']);

						// Trabaja mixColumnInArray
						if (in_array($ArrayIndices[$j],$arrayKeysMixedCol)){
							 
							$arrayKeysMixedData = array_keys($_SESSION['prdLst'][$NameRefList]['arMxdCls'][$ArrayIndices[$j]]);
							 
							if (in_array($ArrayAll[$i][$ArrayNumero[$j]],$arrayKeysMixedData)){

								$aColumBetween = $_SESSION['prdLst'][$NameRefList]['arMxdCls'][$ArrayIndices[$j]][$ArrayAll[$i][$ArrayNumero[$j]]];
								 
							}else{

								$aColumBetween = $ArrayAll[$i][$ArrayNumero[$j]];
								
							}
						}else{

							// Trabaja setFunctionInColumn
							$arrayKeysFunctionInColumn = array_keys($_SESSION['prdLst'][$NameRefList]['arFncInCl']);
							if (in_array($ArrayIndices[$j],$arrayKeysFunctionInColumn)){

								$valueToFunctionInColumn = $ArrayAll[$i][$ArrayNumero[$j]];
								$aColumBetween = $_SESSION['prdLst'][$NameRefList]['arFncInCl'][$ArrayIndices[$j]]['objClass']->$_SESSION['prdLst'][$NameRefList]['arFncInCl'][$ArrayIndices[$j]]['strNameMethod']($valueToFunctionInColumn);
								 
							}else{
								$aColumBetween = $ArrayAll[$i][$ArrayNumero[$j]];
							}
						}

						$aColumnEnd = "";
					}

					/**
					 * Agrupamiento de resultados para
					 * filtro por columna
					 */
					if (in_array($ArrayIndices[$j],$keysArrayColsInFilter)){
					   if (!in_array($aColumBetween,$_SESSION['prdLst'][$NameRefList]['arClsInFlt'][$ArrayIndices[$j]])){
					   	  $_SESSION['prdLst'][$NameRefList]['arClsInFlt'][$ArrayIndices[$j]][] = $aColumBetween;
					   }
					}
					
					/****** Producto final ******/ 
					$cont = $aColumnIni.$this->tildesHTML($aColumBetween).$aColumnEnd;

				}else{
					$cont = '&nbsp;';
				}
				 
				
				$bufRows.= $cont;
				
				if ($_SESSION['prdLst'][$NameRefList]['usClEn'] && !$j)
				   $bufRows.=''.'</td></tr></table>'."\n";
				
				$bufRows.=''.'</td>'."\n";
				//$contRowsShows = $i;
			}
			$bufRows .= "\t".'</tr>'."\n";
		}
		$bufRows .= '</table>'."\n".'';
		/**
		 * - Fin
		 * Mostrar los registros segun la consulta
		 */
		
		
		/**
		 * - Inicio * PostHead *
		 * Mostrar desde aqui los titulos de los campos por medios de los Alias del SQL
		 */
		$bufHead = '';
		$bufHead .= '<table border="0" width="100%" cellpadding="0" cellspacing="1">'."\n";
		$bufHead .= "\t".'<tr>'."\n";
		
		$arrayKeysAradCls = array_keys($_SESSION['prdLst'][$NameRefList]['aradCls']);
		$arrayKeysArFncInCl = array_keys($_SESSION['prdLst'][$NameRefList]['arFncInCl']);		
		
		for ($i = 0; $i<$countArrayIndices;$i++){

			$sqtBkgTitleCol = $_SESSION['prdLst'][$NameRefList]['sImBkHdClDf'];
			 
			// Determinar si se ha seleccionado alguna fila en particular
			if ($ArrayIndices[$i] == $arrayIndicesLlaves[$_SESSION['prdLst'][$NameRefList]['aordBy']]){
				if ($_SESSION['prdLst'][$NameRefList]['usPag'] == true || $_SESSION['prdLst'][$NameRefList]['shwOrdMet'] == true){
					switch ($_SESSION['prdLst'][$NameRefList]['ordMtd']){
						case 'ASC':
							$strImgOrder = '<img src="'.$_SESSION['prdLst'][$NameRefList]['iOrdA'].'" border="0">';
							$sqtBkgTitleCol = $_SESSION['prdLst'][$NameRefList]['sImBkHdClSel'];
							break;
						case 'DESC':
							$strImgOrder = '<img src="'.$_SESSION['prdLst'][$NameRefList]['iOrdD'].'" border="0">';
							$sqtBkgTitleCol = $_SESSION['prdLst'][$NameRefList]['sImBkHdClSel'];
							break;
						default:
							$strImgOrder = '&nbsp;';
							break;
					}
				}

				$colorThisCol = $_SESSION['prdLst'][$NameRefList]['dfCrClTbHd'];
			}else{
				$colorThisCol = $_SESSION['prdLst'][$NameRefList]['dfCrClTbHd'];
				$strImgOrder = '&nbsp;';
			}

			// Calculamos el ancho de las columnas de acuerdo a
			// los valores seteados para cada una de ellas
			if ($_SESSION['prdLst'][$NameRefList]['arWdtByCl'][$ArrayIndices[$i]]){
				$valWidth =  $_SESSION['prdLst'][$NameRefList]['arWdtByCl'][$ArrayIndices[$i]];
				$this->sumWidthByColumn -= intval($valWidth);
			}else{
				$valWidth = intval($this->sumWidthByColumn/($countArrayIndices-count($_SESSION['prdLst'][$NameRefList]['arWdtByCl'])))."%";
			}

			/**
			 * Alias de las columnas o campos afectados por el metodo
			 * setFilterByColumn
			 */
			if (in_array($ArrayIndices[$i],$keysArrayColsInFilter)){
			    $styleDivFilterInColcumn = 'style="visibility: hidden; overflow-y: hidden; overflow-x: hidden; width: auto; height: auto; position: absolute;"';
			    $htmlDivFilterContentInColumn = '';
			    
			    $htmlDivFilterContentInColumn .= '<select size="5" id="select_mydinamiclist_'.$ArrayIndices[$i].'" name="select_mydinamiclist_'.$ArrayIndices[$i].'"  onchange="myListFilterIn(\''.$NameRefList.'\', \'div_mydinamiclist_'.$ArrayIndices[$i].'\',this.value, \''.$ArrayLlaves[$i].'\',\''.$ArrayIndices[$i].'\')">';
			    
			    $htmlDivFilterContentInColumn .= '<option value="">'.$this->strValAllOptionInFilter.'</option>';
			    
			    $arraySelectFilter = $_SESSION['prdLst'][$NameRefList]['arClsInFlt'][$ArrayIndices[$i]];
			    if ($_SESSION['prdLst'][$NameRefList]['arUsOrdFlt'][$ArrayIndices[$i]])
					array_multisort($arraySelectFilter, SORT_ASC);			       
			    
			    foreach($arraySelectFilter as $byFilterValue){
			       $htmlDivFilterContentInColumn .= '<option value="'.$byFilterValue.'">'.$byFilterValue.'</option>';	
			    }
			    
			    $htmlDivFilterContentInColumn .= '</select>';
			    
			    $htmlDivFilterInColcumn  = '<div id="div_mydinamiclist_'.$ArrayIndices[$i].'" name="div_mydinamiclist_'.$ArrayIndices[$i].'" '.$styleDivFilterInColcumn.'>'.$htmlDivFilterContentInColumn.'</div>';
			    
				$strImgFilter = '<a href="javascript:;" onclick="document.getElementById(\'div_mydinamiclist_'.$ArrayIndices[$i].'\').style.visibility = \'visible\'"><img src="../../img/my_dinamiclist/filtrar.gif" border="0"></a>'.$htmlDivFilterInColcumn;
			}else{
				$strImgFilter = '&nbsp;';
			}
			
			if ($_SESSION['prdLst'][$NameRefList]['shwOrdMet'] && !in_array($i,$_SESSION['prdLst'][$NameRefList]['arClsAftd'])){
				$StringOrderIni = '<a class="'.$_SESSION['prdLst'][$NameRefList]['stTlCl'].'" href="javascript:;" onclick="'.$this->prefAjax.'myListMove(\''.$NameRefList.'\',\''.$ArrayLlaves[$i].'\',\''.$ArrayIndices[$i].'\',\''.$_SESSION['prdLst'][$NameRefList]['pagIni'].'\',\''.$_SESSION['prdLst'][$NameRefList]['pagRng'].'\')">';
				$StringOrderEnd = '</a>';
			}else{
				$StringOrderIni = '<font class="'.$_SESSION['prdLst'][$NameRefList]['stTlCl'].'" >';
				$StringOrderEnd = '</font>';
			}

			$bufHead .= "\t".' <td background="'.$sqtBkgTitleCol.'" bgcolor="'.$colorThisCol.'"  width="'.$valWidth.'" class="'.$_SESSION['prdLst'][$NameRefList]['stTlCl'].'"><table border="0" width="100%" cellpadding="0" cellspacing="0"><tr><td width="10%" align="left">'.$strImgFilter.'</td><td width="80%"><div style="text-align:center">';
			
			if (!in_array($ArrayIndices[$i],$_SESSION['prdLst'][$NameRefList]['aradCls'][$i]) || !$_SESSION['prdLst'][$NameRefList]['aradCls'][$i]["label"]){

				$bufHead .= $StringOrderIni.$ArrayIndices[$i].$StringOrderEnd;

				if (!isset($_SESSION['prdLst'][$NameRefList]['arClsInLst']))
				   $_SESSION['prdLst'][$NameRefList]['arClsInLst'] = array();

				if (!in_array($ArrayIndices[$i],$arrayKeysAradCls))
				   if (!in_array($ArrayIndices[$i],$arrayKeysArFncInCl))   
				      $_SESSION['prdLst'][$NameRefList]['arClsInLst'][$ArrayLlaves[$i]] = $ArrayIndices[$i];

			}else{
				if (!$_SESSION['prdLst'][$NameRefList]['aradCls'][$i]["label"])
				  $bufHead .= $StringOrderIni.''.$ArrayIndices[$i].''.$StringOrderEnd;
				else
				  $bufHead .= $StringOrderIni.''.$ArrayIndices[$i].''.$StringOrderEnd;
			}

			
			$bufHead.=''.'</div></td><td width="10%" align="right">'.$strImgOrder.'</td></tr></table></td>'."\n";
		}
		$bufHead .= "\t".'</tr>'."\n";
		/**
		 * - Fin  * PostHead *
		 * Mostrar desde aqui los titulos de los campos por medios de los Alias del SQL
		 */
		
		
		// - Final para Cabezas
		$buf .= $bufHead;
		
		// - Final para registros
		$buf .= $bufRows;
		
		
		$buf .='</td>'."\n";
		$buf .='    </tr>'."\n";
		$buf .='  </table>'."\n".'';

		if ($_SESSION['prdLst'][$NameRefList]['usPag'] == true){
			$buf .= '<table border="0" cellspacing="1" align="center" width="'.$_SESSION['prdLst'][$NameRefList]['wTb'].'">'."\n";
			$buf .= '<tr><td>'."\n";

			if ($_SESSION['prdLst'][$NameRefList]['pagIni']>0)
			   $atras .= '<button class="'.$_SESSION['prdLst'][$NameRefList]['stBtnPag'].'" onclick="'.$this->prefAjax.'myListMove(\''.$NameRefList.'\',\''.'\',\''.$ArrayLlaves[$i].'\','.($posActual = $_SESSION['prdLst'][$NameRefList]['pagIni']-$_SESSION['prdLst'][$NameRefList]['pagRng']).','.$_SESSION['prdLst'][$NameRefList]['pagRng'].',\'N\')"><'.'</button>';
			else
			   $atras .= '&nbsp;';

			if(($_SESSION['prdLst'][$NameRefList]['pagIni']+$_SESSION['prdLst'][$NameRefList]['pagRng'])<$_SESSION['prdLst'][$NameRefList]['cRws'])
			  $adelante .= '<button class="'.$_SESSION['prdLst'][$NameRefList]['stBtnPag'].'" onclick="'.$this->prefAjax.'myListMove(\''.$NameRefList.'\',\''.$_SESSION['prdLst'][$NameRefList]['ordBy'].'\',\''.'\','.($posActual = $_SESSION['prdLst'][$NameRefList]['pagIni']+$_SESSION['prdLst'][$NameRefList]['pagRng']).','.$_SESSION['prdLst'][$NameRefList]['pagRng'].',\'N\')">'.'></button>';
			else
			  $adelante .= '&nbsp;';

			if($_SESSION['prdLst'][$NameRefList]['cRws'] >= $finalCuantas = (intval($_SESSION['prdLst'][$NameRefList]['cRws']/$_SESSION['prdLst'][$NameRefList]['pagRng'])*$_SESSION['prdLst'][$NameRefList]['pagRng'])){
				if ($_SESSION['prdLst'][$NameRefList]['cRws'] == $finalCuantas)
				   $final = '<button class="'.$_SESSION['prdLst'][$NameRefList]['stBtnPag'].'" onclick="'.$this->prefAjax.'myListMove(\''.$NameRefList.'\',\''.$_SESSION['prdLst'][$NameRefList]['ordBy'].'\',\''.'\','.((intval($_SESSION['prdLst'][$NameRefList]['cRws']/$_SESSION['prdLst'][$NameRefList]['pagRng'])*$_SESSION['prdLst'][$NameRefList]['pagRng'])-$_SESSION['prdLst'][$NameRefList]['pagRng']).','.$_SESSION['prdLst'][$NameRefList]['pagRng'].',\'N\')">>></button>';
				else
				   $final = '<button class="'.$_SESSION['prdLst'][$NameRefList]['stBtnPag'].'" onclick="'.$this->prefAjax.'myListMove(\''.$NameRefList.'\',\''.$_SESSION['prdLst'][$NameRefList]['ordBy'].'\',\''.'\','.(intval($_SESSION['prdLst'][$NameRefList]['cRws']/$_SESSION['prdLst'][$NameRefList]['pagRng'])*$_SESSION['prdLst'][$NameRefList]['pagRng']).','.$_SESSION['prdLst'][$NameRefList]['pagRng'].',\'N\')">>></button>';
			}else
			$final = '&nbsp;';
			 
			$mitad = '';

			$numeroPaginas = intval($_SESSION['prdLst'][$NameRefList]['cRws'] / $_SESSION['prdLst'][$NameRefList]['pagRng']);
			
			if ($numeroPaginas>5)
			   $numeroPaginas = 5;
			   
			   
			if (!isset($_SESSION['prdLst'][$NameRefList]['acPag']))
			   $_SESSION['prdLst'][$NameRefList]['acPag'] = 0;

			for ($i = ($_SESSION['prdLst'][$NameRefList]['acPag']-3); $i <= ($_SESSION['prdLst'][$NameRefList]['acPag']+3); $i++){
				
				if ($i < 0 || $i > intval($_SESSION['prdLst'][$NameRefList]['cRws'] / $_SESSION['prdLst'][$NameRefList]['pagRng'])){
				   $page = '';
				}else{
					if ($i < $_SESSION['prdLst'][$NameRefList]['tcPag']){
						if (($i == $_SESSION['prdLst'][$NameRefList]['acPag'])){
					   		$page = '<strong><u>'.($i+1).'</u></strong>';
						}else{
					   		$page = ($i+1);
						}
					}else{
						$page = '';
					}
				}

				if (!$page)
				   $mitad.='<td width="36px" align="center">&nbsp;</td>';
				else
				   $mitad.='<td width="36px" align="center"><button onclick="'.$this->prefAjax.'myListMove(\''.$NameRefList.'\',\''.$_SESSION['prdLst'][$NameRefList]['ordBy'].'\',\''.'\','.($i*$_SESSION['prdLst'][$NameRefList]['pagRng']).','.$_SESSION['prdLst'][$NameRefList]['pagRng'].',\'N\')" style="text-align: center" class="'.$_SESSION['prdLst'][$NameRefList]['stBtnPag'].'">'.$page.'</button></td>';
			}
			 
			$buf .= '<table align="center" border="0" width="466">'."\n";
			$buf .= '<tr>'."\n";
			$buf .= '<td align="center" width="50"><button class="'.$_SESSION['prdLst'][$NameRefList]['stBtnPag'].'" onclick="'.$this->prefAjax.'myListMove(\''.$NameRefList.'\',\''.$_SESSION['prdLst'][$NameRefList]['ordBy'].'\',\''.'\',0,'.$_SESSION['prdLst'][$NameRefList]['pagRng'].',\'N\')"><<</button></td>'.''.'<td align="center" width="50">'.$atras.'</td>'.$mitad.'<td align="center" width="50">'.$adelante.'</td>'.'<td align="center" width="50">'.$final.'</td>'."\n";
			$buf .= '</tr>'."\n";

			$buf .= '</table>'."\n";

			$buf .= '</td></tr></table>'."\n";
		}
		 
		if ($this->NewList)
		   $buf .='</div>'."\n";

		$buf .= '<!-- Fin de Lista Dinamica: '.$NameRefList.' -->'."\n";
		
		
		return $buf;
	}
	 

	private function tildesHTML ($htmlTitldes){
		
		$Replace = array ("á","é","í","í","ó","ú","à","è","ì","ò","ù","Á",
						"É","Í","Ó","Ú","â","ê","î","ô","û","À","È","Ì","Ò",
						"Ù","ä","ë","ï","ö","ü","ñ","Ñ");
		
		$In = array ("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&agrave;",
					"&egrave;","&igrave;","&ograve;","&ugrave;","&Aacute;","&Eacute;",
					"&Iacute;","&Oacute;","&Uacute;","&acirc;","&ecirc;","&icirc;",
					"&ocirc;","&ucirc;","&Agrave;","&Egrave;","&Igrave;","&Ograve;",
					"&Ugrave;","&auml;","&euml;","&iuml;","&ouml;","&uuml;","&ntilde;",
					"&Ntilde;");
		
		$htmlTitldes = str_replace ($Replace,  $In, $htmlTitldes);

		return $htmlTitldes;
	}
		
}


/**
 * Extesion de la clase myList
 * para mejorar el proceso del
 * llamado de las listas dinam
 * icas.
 *
 */
class myDinamicList1 extends myList {

	/**
	 * Usa o no la primera fila de resultado y la 
	 * concatena con un numero indice de referencia
	 * incremental.
	 *
	 * @var boolean
	 */
	public $STYLE_use_col_enum = false;
	
	/**
	 * Establece el color del Borde de la Lista Dinamica
	 *
	 * @var string
	 */
	public $STYLE_color_borde = '#E2E4FF';

	/**
	 * Establece el estilo de los titulos del formulario de filtro de lista
	 *
	 * @var string
	 */
    public $STYLE_clase_titulo_filtro;	
	
	/**
	 * Establece el color de las entre filas de la Lista Dinamica
	 *
	 * @var string
	 */
	public $STYLE_color_fila_del_medio = '#E7F4FE';

	/**
	 * Establece el color de la fila por defecto de la Lista Dinamica
	 *
	 * @var string
	 */
	public $STYLE_color_fila_defecto = '#FFFFFF';

	/**
	 * Establece el color de la primera fila de la Lista Dinamica
	 *
	 * @var string
	 */
	public $STYLE_color_cabeza_columna = '#ECEEFF';

	/**
	 * Establece el color de la columna seleccionada de la Lista Dinamica
	 * (Aplica solo cuando el Ordenamiento Dinamico por columna esta habilitado)
	 *
	 * @var string
	 */
	public $STYLE_color_columna_seleccionada  = '#F5F5F5';


	/**
	 * Color de fondo para las filas cuando el puntero de mouse pasa sobre ellas
	 *
	 * @var string
	 */
	public $STYLE_color_over_fila = '#91FF91';
	
	/**
	 * Color de fondo para las filas cuando se hace click sobre una de ellas
	 *
	 * @var string
	 */
	public $STYLE_color_marked_fila = '#FFC0C0';
	
	
	/**
	 * Establece el color de la celda en donde se encuentra
	 * el titulo de parametrizacion del formulario de la
	 * lista dinamica
	 *
	 * @var string
	 */
	public $STYLE_color_celda_titulo_formulario;

	/**
	 * Establece si se va a usar o no distincion por filas
	 * (Pintara de a una columna de por medio de diferente color a las demas)
	 *
	 * @var boolean
	 */
	public $STYLE_usar_distincion_filas = true;

	/**
	 * Establece la clase del estilo que usan los textos en la primera fila de la Lista Dinamica
	 * (No aplica para los enlaces de esa primera fila)
	 *
	 * @var string
	 */
	public $STYLE_estilo_cabeza_columnas = 'enlace_tabla';

	/**
	 * Establece la clase del estilo para los enlaces que dentro de la Lista Dinamica
	 *
	 * @var string
	 */
	public $STYLE_estilo_enlaces = 'enlace_tabla';

	
	/**
	 * Estilo aplicable para los botones que paginan la lista dinamica
	 *
	 * @var string
	 */
	public $STYLE_estilo_botones_paginacion = 'botones_paginacion';
	
	
	/**
	 * Establece la clase del estilo que los datos que se muestran usaran en la Lista Dinamica
	 *
	 * @var string
	 */
	public $STYLE_estilo_datos = 'contenido_tabla';

	/**
	 * Estable el titulo del formulario de parametrizacion que se usa en la Lista Dinamica
	 *
	 * @var string
	 */
	public $STYLE_titulo_formulario_parametros;
		
	/**
	 * Estable la clase del estilo del titulo de filtro de la lista dinamica
	 *
	 * @var string
	 */
	public $STYLE_estilo_titulo_formulario_parametros;
	
	
	/**
	 * Establece el ancho en px de la Lista Dinamica
	 *
	 * @var integer
	 */
	public $STYLE_ancho_lista = '100%';


	/**
	 * Ruta de la imagen de fondo para las cabezas de las columnas seleccionadas
	 *
	 * @var string
	 */
	public $STYLE_ruta_imagen_fondo_cabeza_columna_seleccionada = '../../img/my_dinamiclist/col_selected.gif';


	/**
	 * Ruta de la imagen de fondo para las cabezas de las columnas por defecto
	 *
	 * @var string
	 */
	public $STYLE_ruta_imagen_fondo_cabeza_columna = '../../img/my_dinamiclist/col_default.gif';


	/**
	 * Ruta de la imagen de fondo para el titulo del formulario de parametrizacion
	 *
	 * @var string
	 */
	public $STYLE_ruta_imagen_fondo_titulo_formulario;


	/**
	 * Establece la ruta de la Imagen de Orden Ascendente.
	 *
	 * @var string
	 */
	public $STYLE_srcImageASC = '../../img/my_dinamiclist/asc.gif';


	/**
	 * Establece la ruta de la Imagen de Orden Descendente.
	 *
	 * @var string
	 */
	public $STYLE_srcImageDESC = '../../img/my_dinamiclist/desc.gif';


	private $objMyList; 
	
	
	/**
	 * Permite definir los parametros iniciales para poder generar el HTML que crea la clase.
	 *
	 * @param string  $name                Referencia Nombre de referencia unico para la lista
	 * @param string  $sqlSelectTabla      Consulta a la base de datos en formato sql
	 * @param boolean $useUniqueList	   Permiete hacer ahorro de variables en la sesion del usuario	
	 */
	public function __construct ($name, $sqlSelectTabla = '', $useUniqueList = false){
 	
		if (!$name)
		   die('List name reference required.');

		if ($useUniqueList){
			   
			if (!isset($_SESSION['listInUse'])){
		   	$_SESSION['listInUse'] = $name;
		   
			}else{
			
		   		if ($name!=$_SESSION['listInUse']){
		   	
		   	  		foreach($_SESSION['prdLst'] as $list => $cont){
		   	  	    		if ($name!=$list)
		   	           			unset($_SESSION['prdLst'][$list]); 	
		   	  		}
		   		}
		   	$_SESSION['listInUse'] = $name;
			}
		}
		
		
		$this->objMyList = new myList;
	    $this->objMyList->myList_preparate($name, $sqlSelectTabla);
	}


	/**
	 * Obtiene el HTML generado por la lista dinamica
	 *
	 * @param string  $name              Nombre de referencia de la lista
	 * @param boolean $useFormLookingFor Usar o no un formulario de Filtro de registros
	 * @return string
	 */
	public function getDinamicList($name, $useFormLookingFor = true){
		$htmlForm = '';
		$htmlList =  $this->objMyList->getDinamicList($name);
		 
		if ($useFormLookingFor)
			$htmlForm = $this->objMyList->getFormParams($name);

		return  $htmlForm.$htmlList;
	}


	/**
	 * Guarda las caracteristicas de estilo de visualizacion
	 * de la lista dinamica.
	 *
	 * @param string $name  Nombre de Referencia de la lista Dianmica
	 */
	public function savePreferences ($name){
		$this->setStyleList($name);
	}


	/**
	 * Imprime el HTML para mostrar directamente la lista
	 * en el HTML.
	 *
	 * @param string  $name               Nombre de Referencia de la lista Dianmica
	 * @param boolean $useFormLookingFor  Mostrar o no formulario de parametrizacion de la lista Dinamica
	 * @return string
	 */
	public function showDinamicList ($name, $useFormLookingFor = true){
		return $this->getDinamicList($name, $useFormLookingFor);
	}


	/**
	 * Configura la propiedad Show Order Method
	 * Para permitir o no mediante un valor booleano
	 * si se va a generar una lista con columna que se
	 * permitan ordenar
	 *
	 * @param string  $name      Nombre de referencia de la lista dinamica
	 * @param boolean $boolValue Apagar o encender
	 */
	public function setShowOrderMethod($name, $boolValue = true){
		$this->objMyList->setShowOrderMethod($name, $boolValue);
	}

	/**
	 * Obtiene el HTML necesario que es el que
	 * se muestra como formulacio de consulta de
	 * parametrizacion de los datos que se tienen
	 *
	 * @param string $name Nombre de referencia de la lista dinamica
	 * @return string
	 */
	public function getFormLookingFor ($name){
		if (!isset($_SESSION['prdLst'][$name]['arClsInLst']))
		   $this->objMyList->getDinamicList();
		return $this->objMyList->getFormParams();
	}

	/**
	 * Configura las paginacion de la lista
	 * dinamica.
	 *
	 * @param string  $name Nombre de referencia de la lista dinamica
	 * @param integer $numberRowForPage Numero de registros por pagina
	 */
	public function setPagination ($name, $numberRowForPage){
		$this->objMyList->setPagination($name, $numberRowForPage);
	}

	
	/**
	 * Beta de agrupamiento de resultado por columna
	 *
	 * @param string  $name				Nombre de referencia de la lista dinamica
	 * @param string  $strFieldAlias	Nombre del campo de la lista (Debe ser igual al ALias de la columna)
	 * @param boolean $orderAsc			Hacer o no un ordenamiento del agrupamiento en el filtro para filtrar por el
	 */
	public function setFilterByColumn ($name, $strFieldAlias, $orderAsc = false){
		$this->objMyList->setFilterByColumn($name, $strFieldAlias, $orderAsc);
	}
	
	
	/**
	 * Configura una columna que se esta mostrando de
	 * resultado en la lista dinamica para que esta tenga
	 * un enlace que permita realizar alguna accion javascript
	 * o xajax. Esta funcion por defecto mandara el valor que
	 * se esta mostrando y este no podra ser cambiado.
	 *
	 * @param string $name          Nombre de referencia de la lista dinamica
	 * @param string $strFieldAlias Nombre del campo de la lista (debe ser igual al Alias de la columna)
	 * @param string $strJSFunction Nombre de la funcion que ejecutara
	 * @param string $strLabel      Etiqueta del enlace si no se quiere mostrar el contenido
	 * @param string $strConfirm    String del confirm (Javascript S/N) que pueda tener ese enlace
	 */
	public function setColumn ($name, $strFieldAlias, $strJSFunction, $strLabelOrCheckbox = '', $strConfirm = ''){
		$strLabel = $strLabelOrCheckbox;
		$this->objMyList->addColum($name, $strFieldAlias, $strJSFunction, $strLabel, $strConfirm);
	}

	/**
	 * Configura una columna del resultado de la consulta para que
	 * esta sea asociada con un arreglo pasado como parametro a la
	 * funcion de tal forma que no se muestren los valores ordinarios
	 * de la tabla si no el valor correspondiente definido por la
	 * llave del subindice del arreglo.
	 * Ejemplo: Si en mi lista dinamica voy a tener un resultado que
	 * no va a variar de unos limitados a 'S' o 'N', uno puede definir
	 * un arreglo de la como array('S'=>'Si Aplica','N'=>'No Aplica');
	 * De esa forma no se mostrarian los valores ordinarios 'S' o 'N'
	 * si no los valores correspondientes definidos dentro del arreglo.
	 *
	 * @param string $name          Nombre del referencia de la lista dinamica
	 * @param string $strFieldAlias Alias de la columna a la cual se va a asociar
	 * @param array  $mixedArray    Arreglo con los indices y los valores a reemplazar en la columna
	 */
	public function mixColumnInArray ($name, $strFieldAlias, $mixedArray){
		$this->objMyList->mixColumnInArray($name, $strFieldAlias, $mixedArray);
	}


	/**
	 * Setea una columna de la lista dinamica para que el valor devuelto en la
	 * consulta sea procesado adicionalmente por un funcion de php que recibira
	 * como parametro el valor obtenido del Alias de la consulta para la lista
	 * dinamica en proceso.
	 *
	 *
	 * @param string $name           Nombre de referencia de la lista dinamica
	 * @param string $strFieldAlias  Alias de la columna a la cual se va a asociar
	 * @param object $objClass       Objecto instanciado de la clase que contiene los metodos de interes
	 * @param string $strNameMethod  Nombre del metodo (funcion) que desea ejecutar que viene
	 */
	public function setFunctionInColumn ($name, $strFieldAlias, $objClass, $strNameMethod){
		$this->objMyList->setFunctionInColumn($name, $strFieldAlias, $objClass, $strNameMethod);
	}


	/**
	 * Setea la confugiracion de un columna para acomodar en porcentaje
	 * o en numero de pixeles el valor que este esta ocupando.
	 *
	 * @param string  $name      Nombre de referencia de la lista dinamica.
	 * @param string  $strAlias  Alias de la columna a la que se va a asociar.
	 * @param integer $intWidth  Valor del width de la columna segun el Alias de el.
	 */
	public function setWidthByColumn ($name, $strAlias, $intWidth){
		$this->objMyList->setWidthByColumn($name, $strAlias, $intWidth);
	}

	/**
	 * Configura la visualizacion de la Lista dinamica
	 * o los estilos de acuerdo a unos parametros standar que son:
	 * color_borde, color_fila_del_medio, color_fila_defecto,
	 * color_cabeza_columna, color_columna_seleccionada,
	 * usar_distincion_filas, estilo_cabeza_columnas,
	 * estilo_enlaces, estilo_datos, titulo_formulario_parametros y
	 * ancho_lista para que se acomode a lo que el programador quiere mostrar.
	 *
	 * @param string $name        Nombre de la lista
	 * @param string $strAtribute Nombre del atributo grafico que se va a modificar
	 * @param string $strValue    Valor nuevo por el que se va a reemplazar
	 */
	private function setStyleList ($name){
		
		$_SESSION['prdLst'][$name]['usClEn'] = $this->STYLE_use_col_enum;;
		
		if ($this->STYLE_ruta_imagen_fondo_titulo_formulario){
		   $_SESSION['prdLst'][$name]['sImBkTlFrmPrms'] = $this->STYLE_ruta_imagen_fondo_titulo_formulario;
		}
		 
		if ($this->STYLE_ruta_imagen_fondo_cabeza_columna_seleccionada){
		   $_SESSION['prdLst'][$name]['sImBkHdClSel'] = $this->STYLE_ruta_imagen_fondo_cabeza_columna_seleccionada;
		}

		if ($this->STYLE_ruta_imagen_fondo_cabeza_columna){
		   $_SESSION['prdLst'][$name]['sImBkHdClDf'] = $this->STYLE_ruta_imagen_fondo_cabeza_columna; 
		}
		 
		if ($this->STYLE_color_celda_titulo_formulario){
		   $_SESSION['prdLst'][$name]['bgCrCeTlFrm'] = $this->STYLE_color_celda_titulo_formulario;
		}
		 
		if ($this->STYLE_color_borde){
		   $_SESSION['prdLst'][$name]['brCr'] = $this->STYLE_color_borde;
		}
		 
		if ($this->STYLE_color_fila_del_medio){
		   $_SESSION['prdLst'][$name]['bgCrRwStr'] = $this->STYLE_color_fila_del_medio;
		}
		 
		if ($this->STYLE_color_fila_defecto){
		   $_SESSION['prdLst'][$name]['dfRwBgCr'] = $this->STYLE_color_fila_defecto;
		}

		if ($this->STYLE_color_cabeza_columna){
		   $_SESSION['prdLst'][$name]['dfCrClTbHd'] = $this->STYLE_color_cabeza_columna;
		}

		if ($this->STYLE_color_columna_seleccionada){
		   $_SESSION['prdLst'][$name]['dfCrClSel'] = $this->STYLE_color_columna_seleccionada;
		}
		
		if ($this->STYLE_color_over_fila){
		   $_SESSION['prdLst'][$name]['dfCrRwHov'] = $this->STYLE_color_over_fila;
		}
		
		if ($this->STYLE_color_marked_fila){
		   $_SESSION['prdLst'][$name]['dfCrRwMrk'] = $this->STYLE_color_marked_fila;
		}

		if ($this->STYLE_usar_distincion_filas){
		   $_SESSION['prdLst'][$name]['usRwStr'] = $this->STYLE_usar_distincion_filas;
		}

		if ($this->STYLE_estilo_cabeza_columnas){
		   $_SESSION['prdLst'][$name]['stTlCl'] = $this->STYLE_estilo_cabeza_columnas;
		}

		if ($this->STYLE_estilo_enlaces){
		   $_SESSION['prdLst'][$name]['stPagLk'] = $this->STYLE_estilo_enlaces;
		}

		if ($this->STYLE_estilo_botones_paginacion){
		   $_SESSION['prdLst'][$name]['stBtnPag'] = $this->STYLE_estilo_botones_paginacion;
		}
		
		if ($this->STYLE_estilo_datos){
		   $_SESSION['prdLst'][$name]['stCtTb'] = $this->STYLE_estilo_datos;
		}
			
		if ($this->STYLE_titulo_formulario_parametros){
		   $_SESSION['prdLst'][$name]['sTlFrmFlt'] = $this->STYLE_titulo_formulario_parametros;
		}
		
		if ($this->STYLE_estilo_titulo_formulario_parametros){
		   $_SESSION['prdLst'][$name]['stTlFrmFlt'] = $this->STYLE_estilo_titulo_formulario_parametros;
		}

		if ($this->STYLE_ancho_lista){
		   $_SESSION['prdLst'][$name]['wTb'] = $this->STYLE_ancho_lista;
		}
		
		if ($this->STYLE_srcImageASC){
			$_SESSION['prdLst'][$name]['iOrdA'] = $this->STYLE_srcImageASC;
		}
		   
		if ($this->STYLE_srcImageDESC){
			$_SESSION['prdLst'][$name]['iOrdD'] = $this->STYLE_srcImageDESC;
		}
		
	}
	
	public function __destruct(){
		
	}
	
}

?>