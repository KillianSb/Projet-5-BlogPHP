<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Service\Mailer;

class TraitementController
{
	private $mailer;

	public function traitementForm()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		$name = filter_input(INPUT_POST, 'lastname');
		$prenom = filter_input(INPUT_POST, 'firstname');
		$phone = filter_input(INPUT_POST, 'numero');
		$mail = filter_input(INPUT_POST, 'email');
		$content = "mail :" . $mail . "<br> Phone : " . $phone . "<br> Message : " . filter_input(INPUT_POST, 'message');

		if (isset($name) || isset($prenom) || isset($phone) || isset($mail)) {
			$nom = $name;
			$prenom = $prenom;
			$phone = $phone;
			$mail = $mail;
			$content = $content;

			$this->mailer = new Mailer();
			$this->mailer->sendMail('killian.sieniski@gmail.com', 'killian.sieniski@gmail.com', $nom . " " . $prenom, $content, "Message de $nom" . " " . "$prenom");
		}

		echo $twig->render('traitementForm.twig');
	}
}
