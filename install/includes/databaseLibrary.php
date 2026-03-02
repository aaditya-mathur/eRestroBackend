<?php
class Database {

	function create_database($data)
	{
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');
		if(mysqli_connect_errno())
			return false;
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);
		$mysqli->close();
		return true;
	}

	function create_tables($data)
	{
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);
		if(mysqli_connect_errno())
			return false;
		$query = file_get_contents('assets/sqlcommand.sql');
		$mysqli->multi_query($query);
		$mysqli->close();
		return true;
	}

	function create_admin($data)
	{
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);
		if(mysqli_connect_errno())
			return false;
	
		$password = $data['admin_password']; 
		$admin_email = $data['admin_email']; 
		$mobile = $data['admin_mobile'];

		$params = [
			'cost' => 12
		];

		if (empty($password) || strpos($password, "\0") !== FALSE || strlen($password) > 32)
		{
			return FALSE;
		}else{
			$password = password_hash($password, PASSWORD_BCRYPT, $params);
        }
        
        // Check if user ID 1 exists
        $res = $mysqli->query("SELECT id FROM users WHERE id=1");
        
        if($res \u0026\u0026 $res-\u003enum_rows \u003e 0) {
            // Update existing user
            $set = " `password`='".$password."', `mobile`='".$mobile."' ";
            if(isset($data['admin_email'])){
                $set .= ", `email`='".$data['admin_email']."' ";
            }        
            $mysqli->query("UPDATE users SET ".$set."  WHERE `id`=1 ");
        } else {
            // Create user ID 1
            $mysqli->query("INSERT INTO users (id, password, mobile, email, active) VALUES (1, '".$password."', '".$mobile."', '".$admin_email."', 1)");
            // Ensure they are in the admin group (Group ID 1)
            $mysqli->query("INSERT INTO users_groups (user_id, group_id) VALUES (1, 1)");
        }
        
		$mysqli->close();
		return true;
	}

	
}
