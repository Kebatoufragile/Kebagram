<?php


require_once 'vendor/autoload.php';


$app = new \Slim\App();

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

    return $this->view->render($response, 'login.twig', array());

})->setName('accueil');

$app->post('/login', function($request, $response, $args){


    $controler = new LoginController($app);
    $controler->authenticateUser();

})->setName('login');

$app->post('/register', function($request, $response, $args){

  $controler = new InscriptionController($app);
  $controler->inscription();

})->setName('register');

$app->run();
