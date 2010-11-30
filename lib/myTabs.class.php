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
	 * @param string $tabDefa Tab por defecto
	 * @return string
	 */
	public function getTabsHtml($tabDefa = ''){
		
		$html = '';

		$html .= '<table width="100%" border="0"><tr><td><div id="div_tab"><ul>';
		
		$i = 0;
		
		$couAr = count($this->arrayTabs);
		
		$idTabDef = '';
		
		foreach ($this->arrayTabs as $etqTab => $urlTab){
			
			$html .= '<li id="tab'.$i.'"><span onclick="makeactive(\'tab'.$i.'\','.$couAr.',\''.$urlTab.'\')">'.$etqTab.'</span></li>';
			
			if ($tabDefa == $etqTab)
				$idTabDef = $i;
			
			$i++;
		}
		
		$html .= '</ul></div></td></tr><tr><td><div id="content_tab"></div></td></tr></table>';
		
		if ($tabDefa)
			$html .= '<script type="text/javascript">makeactive(\'tab'.$idTabDef.'\','.($i).',\''.$this->arrayTabs[$tabDefa].'\')</script>';
		
		return $html;
	}

}


?>