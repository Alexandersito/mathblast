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

class Conexion
{

    public static function conectar()
    {
        $link = new PDO("mysql:host=boceosgqbwef7ipdxxkg-mysql.services.clever-cloud.com;dbname=boceosgqbwef7ipdxxkg",
            "uj2legbumhmpl7fq",
            "HsaWa6DLRiji22jdYq5n");

        $link->exec("set names utf8");

        return $link;
    }

}