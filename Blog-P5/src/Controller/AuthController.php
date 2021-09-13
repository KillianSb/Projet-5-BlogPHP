<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\UserModel;
use App\Manager\UsersManager;
// use App\Models\FormModel;

class AuthController
{
    private $usersModel;
    private $usersManager;

    public function __construct()
    {
        $this->usersModel = new UserModel();
        $this->usersManager = new UsersManager();

        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function connexionView(){

        
        // Les vérifier en bdd si existant ou non
        // Si existant connexion sinon envoi sur enregistrement
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        // $form = new FormModel($_POST);
        // echo $form->input('username','Login');
        // echo $form->input('password','Mots de passe');
        // echo $form->submit();

        if (isset($_SESSION['user'])) {
            header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/cv');
        }
        if (isset($_SESSION['successMessage'])) {
            if ($_SESSION['successMessage'] == "n") {
                $successMessage = "Identifiant ou Mots de passe est incorrect, veuillez réessayer";
                unset($_SESSION['successMessage']);
                echo $twig->render('auth/connexionView.twig', ["successMessage" => $successMessage, "class" => "errorMessage"]);
            } else {
                unset($_SESSION['successMessage']);
            }
        } else {
            echo $twig->render('auth/connexionView.twig');
        }
    }

    public function traitementConnexion(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);
        
        // echo "</br>";
        // var_dump($_POST);
        // echo "</br>";

        if (isset($_SESSION['user'])) {
            header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/cv');
        }

        $username = $_POST['username'];
        $passwordToVerify = $_POST['pass'];

        $return = $this->usersModel->connexion($username, $passwordToVerify);
        if ($return[0] == "y") {
            $_SESSION['user'] = $username;
            header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/home');
            return("");
        } else {
            $_SESSION['successMessage'] = "n";
        }
        header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/connexion');

    }


    public function deconnexion(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        unset($_SESSION['user']);
        header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/home');
    }


    public function inscriptionView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);
        
        if (isset($_SESSION['successMessage'])) {
            if ($_SESSION['successMessage'] == "y") {
                $successMessage = "Votre inscription à bien été prise en compte, bienvenue !";
                unset($_SESSION['successMessage']);
                echo $twig->render('auth/inscriptionView.twig', ["successMessage" => $successMessage, "class" => "successMessage"]);
            } elseif (isset($_SESSION['successMessage'])) {
                if ($_SESSION['successMessage'] == 'em') {
                    $successMessage = "Cette addresse mail est déjà utilisé, désolé.";
                    unset($_SESSION['successMessage']);
                    echo $twig->render('auth/inscriptionView.twig', ["successMessage" => $successMessage, "class" => "errorMessage"]);
                }
                elseif ($_SESSION['successMessage'] == 'eu') {
                    $successMessage = "Ce nom d'utilisateur est déjà utilisé, désolé.";
                    unset($_SESSION['successMessage']);
                    echo $twig->render('auth/inscriptionView.twig', ["successMessage" => $successMessage, "class" => "errorMessage"]);
                }
            } elseif ($_SESSION['successMessage'] == "n") {
                $successMessage = 'Une erreur est survenu, veuillez réessayer.';
                unset($_SESSION['successMessage']);
                echo $twig->render('auth/inscriptionView.twig', ["successMessage" => $successMessage, "class" => "errorMessage"]);
            }
        } else {
            echo $twig->render('auth/inscriptionView.twig');
        }
    }

    public function traitementInscription(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        // echo "</br>";
        // var_dump($_POST);
        // echo "</br>";
        // die();

        if (isset($_POST['name']) || isset($_POST['firstname']) || isset($_POST['username']) || isset($_POST['mail']) || isset($_POST['pass'])) {
            $name = $_POST['name'];
            $firstname = $_POST['firstname'];
            $username = $_POST['username'];
            $mail = $_POST['mail'];
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        }
       

        $return = $this->usersModel->inscription($name, $firstname, $username, $mail, $pass);
        
        // echo "</br>";
        // var_dump($return);
        // echo "</br>";
        // die();

        if ($return == "y") {
            $_SESSION['successMessage'] = "y";
        } elseif ($return == 'em') {
            $_SESSION['successMessage'] = "em";
        } elseif ($return == 'eu') {
            $_SESSION['successMessage'] = "eu";
        } else {
            $_SESSION['successMessage'] = "n";
        }
        header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/inscription');

        // echo "</br>";
        // var_dump($user);
        // echo "</br>";

    }

    public function adminView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        echo $twig->render('admin/adminView.twig');
    }

    public function traitementIsAdmin(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        $username = $_SESSION['user'];


        $user = $this->usersManager->getUser($username);

        if ($user['admin'] == false) {
            echo 'N est pas admin !';
            header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/home');
        } 
        else {
            echo 'Est admin !';
            header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/admin');
        }
    }

}
