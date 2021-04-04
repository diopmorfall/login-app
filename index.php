<!-- This is the index page after the login -->
<?php
	session_start();

	include "html/header.html";
	include "connection.php";
    include "functions.php";

    $user_data = check_login($con);
	
?>
        <title>ToDo Manager</title>
	</head>
    <body>
	<?php include "html/profile-navbar.html";?>
		<div class="page">
			<h4>Welcome back, <?php echo $user_data['user_name'];?> !</h4><br>
			<h5>This is your profile page!</h5>

		</div>
		
		<?php include "html/footer.html";?>
    </body>
</html>