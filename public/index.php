<?php
define("PATH_ROOT", __DIR__ . '/');

require PATH_ROOT . '../app/server.php';

$app = new Slim\App();
$usercontroller = new App\Controllers\UserController(null);
$usercontroller->authenticateUser("oui", "non");