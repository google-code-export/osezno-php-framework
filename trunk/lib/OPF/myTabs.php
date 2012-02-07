<?php
/**
 * myTabs
 *
 * @uses Creacion de pestanas
 * @package OPF
 * @version 0.5
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 *
 * La clase crea pestanas para uso de varias URLs dentro de una misma ventana
 *
 */
class OPF_myTabs{

	/**
	 * Arreglo que contiene cada uno de los Nombres de las pes
	 * tanas que se estan generando.
	 *
	 * @var array
	 */
	private $arrayTabs = array ();

	private $id_tabs = '';

	/**
	 * Contrucctor de la clase.
	 *
	 * Contrucctor de la clase.
	 * <code>
	 *
	 * Ejemplo:
	 * <?php
	 *
	 * $myTabs = new OPF_myTabs('grupo_opciones_1');
	 *
	 * echo $myTabs->getTabsHtml();
	 *
	 * ?>
	 *
	 * </code>
	 * @param string $id_tabs Nombre del grupo de pestañas.
	 */
	public function __construct($id_tabs = ''){

		if (!$id_tabs){

			$id_tabs = 'n';
				
			$id_tabs .= rand(0, 100000);
		}

		$this->id_tabs = $id_tabs;

		if (!isset($GLOBALS['OF_TABS_ID_SEC'])){
				
			global $OF_TABS_ID_SEC;
				
			$GLOBALS['OF_TABS_ID_SEC'] = 1;
		}
	}

	/**
	 * Agrega una pestaña a la salida.
	 *
	 * Se encarga de agregar nuevas pestanas a la salida HTML.
	 * Si se apunta a un script este debe estar al mismo nivel si se quieren preservar los eventos declarados.
	 * Un archivo HTML puede incluirse desde cualquier ruta publica del servidor.
	 * <code>
	 *
	 * Ejemplo:
	 *
	 * <?php
	 *
	 * $myTabs = new OPF_myTabs;
	 *
	 * $myTabs->addTab('Opción A','a.php');
	 *
	 * $myTabs->addTab('Opción B','../b.html');
	 *
	 * echo $myTabs->getTabsHtml();
	 *
	 * ?>
	 *
	 * </code>
	 * @param string $etqTab Etiqueta.
	 * @param string $urlTab Url interna.
	 */
	public function addTab ($etqTab, $urlTab){

		$this->arrayTabs[$etqTab] = $urlTab;
	}

	/**
	 * Obtiene las pestañas.
	 *
	 * Obtiene el HTML para imprimir las pestañas o insertalas en una plantilla.
	 * <code>
	 *
	 * tabs.tpl
	 * <html>
	 * <head>
	 * </head>
	 * <body>
	 * <div align="center">{tabs_a}</div>
	 * <div align="center">{tabs_b}</div>
	 * </body>
	 * </html>
	 *
	 * index.php
	 * <?php
	 *
	 * include 'handlerEvent.php';
	 *
	 * $myTabsA = new OPF_myTabs('primergrupo');
	 *
	 * $myTabsA->addTab('Opción A','a.php');
	 *
	 * $myTabsA->addTab('Opción B','b.php');
	 *
	 * $objOsezno->assign('tabs_a',$myTabsA->getTabsHtml('Opción A'));
	 *
	 * // Podemos crear los grupos de pestañas que necesitemos.
	 *
	 * $myTabsB = new OPF_myTabs;
	 *
	 * $myTabsB->addTab('Opción C','c.php');
	 *
	 * $myTabsB->addTab('Opción D','d.php');
	 *
	 * // Es posible mostrar por defecto una pestaña al cargar el HTML.
	 *
	 * $objOsezno->assign('tabs_b',$myTabsB->getTabsHtml('Opción D'));
	 *
	 * $objOsezno->call_template('tabs.tpl');
	 *
	 * ?>
	 * </code>
	 * @param string $tabDefa Nombre pestaña por defecto
	 * @return string
	 */
	public function getTabsHtml($tabDefa = ''){

		$script = '';

		$html = '';

		$script .= "\n".'<script type="text/javascript">'."\n";

		$html .= '<table width="100%" border="0"><tr><td><div id="div_tab"><ul>'."\n";

		$from = $i = $GLOBALS['OF_TABS_ID_SEC'];

		$couAr = count($this->arrayTabs);

		$idTabDef = '';

		$idDiv = $this->id_tabs.'_content';

		$paramsAllTabs = '\''.$idDiv.'\',';

		$htmlDivTabs = '';

		$selTabDefa = false;

		foreach ($this->arrayTabs as $etqTab => $urlTab){
				
			if (stripos($urlTab,'?')){
					
				$urlTab.='&no_load_xajax=true';
			}else{

				$urlTab.='?no_load_xajax=true';
			}
				
			if (isset($_GET['secure_opf_code'])){

				$urlTab.='&secure_opf_code='.$_GET['secure_opf_code'];
			}
				
			$script .= "\t".'var '.$this->id_tabs.'_myTab'.ucfirst(etqFormat($etqTab)).' = new Array(\''.$this->id_tabs.'_tab'.$i.'\','.$from.','.$couAr.',\''.$urlTab.'\',\'div_cont_'.$this->id_tabs.'_tab'.$i.'\', \''.$this->id_tabs.'\');'."\n";
				
			$display = 'none';
				
			$classTab = '';
				
			if (!$selTabDefa){
					
				if ($tabDefa == $etqTab){
						
					$idTabDef = $i;

					$display = '';

					$selTabDefa = true;
						
					$classTab = 'current';

				}else if(!$tabDefa){

					$display = '';

					$selTabDefa = true;
						
					$classTab = 'current';
				}

			}
				
			$html .= '<li id="'.$this->id_tabs.'_tab'.$i.'" class="'.$classTab.'"><span onclick="makeactive(\''.$this->id_tabs.'_tab'.$i.'\', '.($from).'   ,'.$couAr.',\''.$urlTab.'\',\'div_cont_'.$this->id_tabs.'_tab'.$i.'\', \''.$this->id_tabs.'\')">'.$etqTab.'</span></li>'."\n";

			$htmlDivTabs .= '<div style="display:'.$display.'" id="div_cont_'.$this->id_tabs.'_tab'.$i.'"></div>';

			$i++;
				
			$paramsAllTabs .= $this->id_tabs.'_myTab'.ucfirst(etqFormat($etqTab)).', ';
		}

		$html .= '</ul></div></td></tr><tr><td><div id="'.$idDiv.'">'.$htmlDivTabs.'</div></td></tr></table>'."\n";

		$html .= '<script type="text/javascript" charset="UTF-8">loadAllTabs(';

		$html .= substr($paramsAllTabs,0,-2);

		$html .= ');</script>'."\n";

		$GLOBALS['OF_TABS_ID_SEC'] = $i+1;
			
		$script .= '</script>'."\n";

		return $script.$html;
	}

}

?>