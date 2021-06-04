<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class AdminController
{
    public function adminView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        echo $twig->render('admin/adminView.twig');
    }
}
