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

        // Recup les donnees du form

        $pass = $_POST['password'];
        $user = $_POST['username'];


        echo $twig->render('auth/connexionView.twig',);
    }

    public function traitementConnexion(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        
        echo "</br>";
        var_dump($_POST);
        echo "</br>";

        $username = $_POST['username'];
        $passwordToVerify = $_POST['pass'];

        $return = $this->usersModel->connexion($username, $passwordToVerify);
        if ($return[0] == "y") {
            $_SESSION['user'] = $return[1];
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

        echo "</br>";
        var_dump($_POST);
        echo "</br>";

        $user = new UserModel();
        $user->name = $_POST["name"];
        $user->firstname = $_POST["firstname"];
        $user->username = $_POST["username"];
        $user->mail = $_POST["mail"];
        $user->pass = $_POST["pass"];
        $user->inscription();    


        echo "</br>";
        var_dump($user);
        echo "</br>";

    }
}
