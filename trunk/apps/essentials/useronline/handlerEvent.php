<?php
/**
 * Menjador de eventos de usuario.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */

/**
 * Manejador de eventos de usuario
 *
 */
class controller extends OPF_myController {

	public function closeSessionOnUser ($id){
			
		$ess_usronline = new ess_usronline;
			
		$exito = false;
			
		$ess_usronline->find($id);
			
		if (@unlink(session_save_path().'/'.$ess_usronline->sesname))

			$exito = true;
			
		$ess_usronline->delete($id);
			
		if ($exito){

			$this->notificationWindow(OPF_myLang::getPhrase('OPF_USRONLINE_1'),5,'ok');

			$this->MYLIST_reload('users_on_line');

		}else

		$this->notificationWindow(OPF_myLang::getPhrase('OPF_USRONLINE_2'),5,'error');
			
		return $this->response;
	}


}

?>