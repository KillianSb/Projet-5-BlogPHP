<?php

class BDD
{
    protected function dbConnect()
    {
        try{
            $db = new PDO('mysql:host=localhost;dbname=p5_ks;charset=utf8', 'root', '');
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}