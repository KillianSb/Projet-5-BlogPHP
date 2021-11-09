<?php

namespace App\Models;

/**
 * create a object of user
 */

use App\Core\Database;

class UserModel
{
	public $name;
	public $firstname;
	public $username;
	public $mail;
	public $pass;

	public function __construct()
	{
		$this->db = new Database();
	}

	public function connexion($usernameToVerify, $passwordToVerify)
	{

		$request = $this->db->db->prepare("SELECT * from users WHERE username=:username");
		$request->execute(["username" => $usernameToVerify]);
		$user = $request->fetch();
		if (empty($user)) {
			return (['n']);
		}

		$password = $user['pass'];

		if (password_verify($passwordToVerify, $password)) {
			$userBdd = new UserModel($user['id'], $user['name'], $user['firstname'], $user['username'], $user['mail'], $user['pass'], $user['admin']);
			return (['y', $userBdd]);
		}
		return (['n']);
	}


	public function inscription($name, $firstname, $username, $mail, $pass)
	{

		$checkMail = $this->db->db->prepare("SELECT * FROM users WHERE mail=:mail");
		$checkMail->execute(["mail" => $mail]);
		$userMail = $checkMail->fetch();

		$checkUsername = $this->db->db->prepare("SELECT * FROM users WHERE username=:username");
		$checkUsername->execute(["username" => $username]);
		$userUsername = $checkUsername->fetch();

		if (!empty($userMail)) {
			return ('em');
		} elseif (!empty($userUsername)) {
			return ('eu');
		}

		$request = $this->db->db->prepare('INSERT INTO users (name, firstname, username, mail, pass) VALUES (:name, :firstname, :username, :mail, :pass);');
		$params = [':name' => $name, ':firstname' => $firstname, ':username' => $username, ':mail' => $mail, ':pass' => $pass];
		if ($request->execute($params)) {
			return ("y");
		}
		return ('n');
	}

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
