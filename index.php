<?php

    $connection = new mysqli("localhost","root","","blog");

    if(!$connection){
        die("CONNECTION FAILED");
    }else{
        echo "CONNECTION DONE<br>";
    }

    $query = "SELECT * FROM blog_users;";

    $result = $connection->query($query);

    if($result){
        while($row = $result->fetch_assoc()){
            print_r($row);
        }
    }
    else{
        die("QUERY FAILED");
    }


?>