<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\UserModel;
use App\Manager\PostsManager;
use App\Models\PostModel;


class BlogController
{

    private $postsManager;
    private $usersModel;

    public function __construct()
    {
        $this->usersModel = new UserModel();
        $this->postsManager = new PostsManager();
        $this->postModel = new PostModel();
        
        if (!isset($_SESSION)) {
            session_start();
        }

    }

    public function blogView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        $username = $_SESSION['user'];

        $user = $this->usersModel->getUser($username);

        $userIsAdmin = $user['admin'];

        $posts = $this->postsManager->getPosts();

        if (isset($_SESSION['successMessage'])) {
            if ($_SESSION['successMessage'] == "postCreated") {
                $successMessage = "Votre article à bien été Crée !";
                unset($_SESSION['successMessage']);
                $posts = $this->postsManager->getPosts();
                $user = $this->usersModel->getUser($username);
                echo $twig->render('blogView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'posts' => $posts, "successMessage" => $successMessage, "class" => "successMessage"]);
            } elseif ($_SESSION['successMessage'] == "postError") {
                $successMessage = 'Une erreur est survenu, veuillez réessayer.';
                unset($_SESSION['successMessage']);
                $user = $this->usersModel->getUser($username);
                echo $twig->render('createPostView.twig', ["successMessage" => $successMessage, "class" => "successMessage", 'user' => $user, 'IsAdmin' => $userIsAdmin]);
            }
        } else {
            $user = $this->usersModel->getUser($username);

            echo $twig->render('blogView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'posts' => $posts]);
        }
    }

    public function createPostView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        $username = $_SESSION['user'];
        $userIsAdmin = $user['admin'];

        $user = $this->usersModel->getUser($username);

        echo $twig->render('createPostView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin]);
    }

    public function traitementCreatePost(){
        $titre = $_POST["title"];
        $chapo = $_POST["chapo"];
        $content = $_POST["content"];
        $auteur = $_SESSION['user'];

        $post = new PostModel();
        $post->title = $titre;
        $post->chapo = $chapo;
        $post->content = $content;
        $post->auteur = $auteur;

        $return = $post->createPost();
        
        if ($return == "postCreated") {
            $_SESSION['successMessage'] = "postCreated";
        } else {
            $_SESSION['successMessage'] = "postError";
            header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/createPostView');
        }
        
        header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/blog');
    }

    public function createCommentView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        $username = $_SESSION['user'];

        $user = $this->usersModel->getUser($username);

        $userIsAdmin = $user['admin'];

        $get_url = $_GET["url"];
        if (@preg_match('#^([^0-9]+)([0-9]+)$#',$get_url,$post_id))
        $post_id = $post_id[2]; 

        if (isset($_SESSION['successMessage'])) {
            if ($_SESSION['successMessage'] == "CommentError") {
                $successMessage = 'Une erreur est survenu, veuillez réessayer.';
                unset($_SESSION['successMessage']);
                $post = $this->postsManager->getPost($idPost);
                echo $twig->render('modifPostView.twig', ["successMessage" => $successMessage, "class" => "errorMessage", 'post' => $post, 'id' => $idPost]);
            }
        } else {
            $user = $this->usersModel->getUser($username);

            echo $twig->render('createCommentView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'id' => $post_id]);
        }
    }

    public function traitementCreateComment(){
        $idPost = $_POST["post_id"];
        $author = $_SESSION['user'];
        $comment = $_POST["comment"];

        $post = new PostModel();
        $post->post_id = $idPost;
        $post->author = $author;
        $post->comment = $comment;

        $return = $post->createComment();

        if ($return == "CommentCreated") {
            $_SESSION['successMessage'] = "CommentCreated";
        } else {
            $_SESSION['successMessage'] = "CommentError";
            header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/createCommentView');
        }
        
        header("Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/viewPost/$idPost");
    }

    /**
     * render form to modify a post
     */
    public function modifPostView($idPost){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        if (isset($_SESSION['successMessage'])) {
            if ($_SESSION['successMessage'] == "modifPostError") {
                $successMessage = 'Une erreur est survenu, veuillez réessayer.';
                unset($_SESSION['successMessage']);
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
    public function traitementModifPost($idPost){
        $title = $_REQUEST['title'];
        $chapo = $_REQUEST['chapo'];
        $content = $_REQUEST['content'];
        $date_create = $_REQUEST['dateCreate'];

        date_default_timezone_set('Europe/Paris');
        $date = date('Y-m-d H:i:s');

        $return = $this->postsManager->modifPost($idPost, $title, $chapo, $content, $date_create, $date);

        if ($return == "modifPostCreated") {
            $_SESSION['successMessage'] = "modifPostCreated";
        } else {
            $_SESSION['successMessage'] = "modifPostError";
            header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/modifPostView');
        }

        header("Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/viewPost/$idPost");
    }


    public function ViewPost(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        $username = $_SESSION['user'];

        $user = $this->usersModel->getUser($username);

        $userIsAdmin = $user['admin'];

        $get_url = $_GET["url"];
        if (@preg_match('#^([^0-9]+)([0-9]+)$#',$get_url,$post_id))
        $idPost = $post_id[2]; 

        $post = $this->postsManager->getPost($idPost);

        $comments = $this->postsManager->getComments($idPost);

        // echo "</br>";
        // var_dump($_SESSION);
        // echo "</br>";
        // die();

        if (isset($_SESSION['successMessage'])) {
            if ($_SESSION['successMessage'] == "CommentCreated") {
                $successMessage = "Votre comentaire à bien été Crée !";
                unset($_SESSION['successMessage']);
                $user = $this->usersModel->getUser($username);
                echo $twig->render('viewPost.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'post' => $post, 'comments' => $comments, "successMessage" => $successMessage, "class" => "successMessage", 'user' => $user, 'IsAdmin' => $userIsAdmin, 'id' => $post_id]);
            } elseif ($_SESSION['successMessage'] == "commentError") {
                $successMessage = 'Une erreur est survenu, veuillez réessayer.';
                unset($_SESSION['successMessage']);
                $user = $this->usersModel->getUser($username);
                echo $twig->render('createCommentView.twig', ["successMessage" => $successMessage, "class" => "successMessage", 'user' => $user, 'IsAdmin' => $userIsAdmin, 'id' => $post_id]);
            } 
            if ($_SESSION['successMessage'] == "modifPostCreated") {
                $successMessage = "Votre article à bien été Modifié !";
                unset($_SESSION['successMessage']);
                $post = $this->postsManager->getPost($idPost);
                echo $twig->render('viewPost.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'post' => $post, 'comments' => $comments, "successMessage" => $successMessage, "class" => "successMessage", 'post' => $post, 'id' => $idPost]);
            } elseif ($_SESSION['successMessage'] == "modifPostError") {
                $successMessage = 'Une erreur est survenu, veuillez réessayer.';
                unset($_SESSION['successMessage']);
                $post = $this->postsManager->getPost($idPost);
                echo $twig->render('modifPostView.twig', ["successMessage" => $successMessage, "class" => "errorMessage", 'post' => $post, 'id' => $idPost]);
            }
        } else {
            $post = $this->postsManager->getPost($idPost);

            echo $twig->render('viewPost.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'post' => $post, 'comments' => $comments, 'post_id' => $idPost]);
        } 
    }

}
