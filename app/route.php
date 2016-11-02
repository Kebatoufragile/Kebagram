<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/

$app->get('/', function($request, $response, $args){

    return $this->view->render($response, 'homepage.html.twig', array());

})->setName('accueil');

$app->post('/login', 'App\Controllers\LoginController:dispatch')->setName('login');

$app->get('/profile', 'App\Controllers\ProfileController:dispatch')->setName('profile');

$app->get('/addpic', 'App\Controllers\PictureController:dispatch')->setName('addpic');

$app->get('/signup', 'App\Controllers\InscriptionController:dispatch')->setName('signup');

$app->post('/signup/submit', 'App\Controllers\InscriptionController:dispatchSubmit')->setName('submit');

$app->get('/users', 'App\Controllers\UserController:dispatch')->setName('userpage');

$app->get('/login', 'App\Controllers\LoginController:authenticateUser')->setName('login');
