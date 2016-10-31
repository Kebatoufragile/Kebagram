<?php

namespace App\Controllers;

//require '../vendor/autoload.php';

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


final class InscriptionController extends AbstractController
{

  protected $view;
  protected $logger;
  private $sentinel;

    public function __construct($view){

      parent::__construct($view);
      $this->sentinel = new Sentinel();
      $this->sentinel = $this->sentinel->getSentinel();

    }

    public function dispatch(Request $request, Response $response, $args){

      //$this->register();

      $this->view['view']->render($response, 'register.html.twig');

      return $response;

    }

    public function register(){

        if (isset($_POST['pseudo']) && isset($_POST['mdp']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email'])) {
          $credentials = [
              //'username' => $_POST['username'],
              'password' => $_POST['mdp'],
              'last_name' => $_POST['nom'],
              'first_name' => $_POST['prenom'],
              'email' => $_POST['email']
              //date de naissance ?
          ];

          $this->sentinel->registerAndActivate($credentials);

        } else {
          echo '<script>alert("il manque des données chef")';
        }

    }

    public function dispatchSubmit(Request $request, Response $response, $args){

      $this->register();

      $this->view['view']->render($response, 'submit.html.twig');

      return $response;

    }

}
