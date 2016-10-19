<?php

$app = new \Slim\Slim();


$app->get('/', function() use ($app){
  $control = new UserController($app);
  $control->renderHomepage();
})->name("home page");
