<?php

// Class Conexion{

// 	static public function conectar(){

// 		$link = new PDO("mysql:host=localhost;dbname=mathblast",
// 						"root",
// 						"");

// 		$link->exec("set names utf8");

// 		return $link;

// 	}


// }

Class Conexion
{
    public static function conectar()
    {
        $link = new PDO("mysql:host=" .getenv('DB_HOST'). ";dbname=" .getenv('DB_NAME'),
            getenv('DB_USER'),
            getenv('DB_PASSWORD'));

        $link->exec("set names utf8");

        return $link;
    }
}