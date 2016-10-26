<?php

namespace App\Controllers;

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class LoginController extends AbstractController{

    protected $view;
    protected $logger;
    private $sentinel;

    public function __construct($view){

        parent::__construct($view);

        $this->sentinel = new Sentinel();
        $this->sentinel = $this->sentinel->getSentinel();
    }

    public function dispatch(Request $request, Response $response, $args){

        $this->authenticateUser();

        $this->view['view']->render($response, 'homepage.html.twig');

        return $response;

    }

    /**
     * Authenticate the user if the credentials are correct
     */
    private function authenticateUser(){
        if(isset($_POST['username']) && isset($_POST['password'])){

            $credentials = [
                'email' => $_POST['username'],
                'password' => $_POST['password']
            ];

            $userInterface = $this->sentinel->authenticate($credentials);

            if($userInterface instanceof UserInterface){
                echo '<script>alert("ça marche")</script>';
                $this->sentinel->login($userInterface, true);
            }else{
                echo '<script>alert("ça marche pas")</script>';
            }
        }else{

            echo '<script>alert("il manque des données chef")</script>';

        }


    }
}