<?php

namespace App\Models;

/**
 * create a object of post
 */

use App\Core\Database;

class PostModel
{
    public $id;
    public $titre;
    public $chapo;
    public $contenu;
    public $auteur;
    public $date;
    public $commentaire;
    public $listCommentaire;

    public function __construct()
    {
        $this->db = new Database();
        
        $this->id = null;
        $this->titre = $titre;
        $this->chapo = $chapo;
        $this->contenu = $contenu;
        $this->auteur = $auteur;
        $this->date = $date;
        $this->commentaire = $commentaire;
        $this->listCommentaire = $listCommentaire;
    }

    public function createPost() {

        $request = $this->db->db->prepare('INSERT INTO posts (titre, chapo, contenu, auteur) VALUES (:titre, :chapo, :contenu, :auteur);');
        $params = [':titre' => $this->titre, ':chapo' => $this->chapo, ':contenu' => $this->contenu, ':auteur' => $this->auteur];
        $request->execute($params);
        // var_dump($params);
        // echo "</br>";
        // die();
    }

    // /**
    // * return all users
    // */
    // public function getUsers()
    // {
    //     $request = $this->db->db->query('SELECT * FROM users')->fetchAll();
    //     $usersArray = [];
    //     foreach ($request as $user) {
    //         $usersArray[] = new UserModel($user['id'], $user['firstname'], $user['name'], $user['mail'], $user['admin']);
    //     }
    //     return $usersArray;
    // }
  
    /**
    * return single user
    */
    public function getPost($post)
    {
        $request = $this->db->db->prepare("SELECT * from posts WHERE titre=:titre");
        $request->execute(["titre" => $titre]);
        $post = $request->fetch();

        return $post;
    }

}