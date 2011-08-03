<?php
/**
* myControllerExt
*
* @internal
* @uses Controlador de eventos
* @package	OPF
* @version 0.1
* @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
*
*/
class OPF_myControllerExt {

	/**
	 * Obtener HTML desde plantilla.
	 *
	 * Retorna un contenido HTML desde un archivo plano
	 * @param $file	Nombre del archivo fisico
	 * @param $arrayReplacement	Arreglo con valores que desea reemplazar
	 * @return string
	 */
	protected function loadHtmlFromFile ($file, $arrayReplacement = ''){

		$gestor = fopen($file, 'r');

		$contenido = fread($gestor, filesize($file));

		if (is_array($arrayReplacement)){
			$arrayKeys = array_keys($arrayReplacement);
				
			$contenido = str_ireplace ( $arrayKeys, $arrayReplacement, $contenido);
		}

		fclose($gestor);

		return $contenido;
	}

}

?>