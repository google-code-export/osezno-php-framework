<?php
/**
 * Modelo del datos del Modulo.
 * - Acceso a datos de las bases de datos
 * - Retorna informacion que el Controlador muestra al usuario
 *
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 * @link http://www.osezno-framework.org/
 * @copyright Copyright &copy; 2007-2011 Osezno PHP Framework
 * @license http://www.osezno-framework.org/license.txt
 */
 include '../../config/configApplication.php';

 class fillScaffold {
 	
 	private $fillAreas = array (
 		
 		'fields_table_scaff'
 		
 	); 
 	
 	public function __construct(){
 		
 		$arrFieldsOnTable = array ();
 		
 		$sqlTemp = 'SELECT * FROM '.$_SESSION['temp_scaff_info']['table_name'].' LIMIT 1';
 		
 		$myAct = new OPF_myActiveRecord();
 		
 		$resSql = $myAct->query($sqlTemp,false);
 		
 		$count = 0;
 			
 		foreach ($resSql[0] as $id => $value){
 			
 			$arrFieldsOnTable[] = $id;
 		}
 		
 		/**
 		 * fields_table_scaff
 		 * Listado de campos de la tabla a hacer scaff
 		 */
 		$this->fillAreas['fields_table_scaff'] = '';
 		
 		foreach ($arrFieldsOnTable as $field){
 			
 			$this->fillAreas['fields_table_scaff'].= "\n\t".'public $'.$field.';'."\n";
 		}
 		
 		/**
 		 * form_reg_list_fields
 		 * Parte del formulario de registro de la tabla scaff
 		 */
 		$this->fillAreas['form_reg_list_fields'] = '';
 		
 		$buf = '';
 		
 		foreach ($_SESSION['temp_scaff_info']['form'] as $field => $prop){
 			
 			$etq  = $prop[0];
 			
 			$type = $prop[1];
 			
 			switch ($type){
 				
 				case 1: //Texto
 					$buf .= "\n\t\t".'$myForm->addText(\''.$etq.':\', \''.$field.'\', $'.$_SESSION['temp_scaff_info']['table_name'].'->'.$field.');'."\n";
 				break;
 				case 2: //Numerico
 					$buf .= "\n\t\t".'$myForm->addText(\''.$etq.':\', \''.$field.'\', $'.$_SESSION['temp_scaff_info']['table_name'].'->'.$field.', NULL, NULL, true);'."\n";
 				break;
 				case 3: //Seleccion
 					
 					if (isset($_SESSION['temp_scaff_info']['combos_rel']['type_'.$field])){
 						
 						$buf .= "\n\t\t".'$arrayValues'.$field.' = array();'."\n";
 						
 						$buf .= "\n\t\t".'foreach ($ess_master_tables_detail->find(\'master_tables_id = '.$_SESSION['temp_scaff_info']['combos_rel']['type_'.$field].'\') as $row){'."\n";
 						
 						$buf .= "\n\t\t\t".'$arrayValues'.$field.'[$row->id] = $row->item_desc;'."\n";
 						
 						$buf .= "\n\t\t".'}'."\n";
 					}
 					
 					$buf .= "\n\t\t".'$myForm->addSelect(\''.$etq.':\', \''.$field.'\', $arrayValues'.$field.', $'.$_SESSION['temp_scaff_info']['table_name'].'->'.$field.');'."\n";
 				break;
 				case 4: //Fecha
 					$buf .= "\n\t\t".'$myForm->addText(\''.$etq.':\', \''.$field.'\', $'.$_SESSION['temp_scaff_info']['table_name'].'->'.$field.', 10, 12, true, true);'."\n";
 				break;
 				case 5: //Area texto
 					$buf .= "\n\t\t".'$myForm->addTextArea(\''.$etq.':\', \''.$field.'\', $'.$_SESSION['temp_scaff_info']['table_name'].'->'.$field.');'."\n";
				break;
 				case 6: //Booleano
 					$buf .= "\n\t\t".'$valChk = false;'."\n";
 					
 					$buf .= "\n\t\t".'if ($'.$_SESSION['temp_scaff_info']['table_name'].'->'.$field.')'."\n";
 					
 					$buf .= "\n\t\t\t".'$valChk = true;'."\n";
 					
 					$buf .= "\n\t\t".'$myForm->addCheckBox(\''.$etq.':\',\''.$field.'\',$valChk);'."\n";
 				break; 				
 			}
 		}
 		
 		$this->fillAreas['form_reg_list_fields'] .= $buf;
 		
 		$buf = '';
 		
 		/**
 		 * Campos requeridos antes de ser guardados
 		 * fields_required_list_array
 		 */
 		$this->fillAreas['fields_required_list_array'] = '';
 		
 		foreach ($_SESSION['temp_scaff_info']['form'] as $field => $prop){
 			
 			if($prop[2])
 			
 				$buf .= '\''.$field.'\',';
 			
 		}
 		
 		$buf = substr($buf, 0, -1);
 		
 		$this->fillAreas['fields_required_list_array'] = $buf;
 		
 		$buf = '';
 		
 		/**
 		 * Atcive record cuando un registro se va a guardar
 		 * fields_assign_to_save
 		 */
 		$this->fillAreas['fields_assign_to_save'] = '';
 		
 		foreach ($_SESSION['temp_scaff_info']['form'] as $field => $prop){

 			$buf .= "\n\t\t\t".'$'.$_SESSION['temp_scaff_info']['table_name'].'->'.$field.' = $datForm[\''.$field.'\'];'."\n";
 		}
 		
 		$this->fillAreas['fields_assign_to_save'] = $buf;
 		
 		$buf = '';
 		
 		/**
 		 * Nombres reales en la grilla
 		 * real_names_in_query
 		 */
 		$this->fillAreas['real_names_in_query'] = '';
 		
 		/**
 		 * Sql de la lista dinamica
 		 * sql_list_scaff
 		 */
 		$this->fillAreas['sql_list_scaff'] = '';
 		
 		$buf .= 'SELECT ';
 		
 		if ($_SESSION['temp_scaff_info']['grid_att']['eliminar']){
 			
 			$buf .= $_SESSION['temp_scaff_info']['table_name'].'.'.$_SESSION['temp_scaff_info']['pk'].' AS "'.OPF_FIELD_ELIMINAR.'", ';
 		}
 		
 		if ($_SESSION['temp_scaff_info']['grid_att']['editar']){
 		
 			$buf .= $_SESSION['temp_scaff_info']['table_name'].'.'.$_SESSION['temp_scaff_info']['pk'].' AS "'.OPF_FIELD_MODIFICAR.'", ';
 		}
 		
 		$contRel = 1;
 		
 		$infRel = array();
 		
 		foreach ($_SESSION['temp_scaff_info']['grid_att']['fields_on_list'] as $field => $prop){
 			
 			if (isset($prop[0])){
 			
 				if (isset($_SESSION['temp_scaff_info']['combos_rel']['type_'.$field])){
 					
 					$buf .= 'rel'.$contRel.'.item_desc AS "'.$prop[0].'", ';

 					$infRel[$contRel] = array('id_table'=>$_SESSION['temp_scaff_info']['combos_rel']['type_'.$field], 'fieldrel'=>$field, 'etq'=>$prop[0]);

 					$this->fillAreas['real_names_in_query'] .= "\n\t\t".'$myList->setRealNameInQuery(\''.$prop[0].'\',\''.'rel'.$contRel.'.item_desc\');'."\n";
 					
 					$contRel++;
 					
 				}else{
 					
 					$buf .= ''.$_SESSION['temp_scaff_info']['table_name'].'.'.$field.' AS "'.$prop[0].'", ';
 					
 					$this->fillAreas['real_names_in_query'] .= "\n\t\t".'$myList->setRealNameInQuery(\''.$prop[0].'\',\''.$_SESSION['temp_scaff_info']['table_name'].'.'.$field.'\');'."\n"; 
 				}
 				
 			}
 			
 		}
 		
 		$buf = substr($buf, 0, -2);
 		
 		$buf .= ' FROM '.$_SESSION['temp_scaff_info']['table_name'];
 		
 		if (count($infRel)){
 			
 			foreach ($infRel as $conRel => $propRel){
 				
 				$buf .= ' LEFT OUTER JOIN ess_master_tables_detail rel'.$conRel.' ON (rel'.$conRel.'.id = '.$_SESSION['temp_scaff_info']['table_name'].'.'.$propRel['fieldrel'].' AND rel'.$conRel.'.master_tables_id = '.$propRel['id_table'].') ';
 				
 			}
 			
 		}
 		
 		$this->fillAreas['sql_list_scaff'] = $buf;
 		
 		$buf = '';
 		
 		/**
 		 * Formulario de consulta lista dinamica
 		 * getqueryform
 		 */
 		$buf = 'false';
 		
 		if ($_SESSION['temp_scaff_info']['grid_att']['getqueryform'])
 		
 			$buf = 'true,true';
 		
 		$this->fillAreas['getqueryform'] = $buf;
 		
 		$buf = '';
 		
 		/**
 		 * Exportar resultado de lista a archivos
 		 * setexportdata
 		 */
 		$buf = 'false,false,false';
 			
 		if ($_SESSION['temp_scaff_info']['grid_att']['setexportdata'])
 			
 			$buf = 'true,true,true';
 		
 		$this->fillAreas['setexportdata'] = $buf;
 			
 		$buf = '';
 		
 		/**
 		 * Configurar la paginacion
 		 * setpagination
 		 */
 		$buf = 'false';
 		
 		if ($_SESSION['temp_scaff_info']['grid_att']['setpagination'])
 		
 			$buf = 'true,50';
 			
 		$this->fillAreas['setpagination'] = $buf;
 		
 		$buf = '';
 		
 		/**
 		 * Usar ordenamiento de columnas
 		 * setuseordermethod 
 		 */
 		$buf = 'false';
 			
 		if ($_SESSION['temp_scaff_info']['grid_att']['setuseordermethod'])
 			
 			$buf = 'true';
 		
 		$this->fillAreas['setuseordermethod'] = $buf;
 			
 		$buf = '';
 		
 		/**
 		 * eliminar
 		 */
 		$buf = '';
 		
 		$masWidthEliminar = 0;
 		
 		if ($_SESSION['temp_scaff_info']['grid_att']['eliminar']){
 		
 			$buf = "".'$myList->setEventOnColumn(\''.OPF_FIELD_ELIMINAR.'\',\'onClickDeleteRecord\');'."\n";
 			
 			$masWidthEliminar = 50;
 		}
 			
 		$this->fillAreas['eliminar'] = $buf;
 		
 		$buf = '';

 		/**
 		 * editar
 		 */
 		$buf = '';
 			
 		$masWidthEditar = 0;
 		
 		if ($_SESSION['temp_scaff_info']['grid_att']['editar']){
 			
 			$buf = "".'$myList->setEventOnColumn(\''.OPF_FIELD_MODIFICAR.'\',\'onClickAddRecord\');'."\n";

 			$masWidthEditar = 40;
 		}
 		
 		$this->fillAreas['editar'] = $buf;
 			
 		$buf = '';
 			
 		/**
 		 * eliminar_mul
 		 */
 		$buf = '';
 		
 		if ($_SESSION['temp_scaff_info']['grid_att']['eliminar_mul'] && $masWidthEliminar)
 		
 			$buf = "".'$myList->setGlobalEventOnColumn(\''.OPF_FIELD_ELIMINAR.'\', array(\''.OPF_FIELD_ELIMINAR.'\'=>\'onClickDeleteRecord\') );';
 			
 		$this->fillAreas['eliminar_mul'] = $buf;
 		
 		$buf = '';

 		/**
 		 * Ancho de la lista
 		 * width_list
 		 */
 		$buf = '800';
 			
 		if ($_SESSION['temp_scaff_info']['grid_att']['ancho_total']){
 			
 			$buf = $_SESSION['temp_scaff_info']['grid_att']['ancho_total']+$masWidthEditar+$masWidthEliminar;
 			
 		}
 		
 		$this->fillAreas['width_list'] = $buf;
 			
 		$buf = '';
 		
 		/**
 		 * width_fields
 		 */
 		$buf = '';
 		
 		foreach ($_SESSION['temp_scaff_info']['grid_att']['fields_on_list'] as $id => $prop){
 			
 			$buf .= "\n\t\t".'$myList->setWidthColumn(\''.$id.'\', '.$prop[1].');'."\n";
 			
 		}
 		
 		if ($masWidthEliminar){
 			
 			$buf .= "\n\t\t".'$myList->setWidthColumn(\'Eliminar\', '.$masWidthEliminar.');'."\n";
 			
 		}
 		
 		if ($masWidthEditar){
 			
 			$buf .= "\n\t\t".'$myList->setWidthColumn(\'Editar\', '.$masWidthEditar.');'."\n";
 		}
 			
 		$this->fillAreas['width_fields'] = $buf;
 		
 		$buf = '';
 		
 		/**
 		 * Alto del formulario de registro
 		 * height_window_form
 		 */
 		$buf = '';
 		
 		$this->fillAreas['height_window_form'] = 70+count($_SESSION['temp_scaff_info']['form'])*30;
 			
 		$buf = '';
 	}
 	
 	public function getFillAreaContent($nameArea){
 		
 		return $this->fillAreas[$nameArea];
 	}
 	
 }
 
 class scaffold {
 	
 	static public function scaffReadTemplate ($file, $arrayAssignAreas){
 		
 		$newContent = '';
 		
 		$linkTpl = @fopen($file,'r');
 		
 		if ($linkTpl){
 		
 			$contHTML = fread($linkTpl,filesize($file));
 		
 			$newContent = $contHTML;
 				
 			fclose($linkTpl);
 		
 			if (count($arrayAssignAreas)){
 		
 				$arrayKeys = array_keys($arrayAssignAreas);
 					
 				$newContent = str_ireplace ( $arrayKeys, $arrayAssignAreas, $contHTML);
 			}
 				
 			$newContent = preg_replace('(\\{+[0-9a-zA-Z_]+\\})','',$newContent);
 				
 		}
 		
 		return $newContent;
 	}
 	
 	static public function formStartUp (){
 		
 		$myForm = new OPF_myForm('frm_startup');
 		
 		$myForm->addButton('btn1',LABEL_BTN_ADD,'add.gif');
 		
 		$myForm->addEvent('btn1', 'onclick', 'newScaff', 1);
 		
 		return $myForm->getForm(1);
 	}
 	
 	static public function formNewScaffStep5 ($datForm){
 		
 		$myForm = new OPF_myForm('formNewScaffStep5');
 		
 		$myForm->addComment('cm1:3', '');
 			
 		$myForm->addComment('cm2:3', '');
 			
 		$myForm->addComment('cm3:3', '');
 			
 		$myForm->addComment('cm4:3', '');
 		
 		$myForm->addComment('cm5:3', '');
 		
 		$foldername = 'SCAFF_'.$_SESSION['temp_scaff_info']['table_name'];
 			
 		if (isset($_SESSION['temp_scaff_info']['namefolder']))
 			
 			$foldername = $_SESSION['temp_scaff_info']['namefolder'];
 			
 		$myForm->addText(OPF_SCAFF_42,'namefolder:3',$foldername);
 		
 		$modnom = '';
 		
 		if (isset($_SESSION['temp_scaff_info']['modnom']))
 		
 			$modnom = $_SESSION['temp_scaff_info']['modnom'];
 		
 		$myForm->addText(OPF_SCAFF_11,'modnom:3',$modnom);
 		
 		$moddesc = '';
 		
 		if (isset($_SESSION['temp_scaff_info']['moddesc']))
 		
 			$moddesc = $_SESSION['temp_scaff_info']['moddesc'];
 		
 		$myForm->addText(OPF_SCAFF_12,'moddesc:3',$moddesc);
 		
 		$myForm->addCheckBox(OPF_SCAFF_43,'downloadzip:3');

 		$myForm->addComment('cm6:3', '');
 		
 		$myForm->addComment('cm7:3', '');
 		
 		$myForm->addComment('cm8:3', '');
 		
 		$myForm->addComment('cm9:3', '');
 		
 		$myForm->addComment('cm10:3', '');
 			
 		$myForm->addButton('btn0',OPF_SCAFF_13);
 			
 		$myForm->addEvent('btn0', 'onclick', 'newScaff',4);
 			
 		$myForm->addComment('cm_space', '');
 			
 		$myForm->addButton('btn1',OPF_SCAFF_15,'ok.gif');
 			
 		$myForm->addEvent('btn1', 'onclick', 'toScaffStep6');
 		
 		return $myForm->getForm(3);
 	}
 	
 	static public function formNewScaffStep4 ($datForm){
 		
 		$myForm = new OPF_myForm('formNewScaffStep4');
 		
 		$sqlTemp = 'SELECT * FROM '.$_SESSION['temp_scaff_info']['table_name'].' LIMIT 1';
 		
 		$myAct = new OPF_myActiveRecord();
 		
 		$resSql = $myAct->query($sqlTemp,false);
 		
 		$campoGrilla = array('field_selec','field_etq','field_ancho');
 		
 		$myForm->addComment('field_selec', '<div align="center"><b>'.OPF_SCAFF_16.'/'.OPF_SCAFF_41.'</b></div>');
 			
 		$myForm->addComment('field_etq', '<div align="center"><b>'.OPF_SCAFF_17.'</b></div>');
 			
 		$myForm->addComment('field_ancho', '<div align="center"><b>'.OPF_SCAFF_18.'</b></div>');
 			
 		foreach ($resSql[0] as $id => $value){
 				
 			if (isset($_SESSION['temp_scaff_info']['grid_att']['fields_on_list'][$id])){
 					
 				$check = true;
 					
 				$etq = $_SESSION['temp_scaff_info']['grid_att']['fields_on_list'][$id][0];
 					
 				$width = $_SESSION['temp_scaff_info']['grid_att']['fields_on_list'][$id][1];
 					
 			}else{
 					
 				$check = false;
 					
 				$etq = '';
 					
 				$width = '';
 				
 				$myForm->addDisabled('etq_'.$id);
 				
 				$myForm->addDisabled('width_'.$id);
 			}
 		
 			$myForm->addEvent('field_'.$id, 'onclick', 'updateWidthListT2', 'field_'.$id, 'width_'.$id, 'etq_'.$id);
 			
 			$myForm->addCheckBox($id,'field_'.$id,$check);
 		
 			$campoGrilla[] = 'field_'.$id;
 			
 			$myForm->addComment('etq_'.$id, '<div align="center">'.$myForm->getText('etq_'.$id,$etq,15).'</div>');
 			
 			$campoGrilla[] = 'etq_'.$id;
 		
 			$myForm->addEvent('width_'.$id, 'onblur', 'updateWidthListT','width_'.$id,'field_'.$id);
 			
 			$myForm->addComment('width_'.$id, '<div align="center">'.$myForm->getText('width_'.$id,$width,5,3,true).'</div>');
 			
 			$campoGrilla[] = 'width_'.$id;
 		}

 		$anchoTotal = 0;
 		
 		if (isset($_SESSION['temp_scaff_info']['grid_att']['ancho_total']))
 		
 			$anchoTotal = $_SESSION['temp_scaff_info']['grid_att']['ancho_total'];
 		
 		$myForm->addDisabled('ancho_total');
 		
 		$myForm->addText(OPF_SCAFF_19,'ancho_total',$anchoTotal,5,4,true);
 		
 		$getqueryform = false;
 			
 		if (isset($_SESSION['temp_scaff_info']['grid_att']['getqueryform']))
 			
 			$getqueryform = $_SESSION['temp_scaff_info']['grid_att']['getqueryform'];
 		
 		$myForm->addCheckBox(OPF_SCAFF_20,'getqueryform',$getqueryform);
 		
 		$setexportdata = false;
 		
 		if (isset($_SESSION['temp_scaff_info']['grid_att']['setexportdata']))
 		
 			$setexportdata = $_SESSION['temp_scaff_info']['grid_att']['setexportdata'];
 		
 		$myForm->addCheckBox(OPF_SCAFF_21,'setexportdata',$setexportdata);
 		
 		$setpagination = false;
 			
 		if (isset($_SESSION['temp_scaff_info']['grid_att']['setpagination']))
 			
 			$setpagination = $_SESSION['temp_scaff_info']['grid_att']['setpagination'];
 		
 		$myForm->addCheckBox(OPF_SCAFF_22,'setpagination',$setpagination);
 		
 		$setuseordermethod = false;
 		
 		if (isset($_SESSION['temp_scaff_info']['grid_att']['setuseordermethod']))
 		
 			$setuseordermethod = $_SESSION['temp_scaff_info']['grid_att']['setuseordermethod'];
 		
 		$myForm->addCheckBox(OPF_SCAFF_23,'setuseordermethod',$setuseordermethod);
 		
 		$editar = false;
 			
 		if (isset($_SESSION['temp_scaff_info']['grid_att']['editar']))
 			
 			$editar = $_SESSION['temp_scaff_info']['grid_att']['editar'];
 		
 		$myForm->addCheckBox(OPF_SCAFF_24,'editar',$editar);
 		
 		$eliminar = false;
 		
 		if (isset($_SESSION['temp_scaff_info']['grid_att']['eliminar'])){
 		
 			$eliminar = $_SESSION['temp_scaff_info']['grid_att']['eliminar'];
 			
 		}
 		
 		if (!$eliminar)
 		
 			$myForm->addDisabled('eliminar_mul');
 		
 		$myForm->addEvent('eliminar', 'onclick', 'valOptDelete');
 		
 		$myForm->addCheckBox(OPF_SCAFF_25,'eliminar',$eliminar);
 		
 		$eliminar_mul = false;
 		
 		if (isset($_SESSION['temp_scaff_info']['grid_att']['eliminar_mul']))
 			
 			$eliminar_mul = $_SESSION['temp_scaff_info']['grid_att']['eliminar_mul'];
 		
 		$myForm->addCheckBox(OPF_SCAFF_26,'eliminar_mul',$eliminar_mul);
 		
 		$myForm->addGroup('opcvarias',OPF_SCAFF_27,array('ancho_total','getqueryform','setexportdata','setpagination','setuseordermethod','editar','eliminar','eliminar_mul'));
 		
 		$myForm->addGroup('campos',OPF_SCAFF_28,$campoGrilla,3);
 		
 		$myForm->addButton('btn0',OPF_SCAFF_13);
 		
 		$myForm->addEvent('btn0', 'onclick', 'newScaff',3);
 		
 		$myForm->addComment('cm_space', '');
 		
 		$myForm->addButton('btn1',OPF_SCAFF_14);
 		
 		$myForm->addEvent('btn1', 'onclick', 'toScaffStep5');
 			
 		return $myForm->getForm(3);
 	}
 	
 	static public function formNewScaffStep3 ($datForm){
 		
 		$ess_master_tables = new ess_master_tables;
 		
 		$arrTablas = array();
 		
 		foreach ($ess_master_tables->find(NULL,'name') as $tabla){
 			
 			$arrTablas[$tabla->id] = $tabla->name; 
 		}
 		
 		$myForm = new OPF_myForm('formNewScaffStep3');

 		$myForm->addComment('field_selec', '<div align="center"><b>'.OPF_SCAFF_16.'</b></div>');
 			
 		$myForm->addComment('field_etq', '<div align="center"><b>'.OPF_SCAFF_29.'</b></div>');
 		
 		foreach ($_SESSION['temp_scaff_info']['combos'] as $combo){
 			
 			$myForm->addComment('field_selec_'.$combo, '<div align="center">'.$combo.'</div>');

 			$value = '';
 			
 			if (isset($_SESSION['temp_scaff_info']['combos_rel']['type_'.$combo])){
 				
 				$value = $_SESSION['temp_scaff_info']['combos_rel']['type_'.$combo];
 			}
 			
 			$myForm->addComment('type_'.$combo, '<div align="center">'.$myForm->getSelect('type_'.$combo, $arrTablas, $value).'</div>');
 		}
 		
 		$myForm->addButton('btn0',OPF_SCAFF_13);
 		
 		$myForm->addEvent('btn0', 'onclick', 'newScaff',2);
 		
 		$myForm->addButton('btn1',OPF_SCAFF_14);
 		
 		$myForm->addEvent('btn1', 'onclick', 'toScaffStep4');
 		
 		return $myForm->getForm(2);
 	}
 	
 	static public function formNewScaffStep2 ($datForm){
 		
 		$myForm = new OPF_myForm('formNewScaffStep2');
 		
 		$arrTypes = array (
 			
 			1 => htmlentities(OPF_SCAFF_30),
 			
 			2 => htmlentities(OPF_SCAFF_31),
 			
 			3 => htmlentities(OPF_SCAFF_32),
 			
 			4 => htmlentities(OPF_SCAFF_33),
 			
 			5 => htmlentities(OPF_SCAFF_34),
 			
 			6 => htmlentities(OPF_SCAFF_35)
 		);
 		
 		$myAct = new OPF_myActiveRecord();
 			
 		$resSql =  self::getResultSelectFields($myAct, $_SESSION['temp_scaff_info']['table_name']);  
 			
 		$myForm->addComment('field_etq1', '<div align="center"><b>'.OPF_SCAFF_16.'</b></div>');
 		
 		$myForm->addComment('field_selec', '<div align="center"><b>'.OPF_SCAFF_41.'</b></div>');
 		
 		$myForm->addComment('field_etq', '<div align="center"><b>'.OPF_SCAFF_17.'</b></div>');
 		
 		$myForm->addComment('field_tipo', '<div align="center"><b>'.OPF_SCAFF_36.'</b></div>');

 		$myForm->addComment('field_primary', '<div align="center"><b>'.OPF_SCAFF_40.'</b></div>');
 		
 		$myForm->addComment('field_required', '<div align="center"><b>'.OPF_SCAFF_37.'</b></div>');
 		
 		$count = 0;
 		
 		foreach ($resSql[0] as $id => $value){
 			
 			if (isset($_SESSION['temp_scaff_info']['form'][$id])){
 				
 				$check = true;
 				
 				$etq = $_SESSION['temp_scaff_info']['form'][$id][0];
 				
 				$type = $_SESSION['temp_scaff_info']['form'][$id][1];
 				
 			}else{
 				
 				$check = false;
 				
 				$etq = '';
 				
 				$type = '';
 				
 				$myForm->addDisabled('req_'.$id);
 				
 				$myForm->addDisabled('etq_'.$id);
 				
 				$myForm->addDisabled('type_'.$id);
 			}
 			
 			$checkReq = false;
 			
 			if (isset($_SESSION['temp_scaff_info']['form'][$id][2]))
 			
 				if ($_SESSION['temp_scaff_info']['form'][$id][2])
 			
 					$checkReq = true;
 			
 			$myForm->addEvent('field_'.$id, 'onclick', 'checkFormItem', 'field_'.$id, 'req_'.$id, 'etq_'.$id, 'type_'.$id);
 			
 			$myForm->addComment('etq1_'.$id, '<div align="center">'.$id.'</div>');
 			
 			$myForm->addComment('show_'.$id, '<div align="center">'.$myForm->getCheckBox('field_'.$id, $check).'</div>');
 			
 			$myForm->addComment('etq_'.$id, $myForm->getText('etq_'.$id, $etq, 10));
 			
 			$myForm->addComment('type_'.$id, $myForm->getSelect('type_'.$id, $arrTypes, $type));
 			
 			$mark = false;
 			
 			if (!isset($_SESSION['temp_scaff_info']['pk'])){
 			
 				if (!$count){
 				
 					$mark = true;
 				}
 				
 			}else{
 				
 				if ($_SESSION['temp_scaff_info']['pk'] == $id){
 					
 					$mark = true;
 				}
 				
 			}
 			
 			$myForm->addComment('req_'.$id, '<div align="center">'.$myForm->getCheckBox('req_'.$id, $checkReq).'</div>');
 			
 			$myForm->addComment('primary_'.$id, '<div align="center">'.$myForm->getRadioButton($id, 'primary_key', $mark).'</div>');
 			
 			$count++;
 		}
		
 		$myForm->addButton('btn0',OPF_SCAFF_13);
 			
 		$myForm->addComment('cm_space', '');
 		
 		$myForm->addComment('cm_space1', '');
 		
 		$myForm->addComment('cm_space2', '');
 		
 		$myForm->addComment('cm_space3', '');
 			
 		$myForm->addButton('btn1',OPF_SCAFF_14);
 			
 		$myForm->addEvent('btn1', 'onclick', 'toScaffStep3');
 		
 		$myForm->addEvent('btn0', 'onclick', 'newScaff',1);
 		
 		return $myForm->getForm(6);
 	}
 	
 	static public function formNewScaffStep1 (){
 		
 		$myForm = new OPF_myForm('formNewScaffStep1');
 		
 		$myForm->addComment('cm1:3', '');
 		
 		$myForm->addComment('cm2:3', '');
 		
 		$myForm->addComment('cm3:3', '');
 		
 		$myForm->addComment('cm4:3', '');
 		
 		$myForm->addComment('cm5:3', '');
 		
 		$myForm->addComment('cm6:3', '');
 		
 		$myForm->addComment('cm7:3', '');
 		
 		$table = '';
 		
 		if (isset($_SESSION['temp_scaff_info']['table_name'])){
 			
 			$table = $_SESSION['temp_scaff_info']['table_name'];
 		}

 		$myForm->addHelp('table_name', OPF_SCAFF_39);
 		
 		$myForm->addText(OPF_SCAFF_38,'table_name:3', $table);
 		
 		$myForm->addComment('cm8:3', '');
 		
 		$myForm->addComment('cm9:3', '');
 		
 		$myForm->addComment('cm10:3', '');
 		
 		$myForm->addComment('cm11:3', '');
 		
 		$myForm->addComment('cm12:3', '');
 		
 		$myForm->addComment('cm13:3', '');
 		
 		$myForm->addComment('cm14:3', '');
 		
 		$myForm->addComment('cm15', '');
 		
 		$myForm->addComment('cm16', '');
 		
 		$myForm->addButton('btn1',OPF_SCAFF_14);
 		
 		$myForm->addEvent('btn1', 'onclick', 'toScaffStep2');
 		
 		return $myForm->getForm(3);
 	}
 	
 	static public function getResultSelectFields ($objCnx, $tableName){
 			
 		$sqlTemp = 'SELECT * FROM '.$tableName.' LIMIT 1';
 			
 		return $objCnx->query($sqlTemp,false);
 	}
 	
 }
 
 class ess_master_tables extends OPF_myActiveRecord {
 	
 	public $id;
 	
 	public $name;
 	
 	public $description;
 	
 	public $user_id;
 	
 	public $datetime;
 	
 }
?>