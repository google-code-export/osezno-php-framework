<?php
/**
 * Configuración de OPF.
 * Osezno PHP Framework es una herramienta libre
 * @author: José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */

# Aplicación por defecto 

/**
 * Aplicación por defecto que administra la vista inicial
 * 
 * @var string
 */
$default_app = 'essentials';

/**
 * Modulo de aplicacion por defecto que se cargara si no es llamado
 * 
 * @var string
 */
$default_mod = 'public';

#Auto detectar subdominio

/**
 * Auto detectar subdominio para dedireccionar a la aplicacion secundaria/alerna
 * 
 * @var string
 */
$autodetect_subdomain = true;

# Conexión a base de datos por cada aplicación.

/**
 * [engine] Motor de base de datos; pgsql ó mysql.
 * [database] Nombre de la base de datos.
 * [host] Direccion Ip o nombre de maquina del motor de base de datos.
 * [user] Nombre de usuario para conexion a base de datos.
 * [password] Contraseña de usuario para conexión a base de datos.
 * [port] Puerto para la conexión, Mysql 3306, Postgre 5432.
 * 
 * @var array
 */
$pull_connect = array (

	'www' => 
		
		array (
		
			'engine' => '',
		
			'database' => '',
		
			'host'	=> '',
		
			'user'	=> '',
		
			'password'	=> '',
		
			'port' => ''
		
		),
		
	'essentials' => 

		array (
		
			'engine' => '{db_engine}',
		
			'database' => '{db_name}',
		
			'host'	=> '{db_host}',
		
			'user'	=> '{db_user}',
		
			'password'	=> '{db_password}',
		
			'port' => '{db_port}'
		
		)

);

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

/**
 * Nombre de directorio donde se leen los archivos de sesión, no colocar '/'
 *
 * @var string 
 */
 $sessionPathFolder = 'sess';

?>