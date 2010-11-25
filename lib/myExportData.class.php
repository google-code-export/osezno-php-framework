<?php


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
	 * Exportar datos desde una consulta.
	 * 
	 * @param $sql	Consulta SQL
	 * @param $format	Formato de archivo
	 * @param $filePath	Guardar en archivo fisico
	 * @return string
	 */
	public function __construct($sql, $format = 'html', $filePath = ''){
		
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
		
		return $success;
	}
	
	/**
	 * Contruye el resultado segun el tipo de archivo
	 * @return string
	 */
	private function buildResult (){
		
		//TODO: Casos de uso, pdf
		
		$out = '';
 		
		switch ($this->format){
			case 'pdf':
				
			# TODO: Pdf file
    
			break;
			default:
				
				$out .= '<table border="1">';
				
				foreach ($this->resSql as $row){
 			
 					$out .= '<tr>';
 			
 					foreach ($row as $key => $val){

 						$out .= '<td>';
 				
 						$out .= $val;
 			
 						$out .= '</td>';
 					}
 			
 				$out .= '</tr>';
 				}
 		
 				$out .= '</table>';
 				
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