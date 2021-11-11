<?php

namespace App\Manager;

use App\Core\Database;
use App\Models\PostModel;
use App\Models\CommentModel;

class PostsManager
{

    public function __construct(){   
        $this->db = new Database();
    }

    public function createPost($titre, $chapo, $content, $auteur) {

        $request = $this->db->db->prepare('INSERT INTO posts (titre, chapo, contenu, auteur) VALUES (:titre, :chapo, :contenu, :auteur);');
        $params = [':titre' => $titre, ':chapo' => $chapo, ':contenu' => $content, ':auteur' => $auteur];
        if ($request->execute($params)) {
            return("postCreated");
        }
        return('postError');
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
		$request = $this->db->db->query('SELECT * FROM posts ORDER BY id DESC');
		$posts = $request->fetchAll();
		$postsArrays = [];

		foreach ($posts as $post) {
			$postArray = new PostModel($post['id'], $post['titre'], $post['chapo'], $post['contenu'], $post['auteur'], $post['lastModif'], $post['dateCreate']);
			$postsArrays[] = $postArray;
		}
		return $postsArrays;
	}

	/**
	 * return single post
	 */
	public function getPost($idPost)
	{
		$request = $this->db->db->prepare("SELECT * FROM posts WHERE id=:id");
		$request->execute(["id" => $idPost]);
		$post = $request->fetch();

		return $post;
	}

	/**
	 * create comment by post id
	 */
	public function createComment($idPost, $author, $comment)
	{

        $request = $this->db->db->prepare('INSERT INTO comments (post_id, author, comment) VALUES (:post_id, :author, :comment);');
        $params = [':post_id' => $idPost, ':author' => $author, ':comment' => $comment];
        if ($request->execute($params)) {
            return("CommentCreated");
        }
        return('CommentError');
    }

	/**
	 * return multiple comments
	 */
	public function getComments($idPost)
	{
		$request = $this->db->db->query("SELECT * FROM comments WHERE post_id=$idPost ORDER BY id DESC");
		$comments = $request->fetchAll();
		$commentsArrays = [];


		foreach ($comments as $comment) {
			$commentArray = new CommentModel($comment['id'], $comment['post_id'], $comment['author'], $comment['comment'], $comment['comment_date']);
			$commentsArrays[] = $commentArray;

		}
		return $commentsArrays;
	}

	/**
	 * delete a post by id
	 */
	public function deleteComment($idComment)
	{
		$request = $this->db->db->prepare("DELETE FROM comments WHERE id=:id");
		$params = [':id' => $idComment];
		$request->execute($params);
	}

	/**
	 * modif a post by id
	 */
	public function modifPost($idPost, $title, $chapo, $content, $date_create, $date)
	{
		$request = $this->db->db->prepare("UPDATE posts SET titre=:title, chapo=:chapo, contenu=:content, dateCreate=:date_create, lastModif=:date WHERE id=:id");
		$params = [':title' => $title, ':chapo' => $chapo, ':content' => $content, ':date_create' => $date_create, ':date' => $date, ':id' => $idPost];

		if ($request->execute($params)) {
			return ("modifPostCreated");
		}
		return ('modifPostError');
	}
}
