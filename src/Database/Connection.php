<?php

namespace App\Database;

use PDO;
use PDOException;
use App\Helpers\EnvironmentVariables;

class Connection
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host = EnvironmentVariables::get('DB_HOST');
            $db   = EnvironmentVariables::get('DB_DATABASE');
            $user = EnvironmentVariables::get('DB_USERNAME');
            $pass = EnvironmentVariables::get('DB_PASSWORD');
            $charset = EnvironmentVariables::get('DB_CHARSET') ?: 'utf8mb4';
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            
            try {
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$instance;
    }
}