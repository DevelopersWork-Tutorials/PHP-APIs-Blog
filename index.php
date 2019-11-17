<?php
    $response = array();
    $connection = new mysqli("localhost","root","","blog");

    if($connection->connect_error){
        $response["error"] = "CONNECTION FAILED";
        die();
    }else{
        // echo "CONNECTION DONE<br>";
    }

    $query = "SELECT * FROM blog_users;";

    $result = $connection->query($query);

    if($result){
        while($row = $result->fetch_assoc()){
            // print_r($row);
            $response[$row["uid"]] = $row;
        }
    }
    else{
        $response["error"] = "QUERY FAILED";
        die();
    }

    echo json_encode($response);


    include_once './api/v1/database/index.php';

    $db = new Database();

    $db->setAttributes("localhost","root","","blog");

    if($db->connect()){
        echo "DONE";
    }

    $result = $db->readSimple("blog_users","*","1=1");

    if($result){
        echo "<br>DONE";
    }

    while($row = $result->fetch_assoc()){
        print_r($row);
    }

    $data = "user1";

    $result = $db->insertSimple("blog_users","(username)","('".$data."')");

    if($result){
        echo "<br>DONE";
    }

    $result = $db->readSimple("blog_users","*","1=1");

    if($result){
        echo "<br>DONE";
    }

    while($row = $result->fetch_assoc()){
        print_r($row);
    }

?>