<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\UserModel;

class LegalController
{

    public function __construct()
    {
        $this->usersModel = new UserModel();

        if (!isset($_SESSION)) {
            session_start();
        }

    }

    public function legalView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);
        
        $username = $_SESSION['user'];

        $user = $this->usersModel->getUser($username);

        $userIsAdmin = $user['admin'];

        echo $twig->render('legalView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin]);
    }
    
}
