<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BlogController
{
    public function blogView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        session_start();
        echo("Bonjour ". $_SESSION['user']);

        echo $twig->render('blogView.twig');
    }
}
