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
    <link rel="stylesheet" href="main.css" type="text/css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div id="top-warning">Alpha version</div> 
    <div id="container">
        <div id="mid-window">
            <div id="welcome-text">Welcome to</div>
            <div id="logo-text">Mose Password Manager</div>
			<form action="login.php" method="post">
				<input name="login" type="text" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">
				<input name="password" type="password" placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'">
				<?php
					if(isset($_SESSION['error_dsc']))
					{
						echo '<div style="color: red; text-align: center; padding: 2px 0 0 0;">'.$_SESSION['error_dsc']."</div>";
						unset($_SESSION['error_dsc']);
					}
				?>
				<input type="submit" value="Login">
			</form>
			<div id="register">
				<a href="register.php">Register</a>
			</div>
    </div>
</body>
</html>