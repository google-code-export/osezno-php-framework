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
	public $num_rows;

	/**
	 * Numero entero de campos afectados
	 * por la ultima consulta select a la
	 * base de datos.
	 *  
	 * @var intger
	 */
	private $num_cols;
	

	/*********************/
	/* Variables de obra */
	/*********************/

	/**
	 * Estructura de la tabla actual
	 *
	 * @var mixed
	 */
	private $tableStruct = array();


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
	private $arrayStringRelation = array ('<>','<=',
										  '>=', '!=',
										  '>', '<', 
										  '=', '!');
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
			
			if (!isset($this->tableStruct[$this->table]))
			   $this->getMetaDataTable($this->table);
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
	 *
	 */
	public function begin_transaction (){
			
		switch ($this->engine){
			case 'mysql':
				mysql_query($sql = "START TRANSACTION;", $this->link);
					
				break;
			case 'postgre':
				pg_query($this->link, $sql = "BEGIN TRANSACTION;");
					
				break;
		}
			
		$GLOBALS['OF_SQL_LOG'] .= $sql."\n";
	}

	/**
	 * Finaliza la trasaccion
	 *
	 * @return boolean
	 */
	public function end_transaction (){
		$exito = true;
			
		switch($this->engine){
			case 'mysql':
				if (!trim($GLOBALS['OF_SQL_LOG_ERROR']))
				    mysql_query($sql = "COMMIT;", $this->link);
				else{
					mysql_query($sql = "ROLLBACK;", $this->link);
						
					$exito = false;
				}
				break;
			case 'postgre':
				if (!trim($GLOBALS['OF_SQL_LOG_ERROR']))
				    pg_query($this->link, $sql = "COMMIT;");
				else{
					pg_query($this->link, $sql = "ROLLBACK;");
						
					$exito = false;
				}
				break;
		}

		$GLOBALS['OF_SQL_LOG'] .= $sql."\n";
			
		return $exito;
	}



	/**************************************************/
	/* Funciones CRUD - Query, Insert, Update, Delete */
	/**************************************************/

	/**
	 * Ejecuta una consulta SQL
	 * Devuelve un arreglo con el resultado de la consulta
	 *
	 * @param string $sql
	 */
	public function query ($sql, $saveInLog = true){
		
		if ($saveInLog)
			$GLOBALS['OF_SQL_LOG'] .= $sql.';'."\n";
			
		$array = array();
		$resQuery = $this->dbh->query($sql);
		
		if (!$resQuery){
			$eError = array ();
			$eError = $this->dbh->errorInfo();
			$GLOBALS['OF_SQL_LOG_ERROR'] = $eError[2];
		}else{
			$cadenaSelect = 'select ';
			$pos = stripos($sql, $cadenaSelect);
		
			if ($pos === false){
				$this->num_rows = $resQuery->rowCount();			
			}else{
				$this->num_rows = 0;
				foreach ($resQuery as $row){
					$array[] = $this->buildRes($row);
					$this->num_rows++;	
				}	
			}
		}
		
		return $array;
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
	 * @return object
	 */
	public function find($strCond = '', $orderBy = '', $orderMethod = '', $intLimit = ''){

		return $this->findOperator($strCond, $orderBy, $orderMethod, $intLimit);
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
					
				if (!is_null($this->$field)){

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

			$sql = substr($sql,0,-2).' WHERE '
			.$this->tableStruct[$this->table]['pk']
			.' = '.$this->keyFinded;

			$this->updateIn($sql);

			// Se va a agregar un registro
		}else{
			$sql .= 'INSERT INTO '.$this->table.' (';

			foreach ($this->classVars as $field => $value){

				// Para no tocar la llave primaria
				if (strcmp($field,$this->tableStruct[$this->table]['pk'])){

					if (!is_null($this->$field)){
						
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
			$sql = substr($sql,0,-2)
			.') VALUES ('
			.substr($sqlValues,0,-2).')';

			$this->insertIn($sql);
			$this->setLastInsertId($this->tableStruct[$this->table]['pk']);
		}
		
		return $this->getAfectedRows();
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
		if ($strCond)
			$this->deleteIn($strCond);
			
		return $this->getAfectedRows();
	}

	/**
	 * Trata de eliminar todos los registros
	 * de una tabla.
	 *
	 * @return integer
	 */
	public function delete_all (){
		$this->deleteIn();
		
		return $this->getAfectedRows();
	}


	/**************/
	/* Utilidades */
	/**************/
	
	/**
	 * Exporta una consulta sql o una busqueda
	 * a un archivo de formato html, pdf o xls
	 *
	 * @param mixed $mixed
	 * @param string $format
	 * @return string
	 */
	public function exportQuery ($mixed, $format = 'html'){

		$sw = 0;
		$return = '';
			
		$Rows = $mixed;
		$buf = '';
		$buf .=  '<table width="100%"  border="1" cellpadding="0" cellspacing="0">';

		foreach ($Rows as $Row){
			if (!$sw){
				$sw = 1;
				
				$keys = array_keys($Row);
				$buf.="\t".'<tr>'."\n";
				foreach ($keys as $key){
					if (!is_numeric($key)){
						$buf.="\t\t".'<td>'.ucwords($key).'</td>';	
					}
				}
				$buf.="\t".'</tr>'."\n";
				
			}
			
			$buf.="\t".'<tr>'."\n";

			foreach ($Row as $Key => $Value){
				if (!is_numeric($Key)){
					if (!$Value)
					   $Value = '&nbsp;';
					$buf.="\t\t".'<td>'.$Value.'</td>';
				}
			}

			$buf.="\t".'</tr>'."\n";
		}
			
		$buf .=  '</table>';
			
		switch ($format){
			case 'html':
				$return = $buf;
				break;
		}
			
		return $return;
	}

	
	/***********/
	/* Obreros */
	/***********/
	
	/**
	 * Trata de insertar un registro en la tabla
	 *
	 * @param string $sql
	 * @return integer
	 */
	private function insertIn($sql){

		$out = 0;
		$GLOBALS['OF_SQL_LOG'] .= $sql.';'."\n";
			
		switch ($this->engine){
			case 'mysql':
				$res = mysql_query ($sql, $this->link);

				$iRwsAf = mysql_affected_rows($this->link);

				if ($iRwsAf==-1)
				   $out = 0;
				else
				   $out = $iRwsAf;

				$GLOBALS['OF_SQL_LOG_ERROR'] .= mysql_error($this->link)."\n";
				break;
			case 'postgre':
				$sqlI = $sql;

				$res = pg_query ($this->link, $sqlI = str_replace('"',"'", $sqlI));

				$iRwsAf = pg_affected_rows($res);

				$out = $iRwsAf;
					
				$GLOBALS['OF_SQL_LOG_ERROR'] .= pg_last_error($this->link)."\n";
				break;
		}

		$this->num_rows = $out;

		return $out;
	}

	/**
	 * Trata de actualizar un registro
	 * en la tabla.
	 *
	 * @param string $sql
	 * @return integer
	 */
	private function updateIn ($sql){
			
		$out= 0;
		$GLOBALS['OF_SQL_LOG'] .= $sql.';'."\n";

			
		switch ($this->engine){
			case 'mysql':
				$res = mysql_query ($sql, $this->link);
					
				$iRwsAf = mysql_affected_rows($this->link);
					
				if ($iRwsAf==-1)
				   $out = 0;
				else
				   $out = $iRwsAf;

				$GLOBALS['OF_SQL_LOG_ERROR'] .= mysql_error($this->link)."\n";
				break;
			case 'postgre':
					
				$res = pg_query ($this->link, $sql = str_replace('"',"'",$sql));
					
				$iRwsAf = pg_affected_rows($res);
					
				$out = $iRwsAf;

				$GLOBALS['OF_SQL_LOG_ERROR'] .= pg_last_error($this->link)."\n";
				break;
		}

		$this->num_rows = $out;

		return $out;
	}

	/**
	 * Trata de eliminar uno o varios
	 * registros de la tabla
	 *
	 * @param string $strCond
	 * @return integer
	 */
	private function deleteIn ($strCond = ''){
			
		$out= 0;
		$sql = '';
			
		$sql .= 'DELETE FROM '.$this->table.'';
		$iCounter = 1;
			
		if ($strCond){

				
			if ($this->evalIfIsQuery($strCond)){
					
				$sql .= ' WHERE ';
					
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
			}else{
				if (is_string($strCond))
				$strCond = '\''.$strCond.'\'';

				$sql .= ' WHERE '.$this->tableStruct[$this->table]['pk']
				.' = '.$strCond;
			}
		}
			
		$GLOBALS['OF_SQL_LOG'] .= $sql.';'."\n";
			
		switch ($this->engine){
			case 'mysql':
				$res = mysql_query ($sql, $this->link);
					
				$iRwsAf = mysql_affected_rows($this->link);
					
				if ($iRwsAf==-1)
				   $out = 0;
				else
				   $out = $iRwsAf;

				$GLOBALS['OF_SQL_LOG_ERROR'] .= mysql_error($this->link)."\n";
				break;
			case 'postgre':
				$res = pg_query ($this->link, $sql = str_replace('"',"'",$sql));
					
				$iRwsAf = pg_affected_rows($res);
					
				$out = $iRwsAf;

				$GLOBALS['OF_SQL_LOG_ERROR'] .= pg_last_error($this->link)."\n";
				break;
		}
			
		$this->num_rows = $out;

		return $out;
	}

	/**
	 * Setea y refresca el last insert id para esa tabla
	 *
	 * @param string $fld
	 */
	private function setLastInsertId ($fld){
			
		$sql = '';
			
		switch($this->engine){

			case 'mysql':
					
				$sql = 'SELECT last_insert_id() AS current_value; ';
					
				$rows = mysql_fetch_array(
				mysql_query($sql, $this->link));
					
				$this->lastInserId = $rows['current_value'];
					
				$GLOBALS['OF_SQL_LOG_ERROR'] .= mysql_error($this->link)."\n";
					
				break;
			case 'postgre':
					
				$sql = "SELECT CURRVAL("."'".$this->table.'_'
				.$fld.$this->posFijSeq."'"
				.") AS current_value; ";
					
				$rows = pg_fetch_array(
				pg_query ($this->link, $sql = str_replace('"',"'",$sql)));
					
				$this->lastInserId = $rows['current_value'];
					
				$GLOBALS['OF_SQL_LOG_ERROR'] .= pg_last_error($this->link)."\n";
					
				break;
		}
			
		$GLOBALS['OF_SQL_LOG'] .= $sql."\n";
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

	private function findOperator ($strCond = '', $orderBy = '', $orderMethod = '', $intLimit = 0){
		
		$sql = '';
		
		
		//echo $subSqlF = $this->getStringSqlFields($this->table);
		
		/*
		$results = array();	
		$sql = '';
		$fCnd = '';
		
		$subSqlF = $this->getStringSqlFields($this->table);
			
		if ($this->evalIfIsQuery($strCond) || !$strCond){
			//-> Find all

			$sql .= 'SELECT '.$subSqlF.' FROM '.$this->table.' ';
			$iCounter = 1;

			if ($strCond)
			   $sql .= 'WHERE ';

			$cCond = count($strCond = explode(
					'&',$strCond));

			foreach ($strCond as $cnd){
				
				# TODO: Evaluar si viene una sentencia booleana
				$smblRel = $this->evalSimbolInSubQuery($cnd,true);
				
				if ($smblRel)
					list ($fCnd, $vCnd) = explode($smblRel,$cnd);
				
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

			if ($orderBy){
				$sql .= ' ORDER BY '.$orderBy;
				if ($orderMethod)
				   $sql .= ' '.$orderMethod;
			}else{
				$sql .= ' ORDER BY '.$this->tableStruct[$this->table]['pk'].' ';
			}

			if ($intLimit){
				switch ($this->engine){
					case 'mysql':
						$sql .= ' LIMIT 0, '.$intLimit;
						break;
					case 'postgre';
					    $sql .= ' LIMIT '.$intLimit.' OFFSET 0';
					break;
				}
			}

			$rF = $this->query($sql);

			if ($this->num_rows == 1){
				
				foreach ($rF[0] as $etq => $val){

					if (is_string($etq)){
						
					   $this->$etq = $val;
					}
				}
				
			}else{

				foreach ($rF as $row){
					
					$results[] = $this->buildRes($row);
				}
				
			}

		}else{
			//-> Find
			if (is_string($strCond))
				$strCond = '\''.$strCond.'\'';

			$sql .= 'SELECT '.$subSqlF.' FROM '
			.$this->table.' WHERE '
			.$this->tableStruct[$this->table]['pk'].' = '.$strCond;

			$rF = $this->query($sql);

			if ($this->num_rows){
				$this->keyFinded = $strCond;
				$rF = $rF[0];
					
				foreach ($rF as $etq => $val){
					if (is_string($etq)){
						$this->$etq = $val;
					}
				}
					
			}

		}
			
		return $results;
		
	*/	
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
			
		//return $subSqlF;
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

		$this->tableStruct[$tableName] = array();

		$pk = '';
		$ff = '';
			
		$resQuery = $this->dbh->query($sql = 'SELECT * FROM '.$tableName.' LIMIT 1');
		//echo $sql;
		
		foreach ($resQuery as  $res){
			$i=0;
			foreach ($res as $key => $value){
				//echo var_export($resQuery->getColumnMeta($i),true);
				$i+=1;
			}
		}
		
		$foo = 'Bob'; // Asigna el valor 'Bob' a $foo
		$bar = & $foo; // Referencia $foo vía $bar.
		$bar = "Mi nombre es $bar"; // Modifica $bar...
		echo $foo; // $foo también se modifica.
		echo $bar; 
		
		switch ($this->engine){
			case 'mysql':
				
				//$fields = $this->query('SHOW FIELDS FROM '.$tableName.'');
				/**
				 * TODO: Obtener solo la primera llave primaria
				 * Probar en mysql que obtenga la primera llave
				 * primaria encontrada. 
				 */
				
				/* 	
				foreach ($fields as $field){

					if (!$ff)
					   $ff = $field['Field'];
						
					$this->tableStruct[$tableName]['fields'][$field['Field']] = '';

					$this->tableStruct[$tableName]['types'][$field['Field']] =
					$field['Type'].' '.$field['Extra'];

					if ($field['Key']=='PRI'){
						$pk = $field['Field'];
					}else{
							
						if (!strcmp(strtolower($field['Field']),'id')){
							if (!$pk)
							   $pk = $field['Field'];
						}else{

							if (strripos($field['Field'],'id')!==false){
								if (!$pk)
								   $pk = $field['Field'];
							}
						}
					}
				}
				*/
					
				break;
			case 'postgre':
				/**
				 * TODO: Obtener solo la primera llave primaria
				 * Implementar a fututo la obtencion de resultados
				 * el tablas con mas de una llave primaria
				 */
				/* 	
				$sqlStruct = 'SELECT
					col.column_name AS campo
					,col.data_type as tipo
					,col.character_maximum_length as longitud
					,(SELECT
  					kcu.column_name
					FROM
  						information_schema.key_column_usage kcu
  					INNER JOIN information_schema.table_constraints AS tc ON (kcu.constraint_name = tc.constraint_name AND tc.table_name = kcu.table_name)
						WHERE kcu.table_name = \''.$tableName.'\'
						AND tc.constraint_type = \'PRIMARY KEY\' LIMIT 1 OFFSET 0) AS llave
 						FROM
 						information_schema.tables
    				INNER JOIN information_schema.columns AS col ON (col.table_name = information_schema.tables.table_name)
					WHERE
						information_schema.tables.table_name = \''.$tableName.'\'
					ORDER BY col.ordinal_position';
					
				$fields = $this->query($sqlStruct,false);

				foreach ($fields as $field){

					if (!$ff)
					   $ff = $field['campo'];
						
					$this->tableStruct[$tableName]['fields'][$field['campo']] = '';

					$this->tableStruct[$tableName]['types'][$field['campo']] =
					$field['tipo'].' '.$field['longitud'];

					if ($field['llave']){
						$pk = $field['llave'];
					}else{
							
						if (!strcmp(strtolower($field['campo']),'id')){
							if (!$pk)
							   $pk = $field['campo'];
						}else{

							if (strripos($field['campo'],'id')!==false){
								if (!$pk)
								   $pk = $field['campo'];
							}
							
						}
					}
					
				}
				*/	
				break;
		}

		/*
		if ($pk)
		   $this->tableStruct[$tableName]['pk'] = $pk;
		else
		   $this->tableStruct[$tableName]['pk'] = $ff;
		*/  
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
			
		switch($this->engine){
			case 'mysql':
				if ($this->link)
					mysql_close($this->link);
				break;
			case 'postgres':
				if ($this->link)
					pg_close ($this->link);
				break;
		}
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