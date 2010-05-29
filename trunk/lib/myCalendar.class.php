<?php
	
	/**
	 * 
	 * @author José Ignacio Gutiérrez Guzmán [jose.gutierrez@osezno-framework.org]
	 *
	 */
	class myCal {
		
		public $hight = 300;
		
		public $width = 200;
		
		private $calOut;
		
		public $format = 'Y-m-d';
		
		
		public $arrDsem = array (
			0=>'D',1=>'L',2=>'M',3=>'M',4=>'J',5=>'V',6=>'S'
		);
		
		public $arrMonth = array (
			array(1,'Enero'),
			array(2,'Febrero'),
			array(3,'Marzo'),
			array(4,'Abril'),
			array(5,'Mayo'),
			array(6,'Junio'),
			array(7,'Julio'),
			array(8,'Agosto'),
			array(9,'Septiembre'),
			array(10,'Octubre'),
			array(11,'Noviembre'),
			array(12,'Diciembre')
		);
		
		public $arrYears = array ();
		
		public function __construct($get = ''){
			
			$idForm = 'calform_'.$get['update'];
			
			$objMyForm = new myForm;
			
			$objMyForm->nomForm = $idForm; 
			
			$iniCell = '<td class="cellday">';
			$endCell = '</td>';
			

			$nA = date('Y');
			$nM = 5; 
			
			
			$htm = '';		
			
			//$htm .= '';
			
			$htm .= 'hi<form method="post" onsubmit="return false" name="'.$idForm.'" id="'.$idForm.'">chao';
			
			$htm .= '<table cellpadding="0" cellspacing="0"><tr><td class="tablecal">';
			
			$htm .= '<table cellpadding="1" cellspacing="1">';
			
			$htm .= '<tr>';
			foreach ($this->arrDsem as $id => $le){
				$htm .= '<td class="celldays">'.$le.'</td>';
			}
			$htm .= '</tr>';
			
			$nDmax = date('d',mktime(0,0,0,$nM+1,0,$nA));
			
			$nD = 1;
			
			$toShow = true;
			
			while ($nD <= $nDmax){
				
				foreach ($this->arrDsem as $id => $le){
					
					$w = date('w',mktime(0,0,0,$nM,$nD,$nA));
					
					if ($w==0)
						$htm .= '<tr>';
							
					if ($nD <= $nDmax){
						
						if ($w==$id){
							if (($nM.$nD.$nA)==date('mjY'))
								$htm .= '<td class="cellday_today">'.$nD.$endCell;
							else
								$htm .= $iniCell.$nD.$endCell;
							$nD++;	
						}else{
							$htm .= $iniCell.'&nbsp;'.$endCell;
						}
						
					}else
					  $htm .= $iniCell.'&nbsp;'.$endCell;
				}
			}
			
			/**
			 * Construimos un arreglo de datos para los años
			 */
			for ($aIni=($nA-5);$aIni<($nA+5);$aIni++){
				$this->arrYears[] = array ($aIni,$aIni);
			} 

			$objMyForm->useFirstValueInSelect = false;
			
			$objMyForm->addEventJs('cal_month','onchange','calEventOnChangeMonth',array($get['update']));
			
			$objMyForm->addEventJs('cal_year','onchange','calEventOnChangeYear',array($get['update']));
			
			$htm .= '<tr>';
				$htm .= '<td colspan="7" class="cell_control">'.$objMyForm->getSelect('cal_month',$this->arrMonth,$nM).' - '.$objMyForm->getSelect('cal_year',$this->arrYears,$nA).'</td>';
			$htm .= '</tr>';
			
			$htm .= '</table>';
			
			$htm .= '</td></tr></table>';
			
			$htm .= '</form>';
			
			$this->calOut = $htm;
		}
		
		
		public function getCalendar (){
			
			return $this->calOut; 
		}
		
		
	}
	
?>