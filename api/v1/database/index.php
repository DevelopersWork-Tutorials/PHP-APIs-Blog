<?php

class Database{

    private $connection;
    private $isConnected;

    private $SERVER,$USERNAME,$PASSWORD,$DATABASE;

    function __construct(){
        $this->SERVER = "localhost";
        $this->USERNAME = "root";
        $this->PASSWORD = "";
        $this->DATABASE = "blog";
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

        $this->importSQLFile("\TEMPLATE.sql");
    }

    function readMultiples($queries){
        // SELECT *
        // FROM blog_users_information info,blog_users_credentials creds,blog_users users
        // WHERE users.usernam="admin21" or
        //     info.email="admin@developerswork.yt" or
        //     info.phoneNumber="121212121212"
        // group by users.uid
        // length = 3

        $tablenames = "";
        $whereClause = "";
        foreach($queries as $key => $value){
            $tablenames = $tablenames.$value["tablename"].",";
            foreach($value["whereClause"] as $whereColumn => $whereValue){
                $whereClause = $whereClause.$value["tablename"].".".$whereColumn."=";
                $whereClause = $whereClause."'".$whereValue."' or ";
            }
        }

        $tablenames = rtrim($tablenames,",");
        $whereClause = rtrim($whereClause,"or ");
        
        $columnnames = "*";

        $query = "SELECT $columnnames FROM $tablenames WHERE $whereClause;";

        // echo $query;
        $result = $this->connection->query($query);

        return $this->handleResponse($result);

    }

    function readSimple($tablename,$columnnames,$whereColumn,$whereValue){
        // select (columnnames) from tablename where col1=val;

        if($this->isConnected == false)
            return false;

        $query = "SELECT $columnnames FROM $tablename WHERE $whereColumn='$whereValue';";
        // echo $query;
        $result = $this->connection->query($query);

        return $this->handleResponse($result);
    }

    function insertSimple($tablename,$columnnames,$values){
        // insert into tablename(columenames) values (values);

        if($this->isConnected == false)
            return false;

        $query = "INSERT INTO $tablename ($columnnames) VALUES ($values);";

        $result = $this->connection->query($query);

        return $this->handleResponse($result);
    }

    function updateSimple($tablename,$columnname,$value,$whereColumn,$whereValue){
        // update tablename set columnname=value where ....

        if($this->isConnected == false)
            return false;

        $query = "UPDATE $tablename SET $columnname='$value' WHERE $whereColumn='$whereValue';";

        // echo $query;

        $result = $this->connection->query($query);

        return $this->handleResponse($result);
    }

    function importSQLFile($filename){

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
                    // echo "FAILED : ".$buffer."<BR>";
                }
                $buffer = "";
            }
        }
    }

    function createTable($tablename,$attributes){
        // create table tablename(columnname datatype,..)

        $query = "CREATE TABLE ".$tablename."(".$attributes.")";

        $result = $this->connection->query($query);

        return $this->handleResponse($result);
    }

    function query($query){
        // Any query required
        $result = $this->connection->query($query);

        return $this->handleResponse($result);
    }

    function handleResponse($result){
        $response = array();
        $response['query_error'] = false;
        if($result){
            if($result === true)
                return $response;
            $i = 0; 
            while($row = $result->fetch_assoc()){
                array_push($response,$row);
                $i += 1;
            }
            $response["length"] = $i;
            // print_r($response);
        }else
            $response["query_error"] = $this->connection->error;

        return $response;
    }

}
