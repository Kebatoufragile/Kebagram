<?php

namespace App\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

define('TARGET', "../public/assets/img/avatars/");
define('MAX_SIZE', 2000000);
define('WIDTH_MAX', 1500);
define('HEIGHT_MAX', 1500);

final class ProfileController extends AbstractController{

    protected $view;
    protected $logger;

    public function __construct($view){

        parent::__construct($view);

    }

    public function dispatch(Request $request, Response $response, $args){

        // if logged
        if(isset($_SESSION['user'])){
            $this->view['view']->render($response, 'profile.html.twig', array(
                'user' => $_SESSION['user'],
            ));

        }else
            $this->view['view']->render($response, 'profile.html.twig', array());

        return $response;

    }

    public function modifyProfile(Request $request, Response $response, $args){
        // if user logged
        if(isset($_SESSION['user'])){

            // if informations are filled
            if(isset($_POST['emailProfile']) && isset($_POST['firstnameProfile']) && isset($_POST['nameProfile'])){

                $u = $_SESSION['user'];
                if(strcmp($_POST['emailProfile'], $u->email) != 0){

                    if(is_null(User::where('email', 'like', $_POST['emailProfile'])->first())){

                        $u->email = filter_var($_POST['emailProfile'], FILTER_SANITIZE_EMAIL);
                        $u->first_name = filter_var($_POST['firstnameProfile'], FILTER_SANITIZE_STRING);
                        $u->last_name = filter_var($_POST['nameProfile'], FILTER_SANITIZE_STRING);
                        $u->save();

                        $_SESSION['user'] = User::where("id", "like", $_SESSION['userid'])->first();

                        $this->view['view']->render($response, 'profile.html.twig', array(
                            'user' => $_SESSION['user'],
                            'success' => 'Your profile has been updated.'
                        ));

                    } else{

                        $this->view['view']->render($response, 'profile.html.twig', array(
                            'user' => $_SESSION['user'],
                            'error' => 'Mail address already used.'
                        ));

                    }

                }else{

                    $u->first_name = filter_var($_POST['firstnameProfile'], FILTER_SANITIZE_STRING);
                    $u->last_name = filter_var($_POST['nameProfile'], FILTER_SANITIZE_STRING);
                    $u->save();

                    $_SESSION['user'] = User::where("id", "like", $_SESSION['userid'])->first();

                    $this->view['view']->render($response, 'profile.html.twig', array(
                        'user' => $_SESSION['user'],
                        'success' => 'Your profile has been updated.'
                    ));
                    
                }


            }else{

                $this->view['view']->render($response, 'profile.html.twig', array(
                    'user' => $_SESSION['user'],
                    'error' => 'Informations are missing.'
                ));

            }

        }else
            header('Location: index.php');

    }


    public function modifyPassword(Request $request, Response $response, $args){
        // if user is logged
        if(isset($_SESSION['user'])) {

            // if no informations missing
            if(isset($_POST['actualPassword']) && isset($_POST['newPassword']) && isset($_POST['newPasswordConf'])){

                // if actual password matching
                if(password_verify(filter_var($_POST['actualPassword'], FILTER_SANITIZE_STRING), $_SESSION['user']->password)){

                    // if new password and its confirmation are matching
                    if(filter_var($_POST['newPassword'], FILTER_SANITIZE_STRING) === filter_var($_POST['newPasswordConf'], FILTER_SANITIZE_STRING)){

                        $new = password_hash(filter_var($_POST['newPassword'], FILTER_SANITIZE_STRING), PASSWORD_BCRYPT);
                        $u = $_SESSION['user'];
                        $u->password = $new;
                        $u->save();

                        $_SESSION['user'] = User::where("id", "like", $_SESSION['userid'])->first();

                        $this->view['view']->render($response, 'profile.html.twig', array(
                            'user' => $_SESSION['user'],
                            'success' => 'Your password has been updated.'
                        ));

                    }else{

                        $this->view['view']->render($response, 'profile.html.twig', array(
                            'user' => $_SESSION['user'],
                            'error' => 'Your new password and its confirmation are not matching.'
                        ));

                    }

                }else{

                    // password not matching
                    $this->view['view']->render($response, 'profile.html.twig', array(
                        'user' => $_SESSION['user'],
                        'error' => 'The password you entered does not match with your actual password.'
                    ));
                }

            }

        }else
            header('Location: index.php');

    }


    public function modifyPicture(Request $request, Response $response, $args){

        if(isset($_SESSION['user'])){

            $u = $_SESSION['user'];

            // profile pic
            if(!empty($_FILES['pictureProfile']['name']))
                $pictureProfile = $this->upload($u->username, $response);
            else
                $pictureProfile = 'default';

            if(strcmp($pictureProfile, "default") !== 0){
                $u->profilePic = $pictureProfile;
                $u->save();

                $_SESSION['user'] = $u;

                return $this->view['view']->render($response, 'profile.html.twig', array(
                    'user' => $u,
                    'success' => 'Your profile picture has been updated.'
                ));
            }else{
                return $this->view['view']->render($response, 'profile.html.twig', array(
                    'user' => $_SESSION['user'],
                    'error' => 'Error, please try again.'
                ));
            }




        }else
            return $this->view['view']->render($response, 'homepage.html.twig');

    }



    private function upload($username, $response){
        $tabExt = array('jpg','png','jpeg', 'gif'); //Extensions autorisées

        if(!is_dir(TARGET))
            mkdir(TARGET, 777);


        if( !empty($_FILES['pictureProfile']['name'])){
            $extension = pathinfo($_FILES['pictureProfile']['name'], PATHINFO_EXTENSION);

            if(in_array(strtolower($extension), $tabExt)){

                $infosImg = getimagesize($_FILES['pictureProfile']['tmp_name']);

                if($infosImg[2] >= 1 && $infosImg[2] <= 14){

                    if(($infosImg[0]<=WIDTH_MAX) && ($infosImg[1]<=HEIGHT_MAX) && (filesize($_FILES['pictureProfile']['tmp_name'])<=MAX_SIZE)){

                        if(isset($_FILES['pictureProfile']['error']) && UPLOAD_ERR_OK === $_FILES['pictureProfile']['error']){

                            if(move_uploaded_file($_FILES['pictureProfile']['tmp_name'], TARGET.$username.'tmp'.$extension)){

                                switch($extension){
                                    case 'png':
                                        $src = imagecreatefrompng(TARGET.$username.'tmp'.$extension);
                                        break;
                                    case 'jpg':
                                        $src = imagecreatefromjpeg(TARGET.$username.'tmp'.$extension);
                                        break;
                                    case 'jpeg':
                                        $src = imagecreatefromjpeg(TARGET.$username.'tmp'.$extension);
                                        break;
                                    case 'gif':
                                        $src = imagecreatefromgif(TARGET.$username.'tmp'.$extension);
                                        break;
                                    default:
                                        return 'default';
                                }

                                $dest = imagecreatetruecolor(150, 150);

                                if(imagecopyresized($dest, $src, 0, 0, 0, 0, 150, 150, $infosImg[0], $infosImg[1])){
                                    if(file_exists(TARGET.$username.'tmp'.$extension))
                                        unlink(TARGET.$username.'tmp'.$extension);
                                    if(file_exists(TARGET.$username.'.'.$extension))
                                        unlink(TARGET.$username.'.'.$extension);

                                    switch($extension) {
                                        case 'png':
                                            imagepng($dest, TARGET.$username.'.'.$extension);
                                            break;
                                        case 'jpg':
                                            imagejpeg($dest, TARGET.$username.'.'.$extension);
                                            break;
                                        case 'jpeg':
                                            imagejpeg($dest, TARGET.$username.'.'.$extension);
                                            break;
                                        case 'gif':
                                            imagegif($dest, TARGET.$username.'.'.$extension);
                                            break;
                                    }
                                    return $username.'.'.$extension;
                                }else
                                    return "default";

                            }else{
                                $message = 'A problem has occured during the upload.';
                            }
                        }else{
                            $message = 'An internal error prevented the upload.';
                        }
                    }else{
                        $message = 'The picture is too big. (Max : 1000x1000)';
                    }
                }else{
                    $message = 'The file you want to upload is not a picture.';
                }
            }else{
                $message = 'The file extension is uncorrect.';
            }
        }else{
            $message = 'Please fill the form.';
        }

        return $this->view['view']->render($response, 'profile.html.twig', array(
            'user' => $_SESSION['user'],
            'error' => $message
        ));
    }


}