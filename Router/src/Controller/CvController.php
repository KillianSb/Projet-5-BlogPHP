<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class CvController
{
    public function cvView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        echo $twig->render('cvView.twig');
    }
}
