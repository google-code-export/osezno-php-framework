<?php

/**
 * Multicell solution
 * 
 * Clase alterna para resolver el problema de aplicar multicells con un alto definido.
 * Solución aportada desde http://www.fpdf.org/en/script/script3.php <oliver@fpdf.org>
 * 
 * @ignore
 */
class PDF_MC_Table extends FPDF
{
	private $widths;
	
	private $aligns;

	/**
	 * @ignore
	 */
	public function SetWidths($w){
		
		$this->widths=$w;
	}

	/**
	 * @ignore
	 */
	public function SetAligns($a){
		
		$this->aligns=$a;
	}


	/**
	 * @ignore
	 */
	public function Row($data){
		
		//Calculate the height of the row
		$nb=0;
		
		for($i=0;$i<count($data);$i++)
		
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		
		$h=5*$nb;
		
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++){
			
			$w=$this->widths[$i];
			
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			
			//Save the current position
			$x=$this->GetX();
			
			$y=$this->GetY();
			
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
			
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		
		//Go to the next line
		$this->Ln($h);
	}

   /**
	* @ignore
	*/
	public function CheckPageBreak($h){
		
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
		
			$this->AddPage($this->CurOrientation);
	}
	
   /**
	* @ignore
	*/
	public function NbLines($w,$txt){
		
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		
		$s=str_replace("\r",'',$txt);
		
		$nb=strlen($s);
		
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		
		$sep=-1;
		
		$i=0;
		
		$j=0;
		
		$l=0;
		
		$nl=1;
		
		while($i<$nb){
			
			$c=$s[$i];
			
			if($c=="\n"){
				
				$i++;
				
				$sep=-1;
				
				$j=$i;
				
				$l=0;
				
				$nl++;
				
				continue;
			}
			
			if($c==' ')
			
				$sep=$i;
			
			$l+=$cw[$c];
			
			if($l>$wmax){
				
				if($sep==-1){
					
					if($i==$j)
					
						$i++;
				}else
					$i=$sep+1;
				
				$sep=-1;
				
				$j=$i;
				
				$l=0;
				
				$nl++;
				
			}else
			
				$i++;
		}
		return $nl;
	}
	
}

				
/**
 * myExportData
 * 
 * La clase myExportData ayuda con algunos procedimientos de consultas SQL cuando se requiere obtener un archivo en un formato especifico con elresultado de la consulta.
 *  
 * @uses Exportar cosultas SQL 
 * @package OPF
 * @version 0.1 
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */
class OPF_myExportData {
        
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
         * Campos a ocultar en la consulta SQL
         * @access private  
         * @var array
         */
        private $arrFieldHiden = array ();
        
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
         *      $myExport = new OPF_myExportData('SELECT fiel1, field2, field3 FROM table','pdf','/var/www/html/project/report/report.pdf');
         *      
         *      # Cuando generamos un archivo en formato PDF es prescindible ajustar el tamaño de las columnas pues no es posible calcular su valor automaticamente.
         *
         *      $myExport->setWidth('fiel1',100);
         *
         *      $myExport->setWidth('field2',150);
         *
         *      $myExport->setWidth('field3',200);
         *
         *      $myExport->getResult();
         *
         *?>
         *
         *Ejemplo 2: Salida a un archivo descargable:
         *
         *<?php
         *
         *      $myExport = new OPF_myExportData('SELECT * FROM table','xls');  
         *
         *      $xls = $myExport->getResult();
         *
         *      header ('Content-type: application/x-msexcel');
         *
         *      header ('Content-Disposition: attachment; filename="file.xls"');
         *
         *      header ('Content-Length: '.strlen($xls));
         *
         *      if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")){
         *
         *              header('Pragma: private');
         *
         *              header('Cache-control: private, must-revalidate');
         *      }       
         *
         *      echo $xls;
         *
         *?>
         *
         *</code> 
         * @param string        $sql    Consulta SQL
         * @param string        $format Formato de archivo (pdf,xls,html)
         * @param string        $filePath       Guardar en archivo fisico
         * @param string        $id_list        Nombre de lista dinamica
         * @return boolean
         */
        public function __construct($sql, $format = 'html', $filePath = '', $idList = ''){
                
                $numArg = func_num_args();
                
                if ($numArg == 5){
                        
                        $arrFieldHiden = func_get_arg(4);

                        $this->arrFieldHiden = explode(',',$arrFieldHiden);
                }
                
                $success = true; 
                
                $this->format = $format;
                
                $this->filePath = $filePath;
                
                if (in_array($format,$this->arValidFormat)){
                        
                        $this->myAct = new OPF_myActiveRecord();
                        
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
        
        
        private $objPDF;
        
        private function Header($ori){

                $this->objPDF->Image('../themes/'.THEME_NAME.'/pdflogo/pdf_logo.jpg',10,10,0,0,'','http://www.osezno-framework.org');

                $this->objPDF->SetFont('Arial','',8);
                
                $large = 0;
                
                switch ($ori){
                	case 'L':
                		$large = 275;
                	break;
                	case 'P':
                		$large = 190;
                	break;
                }
                
                
                $this->objPDF->Cell($large,10,REPORT_TITLE.$_SERVER['HTTP_REFERER'],1,0,'R');
                
                $this->objPDF->Ln(10);
        }
        
        /**
         * Contruye el resultado segun el tipo de archivo
         * @access private
         * @return string
         */
        private function buildResult (){
                
        	$fromListExport = false;
        	
        	if (count($this->arrFieldHiden)){
        		
        		$fromListExport = true;
        	}
        	
                $out = '';
                
                $widthList = 0;
                
                if ($this->idList){
                        
                    $myList = new OPF_myList($this->idList);
                
                    $this->width = $myList->getVar('arrayWidthsCols');
                
                    $widthList = $myList->getVar('width');
                    
                    $numFldsAftd = $myList->getVar('numFldsAftd');
                    
                    $widthDefa = intval($widthList/$numFldsAftd); 
                }
                
                switch ($this->format){
                        
                        case 'pdf':
                                
                                $swTl = 0;
                                
                                $ori = 'P';
                                if ($widthList>900)
                                	$ori = 'L';
                                
                                $this->objPDF = new PDF_MC_Table($ori);

                                $this->objPDF->SetLineWidth(.1);
                                
                                $this->objPDF->AddPage();
                                
                                $this->Header($ori);
                                
                                foreach ($this->resSql as $row){
                                        
                                        // Titles
                                        if (!$swTl){

                                        	    $this->objPDF->SetFont('Arial','',10);
                                        	
                                                $intTitl = 1;
                                                
                                                foreach ($row as $key => $val){

                                                        if (in_array($intTitl,$this->arrFieldHiden) || $fromListExport == false){
                                                        
                                                            if(isset($this->width[htmlentities($key, ENT_QUOTES)])){
                                                                	
                                                               $widthCol = $this->width[htmlentities($key, ENT_QUOTES)]+40;
                                                               
                                                             }else
                                                               $widthCol = $widthDefa+40;
                                                
                                                                $this->objPDF->Cell(($widthCol/6),5,ucwords(strtolower($key)),1,0,'C',false);
                                                        
                                                        }
                                                        
                                                        $intTitl++;
                                                        
                                                }

                                                $this->objPDF->Ln();
                                                
                                                $swTl = 1;
                                                
                                                $this->objPDF->SetFont('Arial','',7);
                                        }
                                        
                                        $intTitl = 1;
                                        
                                        $estaFila = array();
                                        
                                        $estaFilaAnchos = array();
                                        
                                        $estaFilaAligns = array();
                                        
                                        foreach ($row as $key => $val){
                                                
                                                if (in_array($intTitl,$this->arrFieldHiden) || $fromListExport == false){
                                                
                                                   if(isset($this->width[htmlentities($key, ENT_QUOTES)])){
                                                        	
                                                      $widthCol = $this->width[htmlentities($key, ENT_QUOTES)]+40;
                                                      
                                                   }else
                                                      
                                                   	  $widthCol = $widthDefa+40;
                                                
                                                    $align = 'L';
                                                      
                                                    if (is_numeric($val))

                                                       $align = 'R';
                                                
                                                     $estaFila[] = utf8_decode($val);

                                                     $estaFilaAligns[] = ($widthCol/6);
                                                        
                                                     $estaFilaAnchos[] = ($widthCol/6);
                                                
                                                }
                                                
                                                $intTitl++;
                                                
                                        }
                                        
                                        $this->objPDF->SetAligns($estaFilaAligns);
                                        
                                        $this->objPDF->SetWidths($estaFilaAnchos);
                                        
                                        $this->objPDF->Row($estaFila);
                                }
                                
                                $out .= $this->objPDF->Output('','S');
                                
                        break;
                        default:
                                
                                $swTl = 0;
                                
                                if ($this->format == 'html'){
                                        
                                        $out .= '<html>';
                                        
                                        $out .= '<head><style type="text/css">td{font-family: Arial, Helvetica, sans-serif;font-size: 13px;}</style></head>';
                                        
                                        $out .= '<body>';
                                        
                                        $out .= '<table border="0" cellspacing="0" cellpadding="0"><tr><td width="30%"><img src="'.$GLOBALS['urlProject'].'/themes/'.THEME_NAME.'/pdflogo/pdf_logo.jpg'.'"></td><td width="70%">'.REPORT_TITLE.$_SERVER['HTTP_REFERER'].'</td></tr>';
                                        
                                        $out .= '<tr><td bgcolor="#000000" colspan="2">';
                                        
                                        $out .= '<table border="0" cellspacing="1" cellpadding="0" width="100%">';
                                }else
                                        $out .= '<table border="1">';
                                
                                $bg = '';
                                
                                if ($this->format == 'html')
                                        $bg = 'bgcolor="#FFFFFF"';                                      
                                        
                                
                                foreach ($this->resSql as $row){
                        
                                        // Titles
                                        if (!$swTl){
                                                
                                                $out .= '<tr>';
                        
                                                $intTitl = 1;
                                                
                                                foreach ($row as $key => $val){

                                                        if (in_array($intTitl,$this->arrFieldHiden) || $fromListExport == false){
                                                        
                                                                $widthCol = '';
                                                
                                                                if (isset($arWidth[htmlentities($key, ENT_QUOTES)])){
                                                                        
                                                                        $widthCol = 'width="'.$arWidth[htmlentities($key, ENT_QUOTES)].'"';
                                                                }
                                                
                                                                $out .= '<td '.$widthCol.' align="center" '.$bg.'>';

                                                                $out .= ucwords(strtolower($key));
                        
                                                                $out .= '</td>';
                                                        
                                                        }
                                                        
                                                        $intTitl++;
                                                }
                        
                                                $out .= '</tr>';
                                                
                                                $swTl = 1;
                                        }
                                        
                                        $out .= '<tr>';
                        
                                        $intTitl = 1;
                                        
                                        foreach ($row as $key => $val){

                                                if (in_array($intTitl,$this->arrFieldHiden) || $fromListExport == false){
                                                
                                                        $align = 'left';
                                                        if (is_numeric($val))
                                                                $align = 'right';
                                                
                                                        $out .= '<td '.$bg.' align="'.$align.'">';
                                
                                                        $out .= utf8_decode($val);
                        
                                                        $out .= '</td>';
                                                }
                                                
                                                $intTitl++;
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
         * if (!$myExport = new OPF_myExportData('SELECT * FROM table','xls')){
         * 
         *              echo $myExport->getError();
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