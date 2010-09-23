<?php

/**
 * Documentación de variables de sesión:
 * 
 * alInQu: Arreglo que contiene los alias con sus respectivos campos de la consulta.
 * sql: Consulta sql original
 * sqlW: Consulta sql de trabajo, esta cambiando segun los cambios que haga el usuario sobre la lista dinamica
 *  
 */


/**
 * 
 * @author Usuario
 *
 */
class myList  {
	
	/**
	 * Anchura de la tabla que contiene la lista
	 * 
	 * @var integer
	 */
	public $widthList = 1000;
	
	/**
	 * Formato aplicado a la anchura de la tabla que 
	 * contiene la lista.
	 * 
	 * @var string
	 */
	private $formatWidthList = 'px';
	
	/**
	 * Tamaño del borde de la lista entre celdas
	 * 
	 * @var integer
	 */
	private $borderCellSize = 1;
	
	/**
	 * Usar distincion entre filas
	 * 
	 * @var bool
	 */
	private $useDistBetwRows = true;
	
	/**
	 * Usar paginacion.
	 * 
	 * @var bool
	 */
	private $usePagination = false;
	
	/**
	 * Numero de registros por pagina cuando la paginacion
	 * esta activa.
	 * 
	 * @var integer
	 */
	private $recordsPerPage;
	
	/**
	 * Numero total de registros en todas las paginas
	 * 
	 * @var integer
	 */
	private $totalRows = 0;
	
	/**
	 * Pagina actual cuando la paginacion esta activa.
	 * 
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
	private $pathThemes = 'css/themes/';
	
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
		'themeName',
		'arrayWidthsCols',
		'usePagination',
		'recordsPerPage',
		'totalRows',
		'currentPage',
		'typeList'
		
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
	 * Arreglo con los anchos determinados para
	 * cada columna.
	 * @var array
	 */
	private $arrayWidthsCols = array ();
	
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
	private $errorSql = false;
	
	
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
	 * Obtiene la parte de la consulta correspodiente
	 * a armar una paginacion.
	 * 
	 * @return string
	 */
	private function getSqlPartLimit (){
		
		$sqlPart = '';
		
		//$sqlPart .= ' LIMIT  '.$this->getVar('recordsPerPage').' OFFSET '.($this->getVar('currentPage')*$this->getVar('recordsPerPage'));
		
		$sqlPart .= ' LIMIT  '.$this->recordsPerPage.' OFFSET '.($this->currentPage*$this->recordsPerPage);
		
		return $sqlPart;
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
	 */
	public function setAliasInQuery ($field, $alias){
		
		$this->arrayAliasSetInQuery[$alias] = $field;
		
	}
	
	/**
	 * Configura si una columna va a tener una propiedad especial 
	 * que le permitira a esta ser ordenada en forma ascendente o
	 * descendente o simplemente no ser organizada.
	 * 
	 * @param $alias
	 */
	public function setUseOrderMethodInColumn ($alias){
		
		//$this->setVar('arrayOrdMethod','',$alias);
		
		$this->arrayOrdMethod[$alias] = '';
		
	}
	
	/**
	 * Contruye una cadena que se incluye dentro del codigo
	 * html para cargar metodos dinamicos con javascript que
	 * permiten cargan opciones especiales de la lista.
	 * 
	 * @return string
	 */
	private function buildJs ($getNumFldsAftd){
		
		$js = ''."\n";
		
		$js .= '<script type=\'text/javascript\' charset=\'UTF-8\'> '."\n";
		
		$js .= 'myList = new myList(\''.$this->idList.'\', '.$getNumFldsAftd.');'."\n";

		$js .= 'myList.loadCss();'."\n";
		
		$js .= '</script>'."\n";
		
		$this->js = $js;
		
		return $this->js;
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
		
		$pathImg = $GLOBALS['urlProject'].'/'.$this->pathThemes.$this->themeName;
		
		$return = '&nbsp;';
		
		if ($method){
			
			$return = '<img src="';
			
			switch ($method){
				
				case 'ASC':
					$return .= $pathImg.'/asc.gif';
				break;
				
				case 'DESC':
					$return .= $pathImg.'/desc.gif';
				break;
			}
			
			$return .= '">';
		}
		
		return $return;
	}
	
	
	/**
	 * Construye la lista dinamica
	 * @return unknown_type
	 */
	private function buildList (){
		
		$buf = '';
		
		if ($this->sqlORobject){
			
			if (is_object($this->sqlORobject)){
			
				// Objeto
				
				$sql = '';
				
				$this->objConn = $this->sqlORobject;
		
				$this->sql = '';
				
				$tabStruct = $this->objConn->getAtt('tableStruct');
				
				$countFields = count($fields = $tabStruct[$table = $this->objConn->getAtt('table')]['fields']); 
				
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
				
				$this->resSql = $this->objConn->find(NULL,NULL,NULL,$this->recordsPerPage);
				
				# Para limitar la ultima pagina
				if (!$this->recordsPerPage)
					$this->totalRows = $this->objConn->getAffectedRows();
				
			}else{
			
				// Cadena
				
				$this->objConn = new myActiveRecord();
		
				$this->sql = $this->sqlORobject.''.$this->getSqlPartLimit();

				$this->resSql = $this->objConn->query ($this->sql);
				
				# Para limitar la ultima pagina
				if (!$this->recordsPerPage)
					$this->totalRows = $this->objConn->getAffectedRows();
			}
			
		}else{
			
			$this->restVarsSess();
			
			$this->objConn = new myActiveRecord();
			
			$sql = $this->sql.''.$this->getSqlPartOrderBy().''.$this->getSqlPartLimit();
					
			$this->resSql = $this->objConn->query($sql);
			
		}

		if ($this->objConn->getErrorLog())
			$this->errorSql = true;		
		
			
		# Numero de campos afectados
		$getNumFldsAftd = $this->objConn->getNumFieldsAffected();
		
		# Numero de registro afectados
		$getAffectedRows = $this->objConn->getAffectedRows();

		/**
		 * Calcular el ancho de cada columna si no hay definido
		 * un ancho especifico definido antes por el usuario.
		 */
		$widByCol = 0;
		
		$totWid = $this->widthList;
		
		foreach ($this->arrayWidthsCols as $col => $wid)
			$totWid -= $wid;
			
		$widByCol	= $totWid / ($getNumFldsAftd - count($this->arrayWidthsCols)); 
		
		$cadParam = '';
		
		$bufHead = '';
		
		$sw = false;
		
		$return = '';
			
		$rows = $this->resSql;
		
		$buf .= $this->buildJs($getNumFldsAftd);
		
		$buf .= '<div id="'.$this->idList.'" name="'.$this->idList.'">'."\n";
		
		$buf .=  "\n".'<table border="0" width="'.$this->widthList.''.$this->formatWidthList.'" cellspacing="0" cellpadding="0"><tr><td class="list">'."\n";
		
		if ($this->errorSql){
			
			$buf .= '<div class="error_sql_list"><b>Error: </b>'.$this->objConn->getErrorLog().'<br><br><div class="error_sql_list_detail"><b>Query:</b> '.$this->objConn->getSqlLog().'</div></div>';
		
		}else{
			
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
				
					$arrColOrd = array ();
				
					$sw = true;
				
					$bufHead.='<tr>'."\n"."\t";

					foreach ($row as $key => $val){
					
						if (!is_numeric($key)){
						
							$widCol = 0;
							if (isset($this->arrayWidthsCols[$key]))
								$widCol = $this->arrayWidthsCols[$key];
							else
								$widCol = $widByCol;
						
							$orderBy = '';	
								
							if (isset($this->arrayOrdMethod[$key])){
								
								$orderBy = $this->arrayOrdMethod[$key];
							
								$styleName = 'cell_title';
							
								if ($orderBy){
								
									$cadParam .= '2,';
								
									$styleName = 'cell_title_selected';
								
									$arrColOrd[] = $key; 
								}else{
									$cadParam .= '1,';
								}
							
								$bufHead.='<td class="'.$styleName.'" width="'.$widCol.'" align="center">';
							
								$bufHead.='<table border="0" width="100%" align="center"><tr><td width="10%">'.$this->getSrcImageOrdMethod($orderBy).'</td><td width="80%" style="text-align:center">'; 
							
								$bufHead.='<a class="column_title" href="javascript:;" onClick="myListMoveTo(\''.$this->idList.'\',\''.$key.'\')">'.ucwords($key).'</a>';

								$bufHead.='</td><td width="10%">&nbsp;</td></tr></table>';
							
								$bufHead.='</td>';
							
							}else{
							
								$cadParam .= '1,';
							
								$bufHead.='<td class="cell_title" width="'.$widCol.'">';
								
								$bufHead.='<font class="column_title">'.ucwords($key).'</font>';
							
								$bufHead.='</td>';	
							}
							
						}
					
					}
				
					$bufHead .=  '</tr>'."\n";
				
					$buf .='{bufHead}';
			
				}
			
				$buf.='<tr ';
			
				$buf.='id="tr_'.$this->idList.'_'.$i.'" ';
			
				$buf.='onclick="myList.markRow(this, \''.$classTd.'\',\''.substr($cadParam,0,-1).'\')" ';
			
				$buf.='onmouseover="myList.onRow(this)" ';
			
				$buf.='onmouseout="myList.outRow(this, \''.$classTd.'\',\''.substr($cadParam,0,-1).'\')" ';
			
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
						
						$buf.=$val;	
					
						$buf.='</td>';
					}
				
				}

				$buf.= "\n".'</tr>'."\n";
				$i++;
			}
			
			$buf .=  '</tbody>'."\n";
		
			$buf .=  '</table>'."\n";
			
		}	
			
		$buf .=  '</td></tr></table>'."\n";

		
		# Usar paginacion
		if ($this->getVar('usePagination')){
			
			$arrBut = array(
				'_ini_page'	 =>array('<<','beg'),
			
				'_back_page' =>array('<', 'bac'),
			
				'_next_page' =>array('>', 'nex'),
			
				'_end_page'	 =>array('>>','end')
			);
			
			
			$objMyForm = new myForm;
			
			$buf .= '<div id="pag_'.$this->idList.'" name="pag_'.$this->idList.'">'."\n";
		
			$buf .= '<table border="0"><tr>';

			if ($this->currentPage == 0){
				$objMyForm->addDisabled($this->idList.'_ini_page');
				
				$objMyForm->addDisabled($this->idList.'_back_page');
			}
				
			foreach ($arrBut as $id => $but){

				$buf .= '<td>'; 
			
				$buf .= $objMyForm->getButton($this->idList.$id,$but[0],'myListPage:'.$this->idList.':'.$but[1]);
			
				$buf .= '</td>';
				
			}
			
			$buf .= '</tr></table>';
			
			$buf .= '</div>'."\n";
		}		
		
		
		$buf .= ''.'</div>'."\n";
		
		$this->bufHtml =  str_replace('{bufHead}',$bufHead,$buf);
		
		# Registramos las variables que se han usado
		$this->regAttClass(get_class_vars(get_class($this)));
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
		
		if ($item){
			if (isset($_SESSION['prdLst'][$this->idList][$name][$item]))
				$_SESSION['prdLst'][$this->idList][$name][$item] = $val;
		}else{
			if (isset($_SESSION['prdLst'][$this->idList][$name]))
				$_SESSION['prdLst'][$this->idList][$name] = $val;
		}		
		
	} 
	
	/**
	 * Obtiene la lista dinamica
	 * @return string
	 */
	public function getList (){
		
		$this->buildList();
		
		return $this->bufHtml;
	}

	
}


?>