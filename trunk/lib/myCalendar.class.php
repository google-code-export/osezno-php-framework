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
		
		
		public $arrMonth = array (
		
		);	
		
		public function __construct($get = ''){
			
			$htm = '';		
			
			$htm .= '<table border="1" width="300"><tr><td>'.$get['div'].'</td></tr>';
			
			$htm .= '<tr><td>';
			
			$htm .= 'trigger:Launcher_'.$get['update']."<br>";
			$htm .= 'to update:'.$get['update']."<br>";
			
			$htm .= '</td></tr></table>';
			
			$this->calOut = $htm;
		}
		
		
		public function getCalendar (){
			
			return $this->calOut; 
		}
		
		
	}
	
?>