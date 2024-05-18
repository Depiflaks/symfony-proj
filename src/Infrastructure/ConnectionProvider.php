<?php
declare(strict_types=1);

namespace App\Infrastructure;

class ConnectionProvider
{
    public static function connectDatabase(): ?\PDO
    {
        $jsonData = json_decode(file_get_contents(__DIR__ . '/account.json'), true);
        try 
        {
            return new \PDO($jsonData['dsn'], $jsonData['name'], $jsonData['password']);
        }
        catch (\PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}