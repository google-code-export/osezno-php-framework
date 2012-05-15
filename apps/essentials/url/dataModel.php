<?php
/**
 * Modelo del datos del Modulo.
 * - Acceso a datos de las bases de datos
 * - Retorna informacion que el Controlador muestra al usuario
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */

class readDirs {

	private $js = '';

	private $arNoShow = array(
 		'.',
 		'..',
 		'admtablas',
 		'admusr',
 		'bit',
 		'frames',
 		'public',
 		'logout',
 		'menu',
 		'options',
 		'passwd',
 		'profiles',
 		'scaffold',
 		'url',
 		'useronline',
 		'welcome'
	);

	private $id = 1;

	public function __construct ($path){

		$d = dir($path = $path);

		while (false !== ($entry = $d->read())) {

			if (!in_array($entry, $this->arNoShow)){

				if (is_dir($path.$entry)){

					$this->js .= "d.add(".$this->id.",0,'".$entry."','javascript:void(assignUrl(\'".$entry."\'))','','','".BASE_URL_PATH."common/js/essentials/img/folder.gif');\n";

					++$this->id;
				}
			}
		}

		$d->close();
	}

	public function returnJsTree (){
			
		return $this->js;
	}

}

?>