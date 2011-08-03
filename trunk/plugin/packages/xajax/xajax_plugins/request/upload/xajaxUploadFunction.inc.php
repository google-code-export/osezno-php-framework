<?php
/*
	File: xajaxUploadFunction.inc.php

	Contains the xajaxUploadFunction class

	Title: xajaxUploadFunction class

	Please see <copyright.inc.php> for a detailed description, copyright
	and license information.
*/

/*
	@package xajax
	@version $Id: xajaxUploadFunction.inc.php 362 2007-05-29 15:32:24Z q_no $
	@copyright Copyright (c) 2005-2006 by Steffen Konerow
	@license http://www.xajaxproject.org/bsd_license.txt BSD License
*/

/*
	Class: xajaxUploadFunction

*/
class xajaxUploadFunction
{
	/*
		String: sAlias
		
		An alias to use for this function.  This is useful when you want
		to call the same xajax enabled function with a different set of
		call options from what was already registered.
	*/
	var $sAlias;
	
	/*
		Object: uf
		
		A string or array which defines the function to be registered.
	*/
	var $uf;
	
	/*
		String: sInclude
		
		The path and file name of the include file that contains the function.
	*/
	var $sInclude;
	
	/*
		Array: aConfiguration
		
		An associative array containing call options that will be sent to the
		browser curing client script generation.
	*/
	var $aConfiguration;
	

	function xajaxUploadFunction($uf, $sInclude=NULL, $aConfiguration=array())
	{
		$this->sAlias = '';
		$this->uf =& $uf;
		$this->sInclude = $sInclude;
		$this->aConfiguration = array();
		foreach ($aConfiguration as $sKey => $sValue)
			$this->configure($sKey, $sValue);
		
		if (is_array($this->uf) && 2 < count($this->uf))
		{
			$this->sAlias = $this->uf[0];
			$this->uf = array_slice($this->uf, 1);
		}

//SkipDebug
		if (is_array($this->uf) && 2 != count($this->uf))
			trigger_error(
				'Invalid function declaration for xajaxUploadFunction.',
				E_USER_ERROR
				);
//EndSkipDebug
	}
	
	/*
		Function: getName
		
		Get the name of the function being referenced.
		
		Returns:
		
		string - the name of the function contained within this object.
	*/
	function getName()
	{
		// Do not use sAlias here!
		if (is_array($this->uf))
			return $this->uf[1];
		return $this->uf;
	}
	
	/*
		Function: configure
		
		Call this to set call options for this instance.
	*/
	function configure($sName, $sValue)
	{
		if ('alias' == $sName)
			$this->sAlias = $sValue;
		else
			$this->aConfiguration[$sName] = $sValue;
	}
	
	/*
		Function: generateRequest
		
		Constructs and returns a <xajaxRequest> object which is capable
		of generating the javascript call to invoke this xajax enabled
		function.
	*/
	function generateRequest($sXajaxPrefix)
	{
		$sAlias = $this->getName();
		if (0 < strlen($this->sAlias))
			$sAlias = $this->sAlias;
		return new xajaxRequest("{$sXajaxPrefix}{$sAlias}");
	}
	
	/*
		Function: generateClientScript
		
		Called by the <xajaxPlugin> that is referencing this function
		reference during the client script generation phase.  This function
		will generate the javascript function stub that is sent to the
		browser on initial page load.
	*/
	function generateClientScript($sXajaxPrefix)
	{
		$sFunction = $this->getName();
		$sAlias = $sFunction;
		if (0 < strlen($this->sAlias))
			$sAlias = $this->sAlias;

		echo "{$sXajaxPrefix}{$sAlias} = function(form_id) { ";
		print "xajax.ext.uploadProgress.processUpload(form_id,'{$sAlias}'";

		print ",{";
		$sSeparator = ", ";
		foreach ($this->aConfiguration as $sKey => $sValue)
			echo "{$sSeparator}{$sKey}: {$sValue}";
		echo "}";
		print ");";
		echo "};\n";
	}

	/*
		Function: call
		
		Called by the <xajaxPlugin> that references this function during the
		request processing phase.  This function will call the specified
		function, including an external file if needed and passing along 
		the specified arguments.
	*/
	function call($aArgs=array())
	{
		$objResponseManager =& xajaxResponseManager::getInstance();
		
		if (NULL != $this->sInclude)
		{
			ob_start();
			require_once $this->sInclude;
			$sOutput = ob_get_clean();
			
//SkipDebug
			if (0 < strlen($sOutput))
			{
				$sOutput = 'From include file: ' . $this->sInclude . ' => ' . $sOutput;
				$objResponseManager->debug($sOutput);
			}
//EndSkipDebug
		}
		
		$mFunction = $this->uf;
		$objResponseManager->append(call_user_func_array($mFunction, $aArgs));
	}
}
?>
