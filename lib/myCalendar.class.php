<?php
	
/**
 * myCal
 * 
 * Calendario como componente de myForm 
 * 
 * @uses Llamado a calendario en formularios
 * @package OSEZNO-PHP-FRAMEWORK
 * @version 0.1
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 *  
 */
class myCal {
		
	public $hight = 300;
		
	public $width = 200;
		
	private $calOut;
		
	private $format = 'Y-m-d';
		
	private $arrDsem = array (
		1=>CAL_DAY1_LABEL,
		2=>CAL_DAY2_LABEL,
		3=>CAL_DAY3_LABEL,
		4=>CAL_DAY4_LABEL,
		5=>CAL_DAY5_LABEL,
		6=>CAL_DAY6_LABEL,
		7=>CAL_DAY7_LABEL
	);
		
	private $arrMonth = array (
		1=> CAL_MONTH1_LABEL,
		2=> CAL_MONTH2_LABEL,
		3=> CAL_MONTH3_LABEL,
		4=> CAL_MONTH4_LABEL,
		5=> CAL_MONTH5_LABEL,
		6=> CAL_MONTH6_LABEL,
		7=> CAL_MONTH7_LABEL,
		8=> CAL_MONTH8_LABEL,
		9=> CAL_MONTH9_LABEL,
		10=>CAL_MONTH10_LABEL,
		11=>CAL_MONTH11_LABEL,
		12=>CAL_MONTH12_LABEL
	);
		
	private $arrYears = array ();
		
	public function __construct($nA, $nM, $nDp, $update){
			
		$nDp = intval($nDp);
			
		$sw = false;
			
		$nSem = intval(date('W',mktime(0,0,0,$nM,1,$nA)));
			
		$nDsh = $nMsh = '';
			
		$arrMonth = array ();
			
		foreach ($this->arrMonth as $id => $month){
			$arrMonth[$nDp.'_'.$id.'_'.$nA] = $month;				
		}
			
		/**
		 * Construimos un arreglo de datos para los años
		 */
		for ($aIni=($nA-5);$aIni<($nA+5);$aIni++){
			$this->arrYears[$nDp.'_'.$nM.'_'.$aIni] = $aIni;
		} 			
			
		$objMyForm = new myForm;

		$iniCell = '<td class="cellday">';
		$endCell = '</td>';
			
		$htm = '';		
			
		$htm .= '<table cellpadding="0" cellspacing="0"><tr><td class="tablecal">';
			
		$htm .= '<table cellpadding="1" cellspacing="1" border=0>';
			
		$htm .= '<tr>';
			$htm .= '<td class="celldays">'.CAL_WK_LABEL.'</td>';
			
		foreach ($this->arrDsem as $id => $le){
			$htm .= '<td class="celldays">'.$le.'</td>';
		}
			
		$htm .= '</tr>';
			
		$nDmax = date('d',mktime(0,0,0,$nM+1,0,$nA));
			
		$nD = 1;
			
		$toShow = true;
			
		while ($nD <= $nDmax){
				
			foreach ($this->arrDsem as $id => $le){
					
				$w = date('N',mktime(0,0,0,$nM,$nD,$nA));
					
				if ($w==1||!$sw){
					$htm .= '<tr>';
					$sw = true;
						
					$htm .= '<td class="cell_week">'.$nSem.'</td>';
				}
						
				if ($nD <= $nDmax){
						
					if ($w==$id){
							
						$nMsh = $nM;
						if ($nM<10)
							$nMsh = '0'.$nM;
								
						$nDsh = $nD; 	
						if ($nD<10)
							$nDsh = '0'.$nD;
							
						$iniA = '<a href="#" class="celldays_a" onclick="selectDate(\''.
							$nA.'-'.
							$nMsh.'-'.
							$nDsh.'\',\''.
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
						
				}else{
				  $htm .= $iniCell.'&nbsp;'.$endCell;
				}
			}
			$nSem = intval(date('W',mktime(0,0,0,$nM,$nD,$nA)));
		}
			
		$objMyForm->setParamTypeOnEvent('field');
			
		$objMyForm->selectUseFirstValue = false;
			
		$objMyForm->addEvent('cal_month',
				'onchange',
				'MYFORM_calOnChange',$update);
			
		$objMyForm->addEvent('cal_year',
				'onchange',
				'MYFORM_calOnChange',$update);
			
		$htm .= '<tr>';
				
		$htm .= '<td colspan="8" class="cell_control">'.
				$objMyForm->getSelect('cal_month',$arrMonth,$nDp.'_'.$nM.'_'.$nA).
				' - '.
				$objMyForm->getSelect('cal_year',$this->arrYears,$nDp.'_'.$nM.'_'.$nA).
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