<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ProfileController extends AbstractController{

    protected $view;
    protected $logger;

    public function __construct($view){

        parent::__construct($view);

    }

    public function dispatch(Request $request, Response $response, $args){

        $this->view['view']->render($response, 'profile.html.twig');

        return $response;

    }


}