<?php

namespace App\Controllers;

use App\Models\Pictures;
use App\Models\Tag;
use App\Models\User;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


final class ResearchController extends AbstractController
{

    protected $view;
    protected $logger;

    public function __construct($view){

        parent::__construct($view);

    }

    public function dispatch(Request $request, Response $response, $args){

        if(isset($_POST['search'])){

            $search = '%'.filter_var($_POST['search'], FILTER_SANITIZE_STRING).'%';

            $users = User::where('username', 'like', $search)->get();
            $tags = Tag::where('Tag', 'like', $search)->get();

            $kebabsObjects = array();
            $kebabs = array();
            foreach($tags as $tag)
                array_push($kebabsObjects,  Pictures::where('uId', 'like', $tag->pictureID)->get());
            for($i=0; $i<count($kebabsObjects); $i++)
              array_push($kebabs, $kebabsObjects[$i][0]);
            $kebabs = array_unique($kebabs);


            if(isset($_SESSION['user'])){
                $this->view['view']->render($response, 'search.html.twig', array(
                    'user' => $_SESSION['user'],
                    'users' => $users,
                    'kebabs' => $kebabs
                ));
            }else{
                $this->view['view']->render($response, 'search.html.twig', array(
                    'users' => $users,
                    'tags' => $tags
                ));
            }
        }else
            header('Location: index.php');

        return $response;

    }

}
