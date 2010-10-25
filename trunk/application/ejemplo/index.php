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
 

 $libros = new libros;
 
 //$libros->setPk('kik');
 

 $libros->beginTransaction();
 
 $libros->query('delete from librosa where id = 156');
 $libros->query('delete from libross where id = 157');

 if (!$libros->endTransaction()){
 	echo 'NO Se hizo la trans'."<br>";
 	//echo $libros->getSqlLog();
 }else{
 	echo 'Se hizo la trans'."<br>";
 }


 
 
 //echo $libros->getLastInsertId()."<br>";
 //echo $libros->getSqlLog()."<br>";
 //echo $libros->getErrorLog(true);
 
 //$libros->
 
 //foreach ($libros->find() as $row)
 	//echo $row->id." ".$row->nombre."<br>";

 /**
  * Asignar contenidos a areas de la plantilla
  */ 
 $objOsezno->assign('form_title','Cambiar este tituloo');
 //$objOsezno->assign('work_area',$modelo->builtList('idlis'));
 $objOsezno->call_template('basic/basic.tpl');
 	
/*
try {
 $conn = new PDO('mysql:dbname=ethos;host=localhost', 'root');
 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
 $conn->beginTransaction();
 $conn->exec('delete from libross where id = 156;');
 $conn->exec('delete from libros where id = 157;');
 print '<p>Transaction complete!</p>';
 $conn->commit();
}catch (PDOException $e) {
  print '<p>Unable to complete transaction!</p>'.$e->errorInfo[2];
  $conn->rollBack();
} 
*/
 
?>