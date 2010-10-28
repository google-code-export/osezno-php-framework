<?php
/**
 * myTime
 *
 * @uses Manejo de Tiempo y fechas
 * @package OSEZNO FRAMEWORK (2008-2011)
 * @version 0.1
 * @author Jose Ignacio Gutierrez Guzman jose.gutierrez@osezno-framework.org
 *
 * Ultima actualizacion: 30 Enero 2007
 *
 * Control de Cambios:
 *
 */
class myTime {

	var $startTime;
	var $endTime;
	var $microsegPassed;
	var $result_intDecimals = 10;

	public function timeStart(){
		list($useg, $seg) = explode(" ", microtime());

		$this->startTime = ((float)$useg + (float)$seg);
	}

	public function timeEnd(){
		list($useg, $seg) = explode(" ", microtime());

		$this->endTime = ((float)$useg + (float)$seg);
		$this->calcTimePassed();

		return $this->microsegPassed;
	}

	private function calcTimePassed (){
		$this->microsegPassed = number_format($this->endTime - $this->startTime,$this->result_intDecimals,',','.');
		return $this->microsegPassed;
	}
}
?>