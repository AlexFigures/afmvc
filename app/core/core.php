<?php
spl_autoload_register(function ($className) {
	
	$fileName = strtolower($className) . '.php';
	
	$expCN = explode('_', $className);
	if(empty($expCN[1])){
		$folder = 'core';			
	}else{			
		switch(strtolower($expCN[0])){
			case 'controller':
				$folder = 'controllers';	
				break;
				
			case 'model':					
				$folder = 'models';	
				break;
						
			default:
				$folder = 'core';
				break;
		}
	}
	

	$file = SITE_PATH . $folder . DS . $fileName;
	//echo $file;
	if (file_exists($file) == false) {
		return false;
	}		
		
    include ($file);
});
