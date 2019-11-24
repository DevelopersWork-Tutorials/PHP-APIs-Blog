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
        
        return $this->isConnected = $this->checkTemplate();
    }

    function checkTemplate(){
        $query = "select 1 from blog_users LIMIT 1;";
        $result1 = $this->connection->query($query);
        
        $query = "select 1 from blog_roles LIMIT 1;";
        $result2 = $this->connection->query($query);

        $query = "select 1 from blog_services LIMIT 1;";
        $result3 = $this->connection->query($query);
        
        $query = "select 1 from blog_posts LIMIT 1;";
        $result4 = $this->connection->query($query);

        if($result1 && $result2 && $result3 && $result4){
            return TRUE;
        }

        if($result1 || $result2 || $result3 || $result4){
            return FALSE;
        }

        $this->importSQLFile();
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

    function importSQLFile(){
        $filename = "\TEMPLATE.sql";
        echo __DIR__;
        $file = file(__DIR__.$filename);

        $buffer = "";
        foreach($file as $record){
            if(substr($record,0,2) == "--" || $record == ""){
                continue;
            }
            
            $buffer = $buffer.$record;

            if(substr(trim($record),-1,1) == ";"){
                $result = $this->connection->query($buffer);
                if(!$result){
                    echo "FAILED : ".$buffer."<BR>";
                }
                $buffer = "";
            }
        }
    }

}