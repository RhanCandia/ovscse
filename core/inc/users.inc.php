<?php

function user_exists($sid) {
    $sid = mysql_real_escape_string($sid);
    $total = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `student_id` = '{$sid}'");
    $total = mysql_result($total, 0);
    
    if ($total != 1) {
        return false;
    } else {
        return true;
    }
}

function valid_credentials($sid, $pass) {
    $sid    =   mysql_real_escape_string(htmlentities($sid));
    $pass	=	base64_encode($pass . "salt");
    
    $total = mysql_query("SELECT COUNT(`student_id`) FROM `users` WHERE `student_id` = '{$sid}' AND `password` = '{$pass}'");
    $total = mysql_result($total, 0);
    
    if ($total != 1) {
        return false;
    } else {
        return true;
    }
    
}

function admin_passChange($sid, $newPass) {

	$sid	 = mysql_real_escape_string($sid);
	$newPass = mysql_real_escape_string($newPass);
	
	$encPass = base64_encode($newPass . "salt");
	
	if (mysql_query("UPDATE `users` SET `password` = '{$encPass}' WHERE `student_id` = '{$sid}'")) {
		return true;
	} else {
		return false;
	}
	
	
}

function rand_pass($lenght) {
	
	$charset = array_merge(range('A', 'Z'), range(0, 9));
	shuffle($charset);
	$word = array_slice($charset, 0, $lenght);
	$pass = implode('', $word);
	$enc = base64_encode($pass . "salt");
	
	return $enc;
}

function add_user($sid, $lname, $fname, $department) {
	$sid = mysql_real_escape_string($sid);
	$lname = ucwords(strtolower(mysql_real_escape_string($lname)));
	$fname = ucwords(strtolower(mysql_real_escape_string($fname)));
	$pass = rand_pass(8);
	
	$sql = "INSERT INTO
				`users`
			(
				`user_group`,
				`student_id`,
				`password`,
				`lname`,
				`fname`,
				`department`
			)
			VALUES
			(
				'user',
				'{$sid}',
				'{$pass}',
				'{$lname}',
				'{$fname}',
				'{$department}'
			)";
	if (mysql_query($sql)) {
		return true;
	} else {
		return mysql_error();
	}
}

function get_userGroup($sid) {
	$sid = mysql_real_escape_string($sid);
	
	$userGroup = mysql_query("SELECT * FROM `users` WHERE `student_id` = '{$sid}'");
	$userGroup = mysql_fetch_assoc($userGroup);
	$return = $userGroup['user_group'];
	
	return $return;
}

function get_userDept($sid) {
	$sid = mysql_real_escape_string($sid);
	
	$userDept = mysql_query("SELECT * FROM `users` WHERE `student_id` = '{$sid}'");
	$userDept = mysql_fetch_assoc($userDept);
	$return = $userDept['department'];
	
	return $return;
}

function get_userName($sid) {
	$sid = mysql_real_escape_string($sid);

	$userName = mysql_query("SELECT * FROM `users` WHERE `student_id` = '{$sid}'");
	$userName = mysql_fetch_assoc($userName);
	$return = $userName['fname'];
	
	return $return;
}

function list_users($dept) {
	$dept	=	mysql_real_escape_string($dept);
	
	$sql	=  "SELECT
					`student_id`	AS	`id`,
					`lname`			AS	`lastname`,
					`fname`			AS	`firstname`,
					`password`		AS	`password`
				FROM
					`users`
				WHERE
					`department`	=	'{$dept}'
				ORDER BY
					`lname`";
					
	$users	=	mysql_query($sql);
	$rows	=	array();
	
	while (($row = mysql_fetch_assoc($users)) !== false) {
		$rows[] = array(
			'id'			=>	$row['id'],
			'lastname'		=>	$row['lastname'],
			'firstname'		=>	$row['firstname'],
			'password'		=>	$row['password']
		);
	}
	
	return $rows;
}

function get_yearLevel($sid) {
	$sid = mysql_real_escape_string($sid);

	$yearLevel = mysql_query("SELECT * FROM `users` WHERE `student_id` = '{$sid}'");
	$yearLevel = mysql_fetch_assoc($yearLevel);
	$return = $yearLevel['year_level'];
	
	return $return;
}

function find_user($sid) {
	
	$sid		=		mysql_real_escape_string($sid);

	$query		=		"SELECT
							`student_id`	AS	`id`,
							`lname`			AS	`lastname`,
							`fname`			AS	`firstname`,
							`password`		AS	`password`,
							`department`	AS	`department`
						FROM
							`users`
						WHERE
							`student_id`	=	'{$sid}'";

	$searched	=		mysql_query($query);
	$searched	=		mysql_fetch_assoc($searched);

	$student = array(
		'id'			=>	$searched['id'],
		'lastname'		=>	$searched['lastname'],
		'firstname'		=>	$searched['firstname'],
		'password'		=>	substr(base64_decode($searched['password']), 0, -4),
		'department'	=>	$searched['department']
	);

	return $student;

}

?>