<?php
/*
	Routes
	controller needs to be registered in dependency.php
*/

$app->get('/', 'App\Controllers\HomeController:dispatch')->setName('accueil');

$app->get('/accueil', 'App\Controllers\HomeController:dispatch')->setName('accueil');

$app->post('/login', 'App\Controllers\LoginController:dispatch')->setName('login');

$app->get('/profile', 'App\Controllers\ProfileController:dispatch')->setName('profile');

$app->get('/addpic', 'App\Controllers\PictureController:dispatch')->setName('addpic');

$app->post('/upload', 'App\Controllers\PictureController:upload')->setName('upload');

$app->get('/signup', 'App\Controllers\InscriptionController:dispatch')->setName('signup');

$app->post('/signup', 'App\Controllers\InscriptionController:dispatchSubmit')->setName('submit');

$app->get('/users', 'App\Controllers\UserController:dispatch')->setName('userpage');

$app->get('/logout', 'App\Controllers\LogoutController:dispatch')->setName('logout');

$app->post('/modify', 'App\Controllers\ProfileController:modifyProfile')->setName('modify');

$app->post('/modifyPassword', 'App\Controllers\ProfileController:modifyPassword')->setName('modifyPassword');

$app->post('/search', 'App\Controllers\ResearchController:dispatch')->setName('search');

$app->post('/modifyPicture', 'App\Controllers\ProfileController:modifyPicture')->setName('modifyPicture');


// routes for error handling
$app->get('/login', 'App\Controllers\HomeController:dispatch')->setName('login');

$app->get('/upload', 'App\Controllers\HomeController:dispatch')->setName('upload');

$app->get('/modify', 'App\Controllers\HomeController:dispatch')->setName('modify');

$app->get('/modifyPassword', 'App\Controllers\HomeController:dispatch')->setName('modifyPassword');

$app->get('/search', 'App\Controllers\HomeController:dispatch')->setName('search');

$app->get('/modifyPicture', 'App\Controllers\HomeController:dispatch')->setName('modifyPicture');
