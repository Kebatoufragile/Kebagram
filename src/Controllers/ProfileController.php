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

        if(isset($_SESSION['user'])){
            $this->view['view']->render($response, 'profile.html.twig', array(
                'user' => $_SESSION['user'],
            ));
        }else
            $this->view['view']->render($response, 'profile.html.twig', array());

        return $response;

    }

    public function modifyProfile(Request $request, Response $response, $args){
        if(isset($_SESSION['user'])){
            if(isset($_POST['emailProfile']) && isset($_POST['firstnameProfile']) && isset($_POST['nameProfile'])){

            }else{
                $this->view['view']->render($response, 'profile.html.twig', array(
                    'user' => $_SESSION['user'],
                    'error' => 'Informations are missing.'
                ));
            }
        }else
            header('Location: index.php');

    }


}