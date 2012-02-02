<?php
/**
 * Vista inicial.
 *
 * @author Jos� Ignacio Guti�rrez Guzm�n <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2011 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
 include 'handlerEvent.php';

 
 /**
  * Asignar contenidos a areas de la plantilla
  */ 
 $objOsezno->assign('nom_modulo',htmlentities(OPF_SCAFF_TITLE));
 
 $objOsezno->assign('desc_modulo',htmlentities(OPF_SCAFF_DESC));
 
 $objOsezno->assign('content1',scaffold::formStartUp());
  
 /**
  * Mostrar la plantilla
  */
 $objOsezno->call_template('scaffold/modulo.tpl');

?>