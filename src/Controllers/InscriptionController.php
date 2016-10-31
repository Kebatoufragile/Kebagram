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

      $this->register();

      $this->view['view']->render($response, 'register.html.twig');

      return $response;

    }

    public function register(){

        if (isset($_POST['pseudo']) && isset($_POST['mdp']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email'])) {
          echo "fraise";
          $credentials = [
              //'username' => $_POST['username'],
              'password' => $_POST['mdp'],
              'last_name' => $_POST['nom'],
              'first_name' => $_POST['prenom'],
              'email' => $_POST['email']
              //date de naissance ?
          ];

          $logRegister = $this->sentinel->registerAndActivate($credentials);

          echo '<script>alert("Inscription reussie, vous pouvez désormais vous connecter")';

          header ('Location: http://localhost/Kebagram/');

        }

        /*if(isset($_POST['inscription'])){

            $data = new DB();
            $data->addConnection(parse_ini_file('../../db_config.ini'));
            $data->setAsGlobal();
            $data->bootEloquent();



            $credentials = [
                'username' => $_POST['pseudo'],
                'password' => $_POST['mdp'],
                'name' => $_POST['nom'],
                'firstname' => $_POST['prenom'],
                'email' => $_POST['email'],
                'birthdate' => $_POST['datenaiss'],
                'creation_date' => getdate(),
            ];
            Sentinel::register($credentials);


        }*/

    }

}
