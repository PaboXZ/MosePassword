<?php
	session_start();
	if(isset($_SESSION['user_id'])) 
	{
		header('Location: manager.php');
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mose Password Manager</title>
    <meta charset="utf-8">
    <meta name="keywords" content="password manager, security, passwords">
    <meta name="description" content="Easy to use password manager."/>
    <link rel="stylesheet" href="css/index.css" type="text/css"/>
	<link rel="stylesheet" href="css/register.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
	<script src="js/register.js" defer></script>

</head>
<body>
    <div id="container">
        <div id="mid-window">
            <div id="welcome-text">Register now!</div>
			<form id="register-form" action="php/registration.php" method="POST">

				<input name="login" type="text" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'"/>
				<input name="email" type="email" placeholder="e-mail" onfocus="this.placeholder=''" onblur="this.placeholder='e-mail'"/>
				<input name="password" type="password" placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'"/>
				<input name="password_repeat" type="password" placeholder="repeat password" onfocus="this.placeholder=''" onblur="this.placeholder='repaet password'"/>
				<label><input type="checkbox" name="tos"/>Accept Terms of Service</label>
				<button type="button">Register</button>
			</form>
			<div id="register">
				<a href="index.php">Back</a>
			</div>
    </div>
</body>
</html>