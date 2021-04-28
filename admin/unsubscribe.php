<?php
	session_start();

	include "../html/admin-header.html";
	include "../function/connection.php";
    include "../function/functions.php";

	$user_data = check_login($con);
	$user_name = $user_data['user_name'];
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		try{
			$query = $con->prepare("DELETE FROM users WHERE user_name = :user_name");
			$query->execute(['user_name'=>$user_name]);
			unset($_SESSION['user_name']);
			header("Location: ../login.php?message=unsubscribed");
		} catch(PDOException $error){
			echo "Error in unsubscribing: " . $error->getMessage();
		}
	}
	
?>
		<link rel="stylesheet" href="../css/style.css">
        <title>Login App - Unsubscribe Page</title>
	</head>
    <body>
	<?php include "../html/admin-navbar.html";?>
		<div class="page">
			<br>
            <h4><?php echo $user_data['user_name'];?>, are you sure to unsubscribe ?</h4>
            <br><br>
			<form class="delete" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
				<button class="btn btn-primary button" type="submit" value="Delete">Unsubscribe</button>
				<a class="btn btn-primary button cancel" href="index.php" role="button">Cancel</a>
            </form>
		</div>
		
		<?php include "../html/footer.html";?>
    </body>
</html>