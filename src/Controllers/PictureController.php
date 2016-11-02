<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Pictures;
use Illuminate\Database\Capsule\Manager as BD;

define('TARGET', "public/assets/img/$_SESSION['user']->username"); //Répertoire cible -> créer un répertoire au nom de l'utilisateur -> a récupérer dans la variabloe de session $_SESSION["username"]
define('MAX_SIZE', 2000000); //Taille max en octets du fichier
define('WIDTH_MAX', 1200);   //Largeur max de l'image en pixels
define('HEIGHT_MAX', 900);  //Hauteur max de l'image en pixels


final class PictureController extends AbstractController{

    protected $view;
    protected $logger;

    public function __construct($view) {

        parent::__construct($view);

    }

    public function dispatch(Request $request, Response $response, $args) {


      //Tableaux de données
      $tabExt = array('jpg','png','jpeg', 'gif'); //Extensions autorisées
      $infosImg = array();

      //Variables
      $extension = '';
      $message = '';
      $nomImage = '';
      $bdd = new BD();
      $bdd->addConnection(parse_ini_file('../../conf/db_config.ini'));
      $bdd->setAsGlobal();
      $bdd->bootEloquent();

      $pic = new Pictures();

      /*************************************************************************
       * Creation du repertoire cible si inexistant
       ***********************************************************************/
      if(!is_dir(TARGET)){
          if(!mkdir(TARGET, 777)) {
              exit('Erreur : le repertoire cible ne peut-être créé ! Vérifiez que vous disposez des droits suffisants pour le faire ou créez le manuellement !');
          }
      }

      /*************************************************************************
       * Script d'upload
       ************************************************************************/
      if(!empty($_POST)){
          //On vérifie si le champ de l'extension est rempli
          if( !empty($_FILES['fichier']['name'])){
              //Récupération de l'extension du fichier
              $extension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);

              //On vérifie l'extension du fichier
              if(in_array(strtolower($extension), $tabExt)){
                  //On récupére les dimensions du fichier
                  $infosImg = getimagesize($_FILES['fichier']['tmp_name']);

                  //On vérifie le type de l'image
                  if($infosImg[2] >= 1 && $infosImg[2] <= 14){
                      //On vérifie les dimensions et taille de l'image
                      if(($infosImg[0]<=WIDTH_MAX) && ($infosImg[1]<=HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name'])<=MAX_SIZE)){
                          //Parcours du tableau d'erreur
                          if(isset($_FILES['fichier']['error']) && UPLOAD_ERR_OK === $_FILES['fichier']['error']){
                              //On renomme le fichier
                              $nomImage = md5(uniqid()).'.'.$extension;

                              //Si c'est OK, on test l'upload
                              if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage)){
                                  $message = 'Upload réussi !';
                                  //insert database
                                  //test data
                                  $pic->Name = $_FILES['fichier']['name'];
                                  $pic->Link = TARGET.'/'.$nomImage;
                                  $pic->uId = 6;
                                  $pic->Desc = "Image de test";
                                  $pic->Date = date("m.d.y");
                                  $pic->AuthorKey = 1;
                                  $pic->save();
                              }else{
                                  //Sinon on affiche une erreur système
                                  $message = 'Problème lors de l\'upload !';
                              }
                          }else{
                              $message = 'Une erreur interne a empêché l\upload de l\image';
                          }
                      }else{
                          //Sinon erreur sur les dimensions et taille de l'image
                          $message = 'Erreur dans les dimensions de l\'image';
                      }
                  }else{
                      //Sinon erreur sur le type de l'image
                      $message = 'Le fichier à uploader n\'est pas une image !';
                  }
              }else{
                  //Sinon on affiche une erreur sur l'extension
                  $message = 'L\'extension du fichier est incorrecte !';
              }
          }else{
              //Sinon on affiche une erreur pour le champ vide
              $message = 'Veuillez remplir le formulaire svp !';
          }
      }


        $this->view['view']->render($response, 'addpicture.html.twig');

        return $response;

    }


}
