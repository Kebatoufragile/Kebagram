<?php

namespace App\Controllers;

use App\Models\User;
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

        if($this->authenticateUser() == 1){
            $this->view['view']->render($response, 'homepage.html.twig', array(
                'error' => 'Unable to log you, check your email address and your password, then try again.'
            ));
        }elseif($this->authenticateUser() == 1){
            $this->view['view']->render($response, 'homepage.html.twig', array(
                'error' => 'Unable to log you, fields are missing, please try again.'
            ));
        }else{
            $this->view['view']->render($response, 'homepage.html.twig', array(
                'user' => $_SESSION['user'],
            ));
        }

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
                $this->sentinel->login($userInterface, true);

                $u = User::where("id", "like", $userInterface->getUserId())->first();

                $_SESSION['userid'] = $userInterface->getUserId();
                $_SESSION['user'] = $u;

                header('Location: index.php');
                exit();
            }else{
                return 1;
            }

        }else{
            return 2;
        }
    }
}
