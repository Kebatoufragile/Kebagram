<?php

namespace App\Controllers;

use Cartalyst\Sentinel\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class UserController
{
    private $view;
    private $logger;
    private $user;
    private $sentinel;

    public function __construct($view, LoggerInterface $logger, $user)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->model = $user;
        $this->sentinel = (new \Cartalyst\Sentinel\Native\Facades\Sentinel())->getSentinel();
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

        $userInterface = $this->sentinel->authenticate($credentials);

        if($userInterface instanceof UserInterface){
            echo '<script>alert("ça marche")</script>';
        }else{
            echo '<script>alert("ça marche pas")</script>';
        }

    }
}