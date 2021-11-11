<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Manager\UsersManager;
use App\Manager\PostsManager;

class AdminController
{

	private $usersManager;
	private $postsManager;

	public function __construct()
	{
		$this->usersManager = new UsersManager();
		$this->postsManager = new PostsManager();

		$session = session_id();
		if(empty($session)){ 
			session_start();
		}
	}

	public function adminView()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		echo $twig->render('admin/adminView.twig');
	}

	/**
	 * list user
	 */
	public function usersListeView()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		// // Ajout pour Dump
		// $twig = new \Twig\Environment($loader, [
		//     'debug' => true,
		//     // ...
		// ]);
		// $twig->addExtension(new \Twig\Extension\DebugExtension());

		$users = $this->usersManager->getUsers();

		echo $twig->render('admin/usersListeView.twig', ['users' => $users]);
	}

	/**
	 * change admin right of a user
	 */
	public function adminLawChange($idUser)
	{
		$this->usersManager->lawChange($idUser);

		header("Location: ../usersListe");
	}


	/**
	 * delete user by id
	 */
	public function deleteUser($idUser)
	{
		$this->usersManager->deleteUser($idUser);

		header("Location: ../usersListeView");
	}

	/**
	 * list posts
	 */
	public function postsListe()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		// // Ajout pour Dump
		// $twig = new \Twig\Environment($loader, [
		//     'debug' => true,
		//     // ...
		// ]);
		// $twig->addExtension(new \Twig\Extension\DebugExtension());

		$posts = $this->postsManager->getPosts();

		echo $twig->render('admin/postsListe.twig', ['posts' => $posts]);
	}

	/**
	 * delete post by id
	 */
	public function deletePost($idPost)
	{
		$this->postsManager->deletePost($idPost);

		header("Location: ../postsListe");
	}


	/**
	 * delete comment by id
	 */
	public function deleteComment($idComment)
	{
		$this->postsManager->deleteComment($idComment);

		header("Location: ../blog");
	}
}
