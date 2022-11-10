<?php
	session_start();
	if(!isset($_SESSION['user_id'])) 
	{
		header('Location: index.php');
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Generate your passwords!</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="main-manager.css"/>
	<link rel="stylesheet" type="text/css" href="css/fontello.css"/>
	<link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet"/>
</head>
<body>
	<div id="topbar">
		<div id="top-logo">Mose Password Manager</div>
		<div id="logout-button"><a href="logout.php">Logout</a></div><div style="clear: both;"></div>
	</div>
	<div id="main-content-box">
		<?php
			try
			{
				require_once "dbconnect.php";
				$db_connection = new mysqli($host, $db_user, $db_password, $db_name);
				require "password_generate.php";
				
				
				$table_name = "passwords_".$_SESSION['user_login'];
				if($db_result = $db_connection->query("SELECT id, name FROM $table_name"))
				{
					for($i = $db_result->num_rows, $j = 3; $i > 0; $i--, $j--)
					{
						$db_single_result = $db_result->fetch_row();
						$pass_name = $db_single_result[1];
						$pass_id = $db_single_result[0];
							echo 
								'<div class="site-box">
								
									<div class="site-box-tile">
										<div class="site-box-name">
											'.$pass_name.'<br>
											'.htmlentities(generate_pass($pass_id, $_SESSION['user_login'], $_SESSION['user_password'], $pass_name)).'
										</div>
										<div class="site-box-menu">
											<div class="site-box-button"><a href="" title="Show password"><i class="icon-show"></i></a></div>
											<div class="site-box-button"><a href="" title="Copy password to clpiboard"><i class="icon-copy"></i></a></div>
											<div class="site-box-button"><a href="menu_options.php?delete_password='.$pass_name.'" title="Delete password!"><i class="icon-delete"></i></a></div>
											<div class="site-box-button"><a href="" title="Edit password"><i class="icon-edit"></i></a></div>
											<div style="clear: both;"></div>
										</div>
									</div>
								</div>';
								
							if(!$j || $i == 1)
							{
								$j = 4;
								echo '<div style="clear: both"></div>';
							}	
					}
				}
				$db_result->close();
				$db_connection->close();
			}
			catch(Exception $db_error)
			{
				echo $db_error;
			}
		?>
		<div id="insert-form">
			<div id="insert-form-header">Create new password!</div>
			<form action="insert_password.php" method="post">
				<input type="text" name="pass_name" placeholder="password name" onfocus="this.placeholder=''" onblur="this.placeholder='password name'"/>
				<input type="submit" value="Create"/>	
			</form>
			<?php
				if(isset($_SESSION['err_manager_insert']))
				{
					echo '<span style="color: red">'.$_SESSION['err_manager_insert'].'</span>';
					unset($_SESSION['err_manager_insert']);
				}
			?>
		</div>
	</div>
	<div id="show-function-container">
		<div id="show-box">
			<div id="show-box-exit" onclick="document.getElementById('show-function-container').style.cssText='display: none;'"><i class="icon-exit"></i></div>
			<div id="show-box-header">
				Your password for <div id="show-box-name">Fb:</div>
			</div>
			<div id="show-box-bottom">
				<div id="show-box-copy"><i class="icon-copy"></i></div>
				<div id="show-box-password">qhbfdssdheh</div>
			</div>
		</div>
	</div>

</body>
</html>