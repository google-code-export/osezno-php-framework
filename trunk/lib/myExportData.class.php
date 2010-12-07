<?php

/**
 * 
 * @package OSEZNO-PHP-FRAMEWORK 
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */
class myExportData {
	
	/**
	 * Objeto de conexion DB
	 * @var object
	 */
	private $myAct;
	
	/**
	 * Formatos validos de resultado
	 * @var array
	 */
	private $arValidFormat = array (
		'html','xls','pdf'
	);
	
	/**
	 * Formato de resultado
	 * @var string
	 */
	private $format = '';

	/**
	 * Informacion del ultimo error al exportar
	 * @var string
	 */
	private $error = '';
	
	/**
	 * Ruta del archivo de salida
	 * @var string
	 */
	private $filePath = '';
	
	/**
	 * Resultado de la consulta sql
	 * @var object
	 */
	private $resSql;
	
	/**
	 * El resultado en texto puro
	 * @var string
	 */
	private $resText = '';
	
	/**
	 * Id de la lista dinamica asociada si existe
	 * @var string
	 */
	private $idList = '';
	
	/**
	 * Exportar datos desde una consulta.
	 * 
	 * @param $sql	Consulta SQL
	 * @param $format	Formato de archivo
	 * @param $filePath	Guardar en archivo fisico
	 * @param $id_list	Nombre de lista dinamica
	 * @return string
	 */
	public function __construct($sql, $format = 'html', $filePath = '', $idList = ''){
		
		$success = true; 
		
		$this->format = $format;
		
		$this->filePath = $filePath;
		
		if (in_array($format,$this->arValidFormat)){
			
			$this->myAct = new myActiveRecord();
			
			$this->resSql = $this->myAct->query($sql);
			
			$this->error = $this->myAct->getErrorLog(false);
			
		}else{
			$success = false;
			
			$this->error = MYEXPORT_ERROR_INVALID_FORMAT;
		}
		
		if ($idList)
			$this->idList = $idList;
		
		return $success;
	}
	
	/**
	 * Contruye el resultado segun el tipo de archivo
	 * @return string
	 */
	private function buildResult (){
		
		$out = '';
 		
		$arWidth = array();
		
		$arAli = array();
		
		$width = '';
		
		if ($this->idList){
			
			$myList = new myList($this->idList);
		
			$arWidth = $myList->getVar('arrayWidthsCols');
		
			$widthList = $myList->getVar('widthList');
			
			$arAli = $myList->getVar('arrayAliasSetInQuery');
		}
		
		switch ($this->format){
			
			case 'pdf':
				
				$swTl = 0;
				
				$pdf = new FPDF();
				
				$pdf->SetFont('Arial','',8);
				
				$pdf->SetLineWidth(.1);
				
				$pdf->AddPage();
				
				foreach ($this->resSql as $row){
					
					if (!$swTl){
						
						foreach ($row as $key => $val){
							$widthCol = 40;
						
							if (isset($arWidth[$key])){
								$widthCol = $arWidth[$key];
							}

							if (isset($arAli[$key]))
								list($key,$data_type) = explode('::',$arAli[$key]);
							
							$pdf->Cell(($widthCol/6),3,ucwords(strtolower($key)),1,0,'C',false);
						}

						$pdf->Ln();
						
						$swTl = 1;
					}
					
					foreach ($row as $key => $val){
						
						$widthCol = 40;
						
						if (isset($arWidth[$key])){
							$widthCol = $arWidth[$key];
						}
						
						$align = 'L';
						if (is_numeric($val))
							$align = 'R';
						
						$pdf->Cell(($widthCol/6),3,$val,1,0,$align);
						
					}
					$pdf->Ln();
				}
				
				$out .= $pdf->Output('','S');
			 	
			break;
			default:
				
				$swTl = 0;
				
				if ($this->format == 'html'){
					
					$out .= '<html>';
					
					$out .= '<head><style type="text/css">td{font-family: Arial, Helvetica, sans-serif;font-size: 13px;}</style></head>';
					
					$out .= '<body>';
					
					$out .= '<table border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#000000">';
					
					$out .= '<table border="0" cellspacing="1" cellpadding="0">';
				}else
					$out .= '<table border="1">';
				
				$bg = '';
				
				if ($this->format == 'html')
					$bg = 'bgcolor="#FFFFFF"';					
					
				foreach ($this->resSql as $row){
 			
					if (!$swTl){
						
						$out .= '<tr>';
 			
 						foreach ($row as $key => $val){

 							$widthCol = '';
						
							if (isset($arWidth[$key])){
								$widthCol = 'width="'.$arWidth[$key].'"';
							}
						
 							$out .= '<td '.$widthCol.' align="center" '.$bg.'>';

 							if (isset($arAli[$key]))
								list($key,$data_type) = explode('::',$arAli[$key]);
 							
 							$out .= ucwords(strtolower($key));
 			
 							$out .= '</td>';
 						}
 			
 						$out .= '</tr>';
						
						$swTl = 1;
					}
					
 					$out .= '<tr>';
 			
 					foreach ($row as $key => $val){

 						$align = 'left';
						if (is_numeric($val))
							$align = 'right';
 						
 						
 						$out .= '<td '.$bg.' align="'.$align.'">';
 				
 						$out .= $val;
 			
 						$out .= '</td>';
 					}
 			
 					$out .= '</tr>';
 					
 					
 				}
 		
 				$out .= '</table>';
 				
 				if ($this->format == 'html'){
					$out .= '</td></tr></table>';
					
					$out .= '</body></html>';
 				}
 				
			break;
		}
 		
 		$this->resText = $out;
	}
	
	/**
	 * Obtiene el ultimo error generado
	 * @return string
	 */
	public function getError (){
		
		return $this->error;
	}
	
	/**
	 * Construye el archivo de salida 
	 * @return file
	 */
	private function buildFileOut (){
		
		$success = true;	
		
		$gest = @fopen($this->filePath, 'w');
		
		if ($gest){
			
			$this->buildResult();
			
			fwrite($gest,$this->resText);
			
			fclose($gest);
			
		}else {
			$this->error = MYEXPORT_ERROR_CREATE_FILE;
			
			$success = false;
		}
		
		return $success;
	}
	
	/**
	 * Obtiene el resultado dado
	 * @return string
	 */
	public function getResult (){
		
		$return = '';
		
		if (!$this->error){
			
			if ($this->filePath){
			
				if (!$this->buildFileOut())
				
					$return = $this->getError();
				
			}else{
				
				$this->buildResult();
				
				$return = $this->resText;
				
			}	
			
		}else{
			
			$return = $this->getError();	
		}
		
		return $return;
	}
	
}

?>