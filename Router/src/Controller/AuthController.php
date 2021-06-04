<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\UserModel;
// use App\Models\FormModel;

class AuthController
{
    private $usersModel;

    public function __construct()
    {
        $this->usersModel = new UserModel();

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
            header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Router/cv');
        }
        if (isset($_SESSION['successMessage'])) {
            if ($_SESSION['successMessage'] == "n") {
                unset($_SESSION['successMessage']);
                echo("Identifiant ou Mots de passe est incorrect, veuillez réessayer");
                echo $twig->render('auth/connexionView.twig');
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
            header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Router/cv');
        }

        $username = $_POST['username'];
        $passwordToVerify = $_POST['pass'];

        $return = $this->usersModel->connexion($username, $passwordToVerify);
        if ($return[0] == "y") {
            $_SESSION['user'] = $_POST['username'];
            // var_dump($_SESSION);
            // die();
            header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Router/home');
            return("");
        } else {
            $_SESSION['successMessage'] = "n";
        }
        header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Router/connexion');

        // $user = new UserModel();
        // $user->name = $_POST["username"];
        // $user->pass = $_POST["pass"];
        // $user->connexion();

    }


    public function deconnexion(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        unset($_SESSION['user']);
        header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Router/home');
    }


    public function inscriptionView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);
        echo $twig->render('auth/inscriptionView.twig');
    }

    // public function traitementValideInscription(){
    //     $loader = new FilesystemLoader('Public\Views');
    //     $twig = new Environment($loader);

    //     if (!empty($_POST['name'] && !empty($_POST['firstname'] && !empty($_POST['username'] && !empty($_POST['mail'] && !empty($_POST['pass'])){
    //     }
            
    //     traitementInscription();
    // }

    public function traitementInscription(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        // echo "</br>";
        // var_dump($_POST);
        // echo "</br>";

        $cryptPass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        $user = new UserModel();
        $user->name = $_POST["name"];
        $user->firstname = $_POST["firstname"];
        $user->username = $_POST["username"];
        $user->mail = $_POST["mail"];
        $user->pass = $cryptPass;
        $user->inscription();
        
        header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Router/home');


        // echo "</br>";
        // var_dump($user);
        // echo "</br>";

    }
}
