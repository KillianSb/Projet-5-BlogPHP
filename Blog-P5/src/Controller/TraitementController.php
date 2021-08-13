<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Service\Mailer;

class TraitementController
{
    private $mailer;
    
    public function traitementForm(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        if (isset($_POST['lastname']) || isset($_POST['firstname']) || isset($_POST['email']) || isset($_POST['numero'])) {
            $nom = $_REQUEST['lastname'];
            $prenom = $_REQUEST['firstname'];
            $phone = $_REQUEST['numero'];
            $mail = $_REQUEST['email'];
            $content = "mail :" . $mail . "<br> Phone : ". $phone . "<br> Message : " .$_REQUEST['message'];

            $this->mailer = new Mailer();
            $this->mailer->sendMail('killian.sieniski@gmail.com', 'killian.sieniski@gmail.com', $nom . " " . $prenom, $content, "Message de $nom" . " " . "$prenom");
    }

    echo $twig->render('traitementForm.twig');
    }
}
