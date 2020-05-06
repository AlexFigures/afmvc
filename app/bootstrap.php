<?php
include_once 'conf.php';
// подключаем файлы ядра
include (SITE_PATH . DS . 'core' . DS . 'core.php'); 
require_once 'core/router.php';

// Загружаем router
$router = new Router();
// задаем путь до папки контроллеров.
$router->setPath (SITE_PATH . 'controllers');
// запускаем маршрутизатор
$router->start();

include_once ("inc/db.php");