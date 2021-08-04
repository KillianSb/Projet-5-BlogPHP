<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\UserModel;
use App\Models\PostModel;
use App\Core\Database;


class BlogController
{

    public function __construct()
    {
        $this->usersModel = new UserModel();
        $this->postsModel = new PostModel();
        $this->db = new Database();
        
        if (!isset($_SESSION)) {
            session_start();
        }

    }

    public function blogView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);


        // if($_SESSION['user'] !== NULL){
        //     echo("Bonjour ". $_SESSION['user']);
        // } else {
        //     echo("Pas connecter <a href=".connexion.">CONNEXION</a>");
        // }

        $username = $_SESSION['user'];

        $user = $this->usersModel->getUser($username);

        $userIsAdmin = $user['admin'];

        echo $twig->render('blogView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin]);
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
        $post->titre = $_POST["titre"];
        $post->chapo = $_POST["chapo"];
        $post->contenu = $_POST["contenu"];
        $post->auteur = $_SESSION['user'];;
        $post->commentaire = $_POST["commentaire"];
        $post->createPost();
        
        header('Location: /P5-BlogPHP/Projet-5-BlogPHP/Router/blog');


        // echo "</br>";
        // var_dump($user);
        // echo "</br>";

    }

}
