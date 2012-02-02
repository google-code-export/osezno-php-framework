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

 
 /**
  * Asignar contenidos a areas de la plantilla
  */
 $OPF_passwd = new OPF_passwd;
 
 $objOsezno->assign('nom_modulo',htmlentities(OPF_PASSWD_TITLE));
 
 $objOsezno->assign('desc_modulo',htmlentities(OPF_PASSWD_DESC));
 
 $objOsezno->assign('content1',$OPF_passwd->getFormChngPasswd());
 
  
 /**
  * Mostrar la plantilla
  */
 $objOsezno->call_template('modulo/modulo.tpl');
 
?>