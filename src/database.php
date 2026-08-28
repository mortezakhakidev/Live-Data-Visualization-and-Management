<?php

namespace Src;



class Database {


  private $dbConnection = null;


  public function __construct()

  {

    $host = 'localhost';

    $port = '3306';

    $db   = 'd3';

    $user = 'root';

    $pass = '';


    try {

      $this->dbConnection = new \PDO(

          "mysql:host=$host;port=$port;dbname=$db",

          $user,

          $pass

      );

    } catch (\PDOException $e) {

      exit($e->getMessage());

    }

  }


  public function connet()

  {

    return $this->dbConnection;

  }

}