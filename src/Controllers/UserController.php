<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class UserController
{
    private $view;
    private $logger;
    private $user;
    private $sentinel;

<<<<<<< HEAD
    public function __construct($view)
=======
    public function __construct($view, LoggerInterface $logger, $user)
>>>>>>> 54bd759a171104de296a52ffcd890a1fecbcb759
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
}