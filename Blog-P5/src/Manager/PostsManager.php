<?php

namespace App\Manager;

use App\Core\Database;
use App\Models\PostModel;

class PostsManager
{

    public function __construct()
    {
        $this->db = new Database();
    }


    public function createPostView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        $username = $_SESSION['user'];

        $user = $this->usersModel->getUser($username);

        $userIsAdmin = $user['admin'];

        echo $twig->render('createPostView.twig', ['user' => $user, 'IsAdmin' => $userIsAdmin]);
    }

    /**
    * delete a post by id
    */
    public function deletePost($idPost)
    {
        $request = $this->db->db->prepare("DELETE FROM posts WHERE id=:id");
        $params = [':id' => $idPost];
        $request->execute($params);
    }

    /**
    * return multiple Posts
    */
    public function getPosts()
    {
        $request = $this->db->db->query('SELECT * FROM posts')->fetchAll();
        $postsArray = [];

        foreach ($request as $posts) {
            $postsArray[] = new PostModel($post['id'], $post['title'], $post['chapo'], $post['content'], $post['auteur'], $post['dateCreate'], $post['commentaire'], $post['listCommentaire']);
        }

        return $request;
    }

    /**
    * return single post
    */
    public function getPost($idPost)
    {
        $post = $this->db->db->query("SELECT * FROM posts WHERE id = $idPost")->fetch();
        // $post = new PostModel($post['id'], $post['titre'], $post['chapô'], $post['content'], $post['auteur'], $post['date'], $post['commentaire'], $post['listCommentaire']);
        return $post;

    }

    /**
    * return multiple comments
    */
    public function getComments($idPost)
    {

        $request = $this->db->db->query("SELECT * FROM comments WHERE post_id=$idPost")->fetchAll();
        $commentsArray = [];

        foreach ($request as $comment) {
            $commentsArray[] = new PostModel($comment['id'], $comment['post_id'], $comment['author'], $comment['comment']);
        }

        return $request;
    }

}
