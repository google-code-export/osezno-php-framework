<?php

/**
 * myExportData
 * 
 * La clase myExportData ayuda con algunos procedimientos de consultas SQL cuando se requiere obtener un archivo en un formato especifico con elresultado de la consulta.
 *  
 * @uses Exportar cosultas SQL 
 * @package OSEZNO-PHP-FRAMEWORK
 * @version 0.1 
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */
class myExportData {
	
	/**
	 * Objeto de conexion DB
	 * @access private
	 * @var object
	 */
	private $myAct;
	
	/**
	 * Formatos validos de resultado
	 * @access private
	 * @var array
	 */
	private $arValidFormat = array (
		'html','xls','pdf'
	);
	
	/**
	 * Formato de resultado
	 * @access private
	 * @var string
	 */
	private $format = '';

	/**
	 * Informacion del ultimo error al exportar
	 * @access private
	 * @var string
	 */
	private $error = '';
	
	/**
	 * Ruta del archivo de salida
	 * @access private
	 * @var string
	 */
	private $filePath = '';
	
	/**
	 * Resultado de la consulta sql
	 * @access private
	 * @var object
	 */
	private $resSql;
	
	/**
	 * El resultado en texto puro
	 * @access private
	 * @var string
	 */
	private $resText = '';
	
	/**
	 * Id de la lista dinamica asociada si existe
	 * @access private
	 * @var string
	 */
	private $idList = '';
	
	/**
	 * Anchos de columnas PDF
	 * @access private 
	 * @var array
	 */
	private $width = array();
	
	/**
	 * Exportar datos desde una consulta.
	 * 
	 * Contructor de la clase que incia tambien el proceso para la generacion de la consulta sql a exportar.
	 * 
	 *<code>
	 *
	 *Ejemplo 1: Salida a un archivo físico:
	 *
	 *<?php
	 *	
 	 *	$myExport = new myExportData('SELECT fiel1, field2, field3 FROM table','pdf','/var/www/html/project/report/report.pdf');
 	 *	
	 *	# Cuando generamos un archivo en formato PDF es prescindible ajustar el tamaño de las columnas pues no es posible calcular su valor automaticamente.
 	 *
	 *	$myExport->setWidth('fiel1',100);
	 *
	 *	$myExport->setWidth('field2',150);
	 *
	 *	$myExport->setWidth('field3',200);
	 *
	 *	$myExport->getResult();
	 *
	 *?>
	 *
	 *Ejemplo 2: Salida a un archivo descargable:
	 *
	 *<?php
	 *
	 *	$myExport = new myExportData('SELECT * FROM table','xls');	
	 *
	 *	$xls = $myExport->getResult();
	 *
	 *	header ('Content-type: application/x-msexcel');
	 *
	 *	header ('Content-Disposition: attachment; filename="file.xls"');
	 *
	 *	header ('Content-Length: '.strlen($xls));
	 *
	 *	if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")){
	 *
	 *		header('Pragma: private');
	 *
	 *		header('Cache-control: private, must-revalidate');
	 *	}	
 	 *
	 *	echo $xls;
	 *
 	 *?>
	 *
	 *</code> 
	 * @param string 	$sql	Consulta SQL
	 * @param string	$format	Formato de archivo (pdf,xls,html)
	 * @param string	$filePath	Guardar en archivo fisico
	 * @param string	$id_list	Nombre de lista dinamica
	 * @return boolean
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
	 * @access private
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
							
							if(isset($this->width[$key])){
								$widthCol = $this->width[$key];
							}else
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
						
						if(isset($this->width[$key])){
							$widthCol = $this->width[$key];
						}else
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
	 * Obtener error.
	 * 
	 * Obtiene el ultimo error generado en caso de que la generacion del archivo no haya sido exitosa o la consulta sql sea erronea.
	 * <code>
	 * 
	 * <?php
	 * 
	 * if (!$myExport = new myExportData('SELECT * FROM table','xls')){
	 * 
	 * 		echo $myExport->getError();
	 * }
	 * 
	 * ?>
	 * </code>
	 * @return string
	 */
	public function getError (){
		
		return $this->error;
	}
	
	/**
	 * Configurar ancho de culumna.
	 * 
	 * Sobre un salida PDF permite definir el ancho que usara una determinada columna en numero de pixeles.
	 * @param string $name
	 * @param integer $width
	 */
	public function setWidthInColumn($name, $width){
		
		$this->width[$name] = $width;
	}
	
	/**
	 * Construye el archivo de salida
	 * @access private 
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
	 * Obtiene archivo o resultado.
	 * 
	 * Devuelve el resultado de la consulta SQL mediante un archivo.
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