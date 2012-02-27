<?php
/**
 * Vista inicial.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
include 'handlerEvent.php';


/**
 * Asignar contenidos a areas de la plantilla
 */

if (isset($_SESSION['profile_id'])){

	$struct_menu = new struct_menu;

	$objOsezno->assign('menu_struct',$struct_menu->getJsMenu());
}

$ess_system_users = new ess_system_users;

$ess_system_users->find($_SESSION['user_id']);

$objOsezno->assign('user_login',OPF_LOGIN_31.'&nbsp;'.$ess_system_users->name);

$objOsezno->assign('open_all',OPF_OPTIONS_1);

$objOsezno->assign('close_all',OPF_OPTIONS_2);

$objOsezno->assign('home_etq','&nbsp;<b>'.APP_DESC.'</b>');


if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') === FALSE) {

	$objOsezno->assign('essentials','OseznoPHP');
}


/**
 * Mostrar la plantilla
 */
$objOsezno->call_template('options/options.tpl');

?>