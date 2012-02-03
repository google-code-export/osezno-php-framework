<?php
/**
 * Vista inicial.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2011 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
 include 'handlerEvent.php';


 $zipFile = new ZIP_zipfile();
 
 $zipFile->add_dir($_GET['namefolder'].'/');
 
 $zipFile->add_file($_SESSION['SCAFF_TEMP_ZIP_FILES_C']['index'], $_GET['namefolder'].'/index.php');
 
 $zipFile->add_file($_SESSION['SCAFF_TEMP_ZIP_FILES_C']['handler'], $_GET['namefolder'].'/handlerEvent.php');
 
 $zipFile->add_file($_SESSION['SCAFF_TEMP_ZIP_FILES_C']['data'], $_GET['namefolder'].'/dataModel.php');
 
 header("Content-type: application/octet-stream");
 
 header("Content-disposition: attachment; filename=".$_GET['namefolder'].".zip");
 
 if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")){
 
 	header('Pragma: private');
 
 	header('Cache-control: private, must-revalidate');
 }
 
 unset($_SESSION['SCAFF_TEMP_ZIP_FILES_C']);
 
 echo $zipFile->file();
 

?>