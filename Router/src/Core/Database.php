<?php

namespace App\Core;

use \PDO;

class Database
{

    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    protected function dbConnect()
    {
        try{
            return new PDO('mysql:host=localhost;dbname=p5_ks;charset=utf8', 'root', '');
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    

    // public function query($query){
    //     $result = $this->db->prepare($query);
    //     $result->execute();
    //     return $result;
    // }
}