<?php

/**
 * Database "signleton" wrapper
 */
class Database
{
    /**
     * @var PDO
     */
    protected static $pdo;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        self::connect();
    }

    /**
     * Checks if Database::$pdo is set, if not it will initialize the database connection with a new PDO instance.
     * Does nothing if we were already connected to the database.
     */
    public static function connect()
    {
        if(self::$pdo != null) {
            return;
        }

        $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME;

        try {
            self::$pdo = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);
        } catch (Exception $e) {
            print_r('Connexion à la base de données impossible.', $e->getMessage());
        }
    }

    /**
     * @return PDO
     */
    public function getPdo() {
        return self::$pdo;
    }
}