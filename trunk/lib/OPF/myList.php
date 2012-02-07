<?php
/**
 * myList
 *
 * Es la propuesta de osezno-framework cuando se desea implementar una
 * lista dianamica (grid) por medio de una consulta sql o una tabla de myActiveRecord.
 *
 * <code>
 *
 * # Ejemplo en la definición:
 *
 * <?php
 *
 *      $myList = new OPF_myList('list_1','SELECT * FROM table');
 *
 *      echo $myList->getList();
 *
 * ?>
 *
 * </code>
 * @uses Listas dinamicas
 * @package OPF
 * @version 0.1
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */
class OPF_myList  {

	/**
	 * Ancho de la lista
	 *
	 * Define el ancho de la lista dinámica en px
	 * @var integer
	 */
	public $width = 1000;

	/**
	 * Formato ancho
	 *
	 * Formato aplicado a la anchura de la tabla que contiene la lista.
	 * @access private
	 * @var string
	 */
	private $formatWidthList = 'px';

	/**
	 * Borde entre celdas
	 *
	 * Tamaño del borde de la lista entre celdas
	 * @access private
	 * @var integer
	 */
	private $borderCellSize = 1;

	/**
	 * Distinguir filas
	 *
	 * Usar distincion entre filas
	 * @access private
	 * @var boolean
	 */
	private $useDistBetwRows = true;

	/**
	 * Usar paginacion.
	 *
	 * Usar paginacion en la lista.
	 * @access private
	 * @var boolean
	 */
	private $usePagination = false;

	/**
	 * Usar Sql Debug
	 *
	 * Habilita la impresion del sql en pantalla para
	 * analizar a medida que se aplican diferentes
	 * acciones sobre la lista dinamica.
	 * @var boolean
	 */
	private $useSqlDebug = false;

	/**
	 * Registros por pagina.
	 *
	 * Numero de registros por pagina cuando la paginacion esta activa.
	 * @access private
	 * @var integer
	 */
	private $recordsPerPage;

	/**
	 * Numero de registros por pagina cuando el usuario selecciona desde el formulario
	 * @access private
	 * @var integer
	 */
	private $recordsPerPageForm = 1;

	/**
	 * Maxima numero de pagina encontrada
	 * @access private
	 * @var integer
	 */
	private $maxNumPage = 0;

	/**
	 * Numero actual de regla maxima
	 * @access private
	 * @var integer
	 */
	private $numRuleQuery = 0;

	/**
	 * Pagina actual cuando la paginacion esta activa.
	 * @access private
	 * @var unknown_type
	 */
	private $currentPage;

	/**
	 * Path imagenes
	 *
	 * Path subcarpeta dentro de la carpeta principal del proyecto que almacena las imagenes generales que se usan en las lista dianmicas.
	 * @access private
	 * @var string
	 */
	private $pathThemes = 'themes/';

	/**
	 * Atributos accesibles.
	 *
	 * Nombre de los atributos seteables
	 * @access private
	 * @var array
	 */
	private $validNomKeys = array (
                'width',
                'formatWidthList',
                'borderCellSize',
                'useDistBetwRows',
                'pathThemes',
                'sql',
                'arrayAliasSetInQuery',
                'arrayOrdMethod',
                'useOrderMethod',
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
                'globalEventsName',
                'useSqlDebug',
                'engineDb',
                'numAffectedRows',
                'numFldsAftd',
                'externalMethods'
                );

                /**
                 * Tipos de filtro
                 *
                 * Relacion en filtros sql
                 * @access private
                 * @var mixed
                 */
                private $myDinamicListRel = array(

                        'like'=>'LIKE',

                        'in'=>'IN',

                        'greater_than'=>'>',

                        'greater_equal_than'=>'>=',

                        'equal'=>'=',

                        'different'=>'<>',

                        'less_than'=>'<',

                        'less_equal_than'=>'<=',

                        'notin'=>'NOT IN',

                        'notlike'=>'NOT LIKE'
                        
                );

                /**
                 * Motor de base de datos que usa.
                 *
                 * @var string
                 */
                private $engineDb = '';

                /**
                 * Tipo de lista
                 *
                 * Define el tipo de lista actual.
                 * @access private
                 * @var string
                 */
                private $typeList = '';

                /**
                 * HTML resultado.
                 *
                 * Hmtl de la lista dinamica
                 * @access private
                 * @var string
                 */
                private $bufHtml = '';

                /**
                 * Objeto conexion
                 *
                 * Objeto de la conexion a BD
                 * @access private
                 * @var object
                 */
                private $objConn;

                /**
                 * Objeto form
                 *
                 * Objeto de formularios
                 * @access private
                 * @var object
                 */
                private $objForm;

                /**
                 * SQL
                 *
                 * Cadena de la consulta SQL
                 * @access private
                 * @var string
                 */
                private $sql = '';

                /**
                 * JS
                 *
                 * Cadena de las funciones JS
                 * @access private
                 * @var string
                 */
                private $js = '';

                /**
                 * SQL result
                 *
                 * Objeto resultado de la consulta SQL
                 * @access private
                 * @var array
                 */
                private $resSql;

                /**
                 * Registros afectados
                 *
                 * Numero de registro afectados por la consulta.
                 * @access private
                 * @var integer
                 */
                private $numAffectedRows = 0;

                /**
                 * Numero de campos afectados y numero de campos mostrado en la lista.
                 * @access private
                 * @var integer
                 */
                private $numFldsAftd = 0;

                /**
                 * Id lista
                 *
                 * Nombre o Id de la lista dinamica
                 * @access private
                 * @var string
                 */
                private $idList = '';

                /**
                 * Alias
                 *
                 * Arreglo que contiene los alias de los campos
                 * @access private
                 * @var array
                 */
                private $arrayAliasSetInQuery = array ();

                /**
                 * Ordenamientos
                 *
                 * Areglo con los metodos de ordenamiento por campo de la consulta
                 * @access private
                 * @var array
                 */
                private $arrayOrdMethod = array ();

                /**
                 * Usar o no ordenamiento automatico en la lista dinamica
                 * @access private
                 * @var boolean
                 */
                private $useOrderMethod = false;

                /**
                 * Subquerys
                 *
                 * Arreglo con las subconsultas que intervienen como reglas.
                 * @access private
                 * @var array
                 */
                private $arrayWhereRules = array ();

                /**
                 * Numero de ordenamiento
                 * @access private
                 * @var array
                 */
                private $arrayOrdNum = array ();

                /**
                 * Anchos por columna
                 *
                 * Arreglo con los anchos determinados para cada columna.
                 * @access private
                 * @var array
                 */
                private $arrayWidthsCols = array ();

                /**
                 * Eventos
                 *
                 * Arreglo con los eventos en columnas.
                 * @access private
                 * @var array
                 */
                private $arrayEventOnColumn = array ();

                /**
                 * Metodos externos
                 *
                 * Arreglo con los nombres de los metodos externos sobre columnas.
                 * @var array
                 * @access private
                 */
                private $externalMethods = array ();

                /**
                 * Arreglo con los nombres de las columnas obtenidos
                 * @access private
                 * @var array
                 */
                private $arrayFieldsOnQuery = array();

                /**
                 * Formatos disponibles para exportar
                 *
                 * Arreglo con los tipos de datos en que es posible exportar la lista dinamica
                 * @access private
                 * @var array
                 */
                private $arrayDataTypeExport = array ('xls'=>false, 'html'=>false, 'pdf'=>false);

                /**
                 * Columna evento global
                 *
                 * Nombre de la columna del evento global
                 * @access private
                 * @var string
                 */
                private $globalEventOnColumn = '';

                /**
                 * Eventos globales
                 *
                 * Arreglo con los metodos y nombres que se ejecutaran en el evento global
                 * @access private
                 * @var array
                 */
                private $globalEventsName = array();

                /**
                 * Error SQL
                 *
                 * Ultimo error de la consulta SQL
                 * @access private
                 * @var string
                 */
                private $errorLog;

                /**
                 * Tema lista
                 *
                 * Nombre del tema de estilo que usara la lista
                 * @access private
                 * @var string
                 */
                private $themeName = 'default';

                /**
                 * Consulta exitosa
                 *
                 * Determina si existe un error en la consutla sql que se ejecuto previo la construccion de la lista.
                 * @access private
                 * @var bool
                 */
                private $successFul = true;

                /**
                 * Objeto myAct
                 *
                 * Cadena SQL u Objeto
                 * @access private
                 * @var string
                 */
                private $sqlORobject;

                /**
                 * Constructor
                 *
                 * Instancia un nuevo objeto de tipo lista dinamica para que pueda ser mostrada cuando se necesite.
                 *<code>
                 *
                 *Ejemplo 1:
                 *
                 *<?php
                 *
                 *  $sql = 'SELECT * FROM table';
                 *
                 *      $myList = new OPF_myList('list_1',$sql);
                 *
                 *      echo $myList->getList();
                 *
                 *?>
                 *
                 *Ejemplo 2:
                 *
                 *<?php
                 *
                 *      class table extends myActiveRecord {
                 *
                 *              public $id;
                 *
                 *              public $name;
                 *
                 *              public $last_name;
                 *
                 *  }
                 *
                 *  $table = new table;
                 *
                 *  $myList = new OPF_myList('list_1',$table);
                 *
                 *  echo $myList->getList();
                 *
                 *?>
                 *
                 *</code>
                 * @param string $idList        Nombre de la lista dinamica.
                 * @param string $sqlORobject   SQL u Objeto tabla.
                 */
                public function __construct($idList, $sqlORobject = ''){

                	$this->idList = $idList;

                	if ($sqlORobject){

                		if (is_object($sqlORobject)){
                			$this->typeList = 'object';
                		}else{
                			$this->typeList = 'string';
                		}

                	}

                	$this->sqlORobject = $sqlORobject;

                	$this->objForm = new OPF_myForm;

                	$this->objForm->setParamTypeOnEvent('field');

                	$this->themeName = THEME_NAME;
                }

                /**
                 * Seleccionar un tema
                 *
                 * Selecciona un tema de estilos para las lista dinamica. Si no se especifica uno, se toma el configurado a nivel de la aplicacion y el metodo retorna el tema en uso.
                 * @param string $theme Nombre del tema
                 * @return string Tema en uso
                 */
                public function setTheme ($theme = ''){

                	if ($theme)
                	$this->themeName = $theme;
                	else{
                		return  $GLOBALS['urlProject'].'/'.$this->pathThemes.$this->themeName.'/style.css.php?img='.$GLOBALS['urlProject'].'/css/themes/'.$this->themeName.'/';
                	}
                }

                /**
                 * Configura una paginación.
                 *
                 * Configura una paginacion sobre la lista dinamica.
                 * @param boolean $use  Activa o inactiva la paginación de la lista dinámica.
                 * @param integer $rows Número de registro a mostrar por pagina.
                 */
                public function setPagination ($use = true, $rows = 20){

                	$this->usePagination = $use;

                	$this->recordsPerPage = $rows;

                	$this->currentPage = 0;
                }

                /**
                 * Habilita una debud para Sql.
                 *
                 * Muestra en pantalla junto a la lista dinamica, un registro de los
                 * cambios sobre la consulta sql que se van produciendo a medida que
                 * se aplican filtros y ordenamientos.
                 * @param boolean $use Activa o inactiva el debug
                 */
                public function setSqlDebug ($use = true){

                	$this->useSqlDebug = $use;
                }

                /**
                 * Configurar ancho em columna.
                 *
                 * Configura manualmente un acho determinado para cada columna de la lista dinamica.
                 * @param string $alias Nombre de la columna o alias
                 * @param integer $width        Ancho de la columna en PX o %
                 */
                public function setWidthColumn ($alias, $width){

                	if (is_int($width))

                	$this->arrayWidthsCols[$alias] = $width;
                	else
                	$this->arrayWidthsCols[$alias] = intval($width);

                }

                /**
                 * Configurar evento sobre columna.
                 *
                 * Configura en una columna segun su alias o nombre un evento que se disparara al hacer click sobre ese campo en esa columna. El evento recibira como parametro el valor de la columna y tambien el nombre de la lista dinamica.
                 * <code>
                 *
                 * Ejemplo:
                 *
                 * Index.php
                 * <?php
                 *
                 * $sql = 'SELECT id, name, last_name FROM table';
                 *
                 * $myList = new OPF_myList('list_1',$sql);
                 *
                 * $myList->setEventOnColumn('id','showInfoUser');
                 *
                 * echo $myList->getList();
                 *
                 * ?>
                 *
                 * handlerEvent.php
                 * <?php
                 *
                 * class className extends myController {
                 *
                 *              public function showInfoUser ($id){
                 *
                 *                      $this->alert($id);
                 *
                 *                      return $this->response;
                 *              }
                 *
                 * }
                 *
                 * $objclassName = new className($objxAjax);
                 *
                 * ?>
                 *
                 * </code>
                 * @param string $alias Alias o nombre de la columna como la escribio
                 * @param strinh $event Nombre del evento que disparara en el handlerEvent
                 * @param string $confirm_msg   Mensaje de confirmacion antes de ejecutar el evento.
                 */
                public function setEventOnColumn ($alias, $event, $confirm_msg = ''){

                	$this->arrayEventOnColumn[$alias] = $event.'::'.$confirm_msg;
                }

                /**
                 * Habilitar exportar datos.
                 *
                 * Configura la posibilidad de que en una lista dinamica se le permita descargar la consulta actual en un formato seleccionable.
                 * @param boolean $xls  Formato xls
                 * @param boolean $html Formato html
                 * @param boolean $pdf  Formato pdf
                 */
                public function setExportData ($xls = false, $html = false, $pdf = false){

                	$this->arrayDataTypeExport = array(
                        'xls'=>$xls,
                        'html'=>$html,
                        'pdf'=>$pdf
                	);
                }

                /**
                 * Configurar evento global.
                 *
                 * Configura un unico evento global en una lista dinamica sobre columna definida para que los registros marcados se vean afectados por dicho evento o eventos. El evento programado recibira en un arreglo los registros seleccionados de dicha columna.
                 *<code>
                 *
                 * Ejemplo:
                 *
                 * Index.php
                 * <?php
                 *
                 * $sql = 'SELECT id, name, last_name FROM table';
                 *
                 * $myList = new OPF_myList('list_1',$sql);
                 *
                 * # Configuramos dos posibles opciones en el evento global.
                 *
                 * $myList->setGlobalEventOnColumn('id',array(
                 *
                 *      'Eliminar'=>'deleteRecord',
                 *
                 *      'Actualizar'=>'updateRecord'
                 *
                 * ));
                 *
                 * echo $myList->getList();
                 *
                 * ?>
                 *
                 * handlerEvent.php
                 * <?php
                 *
                 * # Definimos los eventos.
                 *
                 * class className extends myController {
                 *
                 *      # Cada metodo definido recibira un arreglo con los ids de los registros seleccionados. En este caso se utilizo el valor de la columna 'id'
                 *
                 *              public function deleteRecord ($items){
                 *
                 *                      $this->alert(var_export($items,true));
                 *
                 *                      return $this->response;
                 *              }
                 *
                 *              public function updateRecord ($items){
                 *
                 *                      $this->alert(var_export($items,true));
                 *
                 *                      return $this->response;
                 *              }
                 *
                 * }
                 *
                 * $objclassName = new className($objxAjax);
                 *
                 * ?>
                 *
                 *</code>
                 * @param string $alias Alias o nombre de la columna del que tomara el valor
                 * @param string $events        Array con los etiquetas y nombres de eventos que ejecutara el handlerEvent
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
                 * Obtiene la parte de la consulta correspondiente a condiciones cuando fueron aplicadas en el filtro.
                 * @return string
                 */
                private function getSqlPartWhere (){

                	$sqlWhere = '';

                	$lastIsOr = false;

                	if (count($this->arrayWhereRules)){

                		if (stripos($this->sql, 'WHERE')!==false)
                		$sqlWhere = ' AND (';
                		else
                		$sqlWhere = ' WHERE (1=1 AND ';

                		$rules = '';

                		foreach ($this->arrayWhereRules as $id => $rule){

                			$rules .= $rule.' ';

                		}

                		$sqlWhere .= substr($rules, 3).')';
                	}

                	return $sqlWhere;
                }

                /**
                 * Obtiene una cadena de texto que le indica a la consulta sql principal como debe organizar el resultado de la consulta.
                 * @return string
                 */
                private function getSqlPartOrderBy (){

                	$sqlPart = '';

                	if ($this->arrayOrdMethod!==false){

                		foreach ($this->arrayOrdMethod as $column => $method){

                			if (!$sqlPart)
                			$sqlPart = ' ORDER BY ';

                			if ($method){

                				if (isset($this->arrayAliasSetInQuery[$column]))

                				$sqlPart .= ''.$this->arrayAliasSetInQuery[$column].' '.$method.', ';

                				else

                				$sqlPart .= '"'.$column.'" '.$method.', ';
                			}
                		}
                	}

                	$sqlPart = substr($sqlPart,0,-2);

                	return $sqlPart;
                }

                /**
                 * Configurar Alias
                 *
                 * Configura un campo en la consulta SQL para  que  le sea definido un alias y este pueda ser usado en los demas procesos de busqueda, consulta y ordenamiento.
                 * <code>
                 *
                 * query.sql
                 *
                 * SELECT lpad(CAST(ident as varchar),4,'0') as Identification, nom as User FROM users
                 *
                 * <?php
                 *
                 * // En ocaciones necesitamos aplicar funciones SQL sobre campos de una consulta.
                 *
                 * // Para evitar problemas a la hora de aplicar funcionalidades de listas dinamicas (ordenamientos y filtros) guardamos el nombre del campo original sobre el alias creado.
                 *
                 * $myAct = new OPF_myActiveRecord();
                 *
                 * $myList = new OPF_myList ('idents',$myAct->loadSqlFromFile('query.sql'));
                 *
                 * $myList->setRealNameInQuery('Identification','lpad(CAST(ident as varchar),4,\'0\')');
                 *
                 * echo $myList->getList(true);
                 *
                 * // Lo anterior ayuda a aplicar correctamente un filtro o un ordenamiento sobre el campo 'Identification'.
                 *
                 * ?>
                 *
                 * </code>
                 * @param string $field Nombre del campo en la consulta o Alias
                 * @param string $alias Nombre real compuesto en la consulta
                 */
                public function setRealNameInQuery ($field, $realName){

                	$this->arrayAliasSetInQuery[$field] = $realName;
                }

                /**
                 * Configurar ordenamiento
                 *
                 * Configura si la lista dinamica va a tener una propiedad especial que le permitira a esta ser ordenada en forma ascendente o descendente o simplemente no ser organizada en cada columna.
                 * @param boolean $use Activar o Inactivar
                 * @param string $defaultColumn Nombre de la columna que se mostrara ordenada al cargar la lista dinamica.
                 * @param string $defaultMethod Metodo de ordenamiento que usara la columna a ordenar ASC o DESC.
                 */
                public function setUseOrderMethod ($use, $defaultColumn = '', $defaultMethod = 'ASC'){

                	$default = 'ASC';

                	$methods = array('ASC','DESC');

                	$this->useOrderMethod = $use;

                	if ($defaultColumn){

                		$defaultColumn = ($defaultColumn);
                		 
                		$this->arrayOrdNum[$defaultColumn] = $defaultColumn;

                		if (in_array(strtoupper($defaultMethod),$methods))

                		$this->arrayOrdMethod[$defaultColumn]=strtoupper($defaultMethod);

                		else

                		$this->arrayOrdMethod[$defaultColumn]=$default;
                	}
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
                 * @param $method       Metodo de ordenamiento
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

                private $firsKey = false;

                /**
                 * Construye la lista dinamica
                 * @param $showQueryForm        Mostrar formulario de consulta
                 * @param $showFirstRule        Mostrar primera regla de formulario de consulta
                 * @return unknown_type
                 */
                private function buildList ($showQueryForm, $showFirstRule){

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

                				$this->setRealNameInQuery($field,$field);

                				if ($iCounter<$countFields)

                				$subSqlF .= ', ';

                				$iCounter++;
                			}

                			$sql = 'SELECT '.$subSqlF.' FROM '.$table;

                			$this->sql = $sql;

                		}else{

                			// Cadena

                			$this->objConn = new OPF_myActiveRecord();

                			$sql = $this->sql = $this->sqlORobject;
                		}

                		if ($this->objConn->isSuccessfulConnect()){

                			$this->resSql = $this->objConn->query ($this->sql.''.$this->getSqlPartOrderBy().''.$this->getSqlPartLimit());
                		}

                		$this->engineDb = $this->objConn->getEngine();

                	}else{

                		$this->restVarsSess();

                		$this->objConn = new OPF_myActiveRecord();

                		$sql = $this->sql.''.$this->getSqlPartWhere().''.$this->getSqlPartOrderBy().''.$this->getSqlPartLimit();

                		if ($this->objConn->isSuccessfulConnect()){

                			$this->resSql = $this->objConn->query($sql);
                		}

                	}

                	if ($this->objConn->getErrorLog(true))
                	$this->successFul = false;


                	# Numero de campos afectados
                	$this->numFldsAftd = $this->objConn->getNumFieldsAffected();

                	# Numero de registro afectados
                	$this->numAffectedRows = $this->objConn->getNumRowsAffected();

                	/**
                	 * Calcular el ancho de cada columna si no hay definido
                	 * un ancho especifico definido antes por el usuario.
                	 */
                	$widByCol = 0;

                	$totWid = $this->width;

                	$return = $bufHead = $cadParam = '';

                	$buf .= '<div id="'.$this->idList.'" name="'.$this->idList.'">'."\n";

                	if ($this->useSqlDebug){

                		$buf .= '<div style="text-align:left" class="form_cont_filter"><b>Sql:&nbsp;</b>'.$sql.'<br>';

                		$buf .= '<b>Registros:&nbsp;</b>'.$this->numAffectedRows.'</div><br>';
                	}

                	if (!$this->successFul){

                		$buf .= $this->objConn->getErrorLog(true);

                	}else{

                		$i = 0;
                		 
                		if ($this->numAffectedRows){

                			$buf .=  "\n".'<table border="0" width="'.$this->width.''.$this->formatWidthList.'" cellspacing="0" cellpadding="0" align="center"><tr><td class="list">'."\n";

                			foreach ($this->arrayWidthsCols as $col => $wid){
                				$totWid -= $wid;
                			}

                			if ($totWid)
                			$widByCol       = $totWid / ($this->numFldsAftd - count($this->arrayWidthsCols));

                			$sw = false;

                			$buf .=  "\n".'<table border="0" width="100%" cellspacing="'.$this->borderCellSize.'" cellpadding="0" id="table_'.$this->idList.'">'."\n";

                			$i = 0;

                			$classTd = 'td_default';

                			$rows = $this->resSql;

                			foreach ($rows as $row){

                				if ($this->useDistBetwRows){
                					if ($i%2)
                					$classTd = 'td_default';
                					else
                					$classTd = 'td_middle';
                				}

                				# Titulos de las columnas

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

                							$key = $key;

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

                							if ($this->useOrderMethod && !isset($this->arrayEventOnColumn[$key])){

                								$orderBy = '';

                								if (isset($this->arrayOrdMethod[$key]))
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

                								$bufHead.='<a class="column_title" href="javascript:;" onClick="MYLIST_moveTo(\''.$this->idList.'\',\''.$key.'\')">'.(ucwords($key)).'</a>';

                								$bufHead.='</td><td width="20px" background="'.$this->getSrcImageOrdMethod($orderBy).'" class="num_ord_ref">'.$numOrder.'</td></tr></table>';

                								$bufHead.='</td>';

                							}else{

                								$cadParam .= '1,';

                								$bufHead.='<td width="'.$widCol.'" align="center" class="cell_title">';

                								$bufHead.='<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center"><tr><td width="20px">'.$htmlGlobal.'</td><td align="center">';

                								$bufHead.='<font class="column_title">'.(ucwords($key)).'</font>';

                								$bufHead.='</td><td width="20px">&nbsp;</td></tr></table>';

                								$bufHead.='</td>';

                							}

                						}

                					}

                					$bufHead .=  '</tr>'."\n";

                					$bufHead = str_replace('{htmlGlobal}',$this->returnCheckBox($this->numFldsAftd, $cadParam),$bufHead);

                					$buf .='{bufHead}';

                				}

                				$nmCheck = '';

                				if ($this->globalEventOnColumn){

                					$alsGbl = $this->globalEventOnColumn;

                					if ($row->$alsGbl)

                					$nmCheck = $this->idList.'_'.$row->$alsGbl;
                				}

                				$buf.='<tr ';

                				$buf.='id="tr_'.$this->idList.'_'.$i.'" ';

                				$buf.='onDblClick="markRow(this, \''.$classTd.'\',\''.substr($cadParam,0,-1).'\', '.$this->numFldsAftd.', \''.$nmCheck.'\')" ';

                				$buf.='onmouseover="onRow(this, '.$this->numFldsAftd.')" ';

                				$buf.='onmouseout="outRow(this, \''.$classTd.'\',\''.substr($cadParam,0,-1).'\', '.$this->numFldsAftd.')" ';

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

                							if ($row->$alsGbl){

                								$this->objForm->addEvent($nmCheck,'onclick','check_onlist',array($nmCheck));

                								$buf.='<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center"><tr><td width="20px">'.$this->objForm->getCheckBox($nmCheck).'</td><td class="'.$class.'_checkbox">';
                								 
                							}else{
                								 
                								$buf.='<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center"><tr><td width="20px"></td><td class="'.$class.'_checkbox">';
                								 
                							}
                						}

                						if (isset($this->arrayEventOnColumn[$key])){

                							list($event,$strMsg) = explode('::',$this->arrayEventOnColumn[$key]);

                							if ($strMsg)
                							$strMsg = ' onClick="return confirm(\''.$strMsg.'\')"';

                							if ($val)

                							$buf.='<a href="javascript:void('.$event.'(\''.$val.'\',\''.$this->idList.'\'))"'.$strMsg.'>'.ucwords($key).'</a>';

                						}else if (isset($this->externalMethods[$key])){
                							 
                							$strNameMethod = $this->externalMethods[$key]['strNameMethod'];
                							 
                							$buf.= $this->externalMethods[$key]['objClass']->$strNameMethod($val).' ';
                							 
                						}else{

                							$buf.= ($val).' ';
                							 
                						}

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

                	$buf .= '<div  style="width:'.$this->width.''.$this->formatWidthList.'" id="pag_'.$this->idList.'" name="pag_'.$this->idList.'">'."\n";

                	$buf .= '<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%"><tr><td align="left" width="33%">';

                	if($this->globalEventOnColumn && $this->successFul){

                		$idSelect = 'global_event_'.$this->idList;

                		$this->objForm->name = $this->idList;

                		$this->objForm->selectStringFirstLabelOption = LABEL_FIRST_OPT_SELECT_GLOBAL_ACTION;

                		$this->objForm->styleTypeHelp = 2;

                		$this->objForm->addEvent($idSelect,'onchange','execGlobalEventOnList',$this->idList, $idSelect);

                		$this->objForm->addHelp($idSelect,LABEL_HELP_SELECT_GLOBAL_ACTION);

                		$buf .= $this->objForm->getSelect($idSelect,array_flip($this->globalEventsName));

                	}else
                	$buf .= '&nbsp;';

                	$buf .= '</td><td width="34%" align="center">';

                	# Usar paginacion
                	if ($this->usePagination && $this->successFul){

                		$arrBut = array(
                                '_ini_page'      =>array('&nbsp;--&nbsp;','beg','button'),

                                '_back_page' =>array('&nbsp;-1&nbsp;', 'bac','button'),

                                '_goto_page' =>array(($this->currentPage+1),'goto','field'),

                                '_chg_pag'       =>array(
                		array(1=>($this->recordsPerPage*1),
                		2=>($this->recordsPerPage*2),
                		3=>($this->recordsPerPage*3),
                		4=>($this->recordsPerPage*4),
                		5=>($this->recordsPerPage*5)),'amp_pag','select'),

                                '_next_page' =>array('&nbsp;+1&nbsp;', 'nex','button'),

                                '_end_page'      =>array('&nbsp;++&nbsp;','end','button')
                		);


                		$objMyForm = new OPF_myForm;

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

                					//$htmlBut = '<img src="'.$GLOBALS['urlProject'].'/'.$this->pathThemes.$this->themeName.'/mylist/'.$id.'.gif">';

                					$objMyForm->addEvent($this->idList.$id,'onclick','MYLIST_page',$this->idList,$attr[1]);

                					$buf .= $objMyForm->getButton($this->idList.$id,'','../../'.$this->themeName.'/mylist/'.$id.'.gif');
                					break;
                				case 'field':

                					//$objMyForm->addEvent($this->idList.$id,'onChange','myListPage',array($this->idList,$attr[1]));

                					$objMyForm->addHelp($this->idList.$id,'&nbsp;'.LABEL_HELP_PAGACT_FORM.' <b>'.$attr[0].'</b>'.'&nbsp;');

                					$buf .= $objMyForm->getText($this->idList.$id,$attr[0],1,NULL,true);

                					break;
                				case 'select':

                					$objMyForm->addHelp($this->idList.$id,'&nbsp;'.LABEL_HELP_CHPAG_SELECT_FORM.'&nbsp;');

                					$objMyForm->addEvent($this->idList.$id,'onchange','MYLIST_chPag',$this->idList);

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

                	$this->bufHtml = $this->buildQueryForm($showFirstRule).$this->bufHtml;

                	# Registramos las variables que se han usado
                	$this->regAttClass(get_class_vars(get_class($this)));
                }

                /**
                 * Retorna el campo checkbox que acompaña cada registro cuando el evento global esta activo
                 *
                 * @param $getNumFldsAftd       Numero de campos afectados
                 * @param $cadParam                     Columnas ordenadas
                 * @return string
                 */
                private function returnCheckBox ($getNumFldsAftd, $cadParam){

                	$htmlGlobal = '';

                	if ($this->globalEventOnColumn){

                		list ($alsGbl) = explode('::',$this->globalEventOnColumn);

                		$nmChk = $this->idList.'_over_all';

                		$this->objForm->addEvent($nmChk,'onclick','checkAllBoxesOnList',$this->idList,$nmChk, $getNumFldsAftd, $cadParam);

                		$htmlGlobal = $this->objForm->getCheckBox($nmChk);
                	}

                	return  $htmlGlobal;
                }

                /**
                 * Obtener formulario de filtro
                 *
                 * Retorna el formulario de filtro para una lista dinámica.
                 * @param boolean $showFirstRule        Mostrar primera regla/filtro al iniciar.
                 * @return string
                 */
                public function getQueryForm ($showFirstRule = false){

                	return $this->buildQueryForm($showFirstRule);
                }

                /**
                 * Construye el Html del formulario de consulta
                 * @return string
                 */
                private function buildQueryForm ($showFirstRule){

                	$arFields = array();

                	$objMyForm = new OPF_myForm($nomForm = $this->idList.'QueryForm');

                	$objMyForm->width = '98%';

                	$objMyForm->border = 0;

                	$objMyForm->styleClassTags = 'texto_formularios';

                	$objMyForm->styleClassForm = 'form_cont_filter';

                	$htble = '';

                	/**
                	 * Helps
                	 */
                	$objMyForm->styleTypeHelp = 2;

                	$objMyForm->addDisabled('cancel_query_'.$this->idList);

                	$objMyForm->addDisabled('save_query_'.$this->idList);

                	$htble .= '<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>';

                	$anyBut = false;

                	$objMyForm->addHelp('pdf_'.$this->idList,LABEL_HELP_PDF_BUTTON_FORM);

                	if (!$this->arrayDataTypeExport['pdf'])
                	$objMyForm->addDisabled('pdf_'.$this->idList);
                	else
                	$anyBut = true;

                	$objMyForm->addEvent('pdf_'.$this->idList,'onclick','MYLIST_exportData','pdf',$this->idList);

                	$htble .= '<td width="10%" align="left">'.$objMyForm->getButton('pdf_'.$this->idList,'','pdf.gif').'</td>';

                	$objMyForm->addHelp('xls_'.$this->idList,LABEL_HELP_EXCEL_BUTTON_FORM);

                	if (!$this->arrayDataTypeExport['xls'])
                	$objMyForm->addDisabled('xls_'.$this->idList);
                	else
                	$anyBut = true;

                	$objMyForm->addEvent('xls_'.$this->idList,'onclick','MYLIST_exportData','xls',$this->idList);

                	$htble .= '<td width="10%" align="left">'.$objMyForm->getButton('xls_'.$this->idList,'','excel.gif').'</td>';

                	$objMyForm->addHelp('html_'.$this->idList,LABEL_HELP_HTML_BUTTON_FORM);

                	if (!$this->arrayDataTypeExport['html'])
                	$objMyForm->addDisabled('html_'.$this->idList);
                	else
                	$anyBut = true;

                	$objMyForm->addEvent('html_'.$this->idList,'onclick','MYLIST_exportData','html',$this->idList);

                	$htble .= '<td width="10%" align="left">'.$objMyForm->getButton('html_'.$this->idList,'','html.gif').'</td>';

                	if (!$anyBut)
                	$objMyForm->addDisabled('not_pg_'.$this->idList);

                	$htble .= '<td width="10%">&nbsp;</td>';

                	$htble .= '<td width="10%">&nbsp;</td>';

                	$htble .= '<td width="10%">&nbsp;</td>';

                	$objMyForm->addEvent('help_'.$this->idList,'onclick','MYLIST_help');

                	$objMyForm->addHelp('help_'.$this->idList, TITLE_WINDOW_HELP_MYLIST);

                	$htble .= '<td width="10%" align="right">'.$objMyForm->getButton('help_'.$this->idList,'','help.gif').'</td>';

                	$objMyForm->addHelp($this->idList.'_reload_list',LABEL_HELP_RELOAD_LIST_FORM);

                	$objMyForm->addEvent($this->idList.'_reload_list','onclick','MYLIST_reload',$this->idList);

                	$htble .= '<td width="10%" align="right">'.$objMyForm->getButton($this->idList.'_reload_list',NULL,'reload.gif').'</td>';

                	$objMyForm->addHelp($this->idList.'_apply_rule',LABEL_HELP_APPLY_RULE_FORM);

                	$objMyForm->addEvent($this->idList.'_apply_rule','onclick','MYLIST_applyRuleQuery',$this->idList);

                	$htble .= '<td width="10%" align="right">'.$objMyForm->getButton($this->idList.'_apply_rule',NULL,'ok.gif').'</td>';

                	$objMyForm->addHelp('add_rule_'.$this->idList,LABEL_HELP_ADD_RULE_QUERY_BUTTON_FORM);

                	$objMyForm->addEvent('add_rule_'.$this->idList,'onclick','MYLIST_addRuleQuery',$this->idList,$showFirstRule);

                	$htble .= '<td width="10%" align="right">'.$objMyForm->getButton('add_rule_'.$this->idList,'','find.gif').'</td>';

                	$htble .= '</tr></table>';

                	$objMyForm->addComment('options',$htble);

                	$htmFirstRule = '';

                	if ($showFirstRule)

                	$htmFirstRule = $this->getFirstRuleOnQueryForm();

                	$objMyForm->addComment('rule_for','<div class="form_rule_for_list" id="rule_for_'.$this->idList.'">'.$htmFirstRule.'</div>');

                	return $objMyForm->getForm(1);
                }

                private function getFirstRuleOnQueryForm (){

                	$html = '';

                	if (count($this->arrayAliasSetInQuery) && $this->numAffectedRows){

                		$arFields = array();

                		$objMyForm = new OPF_myForm($idForm = $this->idList.'QueryForm');

                		$objMyForm->cellPadding = 0;

                		$objMyForm->styleTypeHelp = 2;

                		$objMyForm->selectUseFirstValue = false;

                		$this->numRuleQuery += 1;

                		$html .= '<table border="0" id="rule_gp_'.$this->idList.'_'.$this->numRuleQuery.'" width="100%" cellpadding="0" cellspacing="0">';

                		$html .= '<tr>';

                		$html .= '<td width="10%" align="center"><div id="status_'.$this->idList.'_'.$this->numRuleQuery.'" class="rule_cancel" id=""></div></td>';

                		$objMyForm->addHelp('logic_'.$this->numRuleQuery,LABEL_LOGIC_FIELD_ADD_RULE_FORM);

                		$html .= '<td width="20%" align="center">'.$objMyForm->getHidden('logic_'.$this->numRuleQuery,'AND').'</td>';

                		foreach ($this->arrayFieldsOnQuery as $field){

                			if (!isset($this->arrayEventOnColumn[$field]) && isset($this->arrayAliasSetInQuery[$field])){

                				$etq = $field;

                				if (isset($this->arrayAliasSetInQuery[$field])){

                					$data = $this->arrayAliasSetInQuery[$field];

                				}else
                				$data = $field;

                				$arFields[$field] = $etq;
                			}
                		}

                		$objMyForm->addHelp('field_'.$this->numRuleQuery, LABEL_FIELD_LIST_ADD_RULE_FORM);

                		$html .= '<td width="20%" align="center">'.$objMyForm->getSelect('field_'.$this->numRuleQuery,$arFields).'</td>';

                		$spaCha = '&nbsp;';

                		$objMyForm->addEvent('relation_'.$this->numRuleQuery, 'onchange', 'MYLIST_caseSensitiveCheckBox','case_sensitive_'.$this->numRuleQuery, 'relation_'.$this->numRuleQuery);

                		$objMyForm->addHelp('relation_'.$this->numRuleQuery,LABEL_RELATION_FIELD_ADD_RULE_FORM);

                		$html .= '<td width="20%" align="center">'.$objMyForm->getSelect('relation_'.$this->numRuleQuery,$this->myDinamicListRel).'</td>';

                		$objMyForm->addHelp('value_'.$this->numRuleQuery,LABEL_FIELD_VALUE_ADD_RULE_FORM);

                		$objMyForm->addHelp('case_sensitive_'.$this->numRuleQuery,LABEL_CASE_SENSITIVE_LIST_ADD_RULE_FORM);

                		$html .= '<td width="20%" align="center"><table cellpadding="0" border="0" cellspacing="0"><tr><td>'.$objMyForm->getText('value_'.$this->numRuleQuery,NULL,12).'</td><td>'.$objMyForm->getCheckBox('case_sensitive_'.$this->numRuleQuery).'</td></tr></table></td>';

                		$objMyForm->addHelp($this->idList.'_remove_rule_'.$this->numRuleQuery,LABEL_HELP_REM_RULE_FORM);

                		$objMyForm->addEvent($this->idList.'_remove_rule_'.$this->numRuleQuery,'onclick','MYLIST_removeRuleQuery',$this->idList,$this->numRuleQuery);

                		$html .= '<td align="center">'.

                		$objMyForm->getButton($this->idList.'_remove_rule_'.$this->numRuleQuery,NULL,'remove.gif').

                        '</td>';

                		$html .= '</tr>';

                		$html .= '</table>';
                	}


                	return $html;
                }

                /**
                 * Retorna el valor de un atributo de la lista dinamica.
                 * @ignore
                 * @param $name Nombre de la variable
                 * @param $item Si se trata de un arreglo el nombre del indice
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
                 * @ignore
                 * @param $name Nombre de la variable
                 * @param $val  Nuevo valor
                 * @param $item Si te trata de un arreglo el nombre del indice
                 */
                public function setVar ($name, $val, $item = ''){

                	if ($item)
                	$_SESSION['prdLst'][$this->idList][$name][$item] = $val;
                	else
                	$_SESSION['prdLst'][$this->idList][$name] = $val;
                }

                /**
                 * Borra una variable de la lista
                 * @ignore
                 * @param $name Nombre de la variable
                 * @param $item Si se trata de un arreglo el nombre del indice
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
                 * Registros afectados.
                 *
                 * Retorna el numero de registros afectados por la anterior consulta.
                 * @return integer
                 */
                public function getNumRowsAffected(){

                	return $this->numAffectedRows;
                }

                /**
                 * Exito en el proceso.
                 *
                 * Indica si la lista se ejecuto correctamente o no.
                 * @return boolean
                 */
                public function isSuccessfulProcess (){

                	return $this->successFul;
                }

                /**
                 * Obtener HTML
                 *
                 * Obtiene el contenido de la lista dinámica como codigo HTML
                 * @param boolean $showQueryForm        Mostrar formulario de consulta
                 * @param boolean $showFirstRule        Mostrar primera regla a aplicar si el formulario de consulta se va a usar
                 * @return string
                 */
                public function getList ($showQueryForm = false, $showFirstRule = false){

                	$this->buildList($showQueryForm, $showFirstRule);

                	return $this->bufHtml;
                }


                /**
                 * Permite asignar un metodo de una clase a un campo especifico.
                 *
                 * Permite modificar el resultado de un campo pasandolo como parametro a un metodo dentro de una clase. El metodo no debe ser estatico.
                 * <code>
                 *
                 * <?php
                 *
                 * class myMethods {
                 *
                 * 		public function formatName ($last_name){
                 *
                 * 			return ucwords($last_name);
                 * 		}
                 *
                 * }
                 *
                 * $sql = 'SELECT id, name, last_name FROM table';
                 *
                 * $myList = new OPF_myList('list_1',$sql);
                 *
                 * $objClass = new myMethods;
                 *
                 * $myList->setExternalMethodOnColumn('last_name',$objClass'formatName');
                 *
                 * echo $myList->getList();
                 *
                 * ?>
                 *
                 * </code>
                 * @param unknown_type $alias
                 * @param unknown_type $objClass
                 * @param unknown_type $strNameMethod
                 */
                public function setExternalMethodOnColumn ($alias, $objClass, $strNameMethod){
                	 
                	$this->externalMethods[$alias] = array('objClass'=>$objClass, 'strNameMethod'=>$strNameMethod);
                }


}

?>