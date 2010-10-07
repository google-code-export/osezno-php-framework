<?php
/**
 * myActiveRecord
 *
 * @uses Acceso a bases de datos
 * @package OSEZNO FRAMEWORK
 * @version 0.1
 * @author joselitohaCker
 *
 * La clase myActiveRecord es la propuesta que da osezno framework
 * para acceder a las bases de datos de Postgres, MySql mediante
 * objetos del Lenguaje de programacion. Extendiendo la clase a subclases
 * que tengan la informacion de cada una de las tablas a las que se
 * quieran acceder.
 *
 */
class myActiveRecord {

	/****************************/
	/* Variables tipo parametro */
	/****************************/

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
	
	/*********************/
	/* Variables comunes */
	/*********************/


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
	

	/*********************/
	/* Variables de obra */
	/*********************/

	/**
	 * Estructura de la tabla actual
	 *
	 * @var mixed
	 */
	private $tableStruct = array();

	
	public function getAtt ($att){
		
		return $this->$att;
	}

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
	 * @var unknown_type
	 */
	private $arrayInvalidAtt = array (
		'database', 'engine', 'host', 'user', 'password', 'port', 'table', 'posFijSeq', 'num_rows', 'num_cols',
		'dbh', 'successfulConnect', 'tableStruct', 'classVars', 'keyFinded', 'arrayStringRelation', 'lastInserId',
		'arrayInvalidAtt'	
	);
	
	
	private $arrayCrud = array (
		'insert',
		'update',
		'delete'
	);
	
	/*******************/
	/* Metodos magicos */
	/*******************/

	
	/**
	 * Constructor de la clase
	 *
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
			global $OF_SQL_LOG, $OF_SQL_LOG_ERROR;
		}
			
		$this->openConecction();
			
		if (strcmp($this->table = get_class($this),'myActiveRecord')){
			
			if (!isset($this->tableStruct[$this->table])){
				
			   $this->getMetaDataTable($this->table);
			}
		}
			
		$this->classVars = get_class_vars($this->table);
			
	}

	/**
	 * Destructor de la clase
	 *
	 */
	public function __destruct(){
			
		//$this->closeConecction();
	}

	/**************/
	/* Seteadores */
	/**************/

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
	 * Setea el posfijo que en postgres se usa para
	 * llamar a una secuencia en especifico
	 *
	 * @param string $posFij
	 */
	public function setPosfijSeq ($posFij = ''){
			
		$this->posFijSeq = $posFij;
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
	
	/*
	 * Obtenedores
	 */
	
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
	 * @return string
	 */
	public function getErrorLog (){
			
		return trim($GLOBALS['OF_SQL_LOG_ERROR']);
	}

	/**
	 * Obtiene el numero de filas afectadas
	 * por la utima consulta, insercion, actualizacion
	 * o eliminacion de registros.
	 * 
	 *
	 * @return integer
	 */
	public function getAffectedRows (){
			
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

	/*****************/
	/* Transacciones */
	/*****************/

	/**
	 * Inicia una transaccion
	 * en el motor de base de datos
	 *
	 */
	public function beginTransaction (){
			
		
		switch ($this->engine){
			case 'mysql':
				//$sql = "START TRANSACTION;";
				
				
				
				break;
			case 'pgsql':
				//$sql = "BEGIN TRANSACTION;";
				break;
		}
			
		//$this->exec($sql);
		
		//echo $this->dbh->getAttribute(PDO::ATTR_AUTOCOMMIT);
		
		
		$this->dbh->beginTransaction();
		
		$this->dbh->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
	}

	public function commit (){
		/*	
		$sql = "COMMIT;";
		$this->exec($sql);
		*/

		$this->dbh->commit();
	}
	
	
	public function rollBack (){
		/*
		$sql = "ROLLBACK";
		$this->exec($sql);
		*/

		$this->dbh->rollBack();
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
			# Update, Delete, Insert
			echo 'aqui'.'<br>';
			
			$this->num_rows = $this->dbh->exec($sql);
				
			$eError = $this->dbh->errorInfo();
			if (isset($eError[2])){
				$GLOBALS['OF_SQL_LOG_ERROR'] .= $eError[2]."\n";
			}
			
			return $this->num_rows;
			
		}else{
			# Select 
			
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

	public function exec ($sql){
		
		$this->dbh->exec($sql);
		
	}
	
	
	/********************/
	/* Funciones Active */
	/********************/

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

		return $this->findOperator($strCond, $orderBy, $orderMethod, $intLimit, $offSet);
	}


	/**
	 * Trata en indagar en una tabla
	 * si un reggistro o N registro
	 * con determinadas condiciones
	 * existe.
	 *
	 * @param string $strCond
	 * @return boolean
	 */
	public function exists ($strCond){
			
		$exists = false;
			
		if ($this->evalIfIsQuery($strCond)){
			//-> Find all

			$sql .= 'SELECT * FROM '.$this->table.' ';
			$iCounter = 1;

			if ($strCond)
			$sql .= 'WHERE ';

			$cCond = count($strCond = explode(
					'&',$strCond));

			foreach ($strCond as $cnd){

				# TODO: Evaluar si viene una sentencia booleana
				list ($fCnd, $vCnd) = explode(
				$smblRel = $this->evalSimbolInSubQuery(
				$cnd,true),$cnd);
					
				if (trim($fCnd) && $vCnd){
						
					if (is_numeric(trim($vCnd))){
						$sql .= $fCnd.$smblRel.
						' '.trim($vCnd);

					}else{
						$sql .= $fCnd.$smblRel.
						" '".trim($vCnd)."'";
					}

				}else{
					$sql .= ' '.trim($cnd);
				}
					
				if ($iCounter<$cCond)
				   $sql .= ' AND';
					
				$iCounter ++;
			}

			$this->query($sql);

			if ($this->num_rows){
				$exists = true;
			}

		}else{

			if (is_string($strCond))
			   $strCond = '\''.$strCond.'\'';

			$sql .= 'SELECT * FROM '.$this->table
			.' WHERE '.$this->tableStruct[$this->table]['pk']
			.' = '.$strCond;

			$rF = $this->query($sql);

			if ($this->num_rows){
				$exists = true;
			}

		}

		return $exists;
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
			
		// Se va a actualizar un registro
		if ($this->keyFinded){

			$sql .= 'UPDATE '.$this->table.' SET ';

			foreach ($this->classVars as $field => $value){

				// Para no tocar la llave primaria
				if (strcmp($field,$this->tableStruct[$this->table]['pk'])){
					// No tenemos en cuenta los atributos que no fueron definidos
					if (!is_null($this->$field)){
						// Queremos verificar las cadenas por eso los arreglos son excluidos
						if (!is_array($this->$field)){
							// Queremos verificar las cadenas por eso los objetos son excluidos
							if (!is_object($this->$field)){
								if (!is_bool($this->$field)){
									if (!in_array($field,$this->arrayInvalidAtt)){
										// No tenemos en cuenta los atributos que no fueron seteados
										if (strlen(trim($this->$field))){
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
								}
							}
						}
					}
				}
				
				
			}

			$sql = substr($sql,0,-2).' WHERE '
			.$this->tableStruct[$this->table]['pk']
			.' = '.$this->keyFinded;

			//echo 'Registro encontrado';
			
			$this->query($sql);
			
			// Se va a agregar un registro
		}else{
			$sql .= 'INSERT INTO '.$this->table.' (';

			foreach ($this->classVars as $field => $value){

				// Para no tocar la llave primaria
				if (strcmp($field,$this->tableStruct[$this->table]['pk'])){

					// No tenemos en cuenta los atributos que no fueron definidos
					if (!is_null($this->$field)){
						
						// Queremos verificar las cadenas por eso los arreglos son excluidos
						if (!is_array($this->$field)){

							// Queremos verificar las cadenas por eso los objetos son excluidos
							if (!is_object($this->$field)){

								if (!is_bool($this->$field)){
								
									if (!in_array($field,$this->arrayInvalidAtt)){

										// No tenemos en cuenta los atributos que no fueron seteados
										if (strlen(trim($this->$field))){

											$sql.=$field.', ';

											if (is_numeric($this->$field)){
							
												$sqlValues .= $this->$field.', ';
											}else{
							
							   					$sqlValues .= '\''.addslashes($this->$field).'\', ';
											}						
										}
									}
								}
							}
						}
					}
				}
			}
			
			$sql = substr($sql,0,-2).') VALUES ('.substr($sqlValues,0,-2).')';

			$this->query($sql);
			
			$this->lastInserId = $this->dbh->lastInsertId();
		}
		
		return $this->getAffectedRows();
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

				$sql .= ' WHERE '.$this->tableStruct[$this->table]['pk'].' = '.$strCond;
			}

			$this->query($sql);
		}
		
		return $this->getAffectedRows();
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
	 * 
	 * @param $strCond
	 * @param $orderBy
	 * @param $orderMethod
	 * @param $intLimit
	 * @param $offset
	 * @return unknown_type
	 */
	private function findOperator ($strCond = '', $orderBy = '', $orderMethod = '', $intLimit = 0, $offset = 0){
		
		$fCnd = '';
		
		$sql = '';
		
		$subSqlF = $this->getStringSqlFields($this->table);
		
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
					
					$sql .= ' ORDER BY '.$this->tableStruct[$this->table]['pk'].' ';
					
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
				
				$sql .= ' WHERE '.$this->tableStruct[$this->table]['pk'].' = '.$strCond;
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



	private function getMetaDataTable ($tableName){

		$mTable = array ();
		$this->tableStruct[$tableName] = array();

		$pk = '';
		$ff = '';
			
		$resQuery = $this->dbh->query($sql = 'SELECT * FROM '.$tableName.' LIMIT 1');
		
		switch ($this->engine){
			
			case 'mysql':
			
				/**
			 	 * TODO: Obtener solo la primera llave primaria
			 	 * Probar en mysql que obtenga la primera llave
			     * primaria encontrada. 
			     */
				foreach ($resQuery as  $res){
					$i=0;
					foreach ($res as $key => $value){
						
						$mTable = $resQuery->getColumnMeta($i);
					
						if ($mTable['name']){
							
							if (!$ff)
					   			$ff = $mTable['name'];
					   
							$this->tableStruct[$tableName]['fields'][$mTable['name']] = '';   
					
							$this->tableStruct[$tableName]['types'][$mTable['name']] = $mTable['native_type'].' '.$mTable['flags'][0];
					
							if ($mTable['flags'][0]=='primary_key'){
								$pk = $mTable['name'];
							}else{
							
								if (!strcmp(strtolower($mTable['name']),'id')){
									if (!$pk)
							   		$pk = $mTable['name'];
								}else{

									if (strripos($mTable['name'],'id')!==false){
										if (!$pk)
								   		$pk = $mTable['name'];
									}
								}
							}							
						}
					
						$i+=1;
					}
					break;
				}
					
			break;
			case 'pgsql':
				/**
				 * TODO: Obtener solo la primera llave primaria
				 * Implementar a fututo la obtencion de resultados
				 * el tablas con mas de una llave primaria
				 */
				foreach ($resQuery as  $res){
					
					$i=0;
					foreach ($res as $key => $value){
						
						$mTable = $resQuery->getColumnMeta($i);
						
						if ($mTable['name']){
							
							if (!$ff)
					   			$ff = $mTable['name'];
					   
							$this->tableStruct[$tableName]['fields'][$mTable['name']] = '';   
					
							$this->tableStruct[$tableName]['types'][$mTable['name']] = $mTable['native_type'];
					
							if (!strcmp(strtolower($mTable['name']),'id')){
								if (!$pk)
							  		$pk = $mTable['name'];
							}else{

								if (strripos($mTable['name'],'id')!==false){
									if (!$pk)
							   		$pk = $mTable['name'];
								}
							}
														
						}
					
						$i+=1;
						
					}break;
					
				}
			break;
		}

		
		if ($pk)
		   $this->tableStruct[$tableName]['pk'] = $pk;
		else
		   $this->tableStruct[$tableName]['pk'] = $ff;

	}

	/**************/
	/* Conexiones */
	/**************/

	/**
	 * Abre la conexion a la base de datos
	 *
	 * @return resorce
	 */
	public function openConecction (){
		
		$dsn = $this->engine.
				':dbname='.$this->database.
				';host='.$this->host;
		$user = $this->user;
		$password = $this->password;
				
		try {
    		$this->dbh = new PDO($dsn, $user, $password);
    		
    		$this->successfulConnect = true;
    		
		} catch (PDOException $e) {
			
    		$GLOBALS['OF_SQL_LOG'].= 'Connection failed: ' . $e->getMessage();
    		
		}

	}

	/**
	 * Cierra la conexion a la base de datos
	 *
	 */
	public function closeConecction (){
			

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