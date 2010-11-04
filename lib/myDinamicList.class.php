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
	 * Maxima numero de pagina encontrada
	 * @var integer
	 */
	private $maxNumPage = 0;
	
	
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
		'maxNumPage',
		'currentPage',
		'typeList',
		'arrayEventOnColumn',
		'arrayFieldsOnQuery',
		'sqlWhere'
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
	 * Cadena de la consulta SQL
	 * @var string
	 */
	private $sql = '';
	
	/**
	 * Cadena de la consulta cuando se habilita el filtro por lista.
	 * @var string
	 */
	private $sqlWhere = '';
	
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
	 * @var unknown_type
	 */
	private $sqlORobject;
	
	/**
	 * Usar o no imagenes sobre los botones segun el estilo seleccionado
	 * 
	 * @var boolean
	 */
	private $useImgOnButtons = true;
	
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
	 * Configura si va a usar imagenes sobre los botones de paginacion.
	 * 
	 * @param $use	Valor booleano
	 */
	public function setUseImgOnButtons ($use){
		
		$this->useImgOnButtons = $use;
		
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
	 * Obtiene la parte de la consulta correspodiente
	 * a armar una paginacion.
	 * 
	 * @return string
	 */
	private function getSqlPartLimit (){
		
		$sqlPart = '';
		
		if ($this->usePagination)
			$sqlPart .= ' LIMIT  '.$this->recordsPerPage.' OFFSET '.($this->currentPage*$this->recordsPerPage);
		
		return $sqlPart;
	}
	
	/**
	 * Obtiene la parte de la consulta correspondiente
	 * a condiciones cuando fueron aplicadas en el filtro.
	 * @return string
	 */
	private function getSqlPartWhere (){
		
		return $this->sqlWhere;
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
							
									$bufHead.='<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center"><tr><td width="20px" background="'.$this->getSrcImageOrdMethod($orderBy).'" class="num_ord_ref">'.$numOrder.'</td><td width="" style="text-align:center">'; 
							
									$bufHead.='<a class="column_title" href="javascript:;" onClick="myListMoveTo(\''.$this->idList.'\',\''.$key.'\')">'.ucwords($this->returnLabelTitle($key)).'</a>';

									$bufHead.='</td><td width="20px">&nbsp;</td></tr></table>';
							
									$bufHead.='</td>';
							
								}else{
							
									$cadParam .= '1,';
							
									$bufHead.='<td class="cell_title" width="'.$widCol.'">';
								
									$bufHead.='<font class="column_title">'.ucwords($this->returnLabelTitle($key)).'</font>';
							
									$bufHead.='</td>';	
								}
							
							}
					
						}
				
						$bufHead .=  '</tr>'."\n";
				
						$buf .='{bufHead}';
			
					}
			
					$buf.='<tr ';
			
					$buf.='id="tr_'.$this->idList.'_'.$i.'" ';
			
					$buf.='onclick="markRow(this, \''.$classTd.'\',\''.substr($cadParam,0,-1).'\', '.$getNumFldsAftd.')" ';
			
					$buf.='onmouseover="onRow(this, '.$getNumFldsAftd.')" ';
			
					$buf.='onmouseout="outRow(this, \''.$classTd.'\',\''.substr($cadParam,0,-1).'\', '.$getNumFldsAftd.')" ';
			
					$buf.='>'."\n"."\t";
			
					foreach ($row as $key => $val){
				
						if (!is_numeric($key)){
					
							if (!$val)
					   			$Value = '&nbsp;';
					   
							$buf.='<td class="';
					
							if (in_array($key,$arrColOrd))
								$buf.='cell_content_selected">';
							else
								$buf.=''.$classTd.'">';
						
							if (isset($this->arrayEventOnColumn[$key])){
							
								list($event,$strMsg) = explode('::',$this->arrayEventOnColumn[$key]); 
							
								if ($strMsg)
									$strMsg = ' onClick="return confirm(\''.$strMsg.'\')"';
							
								$buf.='<a href="javascript:void('.$event.'(\''.$val.'\',\''.$this->idList.'\'))"'.$strMsg.'>'.ucwords($this->returnLabelTitle($key)).'</a>';
							
							}else
								$buf.=htmlentities($val);	
					
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
		
		# Usar paginacion
		if ($this->usePagination && $this->successFul && $this->numAffectedRows){
			
			$arrBut = array(
				'_ini_page'	 =>array('&nbsp;--&nbsp;','beg','button'),
			
				'_back_page' =>array('&nbsp;-1&nbsp;', 'bac','button'),
			
				'_goto_page' =>array(($this->currentPage+1),'goto','field'),
			
				'_next_page' =>array('&nbsp;+1&nbsp;', 'nex','button'),
			
				'_end_page'	 =>array('&nbsp;++&nbsp;','end','button')
			);
			
			
			$objMyForm = new myForm;
			
			$objMyForm->setParamTypeOnEvent('field');
			
			$objMyForm->styleTypeHelp = 2;
			
			$objMyForm->addHelp($this->idList.'_end_page','&nbsp;'.GOTO_LAST_PAGE.'&nbsp;');
			
			$objMyForm->addHelp($this->idList.'_ini_page','&nbsp;'.GOTO_FIRST_PAGE.'&nbsp;');
			
			$objMyForm->addHelp($this->idList.'_next_page','&nbsp;'.GOTO_NEXT_PAGE.'&nbsp;');
			
			$objMyForm->addHelp($this->idList.'_back_page','&nbsp;'.GOTO_BACK_PAGE.'&nbsp;');
			
			$buf .= '<div id="pag_'.$this->idList.'" name="pag_'.$this->idList.'">'."\n";
		
			$buf .= '<table border="0" align="center"><tr>';

			if ($this->currentPage == 0){
				
				$objMyForm->addDisabled($this->idList.'_ini_page');
				
				$objMyForm->addDisabled($this->idList.'_back_page');
			}
			
			if ($i<$this->recordsPerPage){
				
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
						
						if (!$this->useImgOnButtons){
							$htmlBut = $attr[0];
						}else{
							$htmlBut = '<img src="'.$GLOBALS['urlProject'].'/'.$this->pathThemes.$this->themeName.'/mylist/'.$id.'.gif">';
						}
						
						$buf .= $objMyForm->getButton($this->idList.$id,$htmlBut,'myListPage:'.$this->idList.':'.$attr[1]);
					break;
					
					case 'field':
						
						//$objMyForm->addEventJs($this->idList.$id,'onChange','myListPage',array($this->idList,$attr[1]));
						
						$buf .= $objMyForm->getText($this->idList.$id,$attr[0],3,NULL,true);
						
					break;
					
				}
				
			
				$buf .= '</td>';
				
			}
			
			$buf .= '</tr></table>';
			
			$buf .= '</div>'."\n";
		}
		
		
		$buf .= ''.'</div>'."\n";
		
		$this->bufHtml =  str_replace('{bufHead}',$bufHead,$buf);
		
		if ($showQueryForm)
			$this->bufHtml = $this->buildQueryForm().$this->bufHtml;
		
		
		# Registramos las variables que se han usado
		$this->regAttClass(get_class_vars(get_class($this)));
	}
	
	/**
	 * Construye el Html del formulario de consulta
	 * @return string
	 */
	private function buildQueryForm (){
		
		$arFields = array();
		
		$objMyForm = new myForm($this->idList.'QueryForm');

		$objMyForm->width = $this->widthList.''.$this->formatWidthList;
		
		$objMyForm->border = 0;
		
		$objMyForm->selectUseFirstValue = false;
		
		$objMyForm->idMainButton = $this->idList.'_query';
				
		/*
		foreach ($this->arrayFieldsOnQuery as $field){
			
			$data_type = '';
			
			if (!isset($this->arrayEventOnColumn[$field])){
				
				if (isset($this->arrayAliasSetInQuery[$field])){
					
					list($label, $data_type) =
					 
						explode ('::',$this->arrayAliasSetInQuery[$field]);
				}else
					$label = $field;
				
				$maxlenght = $value = '';
				$size = 10;
				
				$date_field = $valid_num = false;
					
				switch ($data_type){
					
					case 'numeric':
						$valid_num = true;
						
						$maxlenght = 8;
						$size = 8;
						
						$value = 0;
					break;
					
					case'date':
						$date_field = true;
						
						$maxlenght = 10;
						$size = 12;
						
					break;
				}
					
				$objMyForm->addText($label.$objMyForm->getSelect(
				
					'opt_'.$field,$this->returnDataTypeSelectArray($data_type)),
				
					$field,$value,$size,$maxlenght,$valid_num,$date_field
				);
				
				$arFields[] = $field;
			}
				
		}
		*/
		
		$objMyForm->addHidden($arFields[] = 'idlist',$this->idList);
		
		$objMyForm->addGroup('g1',LABEL_FORM_FIELDSET,$arFields,3,true);
		
		$objMyForm->addButton('add_rule',LABEL_ADD_RULE_QUERY_BUTTON_FORM,'showFormAddRuleQuery','add.gif');
		
		$objMyForm->addButton('save_query',LABEL_DOWNLOAD_QUERY_BUTTON_FORM,'onSubmitDownloadQuery','download.gif');
		
		$objMyForm->addButton('cancel_query',LABEL_CANCEL_QUERY_BUTTON_FORM,'onSubmitCancelQuery','cancel.gif');
		
		$objMyForm->srcImageMainButton = 'ok.gif';
		
		$objMyForm->addDisabled('cancel_query');
		$objMyForm->addDisabled('save_query');
		$objMyForm->addDisabled($objMyForm->idMainButton);
		
		$objMyForm->strSubmit = LABEL_QUERY_BUTTON_FORM;
		
		/**
		 * Helps
		 */
		$objMyForm->styleTypeHelp = 2;
		
		$objMyForm->addHelp($objMyForm->idMainButton,LABEL_HELP_QUERY_BUTTON_FORM);
		
		$objMyForm->addHelp('add_rule',LABEL_HELP_ADD_RULE_QUERY_BUTTON_FORM);
		
		$objMyForm->addHelp('save_query',LABEL_HELP_DOWNLOAD_QUERY_BUTTON_FORM);
		
		$objMyForm->addHelp('cancel_query',LABEL_HELP_CANCEL_QUERY_BUTTON_FORM);
		
		
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