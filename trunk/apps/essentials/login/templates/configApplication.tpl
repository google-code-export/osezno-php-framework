<?php
/**
 * Configuración de OPF.
 * 
 * @author: José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */

# Aplicación por defecto 

/**
 * Aplicacion por defecto que administra la vista inicial
 * 
 * @var string
 */
$default_app = 'essentials';

/**
 * Modulo de aplicacion por defecto que se cargara si no es llamado
 * 
 * @var string
 */
$default_mod = 'login';

# Conexión a base de datos.

/**
* Motor de base de datos; pgsql ó mysql.
* 
* @var string
*/
$engine = '{db_engine}';

/**
 * Nombre de base de datos.
 * 
 * @var string
 */
$database = '{db_name}';

/**
 * Direccion Ip o nombre de maquina del motor de base de datos.
 * 
 * @var string
 */
$host = '{db_host}';

/**
 * Nombre de usuario para conexion a base de datos.
 * 
 * @var string
 */
$user = '{db_user}';

/**
 * Contraseña de usuario para conexión a base de datos.
 * 
 * @var string
 */
$password = '{db_password}';

/**
 * Puerto para la conexión, Mysql 3306, Postgre 5432.
 * 
 * @var integer
 */
$port = '{db_port}';


#Ajax Engine

/**
 * Motor de ajax que va a usar en el framework
 *
 * @var string
 */
$ajax_engine = 'xajax';

/**
 * Atributos de cada motor de ajax
 * 
 * @var array
 */
$ajax_conf = array (

	'xajax' => array (
	
		'debug' => false,
		
		'decodeUTF8Input' => true,
		
		'wrapper_prefix' => ''
	)
);

# Zona horaria

/**
 * Zona horaria para php
 * 
 * @var string
 */
$timezone = 'America/Bogota';

# Codificación por defecto

/**
 * Codificacion de caracteres por defecto
 * 
 * @var string
 */
$default_charset = 'utf-8';

# Diseño y Vista

/**
 * Idioma que se va a usar en las etiquetas de los objetos. (spanish, english) (resources/lang/)
 * 
 * @var string
 */
$lang = 'spanish';

/**
 * Tema actual de estilos. (themes/)
 * 
 * @var string
 */
$theme = 'osezno';

# Variables de sesión

/**
 * Nombre de cookie referencia de las sesiones de OPF.
 * 
 * @var string
 */
$sessionName = 'oseznophp';

/**
 * Caducidad en segundos en cache para la sesión.
 * 
 * @var string
 */
$sessionCacheExpire = 3600;

?>