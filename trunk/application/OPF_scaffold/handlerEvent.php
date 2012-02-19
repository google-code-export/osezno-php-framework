<?php
/**
 * Menjador de eventos de usuario.
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2012 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
include 'dataModel.php';

/**
 * Manejador de eventos de usuario
 *
 */
class eventos extends OPF_myController {

	public function onClickSetIdValRT ($datForm, $id){
		
		if ($this->MYFORM_validate($datForm, array('key','value'))){
			
			$_SESSION['temp_scaff_info']['rt'][$id]['key'] = $datForm['key'];
			
			$_SESSION['temp_scaff_info']['rt'][$id]['value'] = $datForm['value'];
			
			$this->clear($id, 'value');
			
			$this->closeModalWindow();
			
		}else{
			
			$this->notificationWindow(MSG_CAMPOS_REQUERIDOS,5,'error');
		}
		
		return $this->response;
	}
	
	public function onClickSetRT ($datForm, $id){
		
		if ($this->MYFORM_validate($datForm, array('table_name'))){
		
			$myAct = new OPF_myActiveRecord();
		
			$resSql = scaffold::getResultSelectFields($myAct,$datForm['table_name']);
		
			if (!$resSql){
					
				$this->messageBox(OPF_SCAFF_10,'warning');
					
			}else{
					
				$_SESSION['temp_scaff_info']['rt'][$id]['table_name'] = $datForm['table_name'];
				
				$this->closeModalWindow();
				
				$this->modalWindow(relationTable::getFormIdValue($id, $datForm),OPF_SCAFF_49, 300, 260);
			}
		
		}else{
		
			$this->notificationWindow(MSG_CAMPOS_REQUERIDOS,5,'error');
		}
		
		return $this->response;
	}
	
	
	
	public function newScaff ($datForm, $step = ''){

		$this->closeModalWindow();
			
		switch ($step){

			case 1:
					
				$this->modalWindow(
					
				scaffold::formNewScaffStep1(),

				OPF_SCAFF_1,580,400,2);
					
				break;

			case 2:
					
				$this->modalWindow(
					
				scaffold::formNewScaffStep2($datForm),

				OPF_SCAFF_2,580,400,2);
					
				break;
					
			case 3:
					
				$this->modalWindow(
					
				scaffold::formNewScaffStep3($datForm),

				OPF_SCAFF_3,580,400,2);
					
				break;

			case 4:
					
				$this->modalWindow(
					
				scaffold::formNewScaffStep4($datForm),

				OPF_SCAFF_4,580,400,2);
					
				$this->script('updateValsAnchos()');

				break;

			case 5:
					
					
					
				$this->modalWindow(
					
				scaffold::formNewScaffStep5($datForm),

				OPF_SCAFF_5,580,400,2);
					
				break;
		}
			
		return $this->response;
	}

	public function selectOtherTable ($datForm, $object, $closePreview = false){
		
		if ($closePreview)
		
			$this->closeModalWindow();
		
		$this->modalWindow(relationTable::getFormTable($object),OPF_SCAFF_49, 300, 260);
		
		return $this->response;
	}
	
	public function toScaffStep6 ($datForm, $rewrite = false){
			
		if ( $this->MYFORM_validate($datForm, array('modnom')) ){

			$_SESSION['temp_scaff_info']['modnom'] = $datForm['modnom'];

			$_SESSION['temp_scaff_info']['moddesc'] = $datForm['moddesc'];

			$_SESSION['temp_scaff_info']['namefolder'] = $datForm['namefolder'];

			$folder = '../../application/'.$datForm['namefolder'].'/';

			$errorRewrite = false;

			if ($rewrite == true){
					
				$d = dir($folder);

				while (false !== ($entry = $d->read())) {
						
					if ($entry != '..' && $entry != '.'){

						if (!unlink($folder.$entry)){
								
							$errorRewrite = true;
								
							break;
						}
					}
						
				}

				$d->close();

				if (!rmdir($folder))

				$errorRewrite = true;

			}

			if (!$errorRewrite){

				if (!file_exists($folder)){
						
					if (mkdir($folder,0644)){

						$writeError = false;
							
						$fillScaffold = new fillScaffold;
							
						$contIndex = scaffold::scaffReadTemplate(PATH_TEMPLATES.'scaffold/index.tpl', array(
							
 							'{scaff_mod_name}'=>($_SESSION['temp_scaff_info']['modnom']),

 							'{scaff_mod_desc}'=>($_SESSION['temp_scaff_info']['moddesc']),

 							'{name_table_scaff}'=>$_SESSION['temp_scaff_info']['table_name']));
							
						$link = fopen($folder.'index.php', 'w');
							
						if ($link){
								
							fwrite($link, $contIndex);
								
							fclose($link);

						}else{

							$writeError = true;
						}
							
						$contHandler = scaffold::scaffReadTemplate(PATH_TEMPLATES.'scaffold/handlerEvent.tpl', array(
							
 						 	'{name_table_scaff}'=>$_SESSION['temp_scaff_info']['table_name'],
							
 						 	'{fields_required_list_array}'=>$fillScaffold->getFillAreaContent('fields_required_list_array'),
							
 						 	'{fields_assign_to_save}'=>$fillScaffold->getFillAreaContent('fields_assign_to_save'),
							
 						 	'{height_window_form}'=>$fillScaffold->getFillAreaContent('height_window_form')
						));

						$link = fopen($folder.'handlerEvent.php', 'w');

						if ($link){
								
							fwrite($link, $contHandler);

							fclose($link);

						}else{

							$writeError = true;
						}
							
						$contDataModel = scaffold::scaffReadTemplate(PATH_TEMPLATES.'scaffold/dataModel.tpl', array(
							
 						 	'{name_table_scaff}'=>$_SESSION['temp_scaff_info']['table_name'],
							
 						 	'{fields_table_scaff}'=>$fillScaffold->getFillAreaContent('fields_table_scaff'),
							
 						 	'{form_reg_list_fields}'=>$fillScaffold->getFillAreaContent('form_reg_list_fields'),
							
 						 	'{sql_list_scaff}'=>$fillScaffold->getFillAreaContent('sql_list_scaff'),
							
 						 	'{getqueryform}'=>$fillScaffold->getFillAreaContent('getqueryform'),
							
 							'{real_names_in_query}'=>$fillScaffold->getFillAreaContent('real_names_in_query'),

 							'{setexportdata}'=>$fillScaffold->getFillAreaContent('setexportdata'),

 							'{setpagination}'=>$fillScaffold->getFillAreaContent('setpagination'),

 							'{setuseordermethod}'=>$fillScaffold->getFillAreaContent('setuseordermethod'),

 							'{eliminar}'=>$fillScaffold->getFillAreaContent('eliminar'),

 							'{editar}'=>$fillScaffold->getFillAreaContent('editar'),

 							'{eliminar_mul}'=>$fillScaffold->getFillAreaContent('eliminar_mul'),

 							'{width_list}'=>$fillScaffold->getFillAreaContent('width_list'),

 							'{width_fields}'=>$fillScaffold->getFillAreaContent('width_fields')
						));
							
						$link = fopen($folder.'dataModel.php', 'w');
							
						if ($link){
								
							fwrite($link, $contDataModel);
								
							fclose($link);

						}else{

							$writeError = true;
						}
							
						if (!$writeError){

							if ($datForm['downloadzip']){

								$_SESSION['SCAFF_TEMP_ZIP_FILES_C'] = array (

 							 		'index'=>$contIndex,

 									'handler'=>$contHandler,

 							 		'data'=>$contDataModel
								);

								$secure_opf_code = '';

								if (isset($_GET['secure_opf_code']))

								$secure_opf_code = $_GET['secure_opf_code'];

								$this->redirect('downloadzip.php?secure_opf_code='.$secure_opf_code.'&namefolder='.$datForm['namefolder']);
							}

							$this->closeMessageBox();

							$this->messageBox(OPF_SCAFF_45.' <b>'.'application/'.$datForm['namefolder'].'/'.'</b> ','INFO');

						}else

						$this->messageBox(OPF_SCAFF_44.' "'.$folder.'"','error');
							
					}else

					$this->messageBox(OPF_SCAFF_6.' "'.$folder.'"','error');
						
				}else
					
				$this->messageBox(OPF_SCAFF_7_A.' <b>'.'application/'.$datForm['namefolder'].'/'.'</b> '.OPF_SCAFF_7_B.' '.OPF_SCAFF_7_C,'help',array(YES=>'toScaffStep6',NO),$datForm,true);
					
			}else
				
			$this->messageBox(OPF_SCAFF_8_A.' <b>'.$folder.'</b> '.OPF_SCAFF_8_B,'error');

		}else

		$this->notificationWindow(MSG_CAMPOS_REQUERIDOS,5,'error');
			
		return $this->response;
	}

	public function toScaffStep5 ($datForm){
			
		$sumCampos = 0;
			
		$key = 'field_';

		$_SESSION['temp_scaff_info']['grid_att'] = array ();
			
		$arrRequired = array ('ancho_total');
			
		foreach ($datForm as $id => $value){

			if (stripos($id, $key) !== false){

				if ($datForm[$id]){

					$realName = substr($id, strlen($key));

					$arrRequired[] = 'etq_'.$realName;

					$arrRequired[] = 'width_'.$realName;

					$_SESSION['temp_scaff_info']['grid_att']['fields_on_list'][$realName] = array ($datForm['etq_'.$realName], $datForm['width_'.$realName]);

					if ($datForm['width_'.$realName])

					$sumCampos += $datForm['width_'.$realName];
				}
					
			}else{
					
				$_SESSION['temp_scaff_info']['grid_att'][$id] = $datForm[$id];
			}

		}
			
		if ($this->MYFORM_validate($datForm, $arrRequired)){
				
			if ($sumCampos == $datForm['ancho_total']){
					
				$this->newScaff($datForm,5);
					
			}else{
					
				$this->messageBox(OPF_SCAFF_9,'ERROR');
			}
				
		}else{
				
			$this->notificationWindow(MSG_CAMPOS_REQUERIDOS,5,'error');
		}
			
		return $this->response;
	}

	public function toScaffStep4 ($datForm){
			
		$arraReq = array ();
			
		$key = 'type_';
			
		$_SESSION['temp_scaff_info']['combos_rel'] = array ();
			
		foreach ($datForm as $id => $value){

			if (stripos($id, $key) !== false){

				if (!isset($_SESSION['temp_scaff_info']['rt'][$id])){
				
					$arraReq[] = $id;
				
				}
				
				if ($datForm[$id]){
				
					if ($datForm[$id] != 'other')
						
						$_SESSION['temp_scaff_info']['combos_rel'][$id] = $datForm[$id];
				
				}
				
					
			}

		}
			
		if ($this->MYFORM_validate($datForm, $arraReq)){

			$this->newScaff($datForm,4);

		}else{

			$this->notificationWindow(MSG_CAMPOS_REQUERIDOS,5,'error');
		}
			
		return $this->response;
	}

	public function toScaffStep3 ($datForm){
			
		$_SESSION['temp_scaff_info']['combos'] = array ();
			
		$key = 'field_';
			
		$checks = array ();
			
		$arrRequired = array ('primary_key');
			
		foreach ($datForm as $id => $value){

			if (stripos($id, $key) !== false){
					
				if ($datForm[$id]){
						
					$realName = substr($id, strlen($key));
						
					$arrRequired[] = 'etq_'.$realName;

					$arrRequired[] = 'type_'.$realName;

					$checks[] = $realName;

					if ($datForm['type_'.$realName] == 3){
							
						$_SESSION['temp_scaff_info']['combos'][] = $realName;
					}

				}

			}

		}
			
		if ($this->MYFORM_validate($datForm, $arrRequired)){

			$_SESSION['temp_scaff_info']['pk'] = $datForm['primary_key'];

			$_SESSION['temp_scaff_info']['form'] = array ();

			foreach ($checks as $campo){
					
				$_SESSION['temp_scaff_info']['form'][$campo] = array ($datForm['etq_'.$campo], $datForm['type_'.$campo], $datForm['req_'.$campo]);
			}

			$this->newScaff($datForm,3);

		}else{

			$this->notificationWindow(MSG_CAMPOS_REQUERIDOS,5,'error');
		}
			
		return $this->response;
	}

	public function toScaffStep2 ($datForm){
			
		if ($this->MYFORM_validate($datForm, array('table_name'))){

			$myAct = new OPF_myActiveRecord();

			if (!isset($_SESSION['temp_scaff_info']))
				
			$_SESSION['temp_scaff_info'] = array();

			$resSql = scaffold::getResultSelectFields($myAct,$datForm['table_name']);

			if (!$resSql){
					
				$this->messageBox(OPF_SCAFF_10,'warning');
					
			}else{
					
				$_SESSION['temp_scaff_info']['table_name'] = $datForm['table_name'];
					
				$this->newScaff($datForm,2);
			}

		}else{

			$this->notificationWindow(MSG_CAMPOS_REQUERIDOS,5,'error');
		}
			
		return $this->response;
	}


}




$objEventos = new eventos($objxAjax);
$objOsezno  = new OPF_osezno($objxAjax,$theme);

$objOsezno->setPathFolderTemplates(PATH_TEMPLATES);
$objxAjax->processRequest();

?>