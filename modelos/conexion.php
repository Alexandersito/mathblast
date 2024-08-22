<?php

// class Conexion
// {

//     public static function conectar()
//     {
//         $link = new PDO("mysql:host=localhost;dbname=mathblast",
//             "root",
//             "");

//         $link->exec("set names utf8");

//         return $link;
//     }

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

// class Conexion
// {
//     public static function conectar()
//     {
//         $host = getenv('DB_HOST');
//         $port = getenv('DB_PORT');
//         $dbname = getenv('DB_NAME');
//         $user = getenv('DB_USER');
//         $password = getenv('DB_PASSWORD');

//         $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
//         $link = new PDO($dsn, $user, $password);

//         $link->exec("set names utf8");

//         return $link;
//     }
// }