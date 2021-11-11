<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Manager\Session;


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

		$username = Session::get('user');

		$user = $this->usersModel->getUserByUsername($username);

		$userIsAdmin = $user['admin'];

		echo $twig->render('postView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin]);
	}
}
