<?php
class db_pdo
{
    const DB_SERVER_TYPE = 'mysql'; // MySQL or MariaDB server
    const DB_HOST = '127.0.0.1'; // local server on my laptop
    const DB_PORT = 3307; // optional, default 3306, use 3307 for MariaDB
    const DB_NAME = 'classicmodels'; // for Database classicmodels
    const DB_CHARSET = 'utf8mb4'; //optional

    const DB_USER_NAME = 'root'; // default user, other users can be created with phpMyAdmin
    const DB_PASSWORD = '';

    // PDO connection options
    const DB_OPTIONS = [
        // throw exception on SQL errors
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // return records with associative keys only, no numeric index
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        //
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    private $DB_connexion;

    public function connect()
    {
        $DSN = self::DB_SERVER_TYPE . ':host=' . self::DB_HOST . ';port=' . self::DB_PORT . ';dbname=' . self::DB_NAME . ';charset=' . self::DB_CHARSET;
        try {
            $this->DB_connexion = new PDO($DSN, self::DB_USER_NAME, self::DB_PASSWORD, self::DB_OPTIONS);
            //echo 'connected to DB!';
        } catch (PDOException $e) {
            header('HTTP/1.0 500 Database connection error ' . $e->getMessage());
            exit('Database connection error ' . $e->getMessage());
        }
    }

    public function disconnect()
    {
        $this->DB_connexion = null;
    }

    /**
     * for INSERT, UPDATE DELETE queries, returns PDOstatement object
     */
    public function query($sql)
    {
        try {
            $result = $this->DB_connexion->query($sql);
            return $result;
        } catch (PDOException $e) {
            header('HTTP/1.0 500 Database error ' . $e->getMessage());
            exit('Database error ' . $e->getMessage());
        }
    }

    /**
     * for SELECT queries, returns a table
     */
    public function querySelect($sql)
    {
        try {
            $result = $this->DB_connexion->query($sql);
            return $result->fetchAll();
        } catch (PDOException $e) {
            header('HTTP/1.0 500 Database error ' . $e->getMessage());
            exit('Database error ' . $e->getMessage());
        }
    }

    public function table($tableName)
    {
        return $this->querySelect("SELECT * FROM " . $tableName);
    }

    /**
     * parameterized query for INSERT, UPDATE DELETE
     */
    public function queryParam($sql, $params)
    {
        try {
            $stmt = $this->DB_connexion->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            header('HTTP/1.0 500 Database error ' . $e->getMessage());
            exit('Database error ' . $e->getMessage());
        }
    }

    /**
     * parameterized query for SELECT
     */
    public function querySelectParam($sql, $params)
    {
        try {
            $stmt = $this->DB_connexion->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            header('HTTP/1.0 500 Database error ' . $e->getMessage());
            exit('Database error ' . $e->getMessage());
        }
    }
}
