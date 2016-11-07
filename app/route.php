<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/

$app->get('/', function($request, $response, $args){

    // recuperation des images et des tags associes
    $pictures = \App\Models\Pictures::all();
    $kebabslist = array();
    foreach($pictures as $picture){
        $kebabslist[] = array($picture, \App\Models\Tag::where("uid", "like", $picture->uId));
    }

    if(isset($_SESSION['userid']))
        $_SESSION['user'] = \App\Models\User::where("id", "like", $_SESSION['userid'])->first();

    if(isset($_SESSION['user'])){
        return $this->view->render($response, 'homepage.html.twig', array(
            'user' => $_SESSION['user'],
            'kebabslist' => $kebabslist,
        ));
    }else{
        return $this->view->render($response, 'homepage.html.twig', array(
            'kebabslist' => $kebabslist,
        ));
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

$app->get('/accueil', function($request, $response, $args){

    // recuperation des images et des tags associes
    $pictures = \App\Models\Pictures::all();
    $kebabslist = array();
    foreach($pictures as $picture){
        $kebabslist[] = array($picture, \App\Models\Tag::where("uid", "like", $picture->uid));
    }

    if(isset($_SESSION['userid']))
        $_SESSION['user'] = \App\Models\User::where("id", "like", $_SESSION['userid'])->first();

    if(isset($_SESSION['user'])){
        return $this->view->render($response, 'homepage.html.twig', array(
            'user' => $_SESSION['user'],
            'kebabslist' => $kebabslist,
        ));
    }else{
        return $this->view->render($response, 'homepage.html.twig', array(
            'kebabslist' => $kebabslist,
        ));
    }


})->setName('accueil');
