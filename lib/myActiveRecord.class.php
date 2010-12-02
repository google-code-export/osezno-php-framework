<?php
/**
 * myActiveRecord
 *
 * La clase myActiveRecord es la propuesta que da osezno framework
 * para acceder a las bases de datos de Postgres, MySql mediante
 * objetos del Lenguaje de programacion. Extendiendo la clase a subclases
 * que tengan la informacion de cada una de las tablas a las que se
 * quieran acceder.
 * 
 * @uses Acceso a bases de datos por medio de objetos de PHP
 * @package OSEZNO FRAMEWORK (2008-2011)
 * @version 0.1
 * @author Jose Ignacio Gutierrez Guzman jose.gutierrez@osezno-framework.org
 */
class myActiveRecord {

	/**
	 * Nombre de la base de datos a
	 * la cual debe conectarse
	 *
	 * @var string
	 */
	private $database;

	/**
	 * Nombre del motor de bases de
	 * datos que vamos a usar, puede
	 * usarse 'mysql' o 'postgres'
	 *
	 * @var string
	 */
	private $engine;

	/**
	 * Nombre del Servidor o Ip
	 * donde se encuentra el motor
	 * de la base de datos.
	 *
	 * @var string
	 */
	private $host;

	/**
	 * Nombre del usuario que
	 * permite el acceso a la
	 * base de datos para conexion.
	 *
	 * @var string
	 */
	private $user;

	/**
	 * Clave de acceso del usuario
	 * que permite la conexion a 
	 * la base de datos.
	 *
	 * @var string
	 */
	private $password;

	/**
	 * Puerto del motor de la Base de 
	 * datos que se usara para conectarse
	 * al motor de base de datos seleccionado.
	 * Puede usar 3306 para mysql o 5432 para postgresql
	 *
	 * @var integer
	 */
	private $port;

	/**
	 * Nombre de la tabla de la base de datos
	 * que actuamente se encuentra en uso para
	 * la transaccion.
	 *
	 * @var string
	 */
	private $table;

	/**
	 * Objeto de conexion a la base de datos
	 *
	 * @var resourse
	 */
	private $dbh;

	/**
	 * Comprueba el estado boleano de si
	 * la actual conexion esta abierta o
	 * cerrada.
	 * @var boolean
	 */
	private $successfulConnect = false;
	
	/**
	 * Numero entero de filas afectadas
	 * por la ultima consulta a la base
	 * de datos.
	 *
	 * @var integer
	 */
	private $num_rows = 0;

	/**
	 * Numero entero de campos afectados
	 * por la ultima consulta select a la
	 * base de datos.
	 *  
	 * @var intger
	 */
	private $num_cols = 0;
	
	/**
	 * Estructura de la tabla actual
	 *
	 * @var mixed
	 */
	private $tableStruct = array();

	/**
	 * Llaves primarias de cada tabla, segun hayan sido definidas o se definan automaticamente.
	 * 
	 * @var array
	 */
	private $tablePk = array ();
	
	/**
	 * Por tabla el id de la secuencia
	 * 
	 * @var array
	 */
	private $tableIdSeq = array ();
	
	/**
	 * Alias de campos de la tabla
	 *
	 * @var unknown_type
	 */
	private $classVars;

	/**
	 * LLave de la tabla que se
	 * esta buscando
	 *
	 * @var unknown_type
	 */
	private $keyFinded;

	/**
	 * Usuales relaciones
	 * que en una consulta
	 * o en una busqueda pueda
	 * tener
	 *
	 * @var unknown_type
	 */
	private $arrayStringRelation = array (
		'<>','<=','>=', '!=','>', '<','=', '!'
	);
	
	/**
	 * Contiene el valor ultimo 
	 * id insertado en determinada
	 * tabla cuando es llamado el
	 * metodo save
	 *
	 * @var unknown_type
	 */
	private $lastInserId;


	/**
	 * Posfijo del nombre de las
	 * secuencias que se unas en postgres
	 *
	 * @var unknown_type
	 */
	private $posFijSeq = '_seq';

	
	/**
	 * Decide si se coloca o no auto comillas sencillas en
	 * las consulta hechas con el metodo find
	 * 
	 * @var unknown_type
	 */
	private $autoQuoteOnFind = true;
	
	/**
	 * Atributos que no son reconocibles para los metodos
	 * que intervienen en las tablas.
	 * @var array
	 */
	private $arrayInvalidAtt = array (
		'database', 'engine', 'host', 'user', 'password', 'port', 'table', 'posFijSeq', 'num_rows', 'num_cols',
		'dbh', 'successfulConnect', 'tableStruct', 'classVars', 'keyFinded', 'arrayStringRelation', 'lastInserId',
		'arrayInvalidAtt'	
	);
	
	/**
	 * Operaciones no Query
	 * 
	 * @var array
	 */
	private $arrayCrud = array (
		'insert',
		'update',
		'delete'
	);

	/**
	 * Intancia a un nuevo objeto
	 * 
	 * @param $database	Base de datos
	 * @param $user	Usuario
	 * @param $password	Clave de usuario
	 * @param $host	Host de DB
	 * @param $engine	Motor de DB
	 * @param $port	Puerto logico
	 */
	public function __construct($database = '', $user = '', $password = '', $host = '', $engine = '', $port = ''){

		$arrayConecction = array (
			'database'=>$database,
			'engine'=>$engine,
			'host'=>$host,
			'user'=>$user,
			'password'=>$password,
			'port'=>$port
		);
		
		$this->setParams($arrayConecction);
		
		if (!isset($GLOBALS['OF_SQL_LOG'])){
			global $OF_SQL_LOG, $OF_SQL_LOG_ERROR, $OF_IN_TRANSACCTION;
			
			$GLOBALS['OF_IN_TRANSACCTION'] = false;
		}
		
		$this->openConecction();

		if (strcmp($this->table = get_class($this),'myActiveRecord')){
			$this->classVars = get_class_vars($this->table);
			
			if (!isset($this->tablePk[$this->table]))
			   $this->getPkFromTable($this->table);
		}
			
	}

	/**
	 * Destructor de la clase
	 *
	 */
	public function __destruct(){
			
		//$this->closeConecction();
	}

	/**
	 * Setear la base de datos que se va a usar
	 *
	 * @param string $newDatabase
	 */
	private  function setDatabase ($newDatabase){
			
		$this->database = $newDatabase;
	}

	/**
	 * Setear el motor de bases de datos que se va a usar
	 *
	 * @param string $newEngine
	 */
	private function setEngine ($newEngine){
			
		$this->engine = $newEngine;
	}

	/**
	 * Setear el nombre del host o su ip para
	 * conectarse a su motor de base de datos
	 *
	 * @param string $newHost
	 */
	private function setHost ($newHost){
			
		$this->host = $newHost;
	}

	/**
	 * Setear el nombre de usuario que se usara
	 * para conectarse a la base de datos
	 *
	 * @param string $newUser
	 */
	private function setUser ($newUser){
			
		$this->user = $newUser;
	}

	/**
	 * Setear la clave de acceso que usara
	 * el usuario que tendra acceso a la base
	 * de datos.
	 *
	 * @param string $newPassword
	 */
	private function setPassword ($newPassword){
			
		$this->password = $newPassword;
	}

	/**
	 * Setear el puerto que se usara
	 * para conectarse a la base de datos
	 * sobre el motor
	 *
	 * @param integer $newPort
	 */
	private function setPort ($newPort){
			
		$this->port = $newPort;
	}

	/**
	 * Setear varios parametros al mismo tiempo
	 * Los parametros se setean mediante un arreglo
	 * que tenga las siguientes llaves (Todas o algunas).
	 *
	 * database, engine, host, user, password, port
	 * 
	 * @param mixed $arrayParams
	 */
	private function setParams ($arrayParams){
		if ($arrayParams['database'])
		   $this->setDatabase($arrayParams['database']);
		else   
		   $this->setDatabase($GLOBALS['MYACTIVERECORD_PARAMS']['database']);

		if ($arrayParams['engine'])
		   $this->setEngine($arrayParams['engine']);
		else{   
		   $this->setEngine($GLOBALS['MYACTIVERECORD_PARAMS']['engine']);
		}

		if ($arrayParams['host'])
		   $this->setHost($arrayParams['host']);
		else
		   $this->setHost($GLOBALS['MYACTIVERECORD_PARAMS']['host']);   

		if ($arrayParams['user'])
		   $this->setUser($arrayParams['user']);
		else   
		   $this->setUser($GLOBALS['MYACTIVERECORD_PARAMS']['user']);

		if ($arrayParams['password'])
		   $this->setPassword($arrayParams['password']);
		else
		   $this->setPassword($GLOBALS['MYACTIVERECORD_PARAMS']['password']);   

		if ($arrayParams['port'])
		   $this->setPort($arrayParams['port']);
		else   
		   $this->setPort($GLOBALS['MYACTIVERECORD_PARAMS']['port']);
	}

	/**
	 * Valida un atributo de la tabla 
	 * 
	 * @param $field
	 * @return unknown_type
	 */
	private function validateAtt ($field){
		
		$valid = false;
		
		if (strcmp($field,$this->tablePk[$this->table]))

		if (!is_null($this->$field))
					
 		if (!is_array($this->$field))
							
		if (!is_object($this->$field))
								
		if (!is_bool($this->$field))
									
		if (!in_array($field,$this->arrayInvalidAtt))
										
		if (strlen(trim($this->$field)))
											
			$valid = true;

		return $valid;
	}
		
	/**
	 * Setea el valor de lastIserId, con el parametro del nombre de la secuencia si aplica
	 *  
	 * @return integer
	 */
	private function get_LastInsertId (){
		
		$idSeq = '';
		if (isset($this->tableIdSeq[$this->table]))
			$idSeq = $this->tableIdSeq[$this->table];
		
		return $this->dbh->lastInsertId($idSeq);	
	}
	/**
	 * Arma una consulta Sql con los parametros asignados
	 * 
	 * @param $strCond
	 * @param $orderBy
	 * @param $orderMethod
	 * @param $intLimit
	 * @param $offset
	 * @return unknown_type
	 */
	
	private function findEngine ($strCond = '', $orderBy = '', $orderMethod = '', $intLimit = 0, $offset = 0){
		
		$fCnd = '';
		
		$sql = '';
		
		$subSqlF = '';
		$iCounter = 1;
		
		$countFields = count($this->classVars);

		foreach ($this->classVars as $var => $val){
			if (!in_array($var,$this->arrayInvalidAtt)){
				$subSqlF .= $var;

				if ($iCounter<$countFields)
			   		$subSqlF .= ', ';

				$iCounter++;
			}
		}
		
		$sql .= 'SELECT '.$subSqlF.' FROM '.$this->table;
		
		$results = '';
		
		# Condicion compuesta, condicion sencilla
		if ( $this->evalIfIsQuery($strCond) || !$strCond){
			
			$iCounter = 1;

			if ($strCond)
			   $sql .= ' WHERE ';

			$cCond = count($strCond = explode(
					'&',$strCond));
			
			foreach ($strCond as $cnd){
				
				# TODO: Evaluar si viene una sentencia booleana
				$smblRel = $this->evalSimbolInSubQuery($cnd,true);
				
				if ($smblRel)
					list ($fCnd, $vCnd) = explode($smblRel,$cnd);
				
				if (trim($fCnd) && $vCnd){

					if ($this->autoQuoteOnFind){
						if (is_numeric(trim($vCnd))){
							$sql .= $fCnd.$smblRel.
							' '.trim($vCnd);

						}else{
							$sql .= $fCnd.$smblRel.
							" '".trim($vCnd)."'";
						}
					}else{
						$sql .= $fCnd.$smblRel.
							' '.trim($vCnd).'';
					}

				}else{
					$sql .= ' '.trim($cnd);
				}
					
				if ($iCounter<$cCond)
				   $sql .= ' AND';
					
				$iCounter ++;
			}
			
			if ($orderBy){
				
				if (is_bool($orderBy)){
					
					$sql .= ' ORDER BY '.$this->tablePk[$this->table].' ';
					
				}else{
					
					if (is_array($orderBy)){
						
						if (count($orderBy)){
							
							$sqlOrderBy = '';
							
							$cute = false;
							foreach ($orderBy as $field => $method){
							
								if ($method){
									$sqlOrderBy .= ' '.$field.' '.$method.', ';
									$cute = true;
								}	
							}
						
							if ($cute){
								$sql .= ' ORDER BY '.substr($sqlOrderBy,0,-2);	
							}
							
						}
						
					}else{
						
						$sql .= ' ORDER BY '.$orderBy;
						
						if ($orderMethod)
				   			$sql .= ' '.$orderMethod;
					}
				}
			}
			
			if ($intLimit){
				
				$sql .= ' LIMIT '.$intLimit.'';
				
				if ($offset){
				
					$sql .= ' OFFSET '.$offset.'';
				}
					
			}
			
			$rF = $this->query($sql);
			
			if ($this->num_rows == 1){
				
				foreach ($rF as $row)
					foreach ($row as $etq => $value){
						$this->$etq = $value;
					}
					
			}else{
				//TODO:

			}
				
		}else{

			if ($strCond){
				if ($this->autoQuoteOnFind){
					if (is_string($strCond))
						$strCond = '\''.$strCond.'\'';
				}
				
				$sql .= ' WHERE '.$this->tablePk[$this->table].' = '.$strCond;
			}
			
			$rF = $this->query($sql);

			if ($this->num_rows){

				$this->keyFinded = $strCond;
				$rF = $rF[0];
				
				foreach ($rF as $etq => $val){
					
					if (is_string($etq)){
						if (!in_array($etq,$this->arrayInvalidAtt)){
							$this->$etq = $val;
						}
					}
				}
			}
		}
						
		return $rF;
	}
			
	/**
	 * Evalua si una condicion pertenece a una consulta sql
	 *
	 * @param unknown_type $strCond
	 * @return unknown
	 */
	private function evalIfIsQuery ($strCond){
			
		$return = false;
			
		foreach($this->arrayStringRelation as $rel){

			if (strripos($strCond,$rel)!==false){
					
				$return = true;
				
				break;
			}
		}
			
		return $return;
	}
	
	/**
	 * Construye el resultado de la consulta sql
	 * 
	 * @param $rF Fila
	 * @return object
	 */
	private function buildRes($rF){
		
		$cloThis = clone $this;
		
		if(is_array($rF)){
			
			foreach($rF as $name => $value){
				
				if (!is_numeric($name)){
					
					$cloThis->$name = $value;
				}
			}
		}
		
		return $cloThis;
	}
	
	/**
	 * Obtiene los campos de una tabla definida para esa tabla
	 * 
	 * @param $table
	 * @return unknown_type
	 */
	private function getStringSqlFields ($table){
			
		$subSqlF = '';
		$iCounter = 1;
		
		$countFields = count($fields = $this->tableStruct[$table]['fields']);

		foreach ($fields as $field => $value){
			
			$subSqlF .= $field;

			if ($iCounter<$countFields)
			   $subSqlF .= ', ';

			$iCounter++;
		}
			
		return $subSqlF;
	}
	
	/**
	 * Evalua la condicion que exite un operador de relacion en find o delete
	 * 
	 * @param $strCond
	 * @param $returnSimbol
	 * @return unknown_type
	 */
	private function evalSimbolInSubQuery ($strCond, $returnSimbol = false){
			
		$true = false;
			
		foreach ($this->arrayStringRelation as $Relation){
			
			if (strpos($strCond,$Relation)!==false){
				
				if (!$returnSimbol)
				   $true = true;
				else
				   $true = $Relation;
				break;
			}
		}

		return $true;
	}
	
	/**
	 * Obtiene la llave primaria de uan tabla basado en la palabra 'id', busca el primer campo de esa tabla
	 * que tenga la palabra solo 'id' o la primera que contenga 'id'
	 * 
	 * @param $tableName
	 */
	private function getPkFromTable ($tableName){

		$pk = '';

		foreach ($this->classVars as $var => $val){
			
			if (!strcmp(strtolower($var),'id')){
				if (!$pk)
	   				$pk = $var;
			}else{

				if (strripos($var,'id')!==false){
					if (!$pk)
			   			$pk = $var;
				}
			}
							
			if ($pk){
		   		$this->tablePk[$tableName] = $pk;
		   		break;
			}
			
		}
		
	}	
	
	/**
	 * Setea el posfijo que en postgres se usa para
	 * llamar a una secuencia en especifico
	 *
	 * @param string $posFij
	 */
	public function setPosfijSeq ($posFij = ''){
			
		$this->posFijSeq = $posFij;
	}
		
	/**
	 * Setea el nombre de la secuencia para que despues de un save pueda ser obtenido su valor
	 * 
	 * @param $name	Nombre secuencia
	 */
	public function setSeqName($name){
		if ($name)
			$this->tableIdSeq[$this->table] = $name;		
	}
	
	/**
	 * Setear comillas automatica en el metodo find
	 * 
	 * @param $value
	 * @return unknown_type
	 */
	public function setAutoQuotesInFind ($value){
		
		$this->autoQuoteOnFind = $value;
	}
	
	/**
	 * Obtener el valor del nombre
	 * de la base de datos actual
	 * para conectarse.
	 *
	 * @return string
	 */
	public function getDatabase (){
			
		return $this->database;
	}

	/**
	 * Obtener el valor del nombre
	 * del motor de la base de datos 
	 * actualmente en uso
	 *
	 * @return string
	 */
	public function getEngine (){
			
		return $this->engine;
	}

	/**
	 * Obtener el valor del nombre
	 * del servidor o su ip, al
	 * cual se esta conectado en
	 * este momento
	 *
	 * @return string
	 */
	public function getHost (){
			
		return $this->host;
	}

	/**
	 * Obtener el valor del nombre
	 * del usuario que en este momento
	 * se encuentra conectado a la
	 * base de datos.
	 *
	 * @return string
	 */
	public function getUser (){
			
		return $this->user;
	}

	/**
	 * Obtener el valor de la clave
	 * actual que en este momento
	 * esta siendo usada por el 
	 * usuario para conectarse a
	 * la base de datos.
	 *
	 * @return string
	 */
	public function getPassword (){
			
		return $this->password;
	}

	/**
	 * Obtener el valor del puerto
	 * actual que en este momento
	 * se utiliza para conectarse
	 * al motor de la base de datos
	 * via TCP/IP
	 *
	 * @return integer
	 */
	public function getPort (){
			
		return $this->port;
	}
	
	/**
	 * Obtiene un registro de las
	 * consulta echas al motor de
	 * la base de datos. Incluso en
	 * una transaccion.
	 *
	 * @return string
	 */
	public function getSqlLog (){
			
		return $GLOBALS['OF_SQL_LOG'];
	}

	/**
	 * Obtiene una cadena con el
	 * utimo error en una transaccion
	 * o consulta sql a la base de datos.
	 * 
	 * @param $HTMLformat	Aplicar formato html a la salida de errores true/false
	 * @return string
	 */
	public function getErrorLog ($HTMLformat = false){

		$error = '';
		
		if (trim($GLOBALS['OF_SQL_LOG_ERROR'])){
			if ($HTMLformat)
				$error = '<div class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.$GLOBALS['OF_SQL_LOG'].'<br><div class="error_detail"><b>'.ERROR_DET_LABEL.'</b>:&nbsp;'.$GLOBALS['OF_SQL_LOG_ERROR'].'</div></div>';
			else 
				$error = trim($GLOBALS['OF_SQL_LOG_ERROR']);
		}
			
		return $error;
	}

	/**
	 * Obtiene el numero de registros afectados
	 * por la utima consulta, insercion, actualizacion
	 * o eliminacion de registros.
	 * 
	 *
	 * @return integer
	 */
	public function getNumRowsAffected (){
			
		return $this->num_rows;
	}
	
	/**
	 * Obtiene el numero de campos afectados
	 * por la ultima consulta.
	 * 
	 * @return integer
	 */
	public function getNumFieldsAffected (){
		
		return $this->num_cols;
	}
	

	/**
	 * Obtiene el valor del indice
	 * o llave primaria siempre y cuando
	 * este sea un campo autoincrmentable 
	 * o serial del ultimo registro insertado
	 * en una tabla
	 *
	 * @return integer
	 */
	public function getLastInsertId (){
			
		return $this->lastInserId;
	}
	
	/**
	 * Obtiene el valor de un atributo
	 * 
	 * @param $att Nombre
	 * @return string
	 */
	public function getAtt ($att){
		
		return $this->$att;
	}
	
	/**
	 * Inicia una transaccion
	 */
	public function beginTransaction (){
		
		if (!$GLOBALS['OF_IN_TRANSACCTION']){
			
			$GLOBALS['OF_SQL_LOG'] .= 'BEGIN TRANSACTION;'."\n";
		
			$GLOBALS['OF_IN_TRANSACCTION'] = true;
		}
		
	}

	/**
	 * Finaliza una transaccion
	 *  
	 * @return boolean
	 */
	public function endTransaction (){
		
		$sucsess = true;
		
		if ($GLOBALS['OF_IN_TRANSACCTION']){
			
			$this->dbh->beginTransaction();
				
			if (!$this->getErrorLog()){
			
				$GLOBALS['OF_SQL_LOG'] .='COMMIT;'."\n";
				
				$this->dbh->commit();
			
			}else{
			
				$GLOBALS['OF_SQL_LOG'] .='ROLLBACK;'."\n";
				
				$this->dbh->rollBack();
			}
			
			$GLOBALS['OF_IN_TRANSACCTION'] = false;
		}
		
		return $sucsess;
	}
	

	/**
	 * Carga una consulta sql desde un archivo fisico
	 * 
	 * @param $file	Ruta del archivo fisico
	 * @param $vars	Arreglo de variables a reemplazar
	 * @return string
	 */
	public function loadSqlFromFile ($file, $vars = array()){

		$link = fopen($file,'r');
		
  		$sql = fread($link, filesize($file));
  		
  		fclose($link);
  		
  		foreach ($vars as $var => $val){
  			
  			unset($vars[$var]);
  			
  			$vars['{'.$var.'}'] = $val;
  		}
		
  		$keys = array_keys($vars);
  		
  		$sql = str_ireplace ( $keys, $vars, $sql);
  		
  		return $sql;
	}
	

	/**
	 * Ejecuta una consulta SQL
	 * Devuelve un arreglo con el resultado de la consulta
	 * 
	 *
	 * @param string $sql
	 */
	public function query ($sql, $saveInLog = true){
		
		$eError = array ();
		
		if ($saveInLog)
			$GLOBALS['OF_SQL_LOG'] .= $sql.' '."\n";
			
		$isrW = false;
			
		foreach ($this->arrayCrud as $rW){
			
			$pos = stripos($sql, $rW);
			
			if ($pos === false){
				
			}else{
				$isrW = true;
				break;
			}
		}
		
		if ($isrW){
			
			# Establecer nombre de secuencia automaticamente en Pgsql
			if (!isset($this->tableIdSeq[$this->table]))
				if ($this->getEngine()=='pgsql')
					$this->tableIdSeq[$this->table] = $this->table.'_'.$this->tablePk[$this->table].$this->posFijSeq;			
			
			$this->num_rows = $this->dbh->exec($sql);
				
			$eError = $this->dbh->errorInfo();
				
			if (isset($eError[2])){
					
				$GLOBALS['OF_SQL_LOG_ERROR'] .= $eError[2]."\n";
			}
			
			return $this->num_rows;
			
		}else{
			
			# Select / No se afectan en transacciones
			$array = array();
			$resQuery = $this->dbh->query($sql);
		
			if (!$resQuery){
				
				$eError = $this->dbh->errorInfo();
				
				$GLOBALS['OF_SQL_LOG_ERROR'] .= $eError[2]."\n";
				
			}else{

				$this->num_cols = $resQuery->columnCount(); 
				$this->num_rows = 0;

				foreach ($resQuery as $row){
					$array[] = $this->buildRes($row);
					$this->num_rows++;	
				}	
				
			}
		
			return $array;
		}
		
	}

	/**
	 * Trata de encontrar registros de una
	 * tabla en la base de datos en uso que
	 * cumplan con determinadas condiciones
	 * segun campos de la tabla.
	 *
	 * @param string $strCond
	 * @param string $orderBy
	 * @param string $orderMethod
	 * @param integer $intLimit
	 * @param integer $offSet
	 * @return object
	 */
	public function find($strCond = '', $orderBy = '', $orderMethod = '', $intLimit = '', $offSet = ''){

		return $this->findEngine($strCond, $orderBy, $orderMethod, $intLimit, $offSet);
	}

	/**
	 * Inserta o Modifica los datos de
	 * un registro.
	 *
	 * @return boolean
	 */
	public function save (){
		
		$sql = '';
		
		$sqlValues = '';
			
		// Update
		if ($this->keyFinded){

			$sql .= 'UPDATE '.$this->table.' SET ';

			foreach ($this->classVars as $field => $value){
				
				if ($this->validateAtt($field)){
					
					$sql.=$field.' = ';

					if (is_numeric($this->$field)){
							
						$sql .= $this->$field.', ';
												
					}else{
												
						if (!strcmp( trim( strtoupper($this->$field)),'NULL'))
							$sql .= 'NULL, ';
						else
							$sql .= '\''.addslashes($this->$field).'\', ';
					}
				
				}
				
			}

			$sql = substr($sql,0,-2).' WHERE '.$this->tablePk[$this->table].' = '.$this->keyFinded;

			$this->query($sql);
			
		// Insert
		}else{
			
			$sql .= 'INSERT INTO '.$this->table.' (';

			foreach ($this->classVars as $field => $value){
				
				if ($this->validateAtt($field)){
				
					$sql.=$field.', ';

					if (is_numeric($this->$field)){
							
						$sqlValues .= $this->$field.', ';
					}else{
							
						$sqlValues .= '\''.addslashes($this->$field).'\', ';
					}
						
				}
			}									
			
			$sql = substr($sql,0,-2).') VALUES ('.substr($sqlValues,0,-2).')';

			$this->query($sql);
			
			$this->lastInserId = $this->get_LastInsertId();
		}
		
		return $this->getNumRowsAffected();
	}

	/**
	 * Trata de borrar registros de una
	 * tabla si ellos cumplen con unas
	 * condiciones.
	 *
	 * @param string $strCond
	 * @return integer
	 */
	public function delete ($strCond){
		
		$sql = '';	
		
		if ($strCond){
			
			$sql .= 'DELETE FROM '.$this->table.'';

			$iCounter = 1;

			if ($this->evalIfIsQuery($strCond)){
					
				$sql .= ' WHERE ';
					
				$cCond = count($strCond = explode(
							'&',$strCond));
					
				foreach ($strCond as $cnd){
						
					# TODO: Evaluar si viene una sentencia booleana
					list ($fCnd, $vCnd) = explode(	$smblRel = $this->evalSimbolInSubQuery(	$cnd,true),$cnd);

					if (trim($fCnd) && $vCnd){
							
						if (is_numeric(trim($vCnd))){
							$sql .= $fCnd.$smblRel.' '.trim($vCnd);

						}else{
							$sql .= $fCnd.$smblRel." '".trim($vCnd)."'";
						}

					}else{
						$sql .= ' '.trim($cnd);
					}
						
					if ($iCounter<$cCond)
					$sql .= ' AND';
						
					$iCounter ++;
				}
				
			}else{
				if (is_string($strCond))
					$strCond = '\''.$strCond.'\'';

				$sql .= ' WHERE '.$this->tablePk[$this->table].' = '.$strCond;
			}

			$this->query($sql);
		}
		
		return $this->getNumRowsAffected();
	}

	/**
	 * Alias de setPrimaryKey
	 * 
	 * @param $field Campo Pk
	 */
	public function setPk($field){

		$this->setPrimaryKey($field);
		
	}

	/**
	 * Configura una llave primaria para la tabla, si no se suministra se calculara automaticamente.
	 * 
	 * @param $field	Campo Pk
	 */
	public function setPrimaryKey($field){
		
		$this->tablePk[$this->table] = $field;
		
	}

	/**
	 * Abre la conexion a la base de datos
	 *
	 * @return resorce
	 */
	private function openConecction (){
		
		$dsn = $this->engine.
				':dbname='.$this->database.
				';host='.$this->host;
		
		$user = $this->user;
		
		$password = $this->password;
				
		try {
    		$this->dbh = new PDO($dsn, $user, $password);
    		
    		//$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		
    		$this->successfulConnect = true;
    		
		} catch (PDOException $e) {
			
			$GLOBALS['OF_SQL_LOG'] .= 'Connect to '.$this->engine;
			
    		$GLOBALS['OF_SQL_LOG_ERROR'].= ''.$e->getMessage();
    			
		}
		
	}

	/**
	 * Cierra la conexion a la base de datos
	 *
	 */
	private function closeConecction (){
			

	}

	/**
	 * Despues de intentar abrir una conexion en el constructor
	 * verifica si esta se pudo abrir o no.
	 * @return boolean
	 */
	public function isSuccessfulConnect (){
		return $this->successfulConnect;
	}
	
}
?>