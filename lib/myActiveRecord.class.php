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
 * @package OSEZNO-PHP-FRAMEWORK
 * @version 0.1
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */
class myActiveRecord {

	/**
	 * Nombre base de datos
	 * 
	 * Nombre de la base de datos a la cual debe conectarse
	 * @access private
	 * @var string
	 */
	private $myact_database;

	/**
	 * Motor base de datos
	 * 
	 * Nombre del motor de bases de datos que vamos a usar, puede usarse 'mysql' o 'postgres'
	 * @access private
	 * @var string
	 */
	private $myact_engine;

	/**
	 * Direccion fisica servidor BD
	 * 
	 * Nombre del Servidor o Ip donde se encuentra el motor de la base de datos.
	 * @access private
	 * @var string
	 */
	private $myact_host;

	/**
	 * Usuario para la conexion
	 * 
	 * Nombre del usuario que permite el acceso a la base de datos para conexion.
	 * @access private
	 * @var string
	 */
	private $myact_user;

	/**
	 * Clave de acceso 
	 * 
	 * Clave de acceso del usuario que permite la conexion a la base de datos.
	 * @access private
	 * @var string
	 */
	private $myact_password;

	/**
	 * Puerto de conexion
	 * 
	 * Puerto del motor de la Base de datos que se usara para conectarse al motor de base de datos seleccionado. 
	 * Puede usar 3306 para mysql o 5432 para postgresql
	 * @access private
	 * @var integer
	 */
	private $myact_port;

	/**
	 * Tabla actual de trabajo
	 * 
	 * Nombre de la tabla de la base de datos que actuamente se encuentra en uso para la transaccion.
	 * @access private
	 * @var string
	 */
	private $myact_table;

	/**
	 * Objeto de la conexion.
	 * 
	 * Objeto de conexion a la base de datos
	 * @access private
	 * @var resourse
	 */
	private $myact_dbh;

	/**
	 * Estado de la conexion actual.
	 * 
	 * Comprueba el estado boleano de si la actual conexion esta abierta o cerrada.
	 * @access private
	 * @var boolean
	 */
	private $successfulConnect = false;
	
	/**
	 * Filas afectadas.
	 * 
	 * Numero entero de filas afectadas por la ultima consulta a la base de datos.
	 * @access private
	 * @var integer
	 */
	private $num_rows = 0;

	/**
	 * Columna afectadas.
	 * 
	 * Numero entero de campos afectados por la ultima consulta select a la base de datos.
	 * @access private
	 * @var intger
	 */
	private $num_cols = 0;
	
	/**
	 * Estructura actual de la tabla.
	 * 
	 * Estructura actual de la tabla.
	 * @access private
	 * @var mixed
	 */
	private $tableStruct = array();

	/**
	 * Llaves primarias de la tablas.
	 * 
	 * Llaves primarias de cada tabla, segun hayan sido definidas o se definan automaticamente.
	 * @access private
	 * @var mixed
	 */
	private $tablePk = array ();
	
	/**
	 * Id de secuencia.
	 * 
	 * Por tabla el id de la secuencia
	 * @access private
	 * @var array
	 */
	private $tableIdSeq = array ();
	
	/**
	 * Alias de campos de la tabla
	 * 
	 * Alias de campos de la tabla en uso.
	 * @access private
	 * @var string
	 */
	private $classVars;

	/**
	 * Valor a buscar principal.
	 * 
	 * Valor a buscar sobre la llave principal de la tabla.
	 * @access private
	 * @var unknown_type
	 */
	private $keyFinded;

	/**
	 * Operadores lógicos
	 * 
	 * Operadores logicos usados para buscar registros de una tabla.
	 * @access private
	 * @var mixed
	 */
	private $arrayStringRelation = array (
		'<>','<=','>=', '!=','>', '<','=', '!'
	);
	
	/**
	 * Valor de ultimo id sobre registro agregado.
	 * 
	 * Contiene el valor ultimo id insertado en determinada tabla cuando es llamado el metodo save().
	 * @access private
	 * @var integer
	 */
	private $lastInserId;

	/**
	 * Posfijo en nombre de secuencia Postgresql
	 * 
	 * Posfijo del nombre de las secuencias que se usan en postgresql.
	 * @access private
	 * @var string
	 */
	private $posFijSeq = '_seq';

	/**
	 * Usar auto comillas en query.
	 * 
	 * Decide si se coloca o no auto comillas sencillas en las consulta hechas con el metodo query cuando se ubica texto dentro de ella.
	 * @access private 
	 * @var boolean
	 */
	private $autoQuoteOnFind = true;
	
	/**
	 * Atributos no reconocibles
	 * 
	 * Atributos que no son reconocibles para los metodos que intervienen en las tablas.
	 * @access private
	 * @var mixed
	 */
	private $arrayInvalidAtt = array (
		'myact_database', 'myact_engine', 'myact_host', 'myact_user', 'myact_password', 'myact_port', 'myact_table', 'posFijSeq', 'num_rows', 'num_cols',
		'myact_dbh', 'successfulConnect', 'tableStruct', 'classVars', 'keyFinded', 'arrayStringRelation', 'lastInserId',
		'arrayInvalidAtt','tablePk', 'tableIdSeq', 'autoQuoteOnFind', 'arrayCrud'	
	);
	
	/**
	 * Operaciones no query.
	 * 
	 * Operaciones no Query.
	 * @access private
	 * @var mixed
	 */
	private $arrayCrud = array (
		'insert',
		'update',
		'delete'
	);

	/**
	 * Abre una conexion a base de datos.
	 * 
	 * Instancia a un nuevo objeto una conexion a la base con los parametros usados. 
	 * @param $database	Nombre base de datos.
	 * @param $user	Usuario de base de datos.
	 * @param $password	Clave de usuario de base de datos.
	 * @param $host	Ruta fisica del servidor de base de datos.
	 * @param $engine Motor de base de datos seleccionado. (mysql o pgsql)	
	 * @param $port	Puerto de conexion.
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

		if (strcmp($this->myact_table = get_class($this),'myActiveRecord')){
			
			$this->classVars = get_class_vars($this->myact_table);
			
			if (!isset($this->tablePk[$this->myact_table]))
			   $this->getPkFromTable($this->myact_table);
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
			
		$this->myact_database = $newDatabase;
	}

	/**
	 * Setear el motor de bases de datos que se va a usar
	 *
	 * @param string $newEngine
	 */
	private function setEngine ($newEngine){
			
		$this->myact_engine = $newEngine;
	}

	/**
	 * Setear el nombre del host o su ip para
	 * conectarse a su motor de base de datos
	 *
	 * @param string $newHost
	 */
	private function setHost ($newHost){
			
		$this->myact_host = $newHost;
	}

	/**
	 * Setear el nombre de usuario que se usara
	 * para conectarse a la base de datos
	 *
	 * @param string $newUser
	 */
	private function setUser ($newUser){
			
		$this->myact_user = $newUser;
	}

	/**
	 * Setear la clave de acceso que usara
	 * el usuario que tendra acceso a la base
	 * de datos.
	 *
	 * @param string $newPassword
	 */
	private function setPassword ($newPassword){
			
		$this->myact_password = $newPassword;
	}

	/**
	 * Setear el puerto que se usara
	 * para conectarse a la base de datos
	 * sobre el motor
	 *
	 * @param integer $newPort
	 */
	private function setPort ($newPort){
			
		$this->myact_port = $newPort;
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
		
		if (strcmp($field,$this->tablePk[$this->myact_table]))

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
		
		if (isset($this->tableIdSeq[$this->myact_table]))
			$idSeq = $this->tableIdSeq[$this->myact_table];
		
		return $this->myact_dbh->lastInsertId($idSeq);	
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
		
		foreach ($this->classVars as $var => $val){
			
			if (!in_array($var,$this->arrayInvalidAtt)){
				
				$subSqlF .= $var;

			   	$subSqlF .= ', ';

				$iCounter++;
			}
		}
		
		$sql .= 'SELECT '.substr($subSqlF,0,-2).' FROM '.$this->myact_table;
		
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
					
					$sql .= ' ORDER BY '.$this->tablePk[$this->myact_table].' ';
					
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
				
				$sql .= ' WHERE '.$this->tablePk[$this->myact_table].' = '.$strCond;
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
			$this->tableIdSeq[$this->myact_table] = $name;		
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
			
		return $this->myact_database;
	}

	/**
	 * Obtener el valor del nombre
	 * del motor de la base de datos 
	 * actualmente en uso
	 *
	 * @return string
	 */
	public function getEngine (){
			
		return $this->myact_engine;
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
			
		return $this->myact_host;
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
			
		return $this->myact_user;
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
			
		return $this->myact_password;
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
			
		return $this->myact_port;
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
			
			$this->myact_dbh->beginTransaction();
				
			if (!$this->getErrorLog()){
			
				$GLOBALS['OF_SQL_LOG'] .='COMMIT;'."\n";
				
				$this->myact_dbh->commit();
			
			}else{
			
				$GLOBALS['OF_SQL_LOG'] .='ROLLBACK;'."\n";
				
				$this->myact_dbh->rollBack();
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
			if (!isset($this->tableIdSeq[$this->myact_table]))
				if ($this->getEngine()=='pgsql')
					$this->tableIdSeq[$this->myact_table] = $this->myact_table.'_'.$this->tablePk[$this->myact_table].$this->posFijSeq;			
			
			$this->num_rows = $this->myact_dbh->exec($sql);
				
			$eError = $this->myact_dbh->errorInfo();
				
			if (isset($eError[2])){
					
				$GLOBALS['OF_SQL_LOG_ERROR'] .= $eError[2]."\n";
			}
			
			return $this->num_rows;
			
		}else{
			
			# Select / No se afectan en transacciones
			$array = array();
			$resQuery = $this->myact_dbh->query($sql);
		
			if (!$resQuery){
				
				$eError = $this->myact_dbh->errorInfo();
				
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

			$sql .= 'UPDATE '.$this->myact_table.' SET ';

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

			$sql = substr($sql,0,-2).' WHERE '.$this->tablePk[$this->myact_table].' = '.$this->keyFinded;

			$this->query($sql);
			
		// Insert
		}else{
			
			$sql .= 'INSERT INTO '.$this->myact_table.' (';

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
			
			$sql .= 'DELETE FROM '.$this->myact_table.'';

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

				$sql .= ' WHERE '.$this->tablePk[$this->myact_table].' = '.$strCond;
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
		
		$this->tablePk[$this->myact_table] = $field;
		
	}

	/**
	 * Abre la conexion a la base de datos
	 *
	 * @return resorce
	 */
	private function openConecction (){
		
		$dsn = $this->myact_engine.
				':dbname='.$this->myact_database.
				';host='.$this->myact_host;
		
		$user = $this->myact_user;
		
		$password = $this->myact_password;
				
		try {
			
    		$this->myact_dbh = new PDO($dsn, $user, $password);
    		
    		//$this->myact_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		
    		$this->successfulConnect = true;
    		
		} catch (PDOException $e) {
			
			$GLOBALS['OF_SQL_LOG'] .= 'Connect to '.$this->myact_engine;
			
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