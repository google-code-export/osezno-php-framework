<?php
/**
 * Vista inicial.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */

/**
 * Asignar contenidos a areas de la plantilla
 */

OPF_osezno::assign('path_js_tree', BASE_URL_PATH);

if (isset($_SESSION['profile_id'])){

	$struct_menu = new struct_menu;

	OPF_osezno::assign('menu_struct',$struct_menu->getJsMenu());
}

$ess_system_users = new ess_system_users;

$ess_system_users->find($_SESSION['user_id']);

OPF_osezno::assign('user_login',OPF_LOGIN_31.'&nbsp;'.$ess_system_users->name);

OPF_osezno::assign('open_all',OPF_OPTIONS_1);

OPF_osezno::assign('close_all',OPF_OPTIONS_2);

OPF_osezno::assign('home_etq','&nbsp;<b>'.APP_DESC.'</b>');


if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') === FALSE) {

	OPF_osezno::assign('essentials','OseznoPHP');
}


/**
 * Mostrar la plantilla
 */
OPF_osezno::call_template('options'.DS.'options.tpl');

?>