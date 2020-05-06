<?php
Class View{
	
	private $vars = [];

	function vars($varname, $value) {

		if (isset($this->vars[$varname]) == true) {
			trigger_error ('Unable to set var `' . $varname . '`. Already set, and overwrite not allowed.', E_USER_NOTICE);
			return false;
		}
		$this->vars[$varname] = $value;
		return true;
	}
	
	function gen($contentView, $templateView){
		$contentView = SITE_PATH . 'views' . DS . $contentView . '.php';
		$templateView = SITE_PATH . 'views' . DS . $templateView . '.php';
		if (file_exists($contentView) == false) {
			trigger_error ('Content View `' . $contentView . '` does not exist.', E_USER_NOTICE);
			return false;
		}
		if (file_exists($templateView) == false) {
			trigger_error ('Template View `' . $templateView . '` does not exist.', E_USER_NOTICE);
			return false;
		}
	/* 	if(is_array($data)) {
			// преобразуем элементы массива в переменные
			extract($data);
		} */
		
		foreach ($this->vars as $key => $value) {
			$$key = $value;
		}
		
		include ($templateView);
	}
	
	
}