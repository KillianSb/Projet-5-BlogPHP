<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController
{
    public function homeView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);
        session_start();
        echo("Bonjour ". $_SESSION['user']);

        echo $twig->render('homeView.twig');
    }
    
}
