<?php

    try{
        $con = new PDO("mysql:host=localhost;dbname=login_db", "root", "");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //?sets the PDO error mode to Exception
        echo "";
    } catch(PDOException $error){ // printing a detailed error
        echo "Connection failed: " . $error->getMessage();
    }

