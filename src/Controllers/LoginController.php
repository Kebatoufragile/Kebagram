<?php

namespace controller;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;


final class LoginController{

    private $view;
    private $user;
    private $logger;
    private $sentinel;

    public function __construct($view, LoggerInterface $logger, $user)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->model = $user;
        //$this->sentinel = (new Sentinel())->getSentinel();
    }

    public function dispatch(Request $request, Response $response, $args)
    {
        //$this->authenticateUser();
        echo '<script>alert("ça marche")</script>';

        $this->view->render($response, 'homepage.html.twig');

        return $response;
    }

    /**
     * Authenticate the user if the credentials are correct
     *
     * @param $username username or mail address
     * @param $password
     *
     */
    private function authenticateUser(){
        if(isset($_POST['username']) && isset($_POST['password'])){

            $credentials = [
                'username' => $_POST['username'],
                'password' => $_POST['password']
            ];

            $userInterface = $this->sentinel->authenticate($credentials);

            if($userInterface instanceof UserInterface){
                echo '<script>alert("ça marche")</script>';
            }else{
                echo '<script>alert("ça marche pas")</script>';
            }
        }else{

            echo '<script>alert("il manque des données chef")</script>';

        }


    }
}