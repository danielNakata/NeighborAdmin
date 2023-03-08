<?php
  class CBDConn {
    public $user = "neighuser";
    public $pass = "123456";
    public $host = "localhost";
    public $port = "3306";
    public $name = "dbneigh_admin";

    public $connection = "";

    function createConnection(){
      $this->connection = new mysqli($this->host.":".$this->port, $this->user, $this->pass, $this->name);
      return $this->connection;
    }
  }
?>
