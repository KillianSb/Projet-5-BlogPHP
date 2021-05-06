<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BlogController
{
    public function blogView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        echo $twig->render('blogView.twig');
    }
}
