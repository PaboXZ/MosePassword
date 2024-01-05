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
    <meta name="description" content="Project password manager"/>

    <meta name="viewport" content="width=device-width initial-scale=1.0"/>

    <link rel="stylesheet" href="css/index.css" type="text/css"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

    <script src="js/index.js" async="defer"></script>
</head>
<body>
    <div id="top-warning">Alpha version</div> 
    <main>
        <div id="container">
            <div id="mid-window">
                <div id="welcome-text">Welcome to</div>
                <div id="logo-text">Mose Password Manager</div>
                <form id="login-form" action="login.php" method="POST">
                    <input name="login" type="text" placeholder="login" required onfocus="this.placeholder=''" onblur="this.placeholder='login'">
                    <input name="password" type="password" placeholder="password" required onfocus="this.placeholder=''" onblur="this.placeholder='password'">
                    <button type="button">Login</button>
                </form>
                <div id="register">
                    <a href="register.php">Register</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>