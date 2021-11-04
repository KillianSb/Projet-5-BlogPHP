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


    /**
    * return multiple users
    */
    public function getUsers()
    {
        
        $request = $this->db->db->query('SELECT * FROM users')->fetchAll();
        $usersArray = [];

        foreach ($request as $users) {

            return $request;
        }

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
        } 
        else {
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
