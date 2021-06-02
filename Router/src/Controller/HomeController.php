<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController
{
    public function homeView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        var_dump($_SESSION);
        echo $twig->render('homeView.twig');
    }
    
}
