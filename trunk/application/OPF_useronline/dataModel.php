<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2011  
   * @version: 0.1
   * @author: Oscar Eduardo Aldana 
   * @author: José Ignacio Gutiérrez Guzmán
   * 
   * developer@osezno-framework.org
   * 
   * dataModel.php: 
   * Modelo del datos del Modulo
   * - Acceso a datos de las bases de datos
   * - Retorna informacion que el Controlador muestra al usuario
   */

  include '../../config/configApplication.php';
 
 
 class user_on_line {

 	public $arraySessUser;
 	
 	public $arraySessWeb;
 	 	
 	public function __construct(){
 		
 		$this->arraySessWeb = 0;
 		
 		$this->arraySessUser = 0;
 	}
 	
 	public function buildFiles(){
 		
 		$ess_usronline = new ess_usronline;
 		
 		$ess_usronline->query('DELETE FROM ess_usronline');
 		
 		$datSesAct = session_encode();
 		
		$d = dir($session_path = session_save_path());
		
		while (false !== ($entry = $d->read())) {
   
			$session_file_name = $session_path.'/'.$entry;
			
			if (is_readable($session_file_name)){
				
				if (is_file($session_file_name)){
				
					$arVarSes = array();
					
					$filesize = filesize($session_file_name);
					
						if ($filesize>20){
							
							$_SESSION['datetime'] = $_SESSION['ip'] = $_SESSION['user_id'] = '';
							
							$cont = '';
							
							$f = fopen($session_file_name, 'r');
						
							$cont = fread($f, $filesize);
							
							fclose($f);
							
							session_decode($cont);
							
							if ($_SESSION['user_id'] != ""){
								
								$ess_usronline->usuario_id = $_SESSION['user_id'];
						
								$ess_usronline->ip = $_SESSION['ip'];
						
								$ess_usronline->sesname = $entry;
						
								$ess_usronline->size = intval($filesize/1024);
						
								$ess_usronline->filectime =  date("Y-m-d H:i:s",filectime($session_file_name));
							
								$ess_usronline->datetime = $_SESSION['datetime'];
								
								$ess_usronline->save();
							}	
							
						}
						
					session_decode($datSesAct);
						
				}
			}
		}
		
		$d->close();
 	}
 	
 	public function buildDinamicListUsersOnLine (){
 		
 		$actRecord = new OPF_myActiveRecord;
 		
 		$arrRpl = array (
 		
 			'OPF_FIELD_CERRAR' => OPF_FIELD_CERRAR,
 			
 			'OPF_FIELD_USUARIO' => OPF_FIELD_USUARIO,
 			
 			'OPF_FIELD_IP' => OPF_FIELD_IP,

 			'OPF_FIELD_INGRESO' => OPF_FIELD_INGRESO,
 			
 			'OPF_FIELD_FILE' => OPF_FIELD_FILE,
 			
 			'OPF_FIELD_PESO' => OPF_FIELD_PESO,
 			
 			'OPF_FIELD_ACTUALIZADO' => OPF_FIELD_ACTUALIZADO
 		
 		);
 		
 		$myList = new OPF_myList('users_on_line',$actRecord->loadSqlFromFile('sql/user_online.sql',$arrRpl));
 		
 		$myList->setWidthColumn(OPF_FIELD_CERRAR, 60);
 		
 		$myList->setWidthColumn(OPF_FIELD_USUARIO, 150);
 		
 		$myList->setWidthColumn(OPF_FIELD_IP, 150);
 		
 		$myList->setWidthColumn(OPF_FIELD_INGRESO, 150);
 		
 		$myList->setWidthColumn(OPF_FIELD_FILE, 200);
 		
 		$myList->setWidthColumn(OPF_FIELD_PESO, 100);
 		
 		$myList->setWidthColumn(OPF_FIELD_ACTUALIZADO, 90);
 		
 		$myList->setRealNameInQuery(OPF_FIELD_USUARIO, 'ess_system_users.user_name');
 		
 		$myList->setRealNameInQuery(OPF_FIELD_IP, 'ess_usronline.ip');
 		
 		$myList->setRealNameInQuery(OPF_FIELD_INGRESO, 'ess_usronline.datetime');
 		
 		$myList->setRealNameInQuery(OPF_FIELD_FILE, 'ess_usronline.sesname');
 		
 		$myList->setRealNameInQuery(OPF_FIELD_PESO, 'ess_usronline.size');
 		
 		$myList->setRealNameInQuery(OPF_FIELD_ACTUALIZADO, 'ess_usronline.filectime');
 		
 		$myList->width = 900;
 		
 		$myList->setEventOnColumn(OPF_FIELD_CERRAR, 'closeSessionOnUser',OPF_USRONLINE_3);
 		
 		$myList->setExportData(true,true,true);
 		
 		$myList->setUseOrderMethod(true,OPF_FIELD_INGRESO);
 		
 		return $myList->getList(true,true);

 	}
 	
 }
 
 class ess_usronline extends OPF_myActiveRecord {
 	
 	public $id;
 	
 	public $usuario_id;
 	
 	public $ip;
 	
 	public $sesname;
 	
 	public $size;
 	
 	public $filectime;

 	public $datetime;
 }
 
 
 
?>