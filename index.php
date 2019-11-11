<?php
    $response = array();
    $connection = new mysqli("localhost","root","","blog");

    if(!$connection){
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


?>