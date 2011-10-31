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
 * @package OPF
 * @version 0.1
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */
class OPF_myActiveRecord {

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
	 * Arreglo con los valores que se
	 * pretenden intercambiar en el metodo
	 * pre query para prevenir ataques sql.
	 * @var array
	 */
	private $arrayPrepare = array ();
	
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
		'myact_dbh', 'arrayPrepare', 'successfulConnect', 'tableStruct', 'classVars', 'keyFinded', 'arrayStringRelation', 'lastInserId',
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
	 * El parametro engine puede ser mysql o pgsql.
	 * <code>
	 * 
	 * 
	 * <?php
	 * 
	 * # Ejemplo 1: 
	 * 
	 * $myAct = new OPF_myActiveRecord('database');
	 * 
	 * # Ejemplo 2:
	 * 
	 * class table extends myActiveRecord {
	 * 
	 *   public $field1;
	 *   
	 *   public $field2;
	 *    
	 * }
	 * 
	 * $table = new table('database');
	 * 
	 * ?>
	 * 
	 * </code>
	 * @param string $database	Nombre base de datos.
	 * @param string $user	Usuario de base de datos.
	 * @param string $password	Clave de usuario de base de datos.
	 * @param string $host	Ruta fisica del servidor de base de datos.
	 * @param string $engine Motor de base de datos seleccionado. (mysql o pgsql)	
	 * @param string $port	Puerto de conexion.
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
	 * Seleccionar Base de datos.
	 * 
	 * Selecciona la base de datos que se va a usar.
	 * @access private
	 * @param string $newDatabase
	 */
	private function setDatabase ($newDatabase){
			
		$this->myact_database = $newDatabase;
	}

	/**
	 * Seleccionar motor de base de datos.
	 * 
	 * Selecciona el motor de base de datos que se va a usar.
	 * @access private
	 * @param string $newEngine
	 */
	private function setEngine ($newEngine){
			
		$this->myact_engine = $newEngine;
	}

	/**
	 * Seleccionar el host de la base de datos.
	 * 
	 * Selecciona el host donde esta ubicado el motor de la base de datos.
	 * @access private
	 * @param string $newHost
	 */
	private function setHost ($newHost){
			
		$this->myact_host = $newHost;
	}

	/**
	 * Seleccionar el usuario.
	 * 
	 * Selecciona el usuario de la base de datos para la conexion.
	 * @access private
	 * @param string $newUser
	 */
	private function setUser ($newUser){
			
		$this->myact_user = $newUser;
	}

	/**
	 * Seleccionar la clave de acceso
	 * 
	 * Setear la clave de acceso que usara el usuario que tendra acceso a la base de datos.
	 * @access private
	 * @param string $newPassword
	 */
	private function setPassword ($newPassword){
			
		$this->myact_password = $newPassword;
	}

	/**
	 * Seleccionar el puerto.
	 * 
	 * Setear el puerto que se usara para conectarse a la base de datos sobre el motor de base de datos.
	 * @access private
	 * @param integer $newPort
	 */
	private function setPort ($newPort){
			
		$this->myact_port = $newPort;
	}

	/**
	 * Seleccionar los paramteros de conexion.
	 * 
	 * Setear varios parametros al mismo tiempo los parametros se setean mediante un arreglo que tenga las siguientes llaves (Todas o algunas). Database, engine, host, user, password, port.
	 * @access private
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
	 * Valida un atributo para saber si es accesible dentro de la clase.
	 * @access private
	 * @param string $field
	 * @return boolean
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
	 * Obtener last insert id (postgresql)
	 * 
	 * Setea el valor de lastIserId, con el parametro del nombre de la secuencia si aplica
	 * @access private  
	 * @return integer
	 */
	private function get_LastInsertId (){
		
		$idSeq = '';
		
		if (isset($this->tableIdSeq[$this->myact_table]))
			$idSeq = $this->tableIdSeq[$this->myact_table];
		
		return $this->myact_dbh->lastInsertId($idSeq);	
	}
	
	/**
	 * Buscar registros
	 *
	 * Busca los registros asociados a una consulta sql.
	 * @access private
	 * @param string $strCond
	 * @param string $orderBy
	 * @param string $orderMethod
	 * @param integer $intLimit
	 * @param integer $offset
	 * @return mixed
	 */
	private function findEngine ($strCond = '', $orderBy = '', $orderMethod = '', $intLimit = 0, $offset = 0){
		
		if ($this->myact_table != 'myActiveRecord'){
		
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

				$keyFinded = '';
			
				$iCounter = 1;

				if ($strCond)
				
			   		$sql .= ' WHERE ';

				$cCond = count($strCond = explode('&',$strCond));
			
				foreach ($strCond as $cnd){
				
					# TODO: Evaluar si viene una sentencia booleana
					$smblRel = $this->evalSimbolInSubQuery($cnd,true);
				
					$vCnd = '';
				
					if ($smblRel)
					
						list ($fCnd, $vCnd) = explode($smblRel,$cnd);
				
					if (trim($fCnd) && $vCnd){

						$keyFinded .= $fCnd.$smblRel.' ?';

						$this->arrayPrepare[] = trim($vCnd);

					}else{
					
						//$keyFinded .= '';
						
						//$this->arrayPrepare[] = trim($vCnd);
					}
					
					if ($iCounter<$cCond)
					
				   		$keyFinded .= ' AND';
					
					$iCounter ++;
				}
			
				$sql .= $keyFinded;
			
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
					
					foreach ($rF[0] as $etq => $value){
					
						if (!in_array($etq,$this->arrayInvalidAtt)){
							
							$this->$etq = $value;
						}	
					}
				
					$this->keyFinded = $keyFinded;
					
				}else{
					//TODO:
					// El resultado sera recorrido
				}
				$this->arrayPrepare = array ();				
			}else{

				if ($strCond){
				
					if ($this->autoQuoteOnFind){
					
						if (is_string($strCond)){
							
							$this->arrayPrepare[] = $strCond;
						}
					}
				
					$sql .= ' WHERE '.$this->tablePk[$this->myact_table].' = '.$strCond;
				}
			
				$rF = $this->query($sql);
			
				if ($this->num_rows){
				
					$this->keyFinded = $strCond;
				
					foreach ($rF[0] as $etq => $val){
					
						if (is_string($etq)){
						
							if (!in_array($etq,$this->arrayInvalidAtt)){
							
								$this->$etq = $val;
							}
						}
					}
				}
				$this->arrayPrepare = array ();
			}
						
			return $rF;
		}
	}
			
	/**
	 * Evaluar condicion.
	 * 
	 * Evalua si una condicion pertenece a una consulta sql.
	 * @access private
	 * @param string $strCond
	 * @return boolean
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
	 * Construye el resultado de una cosunta sql asociada a una tabla o a la base de datos.
	 * @access private
	 * @param object $rF Fila
	 * @return object
	 */
	private function buildRes($rF){
		
		$cloThis = clone $this;
		
		if(is_array($rF)){
			
			foreach($rF as $name => $value){
				
				if (!is_numeric($name)){
					
					$cloThis->$name = utf8_encode($value);
				}
			}
		}
		
		return $cloThis;
	}
	
	/**
	 * Obtener campos de una tabla.
	 * 
	 * Obtiene los campos en una cadena de una tabla .
	 * @access private 
	 * @param string $table
	 * @return string
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
	 * Evaluar condicion.
	 * 
	 * Evalua la condicion que exite un operador de relacion en find o delete.
	 * @access private
	 * @param string $strCond	Condicion
	 * @param boolean $returnSimbol	Retornar o no 
	 * @return boolean
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
	 * Obtener nombre llave primaria.
	 * 
	 * Obtiene la llave primaria de uan tabla basado en la palabra 'id', busca el primer campo de esa tabla que tenga la palabra solo 'id' o la primera que contenga 'id'.
	 * @access private
	 * @param string $tableName	Nombre tabla
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
	 * Configurar el posfijo para las secuencias Postgresql.
	 * 
	 * Configura el posfijo utilizado para llamar a las secuencias en Postgresql cuando se desea obtener el Last Insert Id de una tabla.
	 * @param string $posFij	Posfijo
	 */
	public function setPosfijSeq ($posFij = ''){
			
		$this->posFijSeq = $posFij;
	}
		
	/**
	 * Configurar el nombre de la secuencia usada en Postgresql.
	 * 
	 * Configura el nombre de la secuencia en la tabla para que despues de guardar un registro se pueda obtener el valor de Last Insert Id.
	 * @param string $name	Nombre secuencia
	 */
	public function setSeqName($name = ''){
		
		if ($name)
			$this->tableIdSeq[$this->myact_table] = $name;		
	}
	
	/**
	 * Configurar comillas automaticas. 
	 * 
	 * Configurar si se van a usar o no las comillas automaticas cuando se realizan consultas con el metodo Query. Las comillas automaticas se aplican en cadenas de caracteres alfanumericas.
	 * @param boolean $value	True o False.
	 */
	public function setAutoQuotesInFind ($value){
		
		$this->autoQuoteOnFind = $value;
	}
	
	/**
	 * Obtener el nombre de la base de datos.
	 * 
	 * Obtiene el nombre de la base de datos actual a la que se esta conectado o se esta intentando conectar.
	 * @return string
	 */
	public function getDatabase (){
			
		return $this->myact_database;
	}

	/**
	 * Obtener el motor de base de datos.
	 * 
	 * Obtiene el nombre del motor de la base de datos a la que se esta conectado o se esta intentando conectar.
	 * @return string
	 */
	public function getEngine (){
			
		return $this->myact_engine;
	}

	/**
	 * Obtener el host.
	 * 
	 * Obtiene el host (direccion fisica) del motor de la base de datos a la que se esta conectado o se esta intentando conectar.
	 * @return string
	 */
	public function getHost (){
			
		return $this->myact_host;
	}

	/**
	 * Obtener el usuario de la conexion.
	 * 
	 * Obtiene el nombre del usuario de la base de datos con el que se esta conectado o se esta intentando conectar.
	 * @return string
	 */
	public function getUser (){
			
		return $this->myact_user;
	}

	/**
	 * Obtener la clave del usuario.
	 * 
	 * Obtiene la clave del nombre de usuario de la base de datos a la que se esta conectado o se esta intentando conectar.
	 * @return string
	 */
	public function getPassword (){
			
		return $this->myact_password;
	}

	/**
	 * Obtener numero de puerto.
	 * 
	 * Obtiene el numero de puerto del motor de la base de datos a la que se esta conectado o se esta intentando conectar.
	 * @return integer
	 */
	public function getPort (){
			
		return $this->myact_port;
	}
	
	/**
	 * Obtener el Log Sql.
	 * 
	 * Obtiene un registro de las consulta echas al motor de la base de datos. Incluso en una transaccion.
	 * @return string
	 */
	public function getSqlLog (){
			
		return $GLOBALS['OF_SQL_LOG'];
	}

	/**
	 * Obtener el Log de Errores Sql.
	 * 
	 * Obtiene una cadena con el utimo error en una transaccion o consulta sql a la base de datos.
	 * @param boolean $HTMLformat	Formato HTML
	 * @return string
	 */
	public function getErrorLog ($HTMLformat = false){

		$error = '';
		
		if (trim($GLOBALS['OF_SQL_LOG_ERROR'])){
			
			if ($HTMLformat)
				$error = '<div class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.htmlentities($GLOBALS['OF_SQL_LOG']).'<br><div class="error_detail"><b>'.ERROR_DET_LABEL.'</b>:&nbsp;'.htmlentities($GLOBALS['OF_SQL_LOG_ERROR']).'</div></div>';
			else 
				$error = trim($GLOBALS['OF_SQL_LOG_ERROR']);
		}
			
		return $error;
	}

	/**
	 * Obtener numero de registros.
	 * 
	 * Obtiene el numero de registros afectados por la utima consulta, insercion, actualizacion o eliminacion de registros.
	 * @return integer
	 */
	public function getNumRowsAffected (){
			
		return $this->num_rows;
	}
	
	/**
	 * Obtener numero de campos.
	 * 
	 * Obtiene el numero de campos afectados por la ultima consulta Select.
	 * @return integer
	 */
	public function getNumFieldsAffected (){
		
		return $this->num_cols;
	}
	

	/**
	 * Obtener Last Insert Id.
	 * 
	 * Obtiene el valor del indice o llave primaria siempre y cuando este sea un campo autoincrmentable o serial del ultimo registro insertado en una tabla.
	 * @return integer
	 */
	public function getLastInsertId (){
			
		return $this->lastInserId;
	}
	
	/**
	 * Inicia una transaccion.
	 * 
	 * Inicia un bloque de transaccion.
	 * <code>
	 * 
	 * <?php
	 * 
	 * $myAct = new OPF_myActiveRecord;
	 * 
	 * $myAct->beginTransaction ();
	 * 
	 * $myAct->query("UPDATE table SET field2 = 'value'");
	 * 
	 * $myAct->query("DELETE FROM table WHERE field1 = 1");
	 * 
	 * $myAct->endTransaction ();
	 * 
	 * ?>
	 * 
	 * </code>
	 */
	public function beginTransaction (){
		
		if (!$GLOBALS['OF_IN_TRANSACCTION']){
			
			$GLOBALS['OF_SQL_LOG'] .= 'BEGIN TRANSACTION;'."\n";
		
			$GLOBALS['OF_IN_TRANSACCTION'] = true;
			
			$this->myact_dbh->beginTransaction();
		}
		
	}

	/**
	 * Finaliza una transaccion.
	 *  
	 * Finaliza un bloque de transaccion. Y retorna su exito o no exito.
	 * <code>
	 * 
	 * <?php
	 * 
	 * $myAct = new OPF_myActiveRecord;
	 * 
	 * $myAct->beginTransaction ();
	 * 
	 * $myAct->query("UPDATE table SET field2 = 'value'");
	 * 
	 * $myAct->query("DELETE FROM table WHERE field1 = 1");
	 * 
	 * if ($myAct->endTransaction ())
	 * 	  echo 'Exito'; 		
	 * else
	 * 	  echo $myAct->getErrorLog();
	 * 
	 * ?>
	 * 
	 * </code> 
	 * @return boolean
	 */
	public function endTransaction (){
		
		$sucsess = true;
		
		if ($GLOBALS['OF_IN_TRANSACCTION']){
			
			if (!$this->getErrorLog()){
			
				$GLOBALS['OF_SQL_LOG'] .='COMMIT;'."\n";
				
				$this->myact_dbh->commit();
			
			}else{
			
				$GLOBALS['OF_SQL_LOG'] .='ROLLBACK;'."\n";
				
				$this->myact_dbh->rollBack();
				
				$sucsess = false;
			}
			
			$GLOBALS['OF_IN_TRANSACCTION'] = false;
		}
		
		return $sucsess;
	}
	

	/**
	 * Cargar un archivo de SQL.
	 * 
	 * Carga una consulta sql desde un archivo fisico ademas con la posibilidad de asignar variables dentro de la lectura del archivo.
	 * En caso de no encontrar el archivo retorna FALSE.
	 * <code>
	 * 
	 * query.sql
	 * SELECT * FROM table WHERE id = {id};
	 * 
	 * <?php
	 * $myAct = new OPF_myActiveRecord;
	 * 
	 * $sql = $myAct->loadSqlFromFile('query.sql',array('id'=>1));
	 * 
	 * echo $sql;
	 * ?>
	 * 
	 * Resultado: 
	 * SELECT * FROM table WHERE id = 1;
	 * 
	 * </code> 
	 * @param string $file	Ruta del archivo fisico
	 * @param array $vars	Arreglo de variables a reemplazar
	 * @return string
	 */
	public function loadSqlFromFile ($file, $vars = array()){

		$link = @fopen($file,'r');

		$sql = false;
		
		if ($link){
		
  			$sql = fread($link, filesize($file));
  		
  			fclose($link);
  		
  			foreach ($vars as $var => $val){
  			
  				unset($vars[$var]);
  			
  				$vars['{'.$var.'}'] = $val;
  			}
		
  			$keys = array_keys($vars);
  		
  			$sql = str_ireplace ( $keys, $vars, $sql);
  		
		}
  		
  		return $sql;
	}
	

	/**
	 * Ejecutar una consulta SQL
	 * 
	 * Ejecuta una consulta SQL a la base de datos y retorna una resultado (objeto) asociado a los registros obtenidos o retorna false en caso de que no haya exito.
	 * <code>
	 * 
	 * Ejemplo 1:
	 * <?php
	 * 
	 * // Obtener varios resultados
	 * 
	 * $myAct = new OPF_myActiveRecord();
	 * 
	 * if ($res = $myAct->query('SELECT field1,... FROM table')){
	 * 	  
	 *    foreach ($res as $row)
	 *    	
	 *    	  echo $row->field1.'<br>';
	 *    
	 * }else
	 * 
	 * 	  echo $myAct->getErrorLog();		
	 * 
	 * ?>
	 * 
	 * </code>
	 * @param string $sql Consulta SQL
	 * @param boolean $saveInLog Guardar en el log
	 * @return object
	 */
	public function query ($sql, $saveInLog = true){
		
		$eError = array ();
		
		if ($saveInLog)
		
			$GLOBALS['OF_SQL_LOG'] .= vsprintf(str_ireplace("?","%s",$sql) ,$this->arrayPrepare).' '."\n";
			
		$isrW = false;
			
		foreach ($this->arrayCrud as $rW){
			
			$pos = stripos($sql, $rW);
			
			if ($pos === false){
				
			}else{
				
				if (stripos($sql, 'select') === false){
					
					$isrW = true;
					
					break;
				}
				
			}
			
		}
		
		if ($isrW){
			
			# Establecer nombre de secuencia automaticamente en Pgsql
			if (!isset($this->tableIdSeq[$this->myact_table]))
			
				if ($this->getEngine()=='pgsql')
				
					$this->tableIdSeq[$this->myact_table] = $this->myact_table.'_'.$this->tablePk[$this->myact_table].$this->posFijSeq;			
			
			$sth = $this->myact_dbh->prepare($sql);

			$sth->execute($this->arrayPrepare);
		
			$this->num_rows = $sth->rowCount();  
				
			$eError =  $sth->errorInfo();
				
			if (isset($eError[2])){
					
				$GLOBALS['OF_SQL_LOG_ERROR'] .= $eError[2]."\n";
			}
			
			return $this->num_rows;
			
		}else{
			# Select / No se afectan en transacciones, no afectan las busquedas
			
			$objReturn;
			
			$array = array();
			
			$sth = $this->myact_dbh->prepare($sql);
			
			$sth->execute($this->arrayPrepare);
			
			$resQuery = $sth->fetchAll();
			
			$eError =  $sth->errorInfo();
			
			if (isset($eError[2])){
								
				$GLOBALS['OF_SQL_LOG_ERROR'] .= $eError[2]."\n";
				
			}else{
				
				$this->num_cols = $sth->columnCount();
				
				$this->num_rows = 0;

				foreach ($resQuery as $row){
					
					$array[] = $this->buildRes($row);

					$this->num_rows++;
				}

				
			}
		
			return $array;
		}
		
		$this->arrayPrepare = array ();
	}

	/**
	 * Busca registros que coincidan con el parametro de consulta.
	 * 
	 * Trata de encontrar registros de una tabla en la base de datos en uso que cumplan con determinadas condiciones segun campos de la tabla.
	 * [Nota 1:] El metodo find devolvera un objeto asociado a los campos de la clase extendida (Tabla) o FALSE en caso de no encontrar registros asociados.
	 * [Nota 2:] El metodo find solo esta disponible cuando se llama desde un objeto extendido de la clase myActiveRecord, no directamente desde myActiveRecord. En caso contrario pruebe el metodo Query.
	 * [Nota 3:] EL metodo find solo retorna datos asociados a los campos de la tabla cuando se trata de un solo registro, sin embargo si llega a encontrar mas de un registro el metodo devolvera TRUE.
	 * [Nota 4:] Es posible agregar mas de una condición utilizando los operadores de comparacion ('<>','<=','>=', '!=','>', '<','=', '!') y el conector lógico & (AND) Ver ejemplo 2. 
	 * <code>
	 * 
	 * <?php
	 * 
	 * class usuarios extends myActiveRecord {
	 * 
	 * 	public $usuario_id;
	 * 
	 * 	public $usuario;
	 * 
	 *  public $apellido;
	 * 
	 * }
	 * 
	 * # Ejemplo 1 Condición única:
	 * 
	 * $usuarios = new usuarios;
	 * 
	 * if ($usuarios->find(1)) 
	 *
	 * 	  echo 'Hola '.$usuarios->usuario; 
	 * 
	 * else
	 * 
	 * 	  echo 'No existe el usuario con el Id 1';
	 * 
	 * # Ejemplo 2 Condición compuesta:
	 * 
	 * $apellido = 'ortegon';
	 * 
	 * if ($usuarios->find('usuario=jose & apellido='.$apellido)) 
	 *
	 * 	  echo 'Hola '.$usuarios->usuario; 
	 * 
	 * else
	 * 
	 * 	  echo 'No existe el usuario';
	 * 
	 * ?>
	 * 
	 * </code>
	 * @param string $strCond	Condicion o condiciones principales.
	 * @param string $orderBy	Ordenar por el campo o campos.
	 * @param string $orderMethod	Metodo de ordenamiento.
	 * @param integer $intLimit	Limite de registro.
	 * @param integer $offSet	Cuando aplica un limite de registros obtener desde.
	 * @return object
	 */
	public function find($strCond = '', $orderBy = '', $orderMethod = '', $intLimit = '', $offSet = ''){

		return $this->findEngine($strCond, $orderBy, $orderMethod, $intLimit, $offSet);
	}

	/**
	 * Inserta o Modifica un registro.
	 *
	 * El metodo save modificara un registro o insertara uno nuevo. Si lo precede el metodo find y este encuentra un registro que coincida con la busqueda, este lo modificara. En caso contrario lo agregara a la tabla.
	 * Por seguridad el metodo Save solo actualizara el regitro cuando la busqueda anterior solo haya devuelto un regitro.
	 * <code>
	 * 
	 * <?php
	 * 
	 * # Ejemplo 1:
	 * 
	 * class usuarios extends myActiveRecord {
	 * 
	 * 	public $usuario_id;
	 * 
	 * 	public $usuario;
	 * 
	 * }
	 * 
	 * $usuarios = new usuarios;
	 * 
	 * $usuarios->find(1);
	 *  
	 * $usuarios->usuario = 'xxx';
	 * 
	 * if ($usuarios->save())
	 * 
	 * 	  echo 'Cambios guardados.';
	 * 
	 * else
	 * 
	 * 	  echo $usuarios->getErrorLog();		 
	 * 
	 * ?>
	 * 
	 * </code>
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

					if (!strcmp( trim( strtoupper($this->$field)),'NULL')){
							
						$sql .= 'NULL, ';
							
					}else{
							
						$sql .= '?, ';
							
						$this->arrayPrepare[] = utf8_decode($this->$field);
					}
				
				}
				
			}

			if ($this->evalSimbolInSubQuery($this->keyFinded)){
				
				$sql = substr($sql,0,-2).' WHERE '.$this->keyFinded;
				
			}else{

				$sql = substr($sql,0,-2).' WHERE '.$this->tablePk[$this->myact_table].' = ?';
				
				$this->arrayPrepare[] = $this->keyFinded;
			}

			$this->query($sql);
			
		// Insert
		}else{
			
			$sql .= 'INSERT INTO '.$this->myact_table.' (';

			foreach ($this->classVars as $field => $value){
				
				if ($this->validateAtt($field)){
				
					$sql.=$field.', ';

					$sqlValues .= '?, ';
						
					$this->arrayPrepare[] = utf8_decode($this->$field); 
				}
			}									
			
			$sql = substr($sql,0,-2).') VALUES ('.substr($sqlValues,0,-2).')';

			$this->query($sql);
			
			$this->lastInserId = $this->get_LastInsertId();
		}
		
		$this->arrayPrepare = array ();
		
		return $this->getNumRowsAffected();
	}

	/**
	 * Elimina registros de una tabla.
	 * 
	 * Trata de borrar los registros de una tabla si ellos cumplen con las condiciones. La condicion opera de forma identica a el metodo find. El metodo retornara el numero de registros afectados. 
	 * <code>
	 * 
	 * <?php
	 * 
	 * # Ejemplo 1:
	 * 
	 * class usuarios extends myActiveRecord {
	 * 
	 * 	public $usuario_id;
	 * 
	 * 	public $usuario;
	 * 
	 * }
	 * 
	 * $usuarios = new usuarios;
	 * 
	 * if ($usuarios->delete(1))
	 * 
	 *   echo 'El registro fue eliminado';
	 *   
	 * else  
	 * 
	 *   echo 'El registro no fue eliminado';
	 * 
	 * ?>
	 * 
	 * </code>
	 * @param string $strCond Condicion
	 * @return integer
	 */
	public function delete ($strCond){
		
		$sql = '';	
		
		if ($strCond){
			
			$sql .= 'DELETE FROM '.$this->myact_table.'';

			$iCounter = 1;

			if ($this->evalIfIsQuery($strCond)){
					
				$sql .= ' WHERE ';
					
				$cCond = count($strCond = explode('&',$strCond));
					
				foreach ($strCond as $cnd){
						
					# TODO: Evaluar si viene una sentencia booleana
					list ($fCnd, $vCnd) = explode(	$smblRel = $this->evalSimbolInSubQuery(	$cnd,true),$cnd);

					if (trim($fCnd) && $vCnd){
							
						$sql .= $fCnd.$smblRel.' ?';
						
						$this->arrayPrepare[] = trim($vCnd);

					}else
						
						$sql .= ' '.trim($cnd);
					
						
					if ($iCounter<$cCond)
						
						$sql .= ' AND';
						
					$iCounter ++;
				}
				
			}else{
				
				$strCond = '?';
				
				$this->arrayPrepare[] = $strCond;

				$sql .= ' WHERE '.$this->tablePk[$this->myact_table].' = '.$strCond;
			}

			$this->query($sql);
		}
		
		$this->arrayPrepare = array ();
		
		return $this->getNumRowsAffected();
	}

	/**
	 * Configura la llave primaria de una tabla.
	 * 
	 * Configura una llave primaria para la tabla, si no se suministra se calculara automaticamente.
	 * <code>
	 * 
	 * <?php
	 * 
	 * class usuarios extends myActiveRecord {
	 *
	 * 	public $nombre;
	 * 
	 *  public $apellido;
	 *
	 * }
	 * 
	 * $usuarios = new usuarios;
	 * 
	 * $usuarios->setPrimaryKey('user_id');
	 * 
	 * $usuarios->find(1);
	 * 
	 * echo $usuarios->getSqlLog();
	 * 
	 * ?>
	 * 
	 * Resultado:
	 * SELECT nombre, apellido FROM usuarios WHERE user_id = 1;
	 * 
	 * </code>
	 * @param	string $field	Nombre llave primaria
	 */
	public function setPrimaryKey($field = ''){
		
		$this->tablePk[$this->myact_table] = $field;
	}

	/**
	 * Abre la conexion a la base de datos
	 * @access private
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
    		
    		$this->successfulConnect = true;
    		
		} catch (PDOException $e) {
			
			$GLOBALS['OF_SQL_LOG'] .= 'Connect to '.$this->myact_engine;
			
    		$GLOBALS['OF_SQL_LOG_ERROR'].= ''.$e->getMessage();
    			
		}
		
	}

	/**
	 * Cierra la conexion a la base de datos
	 * @access private
	 */
	private function closeConecction (){
			

	}

	/**
	 * Verificar la conexion actual.
	 * 
	 * Despues de intentar abrir una conexion en el constructor verifica si esta se pudo abrir o no.
	 * <code>
	 * 
	 * <?php
	 * 
	 * $myAct = new OPF_myActiveRecord('database');
	 * 
	 * if ($myAct->isSuccessfulConnect())
	 * 
	 * 	  echo 'Conexion exitosa';
	 *
	 * else
	 * 
	 *    echo $myAct->getErrorLog();
	 * 
	 * ?>
	 * 
	 * </code> 
	 * @return boolean
	 */
	public function isSuccessfulConnect (){
		
		return $this->successfulConnect;
	}
	
}
?>