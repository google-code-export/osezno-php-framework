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

	/**
	 * Acepta el porceso de crear el arhivo de configuracion automaticamente.
	 * 
	 * @param  $datForm
	 * @return string
	 */
	public function onClickCreateConfig ($datForm){
		
		$link = fopen(CONF_PATH, 'w');
		
		$writeError = false;
		
		if ($link){
		
			$OPF_login = new OPF_login;
			
			$cont = $OPF_login->readTemplate(APP_PATH.'essentials/public/templates/configApplication.tpl', array(
				
			 	'{db_name}'=>$datForm['db'],
				
			 	'{db_engine}'=>$datForm['engine'],
				
			 	'{db_host}'=>$datForm['host_db'],
				
			 	'{db_user}'=>$datForm['user_db'],
			 		
				'{db_password}'=>$datForm['passwd_db'],
					
				'{db_port}'=>$datForm['host_port'],
			));
			
			if (fwrite($link, $cont)){

				fclose($link);
				
			}else{
				
				$writeError = true;
			}
		
		}else{
		
			$writeError = true;
		}
		
		if (!$writeError){
			
			$this->notificationWindow(OPF_LOGIN_34,5,'ok');
			
			$this->closeMessageBox();
			
			$this->assign('content1', 'innerHTML', $OPF_login->getFormLogin());
			
		}else{
			
			$this->messageBox(OPF_LOGIN_33,'error');
		}
		
		return $this->response;
	}
	
	public function onLoadShowWel (){
			
		$this->modalWindowFromUrl(BASE_URL_PATH.'resources/lang/firstTime/'.LANG.'.html',OPF_LOGIN_31,300,320,2);
		
		return $this->response;
	}

	public function onChangeEngine ($engine){
			
		if ($engine){
				
			$ext = $engine;
				
			if (!extension_loaded($ext)){

				$this->messageBox('['.$ext.']&nbsp;'.OPF_LOGIN_28,'error');

				$this->clear('engine', 'value');

			}
		}
			
		return $this->response;
	}

	public function onClickReload ($datForm){
			
		$OPF_login = new OPF_login;

		$this->notificationWindow(OPF_LOGIN_35,5,'warning');
		
		$this->closeMessageBox();
			
		$this->modalWindow($OPF_login->getFormConfigApp($datForm),OPF_LOGIN_25,300,400,2);
			
		$this->assign('content1', 'innerHTML', $OPF_login->getFormLogin());
			
		return $this->response;
	}

	public function onClickCreateBD ($datForm){

		$OPF_login = new OPF_login;
			
		if ($this->MYFORM_validate($datForm, array('engine','encoding','db'))){

			switch ($datForm['engine']){
					
				case 'mysql':

					$link = @mysql_connect($datForm['host_db'], $datForm['user_db'], $datForm['passwd_db']);

					if (!$link){

						$this->messageBox(OPF_LOGIN_18,'error');

					}else{

						$sql = 'CREATE DATABASE '.$datForm['db'].' CHARACTER SET '.$datForm['encoding'];

						if (@mysql_query($sql, $link)) {
								
							$this->messageBox(OPF_LOGIN_19,'info');
								
							$this->assign('content1', 'innerHTML', $OPF_login->getFormInstall('tables',$datForm));
								
						} else {

							$this->messageBox(OPF_LOGIN_20.' '.mysql_error($link),'error');

						}

					}

					break;
						
				case 'pgsql':

					$link = @pg_connect($cad = 'host='.$datForm['host_db'].' port='.$datForm['host_port'].' dbname=postgres user='.$datForm['user_db'].' password='.$datForm['passwd_db'].'');

					if (!$link){
							
						$this->messageBox(OPF_LOGIN_23,'error');
							
					}else{
							
						$sql = "CREATE DATABASE ".$datForm['db']." ENCODING '".$datForm['encoding']."'";
							
						if (@pg_query($link, $sql)) {

							$this->messageBox(OPF_LOGIN_19,'info');

							$this->assign('content1', 'innerHTML', $OPF_login->getFormInstall('tables',$datForm));

						}else{

							$link = @pg_connect($cad = 'host='.$datForm['host_db'].' port='.$datForm['host_port'].' dbname='.$datForm['db'].' user='.$datForm['user_db'].' password='.$datForm['passwd_db'].'');

							if (!$link){

								$this->messageBox(OPF_LOGIN_20.' '.pg_errormessage(),'error');
									
							}else{
									
								$this->messageBox(OPF_LOGIN_19,'info');
									
								$this->assign('content1', 'innerHTML', $OPF_login->getFormInstall('tables',$datForm));
							}

						}
							
					}

					break;
			}


		}else{

			$this->messageBox(OPF_LOGIN_22.'', 'error');

		}
		
		return $this->response;
	}

	public function onClickInstall ($datForm){
			
		$OPF_login = new OPF_login;
			
		if ($this->MYFORM_validate($datForm, array('engine','encoding','db'))){

			switch ($datForm['engine']){

				case 'mysql':

					$link = @mysql_connect($datForm['host_db'], $datForm['user_db'], $datForm['passwd_db']);
						
					if (!$link){

						$this->messageBox(OPF_LOGIN_6,'error');

					}else{

						if (@mysql_select_db ($datForm['db'], $link)){
								
							require APP_PATH.'essentials'.DS.'public'.DS.'db'.DS.'essentials_'.$datForm['engine'].'.sql';
								
							$error = '';
								
							@mysql_query('BEGIN;',$link);

							foreach ($arrInstallDB as $bloq){

								if (!@mysql_query($bloq,$link)){

									$error .= mysql_errno($link).mysql_error($link);
											
									break;
								}

							}
								
							if ($error){

								@mysql_query('ROLLBACK;',$link);
									
								$this->modalWindow($error,'Error',300,300,2);
									
							}else{

								@mysql_query('COMMIT;',$link);
									
								$this->messageBox(OPF_LOGIN_15,'info',array(YES=>'onClickCreateConfig',NO=>'onClickReload'),$datForm);
									
								
							}
								
						}else{
								
							$this->messageBox(OPF_LOGIN_21,'error');
						}

					}

					break;
						
				case 'pgsql':

					$link = @pg_connect($cad = 'host='.$datForm['host_db'].' port='.$datForm['host_port'].' dbname='.$datForm['db'].' user='.$datForm['user_db'].' password='.$datForm['passwd_db'].'');
						
					if (!$link){

						$this->messageBox(OPF_LOGIN_6,'error');

					}else{

						@pg_query($link, 'BEGIN;');

						require APP_PATH.'essentials'.DS.'public'.DS.'db'.DS.'essentials_'.$datForm['engine'].'.php';
						
						$error = '';
							
						foreach ($arrInstallDB as $bloq){

							if (!@pg_query($link, $bloq)){

								$error .= pg_last_error($link);

								$this->alert($bloq).pg_last_error($link);

								break;
							}
									
						}
							
						if ($error){

							@pg_query($link, 'ROLLBACK;');

							$this->modalWindow($error.'<br>client_encoding:'.pg_client_encoding($link),'Error',300,300,2);

						}else{

							@pg_query($link, 'COMMIT;');

							$this->messageBox(OPF_LOGIN_15,'info',array(YES=>'onClickCreateConfig',NO=>'onClickReload'),$datForm);
						}

					}

					break;
			}
				
		}else{

			$this->messageBox(OPF_LOGIN_22, 'error');
		}
			
		return $this->response;
	}

	public function onClickLogIn ($datForm){
		
		$myAct = new OPF_myActiveRecord();
		
		if ($myAct->isSuccessfulConnect()){

			$OPF_login = new OPF_login;
			
			if ($OPF_login->existsStruct()){
					
				if ($this->MYFORM_validate($datForm, array('user_opf_ess','passwd_opf_ess'))){

					if ($OPF_login->autenticate($datForm)){

						$_SESSION['register_access'] = true;
							
						$this->redirect(BASE_URL_PATH.'frames/');

					}else

						$this->messageBox($OPF_login->getStrError(),'error');
						
				}else
					
					$this->notificationWindow(MSG_CAMPOS_REQUERIDOS,5,'error');

			}else

				$this->messageBox(OPF_LOGIN_27.$OPF_login->existsStruct().$OPF_login->errorSql,'error');
			
		}else{
			
			$this->heightMessageBox = 290;
			
			$this->errorBox(OPF_LOGIN_23,$myAct->getErrorLog());
		}
			
		return $this->response;
	}


}


$objEventos = new controller();
$objEventos->processRequest();

?>