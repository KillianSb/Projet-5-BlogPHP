<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class ContactController
{
    public function contactView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        session_start();
        echo("Bonjour ". $_SESSION['user']);

        echo $twig->render('contactView.twig');
    }
}
