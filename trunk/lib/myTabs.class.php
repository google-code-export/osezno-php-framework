<?php
/**
 * myTabs
 *
 * @uses Creacion de pestanas
 * @package OSEZNO FRAMEWORK (2008-2011)
 * @version 0.5
 * @author Jose Ignacio Gutierrez Guzman jose.gutierrez@osezno-framework.org
 *
 * La clase crea pestanas para uso de varias URLs dentro de una misma ventana
 *
 */
class myTabs{

	/**
	 * Arreglo que contiene cada uno de los Nombres de las pes
	 * tanas que se estan generando.
	 *
	 * @var array
	 */
	private $arrayTabs = array ();

	/**
	 * Se encarga de agregar nuevas pestanas al super arreglo
	 * que despues sera leido para contruir todo el HTML
	 * necesario para imprimirlo
	 *
	 * @param string $idTab
	 * @param string $etqTab
	 * @param string $urlTab
	 */
	public function addTab ($etqTab, $urlTab){
		
		$this->arrayTabs[$etqTab] = $urlTab;
	}

	/**
	 * Obtiene el HTML de que genera las Tabs en la pagina
	 * o directamente en la plantilla
	 *
	 * @return string
	 */
	public function getTabsHtml(){
		
		$html = '';

		$html .= '<table width="100%" border="0"><tr><td><div id="div_tab"><ul>';
		
		$i = 0;
		
		$couAr = count($this->arrayTabs);
		
		foreach ($this->arrayTabs as $etqTab => $urlTab){
			
			$html .= '<li id="tab'.$i.'"><a href="javascript:void(makeactive(\'tab'.$i.'\','.$couAr.',\''.$urlTab.'\'))">'.$etqTab.'</a></li>';
			
			$i++;
		}
		
		$html .= '</ul></div></td></tr><tr><td><div id="content_tab"></div></td></tr></table>';
		
		return $html;
	}

}


?>