<?php

define('TARGET', "/public/assets/img/$_SESSION['user']->username"); //Répertoire cible -> créer un répertoire au nom de l'utilisateur -> a récupérer dans la variabloe de session $_SESSION["username"]
define('MAX_SIZE', 2000000); //Taille max en octets du fichier
define('WIDTH_MAX', 1200);   //Largeur max de l'image en pixels
define('HEIGHT_MAX', 900);  //Hauteur max de l'image en pixels

//Tableaux de données
$tabExt = array('jpg','png','jpeg', 'gif'); //Extensions autorisées
$infosImg = array();

//Variables
$extension = '';
$message = '';
$nomImage = '';

/*************************************************************************
 * Creation du repertoire cible si inexistant
 ***********************************************************************/
if(!is_dir(TARGET)){
    if(!mkdir(TARGET, 0755)) {
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

?>
