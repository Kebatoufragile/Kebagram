<?php

session_start();

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

$data = new DB();
$data->addConnection(parse_ini_file('conf/db_config.ini'));
$data->setAsGlobal();
$data->bootEloquent();

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$c = new \Slim\Container($configuration);

$app = new \Slim\App($c);

require 'app/route.php';

$container = $app->getContainer();

$container['view'] = function($container){
    $view = new \Slim\Views\Twig('src/Templates', [
        'cache' => false
    ]);

    $basePath = rtrim(str_ireplace("index.php", '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    $view->addExtension(new \Slim\Views\TwigExtension('session', $_SESSION));

    return $view;
};

if(!is_null($_SESSION['userid']) && isset($_SESSION['userid']))
    $_SESSION['user'] = \App\Models\User::where("id", "like", $_SESSION['userid'])->first();

$container['session'] = function($container){
    return $_SESSION;
};

$app->run();


