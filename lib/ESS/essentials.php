<?php

class ESS_essentials {

	private $strModName = '';

	private $limitLenghtCharCryp = 50;

	public function getModName (){
			
		return $this->strModName;
	}

	public function registerAccess ($register){
			
		if ($register){
				
			$ess_bit = new ess_bit;

			$ess_bit->ip = $_SERVER['REMOTE_ADDR'];

			$ess_bit->url = $_SERVER['PHP_SELF'];

			$user_id = NULL;
				
			if (isset($_SESSION['user_id']))
				
			$user_id = $_SESSION['user_id'];
				
			$ess_bit->usuario_id = $user_id;
				
			$ess_bit->datetime = date("Y-m-d H:i:s");
				
			$ess_bit->save();
		}
	}

	private $arrayAlphaNumeric = array (
			1,2,3,4,5,6,7,8,9,0,
 	  		'a','b','c','d','e','f',
 	  		'g','h','i','j','k','l',
 	  		'm','o','p','q','r','s',
 	  		't','u','v','w','x','y','z',
 	  		'A','B','C','D','E','F',
 	  		'G','H','I','J','K','L',
 	  		'M','O','P','Q','R','S',
 	  		'T','U','V','W','X','Y','Z'
	);

	private function genBaseCrypData (){

		if (!isset($_SESSION['key_cryp_data'])){

			$_SESSION['key_cryp_data'] = array();

			$_SESSION['base_key_cryp_data'] = array();

			$count = count($this->arrayAlphaNumeric)-1;

			$i = 0;

			while ($i <= $count){
					
				$rand = rand(0,$count);
					
				if (!in_array($this->arrayAlphaNumeric[$rand],$_SESSION['base_key_cryp_data']))

				$_SESSION['base_key_cryp_data'][] = $this->arrayAlphaNumeric[$rand];

				else
					
				$i++;
					
			}
				
			$base = '';
				
			for($i=0;$i<$this->limitLenghtCharCryp;$i++)

			$base .= rand(0,9);

				
			$_SESSION['key_cryp_data'] = $base;
		}

		return $_SESSION['key_cryp_data'];
	}

	public function crypNumbers ($data){
			
		$crypData = '';

		$data = trim($data);

		$strlen = strlen($data);

		$base = $this->genBaseCrypData();

		for ($i=0;$i<$strlen;$i++)

		$crypData .= $_SESSION['base_key_cryp_data'][substr($data,$i,1) + substr($base,$i,1)];

		return $crypData;
	}

	public function unCrypNumbers($crypData){
			
		$data = '';

		$flip = array_flip($_SESSION['base_key_cryp_data']);

		$length = strlen($crypData);

		$base = $this->genBaseCrypData();

		for ($i=0;$i<$length;$i++)

		$data .=  $flip[substr($crypData,$i,1)] - substr($base,$i,1);

		return $data;
	}

	public function isOwnerOnMod ($menu_id){
			
		$ess_profiles_detail = new ess_profiles_detail;
			
		// Mejorar para encontar una similitud con el script
		$ess_profiles_detail->find('menu_id = '.$menu_id.' & profiles_id = '.$_SESSION['profile_id']);
			
		$ess_menu = new ess_menu;
			
		$ess_menu->find($menu_id);
			
		$this->strModName = $ess_menu->description;
			
		return $ess_profiles_detail->getNumRowsAffected();
	}

}

class ess_menu extends OPF_myActiveRecord {

	public $id;

	public $menu_id;

	public $description;

	public $icon;

	public $url;

	public $ord;

	public $usuario_id;

	public $datetime;

}

class ess_profiles_detail extends OPF_myActiveRecord {

	public $id;

	public $profiles_id;

	public $menu_id;

}

class ess_bit extends OPF_myActiveRecord {

	public $id;

	public $ip;

	public $url;

	public $usuario_id;

	public $datetime;
}

?>