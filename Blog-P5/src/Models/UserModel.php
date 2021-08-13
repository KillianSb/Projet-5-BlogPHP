<?php

namespace App\Models;

/**
 * create a object of user
 */

use App\Core\Database;

class UserModel
{
    public $id;
    public $name;
    public $firstname;
    public $username;
    public $mail;
    public $pass;
    public $admin;

    public function __construct()
    {
        $this->db = new Database();
        
        $this->id = null;
        $this->name = $name;
        $this->firstname = $firstname;
        $this->username = $username;
        $this->mail = $mail;
        $this->pass = $pass;
        $this->admin = $admin;
    }

    public function connexion($usernameToVerify, $passwordToVerify) {

        $request = $this->db->db->prepare("SELECT * from users WHERE username=:username");
        $request->execute(["username" => $usernameToVerify]);
        $user = $request->fetch();
        if (empty($user)) {
            return(['n']);
        }
        // echo "</br>";
        // echo "user :";
        // echo "</br>";
        // var_dump($user);
        // echo "</br>";
        // die();
        $password = $user['pass'];

        if (password_verify($passwordToVerify, $password)) {
            $userBdd = new UserModel($user['id'], $user['name'], $user['firstname'], $user['username'] ,$user['mail'], $user['pass'], $user['admin']);
            // var_dump($userBdd);
            // die();
            return(['y', $userBdd]);
            // echo "</br>";
            // var_dump($passwordToVerify);
            // echo "</br>";
            // echo "</br>";
            // var_dump($userBdd);
            // echo "</br>";
            // die();
        }
        return(['n']);

    }


    public function inscription() {

        $request = $this->db->db->prepare('INSERT INTO users (name, firstname, username, mail, pass) VALUES (:name, :firstname, :username, :mail, :pass);');
        $params = [':name' => $this->name, ':firstname' => $this->firstname, ':username' => $this->username, ':mail' => $this->mail, ':pass' => $this->pass];
        $request->execute($params);
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
    public function getUser($username)
    {
        $request = $this->db->db->prepare("SELECT * from users WHERE username=:username");
        $request->execute(["username" => $username]);
        $user = $request->fetch();

        return $user;
    }

}