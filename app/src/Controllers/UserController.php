<?php

namespace App\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class UserController
{
    private $view;
    private $logger;
    private $user;

    public function __construct($view, LoggerInterface $logger, $user)
    {
        $this->view = $view;
        $this->logger = $logger;
		$this->model = $user;
    }

    public function dispatch(Request $request, Response $response, $args)
    {
        $this->logger->info("Home page action dispatched");

		$users = $this->model->show();

		return $this->view->render($response, 'users.twig', ["data" => $users]);
    }

    /**
     * Authenticate the user if the credentials are correct
     *
     * @param $username username or mail address
     * @param $password
     *
     */
    public function authenticateUser($username, $password){
        $credentials = [
            'username' => $username,
            'password' => $password
        ];

        $userInterface = \Cartalyst\Sentinel\Sentinel::authenticate($credentials);

        if($userInterface instanceof UserInterface){
           /**
            * ça marche
            */
        }else{
            /**
             * ça marche pas
             */
        }

    }
}