<?php

	define('APP_DESC','OPF Essentials');

	define('SHOW_WELCOME_MESSAGE',true);
	
	$urlRedirect =  $GLOBALS['urlProject'].'application/OPF_logout/';
	
	# Modulos de acceso abierto
	$openAccess = array (
		
		'/application/index.php',
	
		'/OPF_login/',
		
		'/OPF_logout/',
		
		'/OPF_login/firstTime.php',
	 
		'/OPF_options/',
	 
		'/application/downloadQuery.php',
	
		'/application/calendarCaller.php',
	
		'/application/myListHelp.php',
	
		'/OPF_menu/url.php',
	
		'/OPF_welcome/'
		
	);

	function showErrorAccess ($error, $detalle){
		
		$errorR = '<html><head><style type="text/css">'.OPF_osezno::$cssErrors.'</style></head><body>';
		
		$errorR .= '<div class="error"><b>'.ERROR_LABEL.':</b>&nbsp;'.htmlentities($error).'<br><div class="error_detail"><b>'.ERROR_DET_LABEL.'</b>:&nbsp;'.htmlentities($detalle).'</div></div>';
		
		$errorR .= '</body></html>';
		
		return $errorR; 
	}
	
	
	function validateAccess ($executed, $openAccess, $urlRedirect, $ESS_essentials){
		
		$isOpenAccess = false;
		
		foreach ($openAccess as $path){
			
			if (stripos($executed, $path)!==false){
				
				$isOpenAccess = true;
				
				break;
			}
			
		}
		
		
		if ($isOpenAccess){
				
			
				
		}else{
			
			if (isset($_SESSION['user_id'])){
					
				if (isset($_GET['secure_opf_code'])){
					
					if (!$ESS_essentials->isOwnerOnMod($ESS_essentials->unCrypNumbers($_GET['secure_opf_code']))){
						
						die(showErrorAccess(OPF_ACCESS_NOT_PERMITED_ERROR, OPF_ACCESS_NOT_PERMITED_DETAIL));
					}
					
				}else{
					
					die(showErrorAccess(OPF_ACCESS_NOT_VERIFY_ERROR, OPF_ACCESS_NOT_VERIFY_DETAIL));
				}
				
			}else{
				
				header ('Location: '.$urlRedirect);
			}
			
		}
		
	}
	
	$ESS_essentials = new ESS_essentials;
	
	if (!isset($_SESSION['register_access'])){
		
		$_SESSION['register_access'] = false;
	}
	
	$ESS_essentials->registerAccess($_SESSION['register_access']);
	
	validateAccess($_SERVER['PHP_SELF'],$openAccess,$urlRedirect, $ESS_essentials);

?>