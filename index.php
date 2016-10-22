<?php


require_once 'vendor/autoload.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$c = new \Slim\Container($configuration);

$app = new \Slim\App($c);

$container = $app->getContainer();

$container['view'] = function($container){
    $view = new \Slim\Views\Twig('src/Templates', [
        'cache' => 'storage/cache'
    ]);

    $basePath = rtrim(str_ireplace("index.php", '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};


$app->get('/', function($request, $response, $args){

    return $this->view->render($response, 'homepage.html.twig', array());

})->setName('accueil');

$app->post('/login', 'controller\LoginController:dispatch')->setName('login');

$app->post('/register', function($request, $response, $args){

    $controller = new InscriptionController($app);
    $controller->inscription();

})->setName('register');

$app->run();
