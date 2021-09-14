<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\UserModel;
use App\Models\PostModel;
use App\Manager\UsersManager;
use App\Manager\PostsManager;
use App\Core\Database;


class BlogController
{

    private $usersManager;
    private $postsManager;

    private $usersModel;
    private $postsModel;

    public function __construct()
    {
        $this->usersModel = new UserModel();
        $this->postsModel = new PostModel();
        $this->usersManager = new UsersManager();
        $this->postsManager = new PostsManager();

        $this->db = new Database();
        
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

        // $comments = $this->postsManager->getComments();

        echo $twig->render('blogView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'posts' => $posts, 'comments' => $comments]);
    }

    public function createPostView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        $username = $_SESSION['user'];

        $user = $this->usersModel->getUser($username);

        $userIsAdmin = $user['admin'];

        echo $twig->render('createPostView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin]);
    }

    public function traitementCreatePost(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        // echo "</br>";
        // var_dump($_POST);
        // echo "</br>";

        $post = new PostModel();
        $post->title = $_POST["title"];
        $post->chapo = $_POST["chapo"];
        $post->content = $_POST["content"];
        $post->auteur = $_SESSION['user'];;
        $post->createPost();
        
        header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/blog');


        // echo "</br>";
        // var_dump($user);
        // echo "</br>";

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

        // echo "</br>";
        // echo "TEST";
        // echo "</br>";
        // var_dump($post_id);
        // echo "</br>";
        // die();

        echo $twig->render('createCommentView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'post_id' => $post_id]);
    }

    public function traitementCreateComment(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        $post = new PostModel();
        $post->post_id = $_POST["post_id"];
        $post->author = $_SESSION['user'];
        $post->comment = $_POST["comment"];
        $post->createComment();
        
        header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Blog-P5/blog');

        // echo "</br>";
        // var_dump($_POST);
        // echo "</br>";
        // die();

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

        echo $twig->render('viewPost.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin, 'post' => $post, 'comments' => $comments, 'post_id' => $idPost]);

    }

}
