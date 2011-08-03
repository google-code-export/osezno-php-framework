<?php

if (false == class_exists('xajaxPlugin') || false == class_exists('xajaxPluginManager'))
{
	$sBaseFolder = dirname(dirname(dirname(__FILE__)));
	$sXajaxCore = $sBaseFolder . '/xajax_core';

	if (false == class_exists('xajaxPlugin'))
		require $sXajaxCore . '/xajaxPlugin.inc.php';
	if (false == class_exists('xajaxPluginManager'))
		require $sXajaxCore . '/xajaxPluginManager.inc.php';
}


if (!defined ('XAJAX_UPLOAD_FUNCTION')) define ('XAJAX_UPLOAD_FUNCTION', 'upfunction');

require_once dirname(__FILE__) . '/xajaxUploadFunction.inc.php';

class clsProgressUpload extends xajaxRequestPlugin
{


//--------------------------------------------------------------------------------------------------------------------------------
	
	private $sCallName = "ProgressUpload";
	private $sDefer;
	private $sJavascriptURI;
	private $bInlineScript;
	
	private $iUploadProgressDelay = 1500;
	private $sUploadProgressType = false;
	private $bUploadProgressComet = false;

	private $sUploadProgressTarget = "xjxProgressUploadIframe";
	private $sRequestedFunction = NULL;

	private $sXajaxPrefix = "xajax_";	
//--------------------------------------------------------------------------------------------------------------------------------

	public function clsProgressUpload() 
	{
		$this->sDefer = ''; 
		$this->sJavascriptURI = '';
		$this->bInlineScript = false;
	

		if (isset($_GET['xjxExtUP'])) $this->sRequestedFunction = $_GET['xjxExtUP'];
		if (isset($_POST['xjxExtUP'])) $this->sRequestedFunction = $_POST['xjxExtUP'];	
	
		if (isset($_POST['APC_UPLOAD_PROGRESS'])) $this->sRequestedFunction = $_POST['xjxExtUP'];	
	}
	
	

//--------------------------------------------------------------------------------------------------------------------------------
	public function configure($sName, $mValue)
	{
		
		
		switch ($sName) 
		{
			case 'scriptDeferral':
							if (true === $mValue || false === $mValue) 
							{
								if ($mValue) $this->sDefer = 'defer ';
								else $this->sDefer = '';
							}
							break;
			
			case 'javascript URI' :
							$this->sJavascriptURI = $mValue;
							break;
			case 'inlineScript':
							if (true === $mValue || false === $mValue)
								$this->bInlineScript = $mValue;
						break;

			case 'UploadProgressType':
							if ("APC" === $mValue || "PHP" === $mValue || "LIGHTTPD" === $mValue || false === $mValue)
								$this->sUploadProgressType = $mValue;
						break;
						
			case 'UploadProgressDelay':
							if (is_int($mValue))
								$this->iUploadProgressDelay = $mValue;
						break;
						
			case 'UploadProgressComet':
						if (true === $mValue || false === $mValue)
								$this->bUploadProgressComet = $mValue;
						break;
						
			case 'UploadProgressTarget':
						if (true === $mValue || false === $mValue)
								$this->sUploadProgressTarget = $mValue;
						break;
		}
	}

//--------------------------------------------------------------------------------------------------------------------------------

	
	public function generateClientScript()
	{

//		if (false === $this->bDeferScriptGeneration || 'deferred' === $this->bDeferScriptGeneration)
//		{
//
//		}

			if (0 < count($this->aFunctions))
			{
				echo "\n<script type='text/javascript' " . $this->sDefer . "charset='UTF-8'>\n";
				echo "/* <![CDATA[ */\n";

				foreach (array_keys($this->aFunctions) as $sKey)
					$this->aFunctions[$sKey]->generateClientScript($this->sXajaxPrefix);



				echo "/* ]]> */\n";
				echo "</script>\n";
			}
		if ($this->bInlineScript)
		{
			echo "\n<script type='text/javascript' " . $this->sDefer . "charset='UTF-8'>\n";
			echo "/* <![CDATA[ */\n";

			include(dirname(__FILE__) . 'xajax_plugins/request/upload/upload.js');

			echo "/* ]]> */\n";
			echo "</script>\n";
		} else {
			echo "\n<script type='text/javascript' src='" . $this->sJavascriptURI . "xajax_plugins/request/upload/upload.js' " . $this->sDefer . "charset='UTF-8'></script>\n";
	
		}
		echo "<link rel='stylesheet' type='text/css' href='" . $this->sJavascriptURI . "xajax_plugins/request/upload/upload.css' />";
		echo "\n<script type='text/javascript' " . $this->sDefer . "charset='UTF-8'>\n";
		echo "/* <![CDATA[ */\n";
		echo "xajax.ext.uploadProgress.configure('UploadProgressType','".$this->sUploadProgressType."');";
		echo "xajax.ext.uploadProgress.configure('UploadProgressTarget','".$this->sUploadProgressTarget."');";
		echo "xajax.ext.uploadProgress.configure('UploadProgressDelay',".$this->iUploadProgressDelay.");";
		if ($this->bUploadProgressComet) {
			echo "xajax.ext.uploadProgress.configure('UploadProgressComet',true);";
		} else {
			echo "xajax.ext.uploadProgress.configure('UploadProgressComet',false);";
		}
		echo "/* ]]> */\n";
		echo "</script>\n";


	}
//--------------------------------------------------------------------------------------------------------------------------------

	public function canProcessRequest() {
		if (NULL == $this->sRequestedFunction)
			return false;

		return true;
	}


//--------------------------------------------------------------------------------------------------------------------------------
	public function register($aArgs)
	{
		if (1 < count($aArgs))
		{
			$sType = $aArgs[0];
			if (XAJAX_UPLOAD_FUNCTION == $sType)
			{
				$xuf =& $aArgs[1];
				if (false === is_a($xuf, 'xajaxUploadFunction'))
					$xuf =& new xajaxUploadFunction($xuf);
				if (2 < count($aArgs))
					if (is_array($aArgs[2]))
						foreach ($aArgs[2] as $sName => $sValue)
							$xuf->configure($sName, $sValue);
				$this->aFunctions[] =& $xuf;
				return $xuf->generateRequest($this->sXajaxPrefix);
			}
		}

		return false;
	}
	
//--------------------------------------------------------------------------------------------------------------------------------
	
	public function processRequest()
	{
		if (NULL == $this->sRequestedFunction)
			return false;

		header("Content-Type:text/html;\n\n");
		$objArgumentManager =& xajaxArgumentManager::getInstance();
		$aArgs = $objArgumentManager->process();

		
		
		if ("getProgress" == $this->sRequestedFunction) 
		{
			$this->call($this->sRequestedFunction,$aArgs);
			return true;
		}


		$pid = $_POST['APC_UPLOAD_PROGRESS'];
		unset($_POST['APC_UPLOAD_PROGRESS']);
		unset($_POST['xjxExtUP']);
		$aArgs = array($_POST);
		foreach (array_keys($this->aFunctions) as $sKey)
		{
			$xuf =& $this->aFunctions[$sKey];

			if ($xuf->getName() == $this->sRequestedFunction)
			{
				$sMethod= $xuf->getName();
				$tmp = call_user_func_array(
					$sMethod,
					$aArgs
				);
				ob_start();
				$tmp->_printResponse_XML();
				$response = ob_get_clean();
				print "<html><head><body><script type='text/javascript'>parent.xajax.ext.uploadProgress.tools.manageResponse('".$pid."',".json_encode($response).");</script></body></html>";
				print $response;
				return true;
			}
		}		
		
		return 'Invalid function request received; no request processor found with this name.';
	}

//--------------------------------------------------------------------------------------------------------------------------------
	public function call($sMethod, $aArgs)
	{
		$objResponseManager =& xajaxResponseManager::getInstance();
		$objResponseManager->append(
			call_user_func_array(
				array(&$this, $sMethod), 
				$aArgs
			)
		);
	}

//--------------------------------------------------------------------------------------------------------------------------------


	private function getProgress($pid) 
	{
		$objResponse = new xajaxResponse();
		$uploadData=apc_fetch("upload_".$pid);
		$upload = array();
		1 == $uploadData['done'] ? $upload['state'] = "done" :  $upload['state'] = "uploading";
		$upload['received']=$uploadData['current'];
		$upload['size']=$uploadData['total'];
		$upload['status']=200;
	
	 	if ($uploadData['done'] != 1) 
	 	{
	 		$objResponse->call('this.processResponse',$upload);
	 	} else {
	 		$objResponse->call('this.done',$upload);
	 	}
		return $objResponse;
	}

//--------------------------------------------------------------------------------------------------------------------------------
	
} 


$objPluginManager =& xajaxPluginManager::getInstance();
$objPluginManager->registerPlugin(new clsProgressUpload(), 100);