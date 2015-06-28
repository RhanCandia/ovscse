<?php

// cheks if the given ballot id is in the table.
function valid_bid($bid) {
    $bid = (int) $bid;
    
    $total = mysql_query("SELECT COUNT(`ballot_id`) FROM `ballots` WHERE `ballot_id` = '{$bid}'");
    $total = mysql_result($total, 0);
    
    if ($total != 1) {
        return false;
    } else {
        return true;
    }
}

function get_over_ballots() {
    $sql = "SELECT
                `ballots`.`ballot_id` AS `id`,
                `ballots`.`ballot_name` AS `title`,
                `ballots`.`ballot_desc` AS `description`,
                `ballot_dept` AS `department`
            FROM `ballots`
            WHERE `isOver` = 1";
    
    $ballots = mysql_query($sql);
    
    $rows = array();
    while(($row = mysql_fetch_assoc($ballots)) !== false) {
        $rows[] = array(
            'id'            => $row['id'],
            'title'         => $row['title'],
            'description'   => $row['description'],
            'department'	=> $row['department']
        );
    }
    
    return $rows;
}

function get_ballot_name($bid) {
	$bid = (int) $bid;
	
	$name = mysql_query("SELECT * FROM `ballots` WHERE `ballot_id` = '{$bid}'");
	$name = mysql_fetch_assoc($name);
	$return = $name['ballot_name'];
	
	return $return;
}

// fetches all the active ballots.
function get_active_ballots() {
    $sql = "SELECT
                `ballots`.`ballot_id` AS `id`,
                `ballots`.`ballot_name` AS `title`,
                `ballots`.`ballot_desc` AS `description`,
                `ballot_dept` AS `department`,
                `isOver` AS `status`
            FROM `ballots`
            WHERE `active` = 1";
    
    $ballots = mysql_query($sql);
    
    $rows = array();
    while(($row = mysql_fetch_assoc($ballots)) !== false) {
        $rows[] = array(
            'id'            => $row['id'],
            'title'         => $row['title'],
            'description'   => $row['description'],
            'department'	=> $row['department'],
            'status'		=> $row['status']
        );
    }
    
    return $rows;
}

// fetches all the queue ballots.
function get_queue_ballots() {
    $sql = "SELECT
                `ballots`.`ballot_id` AS `id`,
                `ballots`.`ballot_name` AS `title`,
                `ballots`.`ballot_desc` AS `description`
            FROM `ballots`
            WHERE `queue` = 1";
    
    $ballots = mysql_query($sql);
    
    $rows = array();
    while(($row = mysql_fetch_assoc($ballots)) !== false) {
        $rows[] = array(
            'id'            => $row['id'],
            'title'         => $row['title'],
            'description'   => $row['description']
        );
    }
    
    return $rows;
}

// fetches all the archive ballots.
function get_archive_ballots() {
    $sql = "SELECT
                `ballots`.`ballot_id` AS `id`,
                `ballots`.`ballot_name` AS `title`,
                `ballots`.`ballot_desc` AS `description`
            FROM `ballots`
            WHERE `archive` = 1 ORDER BY `ballot_id` DESC";
    
    $ballots = mysql_query($sql);
    
    $rows = array();
    while(($row = mysql_fetch_assoc($ballots)) !== false) {
        $rows[] = array(
            'id'            => $row['id'],
            'title'         => $row['title'],
            'description'   => $row['description']
        );
    }
    
    return $rows;
}

// fetches an specific ballot.
function get_ballot($bid) {
    $bid = (int) $bid;
    
    $sql = "SELECT
                `ballot_name` AS `title`,
                `ballot_desc` AS `description`,
                `active`,
                `queue`,
                `archive`                
            FROM `ballots`
            WHERE `ballot_id` = '{$bid}'";
            
    $ballot = mysql_query($sql);
    $ballot = mysql_fetch_assoc($ballot);
    return $ballot;
}

// adds a ballot.
function add_ballot($ballot_name, $department, $ballot_desc) {
    $ballot_name = mysql_real_escape_string(htmlentities($ballot_name));
    $ballot_desc = mysql_real_escape_string($ballot_desc);
    
    mysql_query("INSERT INTO `ballots` (`ballot_name`, `ballot_dept`, `ballot_desc`) VALUES ('{$ballot_name}', '{$department}', '{$ballot_desc}')");
}

// activates a ballot.
function ballot_action($bid, $action) {
    $bid    = (int) $bid;
    $action = (int) $action;
    
    $sql = "";
    
    // will activate a queue.
    if ($action === 0) {
        $sql = "UPDATE  `online_elections`.`ballots`
                SET     `active`    = '0',
                        `queue`     = '1',
                        `archive`   = '0'
                WHERE   `ballots`.`ballot_id` = '{$bid}'";
    }
    // will activate a ballot.
    if ($action === 1) {
        $sql = "UPDATE  `online_elections`.`ballots`
                SET     `active`    = '1',
                        `queue`     = '0',
                        `archive`   = '0'
                WHERE   `ballots`.`ballot_id` = '{$bid}'";
    }
    // will archive a ballot.
    if ($action === 2) {
        $sql = "UPDATE  `online_elections`.`ballots`
                SET     `active`    = '0',
                        `queue`     = '0',
                        `archive`   = '1'
                WHERE   `ballots`.`ballot_id` = '{$bid}'";
    }
    // will delete a ballot.
    if ($action === 3) {
        $sql = "DELETE FROM
                    `online_elections`.`ballots`
                WHERE
                    `ballots`.`ballot_id` = '{$bid}'";
    }
    
    mysql_query($sql);
}

function get_status($bid) {
	$bid = (int) $bid;
	$status = mysql_query("SELECT * FROM `ballots` WHERE `ballot_id` = '{$bid}'");
	$status = mysql_fetch_assoc($status);
	
	return $status['isOver'];
}

function end_ballot($bid) {

    $sql = "UPDATE  `online_elections`.`ballots`
            SET     `isOver`    = '1'
            WHERE   `ballots`.`ballot_id` = '{$bid}'";
                
    mysql_query($sql);
}

function start_ballot($bid) {

    $sql = "UPDATE  `online_elections`.`ballots`
            SET     `isOver`    = '0'
            WHERE   `ballots`.`ballot_id` = '{$bid}'";
                
    mysql_query($sql);
}

function add_voter($sid, $bid) {
    
    $sid = mysql_real_escape_string($sid);
    $bid = mysql_real_escape_string($bid);
    
    mysql_query("UPDATE `ballots` SET `voters` = TRIM('|' FROM IFNULL(CONCAT_WS('|', `voters`, '{$sid}'), '{$sid}')) WHERE `ballot_id` = {$bid}");
    
}

function get_voters($bid) {
	
	$bid = (int) $bid;
	
	$sql = "SELECT
				`voters` AS `voters_string`
			FROM
				`ballots`
			WHERE
				`ballot_id` = {$bid}";
	
	$voters = mysql_query($sql);
	$voters = mysql_fetch_assoc($voters);
	$voters = $voters['voters_string'];
	
	$voters_array = array();
	$voters_array = explode('|', $voters);
	
	return  $voters_array;
	
}

function get_ballotDept($bid) {
	$bid = mysql_real_escape_string($bid);
	
	$ballotDept = mysql_query("SELECT * FROM `ballots` WHERE `ballot_id` = '{$bid}'");
	$ballotDept = mysql_fetch_assoc($ballotDept);
	$return = $ballotDept['ballot_dept'];
	
	return $return;
}

function isActive($bid) {
    $bid = (int) $bid;

    $isActive = mysql_query("SELECT * FROM `ballots` WHERE `ballot_id` = '{$bid}'");
    $isActive = mysql_fetch_assoc($isActive);
    $isActive = $isActive['active'];

    return $isActive;
}  

?>