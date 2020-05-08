<?php

class Router {
	
	protected $route = [];
	protected $path;

	function start(){
		$controllerName = 'tasks';
		$actionName = 'index';//static
      	$modelName = '';
		$fullurl= Router::getCurrentUrl();
        $fullurl= parse_url($fullurl);
		
		$route = explode('/', $fullurl['path']);

        if (empty($route[1])) {
			$route[1] = 'tasks'; 
		}
		
		if (!empty($route[1])) {
			$controllerName = $route[1];
		}
		if (!empty($route[2])) {
			$actionName = $route[2];
		}

		$modelName = 'model_'.$controllerName;
		$controllerName = 'controller_'.$controllerName;
		$actionName = 'action_'.$actionName;
        
		/* echo $modelName . '<br>';
		echo $controllerName . '<br>';
		echo $actionName . '<br>'; */
	
		
		$file = $this->path . $controllerName . '.php';
		
		if (file_exists($file)) {
			include ($file);
        } else {
            Router::page404();
		}
		
		$controller = new $controllerName();
		
        if (is_callable(array($controller, $actionName)) == false) {
			Router::page404();
        }

        $controller->$actionName();

	}
	
	function setPath($path) {
		$path = rtrim($path, '/\\');
        $path .= DS;
	
	if (is_dir($path) == false) {
			throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        $this->path = $path;
	}
	
	static function getCurrentUrl() {
    if(isset($_SERVER["HTTPS"]) && !empty($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] != 'on' )) {
        $url = 'https://'.$_SERVER["SERVER_NAME"];//https url
      }  else {
    $url =  'http://'.$_SERVER["SERVER_NAME"];//http url
      }
      if(( $_SERVER["SERVER_PORT"] != 80 )) {
     $url .= $_SERVER["SERVER_PORT"];
      }
      $url .= $_SERVER["REQUEST_URI"];
       return $url;
       }

   static function page404(){
	    $host = 'https://'.$_SERVER['HTTP_HOST'].'/';
        header('Location:'.$host.'404');
   }
	
	
	
}