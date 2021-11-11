<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Manager\UsersManager;
use App\Manager\Session;



class ContactController
{

	private $usersManager;

	public function __construct()
	{
		$this->usersManager = new UsersManager();

		$session = session_id();
		if(empty($session)){ 
			session_start();
		}
	}

	public function contactView()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		$username = Session::get('user');

		$user = $this->usersManager->getUserByUsername($username);

		$userIsAdmin = $user['admin'];

		echo $twig->render('contactView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin]);
	}
}
