<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Manager\UsersManager;
use App\Manager\Session;

class HomeController
{

	public function __construct()
	{
		$this->usersManager = new UsersManager();

		$session = session_id();
		if(empty($session)){ 
			Session::sessionStart();
		}
	}

	public function homeView()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		$username = Session::get('user');

		$user = $this->usersManager->getUserByUsername($username);

		$userIsAdmin = $user['admin'];

		echo $twig->render('homeView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin]);
	}
}
