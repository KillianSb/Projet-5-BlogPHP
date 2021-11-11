<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Manager\UsersManager;
use App\Manager\PostsManager;
use App\Manager\Session;


class BlogController
{

	private $postsManager;
	private $usersManager;

	public function __construct()
	{
		$this->usersManager = new UsersManager();
		$this->postsManager = new PostsManager();

		$session = session_id();
		if(empty($session)){ 
			session_start();
		}
	}

	public function blogView()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);
		
		$username = Session::get('user');

		$user = $this->usersManager->getUserByUsername($username);

		$userIsAdmin = $user['admin'];

		$posts = $this->postsManager->getPosts();

		if (isset($_SESSION['successMessage'])) {
			if ($_SESSION['successMessage'] == "postCreated") {
				$successMessage = "Votre article à bien été Crée !";
				Session::forget('successMessage');
				$posts = $this->postsManager->getPosts();
				$user = $this->usersManager->getUserByUsername($username);
				echo $twig->render('blogView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'posts' => $posts, "successMessage" => $successMessage, "class" => "successMessage"]);
			} elseif ($_SESSION['successMessage'] == "postError") {
				$successMessage = 'Une erreur est survenu, veuillez réessayer.';
				Session::forget('successMessage');
				$user = $this->usersManager->getUserByUsername($username);
				echo $twig->render('blogView.twig', ["successMessage" => $successMessage, "class" => "successMessage", 'user' => $user, 'posts' => $posts, 'IsAdmin' => $userIsAdmin]);
			}
		} else {
			$user = $this->usersManager->getUserByUsername($username);

			echo $twig->render('blogView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'posts' => $posts]);
		}
	}

	public function createPostView()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		$username = Session::get('user');
		$user = $this->usersManager->getUserByUsername($username);
		$userIsAdmin = $user['admin'];

		echo $twig->render('createPostView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin]);
	}

	public function traitementCreatePost()
	{
		$titre = filter_input(INPUT_POST, 'title');
		$chapo = filter_input(INPUT_POST, 'chapo');
		$content = filter_input(INPUT_POST, 'content');
		$auteur = Session::get('user');

		$return = $this->postsManager->createPost($titre, $chapo, $content, $auteur);

		if ($return == "postCreated") {
			Session::put('successMessage', 'postCreated');
		} else {
			Session::put('successMessage', 'postError');
			header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/createPostView');
		}

		header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/blog');
	}

	public function createCommentView()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		$username = Session::get('user');

		$user = $this->usersManager->getUserByUsername($username);

		$userIsAdmin = $user['admin'];

		$get_url = $_GET["url"];
		if (@preg_match('#^([^0-9]+)([0-9]+)$#', $get_url, $post_id))
			$idPost = $post_id[2];

		if (isset($_SESSION['successMessage'])) {
			if (Session::get('successMessage') == "commentError") {
				$successMessage = 'Une erreur est survenu, veuillez réessayer.';
				Session::forget('successMessage');
				$post = $this->postsManager->getPost($idPost);
				echo $twig->render('modifPostView.twig', ["successMessage" => $successMessage, "class" => "errorMessage", 'post' => $post, 'id' => $idPost]);
			}
		} else {
			$user = $this->usersManager->getUserByUsername($username);

			echo $twig->render('createCommentView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'id' => $post_id]);
		}
	}

	public function traitementCreateComment()
	{
		$idPost = filter_input(INPUT_POST, 'post_id');
		$author = Session::get('user');
		$comment = filter_input(INPUT_POST, 'comment');

		$return = $this->postsManager->createComment($idPost, $author, $comment);

		if ($return == "commentCreated") {
			Session::put('successMessage', 'commentCreated');
		} else {
			Session::put('successMessage', 'commentError');
			header("Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/createCommentView/$idPost");
		}

		header("Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/viewPost/$idPost");
	}

	/**
	 * render form to modify a post
	 */
	public function modifPostView($idPost)
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		if (isset($_SESSION['successMessage'])) {
			if (Session::get('successMessage') == "modifPostError") {
				$successMessage = 'Une erreur est survenu, veuillez réessayer.';
				Session::forget('successMessage');
				$post = $this->postsManager->getPost($idPost);
				echo $twig->render('modifPostView.twig', ["successMessage" => $successMessage, "class" => "errorMessage", 'post' => $post, 'id' => $idPost]);
			}
		} else {
			$post = $this->postsManager->getPost($idPost);

			echo $twig->render('modifPostView.twig', ['post' => $post, 'id' => $idPost]);
		}
	}

	/**
	 * change in databse the post
	 */
	public function traitementModifPost($idPost)
	{
		$title = $_REQUEST['title'];
		$chapo = $_REQUEST['chapo'];
		$content = $_REQUEST['content'];
		$date_create = $_REQUEST['dateCreate'];

		date_default_timezone_set('Europe/Paris');
		$date = date('Y-m-d H:i:s');

		$return = $this->postsManager->modifPost($idPost, $title, $chapo, $content, $date_create, $date);

		if ($return == "modifPostCreated") {
			Session::put('successMessage', 'modifPostCreated');
		} else {
			Session::put('successMessage', 'modifPostError');
			header("Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/modifPostView/$idPost");
		}

		header("Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/viewPost/$idPost");
	}


	public function ViewPost()
	{
		$loader = new FilesystemLoader('Public\Views');
		$twig = new Environment($loader);

		$username = Session::get('user');

		$user = $this->usersManager->getUserByUsername($username);

		$userIsAdmin = $user['admin'];

		$get_url = $_GET["url"];
		if (@preg_match('#^([^0-9]+)([0-9]+)$#', $get_url, $post_id))
			$idPost = $post_id[2];

		$post = $this->postsManager->getPost($idPost);

		$comments = $this->postsManager->getComments($idPost);

		// echo "</br>";
		// var_dump($_SESSION);
		// echo "</br>";
		// die();

		if (isset($_SESSION['successMessage'])) {
			if (Session::get('successMessage') == "commentCreated") {
				$successMessage = "Votre comentaire à bien été Crée !";
				Session::forget('successMessage');
				$user = $this->usersManager->getUserByUsername($username);
				echo $twig->render('viewPost.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'post' => $post, 'comments' => $comments, "successMessage" => $successMessage, "class" => "successMessage", 'user' => $user, 'IsAdmin' => $userIsAdmin, 'id' => $post_id]);
			} elseif (Session::get('successMessage') == "commentError") {
				$successMessage = 'Une erreur est survenu, veuillez réessayer.';
				Session::forget('successMessage');
				$user = $this->usersManager->getUserByUsername($username);
				echo $twig->render('createCommentView.twig', ["successMessage" => $successMessage, "class" => "successMessage", 'user' => $user, 'IsAdmin' => $userIsAdmin, 'id' => $post_id]);
			}
			if (Session::get('successMessage') == "modifPostCreated") {
				$successMessage = "Votre article à bien été Modifié !";
				Session::forget('successMessage');
				$post = $this->postsManager->getPost($idPost);
				echo $twig->render('viewPost.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'post' => $post, 'comments' => $comments, "successMessage" => $successMessage, "class" => "successMessage", 'post' => $post, 'id' => $idPost]);
			} elseif (Session::get('successMessage') == "modifPostError") {
				$successMessage = 'Une erreur est survenu, veuillez réessayer.';
				Session::forget('successMessage');
				$post = $this->postsManager->getPost($idPost);
				echo $twig->render('modifPostView.twig', ["successMessage" => $successMessage, "class" => "errorMessage", 'post' => $post, 'id' => $idPost]);
			}
		} else {
			$post = $this->postsManager->getPost($idPost);

			echo $twig->render('viewPost.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'post' => $post, 'comments' => $comments, 'post_id' => $idPost]);
		}
	}
}
