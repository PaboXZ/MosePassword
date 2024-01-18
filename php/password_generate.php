<?php

function generate_pass($password_id, $user_name, $user_password, $password_name)
{
	while(strlen(($password_id)) < 20)
	{
		$password_id = $password_id.$password_id;
	}	
	while(strlen(($user_name)) < 20)
	{
		$user_name = $user_name.$user_name;
	}	
	while(strlen(($user_password)) < 20)
	{
		$user_password = $user_password.$user_password;
	}	
	while(strlen(($password_name)) < 20)
	{
		$password_name = $password_name.$password_name;
	}
	for($i = 0, $password_result = ''; $i < 20; $i++)
	{
		$password_result = $password_result . chr(((ord($password_id[$i]) * ord($user_name[$i]) * ord($user_password[$i]) * ord($password_name[$i])) % 89) + 33);
	}
	return $password_result;
}

?>