<?php


class OPF_myLang {
	
	public static function setLang ($lang){
		
		if (!isset($_SESSION['lang_in_use'])){

			$_SESSION['lang_in_use'] = $lang;
			
			include LANG_PATH;
			
			$_SESSION['lang_content'] = $lang_content;
			 
		}else{
			
			if ($_SESSION['lang_in_use']!=$lang){
			
				$_SESSION['lang_in_use'] = $lang;
				
				include ROOT_PATH. DS.'resources'.DS.'lang'.DS.$lang.'.php';

				$_SESSION['lang_content'] = $lang_content;
			}
			
		}
		
	}

	public static function getLang (){
		
		return (isset($_SESSION['lang_in_use']) ? '':$_SESSION['lang_in_use']);
	}
	
	public static function getPhrase ($sPhrase){
		
		return (isset($_SESSION['lang_content'][$sPhrase]) ? $_SESSION['lang_content'][$sPhrase]:'<b><i>The phrase is no defined</i></b>');
	} 
	
	
}