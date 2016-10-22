<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/

$app->get('/', function($request, $response, $args){

    return $this->view->render($response, 'homepage.html.twig', array());

})->setName('accueil');

$app->post('/login', 'App\Controllers\LoginController:dispatch')->setName('login');

$app->post('/register', function($request, $response, $args){

    $controller = new InscriptionController($app);
    $controller->inscription();

})->setName('register');