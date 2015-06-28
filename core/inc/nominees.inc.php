<?php

// fetches all nominees for a given ballot.
function get_nominees($bid, $pid) {
    $bid = (int) $bid;
    $pid = (int) $pid;
    
    $sql = "SELECT
                `nominee_id` AS `n_id`,
                `position_id` AS `n_pos`,
                `nominee_name` AS `n_name`,
                `nominee_party` AS `n_party`,
                `nominee_about` AS `n_about`,
                `received_votes` AS `votes`
            FROM `nominees`
            WHERE `ballot_id` = {$bid} AND `position_id` = {$pid}";
            
    $nominees = mysql_query($sql);
    
    $return = array();
    echo mysql_error();
    while (($row = mysql_fetch_assoc($nominees)) !== false) {
        $return[] = $row;
    }
    
    return $return;
}

function get_result($bid, $pid) {
    $bid = (int) $bid;
    $pid = (int) $pid;
    
    $sql = "SELECT
                `nominee_id` AS `n_id`,
                `position_id` AS `n_pos`,
                `nominee_name` AS `n_name`,
                `nominee_party` AS `n_party`,
                `nominee_about` AS `n_about`,
                `received_votes` AS `votes`
            FROM `nominees`
            WHERE `ballot_id` = {$bid} AND `position_id` = {$pid}
            ORDER BY `received_votes`
            DESC";
            
    $nominees = mysql_query($sql);
    
    $return = array();
    echo mysql_error();
    while (($row = mysql_fetch_assoc($nominees)) !== false) {
        $return[] = $row;
    }
    
    return $return;
}

// adds a nominee.
function add_nominee($bid, $pos_id, $name, $party, $about) {
    
    $bid        = (int) $bid;
    $pos_id     = (int) $pos_id;
    $name       = mysql_real_escape_string($name);
    $party      = mysql_real_escape_string($party);
    $about      = mysql_real_escape_string(nl2br(htmlentities($about)));
    
    mysql_query("INSERT INTO `online_elections`.`nominees` (`ballot_id`, `position_id`, `nominee_name`, `nominee_party`, `nominee_about`) VALUES ({$bid}, {$pos_id}, '{$name}', '{$party}', '{$about}')");
}

// deletes / removes a nominee.
function del_nominee($bid, $nid) {
    $bid = (int) $bid;
    $nid = (int) $nid;
    
    mysql_query("DELETE FROM `online_elections`.`nominees` WHERE `nominees`.`ballot_id` = '{$bid}' AND `nominees`.`nominee_id` = '{$nid}'");
}

function get_nominee($nom_id) {
    $nom_id = (int) $nom_id;
    
    $sql = "SELECT
                `nominee_id` AS `n_id`,
                `position_id` AS `n_pos`,
                `nominee_name` AS `n_name`,
                `nominee_party` AS `n_party`,
                `nominee_about` AS `n_about`
            FROM `nominees`
            WHERE `nominee_id` = {$nom_id}";
            
    $nominee = mysql_query($sql);
    
    $return = mysql_fetch_assoc($nominee);
    
    return $return;
}

function cast_vote($n_id) {
    $n_id = (int) $n_id;
    mysql_query("UPDATE `nominees` SET `received_votes` = `received_votes` + 1 WHERE `nominee_id` = {$n_id}");
}

?>