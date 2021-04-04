<?php
    session_start();

    include "html/header.html";
    include "connection.php";
    include "functions.php";

    if(!isset($_SESSION['user_name'])) { //? if the user is not logged in yet

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $user_name = validate_strings($_POST["username"]);
            $password = validate_strings($_POST["password"]);
            
            if(!empty($user_name) && !empty($password)){ //? checking if the values are empty
                if(!is_numeric($user_name)){ // if the username is not a number
                    if(strlen($user_name) > 15){
                        header("Location: signup.php?error=username-too-long");
                    } else if (strlen($password) < 8 || strlen($password) > 12){
                        header("Location: signup.php?error=password-length-not-valid");
                    } else {
                        $check_user_query = "SELECT user_name FROM users WHERE user_name = '$user_name'";
                        $check = mysqli_query($con, $check_user_query);
                            
                        if(mysqli_num_rows($check) === 1){
                            header("Location: signup.php?error=username-found");
                        } else {    //? save in the database
                            $query = "INSERT INTO users (user_name, password) VALUES ('$user_name', '$password')";
                            mysqli_query($con, $query);
                            header("Location: login.php");
                            die;
                        }
                    }
                } else { // the username is a number
                    header("Location: login.php?error=numeric-username");
                }
            } else { //? if one of the values is empty
                header("Location: signup.php?error=missing-data");
            } 
        }
?>

        <title>Login App - Signup</title>
    </head>
    <body>
        <?php include "html/navbar.html";?>
        <div class="page">
            <h3 class="slogan">Sign up now to have an account !</h3>
            <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <?php if(isset($_GET['error'])){ /*displaying the errors*/?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo print_error($_GET['error']); ?>
                    </div>
                <?php } ?>
                <label for="username">Username: </label>
                <input id ="username" class="input" type="text" name="username" placeholder="Enter your username" autofocus><br>
                <label for="psw">Password: </label>
                <input id ="psw" class="input" type="password" name="password" placeholder="Enter your password"><br><br>
                <input class="btn btn-primary button" type="submit" value="Sign up"><br>
                <a href="login.php">Click here if you already have an account to login</a>
            </form>
        </div>
    </body>
</html>
<?php 
    } else { //? if the user is already logged in but tries to open the signup page without logging out
        header("Location: index.php");
    }
?>