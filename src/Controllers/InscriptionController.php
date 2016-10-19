<?php

namespace App\Controllers;

require '../../../vendor/autoload.php';

use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\User;


class InscriptionController
{

    public function inscription(){

        if(isset($_POST['inscription'])){

            $data = new DB();
            $data->addConnection(parse_ini_file('../../../../db_config.ini'));
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


        }

    }

}