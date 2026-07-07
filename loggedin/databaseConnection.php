<?php

    try{
        $conn = mysqli_connect("localhost", "root", '', "resthavendb");
    } catch(Exception $e){
        echo "Could not connect to the database. <br>
        Error: {$e}";
    }
   
?>