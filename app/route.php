<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/

$app->get('/', function($request, $response, $args){

    if(isset($_SESSION['user'])){
        return $this->view->render($response, 'homepage.html.twig', array(
            'user' => $this['session']['user'],
        ));
    }else{
        return $this->view->render($response, 'homepage.html.twig', array());
    }


})->setName('accueil');

$app->post('/login', 'App\Controllers\LoginController:dispatch')->setName('login');

$app->get('/profile', 'App\Controllers\ProfileController:dispatch')->setName('profile');

$app->get('/addpic', 'App\Controllers\PictureController:dispatch')->setName('addpic');

$app->post('/addpic/upload', 'App\Controllers\PictureController:upload')->setName('upload');

$app->get('/signup', 'App\Controllers\InscriptionController:dispatch')->setName('signup');

$app->post('/signup/submit', 'App\Controllers\InscriptionController:dispatchSubmit')->setName('submit');

$app->get('/users', 'App\Controllers\UserController:dispatch')->setName('userpage');

$app->get('/logout', 'App\Controllers\LogoutController:dispatch')->setName('logout');