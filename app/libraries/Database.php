<?php

class Database
{
    private $dbHost = DB_HOST;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;
    private $dbName = DB_NAME;

    private $statement;
    private $dbHandler;
    private $error;

    public function __construct()
    {
        $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT => true, //prevent driver crashes
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /// METHODS ///

    //Allows us to write queries
    public function query($sql)
    {
        $this->statement = $this->dbHandler->prepare($sql);
    }

    //bind values
    public function bind($parameter, $values, $type = null)
    {
        switch (is_null($type)) {
            case is_int($values):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($values):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($values):
                $type = PDO::PARAM_NULLT;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($parameter, $values, $type);
    }

    //execute the prepare statement
    public function execute()
    {
        return $this->statement->execute();
    }

    //return array
    public function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    //return specific row as object
    public function single()
    {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    //get row count
    public function rowCount()
    {
        return $this->statement->rowCount();
    }

}
