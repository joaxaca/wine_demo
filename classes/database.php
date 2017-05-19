<?php

  class Database{
    private $host = '52.60.109.91';
    private $user = 'userDB2';
    private $password = 'password';
    private $dbname = 'db2';

    private $dbh;
    private $error;
    private $stmt;

    public function __construct() {
      // Set DSN
      $dsn = 'mysql:host='. $this->host. ';dbname='. $this->dbname;
      // Set options
      $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION
      );
      // Create new PDO
      try {
        $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
      }
      catch(PDOException $e) {
        $this->error = $e->getMessage();
      }
    }

    public function query($query) {
      $this->stmt = $this->dbh->prepare($query);
      /*
      echo '<pre>';
      print_r($this->stmt);
      echo '</pre>';
      */
    }

    public function bind($param, $value, $type = null) {
      if(is_null($type)) {
        switch(true) {
          case is_int($value):
            $type = PDO::PARAM_INT;
            break;
          case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
          case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
          default:
            $type = PDO::PARAM_STR;
        }
      }
      $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
      return $this->stmt->execute();
    }

    public function lastInsertId() {
      $this->dbh->lastInsertId();
    }

    public function resultset() {
      try {
        $this->execute();
      }
      catch(Exception $e) {
        echo $e->getMessage();
      }
      finally {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
      }
    }

  }

?>
