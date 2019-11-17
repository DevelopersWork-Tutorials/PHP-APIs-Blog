<?php

class Database{

    private $connection;
    private $isConnected;

    private $SERVER,$USERNAME,$PASSWORD,$DATABASE;

    function __construct(){
        $this->SERVER = "localhost";
        $this->USERNAME = "root";
        $this->PASSWORD = "";
        $this->DATABASE = "test";
        $this->isConnected = false;
    }

    function setAttributes($server,$username,$password,$database){
        $this->SERVER = $server;
        $this->USERNAME = $username;
        $this->PASSWORD = $password;
        $this->DATABASE = $database;
        $this->isConnected = false;
    }

    function connect(){
        $this->connection = new mysqli($this->SERVER,$this->USERNAME,$this->PASSWORD,$this->DATABASE);

        if($this->connection->connect_error){
            $this->isConnected = false;
            return false;
        }
        
        $this->isConnected = true;
        return true;
    }

    function readSimple($tablename,$columnnames,$whereclause){
        // select (columnnames) from tablename where col1=val;

        if($this->isConnected == false)
            return false;

        $query = "SELECT ".$columnnames." FROM ".$tablename." WHERE ".$whereclause.";";

        $result = $this->connection->query($query);

        if(!$result)
            return false;

        return $result;
    }

    function insertSimple($tablename,$columnnames,$values){
        // insert into tablename(columenames) values (values);

        if($this->isConnected == false)
            return false;

        $query = "INSERT INTO ".$tablename." ".$columnnames." VALUES ".$values.";";

        $result = $this->connection->query($query);

        if(!$result)
            return false;

        return $result;
    }

}