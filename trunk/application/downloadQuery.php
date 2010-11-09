<?php

	include '../configApplication.php';

	if (isset($_GET['id_list'])){
		
		$content_type = '';
		
		$content_disposition = '';

		$content_disposition = 'Content-Disposition: attachment; filename=query.'.$_GET['format'];
		
		$idList = $_GET['id_list'];
		
		$objList = new myList($idList);
		
		$myAct = new myActiveRecord();
		
		$myAct->query($objList->getVar('sql'));
		
 		/**
 		 * Where rules
 		 */
 		$sqlWhere = '';
 		
 		$arWrRls = $objList->getVar('arrayWhereRules');
 		
		if (count($arWrRls)){
			$sqlWhere = ' WHERE ';
			
			$rules = '';
			
			foreach ($arWrRls as $id => $rule){
				$rules .= $rule.' ';
			}
		
			$sqlWhere .= substr($rules, 3);
		}
 		
 		/**
 		 * Order Method
 		 */
		$sqlOrder = '';
		
		$arOrMtd = $objList->getVar('arrayOrdMethod');
		
		if ($arOrMtd!==false){
		
			foreach ($arOrMtd as $column => $method){
				if ($method){
				
					if (!$sqlOrder)
						$sqlOrder = ' ORDER BY ';
				
					$sqlOrder .= $column.' '.$method.', ';
				}
			}
		}
		
		$sqlOrder = substr($sqlOrder,0,-2);
		
		/**
		 * Limit
		 */
		$sqlLimit = '';
		
		$usPg = $objList->getVar('usePagination');
		
		if ($usPg && ($_GET['usepg']=='t')){
			
			$rdsPg = $objList->getVar('recordsPerPage');
			
			$rdsPgFr = $objList->getVar('recordsPerPageForm');
			
			$cntPg = $objList->getVar('currentPage');
			
			$sqlLimit .= ' LIMIT  '.($rdsPg*$rdsPgFr).' OFFSET '.(($cntPg*$rdsPg)*$rdsPgFr);
		}
 		
 		$sql = $myAct->getSqlLog().''.$sqlWhere.''.$sqlOrder.''.$sqlLimit;
 		
 		$resSql = $myAct->query($sql,false);

 		$xlsOut = $htmlOut = $pdfOut = '';
 		
		switch ($_GET['format']){
			
			case 'xls':
				
				$content_type = 'Content-type: application/x-msexcel';
				
				$xlsOut = '';
 		
 				$xlsOut .= '<table border="1">';
				
				foreach ($resSql as $row){
 			
 					$xlsOut .= '<tr>';
 			
 					foreach ($row as $key => $val){

 						$xlsOut .= '<td>';
 				
 						$xlsOut .= $val;
 				
 						$xlsOut .= '</td>';
 					}
 			
 					$xlsOut .= '</tr>';
 				}
 		
 				$xlsOut .= '</table>';
 		
			break;
			
			case 'html':
				
				$content_type = 'Content-type: text/html';
				
				$htmlOut = '';
 		
 				$htmlOut .= '<table border="1">';
 		
 				foreach ($resSql as $row){
 			
 					$htmlOut .= '<tr>';
 			
 					foreach ($row as $key => $val){

 						$htmlOut .= '<td>';
 				
 						$htmlOut .= $val;
 				
 						$htmlOut .= '</td>';
 					}
 			
 					$htmlOut .= '</tr>';
 				}
 		
 				$htmlOut .= '</table>';
 		
			break;
			
			case 'pdf':
				$content_type = 'Content-type: application/pdf';

			break;
		}
 		
		header ($content_type);
 		header ($content_disposition);
		
 		if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")){
    		
 			header('Pragma: private');
 			
    		header('Cache-control: private, must-revalidate');
 		}
 		
 		echo $xlsOut.$htmlOut.$pdfOut;
	}
	
	die ();
	
?>	