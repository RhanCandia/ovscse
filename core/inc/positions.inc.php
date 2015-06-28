<?php

// gets all positions available in a given ballot.
function get_positions($bid) {
    $bid = (int) $bid;
    
    $sql = "SELECT
                `position_name`
            FROM 
                `positions`
            WHERE
                `ballot_id` = '{$bid}'";
    
    $query = mysql_query($sql);
    $positions = array();
    while ($row = mysql_fetch_assoc($query)) {
        $positions[] = $row['position_name'];
    }
    
    return $positions;
}

// adds a position to a given ballot.
function add_position($bid, $positions) {
    rem_position($bid);
    foreach($positions as $key => $values) {
        if (!empty($values) && $values !== " ") {
            mysql_query("INSERT INTO `online_elections`.`positions` (`ballot_id`, `position_name`, `position_rank`) VALUES ('{$bid}', '{$values}', '{$key}')");
        }
    }
}

// removes a position from a given ballot.
function rem_position($bid) {
    $bid = (int) $bid;
    mysql_query("DELETE FROM `online_elections`.`positions` WHERE `ballot_id` = '{$bid}'");
}

?>