<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class CvController
{
    public function cvView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        session_start();
        echo("Bonjour ". $_SESSION['user']);
        
        echo $twig->render('cvView.twig');
    }
}
