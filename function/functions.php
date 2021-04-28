<?php

    function check_login($con) {
        if(isset($_SESSION['user_name'])){ // superglobal variable
            $user_name = $_SESSION['user_name'];
            $query = $con->prepare("SELECT * FROM  users WHERE user_name = ? LIMIT 1");
            $query->execute([$user_name]);

            if($query->rowCount() === 1){
                return ($query->fetch());
            }
        } else { // redirect to login page
            header("Location: ../login.php");
        }
    }

    // sanitization and validation

    function validate_strings($string) {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);
        return filter_var($string, FILTER_SANITIZE_STRING);       
    }

    function print_message($msg_code) { //? displaying the errors or messages in the login or signup page
        $message = "";
        switch ($msg_code) {
            //? signup and edit messages

            case 'username-too-long':
                $message = "The username must have less than 15 characters";
                break;

            case 'password-length-not-valid':
                $message = "The password must have from 8 to 12 characters";
                break;

            case 'username-found':
                $message = "This username is already used, please choose another one";
                break;

            case 'numeric-username': 
                $message = "The username cannot be a number, please enter a valid value";
                break;     
                
            case 'different-passwords':
                $message = "The entered passwords are different, please retype them";
                break;

            //? login messages

            case 'wrong-password':
                $message = "The password entered for the user is not correct";
                break;

            case 'username-not-found':
                $message = "The username entered is not correct";
                break;

            //? edit account message

            case 'updated-data':
                $message = "Your account information has been updated";
                break;

            case 'updated-username':
                $message = "Your username has been updated";
                break;

            case 'updated-psw':
                $message = "Your password has been updated";
                break;

            //? signup, login and edit message

            case 'missing-data': 
                $message = "Please insert some valid data, username and password are required";
                break;
            
            //? recover account message

            case 'successfully-recovered':
                $message = "Your password has been successfully changed, you can try to login again";
                break;

            //? delete account message

            case 'unsubscribed': 
                $message = "Your account has been deleted";
                break;
            
            default:
                unset($message);
                break;
        }
        return $message;
    }

