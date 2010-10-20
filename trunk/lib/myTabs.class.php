<?php
/**
 * myTabs
 *
 * @uses Creacion de pestanas
 * @package OSEZNO FRAMEWORK
 * @version 0.2.0
 * @author joselitohaCker
 *
 * La clase crea pestanas para uso de varias URLs dentro de una misma ventana
 *
 * Ultima actualizacion: 30 Enero 2007
 *
 * Control de Cambios:
 *
 */
class myTabs{

	/**
	 * Estilo que la opcion (pesatana) seleccionada usa
	 *
	 * @var string
	 */
	public $styleTabSelected = "celda_seleccionada";


	/**
	 * Estilo que usan todas las pestanas por defecto
	 *
	 * @var string
	 */
	public $styleTabOption = "celda_opcion";


	/**
	 * Estilo que usa la tabla padre
	 * Nota: Normalmente se usa para darle un borde inferior a las opciones
	 *
	 * @var string
	 */
	public $styleTableFather = "tabla_padre";


	/**
	 * Estilo que usa la tabla que encierra el iframe que
	 * muestra el contenido complementario
	 *
	 * @var string
	 */
	public $styleIframeSpace = "tabla_iframe";


	/**
	 * Estilo que usan los enlaces de las pestanas
	 *
	 * @var string
	 */
	public $styleLinks = "enlaces";


	/**
	 * Arreglo que contiene cada uno de los Nombres de las pes
	 * tanas que se estan generando.
	 *
	 * @var array
	 */
	private $arrayTabsId = array ();


	/**
	 * Contador que lleva la cuenta
	 * de el numero de Pestanas que
	 * se han agregado.
	 *
	 * @var integer
	 */
	private $intCounterIdTabs = 0;



	/**
	 * Alto del marco en Pixeles
	 *
	 * @var unknown_type
	 */
	private $intHeightFrame = 800;



	/**
	 * Setea el alto de el marco que contiene los contenidos
	 *
	 * @param int $intHeight Alto del marco en pixeles
	 */
	public function setHeightFrame ($intHeight = 800){
		$this->intHeightFrame = $intHeight;
	}


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
		$this->arrayTabsId[$this->intCounterIdTabs]['id_tab']  = $this->intCounterIdTabs;
		$this->arrayTabsId[$this->intCounterIdTabs]['etq_tab'] = $etqTab;
		$this->arrayTabsId[$this->intCounterIdTabs]['url_tab'] = $urlTab;

		$this->intCounterIdTabs+=1;
	}


	/**
	 * Obtiene el HTML de que genera las Tabs en la pagina
	 * o directamente en la plantilla
	 *
	 * @param string $scriptName Nombre del archivo que llama las pestanas
	 * @param mixed  $arrayGet   Arreglo super Global $_GET
	 * @return string
	 */
	public function getTabs($scriptName, $arrayGet){
		$html = '';

		$html .= '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">'."\n";
		$html .= '<tr>'."\n";
		$html .= '<td><table border="0" cellpadding="0" cellspacing="0" class="'.$this->styleTableFather.'" width="100%">'."\n";
		$html .= '<tr>'."\n";

		$html .= '<td>&nbsp;</td>'."\n";

		for ($i=0;$i<count($this->arrayTabsId);$i++){
			$html .= '<td>'."\n";
			if ($arrayGet['selectedTab'] == $i){
				$strClass = $this->styleTabSelected;
				$strURLiFrame = $this->arrayTabsId[$i]['url_tab'];
			}
			else{
				$strClass = $this->styleTabOption;
			}

			$html .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="'.$strClass.'">'."\n";
			$html .= '<tr><td><a class="'.$this->styleLinks.'" href="'.$scriptName.'?selectedTab='.$this->arrayTabsId[$i]['id_tab'].'">'.$this->arrayTabsId[$i]['etq_tab'].'</a></td></tr>'."\n";
			$html .= '</table>'."\n";
			$html .= '</td>'."\n";
			$html .= '<td>&nbsp;</td>'."\n";
		}


		$html .= '</tr>'."\n";
		$html .= '</table>'."\n";

		$html .= '<table width="100%" border="0" class="'.$this->styleIframeSpace.'">'."\n";
		$html .= '<tr>'."\n";
		$html .= '<td><iframe src="'.$strURLiFrame.'" width="100%" height="'.$this->intHeightFrame.'" scrolling="auto" frameborder="0"></iframe></td>'."\n";
		$html .= '</tr>'."\n";
		$html .= '</table>'."\n";

		return $html;
	}

}


?>