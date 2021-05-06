<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class AuthController
{

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function user(): ?User
    {

    }

    public function login(string $username, string $password): ?User
    {

    }



    public function connexionView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        echo $twig->render('auth/connexionView.twig');
    }

    public function traitementConnexion(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        $user = new User();
        if (!empty($_POST)){
            if (empty($_POST['login']) || empty($_POST['pass'])) {
                $errors['pass'] = ['Identifiant ou mdp incorect'];
            }
        }
        var_dump($user);

        // echo $twig->render('connexionView.twig');
        var_dump($_REQUEST['login'], $_REQUEST['pass']);
    }

    public function inscriptionView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        echo $twig->render('auth/inscriptionView.twig');
    }

    public function traitementInscription(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        var_dump($_REQUEST['name'], $_REQUEST['firstname'], $_REQUEST['mail'], $_REQUEST['pass']);
    }
}
