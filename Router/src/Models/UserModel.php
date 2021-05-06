<?php

namespace App\Model;

/**
 * create a object of user
 */
class UserModel
{
    public $id;
    public $name;
    public $firstname;
    public $mail;
    public $pass;
    public $admin;

    public function __construct($id, $firstname, $name, $mail, $pass, $admin)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->name = $name;
        $this->mail = $mail;
        $this->pass = $pass;
        $this->admin = $admin;
    }
}