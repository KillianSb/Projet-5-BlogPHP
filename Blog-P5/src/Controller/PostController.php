<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\UserModel;


class PostController
{
	public function __construct()
	{

		if (!isset($_SESSION)) {
			session_start();
		}
	}

	public function postView()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		$username = $_SESSION['user'];

		$user = $this->usersModel->getUser($username);

		$userIsAdmin = $user['admin'];

		echo $twig->render('postView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin]);
	}
}
