<?php

namespace App\Manager;

use App\Core\Database;
use App\Models\UserModel;

class UsersManager
{

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
	 * return multiple users
	 */
	public function getUsers()
	{

		$request = $this->db->db->query('SELECT * FROM users ORDER BY id DESC')->fetchAll();
		$usersArray = [];

		foreach ($request as $usersArray) {
			return $request;
		}
	}

	/**
	 * return single user
	 */
	public function getUserByUsername($username)
	{
		$request = $this->db->db->prepare("SELECT * from users WHERE username=:username");
		$request->execute(["username" => $username]);
		$user = $request->fetch();

		return $user;
	}

	/**
	 * return single user
	 */
	public function getUser($idUser)
	{
		$user = $this->db->db->query("SELECT * FROM users WHERE id = $idUser")->fetch();

		return $user;
	}

	/**
	 * change law admin of user
	 */
	public function lawChange($idUser)
	{
		$user = $this->getUser($idUser);

		if ($user['admin'] == '0') {
			$request = $this->db->db->prepare('UPDATE users SET admin = :admin WHERE id = :id ');
			$params = [':admin' => '1', ':id' => $idUser];
			$request->execute($params);
		} else {
			$request = $this->db->db->prepare('UPDATE users SET admin = :admin WHERE id = :id ');
			$params = [':admin' => '0', ':id' => $idUser];
			$request->execute($params);
		}
	}

	/**
	 * delete a user by id
	 */
	public function deleteUser($idUser)
	{
		$request = $this->db->db->prepare("DELETE FROM users WHERE id=:id");
		$params = [':id' => $idUser];
		$request->execute($params);
	}
}
