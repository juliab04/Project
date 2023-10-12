<?php
namespace Repository;
use PDO;

class ConnectionFactory
{
    private static PDO $pdo;
    public static function create(): PDO
    {
        if (isset(static::$pdo)) {
            return static::$pdo;
        }
        static::$pdo= new PDO("pgsql:host = db, dbname=dbname", "dbuser", "dbpwd");
        return static::$pdo;
    }

}