<!-- This is the index page after the login -->
<?php
	session_start();

	include "../html/admin-header.html";
	include "../function/connection.php";
    include "../function/functions.php";

	$user_data = check_login($con);
	
	$timestamp = strtotime($user_data['date']);
	$date = date("l jS \of F Y", $timestamp);
	$time = date("H:i:s", $timestamp);
	
?>
		<link rel="stylesheet" href="../css/style.css">
        <title>Login App - Account Page</title>
	</head>
    <body>
	<?php include "../html/admin-navbar.html";?>
		<div class="page">
			<br>
			<h4>Welcome back, <?php echo $user_data['user_name'];?> !</h4><br>
			<h5>This is your profile page!</h5>
			<br>
			<h6>You're a member since <?php echo $date . " at " . $time;?></h6>
		</div>
		
		<?php include "../html/footer.html";?>
    </body>
</html>