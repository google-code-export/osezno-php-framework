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
		
		);	
		
		public function __construct($get = ''){
			
			$nA = date('Y');
			
			$nM = date('m'); 
			
			$htm = '';		
			
			$htm .= '';
			
			$htm .= '<table border="1">';
			
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
							$htm .= '<td>'.$nD.'</td>';
							$nD++;	
						}else{
							$htm .= '<td>&nbsp;</td>';
						}
						
					}
					
				}
				
			}

			
			
			$htm .= '</table>';
			
			$this->calOut = $htm;
		}
		
		
		public function getCalendar (){
			
			return $this->calOut; 
		}
		
		
	}
	
?>