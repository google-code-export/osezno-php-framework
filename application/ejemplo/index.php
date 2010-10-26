<?php
  /**
   * @package OSEZNO PHP FRAMEWORK
   * @copyright 2007-2009  
   * @version: 0.1.5
   * @author: Oscar Eduardo Aldana 
   * @author: José Ignacio Gutiérrez Guzmán
   * developer@osezno-framework.com
   * 
   * index.php: 
   * Vista inicial.
   */
 include 'handlerEvent.php';
 
 $users = new users;
 
 if (!$users->isSuccessfulConnect())
 	echo $users->getErrorLog(true);
 else	
 	echo 'Bien';	
 
/*
 $libros = new libros;
 
 $libros->beginTransaction();
 
 $libros->query('delete from libross where id = 153');
 $libros->query('delete from libros where id = 154');

 if (!$libros->endTransaction()){
 	echo 'NO Se hizo la trans '."<br>".$libros->getErrorLog()."<br>".$libros->getSqlLog()."<br>";
 }else{
 	echo 'Se hizo la trans '."<br>".$libros->getErrorLog()."<br>".$libros->getSqlLog()."<br>";
 }
*/

 

 /**
  * Asignar contenidos a areas de la plantilla
  */ 
 $objOsezno->assign('form_title','Cambiar este titulo');
 //$objOsezno->assign('work_area',$modelo->builtList('idlis'));
 $objOsezno->call_template('basic/basic.tpl');
 	
 
 /*
 error_reporting(-1);

  try {
  	
	$conn = new PDO("pgsql:host=192.168.30.10;dbname=test",'postgresql','postgresql');
	
  } catch (PDOException $e) {
  	
    echo $e->getMessage();
    
  }

/*  
    try {
    	
	    $conn->beginTransaction(); 
    
    	$conn->exec("INSERT INTO users (user) VALES ('JOSELITRON')");
    	
    	$conn->commit();
     
    	
	} catch (PDOException $e) {
    
    	$conn->rollback(); 

    	echo "Error: ", $e->getMessage();
	}  
*/
  
?> 