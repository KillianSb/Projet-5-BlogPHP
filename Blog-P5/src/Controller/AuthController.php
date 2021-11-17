<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Manager\UsersManager;
use App\Manager\Session;

class AuthController
{
	private $usersManager;

	public function __construct()
	{
		$this->usersManager = new UsersManager();

		$session = session_id();
		if(empty($session)){ 
			Session::sessionStart();
		}
	}

	public function connexionView()
	{
		// Les vérifier en bdd si existant ou non
		// Si existant connexion sinon envoi sur enregistrement
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		if (Session::get('user') !== null) {
			header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/cv');
		}
		if (Session::get('successMessage') !== null) {
			if (Session::get('successMessage') == "n") {
				$successMessage = "Identifiant ou Mots de passe est incorrect, veuillez réessayer";
				Session::forget('successMessage');
				echo $twig->render('auth/connexionView.twig', ["successMessage" => $successMessage, "class" => "errorMessage"]);
			} else {
				Session::forget('successMessage');
			}
		} else {
			echo $twig->render('auth/connexionView.twig');
		}
	}

	public function traitementConnexion()
	{
		if (Session::get('user') !== null) {
			header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/cv');
		}

		$username = filter_input(INPUT_POST, 'username');
		$passwordToVerify = filter_input(INPUT_POST, 'pass');

		$return = $this->usersManager->connexion($username, $passwordToVerify);
		if ($return[0] == "y") {
			Session::put('user', $username);
			header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/home');
			return ("");
		} else {
			Session::put('successMessage', 'n');
		}
		header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/connexion');
	}


	public function deconnexion()
	{
		Session::forget('user');
		header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/home');
	}


	public function inscriptionView()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		if (Session::get('successMessage') !== null) {
			if (Session::get('successMessage') == "y") {
				$successMessage = "Votre inscription à bien été prise en compte, bienvenue !";
				Session::forget('successMessage');
				echo $twig->render('auth/inscriptionView.twig', ["successMessage" => $successMessage, "class" => "successMessage"]);
			} elseif (Session::get('successMessage') !== null) {
				if (Session::get('successMessage') == 'em') {
					$successMessage = "Cette addresse mail est déjà utilisé, désolé.";
					Session::forget('successMessage');
					echo $twig->render('auth/inscriptionView.twig', ["successMessage" => $successMessage, "class" => "errorMessage"]);
				} elseif (Session::get('successMessage') == 'eu') {
					$successMessage = "Ce nom d'utilisateur est déjà utilisé, désolé.";
					Session::forget('successMessage');
					echo $twig->render('auth/inscriptionView.twig', ["successMessage" => $successMessage, "class" => "errorMessage"]);
				}
			} elseif (Session::get('successMessage') == "n") {
				$successMessage = 'Une erreur est survenu, veuillez réessayer.';
				Session::forget('successMessage');
				echo $twig->render('auth/inscriptionView.twig', ["successMessage" => $successMessage, "class" => "errorMessage"]);
			}
		} else {
			echo $twig->render('auth/inscriptionView.twig');
		}
	}

	public function traitementInscription()
	{
		$name = filter_input(INPUT_POST, 'name');
		$firstname = filter_input(INPUT_POST, 'firstname');
		$username = filter_input(INPUT_POST, 'username');
		$mail = filter_input(INPUT_POST, 'mail');
		$pass = filter_input(INPUT_POST, 'pass');
		if (isset($name) || isset($firstname) || isset($username) || isset($mail) || isset($pass)) {
			$name = $name;
			$firstname = $firstname;
			$username = $username;
			$mail = $mail;
			$pass = password_hash($pass, PASSWORD_DEFAULT);
		}

		$return = $this->usersManager->inscription($name, $firstname, $username, $mail, $pass);

		if ($return == "y") {
			Session::put('successMessage', 'y');
		} elseif ($return == 'em') {
			Session::put('successMessage', 'em');
		} elseif ($return == 'eu') {
			Session::put('successMessage', 'eu');
		} else {
			Session::put('successMessage', 'n');
		}
		header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/inscription');
	}

	public function adminView()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		echo $twig->render('admin/adminView.twig');
	}

	public function traitementIsAdmin()
	{
		$username = Session::get('user');
		$user = $this->usersManager->getUser($username);

		if ($user['admin'] == false) {
			echo 'N est pas admin !';
			header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/home');
		} else {
			echo 'Est admin !';
			header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/admin');
		}
	}
}
