<?php
define("PATH_ROOT", __DIR__ . '/');

require PATH_ROOT . '../app/server.php';

$usercontroller = new App\Controllers\UserController(null);
$usercontroller->authenticateUser("oui", "non");