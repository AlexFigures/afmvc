<?php
include_once(SITE_PATH .  'conf.php');
Abstract Class Controller {

	public $model;
	public $view;

	function __construct()
	{
		$this->view = new View();
	}
	
	abstract function action_index();

}