<?php
require_once 'core/autoload.php';
require_once 'config/Database.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$controllerClass = ucfirst($controller) . 'Controller';
$controllerFile = 'controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerInstance = new $controllerClass();
    
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        require_once 'views/error/404.php';
    }
} else {
    require_once 'views/error/404.php';
}
?>