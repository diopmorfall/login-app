<?php

    try{
        $con = mysqli_connect("localhost", "root", "", "login_db");
        if($con){
            echo "We're connected to the database <br>";
        }
    } catch(Exception $error){ // printing a detailed error
        echo $error->getMessage();
    }

