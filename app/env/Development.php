<?php

namespace app\env;

error_reporting(-1);
ini_set('display_errors', 1);

class Development implements Example
{
    function pdo(): \PDO
    {
        static $pdo;

        if (!isset($pdo)) {
            $pdo = new \PDO('mysql:host=db;dbname=blog', 'blog', 'pass');
        }

        return $pdo;
    }

}
