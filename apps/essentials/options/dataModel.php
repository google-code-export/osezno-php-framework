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

class struct_menu {

	private $js = "";

	private $maxCols = 0;

	private $arrItems = array();

	private $intCounter = 1;

	private $objESS;

	private function walkItems (){

		$this->objESS = new ESS_essentials();
			
		$ess_menu = new ess_menu();

		$ess_menu->setAutoQuotesInFind(false);
			
		$sql = 'SELECT ess_menu.id, ess_menu.description, ess_menu.url, ess_menu.icon, ess_menu.description FROM ess_menu INNER JOIN ess_profiles_detail ON (ess_profiles_detail.menu_id = ess_menu.id AND ess_profiles_detail.profiles_id = '.$_SESSION['profile_id'].') WHERE ess_menu.menu_id is NULL ORDER BY ess_menu.ord ASC';
			
		foreach ($ess_menu->query($sql) as $menuOpt){
				
			$url = '';

			$icon = '';

			if ($menuOpt->url){

				if (stripos($menuOpt->url,'?'))
					
				$url = $menuOpt->url.'&secure_opf_code='.$this->objESS->crypNumbers($menuOpt->id);
				else
					
				$url = $menuOpt->url.'?secure_opf_code='.$this->objESS->crypNumbers($menuOpt->id);
					
				$icon = $menuOpt->icon;
			}

			$this->js .= "d.add(".$menuOpt->id.",0,'".$menuOpt->description."','".$url."','".$menuOpt->description."','modulo','".$icon."');\n";

			$this->recurWalkItems($ess_menu,$menuOpt->id);
		}

	}

	private function recurWalkItems ($menu,$id){

		$sql = 'SELECT ess_menu.id, ess_menu.description, ess_menu.icon, ess_menu.url, ess_menu.description FROM ess_menu INNER JOIN ess_profiles_detail ON (ess_profiles_detail.menu_id = ess_menu.id AND ess_profiles_detail.profiles_id = '.$_SESSION['profile_id'].') WHERE ess_menu.menu_id = '.$id.' ORDER BY ess_menu.ord ASC';
			
		foreach ($menu->query($sql) as $row){

			$url = '';

			if ($row->url){

				if (stripos($row->url,'?'))
					
				$url = $row->url.'&secure_opf_code='.$this->objESS->crypNumbers($row->id);
				else
					
				$url = $row->url.'?secure_opf_code='.$this->objESS->crypNumbers($row->id);
			}

			$this->js .= "d.add(".$row->id.",".$id.",'".$row->description."','".$url."','".$row->description."','modulo','".$row->icon."');\n";

			$this->recurWalkItems($menu,$row->id);
		}

	}

	public function __construct(){
			
		$this->walkItems();
	}

	public function getJsMenu (){
			
		return $this->js;
	}

}

class ess_system_users extends OPF_myActiveRecord {

	public $id;

	public $user_name;

	public $name;

	public $lastname;

	public $passwd;

	public $status;

	public $profile_id;

	public $datetime;

}

?>