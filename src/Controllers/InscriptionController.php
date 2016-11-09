<?php

namespace App\Controllers;

//require '../vendor/autoload.php';
use App\Models\User;
use Illuminate\Database\Capsule\Manager;
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

      $this->view['view']->render($response, 'register.html.twig');

      return $response;

    }

    public function register(){

        if (isset($_POST['username']) && isset($_POST['mdp']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email'])) {

          $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
          $mdp = filter_var($_POST['mdp'], FILTER_SANITIZE_STRING);
          $ln = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
          $fn = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
          $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

          if($username && $mdp && $ln && $fn && $email){
            $credentials = [
                'username' => $_POST['username'],
                'password' => $_POST['mdp'],
                'last_name' => $_POST['nom'],
                'first_name' => $_POST['prenom'],
                'email' => $_POST['email']
                //date de naissance ?
            ];

            $this->sentinel->registerAndActivate($credentials);
            /*$u=User::where('email', 'like', $_POST['email']);
            $u->username=$_POST['username'];
            $u->save();*/
            return 3;
            
          } else {
            return 1;
            //echo '<script>alert("Les données ne sont pas bonnes")';
          }

        } else {
          return 2;
          //echo '<script>alert("il manque des données chef")';
        }

    }

    public function dispatchSubmit(Request $request, Response $response, $args){

      $res = $this->register();
      if ($res = 3) {
        $this->view['view']->render($response, 'submit.html.twig');
      } elseif ($res = 2){
        $this->view['view']->render($response, 'register.html.twig', array(
          'error' => 'Unable to register you, informations are missing, please try again.'
        ));
      } else {
        $this->view['view']->render($response, 'register.html.twig', array(
          'error' => 'Unable to register you, informations are wrong, please try again.'
        ));
      }

      return $response;

    }

}
