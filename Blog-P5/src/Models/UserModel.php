<?php

namespace App\Models;

/**
 * create a object of user
 */

class UserModel
{
    public $id;
    public $name;
    public $firstname;
    public $mail;
    public $admin;
	public $pass;

    public function __construct($id, $firstname, $name, $mail, $admin, $pass)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->name = $name;
        $this->mail = $mail;
        $this->admin = $admin;
		$this->pass = $pass;
    }
}