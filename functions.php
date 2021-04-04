<?php

    function check_login($con) {
        if(isset($_SESSION['user_name'])){ // superglobal variable
            $user_name = $_SESSION['user_name'];
            $query = "SELECT * FROM users WHERE user_name = '$user_name' LIMIT 1";

            $result = mysqli_query($con, $query);

            if(mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        } else { // redirect to login page
            header("Location: login.php");
            die;
        }
    }

    // sanitization and validation

    function validate_strings($string) {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);
        return filter_var($string, FILTER_SANITIZE_STRING);       
    }

    function print_error($error_code) { //? displaying the error messages in the login or signup page
        $error = "";
        switch ($error_code) {
            //? signup errors

            case 'username-too-long':
                $error = "The username must have less than 15 characters";
                break;

            case 'password-length-not-valid':
                $error = "The password must have from 8 to 12 characters";
                break;

            case 'username-found':
                $error = "This username is already used, please choose another one";
                break;

            case 'numeric-username': 
                $error = "The username cannot be a number, please enter a valid value";
                break;      

            //? login errors

            case 'wrong-password':
                $error = "The password entered for the user is not correct";
                break;

            case 'username-not-found':
                $error = "The username entered is not correct";
                break;

            //? both a signup and login error

                case 'missing-data': 
                    $error = "Please insert some valid data, username and password are required";
                    break;
            
            default:
                unset($error);
                break;
        }
        return $error;
    }

    //todo: Style the pages
