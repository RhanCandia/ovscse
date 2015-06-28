<?php
	
function get_colleges() {
	
	$sql = "SELECT
				`college_id` AS `cid`,
				`college_code` AS `ccode`,
				`college_name` AS `cname`
			FROM
				`colleges`";
	
	$colleges = mysql_query($sql);
	
	$return = array();
	
	while (($row = mysql_fetch_assoc($colleges)) !== false) {
		$return[] = array(
			'cid'		=>	$row['cid'],
			'ccode'		=>	$row['ccode'],
			'cname'		=>	$row['cname']
		);
	}
	
	return $return;
	
}

function get_collegeName($cid) {
	$cid = mysql_real_escape_string($cid);

	$collegeName = mysql_query("SELECT * FROM `colleges` WHERE `college_code` = '{$cid}'");
	$collegeName = mysql_fetch_assoc($collegeName);
	$return = $collegeName['college_name'];
	
	return $return;
}
	
?>