<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2011  
   * @version: 0.1
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
 
 class testInstall {
 
 	public static function getInfoOPF (){
 		
 		$myForm = new OPF_myForm('frm_info_OPF');
 		
 		$myForm->styleClassForm = '';
 		
 		$myForm->addFreeObject('version1','Framework Version:',FRAMEWORK_VERSION);
 		
 		$myForm->addFreeObject('version2','PHP Version:',PHP_VERSION);
 		
 		$myForm->addGroup('version','Versions:',array('version1','version2'),1);
 		
 		$myForm->addFreeObject('path1','URL Project:',$GLOBALS['urlProject']);
 		
 		$myForm->addFreeObject('path2','PATH Project:',$GLOBALS['folderProject']);
 		
 		$myForm->addFreeObject('path3','PATH Templates:',PATH_TEMPLATES);
 		
 		$myForm->addFreeObject('path4','PATH Sessions:',session_save_path());
 		
 		$myForm->addGroup('paths','Paths:',array('path1','path2','path3','path4'));

 		$myForm->addGroup('enviroments','Enviroment:',array('enviroment1','enviroment2'),1);
 		
 		$myForm->addFreeObject('enviroment1','Theme:',THEME_NAME);
 		
 		$myForm->addFreeObject('enviroment2','Lang:',LANG);
 		
 		$myForm->addGroup('sessions','Sessions:',array('sess2','sess3'),1);
 		
 		$myForm->addFreeObject('sess2','Cache expire:',session_cache_expire());
 		
 		$myForm->addFreeObject('sess3','Session name:',session_name());

 		$myForm->addFreeObject('db1','Engine:',$GLOBALS['MYACTIVERECORD_PARAMS']['engine']);
 		
 		$myForm->addFreeObject('db2','Database:',$GLOBALS['MYACTIVERECORD_PARAMS']['database']);
 		
 		$myForm->addFreeObject('db3','Host:',$GLOBALS['MYACTIVERECORD_PARAMS']['host']);
 		
 		$myForm->addFreeObject('db4','User:',$GLOBALS['MYACTIVERECORD_PARAMS']['user']);
 		
 		$myForm->addFreeObject('db5','Port:',$GLOBALS['MYACTIVERECORD_PARAMS']['port']);
 		
 		$myForm->addButton('btn_test_connect','Test','ok.gif');
 		
 		$myForm->addGroup('database','Database:',array('db1','db2','db3','db4','db5','btn_test_connect'));

 		$myForm->addEvent('btn_test_connect', 'onclick', 'onClickTestDB');
 		
 		$myForm->groupGroups(array('version','enviroments','sessions'));
 		
 		$myForm->width = 750;
 		
 		return $myForm->getForm();
 	}  
 	
 	
 }
 
 
 
 
 
?>