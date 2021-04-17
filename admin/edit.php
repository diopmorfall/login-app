<?php
	session_start();

	include "../html/admin-header.html";
	include "../function/connection.php";
    include "../function/functions.php";

    $user_data = check_login($con);
    $current_user_name = $user_data['user_name'];



        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $new_user_name = validate_strings($_POST["new-username"]);
            $new_password = validate_strings($_POST["new-password"]);
            $rep_password = validate_strings($_POST["rep-password"]);
            
            //todo: refactor this, it's a bit ugly (maybe in a function)
            if(!empty($new_user_name) && empty($new_password) && empty($rep_password)){ //? if the username is not empty but the passwords are
                if(!is_numeric($new_user_name)){ // if the username is not a number
                    if(strlen($new_user_name) <= 15){
                        $check_user_query = "SELECT user_name
                                                FROM users
                                                WHERE user_name = '$new_user_name'";
                        $check = mysqli_query($con, $check_user_query);
                            
                        if(mysqli_num_rows($check) === 0){ //? check if there is already a username with that name
                            $query = "UPDATE users
                                SET user_name = '$new_user_name'
                                WHERE user_name = '$current_user_name'";
                            $update = mysqli_query($con, $query);
                            $_SESSION['user_name'] = $new_user_name;
                            header("Location: edit.php?message=updated-data");
                        } else {
                            header("Location: edit.php?message=username-found");
                        }
                    } else { //? username too long
                        header("Location: edit.php?message=username-too-long");
                    }
                } else { //? the username is a number
                    header("Location: edit.php?message=numeric-username");
                }
            }
            
            else if(empty($new_user_name) && !empty($new_password) && !empty($rep_password)){ //? if the username is empty but the passwords aren't
                if (strlen($new_password) >= 8 && strlen($new_password) <= 12){
                    if ($rep_password === $new_password){
                        $query = "UPDATE users
                            SET password = '$new_password'
                            WHERE user_name = '$current_user_name'";
                        $update = mysqli_query($con, $query);
                        header("Location: edit.php?message=updated-data");
                    } else { //? the password entered in the fields are different
                        header("Location: edit.php?message=different-passwords");
                    }
                } else { //? password too long or too short
                    header("Location: edit.php?message=password-length-not-valid");
                }
            }
            else if(!empty($new_user_name) && !empty($new_password) && !empty($rep_password)){ //? all values entered
                if(!is_numeric($new_user_name)){ // if the username is not a number
                    if(strlen($new_user_name) <= 15){
                        $check_user_query = "SELECT user_name
                                                FROM users
                                                WHERE user_name = '$new_user_name'";
                        $check = mysqli_query($con, $check_user_query);
                            
                        if(mysqli_num_rows($check) === 0){ //? check if there is already a username with that name
                            if (strlen($new_password) >= 8 && strlen($new_password) <= 12){
                                if ($rep_password === $new_password){
                                    $query = "UPDATE users
                                        SET password = '$new_password', user_name = '$new_user_name'
                                        WHERE user_name = '$current_user_name'";
                                    $update = mysqli_query($con, $query);
                                    $_SESSION['user_name'] = $new_user_name;
                                    header("Location: edit.php?message=updated-data");
                                } else { //? the password entered in the fields are different
                                    header("Location: edit.php?message=different-passwords");
                                }
                            } else { //? password too long or too short
                                header("Location: edit.php?message=password-length-not-valid");
                            }
                        } else {
                            header("Location: edit.php?message=username-found");
                        }
                    } else { //? username too long
                        header("Location: edit.php?message=username-too-long");
                    }
                } else { //? the username is a number
                    header("Location: edit.php?message=numeric-username");
                }
            } else { //? no values entered
                header("Location: edit.php?message=missing-data");
            }
        }
?>
		<link rel="stylesheet" href="../css/style.css">
        <title>Login App - Edit account</title>
	</head>
    <body>
	<?php include "../html/admin-navbar.html";?>
		<div class="page">
            <h3 class="slogan"><?php echo $user_data['user_name'];?>, edit your account informations now !</h3>
            <form class="form updating-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <?php if(isset($_GET['message'])){ /*displaying the messages*/?>
                    <div class="message alert alert-danger" role="alert">
                        <?php echo print_message($_GET['message']); ?>
                    </div>
                <?php } ?>
                <label for="new-username">New username: </label>
                <input id ="new-username" class="input" type="text" name="new-username" placeholder="<?php echo $user_data['user_name'];?>" autofocus><br>
                <label for="new-psw">New password: </label>
                <input id ="new-psw" class="input" type="password" name="new-password" placeholder="Set a new password"><br>
                <label for="rep-psw">Repeat password: </label>
                <input id ="rep-psw" class="input" type="password" name="rep-password" placeholder="Repeat your password"><br><br>
                <input class="btn btn-primary button" type="submit" value="Update"><br>
            </form>
		</div>
		
		<?php include "../html/footer.html";?>
    </body>
</html>