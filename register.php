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
	<script src="https://www.google.com/recaptcha/api.js"></script>

</head>
<body>
    
	<?php
		if(isset($_SESSION['err_server']))
		{
			echo '<div id="top-warning">'.$_SESSION['err_server'].'</div>';
			unset($_SESSION['err_server']);
		}
	?>
	
    <div id="container">
        <div id="mid-window">
            <div id="welcome-text">Register now!</div>
			<form action="registration_check.php" method="post">
			
				<input name="login" type="text" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'"
					<?php
						if(isset($_SESSION['login_return']))
						{
							echo 'value="'.$_SESSION['login_return'].'"';
							unset($_SESSION['login_return']);
						}
					?>
				/>
				<?php
					if(isset($_SESSION['err_login']))
					{
						echo '<span class="error-text">'.$_SESSION['err_login'].'</span>';
						unset($_SESSION['err_login']);
					}
				?>
				
				<input name="email" type="email" placeholder="e-mail" onfocus="this.placeholder=''" onblur="this.placeholder='e-mail'"
					<?php
						if(isset($_SESSION['email_return']))
						{
							echo 'value="'.$_SESSION['email_return'].'"';
							unset($_SESSION['email_return']);
						}
					?>
				/>
				<?php
					if(isset($_SESSION['err_email']))
					{
						echo '<span class="error-text">'.$_SESSION['err_email']."</span>";
						unset($_SESSION['err_email']);
					}
				?>
				
				<input name="password" type="password" placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'"/>
				<?php
					if(isset($_SESSION['err_password']))
					{
						echo '<span class="error-text">'.$_SESSION['err_password']."</span>";
						unset($_SESSION['err_password']);
					}
				?>
				
				<input name="password_repeat" type="password" placeholder="repeat password" onfocus="this.placeholder=''" onblur="this.placeholder='repaet password'"/>
				<?php
					if(isset($_SESSION['err_password_repeat']))
					{
						echo '<span class="error-text">'.$_SESSION['err_password_repeat']."</span>";
						unset($_SESSION['err_password_repeat']);
					}
				?>
				
				<label>
					<input type="checkbox" name="tos"/> Accept Terms of Service
				</label>
				<?php
					if(isset($_SESSION['err_tos']))
					{
						echo '<span class="error-text">'.$_SESSION['err_tos']."</span>";
						unset($_SESSION['err_tos']);
					}
				?>
				
				<div class="g-recaptcha" data-sitekey="6LdKg7oiAAAAAEhusRGYpdwo9RKa-VIT5cTt_t0w"></div>
				<?php
					if(isset($_SESSION['err_recaptcha']))
					{
						echo '<span class="error-text">'.$_SESSION['err_recaptcha']."</span>";
						unset($_SESSION['err_recaptcha']);
					}
				?>
				
				<input type="submit" value="Register"/>
			</form>
			<div id="register">
				<a href="index.php">Back</a>
			</div>
    </div>
</body>
</html>