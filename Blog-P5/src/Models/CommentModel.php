<?php

namespace App\Models;

class CommentModel
{
	public $id;
	public $post_id;
    public $author;
	public $comment;
	public $comment_date;

    public function __construct($id, $post_id, $author, $comment, $comment_date)
    {
        $this->id = $id;
        $this->post_id = $post_id;
        $this->author = $author;
        $this->comment = $comment;
		$this->comment_date = $comment_date;
    }   
}
