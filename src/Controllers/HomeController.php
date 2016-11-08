<?php

namespace App\Controllers;

use App\Models\User;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class HomeController extends AbstractController{

    protected $view;
    protected $logger;


    public function __construct($view)
    {
        parent::__construct($view);

    }

    public function dispatch(Request $request, Response $response, $args)
    {
        // recuperation des images
        $pictures = \App\Models\Pictures::all();
        $kebabslist = array();

        // recuperation des tags et des usernames
        foreach($pictures as $picture){
            $picture->email = User::where('id', 'like', $picture->AuthorKey)->first()->email;
            $kebabslist[] = array($picture, \App\Models\Tag::where("uid", "like", $picture->uId));
        }

        if(isset($_SESSION['userid']))
            $_SESSION['user'] = \App\Models\User::where("id", "like", $_SESSION['userid'])->first();

        if(isset($_SESSION['user'])){
            return $this->view->render($response, 'homepage.html.twig', array(
                'user' => $_SESSION['user'],
                'kebabslist' => $kebabslist,
            ));
        }else{
            return $this->view->render($response, 'homepage.html.twig', array(
                'kebabslist' => $kebabslist,
            ));
        }
    }
}