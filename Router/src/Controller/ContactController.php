<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class ContactController
{
    public function contactView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        echo $twig->render('contactView.twig');
    }
}
