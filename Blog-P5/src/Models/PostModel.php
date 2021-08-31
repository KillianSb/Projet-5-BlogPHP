<?php

namespace App\Models;

/**
 * create a object of post
 */

use App\Core\Database;

class PostModel
{
    public $id;
    public $title;
    public $chapo;
    public $content;
    public $auteur;
    public $dateCreate;
    public $commentaire;
    public $listCommentaire;

    public function __construct()
    {
        $this->db = new Database();
        
        $this->id = null;
        $this->title = $title;
        $this->chapo = $chapo;
        $this->content = $content;
        $this->auteur = $auteur;
        $this->dateCreate = $dateCreate;
        $this->commentaire = $commentaire;
        $this->listCommentaire = $listCommentaire;
    }

    public function createPost() {

        $request = $this->db->db->prepare('INSERT INTO posts (titre, chapo, contenu, auteur) VALUES (:titre, :chapo, :contenu, :auteur);');
        $params = [':titre' => $this->title, ':chapo' => $this->chapo, ':contenu' => $this->content, ':auteur' => $this->auteur];
        $request->execute($params);
        // var_dump($params);
        // echo "</br>";
        // die();
    }
  
    /**
    * return single user
    */
    public function getPost($post)
    {
        $request = $this->db->db->prepare("SELECT * from posts WHERE titre=:title");
        $request->execute([":title" => $title]);
        $post = $request->fetch();

        return $post;
    }

    public function createComment() {

        $request = $this->db->db->prepare('INSERT INTO comments (post_id, author, comment) VALUES (:post_id, :author, :comment);');
        $params = [':post_id' => $this->post_id, ':author' => $this->author, ':comment' => $this->comment];
        $request->execute($params);
        
        // var_dump($params);
        // echo "</br>";
        // die();
    }
    

}