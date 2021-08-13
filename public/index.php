<?php

	define('ROOT',dirname(__DIR__));
	include(ROOT.'/App/App.php');
	App::$path = 'http://'. $_SERVER['SERVER_NAME'].'/CM_APP/public/';
	App::load();

	$p = 'home';
	//echo '<br><br><br><br>';
if(strpos($_SERVER['REQUEST_URI'], 'api')) {
    new \App\Controller\API\V1\ApiController();
    exit;
}

if(isset($_POST['ajax_action'])){
	$request = explode('.',$_POST['ajax_action']);
	$controller = '\App\Controller\\'.ucfirst($request[0]).'Controller';
	$action = $request[1];
	$controller = new $controller();
	echo $controller->$action();
}
else {
	if (isset($_GET['p'])) {
		$p = $_GET['p'];
	} else {
		$p = 'home/index';
	}
	$p = explode('/', rtrim($p, '/'));
	$action = 'index';

	if (isset($p[0])) {
		$controllerName = $p[0];
		App::getInstance()->cur_page = strtolower($p[0]);

	}
	if (isset($p[1])) {
		$action = $p[1];
	}

	if(!isset($_SESSION['user'])){
		$controllerName = 'user';
		$action = 'login';
	} else {
		if(($p[0] == 'user') && ($p[1] == 'login')){
			$controllerName = 'home';
			$action = 'index';

		}
	}
	$controller = '\App\Controller\\' . ucfirst($controllerName) . 'Controller';

	$controller = new $controller();
	$controller->$action();
}
