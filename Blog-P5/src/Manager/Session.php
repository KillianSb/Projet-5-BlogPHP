<?php

namespace App\Manager;

class Session{

    public static function put($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function get($key){
        return (isset($_SESSION[$key]) ? $_SESSION[$key] : null);
    }

    public static function forget($key){
        unset($_SESSION[$key]);
    }

	public static function start(){
		return !!session_id(); 
    }

	public static function sessionStart(){
		session_start();
    }
}