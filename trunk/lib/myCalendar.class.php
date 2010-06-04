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
		
		private $format = 'Y-m-d';
		
		
		private $arrDsem = array (
			0=>'D',1=>'L',2=>'M',3=>'M',4=>'J',5=>'V',6=>'S'
		);
		
		private $arrMonth = array (
			1=> 'Enero',
			2=> 'Febrero',
			3=> 'Marzo',
			4=> 'Abril',
			5=> 'Mayo',
			6=> 'Junio',
			7=> 'Julio',
			8=> 'Agosto',
			9=> 'Septiembre',
			10=>'Octubre',
			11=>'Noviembre',
			12=>'Diciembre'
		);
		
		private $arrYears = array ();
		
		public function __construct($nA, $nM, $update){
			
			$arrMonth = array ();
			
			foreach ($this->arrMonth as $id => $month){
				$arrMonth[] = array($id.'_'.$nA, $month);				
			}
			
			/**
			 * Construimos un arreglo de datos para los años
			 */
			for ($aIni=($nA-5);$aIni<($nA+5);$aIni++){
				$this->arrYears[] = array ($nM.'_'.$aIni,$aIni);
			} 			
			
			$idForm = 'calform_'.$update;
			
			$objMyForm = new myForm;
			
			/**
			 * Al averiguar por typeParamOnEvent
			 * si verificamos si es global o si es field 
			 * entonces debemos intercambiar entre las funciones 
			 * de javascript automaticamente que traen los
			 * datos del formulario.
			 * 
			 */
			
			$objMyForm->nomForm = $idForm; 
			
			$iniCell = '<td class="cellday">';
			$endCell = '</td>';
			
			$htm = '';		
			
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
							
							$iniA = '<a href="#" class="celldays_a" onclick="selectDate(\''.
								$nA.'-'.
								$nM.'-'.
								$nD.'\',\''.
								$update.'\')">';
							
							$endA = '</a>';
							
							if (($nM.$nD.$nA)==date('mjY'))
								$htm .= '<td class="cellday_today">'.$iniA.
									$nD.
									$endA.$endCell;
							else
								$htm .= $iniCell.$iniA.
									$nD.
									$endA.$endCell;
							$nD++;	
						}else{
							$htm .= $iniCell.'&nbsp;'.$endCell;
						}
						
					}else
					  $htm .= $iniCell.'&nbsp;'.$endCell;
				}
				
			}
			


			$objMyForm->setParamTypeOnEvent('field');
			
			$objMyForm->useFirstValueInSelect = false;
			
			$objMyForm->addEventJs('cal_month',
					'onchange',
					'calEventOnChange',
				array($update));
			
			$objMyForm->addEventJs('cal_year',
					'onchange',
					'calEventOnChange',
				array($update));
			
			$htm .= '<tr>';
				
			$htm .= '<td colspan="7" class="cell_control">'.
					$objMyForm->getSelect('cal_month',$arrMonth,$nM.'_'.$nA).
					' - '.
					$objMyForm->getSelect('cal_year',$this->arrYears,$nM.'_'.$nA).
					'</td>';
					
			$htm .= '</tr>';
			
			$htm .= '</table>';
			
			$htm .= '</td></tr></table>';
			
			$this->calOut = $htm;
		}
		
		
		public function getCalendar (){
			
			return $this->calOut; 
		}
		
		
	}
	
?>