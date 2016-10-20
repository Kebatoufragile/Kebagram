<?php

namespace controller;

use App\Models\User;
use Cartalyst\Sentinel\Users\UserInterface;
use controller\AbstractController;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


final class LoginController extends AbstractController{

    private $view;
    private $user;
    private $sentinel;

    public function __construct($view, $user)
    {
        $this->view = $view;
        $this->model = $user;
        $this->sentinel = (new \Cartalyst\Sentinel\Native\Facades\Sentinel())->getSentinel();
    }

    public function dispatch(Request $request, Response $response, $args)
    {
        $this->authenticateUser();

        return $this->view->render($response, 'homepage.html.twig');
    }

    /**
     * Authenticate the user if the credentials are correct
     *
     * @param $username username or mail address
     * @param $password
     *
     */
    public function authenticateUser(){
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