<?php

/**
 * myList
 * 
 * Es la propuesta de osezno-framework cuando se desea implementar una
 * lista dianamica por medio de una consulta sql o una tabla de myActiveRecord.
 *
 * @uses Listas dinamicas
 * @package OSEZNO FRAMEWORK (2008-2011)
 * @version 0.1
 * @author Jose Ignacio Gutierrez Guzman jose.gutierrez@osezno-framework.org
 *
 */
class myList  {
	
	/**
	 * Anchura de la tabla que contiene la lista
	 * @var integer
	 */
	public $widthList = 1000;
	
	/**
	 * Formato aplicado a la anchura de la tabla que 
	 * contiene la lista.
	 * @var string
	 */
	private $formatWidthList = 'px';
	
	/**
	 * Tamaño del borde de la lista entre celdas
	 * @var integer
	 */
	private $borderCellSize = 1;
	
	/**
	 * Usar distincion entre filas
	 * @var bool
	 */
	private $useDistBetwRows = true;
	
	/**
	 * Usar paginacion.
	 * @var bool
	 */
	private $usePagination = false;
	
	/**
	 * Numero de registros por pagina cuando la paginacion
	 * esta activa.
	 * @var integer
	 */
	private $recordsPerPage;
	
	/**
	 * Numero de registros por pagina cuando el usuario selecciona desde el formulario
	 * @var integer
	 */
	private $recordsPerPageForm = 1;
	
	/**
	 * Maxima numero de pagina encontrada
	 * @var integer
	 */
	private $maxNumPage = 0;
	
	/**
	 * Numero actual de regla maxima	 
	 * @var integer
	 */
	private $numRuleQuery = 0;
	
	/**
	 * Pagina actual cuando la paginacion esta activa.
	 * @var unknown_type
	 */
	private $currentPage;
	
	/**
	 * Path subcarpeta dentro de la carpeta principal del proyecto
	 * que almacena las imagenes generales que se usan en las lista
	 * dianmicas.
	 * 
	 * @var string
	 */
	private $pathThemes = 'themes/';
	
	/**
	 * Nombre de los atributos seteables
	 * @var array
	 */
	private $validNomKeys = array (
		'widthList',
		'formatWidthList',
		'borderCellSize',
		'useDistBetwRows',
		'pathThemes',
		'sql',
		'arrayAliasSetInQuery',
		'arrayOrdMethod',
		'arrayOrdNum',
		'themeName',
		'arrayWidthsCols',
		'usePagination',
		'recordsPerPage',
		'recordsPerPageForm',
		'maxNumPage',
		'currentPage',
		'typeList',
		'arrayEventOnColumn',
		'arrayFieldsOnQuery',
		'numRuleQuery',
		'arrayWhereRules',
		'arrayDataTypeExport',
		'globalEventOnColumn',
		'globalEventsName'
	);	
	
	/**
	 * Tipos de datos que una columna puede ser
	 * @var array
	 */
	private $dataTypeColumn = array (
		'string','numeric','date'
	);
	
	private $typeList = '';
	
	/**
	 * Hmtl de la lista dinamica
	 * @var string
	 */
	private $bufHtml = '';
	
	/**
	 * Objeto de la conexion a BD
	 * @var object
	 */
	private $objConn;
	
	/**
	 * Objeto de formularios
	 * @var object
	 */
	private $objForm;
	
	/**
	 * Cadena de la consulta SQL
	 * @var string
	 */
	private $sql = '';
	
	/**
	 * Cadena de las funciones JS
	 * @var string
	 */
	private $js = '';
	
	/**
	 * Objeto resultado de la consulta SQL
	 * @var array
	 */
	private $resSql;
	
	/**
	 * Numero de registro afectados por la consulta.
	 * @var integer
	 */
	private $numAffectedRows = 0;
	
	/**
	 * Nombre o Id de la lista dinamica
	 * @var string
	 */
	private $idList = '';
	
	/**
	 * Arreglo que contiene los alias de los campos
	 * @var array
	 */
	private $arrayAliasSetInQuery = array ();
	
	/**
	 * Areglo con los ordenamientos de los campos
	 * @var array
	 */
	private $arrayOrdMethod = array ();
	
	/**
	 * Arreglo con las subconsultas que intervienen como reglas.
	 * @var array
	 */
	private $arrayWhereRules = array ();
	
	/**
	 * Numero de ordenamiento
	 * @var array
	 */
	private $arrayOrdNum = array ();
	
	/**
	 * Arreglo con los anchos determinados para
	 * cada columna.
	 * @var array
	 */
	private $arrayWidthsCols = array ();

	/**
	 * Arreglo con los eventos en columnas.
	 * @var array
	 */
	private $arrayEventOnColumn = array ();
	
	/**
	 * Arreglo con los nombres de las columnas obtenidos
	 * @var array
	 */
	private $arrayFieldsOnQuery = array();
	
	/**
	 * Arreglo con los tipos de datos en que es posible exportar la lista dinamica
	 */
	private $arrayDataTypeExport = array ('xls'=>false, 'html'=>false, 'pdf'=>false);
	
	/**
	 * Nombre de la columna del evento global
	 */
	private $globalEventOnColumn = '';
	
	/**
	 * Arreglo con los metodos y nombres que se ejecutaran en el evento global
	 */
	private $globalEventsName = array();
	
	/**
	 * Error de la consulta SQL
	 * @var string
	 */
	private $errorLog;
	
	/**
	 * Nombre del tema de estilo que usara la lista
	 * 
	 * @var string
	 */
	private $themeName = 'default';
	
	/**
	 * Determina si existe un error en la consutla sql
	 * que se ejecuto previo la construccion de la lista.
	 * 
	 * @var bool
	 */
	private $successFul = true;
	
	/**
	 * Cadena SQL u Objeto
	 * 
	 * @var string
	 */
	private $sqlORobject;
	
	/**
	 * Constructor
	 * @param $idList	Nombre de la lista
	 * @param $sqlORobject	SQL o Objeto de metodo
	 * @return string
	 */
	public function __construct($idList, $sqlORobject = ''){
		
		$this->idList = $idList;

		// Preguntamos si sera una lista de objeto o de consulta personalizada
		if ($sqlORobject){
			
			if (is_object($sqlORobject)){
				$this->typeList = 'object';
			}else{
				$this->typeList = 'string';
			}
			
		}
		
		$this->sqlORobject = $sqlORobject;
		
		$this->objForm = new myForm;
		
		$this->objForm->setParamTypeOnEvent('field');
	}
	
	/**
	 * Selecciona un tema de estilos para las lista dinamica.
	 * 
	 * @param $theme Nombre del tema
	 */
	public function setTheme ($theme = ''){
		
		if ($theme)
			$this->themeName = $theme;
		else{
			return  $GLOBALS['urlProject'].'/'.$this->pathThemes.$this->themeName.'/style.css.php?img='.$GLOBALS['urlProject'].'/css/themes/'.$this->themeName.'/';
		}
	}

	/**
	 * Configura una paginacion sobre la lista dinamica.
	 * 
	 * @param $use		Activa o inactiva la paginacion de la lista dinamica			
	 * @param $rows 	Numero de registro a mostrar por pagina.
	 */
	public function setPagination ($use = true, $rows = 20){
		
		$this->usePagination = $use;
		
		$this->recordsPerPage = $rows;
		
		$this->currentPage = 0;
	}
	
	/**
	 * Configura manualmente un acho determinado
	 * para cada columna de la lista dinamica.
	 * 
	 * @param $alias	Nombre de la columna
	 * @param $witdh	Ancho de la columna en PX o %
	 */
	public function setWidthColumn ($alias, $witdh){
		
		if (is_int($witdh))
			$this->arrayWidthsCols[$alias] = $witdh;
		
	}
	
	/**
	 * Configura en una columna segun su alias o nombre
	 * un evento que se disparara al hacer click sobre ese
	 * campo en esa columna. El evento recibira como parametro
	 * el valor de la columna y tambien el nombre de la lista dinamica.
	 * 
	 * @param $alias	Alias o nombre de la columna como la escribio
	 * @param $event	Nombre del evento que disparara en el handlerEvent
	 * @param $confirm_msg	Mensaje de confirmacion
	 */
	public function setEventOnColumn ($alias, $event, $confirm_msg = ''){
		
		$this->arrayEventOnColumn[$alias] = $event.'::'.htmlentities($confirm_msg);
	}
	
	/**
	 * Configura la posibilidad de que en una lista dinamica 
	 * se le permita descargar la consulta actual en un formato
	 * seleccionable.
	 * 
	 * @param $xls		Formato xls
	 * @param $html		Formato html
	 * @param $pdf		Formato pdf
	 */
	public function setExportData ($xls = true, $html = true, $pdf = true){

		$this->arrayDataTypeExport = array(
			'xls'=>$xls,
			'html'=>$html,
			'pdf'=>$pdf
		);
	}
	
	/**
	 * Configura un unico evento global en una lista dinamica sobre columna definida
	 * para que los registros marcados se vean afectados por dicho evento o eventos. El evento 
	 * programado recibira en un arreglo los registros seleccionados de dicha columna.
	 * 
	 * @param $alias	Alias o nombre de la columna del que tomara el valor
	 * @param $events	Array con los nombres y etiquetas de evento que ejecutara el handlerEvent
	 */
	public function setGlobalEventOnColumn ($alias, $events = array ()){
		
		$this->globalEventOnColumn = $alias;
		
		$this->globalEventsName = $events;
	}
	
	/**
	 * Obtiene la parte de la consulta correspodiente
	 * a armar una paginacion.
	 * 
	 * @return string
	 */
	private function getSqlPartLimit (){
		
		$sqlPart = '';
		
		if ($this->usePagination)
			$sqlPart .= ' LIMIT  '.($this->recordsPerPage*$this->recordsPerPageForm).' OFFSET '.($this->currentPage*($this->recordsPerPage*$this->recordsPerPageForm));
		
		return $sqlPart;
	}
	
	/**
	 * Obtiene la parte de la consulta correspondiente
	 * a condiciones cuando fueron aplicadas en el filtro.
	 * @return string
	 */
	private function getSqlPartWhere (){
		
		$sqlWhere = '';
		
		if (count($this->arrayWhereRules)){
			$sqlWhere = ' WHERE ';
			
			$rules = '';
			
			foreach ($this->arrayWhereRules as $id => $rule){
				$rules .= $rule.' ';
			}
		
			$sqlWhere .= substr($rules, 3);
		}
		
		return $sqlWhere;
	}
	
	/**
	 * Obtiene una cadena de texto que le indica a la consulta sql
	 * principal como debe organizar el resultado de la consulta.
	 * 
	 * @return string
	 */
	private function getSqlPartOrderBy (){

		$sqlPart = '';
		
		$arr = $this->getVar('arrayOrdMethod');
		
		if ($arr!==false){
		
			foreach ($arr as $column => $method){
				if ($method){
				
					if (!$sqlPart)
						$sqlPart = ' ORDER BY ';
				
					$sqlPart .= $column.' '.$method.', ';
				}
			}
		}
		
		$sqlPart = substr($sqlPart,0,-2);
		
		return $sqlPart;
	}
	
	/**
	 * Configura un campo en la consulta SQL para  que  le
	 * sea definido un alias y este pueda ser usado en los
	 * demas procesos de busqueda, consulta y ordenamiento.
	 * 
	 * @param $field Nombre del campo
	 * @param $alias Alias del campo
	 * @param $data_type El tipo de dato para dar un trato especial en cada caso (string, numeric, date)
	 */
	public function setAliasInQuery ($field, $alias, $data_type = 'string'){
		
		if (!in_array($data_type,$this->dataTypeColumn))
			$data_type = 'string';
		
		$this->arrayAliasSetInQuery[$field] = htmlentities($alias).'::'.$data_type;
		
	}
	
	/**
	 * Configura si una columna va a tener una propiedad especial 
	 * que le permitira a esta ser ordenada en forma ascendente o
	 * descendente o simplemente no ser organizada.
	 * 
	 * @param $alias
	 */
	public function setUseOrderMethodOnColumn ($alias){
		
		$this->arrayOrdMethod[$alias] = '';
		
	}
	
	/**
	 * Registra los atributos de la clase en una sesion.
	 * Solamente si no estan registrados antes.
	 * @param $arr
	 * @return unknown_type
	 */
	private function regAttClass ($arr){
		
		if (!isset($_SESSION['prdLst'][$this->idList])){
			
			$_SESSION['prdLst'][$this->idList] = array ();

		}	
			
		foreach ($arr as $atn => $atv){
			
				if (in_array($atn,$this->validNomKeys))
			
						$_SESSION['prdLst'][$this->idList][$atn] = $this->$atn;
		}
		
	}
	
	/**
	 * Restaura valores de la clase contenidos en la sesion
	 * @return unknown_type
	 */
	private function restVarsSess (){
		
		foreach ($this->validNomKeys as $varNom){
			
				$this->$varNom = $this->getVar($varNom);
		}
		 
	}
	
	/**
	 * Retorna la ruta de la imagen que se va a mostrar segun
	 * el metodo de ordenamiento.
	 * 
	 * @param $method	Metodo de ordenamiento
	 * @return string	
	 */
	private function getSrcImageOrdMethod ($method = ''){
		
		$pathImg = $GLOBALS['urlProject'].'/'.$this->pathThemes.$this->themeName.'/mylist/';
		
		$return = '';
		
		if ($method){
			
			switch ($method){
				
				case 'ASC':
					$return .= $pathImg.'asc.gif';
				break;
				
				case 'DESC':
					$return .= $pathImg.'desc.gif';
				break;
			}

		}
		
		return $return;
	}
	
	/**
	 * Retorna el alias del campo en la consulta si previamente fue definido
	 * 
	 * @param $title	Campo en la consulta
	 * @return string
	 */
	private function returnLabelTitle ($title){
		
		$return = $title;
		
		if (isset($this->arrayAliasSetInQuery[$title])){
			list($return, $data_type) = explode ('::',$this->arrayAliasSetInQuery[$title]);
		}
		
		return $return;
	}
	
	private $firsKey = false;
	
	/**
	 * Construye la lista dinamica
	 * @param $showQueryForm	Mostrar formulario de consulta
	 * @return unknown_type
	 */
	private function buildList ($showQueryForm){
		
		$buf = '';
		
		if ($this->sqlORobject){
			
			if (is_object($this->sqlORobject)){
			
				// Objeto
				
				$this->objConn = $this->sqlORobject;
		
				$sql = $this->sql = '';
				
				$countFields = count($fields = get_class_vars($table = get_class($this->sqlORobject)) ); 
				
				$subSqlF = '';

				$iCounter = 1;
				
				foreach ($fields as $field => $value){
					
					$subSqlF .= $field;

					if ($iCounter<$countFields)
			   			$subSqlF .= ', ';

					$iCounter++;
				}
				
				$sql = 'SELECT '.$subSqlF.' FROM '.$table;

				$this->sql = $sql;
				
			}else{
			
				// Cadena
				
				$this->objConn = new myActiveRecord();
		
				$this->sql = $this->sqlORobject;
			}
			
			if ($this->objConn->isSuccessfulConnect())
				$this->resSql = $this->objConn->query ($this->sql.''.$this->getSqlPartLimit());
			
		}else{
			
			$this->restVarsSess();
			
			$this->objConn = new myActiveRecord();
			
			$sql = $this->sql.''.$this->getSqlPartWhere().''.$this->getSqlPartOrderBy().''.$this->getSqlPartLimit();

			if ($this->objConn->isSuccessfulConnect())
				$this->resSql = $this->objConn->query($sql);
			
		}

		if ($this->objConn->getErrorLog(true))
			$this->successFul = false;		
		
			
		# Numero de campos afectados
		$getNumFldsAftd = $this->objConn->getNumFieldsAffected();
		
		# Numero de registro afectados
		$this->numAffectedRows = $this->objConn->getNumRowsAffected();

		/**
		 * Calcular el ancho de cada columna si no hay definido
		 * un ancho especifico definido antes por el usuario.
		 */
		$widByCol = 0;
		
		$totWid = $this->widthList;
		
		$return = $bufHead = $cadParam = '';
		
		$buf .= '<div id="'.$this->idList.'" name="'.$this->idList.'">'."\n";
		
		if (!$this->successFul){
			
			$buf .= $this->objConn->getErrorLog(true);
			
		}else{
			
			if ($this->numAffectedRows){
				
				$buf .=  "\n".'<table border="0" width="'.$this->widthList.''.$this->formatWidthList.'" cellspacing="0" cellpadding="0"><tr><td class="list">'."\n";
			
				foreach ($this->arrayWidthsCols as $col => $wid)
					$totWid -= $wid;
			
				if ($totWid)	
					$widByCol	= $totWid / ($getNumFldsAftd - count($this->arrayWidthsCols)); 
		
				$sw = false;
		
				$rows = $this->resSql;
			
				$buf .=  "\n".'<table border="0" width="100%" cellspacing="'.$this->borderCellSize.'" cellpadding="0" id="table_'.$this->idList.'">'."\n";

				$i = 0;
		
				$classTd = 'td_default';
		
				foreach ($rows as $row){

					if ($this->useDistBetwRows){
						if ($i%2)
							$classTd = 'td_default';
						else	
							$classTd = 'td_middle';
					}
			
					/**
			 	 	 * Titulos de las columnas
			 	 	 */		
					if (!$sw){
				
						$this->arrayFieldsOnQuery = array();
					
						$arrColOrd = array ();
				
						$sw = true;
				
						$bufHead.='<tr>'."\n"."\t";

						$arrayOrdNum = array();
					
						$cOrd=1;
					
						foreach ($this->arrayOrdNum as $nom){
						
							$arrayOrdNum[$nom] = $cOrd;
						
							$cOrd++;
						 
						}
					
						$this->firsKey = true;
						
						foreach ($row as $key => $val){
					
							if (!is_numeric($key)){

								$this->arrayFieldsOnQuery[] = $key;
							
								$widCol = 0;
								
								if (isset($this->arrayWidthsCols[$key]))
									$widCol = $this->arrayWidthsCols[$key];
								else
									$widCol = $widByCol;
						
								$orderBy = '';	

								$numOrder = '&nbsp;';
							
								if ($this->firsKey){
									
									$htmlGlobal = '{htmlGlobal}';
									
									$this->firsKey = false;
								}else
									$htmlGlobal = '&nbsp;';	
								
								if (isset($this->arrayOrdMethod[$key])){
								
									$orderBy = $this->arrayOrdMethod[$key];
								
									$styleName = 'cell_title';
								
									if ($orderBy){
								
										$cadParam .= '2,';
								
										$styleName = 'cell_title_selected';
								
										$arrColOrd[] = $key; 
									
										$numOrder = $arrayOrdNum[$key];
									
									}else{
										$cadParam .= '1,';
									}
							
									$bufHead.='<td class="'.$styleName.'" width="'.$widCol.'" align="center">';
							
									$bufHead.='<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center"><tr><td width="20px">'.$htmlGlobal.'</td><td width="" style="text-align:center">'; 
							
									$bufHead.='<a class="column_title" href="javascript:;" onClick="MYLIST_moveTo(\''.$this->idList.'\',\''.$key.'\')">'.ucwords($this->returnLabelTitle($key)).'</a>';

									$bufHead.='</td><td width="20px" background="'.$this->getSrcImageOrdMethod($orderBy).'" class="num_ord_ref">'.$numOrder.'</td></tr></table>';
							
									$bufHead.='</td>';
							
								}else{
									
									$cadParam .= '1,';
									
									$bufHead.='<td width="'.$widCol.'" align="center" class="cell_title">';
									
									$bufHead.='<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center"><tr><td width="20px">'.$htmlGlobal.'</td><td align="center">';
									
									$bufHead.='<font class="column_title">'.ucwords($this->returnLabelTitle($key)).'</font>';
							
									$bufHead.='</td><td width="20px">&nbsp;</td></tr></table>';

									$bufHead.='</td>';
								}
							
							}
					
						}
				
						$bufHead .=  '</tr>'."\n";
				
						$bufHead = str_replace('{htmlGlobal}',$this->returnCheckBox($getNumFldsAftd, $cadParam),$bufHead);
						
						$buf .='{bufHead}';
			
					}
					
					$nmCheck = '';
					
					if ($this->globalEventOnColumn){
						
						$alsGbl = $this->globalEventOnColumn;
						
						$nmCheck = $this->idList.'_'.$row->$alsGbl;
					}
			
					$buf.='<tr ';
			
					$buf.='id="tr_'.$this->idList.'_'.$i.'" ';
			
					$buf.='onclick="markRow(this, \''.$classTd.'\',\''.substr($cadParam,0,-1).'\', '.$getNumFldsAftd.', \''.$nmCheck.'\')" ';
			
					$buf.='onmouseover="onRow(this, '.$getNumFldsAftd.')" ';
			
					$buf.='onmouseout="outRow(this, \''.$classTd.'\',\''.substr($cadParam,0,-1).'\', '.$getNumFldsAftd.')" ';
			
					$buf.='>'."\n"."\t";
			
					$firsVal = true;
					
					foreach ($row as $key => $val){
				
						if (!is_numeric($key)){
							
							if (!$val)
					   			$Value = '&nbsp;';
					   
					   		$buf.='<td class="';	
					   			
							if (in_array($key,$arrColOrd)){
								$class='cell_content_selected';
							}else
								$class=$classTd;
								
							$buf .= $class.'">';	
					   		
							if ($firsVal && $this->globalEventOnColumn){
								
								$nmCheck = $this->idList.'_'.$row->$alsGbl;
								
								$this->objForm->addEventJs($nmCheck,'onclick','check_onlist',array($nmCheck));
								
					   			$buf.='<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center"><tr><td width="20px">'.$this->objForm->getCheckBox($nmCheck).'</td><td class="'.$class.'_checkbox">';
							}
					   		
							if (isset($this->arrayEventOnColumn[$key])){
							
								list($event,$strMsg) = explode('::',$this->arrayEventOnColumn[$key]); 
							
								if ($strMsg)
									$strMsg = ' onClick="return confirm(\''.$strMsg.'\')"';
							
								$buf.='<a href="javascript:void('.$event.'(\''.$val.'\',\''.$this->idList.'\'))"'.$strMsg.'>'.ucwords($this->returnLabelTitle($key)).'</a>';
							
							}else
								$buf.=htmlentities($val);	
					
							if ($firsVal && $this->globalEventOnColumn){
					   			$buf.='</td><td width="20px">&nbsp;</td></tr></table>';
					   			$firsVal = false;	
					   		}
							
					   		$buf.='</td>';
					   		
						}
				
					}

					$buf.= "\n".'</tr>'."\n";
					
					$i++;
				}
			
				$buf .=  '</tbody>'."\n";
		
				$buf .=  '</table>'."\n";
			
				$buf .=  '</td></tr></table>'."\n";
				
			}else{
				//TODO: No hay registros afectados
			}
			
		}	

		$buf .= '<div  style="width:'.$this->widthList.''.$this->formatWidthList.'" id="pag_'.$this->idList.'" name="pag_'.$this->idList.'">'."\n";
		
		$buf .= '<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%"><tr><td align="left" width="33%">';
		
		if($this->globalEventOnColumn && $this->successFul){
			
			$idSelect = 'global_event_'.$this->idList;
			
			$this->objForm->name = $this->idList;
			
			$this->objForm->selectStringFirstLabelOption = LABEL_FIRST_OPT_SELECT_GLOBAL_ACTION;
			
			$this->objForm->styleTypeHelp = 2;
			
			$this->objForm->addEventJs ($idSelect,'onchange','execGlobalEventOnList',array($this->idList, $idSelect));
			
			$this->objForm->addHelp($idSelect,LABEL_HELP_SELECT_GLOBAL_ACTION);
			
			$buf .= $this->objForm->getSelect($idSelect,$this->globalEventsName);
			
		}else
			$buf .= '&nbsp;';

		$buf .= '</td><td width="34%" align="center">';	
		
		# Usar paginacion
		if ($this->usePagination && $this->successFul && $this->numAffectedRows){
			
			$arrBut = array(
				'_ini_page'	 =>array('&nbsp;--&nbsp;','beg','button'),
			
				'_back_page' =>array('&nbsp;-1&nbsp;', 'bac','button'),
			
				'_goto_page' =>array(($this->currentPage+1),'goto','field'),
			
				'_chg_pag'	 =>array(
						array(1=>($this->recordsPerPage*1),
							  2=>($this->recordsPerPage*2),
							  3=>($this->recordsPerPage*3),
							  4=>($this->recordsPerPage*4),
							  5=>($this->recordsPerPage*5)),'amp_pag','select'),
			
				'_next_page' =>array('&nbsp;+1&nbsp;', 'nex','button'),
			
				'_end_page'	 =>array('&nbsp;++&nbsp;','end','button')
			);
			
			
			$objMyForm = new myForm;
			
			$objMyForm->selectUseFirstValue = false;
			
			$objMyForm->setParamTypeOnEvent('field');
			
			$objMyForm->styleTypeHelp = 2;
			
			$objMyForm->addHelp($this->idList.'_end_page','&nbsp;'.GOTO_LAST_PAGE.'&nbsp;');
			
			$objMyForm->addHelp($this->idList.'_ini_page','&nbsp;'.GOTO_FIRST_PAGE.'&nbsp;');
			
			$objMyForm->addHelp($this->idList.'_next_page','&nbsp;'.GOTO_NEXT_PAGE.'&nbsp;');
			
			$objMyForm->addHelp($this->idList.'_back_page','&nbsp;'.GOTO_BACK_PAGE.'&nbsp;');
			
			$buf .= '<table cellspacing="0" cellpadding="0" border="0" align="center" width="250"><tr>';

			if ($this->currentPage == 0){
				
				$objMyForm->addDisabled($this->idList.'_ini_page');
				
				$objMyForm->addDisabled($this->idList.'_back_page');
			}
			
			if ($i<($this->recordsPerPage*$this->recordsPerPageForm)){
				
				$objMyForm->addDisabled($this->idList.'_next_page');
				
				$objMyForm->addDisabled($this->idList.'_end_page');
			}
			
			if ($this->currentPage==$this->maxNumPage){
				
				$objMyForm->addDisabled($this->idList.'_end_page');
			}
			
			foreach ($arrBut as $id => $attr){

				$buf .= '<td>'; 
				
				switch ($attr[2]){
				
					case 'button':
						
						$htmlBut = '<img src="'.$GLOBALS['urlProject'].'/'.$this->pathThemes.$this->themeName.'/mylist/'.$id.'.gif">';
						
						$buf .= $objMyForm->getButton($this->idList.$id,$htmlBut,'MYLIST_page:'.$this->idList.':'.$attr[1]);					break;
					
					case 'field':
						
						//$objMyForm->addEventJs($this->idList.$id,'onChange','myListPage',array($this->idList,$attr[1]));
						
						$buf .= $objMyForm->getText($this->idList.$id,$attr[0],3,NULL,true);
						
					break;
					case 'select':
						
						$objMyForm->addHelp($this->idList.$id,LABEL_HELP_CHPAG_SELECT_FORM);
						
						$objMyForm->addEventJs($this->idList.$id,'onchange','MYLIST_chPag',array($this->idList));
						
						$buf .= $objMyForm->getSelect($this->idList.$id,$attr[0],$this->recordsPerPageForm);
						
					break;
				}
				
				$buf .= '</td>';
			}
			
			$buf .= '</tr></table>';
		}

		$buf .= '</td><td width="33%" align="right" class="texto_formularios">&nbsp;</td></tr></table></div>'."\n";
		
		$buf .= ''.'</div>'."\n";
		
		$this->bufHtml =  str_replace('{bufHead}',$bufHead,$buf);
		
		if ($showQueryForm && $this->successFul)
			$this->bufHtml = $this->buildQueryForm().$this->bufHtml;
		
		# Registramos las variables que se han usado
		$this->regAttClass(get_class_vars(get_class($this)));
	}
	
	/**
	 * Retorna el campo checkbox que acompaña cada registro cuando el evento global esta activo
	 * 
	 * @param $getNumFldsAftd	Numero de campos afectados
	 * @param $cadParam			Columnas ordenadas
	 * @return string
	 */
	private function returnCheckBox ($getNumFldsAftd, $cadParam){
		
		$htmlGlobal = '';
		
		if ($this->globalEventOnColumn){
		
			list ($alsGbl) = explode('::',$this->globalEventOnColumn);
									
			$nmChk = $this->idList.'_over_all';
									
			$this->objForm->addEventJs($nmChk,'onclick','checkAllBoxesOnList',array($this->idList,$nmChk, $getNumFldsAftd, $cadParam));
									
			$htmlGlobal = $this->objForm->getCheckBox($nmChk);
		}
			
		return 	$htmlGlobal;
	}
	
	/**
	 * Retorna el formulario filtro de lista por medio de reglas
	 * @return string
	 */
	public function getQueryForm (){
		
		return $this->buildQueryForm();
	}
	
	/**
	 * Construye el Html del formulario de consulta
	 * @return string
	 */
	private function buildQueryForm (){
		
		$arFields = array();
		
		$objMyForm = new myForm($nomForm = $this->idList.'QueryForm');

		$objMyForm->width = '98%';
		
		$objMyForm->border = 0;
		
		$objMyForm->styleClassTags = 'texto_formularios';
		
		$objMyForm->styleClassForm = 'form_cont_filter';
		
		$htble = '';

		/**
		 * Helps
		 */
		$objMyForm->styleTypeHelp = 2;
		
		$objMyForm->addHelp('add_rule_'.$this->idList,LABEL_HELP_ADD_RULE_QUERY_BUTTON_FORM);
		
		$objMyForm->addDisabled('cancel_query_'.$this->idList);
		
		$objMyForm->addDisabled('save_query_'.$this->idList);

		$htble .= '<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>';
		
		$anyBut = false;
		
		$objMyForm->addHelp('xls_'.$this->idList,LABEL_HELP_EXCEL_BUTTON_FORM);
		
		if (!$this->arrayDataTypeExport['xls'])
			$objMyForm->addDisabled('xls_'.$this->idList);
		else
			$anyBut = true;
			
		$htble .= '<td width="10%" align="left">'.$objMyForm->getButton('xls_'.$this->idList,'','MYLIST_exportData:xls:'.$this->idList,'excel.gif').'</td>';

		$objMyForm->addHelp('html_'.$this->idList,LABEL_HELP_HTML_BUTTON_FORM);
		
		if (!$this->arrayDataTypeExport['html'])
			$objMyForm->addDisabled('html_'.$this->idList);
		else
			$anyBut = true;
		
		$htble .= '<td width="10%" align="left">'.$objMyForm->getButton('html_'.$this->idList,'','MYLIST_exportData:html:'.$this->idList,'html.gif').'</td>';
		
		$objMyForm->addHelp('pdf_'.$this->idList,LABEL_HELP_PDF_BUTTON_FORM);
		
		if (!$this->arrayDataTypeExport['pdf'])
			$objMyForm->addDisabled('pdf_'.$this->idList);
		else
			$anyBut = true;	
		
		$htble .= '<td width="10%" align="left">'.$objMyForm->getButton('pdf_'.$this->idList,'','MYLIST_exportData:pdf:'.$this->idList,'pdf.gif').'</td>';
		
		$objMyForm->addHelp('not_pg_'.$this->idList,LABEL_HELP_USELIMIT_RULE_FORM);
		
		if (!$anyBut)
			$objMyForm->addDisabled('not_pg_'.$this->idList);
		
		$htble .= '<td width="10%" align="left" class="'.$objMyForm->styleClassTags.'">'.LABEL_USELIMIT_RULE_FORM.':'.$objMyForm->getCheckBox('not_pg_'.$this->idList,true).'</td>';
		
		$htble .= '<td width="10%">&nbsp;</td>';
		
		$htble .= '<td width="10%">&nbsp;</td>';
		
		$htble .= '<td width="10%">&nbsp;</td>';
		
		$htble .= '<td width="10%" align="right">'.$objMyForm->getButton('add_rule_'.$this->idList,'','MYLIST_addRuleQuery:'.$this->idList,'find.gif').'</td>';

		$objMyForm->addHelp($this->idList.'_apply_rule',LABEL_HELP_APPLY_RULE_FORM);

		$htble .= '<td width="10%" align="right">'.$objMyForm->getButton($this->idList.'_apply_rule',NULL,'MYLIST_applyRuleQuery:'.$this->idList,'ok.gif').'</td>';
		
		$objMyForm->addDisabled('help_'.$this->idList);
		
		$htble .= '<td width="10%" align="right">'.$objMyForm->getButton('help_'.$this->idList,'','MYLIST_help','help.gif').'</td>';
		
		$htble .= '</tr></table>';
		
		$objMyForm->addComent('options',$htble);
		
		$objMyForm->addComent('rule_for','<div class="form_rule_for_list" id="rule_for_'.$this->idList.'"></div>');
		
		return $objMyForm->getForm(1);
	}
	
	/**
	 * Retorna el valor de un atributo de la lista dinamica.
	 * @param $name	Nombre de la variable
	 * @param $item	Si se trata de un arreglo el nombre del indice
	 * @return string
	 */
	public function getVar ($name, $item = ''){
		$var = false;
		
		if ($item){
			if (isset($_SESSION['prdLst'][$this->idList][$name][$item]))
				$var = $_SESSION['prdLst'][$this->idList][$name][$item];
		}else{
			if (isset($_SESSION['prdLst'][$this->idList][$name]))
				$var = $_SESSION['prdLst'][$this->idList][$name];
		}
			 
		return $var;
	}

	/**
	 * Configura una variable de la lista
	 * @param $name	Nombre de la variable
	 * @param $val	Nuevo valor
	 * @param $item	Si te trata de un arreglo el nombre del indice
	 */
	public function setVar ($name, $val, $item = ''){
		
		if ($item)
			$_SESSION['prdLst'][$this->idList][$name][$item] = $val;
		else
			$_SESSION['prdLst'][$this->idList][$name] = $val;
	} 
	
	/**
	 * Borra una variable de la lista
	 * @param $name Nombre de la variable
	 * @param $item	Si se trata de un arreglo el nombre del indice
	 */
	public function unSetVar ($name, $item){
	
		if ($item){
			if (isset($_SESSION['prdLst'][$this->idList][$name][$item])){
				unset($_SESSION['prdLst'][$this->idList][$name][$item]);
			}
		}else{
			if (isset($_SESSION['prdLst'][$this->idList][$name])){
				unset($_SESSION['prdLst'][$this->idList][$name]);
			}
		}
		
	}

	/**
	 * Retorna el numero de registros afectados por la anteior consulta.
	 * @return integer
	 */
	public function getNumRowsAffected(){
		
		return $this->numAffectedRows;
	}
	
	/**
	 * Indica si la lista se ejecuto correctamente o no
	 * @return boolean
	 */
	public function isSuccessfulProcess (){
		
		return $this->successFul;
	}
	
	/**
	 * Obtiene el contenido de la lista dinámica
	 * @param $showQueryForm	Mostrar formulario de consulta
	 * @return string
	 */
	public function getList ($showQueryForm = false){
		
		$this->buildList($showQueryForm);
		
		return $this->bufHtml;
	}

}

?>