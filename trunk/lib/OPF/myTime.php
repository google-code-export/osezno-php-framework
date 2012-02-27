<?php
/**
 * myTime
 *
 * Controlar tiempo de ejecucion de scripts.
 * <code>
 * Ejemplo de utilización:
 * <?php
 *
 * $myTime = new OPF_myTime;
 *
 * $myTime->timeStart();
 *
 * sleep(5);
 *
 * echo $myTime->timeEnd();
 *
 * ?>
 *
 * </code>
 * @uses Manejo de tiempo (fechas)
 * @package OPF
 * @version 0.1
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */
class OPF_myTime {

	private $startTime;

	private $endTime;

	private $microsegPassed;

	private $result_intDecimals = 10;

	/**
	 * Inicia el contador de tiempo.
	 *
	 * Inicia el contador de tiempo.
	 * @return integer
	 */
	public function timeStart(){

		list($useg, $seg) = explode(" ", microtime());

		return $this->startTime = ((float)$useg + (float)$seg);
	}

	/**
	 * Detiene el contador de tiempo.
	 *
	 * Detiene el contador de tiempo.
	 * @return integer
	 */
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