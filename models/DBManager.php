<?php

class DBManager
{
    private static ?PDO $connection = null;

    /**
     * Retourne la connexion PDO partagée à la base de données.
     * @return PDO : la connexion active.
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            self::$connection = self::createConnection();
        }

        return self::$connection;
    }

    /**
     * Crée une connexion PDO à partir des variables d'environnement.
     * @return PDO : la nouvelle connexion.
     */
    private static function createConnection(): PDO
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $database = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";

        return new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}
