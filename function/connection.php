<?php

    try{
        $con = mysqli_connect("localhost", "root", "", "login_db");
        if($con){
            echo "";
        }
    } catch(Exception $error){ // printing a detailed error
        echo $error->getMessage();
    }

