<?php
    session_start();

    include "html/header.html";
    include "connection.php";
    include "functions.php";

    if(!isset($_SESSION['user_name'])) {  //? if the user is not logged in yet
 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $user_name = validate_strings($_POST["username"]);
            $password = validate_strings($_POST["password"]);

            if(!empty($user_name) && !empty($password)){ // if there are some values inserted
                //read from the database
                $query = "SELECT * FROM  users WHERE user_name = '$user_name' LIMIT 1";
                $result = mysqli_query($con, $query);

                if(mysqli_num_rows($result) === 1){ // if there's a user with $user_name
                    $user_data = mysqli_fetch_assoc($result);
                    if($user_data['password'] === $password){ // if the password is correct
                        $_SESSION['user_name'] = $user_data['user_name']; // assigning the session to $user_name
                        header("Location: index.php"); //redirect to the profile page
                        die;
                    } else { // if the password is not correct
                        header("Location: login.php?error=wrong-password");
                    }
                } else { // if there's no username $user_name in the database
                    header("Location: login.php?error=username-not-found");
                }
            } else { // if user or password are empty
                header("Location: login.php?error=missing-data");
            }
        }
?>

        <title>Login App - Login</title>
    </head>
    <body>
        <?php include "html/navbar.html";?>
        <div class="page">
            <h3 class="slogan">Return in your account now !</h3>
            <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <?php if(isset($_GET['error'])){ ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo print_error($_GET['error']); ?>
                    </div>
                <?php } ?>
                <label for="username">Username: </label>
                <input id ="username" class="input" type="text" name="username" placeholder="Enter your username" autofocus><br>
                <label for="psw">Password: </label>
                <input id ="psw" class="input" type="password" name="password" placeholder="Enter your password"><br><br>
                <input class="btn btn-primary button" type="submit" value="Login"><br>           
                <a href="signup.php">Click here if you don't already have an account to signup</a>
            </form>
        </div>
    </body>
</html>
<?php 
    } else { //? if the user is already logged in but tries to open the login page without logging out
        header("Location: index.php");
    }
?>