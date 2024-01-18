<?php
	session_start();
	if(!isset($_SESSION['user_id'])) 
	{
		header('Location: index.php');
		exit();
	}

try
{
	require_once "php/DbConnection.php";
	$db_connection = new DbConnection();

	require "php/password_generate.php";
	
	$table_name = "passwords_".$_SESSION['user_login'];
	$pass_data = [];

	if($db_result = $db_connection->query("SELECT id, name FROM $table_name"))
	{
		for($i = $db_result->rowCount(); $i > 0; $i--)
		{
			$db_single_result = $db_result->fetch(PDO::FETCH_NUM);
			$pass_data[] = [$db_single_result[1], $db_single_result[0]];
		}
	}
}
catch(Exception $db_error)
{
	echo $db_error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Generate your passwords!</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="css/main-manager.css"/>
	<link rel="stylesheet" type="text/css" href="css/fontello.css"/>
	<link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet"/>
	<script src="js/managerTemp.js" async=defer></script>
</head>
<body>
	<div id="topbar">
		<div id="top-logo">Mose Password Manager</div>
		<div id="logout-button"><a href="logout.php">Logout</a></div><div style="clear: both;"></div>
	</div>
	<div id="main-content-box">

		<?php foreach($pass_data as $pass_values):?>
		<div class="site-box">
			<div class="site-box-tile">
				<div class="site-box-name">
					<div id="site-box-name-'.$pass_name.'"><?=$pass_values[0]?></div>
					<div id="hidden-password-for-<?=$pass_values[0]?>"><?=htmlentities(generate_pass($pass_values[1], $_SESSION['user_login'], $_SESSION['user_password'], $pass_values[0]))?></div>
				</div>
				<div class="site-box-menu">
					<div class="site-box-button"><i title="Show password" onclick="openPasswordWindow('<?=$pass_values[0]?>')"><i class="icon-show"></i></i></div>
					<div class="site-box-button"><i title="Copy password to clpiboard" onclick="copyFromSiteTile('<?=$pass_values[0]?>')"><i class="icon-copy"></i></i></div>
					<div class="site-box-button"><a href="menu_options.php?delete_password=<?=$pass_values[0]?>" title="Delete password!"><i class="icon-delete"></i></a></div>
					<div class="site-box-button"><i title="Edit password"><i class="icon-edit"></i></i></div>
					<div style="clear: both;"></div>
				</div>
			</div>
		</div>
		<?php endforeach;?>

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
	<div id="show-password-container">
		<div id="show-box">
			<div id="show-box-exit" onclick="closePasswordWindow()"><i class="icon-exit"></i></div>
			<div id="show-box-header">
				Your password for <div id="show-box-name">Fb:</div>
			</div>
			<div id="show-box-bottom">
				<div id="show-box-copy" onclick="copyFromShowBox()" title="Copy password"><i class="icon-copy"></i></div>
				<div id="show-box-password"></div>
			</div>
		</div>
	</div>

</body>
</html>