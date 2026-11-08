<?php

declare(strict_types=1);

return function (): PDO {

    $host = 'localhost';
    $database = 'ecbamisi_woodboard';
    $username = 'ecbamisi_woodboard';
    $password = 'DataHatice21@@*';

    $dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";

    try {
        return new PDO(
            $dsn,
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    } catch (PDOException $e) {
        throw new RuntimeException(
            'No fue posible establecer conexión con la base de datos.'
        );
    }
};