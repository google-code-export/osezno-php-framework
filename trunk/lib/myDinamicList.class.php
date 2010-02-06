<?php

class myList  {
	
	/**
	 * Anchura de la tabla que contiene la lista
	 * 
	 * @var integer
	 */
	private $ATTR_WIDTH_LIST = 1000;
	
	/**
	 * Formato aplicado a la anchura de la tabla que 
	 * contiene la lista.
	 * 
	 * @var string
	 */
	private $ATTR_FORMAT_WIDTH_LIST = 'px';
	
	/**
	 * Color de borde de la lista
	 * 
	 * @var string
	 */
	private $ATTR_BORDER_COLOR = '#E2E4FF';
	
	/**
	 * Tamaño del borde de la lista entre celdas
	 * 
	 * @var integer
	 */
	private $ATTR_BORDER_CELL_SIZE = 1;
	
	/**
	 * Estilo del contenido de los datos 
	 * 
	 * @var string
	 */
	private $ATTR_DATA_CONTENT_STYLE = 'contenido_tabla';
	
	/**
	 * Estilo de titulo de las columnas 
	 * 
	 * @var string
	 */
	private $ATTR_COLUMN_TITLE_STYLE = 'enlace_tabla';
	
	/**
	 * Color de fondo de las filas por defecto.
	 * 
	 * @var string
	 */
	private $ATTR_DEFAULT_ROW_COLOR = '#FFFFFF';
	
	/**
	 * Color de fondo de filas cuando la distinción
	 * de filas estas activa.
	 * 
	 * @var string
	 */
	private $ATTR_MIDDLE_ROW_COLOR = '#E7F4FE';
	
	/**
	 * Usar distincion entre filas
	 * 
	 * @var bool
	 */
	private $ATTR_USE_DISTINCT_BETW_ROWS = true;
	
	private $bufHtml = '';
	
	private $objConn;
	
	private $sql = '';
	
	private $resSql;
	
	public function __construct($sqlORobject){

		if (is_object($sqlORobject)){
			
			$this->objConn = $sqlORobject;
			
			$this->resSql = $sqlORobject->find();
			
			$this->sql = $sqlORobject->getSqlLog();
			
		}else{
			
			$this->objConn = new myActiveRecord();
			
			$this->sql = $sql;		
			
			$this->resSql = $this->objConn->query ($this->sql);
			
		}
		
		
	}
	
	public function setAttribute ($name, $value){
		
		$this->$name = $value;
		
	}
	
	
	public function getAttribute ($name){
		
		return $this->$name;
	}
	
	private function buildList (){

		$sw = false;
		$return = '';
			
		$rows = $this->resSql;
		$buf = '';
		$buf .=  "\n".'<table width="'.$this->ATTR_WIDTH_LIST.''.$this->ATTR_FORMAT_WIDTH_LIST.'" cellspacing="0" cellpadding="0"><tr><td bgcolor="'.$this->ATTR_BORDER_COLOR.'">'."\n";
		
		$buf .=  "\n".'<table width="100%" cellspacing="'.$this->ATTR_BORDER_CELL_SIZE.'" cellpadding="0">'."\n";

		$i = 0;
		foreach ($rows as $row){

				if ($this->ATTR_USE_DISTINCT_BETW_ROWS){
					if ($i%2)
						$bgColor = $this->ATTR_DEFAULT_ROW_COLOR;
					else	
						$bgColor = $this->ATTR_MIDDLE_ROW_COLOR;
				}else
					$bgColor = $this->ATTR_DEFAULT_ROW_COLOR;			
			
			if (!$sw){
				$sw = true;
				
				$buf.='<tr>'."\n"."\t";
				
				foreach ($row as $key => $val){
					if (!is_numeric($key)){
						$buf.='<td class="'.$this->ATTR_COLUMN_TITLE_STYLE.'">'.ucwords($key).'</td>';	
					}
				}
				$buf.="\n".'</tr>'."\n";
			}
			
						
			$buf.='<tr>'."\n"."\t";

			
			foreach ($row as $key => $val){
				if (!is_numeric($key)){
					if (!$val)
					   $Value = '&nbsp;';
					$buf.='<td bgcolor="'.$bgColor.'" class="'.$this->ATTR_DATA_CONTENT_STYLE.'">'.$val.'</td>';
				}
				
			}

			$buf.= "\n".'</tr>'."\n";
			$i++;
		}
			
		$buf .=  '</table>'."\n";
		
		$buf .=  '</td></tr></table>'."\n";
				
		$this->bufHtml = $buf;
		
	}
	
	public function getList (){
		
		$this->buildList();
		
		return $this->bufHtml;
	}
	
	
}


class myDinamicListt {
	
	/**
	 * Version de la clase
	 */
	public $version = '1.8';
	
	/**
	 * Suma total de los anchos de las columnas en total
	 *
	 * @var integer
	 */
	private $sumWidthByColumn = 100;
	
	/**
	 * Define el ancho de la lista dinamica
	 */
	public $STYLE_ancho_lista = '100%';#
	
	/**
	 * Define el nombre de la clase de la hoja de estilos 
	 * que aplicara para los botones que paginan la lista 
	 *
	 * @var string
	 */
	public $STYLE_estilo_botones_paginacion = 'botones_paginacion';
	
	/**
	 * Color del borde de la tabla
	 *
	 * @var string
	 */
	public $STYLE_color_borde = '#E2E4FF';#
	
	
	/**
	 * Usar o no disticion entre las filas
	 *
	 * @var boolean
	 */
	public $STYLE_usar_distincion_filas = true;
	
	/**
	 * Color de las filas de registros que usan
	 * por defecto.
	 *
	 * @var string
	 */
	public $STYLE_color_fila_defecto = '#FFFFFF';#

	/**
	 * Color de la fila de por medio que se usa
	 * por defecto.
	 *
	 * @var string
	 */
	public $STYLE_color_fila_del_medio = '#E7F4FE';#
	
	/**
	 * Color de fondo para las filas cuyo cursor pase
	 * sobre ellas.
	 *
	 * @var string
	 */
	public $STYLE_color_over_fila = '#91FF91'; 
	
	/**
	 * Color de fondo sobre de la columna por la cual se esta
	 * ordenando
	 *
	 * @var string
	 */
	public $STYLE_color_columna_seleccionada = '#F5F5F5';
	
	/**
	 * Color de la fila que se marca al hacer click sobre
	 * ella
	 *
	 * @var string
	 */
	public $STYLE_color_marked_fila = '#FFC0C0';
	
	/**
	 * Ruta de la imagen de fondo para los titulos de las
	 * columnas que han sido seleccionadas por el metod de
	 * ordenamiento
	 *
	 * @var string
	 */
	public $STYLE_ruta_imagen_fondo_cabeza_columna_seleccionada = 'col_selected.gif';
	
	/**
	 * Ruta de la imagen de fondo para los titulos de las
	 * columnas por defecto que no han sido seleccionadas
	 * para ordenamiento.
	 *
	 * @var string
	 */
	public $STYLE_ruta_imagen_fondo_cabeza_columna = 'col_default.gif';
	
	/**
	 * Nombre de la clase de la hoja de estilos que aplica 
	 * para los datos que se vana a mostrar dentro de los
	 * resultados de la consulta
	 *
	 * @var string
	 */
	public $STYLE_estilo_datos = 'contenido_tabla';#

	/**
	 * Nombre de la clase de estilos que usan los titulos
	 * de las columnas
	 *
	 * @var string
	 */
	public $STYLE_estilo_cabeza_columnas = 'enlace_tabla';#
		
	
	/**
	 * Establece la ruta de la Imagen de Orden Ascendente de ordenamiento
	 * para una columna
	 *
	 * @var string
	 */
	public $STYLE_srcImageASC = 'asc.gif';


	/**
	 * Establece la ruta de la Imagen de Orden Descendente de ordenamiento
	 * para una columna
	 *
	 * @var string
	 */
	public $STYLE_srcImageDESC = 'desc.gif';
	
	
	/**
	 * Estable la ruta de la Imagen usada para identificar un filtro 
	 * para una columna
	 * 
	 * @var string
	 */
	public $STYLE_srcImageFilter = 'filtrar.gif';
	
	
	/**
	 * Etiqueta de la opcion Todos para un filtro en una
	 * columna especifica donde el filtro este activo.
	 * 
	 * @var string
	 */
	public $strValAllOptionInFilter = '[Todos]';
	
	
	/**
	 * Path subcarpeta dentro de la carpeta principal del poryecto
	 *
	 * @var string
	 */
	public $subFolder_inImg = '/img/my_dinamiclist/';
	
	
	/**
	 * Sql consulta original
	 *
	 * @var string
	 */
	private $sqlLst = '';
	
	/**
	 * Id de la lista dinamica
	 *
	 * @var string
	 */
	private $idLst = '';
	
	/**
	 * Objeto Active Record
	 *
	 * @var object
	 */
	private $objActRcrd;
	
	/**
	 * Constructor de la clase
	 *
	 * @param string $idLst  Nombre de la lista dinamica
	 * @param string $sqlLst Sql consulta original
	 */
	public function __construct($idLst, $sqlLst = ''){
		
		$this->sqlLst = $sqlLst; 
		
		$this->idLst = $idLst;
		
		$this->objActRcrd = new myActiveRecord();
		
		$_SESSION['prdLst'][$idLst]['enD'] = $this->objActRcrd->getEngine();
		
		$_SESSION['prdLst'][$idLst]['sqlt'] = $_SESSION['prdLst'][$idLst]['sql'] = $sqlLst;

		/**
		 * Definiciones de variables
		 */
		$_SESSION['prdLst'][$idLst]['usPag'] = '';
		$_SESSION['prdLst'][$idLst]['aordBy'] = '';
		$_SESSION['prdLst'][$idLst]['shwOrdMet'] = '';
		$_SESSION['prdLst'][$idLst]['pagRng'] = 0;
		$_SESSION['prdLst'][$idLst]['shwOrdMet'] = '';
		$_SESSION['prdLst'][$idLst]['arWdtByCl'] = array ();
		$_SESSION['prdLst'][$idLst]['arWdtByCl'] = array ();
		
		if (!isset($_SESSION['prdLst'][$idLst]['pagIni']))
			$_SESSION['prdLst'][$idLst]['pagIni'] = 0;
		
		$_SESSION['prdLst'][$idLst]['ordBy'] = '';
		$_SESSION['prdLst'][$idLst]['ordMtd'] = '';
		
	}
	
	/**
	 * Activa o inactiva el metodo de ordenamiento dentro
	 * de la lista dianmica
	 *
	 * @param string $idLst Nombre de la lista dinamica
	 * @param boolean $boolValue Activar o Inactivar
	 */
	public function setShowOrderMethod ($idLst, $boolValue){
		
	   $_SESSION['prdLst'][$idLst]['shwOrdMet'] = $boolValue;
	}	
	
	
	/**
	 * Activa la paginacion en la lista actual
	 *
	 * @param string $idLst Nombre de la lista dinamica
	 * @param integer $numRowXPage Numero de registros por pagina
	 */
	public function setPagination($idLst,$numRowXPage = 20){
		
		$_SESSION['prdLst'][$idLst]['usPag'] = true;
		
		$_SESSION['prdLst'][$idLst]['pagRng'] = $numRowXPage;
		
		if (!isset($_SESSION['prdLst'][$idLst]['pagIni']))
		   $_SESSION['prdLst'][$idLst]['pagIni'] = 0;
	}
	
	/**
	 * Setea el ancho por una columna determinada en porcentaje
	 * o en un valor fijo definido por un valor entero.
	 *
	 * @param string $idList Nombre de la lista dinamica
	 * @param string $aliasColumn 
	 * @param string $intWidth
	 */
	public function setWidthByColumn($idList, $aliasColumn, $intWidth){
		
		if (!isset($_SESSION['prdLst'][$idList]['arWdtByCl'][$aliasColumn]))
			$_SESSION['prdLst'][$idList]['arWdtByCl'][$aliasColumn] = $intWidth;
	}
	
	/**
	 * Agrega un enlace a una accion determinada por la funcion Js que 
	 * puede ser un llamado asincronico a un evento ajax.
	 * 
	 * @param $idList			Nombre de la lista dinamica
	 * @param $aliasField		Alias del campo al cual va ligado el enlace
	 * @param $nameJsFunction	Nombre del funcion JS o evento Ajax que se ejecutara
	 * @param $strLabel			Etiqueta que reemplazara el valor del registro donde esta el enlace
	 * @param $strConfirm		Cadena de texto de confirmacion
	 */
	public function setColumn($idList, $aliasField, $nameJsFunction, $strLabel = '', $strConfirm = ''){
		
		if (!isset($_SESSION['prdLst'][$idList]['aradCls'][$aliasField]))
			$_SESSION['prdLst'][$idList]['aradCls'][$aliasField] = array('alias' => $aliasField, 'function' => $nameJsFunction, 'label' => $strLabel, 'confirm' => $strConfirm);
			
		$_SESSION['prdLst'][$idList]['arClsAftd'] = array ();
	}
	
	
	/**
	 * Configura una columna para que el valor en ese
	 * momento mostrado sea asociado a un arreglo de 
	 * valores segun la llave con la que conincida el
	 * valor de la columna.
	 * 
	 * @param $idList		Nombre de la lista dinamica
	 * @param $aliasField	Alias del campo al cual va ligado el valor alterno
	 * @param $mixedValues	Arreglo con las llaves y los valores requeridos para mesclar los datos
	 */
	public function mixColumnInArray ($idList, $aliasField, $mixedValues){
		if (!isset($_SESSION['prdLst'][$idList]['arMxdCls'][$aliasField]))
		   $_SESSION['prdLst'][$idList]['arMxdCls'][$aliasField] = $mixedValues;		
	}
	
	
	/**
	 * Ejecuta el metodo de un objeto que viene de una clase
	 * externa a la clase de listas. Este metodo recibira lo
	 * que venga de la columna de la lista como parametro.
	 * No se puede mezclar con mixColumnInArray o setColumn.
	 * 
	 * @param $idList		Nombre de la lista dinamica
	 * @param $aliasField	Nombre del campo al cual va ligado el metodo	
	 * @param $objClass		Variable objeto de la clase
	 * @param $nameMethod	Nombre interno del metodo de la clase (Publico)
	 */
	public function setFunctionInColumn ($idList, $aliasField, $objClass, $nameMethod){
		if (!isset($_SESSION['prdLst'][$idList]['arFncInCl'][$aliasField]))
		   $_SESSION['prdLst'][$idList]['arFncInCl'][$aliasField] = array ('objClass'=>$objClass, 'nameMethod'=>$nameMethod);			
	} 
	
	
	/**
	 * Activa un filtro para esa columna por los valores que
	 * en ese momento se esten mostrando para agruparlos visualmente
	 * y permitir la seleccion de uno de ellos.
	 *  
	 * @param $idList			Nombre de la lista dinamica
	 * @param $aliasField		Nombre del del campo al cual va ligado el metodo 
	 * @param $orderValuesAsc	Ordenar por defecto los valores
	 */
	public function setFilterByColumn ($idList, $aliasField, $orderValuesAsc = false){
		if (!isset($_SESSION['prdLst'][$idList]['arClsInFlt'][$aliasField]))
			$_SESSION['prdLst'][$idList]['arClsInFlt'][$aliasField] = array ('orderasc'=>$orderValuesAsc);
	}
	
	
	/**
	 * Obtiene el HTML correspondiente a la lista dinamica
	 *
	 * @param string $idLst Nombre de la lista dinamica
	 */
	public function getDinamicList($idLst){
		$buf = '';

		/**
		 * Seteamos el nuevo valos de la sumas de ancho por
		 * columna al total del acho de la lista asignado.
		 */
		if (!strpos($this->STYLE_ancho_lista,'%')){
			
		}
		$this->sumWidthByColumn = $this->STYLE_ancho_lista;
		
		/**
		 * Verificamos si se ha iniciado el ordenamiernto por alguna columna
		 */
		if (isset($_SESSION['prdLst'][$idLst]['ordBy'])){
			
			if ($_SESSION['prdLst'][$idLst]['ordMtd']){
			   $_SESSION['prdLst'][$idLst]['sqlt'] .= ' ORDER BY '.$_SESSION['prdLst'][$idLst]['ordBy'].
			   ' '.$_SESSION['prdLst'][$idLst]['ordMtd'];
			}
				
		}		
		
		/**
		 * Verificamos si la paginacion esta activa para 
		 * definir los limites de registros segun el motor
		 * de la base de datos.
		 */
		if ($_SESSION['prdLst'][$idLst]['usPag'] == true){
			
			switch ($_SESSION['prdLst'][$idLst]['enD']){
				
				case 'mysql':
					$_SESSION['prdLst'][$idLst]['sqlt'] .= ' LIMIT '.$_SESSION['prdLst'][$idLst]['pagIni'].
					', '.$_SESSION['prdLst'][$idLst]['pagRng'];
				break;
				
				case 'postgre':
					$_SESSION['prdLst'][$idLst]['sqlt'] .= ' LIMIT '.$_SESSION['prdLst'][$idLst]['pagRng'].
					' OFFSET '.$_SESSION['prdLst'][$idLst]['pagIni'].';';
				break;
			}
		}
		
	    # Posicion del espacio despues del select
 		$posSpace = stripos($_SESSION['prdLst'][$idLst]['sql'],' ');
 
 		# Posicion del espacio despues del from
 		$posFrom = stripos($_SESSION['prdLst'][$idLst]['sql'],'from');
 
 		# Obtenemos solo lo que esta en el select
 		$select = substr($_SESSION['prdLst'][$idLst]['sql'],$posSpace,($posFrom-$posSpace));
 
		/**
		 * Ejecutamos la consulta temporal
		 */
		$Rows = $this->objActRcrd->query($_SESSION['prdLst'][$idLst]['sqlt']);
		
		if (!isset($_SESSION['prdLst'][$idLst]['cRws'])){
			
			$this->objActRcrd->query($_SESSION['prdLst'][$idLst]['sql']);
			
			$_SESSION['prdLst'][$idLst]['cRws']  = $this->objActRcrd->getAffectedRows();
			
			if ($_SESSION['prdLst'][$idLst]['usPag']){
				$_SESSION['prdLst'][$idLst]['tcPag'] = intval($_SESSION['prdLst'][$idLst]['cRws']/$_SESSION['prdLst'][$idLst]['pagRng']);
			
				if ($_SESSION['prdLst'][$idLst]['cRws']%$_SESSION['prdLst'][$idLst]['pagRng'])
	           		$_SESSION['prdLst'][$idLst]['tcPag'] ++;
			}  		

		}
		
		$buf .= '<!--'."\n";
		$buf .= 'OSEZNO FRAMEWORK'."\n";
		$buf .= 'Generado con la clase para la creacion de Listas Dinamicas myDinamicList.class.php'."\n";
		$buf .= 'Nombre de referencia de la Lista:'.$idLst."\n";
		$buf .= 'Autor: Jose Ignacio Gutierrez Guzman -  joselitohacker@yahoo.es'."\n";
		$buf .= 'Version de la Clase:'."\n";
		$buf .= '-->'."\n";		
		
		$buf .= '<div id="'.$idLst.'" name="'.$idLst.'">'."\n";
		
		$buf .= '<table width="'.$_SESSION['prdLst'][$idLst]['wTb'].'"  border="0" cellpadding="0" cellspacing="0" align="center">'."\n";
		$buf .= '<tr>'."\n";
		$buf .= '<td bgcolor="'.$_SESSION['prdLst'][$idLst]['brCr'].'">'."\n";
		
		$buf .= '<table width="100%"  border="0" cellpadding="0" cellspacing="1">'."\n";

		$count = 0;
		
		# Cadena de metodo de ordenamiento sobre las columnas
		$strOrdMetBeg = '';
		$strOrdMetEnd = '';
		
		$bufHead = '';
		$bufBody = '';
		
		$maxRows = count($Rows);
		$countRows = 1;
		 
		//$buf.=var_export($Rows,true);
		
		foreach ($Rows as $Row){
			
			/**
			 * Mostrar los registros segun la consulta
			 */
			
			# Preguntar si usamos o no distincion entre las filas
			if($_SESSION['prdLst'][$idLst]['usRwStr'] == true){
				if($count%2){
					$bgColor = $_SESSION['prdLst'][$idLst]['dfRwBgCr'];
				}
				else{
					$bgColor = $_SESSION['prdLst'][$idLst]['bgCrRwStr'];
				}					
			}else{
				$bgColor = $_SESSION['prdLst'][$idLst]['dfRwBgCr'];
			}
			
			$bufBody .= '<tr id="tr_'.$idLst.'_'.$count.'" '.
					'onmouseover="onRow(this, \''.$_SESSION['prdLst'][$idLst]['dfCrRwHov'].'\', \'td_'.$idLst.'_'.$count.'\')" '.
					'onmouseout="outRow(this, \''.$bgColor.'\', \'td_'.$idLst.'_'.$count.'\', \''.$_SESSION['prdLst'][$idLst]['dfCrClSel'].'\')" '.
					'onclick="markRow(this, \''.$_SESSION['prdLst'][$idLst]['dfCrRwMrk'].'\', \''.$bgColor.'\', \'td_'.$idLst.'_'.$count.'\', \''.$_SESSION['prdLst'][$idLst]['dfCrClSel'].'\')" '. 
					'bgcolor="'.$bgColor.'">'."\n";
			
			
			$countF = 0;
			foreach ($Row as $Key => $Value){
				
				if (!is_numeric($Key)){
					
					/**
					 * Preparar el Filtro por columna
					 */
					if (isset($_SESSION['prdLst'][$idLst]['arClsInFlt'][$Key])){
						
						if (!isset($arrayFilter))
							$arrayFilter =  array();

						$arrayFilter[$Key][$Value] = $Value;	
					}
					
					if (!$Value)
					   $Value = '&nbsp;';

					$idTd = '';   
					$antBgColor = $bgColor;
					$cadBgColor = '';
					if ($_SESSION['prdLst'][$idLst]['aordBy'] == $Key
						&&
						$_SESSION['prdLst'][$idLst]['ordMtd']){   
						
						$bgColor = $_SESSION['prdLst'][$idLst]['dfCrClSel'];
						$idTd = 'id="td_'.$idLst.'_'.$count.'"';
						$cadBgColor = ' bgcolor="'.$bgColor.'"';
					}
					
					if (isset($_SESSION['prdLst'][$idLst]['arMxdCls'][$Key])){
						
						if ($_SESSION['prdLst'][$idLst]['arMxdCls'][$Key][$Value]){
						
							$setColi = $_SESSION['prdLst'][$idLst]['arMxdCls'][$Key][$Value];
							
						}else{
							
							$setColi = $Value;
						}
							
					}else{
						
						if (isset($_SESSION['prdLst'][$idLst]['arFncInCl'][$Key])){

							$setColi = $_SESSION['prdLst'][$idLst]['arFncInCl'][$Key]['objClass']->$_SESSION['prdLst'][$idLst]['arFncInCl'][$Key]['nameMethod']($Value);
							
						}else{
						
							$setColi = $Value.'';
						}
						
					}
					
					$setCole = '';
					
					if (isset($_SESSION['prdLst'][$idLst]['aradCls'][$Key])){
						
						if (strpos($Value,',')){
							
						   $arPrmVls = explode (',',$Value);
						   
						   $prmVls = '';
						   
						   foreach($arPrmVls as $ivalue){
							 $prmVls.='\''.$ivalue.'\',';
						   }
						   
						   $prmVls = substr($prmVls,0,-1);
						   
						}else{
							
						   $prmVls = '\''.$Value.'\'';
						   
						}
						
						$attr = $_SESSION['prdLst'][$idLst]['aradCls'][$Key];
						
						$setColi = '<a href="javascript:void('.$attr['function'].'('.$prmVls.'));" ';
						
						if ($attr['confirm'])
						 $setColi .= 'onClick="return confirm(\''.$attr['confirm'].'\')" ';
						
						if ($attr['label'])
						 $setColi .= '>'.$attr['label'];
						else{
						  
						  if (isset($_SESSION['prdLst'][$idLst]['arMxdCls'][$Key])){
							if ($_SESSION['prdLst'][$idLst]['arMxdCls'][$Key][$Value])
								$setColi .= '>'.$_SESSION['prdLst'][$idLst]['arMxdCls'][$Key][$Value];
							else	
								$setColi .= '>'.$Value;	
						  }else
						    $setColi .= '>'.$Value;
						    
						}
						
						$setCole = '</a>';
					}
					
					
					$bufBody .= "\t".'<td '.$idTd.' class="'.$_SESSION['prdLst'][$idLst]['stCtTb'].'"'.$cadBgColor.'>';
					$bufBody .= $setColi.$setCole;
					$bufBody .= '</td>'."\n";
					
					$bgColor = $antBgColor;
				}
				
				$countF++;
				
			}
			
			$bufBody .= '</tr>'."\n";
			$count++;	
			
			
			
			/**
			 * Mostrar los titulos de cada una de las columnas
			 */
			if ($countRows == $maxRows){//head
				$sw = 1;
				$arrayKeys = array ();
				$orgArrayKeys = array_keys($Row);
				
				foreach ($orgArrayKeys  as $key => $value)
					if (!is_numeric($value)){
						$arrayKeys[$sw] = $value;
						$sw++;
					}
				
				$bufHead .= '<tr>'."\n";
				foreach ($arrayKeys as $ind => $value){
					
						# Ruta de la imagen que indica por que metodo esta ordenando
						$imgOrdBy = '&nbsp;';
						
						# Suministrar el link para el ordenamiento dependiendo si esta activo o no
						
						if ($_SESSION['prdLst'][$idLst]['shwOrdMet'] == true){

							$strOrdMetBeg = '<a class="'.$_SESSION['prdLst'][$idLst]['stTlCl'].
											'" href="javascript:;" onClick="myListMove(\''.$idLst.
											'\',\''.$ind.'\',\''.$_SESSION['prdLst'][$idLst]['pagIni'].
											'\',\''.$_SESSION['prdLst'][$idLst]['pagRng'].'\')">';
							$strOrdMetEnd = '</a>';
							
							if ($_SESSION['prdLst'][$idLst]['ordBy'] == $ind
								&&
								$_SESSION['prdLst'][$idLst]['ordMtd']){

									
								# Imagen de fondo para la columna seleccionada
						   		$sqtBkgTitleCol = $GLOBALS['urlProject'].$this->subFolder_inImg.
						   							$_SESSION['prdLst'][$idLst]['sImBkHdClSel'];
						   		
						   		# Seleccion del la imagen de fondo para los titulos de las columnas
						   		switch ($_SESSION['prdLst'][$idLst]['ordMtd']){
									case 'ASC':
										$imgOrdBy = '<img src="'.$GLOBALS['urlProject'].
										$this->subFolder_inImg.$_SESSION['prdLst'][$idLst]['iOrdA'].'" border="0">';										break;
									case 'DESC':
										$imgOrdBy = '<img src="'.$GLOBALS['urlProject'].
										$this->subFolder_inImg.$_SESSION['prdLst'][$idLst]['iOrdD'].'" border="0">';										break;
								}									
									
							}else
						   		$sqtBkgTitleCol = $GLOBALS['urlProject'].$this->subFolder_inImg.
						   							$_SESSION['prdLst'][$idLst]['sImBkHdClDf'];
							
						}else{
							
							$sqtBkgTitleCol = $GLOBALS['urlProject'].$this->subFolder_inImg.
												$_SESSION['prdLst'][$idLst]['sImBkHdClDf'];
							
						}
						

						if (isset($_SESSION['prdLst'][$idLst]['arWdtByCl'][$key])){
							
							$valWidth =  $_SESSION['prdLst'][$idLst]['arWdtByCl'][$key];
							
							$this->sumWidthByColumn -= intval($valWidth);
						}else{
							$valWidth = intval($this->sumWidthByColumn/($this->objActRcrd->getNumFieldsAffected()-count($_SESSION['prdLst'][$idLst]['arWdtByCl'])));
						}

						if (strpos($_SESSION['prdLst'][$idLst]['wTb'],'%')){
							$valWidth.='%';
						}
						
						$bufFilter = '&nbsp;';
						if (isset($arrayFilter[$value])){
							
							$idNameDiv 	 	= 'mydinlst_filter_'.$idLst.'_'.$value;
							$idNameSelect 	= 'mydinlst_select_filter_'.$idLst.'_'.$value;
							$styleDiv = 'visibility:hidden;overflow-y:hidden;overflow-x:hidden;width:auto;height:auto;position:absolute;';
							
							$bufFilter = '<a href="javascript:;" onClick="document.getElementById(\''.$idNameDiv.'\').style.visibility=\'visible\'"><img src="'.$GLOBALS['urlProject'].$this->subFolder_inImg.$this->STYLE_srcImageFilter.'" border="0"></a>';
							$bufFilter .= '<div id="'.$idNameDiv.'" name="'.$idNameDiv.'" style="'.$styleDiv.'">';
							
							$selectFilter = '<select size="5" id="'.$idNameSelect.'" name="'.$idNameSelect.'">';
							$selectFilter .= '<option value="">'.$this->strValAllOptionInFilter.'</option>';
							foreach ($arrayFilter[$value] as $valOpt){
								$selectFilter .= '<option value="'.$valOpt.'">'.$valOpt.'</option>';								
							}
							$selectFilter .= '</select>';
							
							
							$bufFilter .= $selectFilter.'</div>';
						}
						
						$bufHead .= "\t".'<td background="'.$sqtBkgTitleCol.'" class="'.
									$_SESSION['prdLst'][$idLst]['stTlCl'].'" width="'.$valWidth.'">';
									
						$bufHead .= '<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr><td width="10%">'.$bufFilter.'</td><td width="80%"><div style="text-align:center">'.
									$strOrdMetBeg.ucwords($value).$strOrdMetEnd.'</div></td><td width="10%">'.$imgOrdBy.'</td></table>';
									
						$bufHead .= '</td>'."\n";
						
					
				}
				$bufHead .= '</tr>'."\n";
				
			}//head	

			$countRows++;
			
		}
			
		
		$buf .= $bufHead;
		$buf .= $bufBody;
		// Buena funcion para generar
		//$buf .= $bufHead;
		
		$buf .= '</table>'."\n";	
			
		if ($_SESSION['prdLst'][$idLst]['usPag'] == true){
		    
			$buf .= '<table border="0" cellspacing="1" align="center" width="100%">'."\n";
		    
			$buf .= '<tr>'."\n".'<td>';

			if ($_SESSION['prdLst'][$idLst]['pagIni']>0)
			   $atras .= '<button class="'.$_SESSION['prdLst'][$idLst]['stBtnPag'].'" onclick="myListMove(\''.$idLst.'\',\''.$_SESSION['prdLst'][$idLst]['ordBy'].'\','.($posActual = $_SESSION['prdLst'][$idLst]['pagIni']-$_SESSION['prdLst'][$idLst]['pagRng']).','.$_SESSION['prdLst'][$idLst]['pagRng'].',\'N\')"><'.'</button>';
			else
			   $atras .= '&nbsp;';

			if(($_SESSION['prdLst'][$idLst]['pagIni']+$_SESSION['prdLst'][$idLst]['pagRng'])<$_SESSION['prdLst'][$idLst]['cRws'])
			  $adelante .= '<button class="'.$_SESSION['prdLst'][$idLst]['stBtnPag'].'" onclick="myListMove(\''.$idLst.'\',\''.$_SESSION['prdLst'][$idLst]['ordBy'].'\','.($posActual = $_SESSION['prdLst'][$idLst]['pagIni']+$_SESSION['prdLst'][$idLst]['pagRng']).','.$_SESSION['prdLst'][$idLst]['pagRng'].',\'N\')">'.'></button>';
			else
			  $adelante .= '&nbsp;';

			if($_SESSION['prdLst'][$idLst]['cRws'] >= $finalCuantas = (intval($_SESSION['prdLst'][$idLst]['cRws']/$_SESSION['prdLst'][$idLst]['pagRng'])*$_SESSION['prdLst'][$idLst]['pagRng'])){
				if ($_SESSION['prdLst'][$idLst]['cRws'] == $finalCuantas)
				   $final = '<button class="'.$_SESSION['prdLst'][$idLst]['stBtnPag'].'" onclick="myListMove(\''.$idLst.'\',\''.$_SESSION['prdLst'][$idLst]['ordBy'].'\','.((intval($_SESSION['prdLst'][$idLst]['cRws']/$_SESSION['prdLst'][$idLst]['pagRng'])*$_SESSION['prdLst'][$idLst]['pagRng'])-$_SESSION['prdLst'][$idLst]['pagRng']).','.$_SESSION['prdLst'][$idLst]['pagRng'].',\'N\')">>></button>';
				else
				   $final = '<button class="'.$_SESSION['prdLst'][$idLst]['stBtnPag'].'" onclick="myListMove(\''.$idLst.'\',\''.$_SESSION['prdLst'][$idLst]['ordBy'].'\','.(intval($_SESSION['prdLst'][$idLst]['cRws']/$_SESSION['prdLst'][$idLst]['pagRng'])*$_SESSION['prdLst'][$idLst]['pagRng']).','.$_SESSION['prdLst'][$idLst]['pagRng'].',\'N\')">>></button>';
			}else
			$final = '&nbsp;';
			 
			$mitad = '';

			$numeroPaginas = intval($_SESSION['prdLst'][$idLst]['cRws'] / $_SESSION['prdLst'][$idLst]['pagRng']);
			
			if ($numeroPaginas>5)
			   $numeroPaginas = 5;
			   
			   
			if (!isset($_SESSION['prdLst'][$idLst]['acPag']))
			   $_SESSION['prdLst'][$idLst]['acPag'] = 0;

			for ($i = ($_SESSION['prdLst'][$idLst]['acPag']-3); $i <= ($_SESSION['prdLst'][$idLst]['acPag']+3); $i++){
				
				if ($i < 0 || $i > intval($_SESSION['prdLst'][$idLst]['cRws'] / $_SESSION['prdLst'][$idLst]['pagRng'])){
				   $page = '';
				}else{
					if ($i < $_SESSION['prdLst'][$idLst]['tcPag']){
						if (($i == $_SESSION['prdLst'][$idLst]['acPag'])){
					   		$page = '<strong><u>'.($i+1).'</u></strong>';
						}else{
					   		$page = ($i+1);
						}
					}else{
						$page = '';
					}
				}

				if (!$page)
				   $mitad .= '<td width="36px" align="center">&nbsp;</td>'."\n";
				else
				   $mitad .= '<td width="36px" align="center"><button onclick="myListMove(\''.$idLst.'\',\''.$_SESSION['prdLst'][$idLst]['ordBy'].'\','.($i*$_SESSION['prdLst'][$idLst]['pagRng']).','.$_SESSION['prdLst'][$idLst]['pagRng'].',\'N\')" style="text-align: center" class="'.$_SESSION['prdLst'][$idLst]['stBtnPag'].'">'.$page.'</button></td>'."\n";
			}
			 
			$buf .= '<table align="center" border="0" width="466">'."\n";
			$buf .= '<tr>'."\n";
			$buf .= '<td align="center" width="50"><button class="'.$_SESSION['prdLst'][$idLst]['stBtnPag'].'" onclick="'.$this->prefAjax.'myListMove(\''.$idLst.'\',\''.$_SESSION['prdLst'][$idLst]['ordBy'].'\',0,'.$_SESSION['prdLst'][$idLst]['pagRng'].',\'N\')"><<</button></td>'."\n".''.'<td align="center" width="50">'.$atras.'</td>'."\n".$mitad.'<td align="center" width="50">'.$adelante.'</td>'."\n".'<td align="center" width="50">'.$final.'</td>'."\n";
			$buf .= '</tr>'."\n";

			$buf .= '</table>'."\n";

			$buf .= '</td>'."\n".'</tr>'."\n".'</table>'."\n";
		}		
		
		$buf .= '</td>'."\n";
		$buf .= '</tr>'."\n";
		$buf .= '</table>'."\n";
		
		$buf.='</div>'."\n";
		
		return $buf;
	}
	
	/**
	 * Guardar las preferencias sobre los estilos
	 * de la lista dinamica
	 *
	 * @param string $idLst Nombre de la lista dinamica
	 */
	public function savePreferences ($idLst){
		
		if ($this->STYLE_ancho_lista){
		   $_SESSION['prdLst'][$idLst]['wTb'] = $this->STYLE_ancho_lista;
		}
		
		if ($this->STYLE_estilo_botones_paginacion){
		   $_SESSION['prdLst'][$idLst]['stBtnPag'] = $this->STYLE_estilo_botones_paginacion;
		}
		
		if ($this->STYLE_color_borde){
		   $_SESSION['prdLst'][$idLst]['brCr'] = $this->STYLE_color_borde;
		}		
		
		if ($this->STYLE_usar_distincion_filas){
		   $_SESSION['prdLst'][$idLst]['usRwStr'] = $this->STYLE_usar_distincion_filas;
		}
		
		if ($this->STYLE_color_fila_defecto){
		   $_SESSION['prdLst'][$idLst]['dfRwBgCr'] = $this->STYLE_color_fila_defecto;
		}

		if ($this->STYLE_color_fila_del_medio){
		   $_SESSION['prdLst'][$idLst]['bgCrRwStr'] = $this->STYLE_color_fila_del_medio;
		}		
		
		if ($this->STYLE_color_over_fila){
		   $_SESSION['prdLst'][$idLst]['dfCrRwHov'] = $this->STYLE_color_over_fila;
		}
		
		if ($this->STYLE_color_columna_seleccionada){
		   $_SESSION['prdLst'][$idLst]['dfCrClSel'] = $this->STYLE_color_columna_seleccionada;
		}

		if ($this->STYLE_color_marked_fila){
		   $_SESSION['prdLst'][$idLst]['dfCrRwMrk'] = $this->STYLE_color_marked_fila;
		}		
		
		if ($this->STYLE_ruta_imagen_fondo_cabeza_columna){
		   $_SESSION['prdLst'][$idLst]['sImBkHdClDf'] = $this->STYLE_ruta_imagen_fondo_cabeza_columna; 
		}
		
		if ($this->STYLE_ruta_imagen_fondo_cabeza_columna_seleccionada){
		   $_SESSION['prdLst'][$idLst]['sImBkHdClSel'] = $this->STYLE_ruta_imagen_fondo_cabeza_columna_seleccionada;
		}
		
		if ($this->STYLE_estilo_datos){
		   $_SESSION['prdLst'][$idLst]['stCtTb'] = $this->STYLE_estilo_datos;
		}
		
		if ($this->STYLE_estilo_cabeza_columnas){
		   $_SESSION['prdLst'][$idLst]['stTlCl'] = $this->STYLE_estilo_cabeza_columnas;
		}

		if ($this->STYLE_srcImageASC){
			$_SESSION['prdLst'][$idLst]['iOrdA'] = $this->STYLE_srcImageASC;
		}
		   
		if ($this->STYLE_srcImageDESC){
			$_SESSION['prdLst'][$idLst]['iOrdD'] = $this->STYLE_srcImageDESC;
		}
				
	}
	
}


?>